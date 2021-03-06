<div class="answers index">
	<h2><?php echo __('Answers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('users_id'); ?></th>
			<th><?php echo $this->Paginator->sort('questions_id'); ?></th>
			<th><?php echo $this->Paginator->sort('performed_checks_id'); ?></th>
			<th><?php echo $this->Paginator->sort('choice_id'); ?></th>
			<th><?php echo $this->Paginator->sort('rank'); ?></th>
			<th><?php echo $this->Paginator->sort('answer'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($answers as $answer): ?>
	<tr>
		<td><?php echo h($answer['Answer']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($answer['Users']['id'], array('controller' => 'users', 'action' => 'view', $answer['Users']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($answer['Questions']['id'], array('controller' => 'questions', 'action' => 'view', $answer['Questions']['id'])); ?>
		</td>
		<td><?php echo h($answer['Answer']['performed_checks_id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($answer['Choice']['title'], array('controller' => 'choices', 'action' => 'view', $answer['Choice']['id'])); ?>
		</td>
		<td><?php echo h($answer['Answer']['rank']); ?>&nbsp;</td>
		<td><?php echo h($answer['Answer']['answer']); ?>&nbsp;</td>
		<td><?php echo h($answer['Answer']['created']); ?>&nbsp;</td>
		<td><?php echo h($answer['Answer']['modified']); ?>&nbsp;</td>
		<td><?php echo h($answer['Answer']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $answer['Answer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $answer['Answer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $answer['Answer']['id']), null, __('Are you sure you want to delete # %s?', $answer['Answer']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Answer'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Users'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Questions'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Choices'), array('controller' => 'choices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Choice'), array('controller' => 'choices', 'action' => 'add')); ?> </li>
	</ul>
</div>
