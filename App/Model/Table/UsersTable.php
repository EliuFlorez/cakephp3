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
        ],
        'password' => [
            'rule' => 'notEmpty',
        ]
    ];
	
	public function initialize(array $config) {
		/*
		// BelongsTo
		$this->belongsTo('roles');
		*/
	}
	
}