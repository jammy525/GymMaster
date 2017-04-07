<?php
namespace App\Model\Table;
use Cake\ORM\Table;


class ReferrerReferredTable extends Table
{
	public function initialize(array $config){
		$this->addBehavior("Timestamp");		
		$this->belongsTo("GymMember");
	}
}
