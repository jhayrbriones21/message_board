<?php if($this->Session->check('Auth.User')){ ?>
<h1><?php echo $this->Html->link("Message List",   '/message/list' ); ?><h1>
<h1><?php echo $this->Html->link("Profile",   '/users/profile' ); ?><h1>
<h1><?php echo $this->Html->link("Logout",   '/users/logout' ); ?><h1>
<?php }else{ ?>
<h1><?php echo $this->Html->link('Register', '/users/register'); ?></h1>
<h1><?php echo $this->Html->link("Login",   '/users/login' ); ?><h1>
<?php } ?>
