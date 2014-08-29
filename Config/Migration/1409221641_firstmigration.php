<?php
class Firstmigration extends CakeMigration {
	/**
	 * Actions to be performed
	 *
	 * @var array $migration
	 * @access public
	 */
	public $migration = [
		'up' => [
			'create_table' => [
				'mail_lists' => [
					'id' => ['type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'],
					'title' => ['type' => 'string', 'length' => 255, 'null' => true],
					'alias' => ['type' => 'string', 'length' => 255, 'null' => true],
					'body' => ['type' => 'text'],
					'list_id' => ['type' => 'string'],
					'status' => ['type' => 'integer', 'length' => 1, 'null' => false, 'default' => 0],
					'created' => ['type' => 'timestamp', 'null' => true],
					'created_by' => [
						'type' => 'integer',
					],
					'modified' => ['type' => 'timestamp', 'null' => true],
					'updated_by' => [
						'type' => 'integer',
					],
					'indexes' => ['PRIMARY' => ['column' => 'id', 'unique' => 1], 'alias' => ['column' => 'alias', 'unique' => 1]],
					'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDb']
				]
			]
		],
		'down' => [
			'drop_table' => [
				'mail_lists'
			],
		],
	];
} 