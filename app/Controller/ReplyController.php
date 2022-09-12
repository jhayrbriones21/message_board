<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class ReplyController extends AppController {

    public function replyMessage()
    {
        if($this->request->is('post'))
        {
            $this->request->data['Reply']['description'] = $this->request->data['Reply']['reply_message'];
            $this->request->data['Reply']['user_id'] = $this->Auth->user('id');
            if ($this->Reply->save($this->request->data)) {
                return json_encode(true);
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }  
        }
    }
 
}