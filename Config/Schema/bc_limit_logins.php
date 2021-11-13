<?php
class BcLimitLoginsSchema extends CakeSchema {

	public $file = 'bc_limit_logins.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $bc_limit_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 8, 'unsigned' => false, 'key' => 'primary'),
		'key' => array('type' => 'string', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8, 'unsigned' => false),
		'login_status' => array('type' => 'tinyinteger', 'null' => true, 'default' => '0', 'length' => 2, 'unsigned' => false),
		'ip_address' => array('type' => 'text', 'null' => true, 'default' => null),
		'user_agent' => array('type' => 'text', 'null' => true, 'default' => null),
		'referer' => array('type' => 'text', 'null' => true, 'default' => null),
		'login_data' => array('type' => 'text', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
	);
}
