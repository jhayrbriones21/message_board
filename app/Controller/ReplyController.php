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
                        'Reply.user_id',
                        'Reply.created',
                        'Reply.modified',
                        'Reply.description',
                        'Profile.profile_pic_path',
                        'User.name',
                        'User.id'
                    )
                ));

                $data = '<div class="reply_content content_'.$reply['Reply']['id'].'">
                    <table id="reply_'.$reply['Reply']['id'].'">
                        <tr>
                            <td width="100">
                                <img src="/test/img/'.($reply['Profile']['profile_pic_path'] ? $reply['Profile']['profile_pic_path'] : 'profile/blank-profile.jpeg').'" width="100px" alt="profile">
                            </td>
                            <td style="vertical-align: middle;">
                                <h3><a href="/profile/view/'.$reply['User']['id'].'">'.$reply['User']['name'].'</a></h3>
                                <h4>'.$this->time_elapsed_string($reply['Reply']['created']).'</h4>
                                <pre id="reply_description_'.$reply['Reply']['id'].'">'.$reply['Reply']['description'].'</pre>
                                <span class="reply_edited" id="reply_edited_'.$reply['Reply']['id'].'"></span>
                                <a href="javascript:" class="edit_message_action" data-detail=\''.json_encode($reply['Reply']).'\'>Edit</a>
                                |
                                <a href="">Delete</a>
                            </td>
                        </tr>
                    </table>

                    <table id="edit_reply_form_'.$reply['Reply']['id'].'" style="display: none;">
                        <tr>
                            <td>
                                <form id="edit_form_'.$reply['Reply']['id'].'">
                                    <fieldset><textarea name="data[Reply][edit_reply]" id="edit_reply_message_'.$reply['Reply']['id'].'" rows="2">'.$reply['Reply']['description'].'</textarea>
                                        <div class="submit">
                                        <button type="button" id="edit_reply_btn" class="submit edit_reply_btn" data-id="'.$reply['Reply']['id'].'">Edit Reply</button>
                                        <button type="button" id="edit_cancel_reply_btn" class="edit_cancel_reply_btn" data-id="'.$reply['Reply']['id'].'">Cancel</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>';

                return json_encode($data);
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

            return json_encode($this->request->data);
        }
    }

    public function deleteReply()
    {
        $this->response->type('application/json');
        $this->autoRender = false;

        $this->Reply->delete(['Reply.id' => $this->request->data['id']]);

        return json_encode($this->request->data);
    }
}
