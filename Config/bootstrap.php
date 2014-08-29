<?php
CroogoCache::config('mailchimp_lists', array_merge(
		Configure::read('Cache.defaultConfig'),
		array('groups' => array('lists'))
	));

CroogoNav::add('contacts.children.mailchimp', array(
    'title' => 'MailChimp lists',
	'url' => array(
		'admin' => true,
		'plugin' => 'mail_chimp',
		'controller' => 'mail_lists',
		'action' => 'index',
	),
	'weight' => 60
));
