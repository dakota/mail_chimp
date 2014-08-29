<?php
/**
 * Created by PhpStorm.
 * User: Walther
 * Date: 2014-08-17
 * Time: 03:34 PM
 */

App::uses('MailChimpAppModel', 'MailChimp.Model');

class MailList extends MailChimpAppModel {

	public $actsAs = [
		'Croogo.Cached' => [
			'groups' => [
				'lists',
			],
		],
		'Croogo.Trackable',
	];

/**
 * Validation
 *
 * @var array
 * @access public
 */
	public $validate = [
		'title' => [
			'rule' => ['minLength', 1],
			'message' => 'Title cannot be empty.',
		],
		'list_id' => [
			'rule' => 'notempty',
			'message' => 'You need to select a mailing list',
		],
		'alias' => [
			'isUnique' => [
				'rule' => 'isUnique',
				'message' => 'This alias has already been taken.',
			],
			'minLength' => [
				'rule' => ['minLength', 1],
				'message' => 'Alias cannot be empty.',
			],
		],
	];

/**
 * Display fields for this model
 *
 * @var array
 */
	protected $_displayFields = [
		'id',
		'title',
		'alias',
	];
} 