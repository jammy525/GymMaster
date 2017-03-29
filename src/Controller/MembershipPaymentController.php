<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Gmgt_paypal_class;

class MembershipPaymentController extends AppController {

    public function initialize() {
        parent::initialize();
        require_once(ROOT . DS . 'vendor' . DS . 'paypal' . DS . 'paypal_class.php');
        require_once(ROOT . DS . 'vendor' . DS . 'tcpdf' . DS . 'tcpdf.php');
        $this->loadComponent("GYMFunction");
    }

    public function paymentList() {
        $new_session = $this->request->session();
        $session = $this->request->session()->read("User");
        $loggedUser = $this->GYMFunction->get_user_detail($session['id']);
        if ($session["role_name"] == "administrator") {
            $data = $this->MembershipPayment->find("all")
                    ->where(['MembershipPayment.mem_plan_status' => 1])
                    ->orWhere(['MembershipPayment.mem_plan_status' => 2])
                    ->orWhere(['MembershipPayment.mem_plan_status' => 0])
                    ->contain(["Membership", "GymMember"])
                    ->hydrate(false)->toArray();
        } else if($session["role_name"] == "licensee" || $session["role_name"] == "staff_member") {
            $data = $this->MembershipPayment->find("all")
                    ->contain(["Membership", "GymMember"])
                    ->where(['MembershipPayment.mem_plan_status' => 1])
                    ->orWhere(['MembershipPayment.mem_plan_status' => 2])
                    ->orWhere(['MembershipPayment.mem_plan_status' => 0])
                    ->hydrate(false)->toArray();
        }else{
            $data = $this->MembershipPayment->find("all")
                    ->contain(["Membership", "GymMember"])
                    ->where([
                        "MembershipPayment.member_id" => $session["id"],
                        'OR' => [
                            ['MembershipPayment.mem_plan_status' => 1],
                            ['MembershipPayment.mem_plan_status' => 2],
                            ['MembershipPayment.mem_plan_status' => 0],
                        ],
                        
                    ])
                    ->hydrate(false)->toArray();
        }
        $this->set("data", $data);

        if ($this->request->is("post")) {
            $session = $this->request->session()->read("User");
            $mp_id = $this->request->data["mp_id"];
            $row = $this->MembershipPayment->findByMpId($mp_id)->contain(['Membership'])->first();
            $user_id = $row['member_id'];
            $membership_id = $row['membership_id'];
            
            $user_info = $this->MembershipPayment->GymMember->get($user_id);
            //Online Payment by customers themselves
            if ($this->request->data["payment_method"] == "Paypal" && $session["role_name"] == "member") {
                $new_session->write("Payment.mp_id", $mp_id);
                $new_session->write("Payment.amount", $this->request->data["amount"]);
                require_once(ROOT . DS . 'vendor' . DS . 'paypal' . DS . 'paypal_process.php');
            } else {
                
                $row['paid_amount'] = $row['paid_amount'] + $this->request->data["amount"];
                $row['paid_by'] = $session['id'];
                $row['payment_status'] = 1;
                //$row['mem_plan_status'] = 1;
                
                // Check logic to set mem_plan_status
                
                $other_rows = $this->MembershipPayment->find()->where(['member_id'=>$user_id, 'mp_id !='=>$mp_id]);
                
                if(count($other_rows->toArray())>0){
                    foreach($other_rows->toArray() as $other_row){
                        if( $other_row['mem_plan_status'] == 1 && ( strtotime( $other_row['end_date']) >= strtotime($row['start_date'] ) ) &&  (strtotime($row['start_date'] ) == strtotime(date('Y-m-d')))){
                            //$row['mem_plan_status'] = 1;
                            $other_row_update_array['mem_plan_status'] = 0;

                            $other_row_update = $this->MembershipPayment->get($other_row['mp_id']);
                            $other_row_update = $this->MembershipPayment->MembershipPaymentHistory->patchEntity($other_row_update, $other_row_update_array);
                            $this->MembershipPayment->save($other_row_update);
                            break;
                        }else if( $other_row['mem_plan_status'] == 1 && ( strtotime( $other_row['end_date']) < strtotime($row['start_date'] ) ) ){
                            $row['mem_plan_status'] = 2;
                        }
                    }
                }else{
                    $row['mem_plan_status'] = 1;
                }
                
                
                $this->MembershipPayment->save($row);
                
                //if record exist and payment not made, start date less than this record then disable that one and enable this one.
                //if record exist and payment made and end date less or equal to start date of this record then
                
                $hrow = $this->MembershipPayment->MembershipPaymentHistory->newEntity();
                $data['mp_id'] = $mp_id;
                $data['amount'] = $this->request->data["amount"];
                $data['payment_method'] = $this->request->data["payment_method"];
                $data['paid_by_date'] = date("Y-m-d");
                $data['created_by'] = $session["id"];
                $data['transaction_id'] = "";

                $hrow = $this->MembershipPayment->MembershipPaymentHistory->patchEntity($hrow, $data);
                $saveResult = $this->MembershipPayment->MembershipPaymentHistory->save($hrow);
                    
            }
            $mailArrUser = [
                "template"=>"payment_user_mail",
                "subject"=>"GoTribe : Payment Successfull",
                "emailFormat"=>"html",
                "to"=>$user_info->email,
                "addTo"=>"jameel.ahmad@rnf.tech",
                "cc"=>"imran.khan@rnf.tech",
                "addCc"=>"jameel.ahmad@rnf.tech",
                "bcc"=>"jameel.ahmad@rnf.tech",
                "addBcc"=>"jameel.ahmad@rnf.tech",
                "viewVars"=>[
                        'name'=>$user_info->first_name . ' ' . $user_info->last_name,
                        'membership'=>$row['membership']['membership_label'],
                        'amount'=>$this->request->data["amount"],
                        'method'=>$this->request->data["payment_method"],
                        'payment_method'=>$this->request->data["payment_method"],
                        'transaction_id'=>$data['transaction_id'],
                        'payment_made_by'=>$this->GYMFunction->get_user_name($session['id'])
                    ]
            ];
            $associated_licensee = $this->GYMFunction->get_user_detail($user_info->associated_licensee);
            $mailArrAdmin = [
                "template"=>"payment_admin_mail",
                "subject"=>"GoTribe : Payment successfull",
                "emailFormat"=>"html",
                "to"=>$associated_licensee['email'],
                "addTo"=>"jameel.ahmad@rnf.tech",
                "cc"=>"imran.khan@rnf.tech",
                "addCc"=>"jameel.ahmad@rnf.tech",
                "bcc"=>"jameel.ahmad@rnf.tech",
                "addBcc"=>"jameel.ahmad@rnf.tech",
                "viewVars"=>[
                        'name'=>$user_info->first_name . ' ' . $user_info->last_name,
                        'email'=>$user_info->email,
                        'username'=>$user_info->username,
                        'membership'=>$row['membership']['membership_label'],
                        'adminName'=>$associated_licensee['first_name'] . ' ' . $associated_licensee['last_name'],
                        'amount'=>$this->request->data["amount"],
                        'method'=>$this->request->data["payment_method"],
                        'transaction_id'=>$data['transaction_id'],
                        'payment_made_by'=>$this->GYMFunction->get_user_name($session['id'])
                    ]
            ];
            if($this->GYMFunction->sendEmail($mailArrUser) && $this->GYMFunction->sendEmail($mailArrAdmin)){
                $this->Flash->success(__("Success! Payment Added Successfully."));
            }
            return $this->redirect(["action" => "paymentList"]);
        }
    }

