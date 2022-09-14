<style type="text/css">
    table tr td{
        border-bottom: none;
    }
</style>
<div class="users form">
	<fieldset>
		<legend><?php echo __('Message Detail'); ?></legend>
	</fieldset>

	<div class="col-lg-12">
        <div class="sidebar-item comments">
            
            <div class="content">
        		<table id="message_<?php echo $message['Message']['id'] ?>">
        			<tr>
        				<td width="100">
                              <?php echo $this->Html->image($message['User']['Profile']['profile_pic_path'] ? $message['User']['Profile']['profile_pic_path']  : 'profile/blank-profile.jpeg', array('width' => '100px','alt'=>'profile')); ?>
                        </td>
        				<td style="vertical-align: middle;">
        					<h3><?php echo $message['User']['name'] ?></h3>
        					<h4><?php echo time_elapsed_string($message['Message']['created']) ?></h4>
        					<pre id="message_description_<?php echo $message['Message']['id'] ?>"><?php echo $message['Message']['description'] ?></pre>
                            <mark><?php echo $message['Recipient']['name'] ?></mark>
                            <p></p>
                            <?php if(AuthComponent::user('id') == $message['User']['id']) { ?>
                            <a href="javascript:" class="message_edit_action" data-detail='<?php echo htmlspecialchars(json_encode($message['Message']), ENT_QUOTES,'UTF-8')?>'>Edit</a>
                            |
                            <a href="javascript:deleteMessage(<?php echo $message['Message']['id'] ?>)">Delete</a>
                            <?php } ?>
        				</td>
        			</tr>
        		</table>

                <?php if(AuthComponent::user('id') == $message['User']['id']) { ?>
                <table id="edit_message_form_<?php echo $message['Message']['id'] ?>" style="display: none;">
                    <tr>
                        <td>
                            <form id="form_edit_message_<?php echo $message['Message']['id'] ?>">
                                <fieldset>
                                    <?php echo $this->Form->input('edit_message',array('type'=>'textarea','id'=>'edit_message_message_'.$message['Message']['id'],'rows'=>2, 'value'=>$message['Message']['description'])) ?>
                                    <div class="submit">
                                        <?php echo $this->Form->button('Edit Message', array('type'=>'button', 'id'=>'edit_message_btn' ,'class'=>'submit edit_message_btn', 'data-id'=>$message['Message']['id'])); ?>

                                        <?php echo $this->Form->button('Cancel', array('type'=>'button', 'id'=>'edit_cancel_message_btn', 'class'=>'edit_cancel_message_btn', 'data-id'=>$message['Message']['id'])); ?>
                                    </div>
                                </fieldset>
                            </form>
                        </td>
                    </tr>
                </table>
                <?php } ?>

                <hr>
                <table>
                    <tr>
                        <td width="100">
                            <?php 
                                echo $this->Html->image($user['Profile']['profile_pic_path'] ? $user['Profile']['profile_pic_path']  : 'profile/blank-profile.jpeg', array('width' => '100px','alt'=>'profile','style'=>'margin-top:30px')); ?>
                        </td>
                        <td style="vertical-align: top;">
                            <fieldset>
                                <?php echo $this->Form->create('Reply'); ?>
                                <?php echo $this->Form->input('reply_message',array('type'=>'textarea','rows'=>2)) ?>
                                <?php echo $this->Form->input('message_id',array('type'=>'hidden','value'=>$message['Message']['id'])) ?>
                                <?php echo $this->Form->submit('Reply',array('id'=>'reply_btn','disabled'=>true)); ?>
                            </fieldset>
                        </td>
                    </tr>
                
                </table>
                <hr>
                <h3 id="count_reply"><?php echo count($message['Reply']) ? count($message['Reply']) > 1 ? count($message['Reply']).' Replies' : count($message['Reply']).' Reply' : '0 Reply'; ?></h3>
                <div class="reply_container">
            		<?php foreach($message['Reply'] as $reply): ?>
                        <div class="reply_content content_<?php echo $reply['id'] ?>">
                            <table id="reply_<?php echo $reply['id'] ?>">
                                <tr>
                                    <td width="100">
                                        <?php echo $this->Html->image($reply['User']['Profile']['profile_pic_path'] ? $reply['User']['Profile']['profile_pic_path'] : 'profile/blank-profile.jpeg', array('width' => '100px','alt'=>'profile')); ?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h3><?php echo $this->Html->link($reply['User']['name'],   '/profile/view/'.$reply['User']['id'] ); ?></h3>
                                        <h4><?php echo time_elapsed_string($reply['created']) ?></h4>
                                        <pre id="reply_description_<?php echo $reply['id'] ?>"><?php echo $reply['description']; ?></pre>
                                        <span class="reply_edited" id="reply_edited_<?php echo $reply['id'] ?>"><?php echo $reply['created'] != $reply['modified'] ? '(edited)<br><br>' : '' ?></span>
                                        <?php if(AuthComponent::user('id') == $reply['User']['id']) { ?>
                                        <a href="javascript:" class="edit_message_action" data-detail='<?php echo htmlspecialchars(json_encode($reply), ENT_QUOTES,'UTF-8') ?>'>Edit</a>
                                        |
                                        <a href="javascript:deleteReply(<?php echo $reply['id'] ?>)">Delete</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>

                            <?php if(AuthComponent::user('id') == $reply['User']['id']) { ?>
                            <table id="edit_reply_form_<?php echo $reply['id'] ?>" style="display: none;">
                                <tr>
                                    <td>
                                        <form id="edit_form_<?php echo $reply['id'] ?>">
                                            <fieldset>
                                                <?php echo $this->Form->input('edit_reply',array('type'=>'textarea','id'=>'edit_reply_message_'.$reply['id'],'rows'=>2, 'value'=>$reply['description'])) ?>
                                                <div class="submit">
                                                    <?php echo $this->Form->button('Edit Reply', array('type'=>'button', 'id'=>'edit_reply_btn' ,'class'=>'submit edit_reply_btn', 'data-id'=>$reply['id'])); ?>

                                                    <?php echo $this->Form->button('Cancel', array('type'=>'button', 'id'=>'edit_cancel_reply_btn', 'class'=>'edit_cancel_reply_btn', 'data-id'=>$reply['id'])); ?>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>
                        </div>
        	    	<?php endforeach ?>

                </div>
                <a href="javascript:showMore(10)" id="show_more_data">Show more</a>
            </div>
        </div>
    </div>
</div>
<?php
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

<script type="text/javascript">
    var load_count = 0;
    $(document).ready(function(){
        $('.reply_content').hide();
        setTimeout(function(){
            $('#ReplyReplyMessage').focus();
        },50);

        setTimeout(function(){
            showMore(10);
        },100)


    });

    // function showMore(number){

    //     var count = 1;
    //     $('.reply_content').each(function(){

    //         if(!$(this).is(':visible'))
    //         {
    //             if(count <= number)
    //             {
    //                 $(this).show();
    //             }

    //             count++;
    //         }
    //     });
    //     countReply();
    // }

    function showMore(number){

        var count = 1;
        $('.reply_content').each(function(){

            if(!$(this).is(':visible'))
            {
                if(count <= number)
                {
                    $(this).show();
                }

                count++;
            }
        });

        load_count += number;

        if(load_count >= $('.reply_content').length)
        {
            $('#show_more_data').hide();
        }else{
            $('#show_more_data').show();
        }

    }



    $('#ReplyReplyMessage').keyup(function(){
        if($(this).val())
        {
            $('#reply_btn').removeAttr('disabled');
        }else{
            $('#reply_btn').attr('disabled','disabled');
        }
    })
    $("form").on("submit", function(event){
        event.preventDefault();
        var form_data = new FormData($(this)[0]);

        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'reply', 'action'=>'replyMessage')) ?>',
            type: 'post',
            data: form_data,
            processData: false,
            contentType: false,
            // dataType: "json",
            success: function(data, textStatus, jqXHR) {
               // location.assign("success");
               $('.reply_container').append(data);
               $('#ReplyReplyMessage').val('');

               countReply();
            },
            error: function(data, textStatus, jqXHR) {
               //process error msg
               console.log(data);
            },
        })
    });

    $('.message_edit_action').click(function(){
        var detail = $(this).data('detail');

        console.log(detail);
        $('#edit_message_form_'+detail.id).show();
        $('#message_'+detail.id).hide();
    });

    $('.edit_cancel_message_btn').click(function(){
        var id = $(this).data('id');

        $('#edit_message_form_'+id).hide();
        $('#message_'+id).show();
    });



    $('.reply_container').on('click','.edit_message_action',function(){
        var detail = $(this).data('detail');

        $('#edit_reply_form_'+detail.id).show();
        $('#reply_'+detail.id).hide();
    });

    $('.reply_container').on('click','.edit_cancel_reply_btn',function(){
        var id = $(this).data('id');

        $('#edit_reply_form_'+id).hide();
        $('#reply_'+id).show();
    });

    $('.edit_message_btn').click(function(){

        console.log($(this).data('id'));
        var form_data = new FormData($('#form_edit_message_'+$(this).data('id'))[0]);

        form_data.append('id',$(this).data('id'));

        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'editMessage')) ?>',
            type: 'post',
            data: form_data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {
                console.log(data);

                $('#message_description_'+data.id).text(data.edit_message);
                $('#edit_message_form_'+data.id).hide();
                $('#message_'+data.id).show();
            },
            error: function(data, textStatus, jqXHR) {
               console.log(data);
            },
        })

    });

    $('.reply_container').on('click','.edit_reply_btn',function(){
        console.log($(this).data('id'));
        var form_data = new FormData($('#edit_form_'+$(this).data('id'))[0]);

        form_data.append('id',$(this).data('id'));

        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'reply', 'action'=>'editReply')) ?>',
            type: 'post',
            data: form_data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {
                console.log(data);

                $('#reply_description_'+data.id).text(data.Reply.edit_reply);
                $('#reply_edited_'+data.id).html('(edited)<br><br>');
                $('#edit_reply_form_'+data.id).hide();
                $('#reply_'+data.id).show();
            },
            error: function(data, textStatus, jqXHR) {
               console.log(data);
            },
        })
    });

    function deleteMessage(id)
    {
        var delete_confirm = confirm('Are you sure you want to delete this message?');

        if(delete_confirm)
        {
            $.ajax({
                url:'<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'deleteMessage')) ?>',
                type: 'post',
                data: {
                    id:id
                },
                dataType: "json",
                success: function(data, textStatus, jqXHR) {
                    alert('Deleted successfully!');
                    location.assign('<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'list')) ?>');
                },
                error: function(data, textStatus, jqXHR) {
                   console.log(data);
                },
            })
        }
    }

    function deleteReply(id)
    {
        var delete_confirm = confirm('Are you sure you want to delete this message?');

        if(delete_confirm)
        {
            $.ajax({
                url:'<?php echo $this->Html->url(array('controller'=>'reply', 'action'=>'deleteReply')) ?>',
                type: 'post',
                data: {
                    id:id
                },
                dataType: "json",
                success: function(data, textStatus, jqXHR) {
                    console.log(data);

                    $('.content_'+data.id).remove();
                    countReply();

                },
                error: function(data, textStatus, jqXHR) {
                   console.log(data);
                },
            })
        }
    }

    function countReply()
    {
        $('#count_reply').text($('.reply_content').length > 1 ? $('.reply_content').length+' Replies' : $('.reply_content').length+' Reply');

        if($('.reply_content').length > 10)
        {
            $('#show_more_data').show();
        }else{
            $('#show_more_data').hide();
        }

        setTimeout(function(){
            $('.reply_content').each(function(){
                if(!$(this).is(':visible'))
                {
                    $('#show_more_data').show();
                }
            })
        })
        
    }
</script>


