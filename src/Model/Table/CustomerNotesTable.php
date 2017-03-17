<?php
namespace App\Model\Table;
use Cake\ORM\Table;


class CustomerNotesTable extends Table
{
	public function initialize(array $config)
	{
		$this->addBehavior("Timestamp");		
		$this->BelongsTo("NoteFor",['className' => 'GymMember',"foreignKey"=>"note_for","propertyName"=>"NoteForCN"]);
                $this->BelongsTo("CreatedBy",['className' => 'GymMember',"foreignKey"=>"created_by","propertyName"=>"CreatedByCN"]);
                $this->BelongsTo("AssociatedLicensee",['className' => 'GymMember',"foreignKey"=>"associated_licensee","propertyName"=>"AssociatedLicenseeCN"]);
		$this->belongsTo("GymClass",["foreignKey"=>"associated_licensee"]);
                $this->belongsTo("GymMember");
	}
}