    public function generatePaymentInvoice() {
        $session = $this->request->session()->read("User");
        $this->set("edit", false);
        $existingMembers = $this->MembershipPayment->find('all')
                ->select(['MembershipPayment.member_id'])
                ->where(['MembershipPayment.mem_plan_status !=' => 3])
                ->toArray();
        $existingMembersIdsArr = array("0");
        if(count($existingMembers) > 0){
            foreach($existingMembers as $existingMembersIds)
                $existingMembersIdsArr[] = $existingMembersIds['member_id'];
        }
        
        $members = $this->MembershipPayment->GymMember->find("list", ["keyField" => "id", "valueField" => "name"])
                ->where(["role_name" => "member", "activated"=>1, "GymMember.id NOT IN"=>$existingMembersIdsArr]);
        $members = $members->select(["id", "name" => $members->func()
                ->concat(["first_name" => "literal", " ", "last_name" => "literal"])])->hydrate(false)->toArray();
        $this->set("members", $members);
        //echo $this->GYMFunction->pre($members);
        $memCats = $this->MembershipPayment->Category->find('all')->hydrate(false)->toArray();
        foreach($memCats as $memCat){
            $membership[$memCat['name']] = $this->MembershipPayment->Membership
                    ->find("list", ["keyField" => "id", "valueField" => "membership_label"])
                    ->where(['membership_cat_id'=>$memCat['id']])->hydrate(false)->toArray();
        }
        //$membership = $this->MembershipPayment->Membership->find("list", ["keyField" => "id", "valueField" => "membership_label"])->contain(['Category']);
        
        $this->set("membership", $membership);

        if ($this->request->is('post')) {
            $mid = $this->request->data["user_id"];
            
            $exist_member = $this->MembershipPayment->findByMemberId($mid)
                    ->where(['mem_plan_status !=' =>3])
                    ->first();
            if(count($exist_member) > 0){
                $this->Flash->error(__("Error! Member already subscribed a plan."));
                return $this->redirect(["action" => "paymentList"]);
            }
            
            $user_info = $this->MembershipPayment->GymMember->get($mid);
            
            $start_date = date("Y-m-d", strtotime($this->request->data["membership_valid_from"]));
            $end_date = date("Y-m-d", strtotime($this->request->data["membership_valid_to"]));
            $row = $this->MembershipPayment->newEntity();
            $pdata["member_id"] = $mid;
            $pdata["created_by"] = $session['id'];
            $pdata["membership_id"] = $this->request->data["membership_id"];
            $pdata["membership_amount"] = $this->request->data["membership_amount"];
            $pdata["paid_amount"] = 0;
            $pdata["start_date"] = $start_date;
            $pdata["end_date"] = $end_date;
            $pdata["membership_status"] = "Continue";
            $pdata["mem_plan_status"] = 0;
            /**
             * We will change the status at the time of recurring payment schedule 
             */
            $pdata["payment_status"] = 0;
            $row = $this->MembershipPayment->patchEntity($row, $pdata);
            $this->MembershipPayment->save($row);
            ################## MEMBER's Current Membership Change ##################
            $member_data = $this->MembershipPayment->GymMember->get($mid);
            $member_data_update['selected_membership'] = $this->request->data["membership_id"];
            $member_data_update['membership_valid_from'] = $start_date;
            $member_data_update['membership_valid_to'] = $end_date;
            $member_data = $this->MembershipPayment->GymMember->patchEntity($member_data, $member_data_update);
            $this->MembershipPayment->GymMember->save($member_data);
            #####################Add Membership History #############################
            $mem_histoty = $this->MembershipPayment->MembershipHistory->newEntity();
            $hdata["member_id"] = $mid;
            $hdata["selected_membership"] = $this->request->data["membership_id"];
            $hdata["membership_valid_from"] = $start_date;
            $hdata["membership_valid_to"] = $end_date;
            //$hdata["created_date"] = date("Y-m-d");
            $hdata = $this->MembershipPayment->MembershipHistory->patchEntity($mem_histoty, $hdata);
            if ($this->MembershipPayment->MembershipHistory->save($mem_histoty)) {
                
                //Membership plan info
                
                $membership_info = $this->MembershipPayment->Membership->findById($this->request->data["membership_id"])->first();
                
                $mailArrUser = [
                "template"=>"subscribe_membership_user_mail",
                "subject"=>"GoTribe : Subscribed Membership Successfull",
                "emailFormat"=>"html",
                "to"=>$user_info->email,
                "addTo"=>"jameel.ahmad@rnf.tech",
                "cc"=>"imran.khan@rnf.tech",
                "addCc"=>"jameel.ahmad@rnf.tech",
                "bcc"=>"jameel.ahmad@rnf.tech",
                "addBcc"=>"jameel.ahmad@rnf.tech",
                "viewVars"=>[
                        'name'=>$user_info->first_name . ' ' . $user_info->last_name,
                        'membership'=>$membership_info['membership_label'],
                        'amount'=>$membership_info["membership_amount"],
                        'validity'=>date($this->GYMFunction->getSettings('date_format'),strtotime($start_date)). " To ". date($this->GYMFunction->getSettings('date_format'),strtotime($end_date))
                    ]
                ];
                $associated_licensee = $this->GYMFunction->get_user_detail($user_info->associated_licensee);
                $mailArrAdmin = [
                    "template"=>"subscribe_membership_admin_mail",
                    "subject"=>"GoTribe : Subscribed Membership Successfull",
                    "emailFormat"=>"html",
                    "to"=>$associated_licensee['email'],
                    "addTo"=>"jameel.ahmad@rnf.tech",
                    "cc"=>"imran.khan@rnf.tech",
                    "addCc"=>"jameel.ahmad@rnf.tech",
                    "bcc"=>"jameel.ahmad@rnf.tech",
                    "addBcc"=>"jameel.ahmad@rnf.tech",
                    "viewVars"=>[
                            'name'=>$user_info->first_name . ' ' . $user_info->last_name,
                            'email'=>$user_info->email,
                            'username'=>$user_info->username,
                            'membership'=>$membership_info['membership_label'],
                            'adminName'=>$associated_licensee['first_name'] . ' ' . $associated_licensee['last_name'],
                            'amount'=>$membership_info["membership_amount"],
                            'validity'=>date($this->GYMFunction->getSettings('date_format'),strtotime($start_date)). " To ". date($this->GYMFunction->getSettings('date_format'),strtotime($end_date))
                        ]
                ];
                if($this->GYMFunction->sendEmail($mailArrUser) && $this->GYMFunction->sendEmail($mailArrAdmin)){
                    $this->Flash->success(__("Success! Subscribed Membership Successfully."));
                    return $this->redirect(["action" => "paymentList"]);
                }
                
                
            }
        }
    }

