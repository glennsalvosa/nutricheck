<?php
	$user_info = $this->request->data['User'];
?>

<div class="users form">
<?php echo $this->Form->create('User', array('class'=>'form-horizontal'));?>
	<fieldset>
		<legend><?php echo __('Profile Information'); ?></legend>
			
			<?php echo $this->Form->input('UserProfile.id'); ?>
			<?php echo $this->Form->input('User.id'); ?>
			
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.first_name', array('div' => false, 'placeholder' => 'Firstname')); ?></div>
			
			<?php /*
				<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.middle_name', array('div' => false, 'placeholder' => 'Middlename')); ?></div>
			*/ ?>
			
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.last_name', array('div' => false, 'placeholder' => 'Lastname')); ?></div>
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.contact', array('type' => 'text', 'div' => false, 'placeholder' => 'Contact Number', 'label' => 'Contact Number')); ?></div>
			
			<?php if($user_info['group_id'] != 3) { ?>
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.company', array('type' => 'text', 'div' => false, 'placeholder' => 'Company', 'label' => 'Company')); ?></div>
			<?php } ?>
			
			<?php if($user_info['group_id'] == 3) { ?>
				<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.age', array('type' => 'text', 'div' => false, 'placeholder' => 'Age')); ?></div>
				<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.birthday', array('type' => 'text', 'div' => false, 'class' => 'hasDatepicker', 'id' => 'datepicker', 'placeholder' => 'Birthday')); ?></div>
				<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.nationality', array('type' => 'text', 'div' => false, 'placeholder' => 'Nationality')); ?></div>
			<?php } ?>
			
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.zip', array('type' => 'text', 'div' => false, 'placeholder' => 'Zip')); ?></div>
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.address', array('type' => 'text', 'div' => false, 'placeholder' => 'Address')); ?></div>
			
			<div class="left span12 inputHolder"><?php echo $this->Form->input('UserProfile.gender', array('div' => false, 'empty' => 'Gender', 'options' => array('male' => 'Male', 'female' => 'Female'))); ?></div>
									
			<br /><br />
			<div class="left span12 inputHolder"><?php echo $this->Form->input('User.email', array('div' => false, 'placeholder' => 'Email', 'readonly' => true)); ?></div>
			<div class="left span12 inputHolder"><?php echo $this->Form->input('User.password', array('div' => false, 'placeholder' => 'Password')); ?></div>
			<div class="left span12 inputHolder"><?php echo $this->Form->input('User.password2', array('type' => 'password', 'div' => false, 'placeholder' => 'Repeat Password', 'label' => 'Repeat Password')); ?></div>			

        <div class="left span12">
            <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary', 'div'=>false, 'disabled' =>false )); ?>
            <?php echo $this->Form->reset(__('Cancel'), array('class'=>'btn', 'div'=>false));?>
        </div>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<script>
	$(document).ready( function () {
		
		$( "#datepicker" ).datepicker();
		
		$('#UserEditProfileForm').submit( function () {
			var user_password = $('#UserPassword').val();
			var user_password2 = $('#UserPassword2').val();
			
			if((user_password !== "") && (user_password2 === "")) {
				$('#UserPassword2').addClass('required');
				alert('Please repeat your password to continue');
				return false;
			} else {
				$('#UserPassword2').removeClass('required');
			}
			
			if((user_password !== "") && (user_password2 !== "")) {
				if(user_password !== user_password2) {
					alert('Passwords mismatch');
					return false;
				}
			}
		});
	});
</script>