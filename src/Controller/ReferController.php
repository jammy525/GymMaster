<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Database\Expression\IdentifierExpression;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

Class ReferController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent("GYMFunction");
    }
    
    public function referFriend() {
        //$this->GYMFunction->pre($_SERVER);die;
        $session = $this->request->session()->read("User");
        $classes = $this->Refer->GymClass->find("list",["keyField"=>"id","valueField"=>"name"])->toArray();
        $classes["all"] = "All";

        $this->set("classes",$classes);
        
        if ($this->request->is("post")) {
            $email = $this->request->data["refer_to"];
            
            if ( $email != "" && preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,8})$/", $email) ){
                $refCode = $this->GYMFunction->__generateReferalUrl('encrypt');
                $user['email'] = $email;
                $user['refURL'] = $_SERVER['HTTP_HOST']. '/member-registration/register/' . $refCode;
                if($_SERVER['HTTP_HOST'] == 'localhost'){
                    $user['refURL'] = $_SERVER['HTTP_HOST']. '/gym_master' . '/member-registration/register/' . $refCode;
                }
                if($this->sendReferFriendEmail($user)){
                    $this->Flash->success(__("Refernce Sent Successfully!."));
                    return $this->redirect($this->referer());
                }else{
                    $this->Flash->error(__("Error Occured."));
                    return $this->redirect($this->referer());
                }
            } else{
                $this->Flash->error(__("Please insert the correct address."));
		return $this->redirect($this->referer());
            } 
        }
    }
    
    /**
     * Sends password reset email to user's email address.
     * @param $id
     * @return
     */
    function sendReferFriendEmail($user = null) {
        if (!empty($user)) {
            $session = $this->request->session()->read("User");
            $referralDetails = $this->GYMFunction->get_user_detail($session['id']);
            //echo '<pre>';print_r($referralDetails);die;
            $mailArr = [
                    "template"=>"refer_friend_mail",
                    "subject"=>$this->GYMFunction->get_user_name($referralDetails['id'])." <".$referralDetails['email']."> Refer you GoTribe",
                    "emailFormat"=>"html",
                    "to"=>$user['email'],
                    "addTo"=>"jameel.ahmad@rnf.tech",
                    "cc"=>"imran.khan@rnf.tech",
                    "addCc"=>"jameel.ahmad@rnf.tech",
                    "bcc"=>"jameel.ahmad@rnf.tech",
                    "addBcc"=>"jameel.ahmad@rnf.tech",
                    "viewVars"=>[
                            'link'=>$user['refURL'],
                            'name'=>$this->GYMFunction->get_user_name($referralDetails['id']),
                            'email'=>$referralDetails['email']
                        ]
                ];
            return $this->GYMFunction->sendEmail($mailArr);
        }
        return false;
    }
    
    
    public function isAuthorized($user){
        return parent::isAuthorizedCustom($user);
    }
}