    public function membershipEdit($eid) {
        $session = $this->request->session()->read("User");
        $this->set("edit", true);
        $members = $this->MembershipPayment->GymMember->find("list", ["keyField" => "id", "valueField" => "name"])
                ->where(["role_name" => "member", "activated"=>1]);
        $members = $members->select(["id", "name" => $members->func()
                ->concat(["first_name" => "literal", " ", "last_name" => "literal"])])->hydrate(false)->toArray();
        $this->set("members", $members);
        $memCats = $this->MembershipPayment->Category->find('all')->hydrate(false)->toArray();
        foreach($memCats as $memCat){
            $membership[$memCat['name']] = $this->MembershipPayment->Membership
                    ->find("list", ["keyField" => "id", "valueField" => "membership_label"])
                    ->where(['membership_cat_id'=>$memCat['id']])->hydrate(false)->toArray();
        }
        $this->set("membership", $membership);

        $data = $this->MembershipPayment->get($eid);
        $this_record = $data->toArray();
        $this->set("data", $this_record);
        
        if ($this->request->is('post')) {
            
            $mid = $this->request->data["user_id"];
            $start_date = date("Y-m-d", strtotime($this->request->data["membership_valid_from"]));
            $end_date = date("Y-m-d", strtotime($this->request->data["membership_valid_to"]));
            $user_info = $this->MembershipPayment->GymMember->get($mid);
            
            if($this_record['mem_plan_status'] == 0 && $this_record['payment_status'] == 0){
                $this->MembershipPayment->delete($data);
                $pdata["mem_plan_status"] = 0;
            }
            
            // Add new record
            if($this_record['mem_plan_status'] == 1 && $this_record['payment_status'] == 1){
                $pdata["mem_plan_status"] = 2;
            }
            
            if($this_record['mem_plan_status'] == 2 && $this_record['payment_status'] == 0){
                $this->MembershipPayment->delete($data);
                $pdata["mem_plan_status"] = 2;
            }
            
            if($this_record['mem_plan_status'] == 2 && $this_record['payment_status'] == 1){
                $pdata["mem_plan_status"] = 2;
            }
            
            //add new subscription
            $row = $this->MembershipPayment->newEntity();
            $pdata["member_id"] = $mid;
            $pdata["created_by"] = $session['id'];
            $pdata["membership_id"] = $this->request->data["membership_id"];
            $pdata["membership_amount"] = $this->request->data["membership_amount"];
            $pdata["paid_amount"] = 0;
            $pdata["start_date"] = $start_date;
            $pdata["end_date"] = $end_date;
            $pdata["membership_status"] = "Upgrade";
            $pdata["payment_status"] = 0;
            /**
             * At the time of payment schedule we will check if there is record exist with mem_plan_status  = 2
             * If yes, we will update records like 
             * record with mem_plan_status  = 1 TO mem_plan_status  = 0 // unsubscribe old record
             * and record with mem_plan_status  = 2 To mem_plan_status  = 1 // subscribe new record
             * Also we will overwrite records no new entry on edit subscription repeatedly.
             */
            $row = $this->MembershipPayment->patchEntity($row, $pdata);
            $this->MembershipPayment->save($row);
            ################## MEMBER's Current Membership Change ##################
            $member_data = $this->MembershipPayment->GymMember->get($mid);
            $member_data_update['selected_membership'] = $this->request->data["membership_id"];
            $member_data_update['membership_valid_from'] = $start_date;
            $member_data_update['membership_valid_to'] = $end_date;
            $member_data = $this->MembershipPayment->GymMember->patchEntity($member_data, $member_data_update);
            $this->MembershipPayment->GymMember->save($member_data);
            #####################Add Membership History #############################
            $mem_histoty = $this->MembershipPayment->MembershipHistory->newEntity();
            $hdata["member_id"] = $mid;
            $hdata["selected_membership"] = $this->request->data["membership_id"];
            $hdata["membership_valid_from"] = $start_date;
            $hdata["membership_valid_to"] = $end_date;
            $hdata = $this->MembershipPayment->MembershipHistory->patchEntity($mem_histoty, $hdata);

            if ($this->MembershipPayment->MembershipHistory->save($mem_histoty)) {

                //Membership plan info

                $membership_info = $this->MembershipPayment->Membership->findById($this->request->data["membership_id"])->first();

                $mailArrUser = [
                "template"=>"subscribe_membership_user_mail",
                "subject"=>"GoTribe : Subscribed Membership Successfull",
                "emailFormat"=>"html",
                "to"=>$user_info->email,
                "addTo"=>"jameel.ahmad@rnf.tech",
                "cc"=>"imran.khan@rnf.tech",
                "addCc"=>"jameel.ahmad@rnf.tech",
                "bcc"=>"jameel.ahmad@rnf.tech",
                "addBcc"=>"jameel.ahmad@rnf.tech",
                "viewVars"=>[
                        'name'=>$user_info->first_name . ' ' . $user_info->last_name,
                        'membership'=>$membership_info['membership_label'],
                        'amount'=>$membership_info["membership_amount"],
                        'validity'=>date($this->GYMFunction->getSettings('date_format'),strtotime($start_date)). " To ". date($this->GYMFunction->getSettings('date_format'),strtotime($end_date))
                    ]
                ];
                $associated_licensee = $this->GYMFunction->get_user_detail($user_info->associated_licensee);
                $mailArrAdmin = [
                    "template"=>"subscribe_membership_admin_mail",
                    "subject"=>"GoTribe : Subscribed Membership Successfull",
                    "emailFormat"=>"html",
                    "to"=>$associated_licensee['email'],
                    "addTo"=>"jameel.ahmad@rnf.tech",
                    "cc"=>"imran.khan@rnf.tech",
                    "addCc"=>"jameel.ahmad@rnf.tech",
                    "bcc"=>"jameel.ahmad@rnf.tech",
                    "addBcc"=>"jameel.ahmad@rnf.tech",
                    "viewVars"=>[
                            'name'=>$user_info->first_name . ' ' . $user_info->last_name,
                            'email'=>$user_info->email,
                            'username'=>$user_info->username,
                            'membership'=>$membership_info['membership_label'],
                            'adminName'=>$associated_licensee['first_name'] . ' ' . $associated_licensee['last_name'],
                            'amount'=>$membership_info["membership_amount"],
                            'validity'=>date($this->GYMFunction->getSettings('date_format'),strtotime($start_date)). " To ". date($this->GYMFunction->getSettings('date_format'),strtotime($end_date))
                        ]
                ];
                if($this->GYMFunction->sendEmail($mailArrUser) && $this->GYMFunction->sendEmail($mailArrAdmin)){
                    $this->Flash->success(__("Success! Subscribed Membership Successfully."));
                    return $this->redirect(["action" => "paymentList"]);
                }
            }
        }
        $this->render("generatePaymentInvoice");
    }

