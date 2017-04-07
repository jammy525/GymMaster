<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class GymClassTable extends Table
{
	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		
		$this->belongsTo("GymMember",["foreignKey"=>"created_by"]);
		 $this->belongsTo("ClassType",["foreignKey"=>"class_type_id"]);
	}
}
