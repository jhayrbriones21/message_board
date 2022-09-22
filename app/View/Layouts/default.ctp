<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Message Board');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		// css
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('custom.css');
		echo $this->Html->css('fontawesome.css');
		echo $this->Html->css('jquery-ui.css');
		echo $this->Html->css('select2.min.css');

		//scripts
		echo $this->Html->script('jquery-3.6.1.min.js');
		echo $this->Html->script('jquery-ui.js');
		echo $this->Html->script('select2.min.js');


		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="banner">
				<?php echo $this->Html->link($cakeDescription, '#'); ?>
			</div>
			<div class="navbar">
			  	<?php 
			  		if(!$this->Session->check('Auth.User')):
			  			echo $this->Html->link('Register', '/users/register');
						echo $this->Html->link("Login",   '/users/login' );
					else:
			  			echo $this->Html->link("Message List",   '/message/list' );
			  		endif
	  			?>
				<!-- <a href="#">Logged ID: <?php echo AuthComponent::user('id'); ?> </a> -->
	  			<?php if($this->Session->check('Auth.User')): ?>
			  	<div class="dropdown">
			    	<button class="dropbtn"><?php echo AuthComponent::user('email'); ?> 
			      		<i class="fa fa-caret-down"></i>
			    	</button>
			    	<div class="dropdown-content">
			    		<?php 
							echo $this->Html->link("Profile",   '/users/profile' );
							echo $this->Html->link("Settings",   '/users/settings' );
							echo $this->Html->link("Logout",   '/users/logout' );
						?>
			    	</div>
			  	</div>
				 <?php endif ?>
			</div>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'https://cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
