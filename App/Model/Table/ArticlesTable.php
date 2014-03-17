<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTable extends Table {
	
	public $validate = [
        'title' => [
            'rule' => 'notEmpty'
        ],
        'body' => [
            'rule' => 'notEmpty'
        ]
    ];
	
}