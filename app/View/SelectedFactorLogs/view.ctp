<div class="selectedFactorLogs view">
<h2><?php echo __('Selected Factor Log'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($selectedFactorLog['SelectedFactorLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($selectedFactorLog['User']['name'], array('controller' => 'users', 'action' => 'view', $selectedFactorLog['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Factor'); ?></dt>
		<dd>
			<?php echo $this->Html->link($selectedFactorLog['Factor']['name'], array('controller' => 'factors', 'action' => 'view', $selectedFactorLog['Factor']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($selectedFactorLog['SelectedFactorLog']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($selectedFactorLog['SelectedFactorLog']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($selectedFactorLog['SelectedFactorLog']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Selected Factor Log'), array('action' => 'edit', $selectedFactorLog['SelectedFactorLog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Selected Factor Log'), array('action' => 'delete', $selectedFactorLog['SelectedFactorLog']['id']), null, __('Are you sure you want to delete # %s?', $selectedFactorLog['SelectedFactorLog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Selected Factor Logs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Selected Factor Log'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Factors'), array('controller' => 'factors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Factor'), array('controller' => 'factors', 'action' => 'add')); ?> </li>
	</ul>
</div>
