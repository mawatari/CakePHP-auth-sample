<?php
App::uses('AppController', 'Controller');
/**
 * Signup Controller
 *
 * @property User $User
 */
class SignupController extends AppController {

/**
 * @var string
 */
	public $name = 'Signup';

/**
 * @var string
 */
	public $uses = 'User';

/**
 * @var array
 */
	public $components = [
		'Auth' => [
			'authenticate' => [
				'Form' => [
					'fields' => [
						'username' => 'email',
						'password' => 'password'
					]
				]
			],
			'loginRedirect' => [
				'controller' => 'users',
				'action' => 'index'
			],
		]
	];

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * @return CakeResponse
 */
	public function index() {
		if ($this->request->is('post')) {
			$email = $this->request->data['User']['email'];
			$activation_code = md5($email . time());

			// 仮登録中のユーザは既存のレコードを使用
			$user = $this->User->find(
				'first',
				[
					'conditions' => [
						'email'     => $email,
						'is_active' => false
					]
				]
			);

			// 仮登録中でないユーザは新規レコードを作成
			if (!$user) {
				$this->User->create();
				$user = ['User' => $this->request->data['User']];
			}

			$user['User']['is_active']       = false;
			$user['User']['activation_code'] = $activation_code;
			$user['User']['password'] = $this->request->data['User']['password'];

			if ($this->User->save($user)) {
				// メール送信処理
				// 省略
				// かわりにリンクを表示
				$this->set('activation_code', $activation_code);

				return $this->render('finished');
			}
		}

		return $this->render();
	}

/**
 * @param $activation_code
 * @return CakeResponse|void
 */
	public function activate($activation_code) {
		$errors = [];

		// アクティベーションコードが正しいものか確認
		$user = $this->User->find(
			'first',
			[
				'conditions' => [
					'activation_code' => $activation_code,
					'is_active' => false
				]
			]
		);
		if (!$user) {
			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is('post')) {
			// 認証情報が正しければアクティベーション
			if ($this->Auth->login()) {
				$this->User->id = $user['User']['id'];
				$this->User->set('is_active', true);
				$this->User->save();
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$errors[] = 'メールアドレスかパスワードが違います。';
			}
		}

		$this->set('errors', $errors);
		return $this->render();
	}
}
