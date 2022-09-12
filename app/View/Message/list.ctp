<div class="users form">
	<fieldset>
		<legend><?php echo __('Message List'); ?></legend>
		<div>
		<?php echo $this->Form->button('New Message', array(
		    'type' => 'button',
		    'onclick' => 'location.href=\'./add\';',
		    'style' => 'float:right',
		    'class' => 'btn btn-secondary'
		    )); ?>
		</div>
	</fieldset>

    <div class="col-lg-12">
      <div class="sidebar-item comments">
        <div class="content">
          	<?php foreach($messages as $message): ?>  
          		<table>
          			<tr style="cursor: pointer;" class="view_message_detail" data-href='./detail/<?php echo $message['Message']['id']; ?>'>
          				<td width="110"><img src="https://templatemo.com/templates/templatemo_551_stand_blog/assets/images/comment-author-02.jpg" alt=""></td>
          				<td style="vertical-align: middle;">
          					<h3><?php echo $message['User']['name'] ?></h3>
          					<h4><?php echo $message['Message']['created'] ?></h4>
          					<p><?php echo $message['Message']['description'] ?></p>
          				</td>
          			</tr>	
          		</table>
	        <?php endforeach ?>
        </div>
      </div>
    </div>
</div>

<?php echo $this->element('Sidebar/default');?>

<script type="text/javascript">
	$('.view_message_detail').click(function(){
		location.assign($(this).data('href'));
	})
</script>

