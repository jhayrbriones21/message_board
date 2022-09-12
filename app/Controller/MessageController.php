<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class MessageController extends AppController {
 
    // public $paginate = array(
    //     'limit' => 25,
    //     'conditions' => array('status' => '1'),
    //     'order' => array('User.username' => 'asc' ) 
    // );
    public $uses = array(
        'User',
        'Message',
        'Profile',
    );

    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User')){
            $this->redirect('/users/login');      
        }
        $this->Auth->allow('list','add','replyMessage'); 
    }
 
    public function list() {

        $messages = $this->Message->find('all', array('recursive' => 2));

        // print_r(json_encode($messages));

        $this->set(compact('messages'));
    }

    public function add()
    {
        //if already logged-in, redirect
        if(!$this->Session->check('Auth.User')){
            $this->redirect(array('action' => '/'));      
        }
         
        if ($this->request->is('post')) {

            print_r($this->request->data);
            $this->request->data['Message']['user_id'] = $this->Auth->user('id');
            if ($this->Message->save($this->request->data)) {
                $this->Session->setFlash(__('The message has been created'));
               $this->redirect(array('controller'=>'message', 'action' => 'list'));
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
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
            'recursive' => 2
            )
        );

        $this->set(compact('message'));
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
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }  
        }
    }
 
}