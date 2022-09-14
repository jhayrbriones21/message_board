<style type="text/css">
	.is-hidden { display: none !important; }
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
          					<h4><?php echo time_elapsed_string($message['Message']['created']) ?></h4>
          					<mark><?php echo $message['Recipient']['name'] ?></mark>
          					<pre class="show-read-more"><?php echo htmlspecialchars($message['Message']['description']) ?></pre>
          					<p><?php echo count($message['Reply']) ? count($message['Reply']) > 1 ? count($message['Reply']).' Replies' : count($message['Reply']).' Reply' : '0 Reply' ?> <a href="./detail/<?php echo $message['Message']['id']; ?>">add reply</p>
          				</td>
          			</tr>	
          		</table>
	        <?php endforeach ?>
	        <a href="javascript:showMore(10)" id="show_more_data">Show more</a>
        </div>
      </div>
    </div>
</div>

<?php
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>


<script type="text/javascript">

	var load_count = 0;

    $(document).ready(function(){
        $('table').hide();

        showMore(10);

         var maxLength = 300;
		    $(".show-read-more").each(function(){
		        var myStr = $(this).text();
		        if($.trim(myStr).length > maxLength){
		            var newStr = myStr.substring(0, maxLength);
		            var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
		            $(this).empty().html(newStr);
		            $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
		            $(this).append('<span class="more-text">' + removedStr + '</span>');
		        }
		    });
		    $(".read-more").click(function(){
		        $(this).siblings(".more-text").contents().unwrap();
		        $(this).remove();
		    });

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

        load_count += number;

        if(load_count >= $('table').length)
        {
        	$('#show_more_data').hide();
        }else{
        	$('#show_more_data').show();
        }

    }

    function liveSearch() {

    	if($('#search_message').val())
		{
		  	$('table').show();
		}else{
			$('table').hide();
			var count = 1;
			$('table').each(function(){

	            if(!$(this).is(':visible'))
	            {
	                if(count <= load_count)
	                {
	                    $(this).show();
	                }

	                count++;
	            }
	        });
		}

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

	}
</script>

