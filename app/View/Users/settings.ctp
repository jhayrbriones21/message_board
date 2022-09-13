<div class="users form">
    <fieldset>
        <?php echo $this->Form->create('User'); ?>
        <legend><?php echo __('Settings'); ?></legend>
        <?php echo $this->Form->input('email', array('value'=>$user['email'])); ?>
        <?php echo $this->Form->input('old_password', array('label' => 'Old Password', 'maxLength' => 255, 'type'=>'password')); ?>
        <?php echo $this->Form->input('password_update', array('label' => 'New Password', 'maxLength' => 255,'type'=>'password')); ?>
        <?php echo $this->Form->input('password_confirm_update', array('label' => 'Confirm Password', 'maxLength' => 255,'type'=>'password')); ?>
        <?php echo $this->Form->end(__('Update')); ?>
    </fieldset>
</div>

<script type="text/javascript">

    // $('form').on('submit',function(e){
    //     var password = $('#UserPasswordUpdate');

    //     var confirm_password = $('#UserPasswordConfirmUpdate');
    //     var validatedConfirmPassword = checkConfirmPassword(password.val(),confirm_password.val());

    //     if(!validatedConfirmPassword.status)
    //     {
    //         confirm_password.parent().attr('class','required error');
    //         confirm_password.next('div').remove();

    //         $("<div>", {
    //             class: "error-message", 
    //             text: validatedConfirmPassword.message,
    //             insertAfter: confirm_password,
    //         });
    //     }else{
    //         confirm_password.next('div').remove();
    //         confirm_password.parent().removeClass().addClass('required');
    //     }

    //     if($('.error-message').length){
    //         e.preventDefault();
    //     }
    // });

    // function checkConfirmPassword(password,confirm_password) {
    //     console.log(password,confirm_password);
    //     if(!confirm_password)
    //     {
    //         return {'status':false,'message':'Please confirm your password'};
    //     }
    //     else if(password != confirm_password)
    //     {
    //         return {'status':false,'message':'Confim passwords not match.'};
    //     }else{
    //         return {'status':true,'message':''};
    //     }
    // }
</script>

