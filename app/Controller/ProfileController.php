<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class ProfileController extends AppController {

    public function view($id)
    {
        $profile = $this->Profile->find('first',array(
                            'joins' => array(
                                array(
                                    'table' => 'users',
                                    'alias' => 'User',
                                    'type' => 'INNER',
                                    'conditions' => array('User.id = Profile.user_id')
                                )
                            ),
                            'fields' => array(
                                'Profile.profile_pic_path',
                                'Profile.birthdate',
                                'Profile.gender',
                                'Profile.hubby',
                                'User.name',
                                'User.email',
                                'User.created',
                                'User.last_login',
                                'User.id'
                            ),
                            'conditions' => array('User.id' => $id)
                        )
                    );

        if(!$profile){
            $this->Flash->error(__('Page not found!'));

            return $this->redirect($this->referer());
        }


        $this->set(compact('profile'));
    }
 
}