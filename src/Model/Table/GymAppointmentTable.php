<?php 
namespace App\Model\Table;
use Cake\ORM\Table;
Class GymAppointmentTable extends Table
{
	public function initialize(array $config)
	{
		$this->belongsTo("GymClass",["foreignKey"=>"class_id"]);
	}
	
}