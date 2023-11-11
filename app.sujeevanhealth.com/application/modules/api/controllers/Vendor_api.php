<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vendor_api extends CI_Controller{
    public function __construct() {
            parent::__construct();
            $sv     =   $this->api_model->checkAuthorizationvalid();
            $dta    =   $this->api_model->jsonencode("0","Authorization key Invalid");
            if($sv != "1"){
                echo $dta;exit;
            }
    }
    public function register(){
        $sv    =   $this->api_model->checkAuthorizationvalid();
        $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
        if($sv == "1"){
            $dta	=	$this->api_model->jsonencode("1","Some fields are required");
            if($this->input->post('mobile_no')!='' && $this->input->post('email')!='' && $this->input->post('password')!=''){
                $vvpl   =   $this->api2_model->checkUnique();
                $dta	=	$this->api_model->jsonencode("2","Email or Mobile no already exists");
                if(!$vvpl){
                    $dta	=   $this->api_model->jsonencode("3","Not registered.Please try again");
                    $thi        =   $this->api2_model->signup();
                    if($thi){
                        $dta	=   $this->api_model->jsonencode("4","OTP has been sent successfully");
                    }
                }
            }
        }
        echo ($dta);
    }
    public function sendotp(){
        $json       =   $this->api_model->jsonencode("1","Mobile No. is required");
        if($this->input->post("mobile_no") != ""){ 
            $eck  =   $this->api2_model->checkregacstatus();
            $json   =   $this->api_model->jsonencode("5","Don’t have an account yet? Create one");
            if($eck==1){
              $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            }else if($eck!= false){
                $jon        =   $this->api_model->sendotp("1");
                $json       =   $this->api_model->jsonencode('3', "OTP has been not sent.Please try again");
                if($jon){
                    $json   =   $this->api_model->jsonencode('4', "OTP has been sent successfully");
                } 
            }
        }
        echo ($json);
    }
    public function otp_verify(){ 
        $json   =   $this->api_model->jsonencode("1","Mobile No. and OTP are required");
        if($this->input->post("mobile_no") != "" && $this->input->post("otp_no") != ""){
            $eck  =   $this->api2_model->checkregacstatus();
            if($eck != 1){
                $json   =   $this->api_model->jsonencode('2', "OTP has been expired or not valid");
                $ins    =   $this->api_model->verifyotp();
                if($ins){					
                    $profile    =   $this->api2_model->getProfile();
                    if($profile["regvendor_vendor_id"] == ""){
                        $data["regvendor_id"]       =   $profile["regvendor_id"];
                        $data["vendors"]            =   $this->api_model->vendors();
                        $json                       =   $this->api_model->jsonencode('3',$data);
                    }else{
                        $json                       =   $this->api_model->jsonencode('5',$profile);
                    }
                }
            }else {
                $json   =   $this->api_model->jsonencode("4","Mobile No. has been blocked.Please contact administrator");
            }
        }
        echo $json;
    }
    public function forget_password_change(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('password') != '' && $this->input->post('mobile_no') != ''){
                $eck  =   $this->api2_model->checkregacstatus();
                $dta   =   $this->api_model->jsonencode("5","Mobile Number is not registered.");
                if($eck==1){
                  $dta   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
                }else if($eck!= false){
                    $jon        =   $this->api2_model->forget_password_change();
                    $dta       =   $this->api_model->jsonencode('4', "Failed to change password");
                    if($jon){
                        $dta   =   $this->api_model->jsonencode('3', "Password changed");
                    } 
                }
        }
        echo ($dta);    
    }
    public function vendors(){
        $ppunt  =   $this->api_model->vendors();
        $dta    =   $this->api_model->jsonencode("1",$ppunt);
        echo ($dta);
    }
    public function vendoriconcreate(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('vendor_id') != ''){
            $vvpl   =   $this->api2_model->vendorsview();
            $dta    =	$this->api_model->jsonencode("2","Vendor does not exists");
            if(is_array($vvpl) && count($vvpl) > 0){
                $dta   =   $this->api_model->jsonencode("3",$vvpl);
            }
        }
        echo ($dta);  
    }
    public function cities(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('state_id') != '' ){
            $vvpl   =   $this->api2_model->viewDistricts();
            $dta    =	$this->api_model->jsonencode("2","State does not exists");
            if(is_array($vvpl) && count($vvpl) > 0){
                $dta   =   $this->api_model->jsonencode("3",$vvpl);
            }
        }
        echo ($dta);  
    }
    public function measures(){
        $vvpl   =   $this->api2_model->viewmeasures();
        $dta    =	$this->api_model->jsonencode("1","Measures are not available");
        if(is_array($vvpl) && count($vvpl) > 0){
            $dta   =   $this->api_model->jsonencode("2",$vvpl);
        }
        echo ($dta);  
    }
    public function alldata(){
        $sv    =   $this->api_model->checkAuthorizationvalid();
        $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
        if($sv == "1"){
            $ppunt  =   array(
                "specialization"    =>  $this->api2_model->viewSpecialization(),
                "states"            =>  $this->api2_model->viewStates()
            );
            $dta   =   $this->api_model->jsonencode("1",$ppunt);
        }
        echo ($dta);
    }
    public function splash(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""  && $this->input->post("device_os")!='' && $this->input->post("app_type")!='' && $this->input->post("version_no")!=''){
            $vsao   =   $this->api_model->viewappversion();
            // echo "<pre>";print_R($vsao);exit;
            if(count($vsao) > 0){
                $json   =   $this->api_model->jsonencode("7","Update APP Version");
            }else{
                $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
                $eck    =   $this->api2_model->checkregacstatus();
                if($eck == 3){
                    $profile    =   $this->api2_model->getProfile();
                    if($profile["regvendor_vendor_id"] != ""){
                        $days_av   =   $this->api2_model->get_vendor_availability_days($profile["regvendor_id"]);
                        // echo $profile["regvendor_vendor_id"].count($days_av);
                        if(count($days_av)>0 || empty($profile["regvendor_vendor_id"]) || $profile["regvendor_vendor_id"]== '10VT' || $profile["regvendor_vendor_id"]== '11VT' || $profile["regvendor_vendor_id"]== '9VT'){
                            // print_r($profile["regvendor_vendor_id"]);exit;
                            $json       =   $this->api_model->jsonencode('5',$this->api2_model->dashboard());
                        }else{
                            // print_r(count($days_av));exit;
                            $data["regvendor_id"]       =   $profile["regvendor_id"];
                            $data["vendors"]            =   $this->api_model->vendors();
                            $json       =   $this->api_model->jsonencode('6',$data);
                        }
                        
                    }else{
                        $data["regvendor_id"]       =   $profile["regvendor_id"];
                        $data["vendors"]            =   $this->api_model->vendors();
                        $json                       =   $this->api_model->jsonencode('3',$data);
                        // $json       =   $this->api_model->jsonencode('3',$profile);
                        
                    }
                }
                if($eck == 2){
                    $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
                }
            }
        }
        echo $json;
    }
    public function token(){
        $data   =   $this->api_model->jsonencode('0',"some feilds are required",'0');
        if($this->input->post("firebase_token") != "" && $this->input->post("regvendor_id") != ""){
            $isn    =   $this->api2_model->saveToken("Vendor");
            $data   =   $this->api_model->jsonencode('2',"Token has been not saved.Please try again.",'0');
            if($isn){
                $data   =   $this->api_model->jsonencode('1',"Token has been saved successfully",'0');
            }
        }
            echo json_encode($data);
    } 
    public function login(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')!= '' && $this->input->post('password') != ''){
            $dta    =   $this->api_model->jsonencode('2',"Check Email Id/Mobile or Password");
            $res    =   $this->api2_model->login();
            if($res){
                $profile    =   $this->api2_model->getProfile();
                if($profile["regvendor_otp"] == "0"){
                    $dta       =   $this->api_model->jsonencode('4',"OTP Not verified");
                }
                else if($profile["regvendor_vendor_id"] == ""){
                    $data["regvendor_id"]       =   $profile["regvendor_id"];
                    $data["vendors"]            =   $this->api_model->vendors();
                    $dta                        =   $this->api_model->jsonencode('3',$data);
                }
                else{
                    $days_av   =   $this->api2_model->get_vendor_availability_days($profile["regvendor_id"]);
                    if(count($days_av)>0 || empty($profile["regvendor_vendor_id"]) || $profile["regvendor_vendor_id"]== '10VT' ||  $profile["regvendor_vendor_id"]== '11VT' || $profile["regvendor_vendor_id"]== '9VT'){
                        $dta       =   $this->api_model->jsonencode('5',$this->api2_model->dashboard());
                    }else{
                        $data["regvendor_id"]       =   $profile["regvendor_id"];
                        $data["vendors"]            =   $this->api_model->vendors();
                        $dta       =   $this->api_model->jsonencode('6',$data);
                    }
                }
            }
        }
        echo ($dta);
    }
    public function logout(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')  !=  ''){
            $dta    =   $this->api_model->jsonencode('2',"Logout failed");
            $res    =   $this->api2_model->logout();
            if($res){
                $dta   =   $this->api_model->jsonencode('3',"Logged out Successfully");
            }
        }
        echo ($dta);
    }
    public function create_profile(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('full_name') != '' && $this->input->post('state') != '' && $this->input->post('city') != '' && $this->input->post('regvendor_id') !=  '' && $this->input->post('vendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("3","Not created profile.Please try again");
                $thi    =   $this->api2_model->updateprofile();
                if($thi){
                    $dta	=   $this->api_model->jsonencode("4","Registered successfully");
                }
            }
        }
        echo ($dta);    
    }
    public function update_profile(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                if($this->input->post('full_name') != '' && $this->input->post('state') != '' && $this->input->post('city') != ''){
                    $thi    =   $this->api2_model->updateprofile();
                }
                $dta	=   $this->api_model->jsonencode("3",$this->api2_model->getProfile());
            }
        }
        echo ($dta);    
    }
    public function stage_profile(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("3","Not updated profile.Please try again");
                $thi    =   $this->api2_model->stage_profile();
                if($thi){
                    $dta	=   $this->api_model->jsonencode("4",$this->api2_model->dashboard());
                }
            }
        }
        echo ($dta);    
    }
    public function changepassword(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('current_password') != '' && $this->input->post('new_password') != '' && $this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("3","Not updated any Password.Please try again");
                $thi    =   $this->api2_model->changepassword();
                if($thi == 1){
                    $dta	=   $this->api_model->jsonencode("5","Current and New Password are same");
                }
                if($thi == 2){
                    $dta	=   $this->api_model->jsonencode("4","Password had been changed successfully");
                }
                if($thi == 3){
                    $dta	=   $this->api_model->jsonencode("3","your old password is incorrect");
                }
            }
        }
        echo ($dta);    
    }
    public function rating(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  '' && $this->input->post('rating') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("3","Not sent any rating.Please try again");
                $thi    =   $this->api2_model->ratingpanel();
                if($thi){
                    $dta	=   $this->api_model->jsonencode("4","Rating had been sent successfully");
                }
            }
        }
        echo ($dta);    
    }
    public function packages(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("4","No packages are available");
                if($this->input->post('regpackage_service_name') !=  '' && $this->input->post('regpackage_service_price') !=  ''){
                    $thi    =   $this->api2_model->servicepackages();
                }
                if($this->input->post('regpackage_del_status') ==  '1'){
                    $thi    =   $this->api2_model->deleteservicepackages();
                }
                $vpspackages    =   $this->api2_model->packages();
                if(is_array($vpspackages) && count($vpspackages) > 0){
                    $dta	=   $this->api_model->jsonencode("3",$vpspackages);
                }
            }
        }
        echo ($dta);    
    }
    public function support(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $supo   =   array(
                    "site_email"    => sitedata("site_email"),
                    "site_contact"  => sitedata("site_contact"),
                );
                $dta	=   $this->api_model->jsonencode("3",$supo);
            }
        }
        echo ($dta);    
    }
    public function accounts(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("4","No accounts are available");
                if($this->input->post('regbank_name') !=  '' && $this->input->post('regbank_bank_name') !=  '' && $this->input->post('regbank_ifsc') !=  '' && $this->input->post('regbank_account_no') !=  ''){
                    $thi    =   $this->api2_model->bankaccount();
                }
                if($this->input->post('regbank_del_status') ==  '1'){
                    $thi    =   $this->api2_model->deleteBanks();
                }
                $vpspackages    =   $this->api2_model->bankaccountslist();
                if(is_array($vpspackages) && count($vpspackages) > 0){
                    $dta	=   $this->api_model->jsonencode("3",$vpspackages);
                }
            }
        }
        echo ($dta);    
    }
    public function visibility(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("4","No visibility are available");
                if($this->input->post('regbank_state_visible') !=  '' && $this->input->post('regbank_city_visible') !=  ''){
                    $thi    =   $this->api2_model->update_visible();
                }
                $vpspackages    =   $this->api2_model->visibility();
                if(is_array($vpspackages) && count($vpspackages) > 0){
                    $dta	=   $this->api_model->jsonencode("3",$vpspackages);
                }
            }
        }
        echo ($dta);    
    }
    public function blogs(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("4","No Blogs data are available");
                if($this->input->post('blog_title') !=  '' && $this->input->post('blog_description') !=  ''){
                    $thi    =   $this->api2_model->create_bllog();
                }
                if($this->input->post('blog_del_status') ==  "1"){
                    $thi    =   $this->api2_model->delete_blogs();
                }
                $vpspackages    =   $this->api2_model->blogs();
                if(is_array($vpspackages) && count($vpspackages) > 0){
                    $dta	=   $this->api_model->jsonencode("3",$vpspackages);
                }
            }
        }
        echo ($dta);    
    }
    public function queries(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("4","No Blogs data are available");
                if($this->input->post('blog_title') !=  '' && $this->input->post('blog_description') !=  ''){
                    $thi    =   $this->api2_model->update_queries();
                }
                $vpspackages    =   $this->api2_model->queries();
                if(is_array($vpspackages) && count($vpspackages) > 0){
                    $dta	=   $this->api_model->jsonencode("3",$vpspackages);
                }
            }
        }
        echo ($dta);    
    }
    public function availbility(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('regvendor_id') !=  ''){
            $vvpl   =   $this->api2_model->checkUniquevendor();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($vvpl){
                $dta	=   $this->api_model->jsonencode("4","No visibility are available");
                if($this->input->post('regbank_state_visible') !=  '' && $this->input->post('regbank_city_visible') !=  ''){
                    $thi    =   $this->api2_model->update_visible();
                }
                $vpspackages    =   $this->api2_model->availbility();
                if(is_array($vpspackages) && count($vpspackages) > 0){
                    $dta	=   $this->api_model->jsonencode("3",$vpspackages);
                }
            }
        }
        echo ($dta);    
    }
    
    public function qualificaitons(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $data   =   $this->api2_model->qualifications();
                $json   =   $this->api_model->jsonencode('3',$data);
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    /** Earnings ***/
    public function earnings(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $data   =   $this->api2_model->earnings();
                $json   =   $this->api_model->jsonencode('3',$data);
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function register_availability(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                if($this->input->post("availability_from_time") != "" && $this->input->post("availability_available")  != "" && $this->input->post("availability_to_time") != "" && $this->input->post("availability_type") != ""){
                    $datad   =   $this->api2_model->insert_availability();
                }
                $json   =   $this->api_model->jsonencode('5',"No availability list had been available");
                $data   =   $this->api2_model->register_availability();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function transaction(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No transaction history are available");
                $data   =   $this->api2_model->transaction();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function register_appointments(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No Appointments list are available");
                $data   =   $this->api2_model->products();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function vital_medications(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("registration_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any prescription details medications");
                $data   =   $this->api2_model->vital_medications();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function vital_nursemedications(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("registration_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any vital details medications");
                $data   =   $this->api2_model->vital_nursemedications();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function vital_bp(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("vital_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any vital details medications");
                $data   =   $this->api2_model->vital_bp();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function vital_medicationsothers(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("vital_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any vital details medications");
                $data   =   $this->api2_model->vitalmedications();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function products(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No Products list are available");
                if($this->input->post("product_name")  != "" && $this->input->post("product_description") != "" && $this->input->post("actual_price") != ""){
                    $datad   =   $this->api2_model->insert_products();
                }
                if($this->input->post('product_del_status') ==  '1'){
                    $thi    =   $this->api2_model->deleteproducts();
                }
                $data   =   $this->api2_model->products();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function facilites(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No facilites list are available");
                if($this->input->post("facilites_name")  != ""){
                    $datad   =   $this->api2_model->insert_facilites();
                }
                if($this->input->post('facilites_del_status') ==  '1'){
                    $thi    =   $this->api2_model->deletefacilites();
                }
                $data   =   $this->api2_model->facilites();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function specialities(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No specialities list are available");
                if($this->input->post("specialities_name")  != ""){
                    $datad   =   $this->api2_model->insert_specialities();
                }
                if($this->input->post('specialities_del_status') ==  '1'){
                    $thi    =   $this->api2_model->deletespecialities();
                }
                $data   =   $this->api2_model->specialities();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function doctors(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No doctors list are available");
                if($this->input->post("doctors_name")  != ""){
                    $datad   =   $this->api2_model->insert_doctors();
                }
                if($this->input->post('doctors_del_status') ==  '1'){
                    $thi    =   $this->api2_model->deletedoctors();
                }
                $data   =   $this->api2_model->doctors();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function assigned_customer(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('4',"No specialities list are available");
                $data   =   $this->api2_model->assigned_customer();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function assigned_customer_history(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('4',"No specialities list are available");
                $data   =   $this->api2_model->assigned_customer_history();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function prescription_update(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" || $this->input->post("email") != ""){
            
                $json   =   $this->api_model->jsonencode('2',"Not added any prescription");
                $data   =   $this->api2_model->prescription_update();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"submitted prescription successfully");
                }
        }
        echo $json;
    }
    public function prescription(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("registration_id") != ""  || $this->input->post("email") != ""){
            
                $json   =   $this->api_model->jsonencode('2',"No data available");
                $data   =   $this->api2_model->prescription();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            
        }
        echo $json;
    }
    public function prescription_all(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post("registration_id") != "") || $this->input->post("email") != ""){
                $json   =   $this->api_model->jsonencode('2',"No data available");
                $data   =   $this->api2_model->prescription_all();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            
        }
        echo $json;
    }
    public function vital_update(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" || $this->input->post("email") != "" ){
                $json   =   $this->api_model->jsonencode('2',"Not added any vital");
                $data   =   $this->api2_model->vital_update();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"submitted vital successfully");
                }
            
        }
        echo $json;
    }
    public function vital(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post("registration_id") != "") || $this->input->post("email") != ""){
                $json   =   $this->api_model->jsonencode('2',"No data available");
                $data   =   $this->api2_model->vital();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            
        }
        echo $json;
    }
    public function vital_all(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post("registration_id") != "") || $this->input->post("email") != ""){
                $json   =   $this->api_model->jsonencode('2',"No data available");
                $data   =   $this->api2_model->vital_all();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            
        }
        echo $json;
    }
    public function investigation_update(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any investigation");
                $data   =   $this->api2_model->investigation_update();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"submitted investigation successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function investigation(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No data available");
                $data   =   $this->api2_model->investigation();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function result_update(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any result");
                $data   =   $this->api2_model->result_update();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"submitted result successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function result(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No data available");
                $data   =   $this->api2_model->result();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function medication_update(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any medication");
                $data   =   $this->api2_model->medication_update();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"submitted medication successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function medication(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No data available");
                $data   =   $this->api2_model->medication();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function review_update(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not added any review");
                $data   =   $this->api2_model->review_update();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"submitted review successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function review(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No data available");
                $data   =   $this->api2_model->review();
                if(is_array($data) && count($data) > 0){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function appiontment_otp_verify(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != "" && $this->input->post("otp") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not Updated check otp or user appointment");
                $data   =   $this->api2_model->appiontment_otp_verify();
                if($data==1){
                    $json   =   $this->api_model->jsonencode('3',"otp verified");
                }else{
                    $json   =   $this->api_model->jsonencode('6',"wrong otp");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function membership_assign_description(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != "" && $this->input->post("membership_assign_description") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Not Updated Description");
                $data   =   $this->api2_model->membership_assign_description();
                if($data){
                    $json   =   $this->api_model->jsonencode('3','Updated successfully');
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function get_membership_assign_description(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("membership_assign_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No Data Available");
                $data   =   $this->api2_model->get_membership_assign_description();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function blog_modules(){
        $citions["columns"]	=	"sub_module_id as module_id,concat(module_name,'-',sub_module_name) as module_name";
        $citions["whereCondition"]	=	"submodule_isblog = 1";
        $data	=	$this->sub_module_model->viewSub_module($citions);
        $json   =   $this->api_model->jsonencode('3',$data);
        echo $json;
    }
    public function search_facility(){
        $dta    =   $this->api_model->jsonencode('1',"no results available");
        $dsta    =   $this->api2_model->search_facility();
        if($dsta){
        	$dta    =   $this->api_model->jsonencode('3',$dsta);
        }
            
        echo ($dta);
    }
    public function search_speciality(){
        $dta    =   $this->api_model->jsonencode('1',"no results available");
        $dsta    =   $this->api2_model->search_speciality();
        if($dsta){
        	$dta    =   $this->api_model->jsonencode('3',$dsta);
        }
            
        echo ($dta);
    }
    public function search_sub_speciality(){
        $dta    =   $this->api_model->jsonencode('1',"some feilds are missing");
        if(!empty($this->input->post('hospital_specialities_id'))){
            $dta    =   $this->api_model->jsonencode('2',"no results available");
            $dsta    =   $this->api2_model->search_sub_speciality();
            if($dsta){
            	$dta    =   $this->api_model->jsonencode('3',$dsta);
            }
        }
        
            
        echo ($dta);
    }
    public function vendor_availability(){
        $time_slot= $this->db->query("select * from  book_appointment_time_slot")->row_array();
        switch ($time_slot['book_appointment_time_type']) {
          case "0":
            $slot = $time_slot['book_appointment_time']." seconds";
            break;
          case "1":
            $slot = $time_slot['book_appointment_time']." minutes";
            break;
          case "2":
            $slot = $time_slot['book_appointment_time']." hours";
            break;
          case "3":
            $slot = $time_slot['book_appointment_time']." days";
            break;
          default:
        }
        $interval = DateInterval::createFromDateString($slot);
        $begin = new DateTime(date("Y-m-d h:i:s"));
        $end = new DateTime(date("Y-m-d").'T23:59:00');
        // DatePeriod won't include the final period by default, so increment the end-time by our interval
        $end->add($interval);
        
        // Convert into array to make it easier to work with two elements at the same time
        $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));
        
        $start = array_shift($periods);
        
        foreach ($periods as $time) {
            echo $start->format('h:iA'). ' - '. $time->format('h:iA').'<br>';
            $start = $time;
        }
    }
    public function available_slots(){
        $time_slot= $this->db->query("select * from  book_appointment_time_slot")->row_array();
        switch ($time_slot['book_appointment_time_type']) {
          case "0":
            $slot = $time_slot['book_appointment_time']." seconds";
            break;
          case "1":
            $slot = $time_slot['book_appointment_time']." minutes";
            break;
          case "2":
            $slot = $time_slot['book_appointment_time']." hours";
            break;
          case "3":
            $slot = $time_slot['book_appointment_time']." days";
            break;
          default:
        }
        $interval = DateInterval::createFromDateString($slot);
        $now = new DateTime(date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s"))+60*60));
        $begin = new DateTime(date("Y-m-d").'T00:00:00');
        $end = new DateTime(date("Y-m-d").'T23:59:00');
        // DatePeriod won't include the final period by default, so increment the end-time by our interval
        $end->add($interval);
        
        // Convert into array to make it easier to work with two elements at the same time
        $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));
        
        $start = array_shift($periods);
        
        foreach ($periods as $time) {
            if(date("Y-m-d") == date("Y-m-d",strtotime($this->input->post('date')))){
                if($now->format("H:iA") <  $start->format('H:iA')){
                    echo $start->format('h:iA'). ' - '. $time->format('h:iA').'<br>';
                }
            }else{
                echo $start->format('h:iA'). ' - '. $time->format('h:iA').'<br>';
            }
            
            $start = $time;
        }
    }
    public function create_vendor_availability(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("vendor_availability") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Failed");
                $this->availability_validation();// validating before insert data
                $data   =   $this->api2_model->create_vendor_availability();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"Created availability successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function update_vendor_availability(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("vendor_availability") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Failed");
                $data   =   $this->api2_model->update_vendor_availability();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"Updated availability successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function delete_vendor_availability(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("day") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"Failed");
                $data   =   $this->api2_model->delete_vendor_availability();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',"Deleted availability successfully");
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function get_vendor_availability(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No Data Available");
                $data   =   $this->api2_model->get_vendor_availability();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function get_vendor_day_availability(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("regvendor_id") != "" && $this->input->post("day") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck    =   $this->api2_model->checkregacstatus();
            if($eck == 3){
                $json   =   $this->api_model->jsonencode('5',"No Data Available");
                $data   =   $this->api2_model->get_vendor_day_availability();
                if($data){
                    $json   =   $this->api_model->jsonencode('3',$data);
                }
            }
            if($eck == 2){
                $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
            }
        }
        echo $json;
    }
    public function availability_validation(){
        $days_av   =   $this->api2_model->get_vendor_availability_days();
        if(count($days_av)>0){
            $availability = json_decode($this->input->post("vendor_availability"));
            if(is_array($availability) && count($availability) >0){
                $all_days = array();
                foreach($availability as $av){
                    $days = explode(',',$av->Day);
                    if(is_array($days) && count($days) >0){
                        foreach($days as $d){
                            if(in_array(ucfirst(trim($d)),$all_days)){
                                $json   =   $this->api_model->jsonencode('7',ucfirst(trim($d))." repeating 2 or more times");
                                echo $json;exit;
                            }
                            $shifts = $av->Shift;
                            if(is_array($shifts) && count($shifts) >0){ $i=1;
                                foreach($shifts as $s){
                                    if(!empty($s->from) && !empty($s->to)){
                                        if(date("H:i:s",strtotime($s->from)) >= date("H:i:s",strtotime($s->to))){
                                            $json   =   $this->api_model->jsonencode('7',ucfirst(trim($d))." has wrong from and to time combination");
                                            echo $json;exit;
                                        }
                                    }
                                }
                            }
                            array_push($all_days,ucfirst(trim($d)));
                            if(in_array(ucfirst(trim($d)),$days_av)){
                                $json   =   $this->api_model->jsonencode('6',ucfirst(trim($d))." already exists");
                                echo $json;exit;
                            }
                        }
                    }
                }
            }
        }else{
            $availability = json_decode($this->input->post("vendor_availability"));
            if(is_array($availability) && count($availability) >0){
                $all_days = array();
                foreach($availability as $av){
                    $days = explode(',',$av->Day);
                    if(is_array($days) && count($days) >0){
                        foreach($days as $d){
                            if(in_array(ucfirst(trim($d)),$all_days)){
                                $json   =   $this->api_model->jsonencode('7',ucfirst(trim($d))." repeating 2 or more times");
                                echo $json;exit;
                            }
                            $shifts = $av->Shift;
                            if(is_array($shifts) && count($shifts) >0){ $i=1;
                                foreach($shifts as $s){
                                    if(!empty($s->from) && !empty($s->to)){
                                        if(date("H:i:s",strtotime($s->from)) >= date("H:i:s",strtotime($s->to))){
                                            $json   =   $this->api_model->jsonencode('7',ucfirst(trim($d))." has wrong from and to time combination");
                                            echo $json;exit;
                                        }
                                    }
                                }
                            }
                            array_push($all_days,ucfirst(trim($d)));
                        }
                    }
                }
            }
        }
    }
    public function __destruct(){
        $this->db->close();
    }
}