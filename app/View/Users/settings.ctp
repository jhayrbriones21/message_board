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

