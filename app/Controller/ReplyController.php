<?php 
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class ReplyController extends AppController {

    public function replyMessage()
    {
        $this->response->type('application/json');  
        $this->autoRender = false; 

        if($this->request->is('post'))
        {
            $this->request->data['Reply']['description'] = $this->request->data['Reply']['reply_message'];
            $this->request->data['Reply']['user_id'] = $this->Auth->user('id');
            if ($this->Reply->save($this->request->data)) {

                $reply = $this->Reply->find('first',array(
                    'conditions'=>array('Reply.id'=>$this->Reply->id)
                    ,'recursive'=>2
                ));

                // $data = '<table class="reply_content"><tr>
                //     <td width="150"><img src="/test/img/'.($reply['User']['Profile']['profile_pic_path'] ? $reply['User']['Profile']['profile_pic_path'] : '/test/img/profile/blank-profile.jpeg').'" width="150px" alt="profile"></td>
                //     <td style="vertical-align: middle;">
                //         <h3>'.$reply['User']['name'].'</h3>
                //         <h4>'.$reply['Reply']['created'].'</h4>
                //         <pre>'.$reply['Reply']['description'].'</pre>
                //     </td>
                // </tr></table>';

                $data = '<div class="reply_content content_'.$reply['Reply']['id'].'">
                    <table id="reply_'.$reply['Reply']['id'] .'">
                        <tr>
                            <td width="100">
                                <img src="/test/img/'.($reply['User']['Profile']['profile_pic_path'] ? $reply['User']['Profile']['profile_pic_path'] : '/test/img/profile/blank-profile.jpeg').'" width="100px" alt="profile">
                            </td>
                            <td style="vertical-align: middle;">
                                <h3><a href="/profile/view/'.$reply['User']['id'].'">'.$reply['User']['name'].'</a></h3>
                                <h4>'.$reply['Reply']['created'].'</h4>
                                <pre id="reply_description_'.$reply['Reply']['id'] .'">'.$reply['Reply']['description'].'</pre>
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

    public function editReply()
    {
        $this->response->type('application/json');  
        $this->autoRender = false; 

        if($this->request->is('post'))
        {
            $this->Reply->read('id', $this->request->data['id']);
            $this->Reply->saveField('description', $this->request->data['Reply']['edit_reply']);

            return json_encode($this->request->data);
        }
    }

    public function deleteReply()
    {
        $this->response->type('application/json');  
        $this->autoRender = false; 

        $this->Reply->delete(array('Reply.id' => $this->request->data['id']));

        return json_encode($this->request->data);
    }
 
}