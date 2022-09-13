<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class ProfileController extends AppController {

    public function view($id)
    {
        $profile = $this->Profile->find('first',array(
                                'conditions'=>array('User.id'=>$id)
        ));

        $this->set(compact('profile'));
    }
 
}