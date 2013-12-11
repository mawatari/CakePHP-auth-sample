<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property user $user
 */
class UsersController extends AppController {

/**
 * @var string
 */
	public $name = 'Users';

/**
 * @var string
 */
	public $uses = 'User';

/**
 * Components
 *
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
			'loginAction' => [
				'action' => 'login'
			],
			'loginRedirect' => [
				'action' => 'index'
			],
			'logoutRedirect' => [
				'action' => 'login'
			]
		]
	];

/**
 * @return CakeResponse
 */
	public function index() {
		return $this->render();
	}

/**
 * @return CakeResponse|void
 */
	public function login() {
		$errors = [];

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$errors[] = 'メールアドレスかパスワードが違います。';
			}
		}
		$this->set('errors', $errors);
		return $this->render();
	}

/**
 * @return void
 */
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
} 