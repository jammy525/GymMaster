<?php
namespace App\Model\Table;
use Cake\ORM\Table;


class ReferralCodeTable extends Table
{
	public function initialize(array $config){
		$this->addBehavior("Timestamp");		
		$this->belongsTo("GymMember",["foreignKey"=>"user_id"]);
	}
}
