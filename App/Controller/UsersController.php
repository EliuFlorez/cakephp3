<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2014, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2014, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP Project
 * @since         CakePHP(tm) v 3.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace App\Controller;

/// App Controller
use App\Controller\AppController;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Component\SessionComponent;
use Cake\Controller\Component\Auth\FormAuthenticate;
use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Error;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Session;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Routing\Dispatcher;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * UsersController class
 *
 */
class UsersController extends AppController {
	
	// Components
	public $components = [
		'Auth' => [
			'authenticate' => [
				'Form' => [
					'userModel' => 'Users',
					'scope' => ['User.is_active' => true],
					'fields' => ['username' => 'email']
				],
			],
			'loginAction' => [
				'controller' => 'users', 'action' => 'login'
			],
			'loginRedirect' => [
				'controller' => 'pages', 'action' => 'display'
			],
            'logoutRedirect' => [
				'controller' => 'pages', 'action' => 'display', 'home'
			],
			'authorize' => ['Controller']
		],
		'Session',
		'RequestHandler'
	];
	
	/**
	 * This controller uses Users models
	 *
	 * @var array
	 */
	public $uses = [
		'User',
	];
	
	/**
	 * beforeFilter method
	 *
	 * @param Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		// Allow
		$this->Auth->allow();
	}
	
	/**
	 * Articles index method
	 *
	 * @return void
	 */
	public function index() { 
		
	}
	
	/**
	 * Used to logged in the site
	 *
	 * @access public
	 * @return void
	 */
	public function login() {
		// Title
		$this->set('title_for_layout', 'Iniciar sesion');
		
		// Users Auth
		if ($this->Auth->user('id')) {
			$this->redirect('/');
		}
		
		$user = $this->Users->newEntity($this->request->data);
		
		// POST, PUT
		//if ($this->request->is(['post', 'put'])) {
			
			// Request Data
			if(!empty($this->request->data['username']) && !empty($this->request->data['password'])){
				$this->Auth->request->data = array(
					'Users' => array(
						'username' => $this->request->data['username'],
						'password' => Security::hash($this->request->data['password'], null, true)
						//'password' => Security::hash($this->request->data['password'], 'blowfish', false)
					)
				);
			} else {
				unset($this->request->data['password']);
			}
			
			// Validar
			$this->Auth->request->data = array(
				'Users' => array(
					'username' => 'demo',
					'password' => Security::hash('demo', null, true)
				)
			);
			
			echo '$this->Auth->request->data = return ';
			print_r($this->Auth->request->data);
			
			echo '<br/><br/>';
			
			echo '$this->request->data = return';
			print_r($this->request->data);
			
			echo '<br/><br/>';
			
			echo '$this->Auth->login() = return ';
			echo ($this->Auth->login()) ? 'true' : 'false';
			
			echo '<br/><br/>';
			
			echo '$this->Auth->login($this->request->data) return ';
			echo ($this->Auth->login($this->request->data)) ? 'true' : 'false';
			
			echo '<br/><br/>';
			
			echo '$this->Auth->logout() return ';
			print_r($this->Auth->logout());
			
			echo '<br/><br/>';
			echo '<br/><br/>';
			
			// Invalido
			$this->Auth->request->data = array(
				'Users' => array(
					'username' => 'demo',
					'password' => Security::hash('demo0000', null, true)
				)
			);
			
			echo '$this->Auth->request->data = return ';
			print_r($this->Auth->request->data);
			
			echo '<br/><br/>';
			
			echo '$this->request->data = return';
			print_r($this->request->data);
			
			echo '<br/><br/>';
			
			echo '$this->Auth->login() = return ';
			echo ($this->Auth->login()) ? 'true' : 'false';
			
			echo '<br/><br/>';
			
			echo '$this->Auth->login($this->request->data) return ';
			echo ($this->Auth->login($this->request->data)) ? 'true' : 'false';
			
			echo '<br/><br/>';
			
			echo '$this->Auth->logout() return ';
			print_r($this->Auth->logout());
			
			die();
			
			//Auth Login
			if ($this->Auth->login()) {
				// Redirects
				$this->redirect('/articles');
			} else {
				// Flash Message
				$this->Session->setFlash('Nombre de usuario o contraseña invalido');
			}
        //}
		
		$this->set('user', $user);
	}
	
	/**
	 * Used to logged out from the site
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	/**
	 * Users add method
	 *
	 * @return void
	 */
    public function add() {
        // Title
		$this->set('title_for_layout', 'Registro');
		
		// Users Auth
		if ($this->Auth->user('id')) {
			$this->redirect('/');
		}
		
		// Entity
		$user = $this->Users->newEntity($this->request->data);
		
		// POST
		if ($this->request->is(['post', 'put'])) {
			if ($this->Users->save($user)) {
                $this->Session->setFlash(__('Your user has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Session->setFlash(__('Unable to add your user.'));
        }
		
		$this->set('user', $user);
    }
	
	/**
	 * Users edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit() {
		// Users Auth
		if (!$userId = $this->Auth->user('id')) {
			$this->Session->setFlash(__('Your user has been saved.'));
			$this->redirect('/');
		} else {
			
			// Title
			$this->set('title_for_layout', 'Registro');
			
			// GET
			$user = $this->Users->get($userId);
			
			// POST, PUT
			if ($this->request->is(['post', 'put'])) {
				$this->Users->patchEntity($user, $this->request->data);
				if ($this->Users->save($user)) {
					$this->Session->setFlash(__('Your user has been updated.'));
					return $this->redirect(['action' => 'edit']);
				}
			}
			
			// Set
			$this->set('user', $user);
		}
	}
	
}
