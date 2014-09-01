<div class="selectedFactorLogs form">
<?php echo $this->Form->create('SelectedFactorLog'); ?>
	<fieldset>
		<legend><?php echo __('Edit Selected Factor Log'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('factor_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SelectedFactorLog.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SelectedFactorLog.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Selected Factor Logs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Factors'), array('controller' => 'factors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Factor'), array('controller' => 'factors', 'action' => 'add')); ?> </li>
	</ul>
</div>
