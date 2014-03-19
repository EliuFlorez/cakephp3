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

use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * Articles table class
 *
 */
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
	
	public function initialize(array $config) {
		/*
		// BelongsTo
		$this->belongsTo('authors');
		
		// BelongsToMany
		$this->belongsToMany('tags');
		
		// HasMany
		$this->hasMany('ArticlesTags');
		*/
	}
	
	public function findPublished(Query $query, array $options = []) {
        $query->where([
				'Articles.id >=' => 2
			]
		);
        return $query;
    }
	
}