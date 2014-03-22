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

use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Utility\Security;

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
	public function beforeSave(Event $event, Entity $entity) {
		if (!empty($entity->get('password'))) {
			$entity->set('password', Security::hash($entity->get('password'), null, true));
			//$entity->set('password', Security::hash($entity->get('password'), 'blowfish', false));
		}
		return true;
	}
	
}