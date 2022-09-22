<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Login'); ?></legend>
        <?php echo $this->Form->input('email'); ?>
        <?php echo $this->Form->input('password'); ?>
    <?php echo $this->Form->end(__('Login')); ?>
    </fieldset>
</div>

