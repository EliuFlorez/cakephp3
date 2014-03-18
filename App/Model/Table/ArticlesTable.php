<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTable extends Table {
	
	protected $_table = 'articles';
	
	public $validate = [
        'title' => [
            'rule' => 'notEmpty'
        ],
        'body' => [
            'rule' => 'notEmpty'
        ]
    ];
	
}