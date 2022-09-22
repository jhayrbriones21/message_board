<style type="text/css">
    table tr td{
        border-bottom: none;
    }
    ul
    {
        list-style-type: none;
    }

    div ul li
    {
        margin: 5px;
    }    

    img
    {
        vertical-align: middle; /* | top | bottom */
    }
    div ul li p
    {
        display: inline-block;
        vertical-align: middle; /* | top | bottom */
        margin: 10px;
    }
    #list_user_connected img{
        border-radius: 10px;
    }
</style>
<div style="position:relative;">
    <div style="position:absolute;">
    <h4>Connected to this room</h4>
        <ul id="list_user_connected">

        </ul>
    </div>
</div>
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
                              <?php echo $this->Html->image($message['Profile']['profile_pic_path'] ? $message['Profile']['profile_pic_path']  : 'profile/blank-profile.jpeg', array('width' => '100px','alt'=>'profile')); ?>
                        </td>
        				<td style="vertical-align: middle;">
        					<h3><?php echo $message['User']['name'] ?></h3>
        					<h4><?php echo time_elapsed_string($message['Message']['created']) ?></h4>
                            <mark><?php echo $message['Recipient']['name'] ?></mark>
        					<pre id="message_description_<?php echo $message['Message']['id'] ?>" class="show-read-more"><?php echo $message['Message']['description'] ?></pre>
                            <p style="color: gray;" id="message_edited_status"><?php echo $message['Message']['created'] != $message['Message']['modified'] ? '(edited)' : '' ?></p>
                            <?php if(AuthComponent::user('id') == $message['User']['id']): ?>
                            <a href="javascript:" class="message_edit_action" data-detail='<?php echo htmlspecialchars(json_encode($message['Message']), ENT_QUOTES,'UTF-8')?>'>Edit</a>
                            |
                            <a href="javascript:deleteMessage(<?php echo $message['Message']['id'] ?>)">Delete</a>
                            <?php endif ?>
        				</td>
        			</tr>
        		</table>

                <?php if(AuthComponent::user('id') == $message['User']['id']): ?>
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
                <?php endif ?>

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
                        <div class="reply_content content_<?php echo $reply['Reply']['id'] ?>">
                            <table id="reply_<?php echo $reply['Reply']['id'] ?>">
                                <tr>
                                    <td width="100">
                                        <?php echo $this->Html->image($reply['Profile']['profile_pic_path'] ? $reply['Profile']['profile_pic_path'] : 'profile/blank-profile.jpeg', array('width' => '100px','alt'=>'profile')); ?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h3><?php echo $this->Html->link($reply['User']['name'],   '/profile/view/'.$reply['User']['id'] ); ?></h3>
                                        <h4><?php echo time_elapsed_string($reply['Reply']['created']) ?></h4>
                                        <pre id="reply_description_<?php echo $reply['Reply']['id'] ?>" class="show-read-more"><?php echo htmlspecialchars($reply['Reply']['description']) ?></pre>
                                        <span class="reply_edited" id="reply_edited_<?php echo $reply['Reply']['id'] ?>"><?php echo $reply['Reply']['created'] != $reply['Reply']['modified'] ? '(edited)<br><br>' : '' ?></span>
                                        <?php if(AuthComponent::user('id') == $reply['User']['id']): ?>
                                        <a href="javascript:" class="edit_message_action" data-detail='<?php echo htmlspecialchars(json_encode($reply['Reply']), ENT_QUOTES,'UTF-8') ?>'>Edit</a>
                                        |
                                        <a href="javascript:deleteReply(<?php echo $reply['Reply']['id'] ?>)">Delete</a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </table>

                            <?php if(AuthComponent::user('id') == $reply['User']['id']): ?>
                            <table id="edit_reply_form_<?php echo $reply['Reply']['id'] ?>" style="display: none;">
                                <tr>
                                    <td>
                                        <form></form>
                                        <form id="edit_form_<?php echo $reply['Reply']['id'] ?>">
                                            <fieldset>
                                                <?php echo $this->Form->input('edit_reply',array('type'=>'textarea','id'=>'edit_reply_message_'.$reply['Reply']['id'],'rows'=>2, 'value'=>$reply['Reply']['description'])) ?>
                                                <div class="submit">
                                                    <?php echo $this->Form->button('Edit Reply', array('type'=>'button', 'id'=>'edit_reply_btn' ,'class'=>'submit edit_reply_btn', 'data-id'=>$reply['Reply']['id'])); ?>

                                                    <?php echo $this->Form->button('Cancel', array('type'=>'button', 'id'=>'edit_cancel_reply_btn', 'class'=>'edit_cancel_reply_btn', 'data-id'=>$reply['Reply']['id'])); ?>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <?php endif ?>
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

