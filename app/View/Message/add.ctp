<div class="users form">
	<?php echo $this->Form->create('Message'); ?>
	<fieldset>
		<legend><?php echo __('Add Message'); ?></legend>

		<div class="input textarea required">
			<label>Recipient</label>
			<select name="data[Message][recipient_id]" id="MessageRecipient" style="min-width: 50%">
			<?php
				foreach($users as $user):
					echo '<option value="'.$user['User']['value'].'">'.$user['User']['text'].'</option>';
				endforeach
			?>
			</select>
		</div>
		<?php echo $this->Form->input('description', array('type' => 'textarea')); ?>
		<?php echo $this->Form->end(__('Add New Message')); ?>
	</fieldset>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#MessageRecipient').select2();
		$("textarea").autoHeight();
	});

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
</script>