    public function deletePayment($mp_id) {
        $row = $this->MembershipPayment->get($mp_id);
        if ($this->MembershipPayment->delete($row)) {
            $this->Flash->success(__("Success! Payment Record Deleted Successfully."));
            return $this->redirect(["action" => "paymentList"]);
        }
    }
    
    public function pdfView($ftype = '0',$mp_id) { 
        
        $payment_tbl = TableRegistry::get("MembershipPayment");
        $setting_tbl = TableRegistry::get("GeneralSetting");
        $pay_history_tbl = TableRegistry::get("MembershipPaymentHistory");

        $sys_data = $setting_tbl->find()->select(["name", "address", "gym_logo", "date_format", "office_number", "country"])->hydrate(false)->toArray();
        $sys_data[0]["gym_logo"] = (!empty($sys_data[0]["gym_logo"])) ? $this->request->base . "/webroot/upload/" . $sys_data[0]["gym_logo"] : $this->request->base . "/webroot/img/Thumbnail-img.png";
        $data = $payment_tbl->find("all")->contain(["GymMember", "Membership"])->where(["mp_id" => $mp_id])->hydrate(false)->toArray();
        $history_data = $pay_history_tbl->find("all")->where(["mp_id" => $mp_id])->hydrate(false)->toArray();
        //$this->GYMFunction->pre($data);
        $session = $this->request->session();
        $float_l = ($session->read("User.is_rtl") == "1") ? "right" : "left";
        $float_r = ($session->read("User.is_rtl") == "1") ? "left" : "right";
        $float_l = "left";
        $float_r = "right";
        
        $this->set('ftype', $ftype);
        $this->set('title', 'Member Invoice');
        $this->viewBuilder()->layout('pdf/pdf');
        $this->set("float_r", $float_r);
        $this->set("float_l", $float_l);
        $this->set("sys_data", $sys_data);
        $this->set("data", $data);
        $this->set("history_data", $history_data);
        $this->set('mp_id', $mp_id);        
        $this->viewBuilder()->template('pdf/invoice');
        $this->set('filename', date('Y-m-d') . '_invoice.pdf');
        $this->response->type('pdf');
        
    }
    
