<?php

/**
 * [BcLoginHisoty] BcLimitLoginsController
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLoginHisoty
 * @license			MIT
 */
class BcLimitLoginsController extends AppController {

	/**
	 * モデル
	 *
	 * @var array
	 */
	public $uses = [
		'BcLimitLogin.BcLimitLogin',
	];

	/**
	 * コンポーネント
	 *
	 * @var array
	 */
	public $components = [
		'BcAuth',
		'Cookie',
		'BcAuthConfigure',
	];

	/**
	 * beforeFilter
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * beforeRender
	 *
	 * @return void
	 */
	public function beforeRender() {
		parent::beforeRender();
	}

	/**
	 * [ADMIN] 一覧表示
	 *
	 * @return void
	 */
	public function admin_index() {

		$default = ['named' => [
			'num' => $this->siteConfigs['admin_list_num'],
			'sort' => 'id',
			'direction' => 'desc',
		]];
		$this->setViewConditions($this->modelClass, ['group' => 'BcLimitLogin', 'default' => $default]);

		$conditions = $this->_createAdminIndexConditions($this->request->data);

		if (strpos($this->passedArgs['sort'], '.') === false) {
			$order = $this->modelClass . '.' . $this->passedArgs['sort'];
		}
		if ($order && $this->passedArgs['direction']) {
			$order .= ' ' . $this->passedArgs['direction'];
		}

		$options = [
			'fields' => [],
			'conditions' => $conditions,
			'order' => $order,
			'limit' => $this->passedArgs['num'],
			'recursive' => -1,
			'cache' => false,
		];

		$this->paginate = $options;
		$posts = $this->paginate($this->modelClass);
		$this->set('posts', $posts);

		$this->_setAdminIndexViewData();

		if ($this->request->is('ajax') || !empty($this->request->query['ajax'])) {
			$this->render('ajax_index');
			return;
		}

		$this->pageTitle = __d('baser', 'ログイン履歴');
		$this->search = 'bc_limit_logins_index';
		$this->help = 'bc_limit_logins_index';
	}

	/**
	 * [ADMIN] 一覧の表示用データをセットする
	 *
	 * @return void
	 */
	protected function _setAdminIndexViewData() {

		$this->set('users', $this->User->getUserList());
		$this->set('loginStatus', $this->BcLimitLogin->loginStatus);
	}

	/**
	 * [ADMIN] ページ一覧用の検索条件を生成する
	 *
	 * @param int $bcLimitLoginContentId
	 * @return array $conditions
	 */
	protected function _createAdminIndexConditions($data) {

		unset($data['_Token']);
		unset($data['ListTool']);

		// 条件指定のないフィールドを解除
		if (!empty($data[$this->modelClass])) {
			foreach ($data[$this->modelClass] as $key => $value) {
				if (trim($value) === '') {
					unset($data[$this->modelClass][$key]);
				}
			}
		}

		$conditions = [];

		if (isset($data[$this->modelClass]['user_id'])) {
			$conditions[$this->modelClass . '.user_id'] = $data[$this->modelClass]['user_id'];
		}

		if (isset($data[$this->modelClass]['login_status'])) {
			$conditions[$this->modelClass . '.login_status'] = $data[$this->modelClass]['login_status'];
		}

		if (isset($data[$this->modelClass]['searh_text'])) {
			$searchText = h(trim($data[$this->modelClass]['searh_text']));
			$conditions['OR'] =
				[
					$this->modelClass . '.ip_address LIKE' => '%' . $searchText . '%',
					$this->modelClass . '.user_agent LIKE' => '%' . $searchText . '%',
				];
		}

		return $conditions;
	}

	/**
	 * [ADMIN] 詳細表示処理
	 *
	 * @param int $id
	 * @return void
	 */
	public function admin_view($id) {

		if (!$id) {
			$this->BcMessage->setError(__d('baser', '無効な処理です。'));
			$this->redirect(['action' => 'index']);
		}

		$this->{$this->modelClass}->recursive = -1;
		$this->request->data = $this->{$this->modelClass}->find('first', [
			'conditions' => [
				$this->modelClass . '.id' => $id,
			],
		]);
		if (!$this->request->data) {
			$this->BcMessage->setError(__d('baser', '無効な処理です。'));
			$this->redirect(['action' => 'index']);
		}

		// 表示設定
		$this->_setAdminFormViewData();

		$this->crumbs[] = [
			'name' => __d('baser', 'ログイン履歴'),
			'url' => [
				'action' => 'index',
			]
		];

		$this->pageTitle = __d('baser', 'ログイン履歴詳細');
		$this->render('view');
	}

	/**
	 * [ADMIN] 詳細画面表示用データをセットする
	 *
	 * @return void
	 */
	protected function _setAdminFormViewData() {

		$this->set('users', $this->User->getUserList());
		$this->set('loginStatus', $this->BcLimitLogin->loginStatus);
	}

	/**
	 * [ADMIN] 削除処理　(ajax)
	 *
	 * @param int $id
	 * @return void
	 */
	public function admin_ajax_delete($id = null) {

		$this->_checkSubmitToken();
		if (!$id) {
			$this->ajaxError(500, __d('baser', '無効な処理です。'));
		}

		// 削除実行
		if ($this->_del($id)) {
			clearViewCache();
			exit(true);
		}

		exit();
	}

	/**
	 * 一括削除
	 *
	 * @param array $ids
	 * @return boolean
	 */
	protected function _batch_del($ids) {

		if ($ids) {
			foreach ($ids as $id) {
				$this->_del($id);
			}
		}

		return true;
	}

	/**
	 * データを削除する
	 *
	 * @param int $id
	 * @return boolean
	 */
	protected function _del($id) {

		// メッセージ用にデータを取得
		$post = $this->{$this->modelClass}->read(null, $id);

		// 削除実行
		if ($this->{$this->modelClass}->delete($id)) {
			// ログを記録する

			// $this->BcMessage->setSuccess(
			// 	sprintf(
			// 		__d('baser', 'ログイン履歴： No.%s を削除しました。(一括削除)'),
			// 		$post[$this->modelClass]['id']
			// 	),
			// 	true,
			// 	false
			// );
			// ↑ 複数のログが記録されない為 ↓ 直接、保存処理を記述（コアのバグ？）
			$Dblog = ClassRegistry::init('Dblog');
			$logdata['Dblog']['name'] = sprintf(
				__d('baser', 'ログイン履歴： No.%s を削除しました。(一括削除)'),
				$post[$this->modelClass]['id']
			);
			$logdata['Dblog']['user_id'] = @$_SESSION['Auth'][Configure::read('BcAuthPrefix.admin.sessionKey')]['id'];
			$Dblog->create($logdata);
			$Dblog->save($logdata);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * [ADMIN] 削除処理
	 *
	 * @param int $id
	 * @return void
	 */
	public function admin_delete($id = null) {

		$this->_checkSubmitToken();

		if (!$id) {
			$this->BcMessage->setError(__d('baser', '無効な処理です。'));
			$this->redirect(['action' => 'index']);
		}

		// メッセージ用にデータを取得
		$post = $this->{$this->modelClass}->read(null, $id);

		// 削除実行
		if ($this->{$this->modelClass}->delete($id)) {
			clearViewCache();
			$this->BcMessage->setSuccess(
				sprintf(
					__d('baser', 'ログイン履歴： No.%s を削除しました。'),
					$post[$this->modelClass]['id']
				)
			);
		} else {
			$this->BcMessage->setError(__d('baser', 'データベース処理中にエラーが発生しました。'));
		}

		$this->redirect(['action' => 'index']);
	}
}
