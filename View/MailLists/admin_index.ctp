<?php
$this->Html
	->addCrumb('', '/admin', ['icon' => 'home'])
	->addCrumb('MailChimp Lists', '/' . $this->request->url);

$this->extend('/Common/admin_index');
?>

<table class="table table-striped">
	<?php
	$tableHeaders = $this->Html->tableHeaders([
			$this->Paginator->sort('id', __d('croogo', 'Id')),
			$this->Paginator->sort('title', __d('croogo', 'Title')),
			$this->Paginator->sort('alias', __d('croogo', 'Alias')),
			$this->Paginator->sort('status', __d('croogo', 'Status')),
			__d('croogo', 'Actions'),
		]);
	?>
	<thead>
	<?php echo $tableHeaders; ?>
	</thead>
	<?php

	$rows = [];
	foreach ($mailLists as $mailList) :
		$actions = [];
		$actions[] = $this->Croogo->adminRowActions($mailList['MailList']['id']);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'edit', $mailList['MailList']['id']],
			['icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item')]
		);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'delete', $mailList['MailList']['id']],
			['icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item')],
			__d('croogo', 'Are you sure?'));
		$actions = $this->Html->div('item-actions', implode(' ', $actions));
		$rows[] = [
			$mailList['MailList']['id'],
			$mailList['MailList']['title'] .
			($mailList['MailList']['status'] == CroogoStatus::PREVIEW ? '<span class="label label-warning">' . __d('croogo', 'preview') . '</span>' : ''),
			$mailList['MailList']['alias'],
			$this->element('admin/toggle', [
				'id' => $mailList['MailList']['id'],
				'status' => (int)$mailList['MailList']['status'],
			]),
			$actions,
		];
	endforeach;

	echo $this->Html->tableCells($rows);
	?>
</table>
