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

// Controllers
use App\Controller\AppController;

// Core App
use Cake\Core\App;
use Cake\Core\Configure;

// Events
use Cake\Event\Event;

// Utility
use Cake\Utility\Security;

// Error
use Cake\ORM\Error\RecordNotFoundException;
use Cake\Error\NotFoundException;

/**
 * ArticlesController class
 *
 */
class ArticlesController extends AppController {
	
    public $helpers = [
		'Html', 
		'Form', 
		'Session',
	];
	
    public $components = [
		'Session',
		'RequestHandler',
	];

	/**
	 * beforeFilter method
	 *
	 * @param Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
	
	}
	
	/**
	 * beforeSave method
	 *
	 * @param Event $event
	 * @return void
	 */
	public function beforeSave(Event $event, Entity $entity, ArrayObject $options) {
	
	}
	
	/**
	 * Articles index method
	 *
	 * @return void
	 */
    public function index() {
		$options = [
			'conditions' => ['Articles.id' => 2],
			'order' => ['Articles.id DESC'],
			'limit' => 10,
		];
		
		$articles = $this->Articles->find('all', $options);
		
		$this->set('articles', $articles);
    }

	/**
	 * Articles view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid article'));
        }
        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }

	/**
	 * Articles add method
	 *
	 * @return void
	 */
    public function add() {
        $article = $this->Articles->newEntity($this->request->data);
		
		if ($this->request->is(['post', 'put'])) {
			if ($this->Articles->save($article)) {
                $this->Session->setFlash(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Session->setFlash(__('Unable to add your article.'));
        }
		
		$this->set('article', $article);
    }
	
	/**
	 * Articles edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid article'));
		}

		$article = $this->Articles->get($id);
		
		if ($this->request->is(['post', 'put'])) {
			$this->Articles->patchEntity($article, $this->request->data);
			if ($this->Articles->save($article)) {
				$this->Session->setFlash(__('Your article has been updated.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Session->setFlash(__('Unable to update your article.'));
		}

		$this->set('article', $article);
	}
	
	/**
	 * Articles ajax method
	 *
	 * @return void
	 */
	public function ajax() {
		// Render View = False
		$this->layout     = false;
		$this->autoRender = false;
		
		// Ajax = True
		if($this->request->is('ajax')){
			Configure::write('debug', false);
			if($id = $this->request->data['id']){
				// Return Articles
				$return = $article = $this->Articles->get($id);
			} else {
				$return = array('return' => false);
			}
		} else {
			$return = array('ajaxError' => false);
		}
		
		// Return JSON
		echo json_encode($return);
		
		// Clear
		unset($return);
	}
	
	/**
	 * Articles ajax method
	 *
	 * @return void
	 */
	public function ajaxDelete() {
		// Render View = False
		$this->layout     = false;
		$this->autoRender = false;
		
		// Ajax = True
		if($this->request->is('ajax')){
			Configure::write('debug', false);
			if($id = $this->request->data['id']){
				// Articles Get
				$article = $this->Articles->get($id);
				if(!empty($article)){
					if ($this->Articles->delete($article)) {
						$return = array('return' => true);
					} else {
						$return = array('return' => false);
					}
				} else {
					$return = array('return' => false);
				}
			} else {
				$return = array('return' => false);
			}
		} else {
			$return = array('ajaxError' => false);
		}
		
		// Return JSON
		echo json_encode($return);
		
		// Clear
		unset($return);
	}
	
	/**
	 * Articles delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if (!$id) {
			throw new NotFoundException(__('Invalid article'));
		}
		
		$article = $this->Articles->get($id);
		if ($this->Articles->delete($article)) {
			$this->Session->setFlash(__('The article with id: %s has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}

}