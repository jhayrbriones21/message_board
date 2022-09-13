<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $uses = array(
        'User',
        'Profile',
        'Security'
    );
 
    public $paginate = array(
        'limit' => 25,
        'conditions' => array('status' => '1'),
        'order' => array('User.username' => 'asc' ) 
    );
     
    public function beforeFilter() {
        parent::beforeFilter();
        date_default_timezone_set('Asia/Manila');
        $this->Auth->allow('login','register','checkEmailExist'); 
    }
     
    public function login() {
         
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect('/users/profile');      
        }
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {

                date_default_timezone_set('Asia/Manila');

                $this->User->read('id', $this->Auth->user('id'));
                $this->User->saveField('last_login',date('Y-m-d H-i-s'));
                $this->Flash->success(__('Welcome, '. $this->Auth->user('name')));

                $this->redirect('/users/profile');
            } else {
                $this->Flash->error(__('Invalid username or password'));
            }
        } 
    }
 
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
 
    public function index() {
        $this->redirect('/users/profile');
    }

    public function register() {
        if ($this->request->is('post')) {
                 
            $this->request->data['User']['last_login'] = date('Y-m-d H-i-s');
            $this->request->data['User']['created_ip'] = $this->request->clientIp();

            if ($this->User->save($this->request->data)) {
                if($this->Auth->login())
                {
                    $this->request->data['Profile']['user_id'] = $this->Auth->user('id');
                    $this->Profile->save($this->request->data);
                    $this->redirect('/users/success');
                }
                
            } else {
                $this->Flash->error(__('The user could not be created. Please, try again.'));
            }   
        }
    }

    public function success()
    {

    }

    public function profile()
    {
        $profile = $this->Profile->find('first',array(
                'conditions' => array('Profile.user_id' => $this->Auth->user('id') )
            )
        );

        $this->set(compact('profile'));
    }

    public function checkEmailExist()
    {
        $this->response->type('application/json');  
        $this->autoRender = false; 

        if($this->request->is('get'))
        {
            $email_exist = $this->User->find('first',  array(
                'conditions' => array('User.email' => $this->request->query['email']) 
                )
            );

            if($email_exist)
            {
                return json_encode(true);
            }
        }
        return json_encode(false);
    }

    public function settings()
    {
        $user = $this->Auth->user();
        $this->set(compact('user'));

        if($this->request->is('post')){

            $current_user = $this->User->find('first', array(
                                        'conditions'=>array('User.id'=> $this->Auth->user('id'))
                                    )
                                );

            $email_exist = $this->User->find('all', array(
                                    'conditions'=>array(
                                                'User.id !='=>$this->Auth->user('id'),
                                                'User.email'=>$this->request->data['User']['email']
                                    )
                                ));

            $hash_new_check = Security::hash($this->request->data['User']['old_password'], 'blowfish', $current_user['User']['password']);

            if($email_exist)
            {
                return $this->Flash->error(__('This email is already in use'));
            }

            if($hash_new_check != $current_user['User']['password'])
            {
                return $this->Flash->error(__('Your old password not match.'));
            }

            if($this->request->data['User']['password_update'] != $this->request->data['User']['password_confirm_update'])
            {
                return $this->Flash->error(__('Confim password not match.'));
            }

            $this->User->read('id', $this->Auth->user('id'));
            $this->User->saveField('email', $this->request->data['User']['email']);
            $this->User->saveField('password', $this->request->data['User']['password_update']);
            $this->User->saveField('modified_ip', $this->request->clientIp());

            $this->Flash->success(__('Your settings has been saved.'));

            return $this->redirect('/users/settings'); 

        }
        

        
    }
 
    public function edit() {

        if($this->request->is('post'))
        {
            $profile = $this->Profile->find('first',  array(
                'conditions' => array('Profile.user_id' => $this->Auth->user('id') )
                )
            );

            if(isset($this->request->data['Profile']['picture']) && isset($this->request->data['Profile']['picture']['name']))
            {
                if($this->request->data['Profile']['picture']['name'] && $this->request->data['Profile']['picture']['type'])
                {
                    $exp = array();
                    $exp = explode("/", $this->request->data['Profile']['picture']['type']);

                    $this->request->data['Profile']['picture']['name'] = $this->Auth->user('id').date("Y_m_d_H_i") .".". $exp[1];

                    $tmp = $this->request->data['Profile']['picture']['tmp_name']; 
                    $image = $this->request->data['Profile']['picture']['name'];
                    $target = WWW_ROOT.'img'.DS.'profile'.DS; 

                    $target = $target.basename($image); 

                    if (move_uploaded_file($tmp, $target)) {
                        echo "Successfully moved"; 

                        $this->request->data['Profile']['profile_pic_path'] = 'profile/'.$this->request->data['Profile']['picture']['name'];
                    }
                    else
                    {
                        echo "Error";
                    }
                }else{
                    $this->request->data['Profile']['profile_pic_path'] = '';
                }
            }


            $this->request->data['Profile']['user_id'] = $this->Auth->user('id');
            $this->request->data['Profile']['birthdate'] = date('Y-m-d',strtotime($this->request->data['Profile']['date']));
            

            if(!$profile){
                $this->Profile->save($this->request->data);
            }else{
                var_dump($profile['Profile']['id']);
                $this->Profile->read(null, $profile['Profile']['id']);

                if($this->request->data['Profile']['profile_pic_path'])
                {
                    $this->Profile->saveField('profile_pic_path', $this->request->data['Profile']['profile_pic_path']);
                }

                $this->Profile->saveField('birthdate', $this->request->data['Profile']['birthdate']);
                $this->Profile->saveField('gender', $this->request->data['Profile']['gender']);
                $this->Profile->saveField('hubby', $this->request->data['Profile']['hubby']);

                $this->User->read('id', $this->Auth->user('id'));
                $this->User->saveField('name', $this->request->data['Profile']['name']);

                $this->Flash->success(__('Your profile has been saved.'));
                return $this->redirect('/users/profile');
            }
        }
        
        $profile = $this->Profile->find('first',array(
                'conditions' => array('Profile.user_id' => $this->Auth->user('id') )
            )
        );

        $this->set(compact('profile'));
    }
 
}