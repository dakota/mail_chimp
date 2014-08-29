<?php
/**
 * Created by PhpStorm.
 * User: Walther
 * Date: 2014-08-17
 * Time: 03:33 PM
 */

App::uses('MailChimpAppController', 'MailChimp.Controller');

class MailListsController extends MailChimpAppController {

/**
 * beforeFilter
 *
 * @return void
 * @access public
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->unlockedActions[] = 'admin_toggle';
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->paginate['MailList']['order'] = $this->MailList->escapeField('created') . ' DESC';
		$this->MailList->recursive = 0;

		$this->set('mailLists', $this->paginate());
		$this->set('displayFields', $this->MailList->displayFields());
	}

/**
 * Toggle mailList status
 *
 * @param string $id MailList id
 * @param integer $status Current mailList status
 * @return void
 */
	public function admin_toggle($id = null, $status = null) {
		$this->Croogo->fieldToggle($this->{$this->modelClass}, $id, $status);
	}

/**
 * Admin add
 *
 * @return void
 * @access public
 */
	public function admin_add() {
		if (!empty($this->request->data)) {
			$this->MailList->create();
			if ($this->MailList->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The MailList has been saved'), 'default', ['class' => 'success']);
				return $this->redirect(['action' => 'index', $this->MailList->id]);
			} else {
				$this->Session->setFlash(__d('croogo', 'The MailList could not be saved. Please, try again.'), 'default', ['class' => 'error']);
			}
		}

		$mailChimp = new Mailchimp(Configure::read('Service.mailChimpKey'));
		$lists = $mailChimp->lists->getList()['data'];
		$lists = Hash::combine($lists, '{n}.id', '{n}.name');

		$this->set('title_for_layout', 'Create a mailList');
		$this->set('lists', $lists);
		$this->render('admin_form');
	}

/**
 * Admin edit
 *
 * @param integer $id
 * @return void
 * @access public
 */
	public function admin_edit($id = null) {
		$this->set('title_for_layout', __d('croogo', 'Edit mailList'));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__d('croogo', 'Invalid mailList'), 'default', ['class' => 'error']);
			return $this->redirect(['action' => 'index']);
		}
		if (!empty($this->request->data)) {
			if ($this->MailList->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The MailList has been saved'), 'default', ['class' => 'success']);
				return $this->Croogo->redirect(['action' => 'edit', $this->MailList->id]);
			} else {
				$this->Session->setFlash(__d('croogo', 'The MailList could not be saved. Please, try again.'), 'default', ['class' => 'error']);
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MailList->read(null, $id);
		}

		$mailChimp = new Mailchimp(Configure::read('Service.mailChimpKey'));
		$lists = $mailChimp->lists->getList()['data'];
		$lists = Hash::combine($lists, '{n}.id', '{n}.name');

		$this->set('lists', $lists);
		$this->set('title_for_layout', 'Edit mailList');
		$this->render('admin_form');
	}

/**
 * Admin delete
 *
 * @param integer $id
 * @return void
 * @access public
 */
	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('croogo', 'Invalid id for mailList'), 'default', ['class' => 'error']);
			return $this->redirect(['action' => 'index']);
		}

		if ($this->MailList->delete($id)) {
			$this->Session->setFlash(__d('croogo', 'MailList deleted'), 'default', ['class' => 'success']);
			return $this->redirect(['action' => 'index']);
		}
	}

	public function view($alias) {
		$list = $this->MailList->findByAlias($alias);

		if (!isset($list['MailList']['id'])) {
			throw new NotFoundException();
		}

		if ($this->request->is('post') && !empty($this->request->data['Subscribe']['email'])) {
			$mailChimp = new Mailchimp(Configure::read('Service.mailChimpKey'));
			$result = $mailChimp->lists->subscribe($list['MailList']['list_id'], [
				'email' => $this->request->data['Subscribe']['email']
			], [
				'FNAME' => $this->request->data['Subscribe']['first_name'],
				'LNAME' => $this->request->data['Subscribe']['surname']
			]);

			if (isset($result['status'])) {
				$this->set('message', [
					'body' => $list['MailList']['error_message'] . ' ' . $result['error'],
					'type' => 'danger'
				]);
			} else {
				$this->set('message', [
					'body' => $list['MailList']['thank_you_message'],
					'type' => 'success'
				]);
			}
		}

		$this->set('list', $list);
		$this->set('title_for_layout', $list['MailList']['title']);
	}
} 