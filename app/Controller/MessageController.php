<?php

App::uses('AppController', 'Controller');

class MessageController extends AppController
{
    public $uses = [
        'User',
        'Message',
        'Profile',
        'Reply',
        'Security',
    ];

    public function beforeFilter()
    {
        parent::beforeFilter();
        date_default_timezone_set('Asia/Manila');
        if (!$this->Session->check('Auth.User')) {
            $this->redirect('/users/login');
        }
        $this->Auth->allow('list', 'add', 'replyMessage');
    }

    public function list()
    {
        $this->Message->virtualFields = array(
			'count' => "SELECT `COUNT(*)` FROM `replies` AS `Reply` 
						WHERE `Reply`.`message_id` = `Message`.`id`"
		);

        $messages = $this->Message->find('all',array(
                    'joins'=> array(
                        array(
                            'table' => 'users',
                            'alias' => 'User',
                            'type' => 'INNER',
                            'conditions' => array('User.id = Message.user_id')
                        ),
                        array(
                            'table' => 'profiles',
                            'alias' => 'Profile',
                            'type' => 'INNER',
                            'conditions' => array('Profile.user_id = User.id')
                        ),
                        array(
                            'table' => 'users',
                            'alias' => 'Recipient',
                            'type' => 'INNER',
                            'conditions' => array('Recipient.id = Message.recipient_id')
                        )
                    ),
                    'fields' => array(
                        'Message.id',
                        'Message.user_id',
                        'Message.description',
                        'Message.created',
                        'Profile.profile_pic_path',
                        'User.name',
                        'Recipient.name',
                        'Message.count'
                    )
                )
            );

        $this->set(compact('messages'));
    }

    public function add()
    {
        if (!$this->Session->check('Auth.User')) {
            $this->redirect(['action' => '/']);
        }

        if ($this->request->is('post')) {
            $this->request->data['Message']['user_id'] = $this->Auth->user('id');
            if ($this->Message->save($this->request->data)) {
                $this->Flash->success(__('The message has been created'));
                $this->redirect(['controller' => 'message', 'action' => 'list']);
            } else {
                $this->Flash->error(__('The user could not be created. Please, try again.'));
            }
        }

        $users = $this->User->find('all',
                                [
                                     'fields' => ['User.id as value', 'name as text'],
                                  ]);

        $this->set(compact('users'));
    }

    public function detail($id)
    {
        $message = $this->Message->find('first',array(
                'joins'=> array(
                    array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type' => 'INNER',
                        'conditions' => array('User.id = Message.user_id')
                    ),
                    array(
                        'table' => 'profiles',
                        'alias' => 'Profile',
                        'type' => 'INNER',
                        'conditions' => array('Profile.user_id = User.id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Recipient',
                        'type' => 'INNER',
                        'conditions' => array('Recipient.id = Message.recipient_id')
                    )
                ),
                'fields' => array(
                    'Message.id',
                    'Message.user_id',
                    'Message.description',
                    'Message.created',
                    'Profile.profile_pic_path',
                    'User.name',
                    'User.id',
                    'Recipient.name',
                ),
                'conditions' => array('Message.id'=>$id)
            )
        );

        if(empty($message))
        {
            throw new NotFoundException('Could not find that message');
        }

        $message['Reply'] = $this->Reply->find('all',array(
                                'joins' => array(
                                    array(
                                        'table' => 'users',
                                        'alias' => 'User',
                                        'type' => 'INNER',
                                        'conditions' => array('User.id = Reply.user_id')
                                    ),
                                    array(
                                        'table' => 'profiles',
                                        'alias' => 'Profile',
                                        'type' => 'INNER',
                                        'conditions' => array('Profile.user_id = User.id')
                                    )
                                ),
                                'conditions'=>array('Reply.message_id'=>$message['Message']['id']),
                                'fields'=>array(
                                    'Reply.id',
                                    'Reply.user_id',
                                    'Reply.created',
                                    'Reply.modified',
                                    'Reply.description',
                                    'Profile.profile_pic_path',
                                    'User.name',
                                    'User.id'
                                )
                            ));

                           

        if (!$message) {
            $this->Flash->error(__('The message was deleted!'));

            return $this->redirect($this->referer());
        }

        $user = $this->Profile->find('first',array('conditions'=>array('Profile.user_id'=>$this->Auth->user('id'))));

        $this->set(compact('message', 'user'));
    }

    public function replyMessage()
    {
        if ($this->request->is('post')) {
            $this->request->data['Reply']['description'] = $this->request->data['Reply']['reply_message'];
            $this->Reply->create();
            if ($this->Reply->save($this->request->data)) {
                return json_encode(true);
            } else {
                $this->Flash->error(__('The user could not be created. Please, try again.'));
            }
        }
    }

    public function editMessage()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $this->Message->read('id', $this->request->data['id']);
            $this->Message->saveField('description', $this->request->data['edit_message']);

            return json_encode($this->request->data);
        }
    }

    public function deleteMessage()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $this->Message->delete(['Message.id' => $this->request->data['id']]);
            $this->Reply->deleteAll(['Reply.message_id' => $this->request->data['id']]);

            return json_encode($this->request->data);
        }
    }

    public function searchMessage()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        $search = $this->request->query['search'];

        $conditions = ['OR' => ["Message.description LIKE '%$search%'", "User.name LIKE '%$search%'", "Recipient.name LIKE '%$search%'"]];

        $searched_messages = $this->Message->find('all', ['conditions' => $conditions]);

        return json_encode($searched_messages);
    }
}