<script src="http://<?php echo $_SERVER['SERVER_NAME'] ?>:3000/socket.io/socket.io.js"></script>
<script>
    
	var socket = io.connect('http://<?php echo $_SERVER['SERVER_NAME'] ?>:3000'); // connect to socket.io server
    var room = <?php echo json_encode(hash('sha1',$message['Message']['id'])) ?>;
    var user = <?php echo json_encode(AuthComponent::user()) ?>;
    user.profile_pic_path = <?php echo json_encode($user['Profile']['profile_pic_path']) ?>

    $(document).ready(function(){
        $('.reply_content').hide();
        setTimeout(function(){
            $('#ReplyReplyMessage').focus();
        },50);

        setTimeout(function(){
            showMore(10);
        },100)

        var maxLength = 300;
		$(".show-read-more").each(function(){
			var myStr = $(this).text();
			if($.trim(myStr).length > maxLength){
				var newStr = myStr.substring(0, maxLength);
				var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
				$(this).empty().html(newStr);
				$(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
				$(this).append('<span class="more-text">' + removedStr + '</span>');
			}
		});
		$(".read-more").click(function(){
			$(this).siblings(".more-text").contents().unwrap();
			$(this).remove();
		});

        $("textarea").autoHeight();

        socket.emit('join-room',room,user); // join room when they page is ready
    });

    socket.on('users_connected_to_this_room', data => {
        var user_list = '';
        $.map(data,function(user){
            console.log(user);
            // user_list += `<li>${user.name}</li>`;
            user_list += `<li><a href="<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'messagePrivate/${user.id}'))?>"><img src="/test/img/${(user.profile_pic_path ? user.profile_pic_path : 'profile/blank-profile.jpeg')}" width="20px" alt="profile"><p>${user.name}</p></a></li>`;
        });

        $('#list_user_connected').html(user_list);
    });

    // execute message edited
    socket.on('receive_message_edited', data => {
        $('#message_description_'+data.id).text(data.edit_message);
        $('#edit_message_form_'+data.id).hide();
        $('#message_'+data.id).show();
        $('#message_edited_status').text('(edited)');
    });

    // execute deleted message
    socket.on('receive_message_deleted', data => {
        location.reload();
    });

    // execute add reply
    socket.on('receive_reply', data => {
        $('.reply_container').append(appendReplyTemplate(data));
        countReply();
        $("textarea").autoHeight();
    });

    // execute edited reply
    socket.on('receive_reply_edited', data => {
        $('#reply_description_'+data.Reply.id).text(data.Reply.description);
        $('#reply_edited_'+data.Reply.id).html('(edited)<br><br>');
        $('#edit_reply_form_'+data.Reply.id).hide();
        $('#reply_'+data.Reply.id).show();
    })

    // execute deleted reply
    socket.on('receive_reply_deleted', data => {
        $('.content_'+data.Reply.id).remove(); // remove from list
        countReply(); // update count replied
    })
</script>

<script type="text/javascript">
    var load_count = 0;

    jQuery.fn.extend({
        autoHeight: function () {
            function autoHeight_(element) {
            return jQuery(element)
                .css({ "height": 0, "overflow-y": "hidden" })
                .height(element.scrollHeight);
            }
            return this.each(function() {
            autoHeight_(this).on("input", function() {
                autoHeight_(this);
            });
            });
        }
    });

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
            success: function(data, textStatus, jqXHR) {
               $('#ReplyReplyMessage').val('');
               socket.emit('send-reply', data,room);
            },
            error: function(data, textStatus, jqXHR) {
               console.log(data);
            },
        })
    });

    $('.message_edit_action').click(function(){
        var detail = $(this).data('detail');

        $('#edit_message_form_'+detail.id).show();
        $('#message_'+detail.id).hide();
        $('#edit_message_message_'+detail.id).focus().trigger('input');
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

        $("textarea").autoHeight();
        $('#edit_reply_message_'+detail.id).focus().trigger('input');

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
                socket.emit('send-message-edited',data,room);
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
                socket.emit('send-reply-edited',data,room); // send reply edited to server
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
                    socket.emit('send-message-deleted',data,room); // send to server that the message was deleted
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
                    socket.emit('send-reply-deleted',data,room); // send reply deleted to server
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

    function appendReplyTemplate(data)
    {
        var reply_template = `<div class="reply_content content_${data.Reply.id}">
                    <table id="reply_${data.Reply.id}">
                        <tr>
                            <td width="100">
                                <img src="/test/img/${(data.Profile.profile_pic_path ? data.Profile.profile_pic_path : 'profile/blank-profile.jpeg')}" width="100px" alt="profile">
                            </td>
                            <td style="vertical-align: middle;">
                                <h3><a href="/profile/view/${data.User.id}">${data.User.name}</a></h3>
                                <h4>${data.Reply.created}</h4>
                                <pre id="reply_description_${data.Reply.id}">${data.Reply.description}</pre>
                                <span class="reply_edited" id="reply_edited_${data.Reply.id}"></span>`;

                                if(data.User.id == <?php echo AuthComponent::user('id') ?>)
                                {
                                    reply_template += `<a href="javascript:" class="edit_message_action" data-detail=\'${JSON.stringify(data.Reply)}\'>Edit</a>
                                                        |
                                                        <a href="">Delete</a>`;
                                }
                                reply_template += `</td>
                        </tr>
                    </table>`;

                    if(data.User.id == <?php echo AuthComponent::user('id') ?>){
                        reply_template += `<table id="edit_reply_form_${data.Reply.id}" style="display: none;">
                                            <tr>
                                                <td>
                                                    <form id="edit_form_${data.Reply.id}">
                                                        <fieldset><textarea name="data[Reply][edit_reply]" id="edit_reply_message_${data.Reply.id}" rows="2">${data.Reply.description}</textarea>
                                                            <div class="submit">
                                                            <button type="button" id="edit_reply_btn" class="submit edit_reply_btn" data-id="${data.Reply.id}">Edit Reply</button>
                                                            <button type="button" id="edit_cancel_reply_btn" class="edit_cancel_reply_btn" data-id="${data.Reply.id}">Cancel</button>
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>`;
                    }
        return reply_template;
    }
</script>


