<?php
class MailChimpActivation {

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeActivation(&$controller) {
		return true;
	}

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onActivation(&$controller) {
		App::uses('CroogoPlugin', 'Extensions.Lib');
		$CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('MailChimp');

		// Insert basePath setting for use while hooking clink plugin into ckeditor
		// during bootstrap process.
		$setting = $controller->Setting->find('first', [
			'conditions' => [
				'key' => 'Service.mailChimpKey',
			],
		]);
		if (!$setting) {
			$controller->Setting->create();
			$controller->Setting->save([
				'key' => 'Service.mailChimpKey',
				'value' => '',
				'title' => 'MailChimp API Key',
				'input_type' => 'text',
				'editable' => 1,
				'weight' => 31,
				'params' => '',
			]);
		}
	}

	/**
	 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 *
 * @return boolean
 */
	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		// Remove basePath setting
		$controller->Setting->deleteAll([
			'key' => 'Service.mailChimpKey',
		]);
		$CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->unmigrate('MailChimp');
	}
}