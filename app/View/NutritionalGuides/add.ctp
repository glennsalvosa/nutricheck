<div class="nutritionalGuides form">
<?php echo $this->Form->create('NutritionalGuide'); ?>
	<fieldset>
		<legend><?php echo __('Add Nutritional Guide'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('description', array('class' => 'ckeditor'));
		echo $this->Form->input('nutritional_guide_type_id', array('options' => $nutritional_guide_types));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<?php /*
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Nutritional Guides'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Users'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
*/ ?>
