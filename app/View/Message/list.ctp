<style type="text/css">
	.is-hidden { display: none; }
</style>
<div class="users form">
	<fieldset>
		<legend style="width:100%;">
			<?php echo __('Message List'); ?> (<?php echo count($messages) ?>)
			<?php echo $this->Form->button('New Message', array(
			    'type' => 'button',
			    'onclick' => 'location.href=\'./add\';',
			    'style' => 'float:right',
			    'class' => 'btn btn-secondary'
			    )); ?>
		</legend>
		<div>
			<?php echo $this->Form->input('search_message',array('label'=>'Search Messages','oninput'=>'liveSearch()')) ?>
			
		</div>
	</fieldset>

    <div class="col-lg-12">
      <div class="sidebar-item comments">
        <div class="content">
          	<?php foreach($messages as $message): ?>  
          		<table>
          			<tr style="cursor: pointer;" class="view_message_detail" data-href='./detail/<?php echo $message['Message']['id']; ?>'>
          				<td width="150">
                      <?php echo $this->Html->image($message['User']['Profile']['profile_pic_path'] ? $message['User']['Profile']['profile_pic_path']  : 'profile/blank-profile.jpeg', array('width' => '150px','alt'=>'profile')); ?>
                  </td>
          				<td style="vertical-align: middle;">
          					<h3><?php echo $message['User']['name'] ?></h3>
          					<h4><?php echo $message['Message']['created'] ?></h4>
          					<mark><?php echo $message['Recipient']['name'] ?></mark>
          					<p><?php echo $message['Message']['description'] ?></p>
          					<p><?php echo count($message['Reply']) ? count($message['Reply']) > 1 ? 'Replies: '.count($message['Reply']) : 'Reply: '.count($message['Reply']) : '' ?></p>
          				</td>
          			</tr>	
          		</table>
	        <?php endforeach ?>
	        <a href="javascript:showMore(10)" id="show_more_data">Show more</a>
        </div>
      </div>
    </div>
</div>


<script type="text/javascript">

	var load_count = 0;
	$('.view_message_detail').click(function(){
		location.assign($(this).data('href'));
	});

    $(document).ready(function(){
        $('table').hide();

        showMore(10);


    });

    function showMore(number){

        var count = 1;
        $('table').each(function(){

            if(!$(this).is(':visible'))
            {
                if(count <= number)
                {
                    $(this).show();
                }

                count++;
            }
        });

        load_count =+ number;
    }

    function liveSearch() {

		  let table = $('table');
		  let search_query = $('#search_message').val();
		  for (var i = 0; i < table.length; i++) {
		    if(table[i].innerText.toLowerCase()
		      .includes(search_query.toLowerCase())) {
		        table[i].classList.remove("is-hidden");
		    } else {
		      table[i].classList.add("is-hidden");
		    }
		  }

		  if($('#search_message').val())
		  {
		  	
		  }
	}
</script>

