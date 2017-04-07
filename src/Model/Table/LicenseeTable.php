<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

Class LicenseeTable extends Table{
	
	public function initialize(array $config)
	{
            $this->addBehavior('Timestamp');
            //$this->BelongsTo("GymRoles",["foreignKey"=>"role"]);
            //$this->BelongsTo("GymLocation",["foreignKey"=>"location_id"]);
           $this->BelongsTo("GymMember");
            //$this->BelongsTo("Specialization",["propertyName"=>"specialization"]);
	}
}