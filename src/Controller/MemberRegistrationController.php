<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Database\Expression\IdentifierExpression;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Core\Configure;

Class MemberRegistrationController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadComponent("GYMFunction");
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index','register','emailExist','usernameExist', 'getMembershipEndDate', 'addPaymentHistory', 'crypto_rand_secure', 'getToken']);
        if (in_array($this->request->action, ['getMembershipEndDate'])) {
            $this->eventManager()->off($this->Csrf);
        }
    }

    private function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 1)
            return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    private function getToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
        }
        
        $referralCode = $this->MemberRegistration->ReferralCode->find()->where(["code"=>$token])->first();
        if(count($referralCode) > 0){
            return $this->getToken($length);
        }
        return $token;
    }

    public function index() {
        $this->viewBuilder()->layout('login');
        $lastid = $this->MemberRegistration->GymMember->find("all", ["fields" => "id"])->last();
        $lastid = ($lastid != null) ? $lastid->id + 1 : 01;

        $member = $this->MemberRegistration->GymMember->newEntity();
        $m = date("d");
        $y = date("y");
        $prefix = "M" . $lastid;
        $member_id = $prefix . $m . $y;

        $this->set("member_id", $member_id);
        
        $classes = $this->MemberRegistration->GymMember->ClassSchedule->find("list", ["keyField" => "id", "valueField" => "class_name"]);
        $groups = $this->MemberRegistration->GymMember->GymGroup->find("list", ["keyField" => "id", "valueField" => "name"]);
        $interest = $this->MemberRegistration->GymMember->GymInterestArea->find("list", ["keyField" => "id", "valueField" => "interest"]);
        $source = $this->MemberRegistration->GymMember->GymSource->find("list", ["keyField" => "id", "valueField" => "source_name"]);
        $membership = $this->MemberRegistration->GymMember->Membership->find("list", ["keyField" => "id", "valueField" => "membership_label"]);


        $this->set("classes", $classes);
        $this->set("groups", $groups);
        $this->set("interest", $interest);
        $this->set("source", $source);
        $this->set("membership", $membership);
        $this->set("edit", false);
        if ($this->request->is("post")) {
            $this->request->data['member_id'] = $member_id;
            $image = $this->GYMFunction->uploadImage($this->request->data['image']);
            $this->request->data['image'] = (!empty($image)) ? $image : "profile-placeholder.png";
            $this->request->data['birth_date'] = date("Y-m-d", strtotime($this->request->data['birth_date']));
            $this->request->data['created_date'] = date("Y-m-d");
            $this->request->data['assign_group'] = json_encode($this->request->data['assign_group']);
            $this->request->data['membership_status'] = "Prospect";
            $this->request->data["role_name"] = "member";

            $member = $this->MemberRegistration->GymMember->patchEntity($member, $this->request->data);

            if ($saveResult = $this->MemberRegistration->GymMember->save($member)) {
                $this->request->data['member_id'] = $member->id;
                $this->GYMFunction->add_membership_history($this->request->data);
                
                $referralCode = $this->MemberRegistration->ReferralCode->newEntity();
                $referralCodeArray['user_id'] = $saveResult['id'];
                $referralCodeArray['code'] = $this->getToken(8);
                $referralCode = $this->MemberRegistration->ReferralCode->patchEntity($referralCode,$referralCodeArray);
                
                if ($this->addPaymentHistory($this->request->data) && $this->MemberRegistration->ReferralCode->save($this->request->data) ) {
                    // $this->Flash->success(__("Success! Record Saved Successfully."));					
                }

                if (!empty($this->request->data["assign_class"])) {
                    foreach ($this->request->data["assign_class"] as $class) {
                        $new_row = $this->MemberRegistration->GymMemberClass->newEntity();
                        $data = array();
                        $data["member_id"] = $member->id;
                        $data["assign_class"] = $class;
                        $new_row = $this->MemberRegistration->GymMemberClass->patchEntity($new_row, $data);
                        $this->MemberRegistration->GymMemberClass->save($new_row);
                    }
                }

                $sys_email = $this->GYMFunction->getSettings("email");
                $sys_name = $this->GYMFunction->getSettings("name");
                $headers = "From: {$sys_name} <{$sys_email}>" . "\r\n";
                $message = "<p>Hi {$this->request->data["first_name"]},</p>";
                $message .= "<p>Thank you for registering on our system.</p>";
                $message .= "<p>Your Username:{$this->request->data['username']}</p>";
                $message .= "<p>You can login once after admin review your account and activates it.</p>";
                $message .= "<p>Thank You.</p>";
                @mail($this->request->data["email"], _("New Registration : {$sys_name}"), $message, $headers);

                $this->Flash->success(__("Registration completed successfully. Please Check email"));
                // echo "<script>alert('Success! Registration completed successfully.');</script>";
                //Send Mail

                return $this->redirect(["controller" => "users", "action" => "login"]);
                // return $this->redirect(["action"=>"regComplete"]);
            } else {
                if ($member->errors()) {
                    foreach ($member->errors() as $error) {
                        foreach ($error as $key => $value) {
                            $this->Flash->error(__($value));
                        }
                    }
                }
            }
        }
    }
    
    public function register($hash = null){
        if(!isset($hash)){
            return $this->redirect(["action"=>"index"]);
        }else{
            $code = $this->GYMFunction->__generateReferalUrl('decrypt',$hash);
            
            $referral_code_table = TableRegistry::get('ReferralCode');	
            $referral_detail = $referral_code_table->find()->where(['code'=>$code])->first();
            if(count($referral_detail) <= 0){
                return $this->redirect(["action"=>"index"]);
            }
            //echo $referral_detail['user_id'];die;
            $this->viewBuilder()->layout('login');
            
            $lastid = $this->MemberRegistration->GymMember->find("all", ["fields" => "id"])->last();
            $lastid = ($lastid != null) ? $lastid->id + 1 : 01;

            $member = $this->MemberRegistration->GymMember->newEntity();
            $m = date("d");
            $y = date("y");
            $prefix = "M" . $lastid;
            $member_id = $prefix . $m . $y;

            $this->set("member_id", $member_id);

            $classes = $this->MemberRegistration->GymMember->GymClass->find("list", ["keyField" => "id", "valueField" => "name"]);
            $groups = $this->MemberRegistration->GymMember->GymGroup->find("list", ["keyField" => "id", "valueField" => "name"]);
            $interest = $this->MemberRegistration->GymMember->GymInterestArea->find("list", ["keyField" => "id", "valueField" => "interest"]);
            $source = $this->MemberRegistration->GymMember->GymSource->find("list", ["keyField" => "id", "valueField" => "source_name"]);
            $membership = $this->MemberRegistration->GymMember->Membership->find("list", ["keyField" => "id", "valueField" => "membership_label"]);
            $licensee = $this->MemberRegistration->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"licensee"]);
            $licensee = $licensee->select(["id","name"=>$licensee->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();

            $this->set("classes", $classes);
            $this->set("groups", $groups);
            $this->set("interest", $interest);
            $this->set("source", $source);
            $this->set("membership", $membership);
            $this->set("licensee", $licensee);
            $this->set("edit", false);
            
            $this->render("index");
            if ($this->request->is("post")) {
                $this->request->data['referrer_by'] = $referral_detail['user_id'];
                $this->request->data['role_id'] = 4;
                $this->request->data['member_id'] = $member_id;
                $image = $this->GYMFunction->uploadImage($this->request->data['image']);
                $this->request->data['image'] = (!empty($image)) ? $image : "profile-placeholder.png";
                $this->request->data['birth_date'] = date("Y-m-d", strtotime($this->request->data['birth_date']));
                $this->request->data['created_date'] = date("Y-m-d");
                $this->request->data['assign_group'] = json_encode($this->request->data['assign_group']);
                $this->request->data['membership_status'] = "Prospect";
                $this->request->data["role_name"] = "member";

                $member = $this->MemberRegistration->GymMember->patchEntity($member, $this->request->data);

                if ($saveResult = $this->MemberRegistration->GymMember->save($member)) {
                    $this->request->data['member_id'] = $member->id;
                    $this->GYMFunction->add_membership_history($this->request->data);

                    $referralCode = $this->MemberRegistration->ReferralCode->newEntity();
                    $referralCodeArray['user_id'] = $saveResult['id'];
                    $referralCodeArray['code'] = $this->getToken(8);
                    $referralCode = $this->MemberRegistration->ReferralCode->patchEntity($referralCode,$referralCodeArray);

                    if ($this->addPaymentHistory($this->request->data) && $this->MemberRegistration->ReferralCode->save($referralCode) ) {
                        // $this->Flash->success(__("Success! Record Saved Successfully."));					
                    }

                    if (!empty($this->request->data["assign_class"])) {
                        foreach ($this->request->data["assign_class"] as $class) {
                            $new_row = $this->MemberRegistration->GymMemberClass->newEntity();
                            $data = array();
                            $data["member_id"] = $member->id;
                            $data["assign_class"] = $class;
                            $new_row = $this->MemberRegistration->GymMemberClass->patchEntity($new_row, $data);
                            $this->MemberRegistration->GymMemberClass->save($new_row);
                        }
                    }

                    $sys_email = $this->GYMFunction->getSettings("email");
                    $sys_name = $this->GYMFunction->getSettings("name");
                    $headers = "From: {$sys_name} <{$sys_email}>" . "\r\n";
                    $message = "<p>Hi {$this->request->data["first_name"]},</p>";
                    $message .= "<p>Thank you for registering on our system.</p>";
                    $message .= "<p>Your Username:{$this->request->data['username']}</p>";
                    $message .= "<p>You can login once after admin review your account and activates it.</p>";
                    $message .= "<p>Thank You.</p>";
                    @mail($this->request->data["email"], _("New Registration : {$sys_name}"), $message, $headers);

                    $this->Flash->success(__("Registration completed successfully. Please Check email"));
                    // echo "<script>alert('Success! Registration completed successfully.');</script>";
                    //Send Mail

                    return $this->redirect(["controller" => "users", "action" => "login"]);
                    // return $this->redirect(["action"=>"regComplete"]);
                } else {
                    if ($member->errors()) {
                        foreach ($member->errors() as $error) {
                            foreach ($error as $key => $value) {
                                $this->Flash->error(__($value));
                            }
                        }
                    }
                }
            }
        }
        
    }
    private function addPaymentHistory($data) {
        $row = $this->MemberRegistration->MembershipPayment->newEntity();
        $save["member_id"] = $data["member_id"];
        $save["membership_id"] = $data["selected_membership"];
        $save["membership_amount"] = $this->GYMFunction->get_membership_amount($data["selected_membership"]);
        $save["paid_amount"] = 0;
        $save["start_date"] = $data["membership_valid_from"];
        $save["end_date"] = $data["membership_valid_to"];
        /* $save["membership_status"] = $data["membership_status"]; */
        $save["payment_status"] = 0;
        $save["created_date"] = date("Y-m-d");
        /* $save["created_dby"] = 1; */
        $row = $this->MemberRegistration->MembershipPayment->patchEntity($row, $save);
        if ($this->MemberRegistration->MembershipPayment->save($row)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function regComplete() {
        $this->autoRender = false;
        echo "<br><p><i><strong>Success!</strong> Registration completed successfully.</i></p>";
        echo "<p><i><a href='{$this->request->base}/Users'>Click Here</a> to Redirect on login page.</i></p>";
    }

    public function getMembershipEndDate() {
        $this->autoRender = false;

        if ($this->request->is("ajax")) {
            // $format = $this->GYMFunction->date_format();
            // $format = str_ireplace(array("yyyy","yy","dd","mm"),array("y","y","d","m"),$format);
            // $format = str_replace("yy","Y",$format);
            // $format = str_replace("dd","d",$format);
            // $format = str_replace("mm","m",$format);
            $date = $this->request->data["date"];
            $date = str_replace("/", "-", $date);
            $membership_id = $this->request->data["membership"];
            $date1 = date("Y-m-d", strtotime($date));
            $membership_table = TableRegistry::get("Membership");
            $row = $membership_table->get($membership_id)->toArray();
            $period = $row["membership_length"];
            $end_date = date("Y-m-d", strtotime($date1 . " + {$period} days"));
            echo $end_date;
            // echo "Asd";
            die;
        }
    }
    
    public function emailExist(){ 
        $this->request->data = $_REQUEST;
        $email = $this->request->data['fieldValue'];
        $fieldId = $this->request->data['fieldId'];
        $member_tbl = TableRegistry::get("GymMember");
        $query = $member_tbl->find()->where(["email"=>$email])->first();
        $count = intval(count($query));
        if($count == 1){
            $arrayToJs[0] = $fieldId;
            $arrayToJs[1] = false;		// RETURN TRUE
            echo json_encode($arrayToJs);
            die;
        }else{
            $arrayToJs[0] = $fieldId;
            $arrayToJs[1] = true;			// RETURN TRUE
            echo json_encode($arrayToJs);
            die;
        }
    }
    
    public function usernameExist(){
        $this->request->data = $_REQUEST;
        $username = $this->request->data['fieldValue'];
        $fieldId = $this->request->data['fieldId'];
        $member_tbl = TableRegistry::get("GymMember");
        $query = $member_tbl->find()->where(["username"=>$username])->first();
        $count = intval(count($query));
        if($count == 1){
            $arrayToJs[0] = $fieldId;
            $arrayToJs[1] = false;		// RETURN TRUE
            echo json_encode($arrayToJs);	
            die;
        }else{
            $arrayToJs[0] = $fieldId;
            $arrayToJs[1] = true;			// RETURN TRUE
            echo json_encode($arrayToJs);
            die;
        }
    }
}
