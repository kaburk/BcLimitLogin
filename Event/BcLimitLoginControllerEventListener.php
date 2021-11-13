<?php

/**
 * [BcLoginHisoty] ControllerEventListener
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLoginHisoty
 * @license			MIT
 */
class BcLimitLoginControllerEventListener extends BcControllerEventListener {

	public $events = array(
		'Users.beforeLogin',
		'Users.afterLogin',
		'Users.beforeLogout',
		'Users.afterAgentLogin',
		'Users.beforeBackAgent',
	);

	public function __construct() {
		parent::__construct();

		$this->BcLimitLogin = ClassRegistry::init('BcLimitLogin.BcLimitLogin');

		App::uses('BcBaserHelper', 'View/Helper');
		$this->BcBaser = new BcBaserHelper(new View());
	}

	/**
	 * usersBeforeLogin
	 *
	 * @param CakeEvent $event
	 */
	public function usersBeforeLogin(CakeEvent $event) {

		$Controller = $event->subject();
		$key = $Controller->Session->id();
		$ipAddress = $Controller->request->clientIp(false);

		if (isset($event->data['user']['User'])) {
			// ログイン前情報を記録
			$data = [];
			$data['BcLimitLogin']['key'] = $key;
			$data['BcLimitLogin']['user_id'] = null;
			$data['BcLimitLogin']['login_status'] = 0;
			$data['BcLimitLogin']['ip_address'] = $ipAddress;
			$data['BcLimitLogin']['user_agent'] = $Controller->request->header('User-Agent');
			$data['BcLimitLogin']['referer'] = $Controller->referer();
			$data['BcLimitLogin']['login_data'] = json_encode($event->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			$this->BcLimitLogin->create($data);
			$this->BcLimitLogin->save($data);

			// ログイン履歴を取得
			$limitCount = Configure::read('BcLimitLogin.LimitCount');
			$limitMonth = (int) Configure::read('BcLimitLogin.LimitMonth');
			$count = $this->BcLimitLogin->find('count', [
				'conditions' => [
					'key' => $key,
					'ip_address' => $ipAddress,
					'login_status' => 0,
					'modified >=' => date('Y-m-d H:i:s', strtotime(($limitMonth * -1) . ' minutes')),
				],
				'recursive' => -1,
			]);
			// 一定数のミスでログインを制限
			if ($count > $limitCount) {
				$Controller->BcMessage->setError(
					__d(
						'baser',
						'入力を一定回数誤った為ログイン制限しております。しばらくしてからアクセスしてください。'
					)
				);
				return false;
			}
		}
		return true;
	}

	/**
	 * usersAfterLogin
	 *
	 * @param CakeEvent $event
	 */
	public function usersAfterLogin(CakeEvent $event) {

		$Controller = $event->subject();
		$key = $Controller->Session->id();
		$ipAddress = $Controller->request->clientIp(false);

		$data = $this->BcLimitLogin->find('first', [
			'conditions' => [
				'key' => $key,
				'ip_address' => $ipAddress,
				'login_status' => 0,
			],
			'recursive' => -1,
		]);

		// ログイン後情報を記録
		$data['BcLimitLogin']['user_id'] = $event->data['user']['id'];
		$data['BcLimitLogin']['login_status'] = 1;
		$data['BcLimitLogin']['ip_address'] = $ipAddress;
		$data['BcLimitLogin']['user_agent'] = $Controller->request->header('User-Agent');
		$data['BcLimitLogin']['referer'] = $Controller->referer();
		$data['BcLimitLogin']['login_data'] = json_encode($event->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$this->BcLimitLogin->set($data);
		$this->BcLimitLogin->save($data);

		// 「最近の動き」にログインしたことを記録する
		$userName = $this->BcBaser->getUserName($event->data['user']);
		$userId = $event->data['user']['name'];
		$Controller->BcMessage->setSuccess(
			__d(
				'baser',
				'%s（%s）がログインしました。',
				$userName,
				$userId
			),
			true,
			false
		);

		return true;
	}

	/**
	 * usersBeforeLogout
	 *
	 * @param CakeEvent $event
	 */
	public function usersBeforeLogout(CakeEvent $event) {

		$Controller = $event->subject();
		$key = $Controller->Session->id();
		$ipAddress = $Controller->request->clientIp(false);

		// ログアウト情報を記録
		$data = [];
		$data['BcLimitLogin']['key'] = $key;
		$data['BcLimitLogin']['user_id'] = $event->data['user']['id'];
		$data['BcLimitLogin']['login_status'] = 2;
		$data['BcLimitLogin']['ip_address'] = $ipAddress;
		$data['BcLimitLogin']['user_agent'] = $Controller->request->header('User-Agent');
		$data['BcLimitLogin']['referer'] = $Controller->referer();
		$data['BcLimitLogin']['login_data'] = json_encode($event->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$this->BcLimitLogin->create($data);
		$this->BcLimitLogin->save($data);

		// 「最近の動き」にログアウトしたことを記録する
		$userName = $this->BcBaser->getUserName($event->data['user']);
		$userId = $event->data['user']['name'];
		$Controller->BcMessage->setSuccess(
			__d(
				'baser',
				'%s（%s）がログアウトしました。',
				$userName,
				$userId
			),
			true,
			false
		);

		return true;
	}

	/**
	 * usersAfterAgentLogin
	 *
	 * @param CakeEvent $event
	 */
	public function usersAfterAgentLogin(CakeEvent $event) {

		$Controller = $event->subject();

		// 「最近の動き」に代理ログインしたことを記録する
		$beforeUserName = $this->BcBaser->getUserName($event->data['beforeUser']);
		$beforeUserId = $event->data['beforeUser']['name'];
		$afterUserName = $this->BcBaser->getUserName($event->data['afterUser']);
		$afterUserId = $event->data['afterUser']['name'];
		$Controller->BcMessage->setSuccess(
			__d(
				'baser',
				'%s（%s）が %s（%s）に代理ログインしました。',
				$beforeUserName,
				$beforeUserId,
				$afterUserName,
				$afterUserId
			),
			true,
			false
		);

		return true;
	}

	/**
	 * usersBeforeBackAgent
	 *
	 * @param CakeEvent $event
	 */
	public function usersBeforeBackAgent(CakeEvent $event) {

		$Controller = $event->subject();

		// 「最近の動き」に代理ログインから戻ったことを記録する
		$beforeUserName = $this->BcBaser->getUserName($event->data['beforeUser']);
		$beforeUserId = $event->data['beforeUser']['name'];
		$afterUserName = $this->BcBaser->getUserName($event->data['afterUser']);
		$afterUserId = $event->data['afterUser']['name'];
		$Controller->BcMessage->setSuccess(
			__d(
				'baser',
				'代理ログイン %s（%s）から %s（%s）に戻りました。',
				$beforeUserName,
				$beforeUserId,
				$afterUserName,
				$afterUserId
			),
			true,
			false
		);
		return true;
	}
}
