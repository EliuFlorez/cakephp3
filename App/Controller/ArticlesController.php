<?php

namespace App\Controller;

/*
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Component\SessionComponent;

use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Session;
use Cake\Network\Email\Email;
*/

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

use Cake\Utility\Security;

use Cake\Error\NotFoundException;
use Cake\ORM\Error\RecordNotFoundException;

class ArticlesController extends AppController {
	
    public $helpers = [
		'Html', 
		'Form', 
		'Session'
	];
	
    public $components = [
		'Session'
	];

    public function index() {
		$articles = $this->Articles->find('all');
		$this->set('articles', $articles);
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid article'));
        }
        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }

    public function add() {
        if ($this->request->is('post')) {
			$article = $this->Articles->newEntity($this->request->data);
            if ($this->Articles->save($article)) {
                $this->Session->setFlash(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Session->setFlash(__('Unable to add your article.'));
			$this->set('article', $article);
        }
    }
	
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