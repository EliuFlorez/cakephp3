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

use App\Controller\AppController;

use Cake\Event\Event;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Error\NotFoundException;
use Cake\ORM\Error\RecordNotFoundException;

/**
 * ArticlesController class
 *
 */
class ArticlesController extends AppController {
	
    public $helpers = [
		'Html', 
		'Form', 
		'Session'
	];
	
    public $components = [
		'Session'
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
		$articles = $this->Articles->find('all');
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
			if($this->Articles->save(new Entity($this->request->data))){
			//if ($this->Articles->save($article)) {
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
			//$this->Articles->patchEntity($article, $this->request->data);
			if($this->Articles->save(new Entity($this->request->data))){
			//if ($this->Articles->save($article)) {
				$this->Session->setFlash(__('Your article has been updated.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Session->setFlash(__('Unable to update your article.'));
		}

		$this->set('article', $article);
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