    /*
    public function membershipUnsubscribe($mp_id) {
        
        $row = $this->MembershipPayment->get($mp_id);
        $row_update_array['unsubscribed'] = 1;
        $row = $this->MembershipPayment->patchEntity($row, $row_update_array);
        if ($this->MembershipPayment->save($row)) {
            $this->Flash->success(__("Success! Plan unsubscribed."));
            return $this->redirect(["action" => "paymentList"]);
        }
    }*/

    public function incomeList() {
        $data = $this->MembershipPayment->GymIncomeExpense->find("all")->contain(["GymMember"])->where(["invoice_type" => "income"])->hydrate(false)->toArray();
        $this->set("data", $data);
    }

    public function addIncome() {
        $session = $this->request->session()->read("User");
        $this->set("edit", false);
        $members = $this->MembershipPayment->GymMember->find("list", ["keyField" => "id", "valueField" => "name"])->where(["role_name" => "member"]);
        $members = $members->select(["id", "name" => $members->func()->concat(["first_name" => "literal", " ", "last_name" => "literal"])])->hydrate(false)->toArray();
        $this->set("members", $members);

        if ($this->request->is("post")) {
            $row = $this->MembershipPayment->GymIncomeExpense->newEntity();
            $data = $this->request->data;
            $total_amount = null;
            foreach ($data["income_amount"] as $amount) {
                $total_amount += $amount;
            }
            $data["total_amount"] = $total_amount;
            $data["entry"] = $this->get_entry_records($data);
            $data["receiver_id"] = $session["id"]; //current userid;			
            $data["invoice_date"] = date("Y-m-d", strtotime($data["invoice_date"]));
            $row = $this->MembershipPayment->GymIncomeExpense->patchEntity($row, $data);
            if ($this->MembershipPayment->GymIncomeExpense->save($row)) {
                $this->Flash->success(__("Success! Record Saved Successfully."));
                return $this->redirect(["action" => "incomeList"]);
            }
        }
    }

