<style>
    .recipient_message{
        padding: 1px 15px;
        background: #efeded;
        border-radius: 15px;
        text-align: left;
        margin-top: 10px;
        float: left;
        width: 75%;
    }
    .sender_message{
        padding: 1px 15px;
        background: #3ac9f2;
        border-radius: 15px;
        text-align: right;
        margin-top: 10px;
        float: right;
        width: 75%;
    }
    table tr td{
        border-bottom: none;
    }
    ul
    {
        list-style-type: none;
        margin: 0px;
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
        margin: 2px;
    }
    #list_user_connected img{
        border-radius: 10px;
    }
    li span{
        font-size: 11px;
        /* margin-left: 27px; */
    }
    li a{
        text-decoration: none;
    }
    span .message_content {
        white-space: nowrap;
        width: 100%;                   /* IE6 needs any width */
        overflow: hidden;              /* "overflow" value must be different from  visible"*/ 
        -o-text-overflow: ellipsis;    /* Opera < 11*/
        text-overflow:    ellipsis;    /* IE, Safari (WebKit), Opera >= 11, FF > 6 */
    }
</style>
<div style="position:relative;">
    <div style="position:absolute;">
    <h4>List of Users</h4>
        <ul class="list_user_container">
            
        </ul>
    </div>
</div>
<div class="users form" style="width: 66%;">
    <fieldset>
		<legend><?php echo __('Private Message'); ?></legend>
        <img src="/test/img/<?php echo $user['Profile']['profile_pic_path'] ? $user['Profile']['profile_pic_path'] : 'profile/blank-profile.jpeg' ?>" width="100px" alt="profile">
        <p></p>
        <p>Recipient: <b><?php echo $user['User']['name'] ?></b></p>
        <p>Email: <b><?php echo $user['User']['email'] ?></b></p>
        <hr>
        <br>
        <div id="message_container">
            <?php if(!empty($private_messages)): ?>
                <?php foreach($private_messages as $private_message): ?>
                    <div class="<?php echo $private_message['Message']['user_id'] == AuthComponent::user('id') ? 'sender_message' : 'recipient_message' ?>"><pre><?php echo $private_message['Message']['description'] ?> <?php echo $private_message['Message']['id'] ?></pre></div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </fieldset>
    <fieldset>
    <hr>
    <br>
    <span><?php echo AuthComponent::user('id') ?></span>
		<?php echo $this->Form->input('description', array('type' => 'textarea','label'=>'Message')); ?>
        <?php echo $this->Form->submit('Send Message',array('id'=>'private_message_btn','disabled'=>true)); ?>
	</fieldset>
</div>


<script src="http://<?php echo $_SERVER['SERVER_NAME'] ?>:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect('http://<?php echo $_SERVER['SERVER_NAME'] ?>:3000/private_message'); // connect to socket.io server
    var ids = [<?php echo $user['User']['id'] ?>,<?php echo AuthComponent::user('id') ?>];
    var room = <?php echo json_encode($room) ?>;

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

    $(document).ready(function()
    {
        $("textarea").autoHeight().focus();

        socket.on('receive_private_message', data => {
            console.log(data);
            var auth_user_id = <?php echo AuthComponent::user('id') ?>;
            $('#message_container').append('<div class="'+(data.Message.user_id == auth_user_id ? 'sender_message' : 'recipient_message')+'"><pre>'+data.Message.description+'</pre></div>');
        });

        socket.on('has_new_chat_users',data => {
            console.log('has new chat');
            getUserLatestRecordMessage();
        })

        socket.emit('join-private-room',room);

        getUserLatestRecordMessage();
    })

    $(function(){

        $('#description').keyup(function(){
            if($(this).val())
            {
                $('#private_message_btn').removeAttr('disabled');
            }else{
                $('#private_message_btn').attr('disabled',true);
            }
        });

        $('#private_message_btn').click(function(){
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'sendPrivateMessage')) ?>',
                type: 'post',
                data: {
                    description: $('#description').val(),
                    recipient_id: '<?php echo $user['User']['id'] ?>',
                }
            }).done(function(data){
                $('#description').val('').focus().autoHeight();
                $('#message_container').append(`<div class="sender_message"><pre>${data.Message.description}</pre></div>`);

                socket.emit('send-private-message',data,room);
            })
        })
    });

    function getUserLatestRecordMessage()
    {
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'getUserLatestRecordMessage')) ?>',
            type: 'get',
            data:{}
        }).done(function(data){
            console.log(data);
            var list_user_con = '';
            $.map(data,function(user){
                list_user_con += `
                    <li>
                        <table>
                            <tr>
                            <td style="width: 40px;">
                                <img src="<?php echo $this->Html->url('/img') ?>/${(user.Profile.profile_pic_path ? user.Profile.profile_pic_path  : 'profile/blank-profile.jpeg')}" width="40px" alt="profile">
                            </td>
                            <td>
                                <a href="<?php echo $this->Html->url(array('controller'=>'message', 'action'=>'messagePrivate')) ?>/${user.User.id}">
                                    <p>${user.User.name}</p>
                                    <br>
                                    <p>${user.User.email}</p>
                                    <br>
                                    <span style="color: gray;">${user.Message.message_id} ${user.Message.id} ${truncate_with_ellipsis(user.Message.description,30)}</span>
                                    <span></span>
                                </a>
                            </td>
                            </tr>
                        </table>
                    </li>`;
            });

            $('.list_user_container').html(list_user_con);
        })
    }

    function truncate_with_ellipsis(s = '',maxLength) {
        if(s)
        {
            if (s.length > maxLength) {
                return s.substring(0, maxLength) + '...';
            }
        }else{
            return ''
        }
        
        return s;
        // console.log(s);
    };
</script>

