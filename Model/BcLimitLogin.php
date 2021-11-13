<?php

/**
 * [BcLimitLogin] BcLimitLogin model
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLimitLogin
 * @license			MIT
 */
class BcLimitLogin extends AppModel {

	public $loginStatus = [
		'0' => '未ログイン',
		'1' => 'ログイン',
		'2' => 'ログアウト',
	];
}