    public function get_entry_records($data) {
        $all_income_entry = $data['income_entry'];
        $all_income_amount = $data['income_amount'];

        $entry_data = array();
        $i = 0;
        foreach ($all_income_entry as $one_entry) {
            $entry_data[] = array('entry' => $one_entry,
                'amount' => $all_income_amount[$i]);
            $i++;
        }
        return json_encode($entry_data);
    }

    public function incomeEdit($eid) {
        $this->set("edit", true);
        $members = $this->MembershipPayment->GymMember->find("list", ["keyField" => "id", "valueField" => "name"])->where(["role_name" => "member"]);
        $members = $members->select(["id", "name" => $members->func()->concat(["first_name" => "literal", " ", "last_name" => "literal"])])->hydrate(false)->toArray();
        $this->set("members", $members);

        $row = $this->MembershipPayment->GymIncomeExpense->get($eid);
        $this->set("data", $row->toArray());

        if ($this->request->is("post")) {
            $data = $this->request->data;
            $total_amount = null;
            foreach ($data["income_amount"] as $amount) {
                $total_amount += $amount;
            }
            $data["total_amount"] = $total_amount;
            $data["entry"] = $this->get_entry_records($data);
            $data["invoice_date"] = date("Y-m-d", strtotime($data["invoice_date"]));

            $row = $this->MembershipPayment->GymIncomeExpense->patchEntity($row, $data);
            if ($this->MembershipPayment->GymIncomeExpense->save($row)) {
                $this->Flash->success(__("Success! Record Updated Successfully."));
                return $this->redirect(["action" => "incomeList"]);
            }
        }
        $this->render("addIncome");
    }

