<?php 
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ResetPasswordTable extends Table
{
 
	public function initialize(array $config){
            $this->table('gym_member');
            //$this->belongsTo('GymMember');
	}
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        return $validator
            ->notEmpty('password', 'Password is required.')
            ->notEmpty('cpassword', 'Password is required.')
            ->add('password', [
                    'compare' => [
                        'rule' => ['password', 'cpassword']
                    ]
                ]);
    }
}