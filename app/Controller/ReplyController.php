<?php

App::uses('AppController', 'Controller');

class ReplyController extends AppController
{
    public function beforeFilter()
    {
        date_default_timezone_set('Asia/Manila');
    }

    public function replyMessage()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $this->request->data['Reply']['description'] = $this->request->data['Reply']['reply_message'];
            $this->request->data['Reply']['user_id'] = $this->Auth->user('id');
            if ($this->Reply->save($this->request->data)) {
                $reply = $this->Reply->find('first',array(
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
                    'conditions'=>array('Reply.id' => $this->Reply->id),
                    'fields'=>array(
                        'Reply.id',
                        'Reply.message_id',
                        'Reply.user_id',
                        'Reply.created',
                        'Reply.modified',
                        'Reply.description',
                        'Profile.profile_pic_path',
                        'User.name',
                        'User.id'
                    )
                ));
                $reply['Reply']['created'] = $this->time_elapsed_string($reply['Reply']['created']);
                return json_encode($reply);
            } else {
                $this->Flash->error(__('The user could not be created. Please, try again.'));
            }
        }
    }

    private function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k.' '.$v.($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string).' ago' : 'just now';
    }

    public function editReply()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $this->Reply->read('id', $this->request->data['id']);
            $this->Reply->saveField('description', $this->request->data['Reply']['edit_reply']);

            $reply = $this->Reply->find('first',array('conditions'=>array('Reply.id' => $this->Reply->id)));

            return json_encode($reply);
        }
    }

    public function deleteReply()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        $reply = $this->Reply->find('first',array('conditions'=>array('Reply.id' => $this->request->data['id'])));
        $this->Reply->delete(['Reply.id' => $this->request->data['id']]);

        return json_encode($reply);
    }
}
