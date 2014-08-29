<?php
class Messages extends CakeMigration {
	/**
	 * Actions to be performed
	 *
	 * @var array $migration
	 * @access public
	 */
	public $migration = [
		'up' => [
			'create_field' => [
				'mail_lists' => [
					'thank_you_message' => [
						'type' => 'text'
					],
					'error_message' => [
						'type' => 'text'
					],
				]
			]
		],
		'down' => [
			'drop_field' => [
				'mail_lists' => [
					'thank_you_message', 'error_message'
				],
			],
		],
	];

}