<?php
/**
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright 2005-2013, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @since         3.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Users table class
 *
 */
class UsersTable extends Table {
	
	protected $_table = 'users';
	
	public $validate = [
        'username' => [
            'rule' => 'notEmpty',
			'message' => 'Por favor, introduzca nombre de usuario'
        ],
        'password' => [
            'rule' => 'notEmpty',
			'message' => 'Por favor, introduzca la contrasena'
        ]
    ];
	
	public function initialize(array $config) {
		/*
		// BelongsTo
		$this->belongsTo('roles');
		*/
	}
	
	/**
	 * beforeSave method
	 *
	 * @param Event $event
	 * @return void
	 */
	public function beforeSave() {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = Security::hash($this->data['User']['password'], 'blowfish');
		} else {
			unset($this->data['User']['password']);
		}
		return true;
	}
	
}