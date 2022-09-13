<div class="users form">
    <fieldset>
        <legend><?php echo __('View Profile'); ?></legend>
    </fieldset>

    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <table>
                <tr>
                    <td width="150">
                        <?php echo $this->Html->image($profile['Profile']['profile_pic_path'] ? $profile['Profile']['profile_pic_path'] : 'profile/blank-profile.jpeg', array('width' => '150px','alt'=>'profile')); ?>
                    </td>
                    <td>
                        <h3><?php echo $profile['User']['name'] ?></h3>
                        <h4>Gender: <?php echo $profile['Profile']['gender'] == 0 ? 'Male' : 'Female' ?></h4>
                        <h4>Birthdate: <?php echo $profile['Profile']['birthdate'] ? date('F d, Y',strtotime($profile['Profile']['birthdate'])) : '' ?></h4>
                        <h4>Joined: <?php echo date('F d, Y ha',strtotime($profile['User']['created'])) ?></h4>
                        <h4>Last Login: <?php echo date('F d, Y ha',strtotime($profile['User']['last_login'])) ?> </h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h3>Hubby</h3>
                        <p><?php echo $profile['Profile']['hubby'] ?></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

