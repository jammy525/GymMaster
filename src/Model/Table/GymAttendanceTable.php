<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class GymAttendanceTable extends Table
{
	public function initialize(array $config)
	{
		$this->addBehavior("Timestamp");
		$this->belongsTo("ClassSchedule");
		$this->belongsTo("GymMember");
		$this->belongsTo("GymMemberClass");
	        $this->belongsTo("GymClass"); 	
                
	}
}