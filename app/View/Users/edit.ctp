<div class="users form">
<?php echo $this->Form->create('Profile',array('enctype'=>'multipart/form-data')); ?>
    <fieldset>
        <legend><?php echo __('Edit Profile'); ?></legend>
        <?php echo $this->Html->image($profile['Profile']['profile_pic_path'] ? $profile['Profile']['profile_pic_path'] : 'profile/blank-profile.jpeg', array('width' => '200px','alt'=>'profile','id'=>'preview')); ?>
        <?php echo $this->Form->file('picture',['type'=>'file','accept'=>'image/*','onchange'=>"document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"]) ?>
        <?php echo $this->Form->input('name',array('value'=>$profile['User']['name'])); ?>
        <?php echo $this->Form->input('date',array('value'=>$profile['Profile']['birthdate'], 'label'=>'Birthdate')); ?>
        <?php
        echo $this->Form->input('gender', array(
                'options' => array('Male', 'Female'),
                'type' => 'radio',
                'value' => $profile['Profile']['gender']
            ));
        ?>
        <?php echo $this->Form->input('hubby',array('value'=>$profile['Profile']['hubby'],'type'=>'textarea')); ?>
        <?php echo $this->Form->end(__('Update')); ?>
    </fieldset>
</div>

<script type="text/javascript">
    $(document).ready(function(){
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

    $(function() {
        $("#ProfileDate").datepicker();
    });

    $(".gender").change(function () {        
        $('[type=radio]:checked').prop('checked', false);
        $(this).prop('checked', 'checked');        
    });

    $("form").on("submit", function(event){
        var name = $('#ProfileName');
        var validatedName = allLetter(name.val());

        var birthdate = $('#ProfileDate');
        var validatedBirthdate = checkBirthdate(birthdate.val());

        var gender = $('#ProfileGender');
        var validatedGender = checkGender(gender.val());

        var hubby = $('#ProfileHubby');
        var validatedHubby = checkHubby(hubby.val());

        if(!validatedName.status)
        {
            name.parent().attr('class','required error');
            name.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedName.message,
                insertAfter: name,
            });
        }else{
            name.next('div').remove();
            name.parent().removeClass().addClass('required');
        }

        if(!validatedBirthdate.status)
        {
            birthdate.parent().attr('class','required error');
            birthdate.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedBirthdate.message,
                insertAfter: birthdate,
            });
        }else{
            birthdate.next('div').remove();
            birthdate.parent().removeClass().addClass('required');
        }

        if(!validatedGender.status)
        {
            gender.parent().attr('class','required error');
            gender.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedGender.message,
                insertAfter: gender,
            });
        }else{
            gender.next('div').remove();
            gender.parent().removeClass().addClass('required');
        }

        if(!validatedHubby.status)
        {
            hubby.parent().attr('class','required error');
            hubby.next('div').remove();

            $("<div>", {
                class: "error-message", 
                text: validatedHubby.message,
                insertAfter: hubby,
            });
        }else{
            hubby.next('div').remove();
            hubby.parent().removeClass().addClass('required');
        }

        if($('.error-message').length){
            event.preventDefault();
        }
    });

    function allLetter(name)
    { 
        var letters = /^[A-Za-z ]+$/;
        if(!name)
        {
            return {'status':false,'message':'Name is required'};
        }
        else if(name.length < 5)
        {
            return {'status':false,'message':'Name must have a mimimum of 5 characters'};
        }
        else if(name.length > 20)
        {
            return {'status':false,'message':'Name must have a maximum of 20 characters'};
        }else if(letters.test(name))
        {
            return {'status':true,'message':''};
        }
        else
        {
            return {'status':false,'message':'Name must have alphabet characters only'};
        }
    }

    function checkGender(gender)
    {
        if(gender)
        {
            return {'status':true,'message':''};
        }else{
            return {'status':false,'message':'Gender is required'};
        }
    }

    function checkHubby(hubby)
    {
        if(hubby)
        {
            return {'status':true,'message':''};
        }else{
            return {'status':false,'message':'Hubby is required'};
        }
    }
    function checkBirthdate(birthdate)
    {
        if(birthdate)
        {
            return {'status':true,'message':''};
        }else{
            return {'status':false,'message':'Birthdate is required'};
        }
    }
</script>
