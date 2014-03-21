<?php
/**
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright 2005-2014, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @since         3.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User entity class used for asserting correct loading
 *
 */
class User extends Entity {

	public function getFullName() {
        return $this->name;
    }
	
}
