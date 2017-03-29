<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

Class UnsubscribedMember extends Table{
	
	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->BelongsTo("GymMember",["foreignKey"=>"mem_id"]);	
	}
}
