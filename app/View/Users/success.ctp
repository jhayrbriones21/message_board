<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Thank you for registering'); ?></legend>
    </fieldset>
<?php echo $this->Form->button('Back to homepage', array(
    'type' => 'button',
    'onclick' => 'location.href=\'./index\';',
    )); ?>
</div>

