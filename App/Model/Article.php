<?php

class Article extends AppModel {
	
	public $actsAs = [
		'UploadPack.Upload' => [
			'image' => [
				'styles' => [
					'big' => '200x200',
					'small' => '120x120',
					'thumb' => '80x80'
				]
			]
		]
	];
	
}
