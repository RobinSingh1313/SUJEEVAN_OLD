<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends CI_Controller{
        public function __construct() {
                parent::__construct();
        }
        public function index(){
                if($this->session->userdata("login_id") != ''){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
                $darta  =   array(
                    'title'     =>  "Login",
                    "content"   =>  "login"
                );
                $remember   =   "0";
                if(isset($_COOKIE['cookieuser']) && isset($_COOKIE['cookiepassword'])){
                    $darta["adminUsername"] = $_COOKIE['cookieuser'];
                    $darta["adminPassword"] = base64_decode($_COOKIE['cookiepassword']);
                    $remember = 1;
                }
                if($remember == 1) { $chkd = 'checked'; } else{ $chkd = ''; }
                $darta["selRemeber"]  =   $chkd;
                if($this->input->post("submit")){
                    $this->form_validation->set_rules("username","Email ID /Username","xss_clean|required|callback_checkemail");
                    $this->form_validation->set_rules("password","Password","required|xss_clean|xss_clean|min_length[2]|max_length[50]");
                    if($this->form_validation->run() == TRUE){
                        $adminUsername     =   $this->input->post("username");
                        $adminPassword     =   $this->input->post("password");
                        if(isset($_POST['remember']) && $_POST['remember'] == 1){
                            setcookie("cookieuser", $adminUsername, time()+3600 , "/");
                            $password = base64_encode($adminPassword);
                            setcookie("cookiepassword",$password, time()+60*60*24*30 , "/");
                        }
                        else{
                            setcookie("cookieuser", $adminUsername, time()+(-3600) , "/");
                            setcookie("cookiepassword", $adminPassword, time()+(-3600) , "/");
                        }
                        $ins    =   $this->login_model->checkLogin();
                        if($ins){
                            $this->session->set_flashdata("suc","Welcome to ".$this->session->userdata("login_name"));
                            redirect(sitedata("site_admin")."/Dashboard");
                        }else{
                            $this->session->set_flashdata("err","Login failed");
                            redirect(sitedata("site_admin")."/");
                        }
                    }
                }
                $this->load->view("outer_template",$darta);
        }
        public function forgot(){
                $darta  =   array(
                    'title'     =>  "Forgot Password",
                    "content"   =>  "forgotpassword"
                );
                if($this->input->post("submit")){
                    $this->form_validation->set_rules("emailid","Email ID","valid_email|xss_clean|required|callback_checkemail"); 
                    if($this->form_validation->run() == TRUE){
                        $ins    =   $this->login_model->sendpassword();
                        if($ins){
                            $this->session->set_flashdata("suc","A password has been sent to registered mail.Please check them and login.");
                            redirect(sitedata("site_admin"));
                        }else{
                            $this->session->set_flashdata("err","Password has been not sent to the registered mail.");
                            redirect(sitedata("site_admin")."/Forgot-Password");
                        }
                    }
                }
                $this->load->view("outer_template",$darta);
        }
        public function checkemail($str){
            $vsp	=	$this->login_model->checkvalueemail($str); 
            if(!$vsp){
                $this->form_validation->set_message("checkemail","Emaild ID /Username does not exists.");
                return FALSE;
            }	 
            return TRUE; 	
        }	
        public function checkusernameexist(){
                $emailid    =   $this->input->post("username");
                $vsap   =   $this->login_model->checkvalueemail($emailid);
                echo ($vsap)?"true":"false";
        }
        public function checkemailexist(){
                $emailid    =   $this->input->post("emailid");
                $vsap       =   $this->login_model->checkvalueemailuser($emailid);
                echo ($vsap)?"true":"false";
        }
        public function logout(){
                $this->session->sess_destroy();
                redirect("/");
        }
}