<?php
App::uses('AppModel', 'Model');
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
	];

}
