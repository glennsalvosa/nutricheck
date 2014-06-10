<?php
	$user_info = $this->Session->read('Auth.User');
?>

<div class="users form">
<ul class="breadcrumb">
    <li><?php echo $this->Html->link('User', array('action'=>'index'));?><span class="divider">/</span></li>
    <li class="active">Edit User</li>
</ul>
<?php echo $this->Form->create('User', array('class'=>'form-horizontal'));?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
            echo $this->Form->input('id');
            echo $this->Form->input('name', array('div'=>'control-group',
                'before'=>'<label class="control-label">'.__('Name').'</label><div class="controls">',
                'after'=>$this->Form->error('name', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
                'error' => array('attributes' => array('style' => 'display:none')),
                'label'=>false, 'class'=>'input-xlarge'));
            echo $this->Form->input('email', array('div'=>'control-group', 'readonly'=>true,
                'before'=>'<label class="control-label">'.__('Email').'</label><div class="controls">',
                'after'=>$this->Form->error('email', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
                'error' => array('attributes' => array('style' => 'display:none')),
                'label'=>false, 'class'=>'input-xlarge'));

            echo $this->Form->input('password', array('div'=>'control-group',
                'before'=>'<label class="control-label">'.__('Password').'</label><div class="controls">',
                'after'=>$this->Form->error('password', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
                'error' => array('attributes' => array('style' => 'display:none')),
                'label'=>false, 'class'=>'input-xlarge'));
            echo $this->Form->input('password2', array('div'=>'control-group', 'type'=>'password',
                'before'=>'<label class="control-label">'.__('Confirm Password').'</label><div class="controls">',
                'after'=>$this->Form->error('password2', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
                'error' => array('attributes' => array('style' => 'display:none')),
                'label'=>false, 'class'=>'input-xlarge'));

            echo $this->Form->input('group_id', array('div'=>'control-group',
                'before'=>'<label class="control-label">'.__('Group').'</label><div class="controls">',
                'after'=>'</div>','label'=>false, 'class'=>'input-xlarge'));
				
			if($user_info['group_id'] == 1) {
				echo $this->Form->input('group_id', array('div'=>'control-group',
                'before'=>'<label class="control-label">'.__('Group').'</label><div class="controls">',
                'after'=>'</div>','label'=>false, 'class'=>'input-xlarge'));
			} else {
				echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $user_info['id']));
			}
        ?>
        <div class="form-actions">
            <?php 
             //$disabled = ($this->data['User']['id'] == 1 || $this->data['User']['id'] == 2) ? true : false;
             //if($disabled) echo "<p>Edit `Admin` user temporarily close for demo.Sorry for any inconvenience.</p>";
             echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary', 'div'=>false, 'disabled' =>false ));
?>
            <?php echo $this->Form->reset(__('Cancel'), array('class'=>'btn', 'div'=>false));?>
        </div>
	</fieldset>
<?php echo $this->Form->end();?>
</div>