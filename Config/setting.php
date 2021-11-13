<?php

/**
 * [BcLimitLogin] setting
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLimitLogin
 * @license			MIT
 */

$config['BcLimitLogin'] = [
	// ※ 下記の例は、10分間に5回以上ログイン失敗したらログインを制限する
	'LimitCount' => 5,		// ログイン失敗の回数
	'LimitTime' => 10,		// チェックする時間（分）
];

/**
 * システムナビ
 */
$config['BcApp.adminNavigation'] = [
	'Plugins' => [
		'menus' => [
			'BcLimitLoginHistory' => [
				'title' => __d('baser', 'ログイン履歴'),
				'url' => [
					'admin' => true,
					'plugin' => 'bc_limit_login',
					'controller' => 'bc_limit_logins',
					'action' => 'index'
				]
			],
		]
	],
];

$config['BcApp.adminNavi.BcLimitLogin'] = [
	'name' => 'BcLimitLogin',
	'contents' => [
		[
			'name' => __d('baser', 'ログイン履歴'),
			'url' => [
				'admin' => true,
				'plugin' => 'bc_limit_login',
				'controller' => 'bc_limit_logins',
				'action' => 'index',
			],
		],
	]
];
