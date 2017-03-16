<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

Class ReferTable extends Table{
	
	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->belongsTo("GymClass");	
	}
}
