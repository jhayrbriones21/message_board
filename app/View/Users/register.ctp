<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Register'); ?></legend>
        <?php echo $this->Form->input('name'); ?>
        <?php echo $this->Form->input('email'); ?>
        <?php echo $this->Form->input('password'); ?>
        <?php echo $this->Form->input('password_confirm', array('label' => 'Confirm Password', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password')); ?>
        <div class="submit">
            <?php echo $this->Form->button('Register', array('type'=>'button', 'id'=>'register_btn' ,'class'=>'submit')); ?>
        </div>
    </fieldset>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#UserName,#UserEmail,#UserPassword,#UserPasswordConfirm').removeAttr('required');
    });

    var timer_email;
    var email_log;
    var timer_submit;
    $('#UserEmail').keydown(function(){
        if(email_log != $(this).val())
        {
            clearTimeout(timer_email);

            timer_email = setTimeout(function(){
                checkEmailExist($('#UserEmail').val());
            },500);

            email_log = $(this).val();
        }
    });

    $('#register_btn').click(function(){

        var name = $('#UserName');
        var validatedName = allLetter(name.val());

        var email = $('#UserEmail');
        var validatedEmail = isEmail(email.val());

        var password = $('#UserPassword');
        var validatedPassword = checkPassword(password.val());

        var confirm_password = $('#UserPasswordConfirm');
        var validatedConfirmPassword = checkConfirmPassword(password.val(),confirm_password.val());

        if(!validatedName.status)
        {
            name.parent().attr('class','required error');
            name.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedName.message,
                insertAfter: name,
            });
        }else{
            name.next('div').remove();
            name.parent().removeClass().addClass('required');
        }

        if(!validatedEmail.status)
        {
            email.parent().attr('class','required error');
            email.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedEmail.message,
                insertAfter: email,
            });
        }else{
            email.next('div').remove();
            email.parent().removeClass().addClass('required');
        }

        if(!validatedPassword.status)
        {
            password.parent().attr('class','required error');
            password.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedPassword.message,
                insertAfter: password,
            });
        }else{
            password.next('div').remove();
            password.parent().removeClass().addClass('required');
        }

        if(!validatedConfirmPassword.status)
        {
            confirm_password.parent().attr('class','required error');
            confirm_password.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedConfirmPassword.message,
                insertAfter: confirm_password,
            });
        }else{
            confirm_password.next('div').remove();
            confirm_password.parent().removeClass().addClass('required');
        }

        if(!$('.error-message').length){
            $("form").submit();
        }
    })

    function checkEmailExist(email)
    {
         $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'checkEmailExist')) ?>',
            type: 'get',
            data: {
                email: email
            },
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
                var email = $('#UserEmail');
                if(data)
                {
                    email.parent().attr('class','required error');
                    email.next('div').remove();

                    $("<div>", {
                        class: "error-message", 
                        text: 'This email is already in use',
                        insertAfter: email,
                    });
                }else{
                    email.next('div').remove();
                    email.parent().removeClass().addClass('required');
                }
            },
            error: function(data, textStatus, jqXHR) {
               //process error msg
               console.log(data);
            },
        })
    }

    function allLetter(name)
    { 
        var letters = /^[A-Za-z ]+$/;

        if(!name)
        {
            return {'status':false,'message':'Name is required'};
        }
        else if(name.length < 5)
        {
            return {'status':false,'message':'Name must have a mimimum of 5 characters'};
        }
        else if(name.length > 20)
        {
            return {'status':false,'message':'Name must have a maximum of 20 characters'};
        }
        else if(letters.test(name))
        {
            return {'status':true,'message':''};
        }
        else
        {
            return {'status':false,'message':'Name must have alphabet characters only'};
        }
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!email)
        {
            return {'status':false,'message':'Email is required'};
        }
        else if(regex.test(email))
        {
            return {'status':true,'message':''};
        }else{
            return {'status':false,'message':'Please provide a valid email address.'};
        }
        return regex.test(email);
    }

    function checkPassword(password) {
        if(!password)
        {
            return {'status':false,'message':'Password is required'};
        }else{
            return {'status':true,'message':''};
        }
    }

    function checkConfirmPassword(password,confirm_password) {

        if(!confirm_password)
        {
            return {'status':false,'message':'Please confirm your password'};
        }
        else if(password != confirm_password)
        {
            return {'status':false,'message':'Confim passwords not match.'};
        }else{
            return {'status':true,'message':''};
        }
    }
</script>