    public function deleteIncome($did) {
        $row = $this->MembershipPayment->GymIncomeExpense->get($did);
        if ($this->MembershipPayment->GymIncomeExpense->delete($row)) {
            $this->Flash->success(__("Success! Record Deleted Successfully."));
            return $this->redirect($this->referer());
        }
    }

    public function printInvoice() {
        $id = $this->request->params["pass"][0];
        $invoice_type = $this->request->params["pass"][1];
        $in_ex_table = TableRegistry::get("GymIncomeExpense");
        $setting_tbl = TableRegistry::get("GeneralSetting");
        $income_data = array();
        $expense_data = array();
        $invoice_data = array();

        $sys_data = $setting_tbl->find()->select(["name", "address", "gym_logo", "date_format", "office_number", "country"])->hydrate(false)->toArray();

        if ($invoice_type == "income") {
            $income_data = $this->MembershipPayment->GymIncomeExpense->find("all")->contain(["GymMember"])->where(["GymIncomeExpense.id" => $id])->hydrate(false)->toArray();
            $this->set("income_data", $income_data[0]);
            $this->set("expense_data", $expense_data);
            $this->set("invoice_data", $invoice_data);
        } else if ($invoice_type == "expense") {
            $expense_data = $this->MembershipPayment->GymIncomeExpense->find("all")->where(["GymIncomeExpense.id" => $id])->select($this->MembershipPayment->GymIncomeExpense);
            $expense_data = $expense_data->leftjoin(["GymMember" => "gym_member"], ["GymIncomeExpense.receiver_id = GymMember.id"])->select($this->MembershipPayment->GymMember)->hydrate(false)->toArray();
            $expense_data[0]["gym_member"] = $expense_data[0]["GymMember"];
            unset($expense_data[0]["GymMember"]);
            $this->set("income_data", $income_data);
            $this->set("expense_data", $expense_data[0]);
            $this->set("invoice_data", $invoice_data);
        }

        $this->set("sys_data", $sys_data[0]);
    }

    public function expenseList() {
        $data = $this->MembershipPayment->GymIncomeExpense->find("all")->where(["invoice_type" => "expense"])->hydrate(false)->toArray();
        $this->set("data", $data);
    }

    public function addExpense() {
        $this->set("edit", false);
        $session = $this->request->session()->read("User");

        if ($this->request->is("post")) {
            $row = $this->MembershipPayment->GymIncomeExpense->newEntity();
            $data = $this->request->data;
            $total_amount = null;
            foreach ($data["income_amount"] as $amount) {
                $total_amount += $amount;
            }
            $data["total_amount"] = $total_amount;
            $data["entry"] = $this->get_entry_records($data);
            $data["receiver_id"] = $session["id"]; //current userid;			
            $data["invoice_date"] = date("Y-m-d", strtotime($data["invoice_date"]));
            $row = $this->MembershipPayment->GymIncomeExpense->patchEntity($row, $data);
            if ($this->MembershipPayment->GymIncomeExpense->save($row)) {
                $this->Flash->success(__("Success! Record Saved Successfully."));
                return $this->redirect(["action" => "expenseList"]);
            }
        }
    }

    public function expenseEdit($eid) {
        $this->set("edit", true);

        $row = $this->MembershipPayment->GymIncomeExpense->get($eid);
        $this->set("data", $row->toArray());

        if ($this->request->is("post")) {
            $data = $this->request->data;
            $total_amount = null;
            foreach ($data["income_amount"] as $amount) {
                $total_amount += $amount;
            }
            $data["total_amount"] = $total_amount;
            $data["entry"] = $this->get_entry_records($data);
            $data["invoice_date"] = date("Y-m-d", strtotime($data["invoice_date"]));

            $row = $this->MembershipPayment->GymIncomeExpense->patchEntity($row, $data);
            if ($this->MembershipPayment->GymIncomeExpense->save($row)) {
                $this->Flash->success(__("Success! Record Updated Successfully."));
                return $this->redirect(["action" => "expenseList"]);
            }
        }
        $this->render("addExpense");
    }

