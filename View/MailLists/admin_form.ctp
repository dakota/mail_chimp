<?php
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', ['icon' => 'home'])
	->addCrumb('MailChimp Lists', ['action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html
		->addCrumb($this->request->data['MailList']['title'], '/' . $this->request->url);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html
		->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('MailList');

?>
<div class="<?php echo $this->Layout->cssClass('row'); ?>">
	<div class="<?php echo $this->Layout->cssClass('columnLeft'); ?>">

		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Mail List'), '#basic');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">

			<div id="basic" class="tab-pane">
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('title', [
					'label' => __d('croogo', 'Title'),
				]);
				echo $this->Form->input('alias', [
					'label' => __d('croogo', 'Alias'),
				]);
				echo $this->Form->input('body', [
					'label' => __d('croogo', 'Body'),
				]);
				echo $this->Form->input('thank_you_message', [
					'label' => __d('croogo', 'Thank you message'),
				]);
				echo $this->Form->input('error_message', [
					'label' => __d('croogo', 'Error message'),
				]);
				echo $this->Form->input('list_id', [
					'empty' => 'Select a mailing list',
					'label' => __d('croogo', 'MailChimp list'),
				]);
			?>
			</div>

			<?php echo $this->Croogo->adminTabs(); ?>
		</div>
	</div>

	<div class="<?php echo $this->Layout->cssClass('columnRight'); ?>">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']) .
			$this->Form->button(__d('croogo', 'Save'), ['button' => 'success']) .
			$this->Html->link(
				__d('croogo', 'Cancel'),
				['action' => 'index'],
				['button' => 'danger']
			) .
			$this->Form->input('status', [
					'legend' => false,
					'type' => 'radio',
					'class' => false,
					'label' => true,
					'default' => CroogoStatus::UNPUBLISHED,
					'options' => $this->Croogo->statuses(),
				]) .
			$this->Html->endBox();

		echo $this->Croogo->adminBoxes();
	?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
