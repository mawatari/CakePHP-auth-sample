<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * @var string
 */
	public $name = 'User';

/**
 * @var string
 */
	public $useTable = 'users';

/**
 * @var array
 */
	public $actsAs = ['Containable', 'MyValidationRule'];

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = [
		'email' => [
			[
				'rule' => 'notEmptyMb',
				'message' => 'メールアドレスを入力してください。'
			],
			[
				'rule' => ['custom', '/^.+@.+$/'],
				'message' => '形式が正しくありません。'
			],
			[
				'rule' => 'isUniqueAndActive',
				'message' => '既に使用されています。'
			]
		],
		'password' => [
			[
				'rule'    => 'notEmptyMb',
				'message' => 'パスワードを入力してください。'
			],
			[
				'rule'    => ['custom', '/^[a-zA-Z0-9]+$/'],
				'message' => '半角英数字で入力してください。'
			],
		]
	];

/**
 * @param $check
 * @return bool
 */
	public function isUniqueAndActive($check) {
		foreach ($check as $key => $value) {
			$count = $this->find(
				'count',
				[
					'conditions' => [
						$key => $value,
						'is_active' => true
					],
					'recursive' => -1
				]
			);
			if ($count != 0) {
				return false;
			}
		}
		return true;
	}

	public function beforeSave($options = []) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}
}
