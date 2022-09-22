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
                    'Message.modified',
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
            $this->Flash->error(__('The message was deleted!'));
            return $this->redirect('/message/list');
            
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

        $searched_messages = $this->Message->find('all', array(
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array('User.id = Message.user_id')
                ),
                array(
                    'table' => 'users',
                    'alias' => 'Recipient',
                    'type' => 'INNER',
                    'conditions' => array('Recipient.id = Message.user_id')
                )
            ),
            'conditions' => $conditions
            )
        );

        return json_encode($searched_messages);
    }

    public function messagePrivate($id)
    {
        $user = $this->Profile->find('first',array(
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => 'Profile.user_id = User.id'
                )
            ),
            'fields' => array(
                'User.id',
                'User.name',
                'User.email',
                'Profile.profile_pic_path'
            ),
            'conditions'=>array('Profile.user_id'=>$id)
        ));

        $private_messages = $this->Message->find('all',array(
            'conditions' => array(
                'Message.user_id IN' => array($id,$this->Auth->user('id')),
                'Message.recipient_id IN' => array($id,$this->Auth->user('id')),
                'Message.is_private' => 1
            ),
            'order' => 'Message.created'
        ));

        $ids = array($id,$this->Auth->user('id'));
        uasort($ids, function($a, $b){
            if($a == $b)
                return 1;
            else
                return $b - $a;
        });

        $room = hash('sha1','private'.implode(":",$ids));

        $this->set(compact('user','private_messages','room'));
    }

    public function sendPrivateMessage()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        if($this->request->is('post'))
        {
            $this->Message->create();
            $this->Message->set(array(
                'recipient_id' => $this->request->data['recipient_id'],
                'description' => $this->request->data['description'],
                'user_id' => $this->Auth->user('id'),
                'is_private' => 1
            ));
            
            if($this->Message->save())
            {
                return json_encode($this->Message->find('first',array(
                    'conditions' => array('Message.id'=>$this->Message->id)
                )));
            }
        }
    }

    public function getUserLatestRecordMessage()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        $this->User->virtualFields = array(
			'message_id' => "SELECT `id` FROM `messages` AS `Message` 
						WHERE `Message.recipient_id` = `User.id` OR `Message.user_id`=`User.id` AND `Message.is_private` = 1 ORDER BY `Message.id DESC` LIMIT 1"
		);

        $usersss = $this->User->find('all',array(
            array(
                'SELECT `id` FROM `messages` AS `Message` WHERE `Message.id` = `User.message_id` LIMIT 1'
            ),
            // 'joins' => array(
                
            // ),
            'fields' => array(
                'User.id',
                'User.message_id',
                'Message.id',
            ),
            // 'conditions' => array('Message.id = User.message_id'),
            'order' => 'User.message_id DESC'
        ));

        pr($usersss);

        $this->Message->virtualFields = array(
			'message_id' => "SELECT `id` FROM `messages` AS `Message` 
						WHERE `Message.recipient_id` = `User.id` OR `Message.user_id`=`User.id` AND `Message.is_private` = 1 ORDER BY `Message.id DESC` LIMIT 1"
		);

        $user_list = $this->Message->find('all',array(
            'joins' => array(
                array(
                    'table' => 'messages',
                    'alias' => 'CurrentMessage',
                    'type' => 'LEFT',
                    'conditions' => array('CurrentMessage.id = Message.message_id')
                ),
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'RIGHT',
                    'conditions' => array('Message.user_id = User.id OR Message.recipient_id = User.id')
                ),
                array(
                    'table' => 'profiles',
                    'alias' => 'Profile',
                    'type' => 'INNER',
                    'conditions' => array('User.id = Profile.user_id')
                ),
            ),
            'fields' => array(
                'User.id',
                'User.name',
                'User.email',
                'Message.message_id',
                'Profile.profile_pic_path',
                'Message.created',
                'Message.description',
                'Message.id'
            ),
            'conditions' => array(
                'OR' => array('Message.user_id' => $this->Auth->user('id'),'Message.recipient_id' => $this->Auth->user('id'))
            ),
            'group' => 'User.id',
            'order' => 'Message.message_id DESC'
        ));

        return json_encode($user_list);
    }
}