    public function deleteAccountant($id) {
        $row = $this->GymAccountant->GymMember->get($id);
        if ($this->GymAccountant->GymMember->delete($row)) {
            $this->Flash->success(__("Success! Accountant Deleted Successfully."));
            return $this->redirect($this->referer());
        }
    }

    public function paymentSuccess() {
        $payment_data = $this->request->session()->read("Payment");
        $session = $this->request->session()->read("User");
        $feedata['mp_id'] = $payment_data["mp_id"];
        $feedata['amount'] = $payment_data['amount'];
        $feedata['payment_method'] = 'Paypal';
        $feedata['paid_by_date'] = date("Y-m-d");
        $feedata['created_by'] = $session["id"];
        $row = $this->MembershipPayment->MembershipPaymentHistory->newEntity();
        $row = $this->MembershipPayment->MembershipPaymentHistory->patchEntity($row, $feedata);
        if ($this->MembershipPayment->MembershipPaymentHistory->save($row)) {
            $row = $this->MembershipPayment->get($payment_data["mp_id"]);
            $row->paid_amount = $row->paid_amount + $payment_data['amount'];
            $this->MembershipPayment->save($row);
        }

        $session = $this->request->session();
        $session->delete('Payment');

        $this->Flash->success(__("Success! Payment Successfully Completed."));
        return $this->redirect(["action" => "paymentList"]);
    }

    public function ipnFunction() {
        if ($this->request->is("post")) {
            $trasaction_id = $_POST["txn_id"];
            $custom_array = explode("_", $_POST['custom']);
            $feedata['mp_id'] = $custom_array[1];
            $feedata['amount'] = $_POST['mc_gross_1'];
            $feedata['payment_method'] = 'Paypal';
            $feedata['trasaction_id'] = $trasaction_id;
            $feedata['created_by'] = $custom_array[0];
            //$log_array		= print_r($feedata, TRUE);
            //wp_mail( 'bhaskar@dasinfomedia.com', 'gympaypal', $log_array);
            $row = $this->MembershipPayment->MembershipPaymentHistory->newEntity();
            $row = $this->MembershipPayment->MembershipPaymentHistory->patchEntity($row, $feedata);
            if ($this->MembershipPayment->MembershipPaymentHistory->save($row)) {
                $this->Flash->success(__("Success! Payment Successfully Completed."));
            } else {
                $this->Flash->error(__("Paypal Payment IPN save failed to DB."));
            }
            return $this->redirect(["action" => "paymentList"]);
            //require_once SMS_PLUGIN_DIR. '/lib/paypal/paypal_ipn.php';
        }
    }
    
    ####  Upgrade membership by BrainTree Payment Gateway ####
    
    public function membershipUpgrade($membership_id=null)
    {
           
        if(!empty($membership_id))
        {
              $row = $this->MembershipPayment->Membership->get($membership_id);
               $this->set("data", $row->toArray());
        }
        
    }

    public function isAuthorized($user) {
        $role_name = $user["role_name"];
        $curr_action = $this->request->action;
        $members_actions = ["paymentList", "paymentSuccess", "ipnFunction"];
        $staff_actions = ["paymentList", "addIncome", "incomeList", "expenseList", "addExpense", "incomeEdit", "expenseEdit"];
        $acc_actions = ["paymentList", "addIncome", "incomeList", "expenseList", "addExpense", "incomeEdit", "expenseEdit"];
        switch ($role_name) {
            CASE "member":
                if (in_array($curr_action, $members_actions)) {
                    return true;
                } else {
                    return false;
                }
                break;

            CASE "staff_member":
                if (in_array($curr_action, $staff_actions)) {
                    return true;
                } else {
                    return false;
                }
                break;

            CASE "accountant":
                if (in_array($curr_action, $acc_actions)) {
                    return true;
                } else {
                    return false;
                }
                break;
        }
        return parent::isAuthorized($user);
    }
    //public function isAuthorized($user){
        //return parent::isAuthorizedCustom($user);
    //}

}
