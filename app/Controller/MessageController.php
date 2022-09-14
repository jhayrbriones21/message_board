<?php 
App::uses('AppController', 'Controller');

class MessageController extends AppController {

    public $uses = array(
        'User',
        'Message',
        'Profile',
        'Reply',
        'Security'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        date_default_timezone_set('Asia/Manila');
        if(!$this->Session->check('Auth.User')){
            $this->redirect('/users/login');      
        }
        $this->Auth->allow('list','add','replyMessage'); 
    }
 
    public function list() {

        $messages = $this->Message->find('all', array('recursive' => 2));

        $this->set(compact('messages'));
    }

    public function add()
    {
        if(!$this->Session->check('Auth.User')){
            $this->redirect(array('action' => '/'));      
        }
         
        if ($this->request->is('post')) {

            $this->request->data['Message']['user_id'] = $this->Auth->user('id');
            if ($this->Message->save($this->request->data)) {
                $this->Flash->success(__('The message has been created'));
               $this->redirect(array('controller'=>'message', 'action' => 'list'));
            } else {
                $this->Flash->error(__('The user could not be created. Please, try again.'));
            }  
        } 

        $users = $this->User->find('all',
                                array(
                                     'fields' => array('User.id as value','name as text')
                                  ));


        $this->set(compact('users'));
    }

    public function detail($id)
    {
        $message = $this->Message->find('first',  array(
            'conditions' => array('Message.id' => $id),
            'recursive' => 3
            )
        );

        if(!$message){
            $this->Flash->error(__('The message was deleted!'));
            return $this->redirect($this->referer());
        }

        $user = AuthComponent::user();

        $this->set(compact('message','user'));
    }

    public function replyMessage()
    {
        if($this->request->is('post'))
        {
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

        if($this->request->is('post'))
        {
            $this->Message->read('id', $this->request->data['id']);
            $this->Message->saveField('description', $this->request->data['edit_message']);

            return json_encode($this->request->data);
        }
    }

    public function deleteMessage()
    {
        $this->response->type('application/json');  
        $this->autoRender = false; 

        if($this->request->is('post'))
        {
            $this->Message->delete(array('Message.id' => $this->request->data['id']));
            $this->Reply->deleteAll(array('Reply.message_id'=>$this->request->data['id']));

            return json_encode($this->request->data);
        }
    }

    public function searchMessage()
    {
        $this->response->type('application/json');  
        $this->autoRender = false;

        $search = $this->request->query['search'];

        $conditions = array('OR'=>array("Message.description LIKE '%$search%'","User.name LIKE '%$search%'","Recipient.name LIKE '%$search%'"));

        $searched_messages = $this->Message->find('all',array('conditions'=>$conditions));

        // $this->set(compact('searched_messages'));

        return json_encode($searched_messages);
    }
 
}