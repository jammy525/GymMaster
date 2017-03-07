<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Database\Expression\IdentifierExpression;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

Class ResetPasswordController extends AppController {

    public function initialize() {
        parent::initialize();
        //$this->loadComponent('Csrf');
        $this->loadComponent("GYMFunction");
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index','resetPasswordToken']);
        
    }

    public function index() {
        $session = $this->request->session()->read("User");
        $session_w = $this->request->session();
        if($session["id"]){
            return $this->redirect(["controller"=>"Dashboard"]);
            die;
        }
        $this->viewBuilder()->layout('login');
        
        if ($this->request->is("post")) {
            $email = $this->request->data["email"];
            
            if ( $email != "" && preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,8})$/", $email) ) {
                $user = $this->ResetPassword->findByEmail($email)->first();
                if (!empty($user) ) {
                    $user = $this->__generatePasswordToken($user);
                    //$this->GYMFunction->pre($user);
                    if ( $this->ResetPassword->save($user) && $this->__sendForgotPasswordEmail($user) ) {
                        $this->Flash->success('Password reset instructions have been sent to your email address. You have 24 hours to complete the request.');
                        return $this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__("This email is not associated with our system."));
                    return $this->redirect($this->referer());
                }
                
            } else{
                $this->Flash->error(__("Please insert the correct email address."));
		return $this->redirect($this->referer());
            } 
        }
    }

    /**
     * Allow user to reset password if $token is valid.
     * @return
     */
    public function resetPasswordToken($reset_password_token = null) {
        if($reset_password_token == null){
            return $this->redirect(["controller"=>"users"]);
            die;
        }
        
        $this->data = $this->ResetPassword->findByResetPasswordToken($reset_password_token)->first();
        if (!empty($this->data['reset_password_token']) && !empty($this->data['token_created_at']) && $this->__validToken($this->data['token_created_at'])) {
            $_SESSION['token'] = array(
                                        "reset_password_token"=>$reset_password_token,
                                        "token_created_at"=>$this->data['token_created_at'],
                                    );
        } else {
            $this->Flash->error(__('The password reset request has either expired or is invalid.'));
            return $this->redirect(["controller"=>"users"]);
            die;
        }
            
        if($this->request->is("post")){
            //$this->GYMFunction->pre($this->request->data["password"]);
            if ($this->data['reset_password_token'] != $_SESSION['token']['reset_password_token'] && $this->data['token_created_at'] != $_SESSION['token']['token_created_at']) {
                $this->Flash->error(__('The password reset request has either expired or is invalid.'));
                return $this->redirect(["controller"=>"users"]);
                die;
            }

            $user = $this->ResetPassword->findByResetPasswordToken($this->data['reset_password_token'])->first();
            //$user->id = $user['id'];
            $hasher = new DefaultPasswordHasher();
            $user['password'] = $hasher->hash($this->request->data["password"]);

            if ($this->ResetPassword->save($this->data, array('validate' => 'only'))) {
                $user->data['reset_password_token'] = $this->data['token_created_at'] = null;
                $user['reset_password_token'] = $user['token_created_at'] = null;
                if ($this->ResetPassword->save($user) && $this->__sendPasswordChangedEmail($user)) {
                    unset($_SESSION['token']);
                    $this->Flash->success(__('Your password was changed successfully. Please login to continue.'));
                    return $this->redirect(["controller"=>"users"]);
                    die;
                }
            }
        }
        $this->viewBuilder()->layout('login');
        
    }
    /**
     * Generate a unique hash / token.
     * @param Object User
     * @return Object User
     */
    function __generatePasswordToken($user) {
        if (empty($user)) {
            return null;
        }
        $hasher = new DefaultPasswordHasher();
        
        // Generate a random string 100 chars in length.
        $token = "";
        for ($i = 0; $i < 100; $i++) {
            $d = rand(1, 100000) % 2;
            $d ? $token .= chr(rand(33,79)) : $token .= chr(rand(80,126));
        }
        (rand(1, 100000) % 2) ? $token = strrev($token) : $token = $token;
        // Generate hash of random string
        $hash = $hasher->hash($token, 'sha256', true);;
        for ($i = 0; $i < 20; $i++) {
            $hash = $hasher->hash($hash, 'sha256', true);
        }
        $user['reset_password_token'] = str_replace('/', '%', $hash);
        $user['token_created_at']     = date('Y-m-d H:i:s');
        return $user;
    }
    /**
     * Validate token created at time.
     * @param String $token_created_at
     * @return Boolean
     */
    function __validToken($token_created_at) {
        $expired = strtotime($token_created_at) + 86400;
        $time = strtotime("now");
        if ($time < $expired) {
            return true;
        }
        return false;
    }
    /**
     * Sends password reset email to user's email address.
     * @param $id
     * @return
     */
    function __sendForgotPasswordEmail($user = null) {
        if (!empty($user)) {
            $mailArr = [
                    "template"=>"forgot_pass_mail",
                    "subject"=>"Password Reset Request",
                    "emailFormat"=>"html",
                    "to"=>$user['email'],
                    "addTo"=>"jameel.ahmad@rnf.tech",
                    "cc"=>"imran.khan@rnf.tech",
                    "addCc"=>"jameel.ahmad@rnf.tech",
                    "bcc"=>"jameel.ahmad@rnf.tech",
                    "addBcc"=>"jameel.ahmad@rnf.tech",
                    "viewVars"=>[
                            'name'=>$this->GYMFunction->get_user_name($user['id']),
                            'email'=>$user['email'],
                            'link'=>$user['reset_password_token']
                        ]
                ];
            return $this->GYMFunction->sendEmail($mailArr);
        }
        return false;
    }
    /**
     * Notifies user their password has changed.
     * @param $id
     * @return
     */
    function __sendPasswordChangedEmail($user = null) {
        if (!empty($user)) {
            $mailArr = [
                    "template"=>"forgot_pass_change_mail",
                    "subject"=>"Password Reset Request success",
                    "emailFormat"=>"html",
                    "to"=>$user['email'],
                    "addTo"=>"jameel.ahmad@rnf.tech",
                    "cc"=>"imran.khan@rnf.tech",
                    "addCc"=>"jameel.ahmad@rnf.tech",
                    "bcc"=>"jameel.ahmad@rnf.tech",
                    "addBcc"=>"jameel.ahmad@rnf.tech",
                    "viewVars"=>[
                            'name'=>$this->GYMFunction->get_user_name($user['id'])
                        ]
                ];
            return $this->GYMFunction->sendEmail($mailArr);
        }
        return false;
    }

}
