<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class ProfileController extends AppController {

    public function view($id)
    {
        $profile = $this->Profile->find('first',array(
                                'conditions'=>array('User.id'=>$id)
        ));

        if(!$profile){
            $this->Flash->error(__('Page not found!'));

            return $this->redirect($this->referer());
        }


        $this->set(compact('profile'));
    }
 
}