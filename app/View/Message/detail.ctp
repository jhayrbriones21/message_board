<div class="users form">
	<fieldset>
		<legend><?php echo __('Message Detail'); ?></legend>
	</fieldset>

	<div class="col-lg-12">
    <div class="sidebar-item comments">
      <div class="content">
      	<fieldset>
	      	<?php echo $this->Form->create('Reply'); ?>
	      	<?php echo $this->Form->input('reply_message',array('type'=>'textarea')) ?>
	      	<?php echo $this->Form->input('message_id',array('type'=>'hidden','value'=>$message['Message']['id'])) ?>
	      	<?php echo $this->Form->end(__('Reply')); ?>
	      </fieldset>
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
    		<?php foreach($message['Reply'] as $reply): ?>
    		<div class="reply_content">
    			<p class="reply_date"><?php echo $reply['created']; ?></p>
    			<br>
    			<p><?php echo $reply['description']; ?></p>
    				
  			</div>
	    	<?php endforeach ?>
      </div>
      

    </div>
  </div>
</div>

<?php echo $this->element('Sidebar/default');?>

<script type="text/javascript">
    $("form").on("submit", function(event){
        event.preventDefault();

        var form_data = new FormData($(this)[0]);

        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'reply', 'action'=>'replyMessage')) ?>',
            type: 'post',
            data: form_data,
            processData: false,
            contentType: false,
            // dataType: "json",
            success: function(data, textStatus, jqXHR) {
               location.assign("success");
            },
            error: function(data, textStatus, jqXHR) {
               //process error msg
               console.log(data);
            },
        })
    });
</script>


