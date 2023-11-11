<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Api extends CI_Controller{
    public function __construct() {
            parent::__construct();
           $sv     =   $this->api_model->checkAuthorizationvalid();
           $dta    =   $this->api_model->jsonencode("0","Authorization key Invalid");
           if($sv != "1"){
               echo $dta;
               exit;
           }
    }
    public function countries(){
        $sv    =   $this->api_model->checkAuthorizationvalid();
        $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
        if($sv == "1"){
            $ppunt  =   array(
                "countries"     =>  $this->api_model->countries()
            );
            $dta   =   $this->api_model->jsonencode("1",$ppunt);
        }
        echo ($dta);
    }
    public function register(){
        $sv    =   $this->api_model->checkAuthorizationvalid();
        $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
        if($sv == "1"){
            $dta	=	$this->api_model->jsonencode("1","Some fields are required");
            if($this->input->post('mobile_no')!='' && $this->input->post('email')!='' && $this->input->post('password')!=''){
                $vvpl   =   $this->api_model->checkUnique();
                $dta	=	$this->api_model->jsonencode("2","Email or Mobile no already exists");
                if(!$vvpl){
                    $dta	=   $this->api_model->jsonencode("3","Not registered.Please try again");
                    $thi        =   $this->api_model->signup();
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
            $eck  =   $this->api_model->checkregacstatus();
              $json   =   $this->api_model->jsonencode("5","Mobile Number is not registered.");
            if($eck==1){
              $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            }else if($eck!= false){
                $jon        =   $this->api_model->sendotp();
                $json       =   $this->api_model->jsonencode('3', "OTP has been not sent.Please try again");
                if($jon){
                    $json   =   $this->api_model->jsonencode('4', "OTP has been sent successfully");
                } 
            }
        }
        echo ($json);
    }
    public function customer_forget_password_change(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('password') != '' && $this->input->post('mobile_no') != ''){
                $eck  =   $this->api_model->checkregacstatus();
                $dta   =   $this->api_model->jsonencode("5","Mobile Number is not registered.");
                if($eck==1){
                  $dta   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
                }else if($eck!= false){
                    $jon        =   $this->api_model->customer_forget_password_change();
                    $dta       =   $this->api_model->jsonencode('4', "Failed to change password");
                    if($jon){
                        $dta   =   $this->api_model->jsonencode('3', "Password changed");
                    } 
                }
        }
        echo ($dta);    
    }
    public function otp_verify(){ 
        $json   =   $this->api_model->jsonencode("1","Mobile No. and OTP are required");
        if($this->input->post("mobile_no") != "" && $this->input->post("otp_no") != ""){
            $eck  =   $this->api_model->checkregacstatus();
            if($eck != 1){
                $json   =   $this->api_model->jsonencode('2', "OTP has been expired or not valid");
                $ins    =   $this->api_model->verifyotp();
                if($ins){					
                    $profile    =   $this->api_model->getProfile();
                    $json       =   $this->api_model->jsonencode('5', "Update Basic details");
                    if($profile["register_name"] != ""){
                        $json       =   $this->api_model->jsonencode('3', $profile);
                    }
                }
            }else {
                $json   =   $this->api_model->jsonencode("4","Mobile No. has been blocked.Please contact administrator");
            }
        }
        echo $json;
    }
    public function login(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')!= '' && $this->input->post('password') != ''){
            $dta    =   $this->api_model->jsonencode('2',"Email Id does not exist.");
            $res    =   $this->api_model->login();
            if($res == 2){
                $dta    =   $this->api_model->jsonencode('2',"Please contact Administrator as your Profile blocked");
            }else if($res == 1){
                $profile    =   $this->api_model->getProfile();
                $dta        =   $this->api_model->jsonencode('4', "Update Basic details");
                if($profile["register_otp"] == "0"){
                    $dta       =   $this->api_model->jsonencode('5',"OTP Not verified");
                }
                if($profile["register_name"] != ""){
                    $dsta       =   $this->api_model->dashboard();
                    $dta       =   $this->api_model->jsonencode('3', $dsta);
                }
            }else{
                $dta    =   $this->api_model->jsonencode('2',"Please check login details");
            }
        }
        echo ($dta);
    }
    public function update_basic_details(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('full_name')!='' && $this->input->post('email')!='' && $this->input->post('age')!=''){
            $dta   =   $this->api_model->jsonencode('2',"Not updated full details please try again");
            $res    =   $this->api_model->add_basic_details();
            if($res){
                // $dash   =   $this->api_model->dashboard();
                $title = 'Sujeevan';
                $message = 'Profile updated successfully';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_pushnotifications($title,$message,$id,'',$push_type,'');
                $dta    =   $this->api_model->jsonencode('3',"updated successfully");
            }
        }
        echo ($dta);
    }
    public function logout(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')  !=  ''){
            $dta    =   $this->api_model->jsonencode('2',"Logout failed");
            $res    =   $this->api_model->logout();
            if($res){
                $dta   =   $this->api_model->jsonencode('3',"Logged out Successfully");
            }
        }
        echo ($dta);
    }
    public function splash(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        
        if($this->input->post("email") != "" && $this->input->post("device_os")!='' && $this->input->post("app_type")!='' && $this->input->post("version_no")!=''){
            $vsao   =   $this->api_model->viewappversion();
            // echo "<pre>";print_R($vsao);exit;
            if(count($vsao) > 0){
                $json   =   $this->api_model->jsonencode("6","Update APP Version");
            }else{
                $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
                $eck  =   $this->api_model->checkregacstatus();
                if($eck == 3){
                    $dsta       =   $this->api_model->dashboard();
                    $json       =   $this->api_model->jsonencode('3',$dsta);
                }
                if($eck == 2){
                    $json    =   $this->api_model->jsonencode('4',"OTP Not verified");
                }
                if($eck == 5){
                    $json    =   $this->api_model->jsonencode('5',"Name Field Empty");
                }   
            }
        }
        echo $json;
    }
    public function changepassword(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('current_password') != '' && $this->input->post('new_password') != '' && $this->input->post('email') !=  ''){
            $eck  =   $this->api_model->checkregacstatus();
            $dta    =	$this->api_model->jsonencode("2","User does not exists");
            if($eck == 3){
              	$dta	=   $this->api_model->jsonencode("3","Not updated any Password.Please try again");
                $thi    =   $this->api_model->changepassword();
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
    public function token(){
        $data   =   $this->api_model->jsonencode('0',"some feilds are required",'0');
        if($this->input->post("firebase_token") != "" && $this->input->post("email") != ""){
            $isn    =   $this->api_model->saveToken("Customer");
            $data   =   $this->api_model->jsonencode('2',"Token has been not saved.Please try again.",'0');
            if($isn){
                $data   =   $this->api_model->jsonencode('1',"Token has been saved successfully",'0');
            }
        }
            echo json_encode($data);
    } 
    public function submodule(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Sub modules are available");
                $dsta    =   $this->api_model->submodules(0);
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function submoduleview(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Sub modules are available");
                $dsta    =   $this->api_model->submodules(1);
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function blogs(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Blog data are available");
            $conditions["columns"]          =    "blog_image,blogid,blog_id,blog_title,blog_alias_name,module_name,blog_description,blogid as blog_images,blog_created_on,blog_created_by";
            $conditions['whereCondition']   =   "moduleid  = '".$this->input->post('module_id')."' and blog_acde = 'Active'";
            $conditions['tipoOrderby']   =   "blogid";
            $conditions['order_by']   =   "desc";
            $conditions['limit']   =   "10";
            $conditions2["columns"]          =    "blog_image,blogid,blog_id,blog_title,blog_alias_name,module_name,blog_description,blogid as blog_images,blog_created_on,blog_created_by";
            $conditions2['whereCondition']   =   "moduleid  = '".$this->input->post('module_id')."' and blog_acde = 'Active'";
                $blog = $this->blog_model->viewBlogList($conditions);
                $blog1 = $this->blog_model->viewBlogList($conditions2);
                $data = array(
                    "general_blogs" => $blog,
                    "most_viewed"   => $this->blog_model->mostViewed($blog1) 
                );
                //$dsta    =   $this->api_model->blogs();
                //$dsta['heart_related']    =   $this->api_model->heart_related_blogs();
              	if(is_array($data) && count($data) > 0){
                	$json    =   $this->api_model->jsonencode('3',$data);
                }
            }
        }
        echo $json;
    }
    public function blogsview(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("blog_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
                $blog_view_check = $this->api_model->blog_view_check();
              	$json    =   $this->api_model->jsonencode('4',"No Blog data are available");
                $dsta    =   $this->api_model->blogsid();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
   public function questions(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No questions data are available");
          		if($this->input->post("module") != "" && $this->input->post("qa_question") != ""){
              	    $dsta    =   $this->api_model->createqueries();
              	}
                $dsta    =   $this->api_model->questions();
                foreach ($dsta as $dkey => $dvalue) {
                    $date = $dvalue['date'];
                    $dsta[$dkey]['date'] = date('d-m-y',strtotime($date));
                    $dsta[$dkey]['answerid'] = $dvalue['answerid'];
                    $user_id = $dvalue['qa_created_by'];
                    $regvendor = $dvalue['ans_regvendor_id'];
                    $pms["whereCondition"]  =   "(registration_id = '".$user_id."')";
                    $get_user     =   $this->registration_model->getRegistration($pms);
                    $target_dir             =   base_url().$this->config->item("upload_dest")."user";
                    if(is_array($get_user) and count($get_user)>0)
                    {
                        $user_name = $get_user['register_name'];
                        $user_image = $get_user['register_image'];
                        $dsta[$dkey]['user_name'] = $user_name;
                        if($user_image!='')
                        {
                        $dsta[$dkey]['user_image'] = $target_dir.'/'.$user_image;
                        }
                        else
                        {
                         $dsta[$dkey]['user_image'] = "";   
                        }
                    }
                    else
                    {
                       $dsta[$dkey]['user_name'] = ""; 
                       $dsta[$dkey]['user_image'] = "";
                    }
                    $condition["whereCondition"]    =   "regvendor_id = '".$regvendor."'";
                    $vpo    =   $this->vendor_registration_model->getRegistration($condition);
                    if(is_array($vpo) && count($vpo) > 0)
                    {
                        $doctor_name = $vpo['regvendor_name'];
                        $dsta[$dkey]['doctor_name'] = $doctor_name;
                    }
                    else
                    {
                        $dsta[$dkey]['doctor_name'] = "";
                    }
                    unset($dsta[$dkey]['qa_created_by']);
                    unset($dsta[$dkey]['qa_modified_by']);
                }
                //print_r($dsta);exit;
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function user_questions(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
                $json    =   $this->api_model->jsonencode('4',"No questions data are available");
                $dsta    =   $this->api_model->user_questions();
                foreach ($dsta as $dkey => $dvalue) {
                    $date = $dvalue['date'];
                    $dsta[$dkey]['date'] = date('d-m-y',strtotime($date));
                    $user_id = $dvalue['qa_created_by'];
                    $regvendor = $dvalue['qa_modified_by'];
                    if($dvalue['ans_answer']==null)
                    {
                       $dsta[$dkey]['ans_answer'] = ""; 
                    }
                    $pms["whereCondition"]  =   "(registration_id = '".$user_id."')";
                    $get_user     =   $this->registration_model->getRegistration($pms);
                    $target_dir             =   base_url().$this->config->item("upload_dest")."user";
                    if(is_array($get_user) and count($get_user)>0)
                    {
                        $user_name = $get_user['register_name'];
                        $user_image = $get_user['register_image'];
                        $dsta[$dkey]['user_name'] = $user_name;
                        if($user_image!='')
                        {
                        $dsta[$dkey]['user_image'] = $target_dir.'/'.$user_image;
                        }
                        else
                        {
                         $dsta[$dkey]['user_image'] = "";   
                        }
                    }
                    else
                    {
                       $dsta[$dkey]['user_name'] = ""; 
                       $dsta[$dkey]['user_image'] = "";
                    }
                    $condition["whereCondition"]    =   "regvendor_id = '".$regvendor."'";
                    $vpo    =   $this->vendor_registration_model->getRegistration($condition);
                    if(is_array($vpo) && count($vpo) > 0)
                    {
                        $doctor_name = $vpo['regvendor_name'];
                        $dsta[$dkey]['doctor_name'] = $doctor_name;
                    }
                    else
                    {
                        $dsta[$dkey]['doctor_name'] = "";
                    }
                    unset($dsta[$dkey]['qa_created_by']);
                    unset($dsta[$dkey]['qa_modified_by']);
                }
                //print_r($this->db->last_query());exit;
                if(is_array($dsta) && count($dsta) > 0){
                    $json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function multiple_answer_list()
    {
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "")
        {   
            $pms["whereCondition"]  =   "(register_email = '".$this->input->post('email')."')";
            $pms["columns"]         =   "registration_id";
            $get_user     =   $this->registration_model->getRegistration($pms);   
            $list = $this->api_model->question_list();
            
            $json   =   $this->api_model->jsonencode("2","Questions list empty");

            if(is_array($list) && count($list) > 0)
            {
               
                $data['question_info'] = array(
                    'qa_id' => $list['qa_id'],
                    'question' => $list['qa_question']
                );
                $answers_list = $this->api_model->multiple_answer_list();
                $json   =   $this->api_model->jsonencode("4","Answers list empty");
                if(is_array($answers_list) and count($answers_list))
                {
                    $target_dir             =   base_url().$this->config->item("upload_dest")."vendors/";
                    $count = count($answers_list);
                    $data['question_info']['count'] = $count;
                    foreach ($answers_list as $akey => $avalue) {
                        $answered_date = date('d-m-y',strtotime($avalue['created_at']));
                        $condition["columns"] = "regvendor_id,regvendor_name,specialization_name,,concat('".$target_dir."',regvendor_upload_picture) as doctor_image,regvendor_experience_yrs";
                        $condition["whereCondition"]    =   "regvendor_id = '".$avalue['ans_regvendor_id']."'";
                        $vpo    =   $this->vendor_registration_model->getRegistration($condition);
                        $likes_status = $this->api_model->likes_count($avalue['answerid'],$get_user['registration_id']);
                        $data['answers_list'][$akey]['answerid'] = $avalue['answerid'];
                        $data['answers_list'][$akey]['answer'] = $avalue['ans_answer'];
                        if($avalue['answer_image'] != NULL)
                        {
                        $data['answers_list'][$akey]['answer_image'] = $avalue['answer_image'];
                        }
                        else
                        {
                         $data['answers_list'][$akey]['answer_image'] = "";  
                        }
                        $data['answers_list'][$akey]['doctor_id'] = $vpo['regvendor_id'];
                        $data['answers_list'][$akey]['doctor_name'] = $vpo['regvendor_name'];
                        $data['answers_list'][$akey]['doctor_specialization'] = $vpo['specialization_name'];
                        $data['answers_list'][$akey]['doctor_experience'] = $vpo['regvendor_experience_yrs'];
                        $data['answers_list'][$akey]['doctor_image'] = $vpo['doctor_image'];
                        $data['answers_list'][$akey]['answer_date'] = $answered_date;
                        $data['answers_list'][$akey]['likes'] = $likes_status;
                    }
                    $json    =   $this->api_model->jsonencode('3',$data);
                }
            }
        }
        echo $json;
    }
    public function homepackages(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Home Packages data are available");
                $dsta    =   $this->api_model->homepackages();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function hometest(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Home Tests data are available");
                $dsta    =   $this->api_model->hometest();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function getPackages(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("package_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Home Packages data are available");
                $dsta    =   $this->api_model->getPackages();
              	if(is_array($dsta) && count($dsta) > 0){
                    $dstav   =    array(
                        "package"   =>  $dsta,
                        "items"     =>  $this->api_model->subitems()
                    );
                    $json    =   $this->api_model->jsonencode('3',$dstav);
                }
            }
        }
        echo $json;
    }
    public function wellness(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Wheel of Wellness are available");
                $dsta    =   $this->api_model->wellness();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function wellness_details(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("wellness_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"Invalid Wheel of Wellness ID");
                $dsta    =   $this->api_model->wellness_details();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function wellness_contact(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("wellness_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"Contact form submisssion Failed");
                $dsta    =   $this->api_model->create_wellness_contact();
              	if($dsta){
                	$json    =   $this->api_model->jsonencode('3',"Submitted Successfull");
                }
            }
        }
        echo $json;
    }
    public function consultation(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("module_id") != "" && $this->input->post("sub_module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No consultations data are available");
                $dsta    =   $this->api_model->consultation();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function consultationview(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No consultations data are available");
                $dsta    =   $this->api_model->consultationview();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function consultationpackages(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("regvendor_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No consultations packages are available");
                $dsta    =   $this->api_model->consultationpackages();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function chatroom(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Messages are available");
              	if($this->input->post("message")  != ""){
              	    $dta    =   $this->api_model->chatroom_create();    
              	}
            //   	if($this->input->post("message")==''){
            //         $dsta = array(array("from_message" => '' , "to_message" => "Hi, welcome to Sujeevan Health"),array("from_message" => '' , "to_message" => "Please let us know how we can help you."));
            //     }else{
                    $dsta = array(array("from_message" => '' , "to_message" => "Hi, welcome to Sujeevan Health"),array("from_message" => '' , "to_message" => "Please let us know how we can help you."));
                    $daata    =   $this->api_model->chatroom();
                    if(count($daata)>0){
                        $dsta = array(array("from_message" => '' , "to_message" => "Hi, welcome to Sujeevan Health"));
                        array_push($dsta,array("from_message" => '' , "to_message" => "Please let us know how we can help you."));
                        foreach($daata as $d){
                            array_push($dsta,$d);
                        }
                        // $dsta = array($dsta);
                    }
                // }
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function symptoms_checker(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
            	$json    =   $this->api_model->jsonencode('4',"No list are available");
                $dsta    =   $this->api_model->symptoms_checker();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function consultdoctors(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
            	$json    =   $this->api_model->jsonencode('4',"No list are available");
                $dsta    =   $this->api_model->consultdoctors();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function healthsymptoms(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("healthcategory_id") != ''){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
            	$json    =   $this->api_model->jsonencode('4',"No Health Symptoms are available");
                $dsta    =   $this->api_model->viewsubCategory();
              	if(is_array($dsta) && count($dsta) > 0){
                	$json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function doctors_list(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
           
                $json    =   $this->api_model->jsonencode('4',"No list are available");
                $dsta    =   $this->api_model->doctors_list();
               
              
                if(is_array($dsta) && count($dsta) > 0){
                     foreach ($dsta as $key => $value) 
                     {
                        $consultation = explode(",", $value["regvendor_type_of_consultation"]);
                        $consultation = array_map('trim', $consultation);
                        $dsta[$key]['consultation_type_0']="";
                        $dsta[$key]['consultation_type_1']="";
                        $dsta[$key]['consultation_type_2']="";
                        
                            foreach ($consultation as $key1 => $consult) 
                            {
                                $dsta[$key]['consultation_type_'.$key1]=$consult;
                            }
                        
                    unset($dsta[$key]["regvendor_type_of_consultation"]);
                    }

                    $json    =   $this->api_model->jsonencode('3',$dsta);
                }
            
        }
        echo $json;
    }
    public function vendor_list(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
           
                $json    =   $this->api_model->jsonencode('4',"No list are available");
                $dsta    =   $this->api_model->vendor_list();
               
              
                if(is_array($dsta) && count($dsta) > 0){
                     foreach ($dsta as $key => $value) 
                     {
                        $consultation = explode(",", $value["regvendor_type_of_consultation"]);
                        $consultation = array_map('trim', $consultation);
                        
                        $dsta[$key]['consultation_type_0']="";
                        $dsta[$key]['consultation_type_1']="";
                        $dsta[$key]['consultation_type_2']="";
                        
                            foreach ($consultation as $key1 => $consult) 
                            {
                                $dsta[$key]['consultation_type_'.$key1]=$consult;
                            }
                        
                    unset($dsta[$key]["regvendor_type_of_consultation"]);
                    }

                    $json    =   $this->api_model->jsonencode('3',$dsta);
                }
            
        }
        echo $json;
    }
    public function doctor_info()
    {
        $json = $this->api_model->jsonencode("1","Some fields are required");
        //print_r($this->input->post('email'));exit;
        if($this->input->post('email') != "")
        {
            $regvendor_id = $this->input->post('regvendor_id');
            $result = $this->api_model->doctor_info($regvendor_id);
            if(is_array($result) && count($result)>0)
            {
                $json = $this->api_model->jsonencode('3',$result);
            }
        }
        echo $json;
    }
    public function basic_chatbot()
    {
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email') != "")
        {
            $regvendor_id = $this->input->post('regvendor_id');
            $result = $this->api_model->basic_chatbot($regvendor_id);
            if(is_array($result) && count($result)>0)
            {
                $json = $this->api_model->jsonencode('3',$result);
            }
        }
        echo $json;
    }
    public function basic_chatbot_save()
    {
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email') != "" && $this->input->post('date') != "" && $this->input->post('time') != "" && $this->input->post('regvendor_id') != "")
        {
            
            $json    =   $this->api_model->jsonencode("3","Not saved.Please try again");
            $save_basic_chatbot = $this->api_model->basic_chatbot_save();
            if($save_basic_chatbot)
            {
                $json    =   $this->api_model->jsonencode("4","Saved successfully");
            
                if($this->input->post('regvendor_id') != ""){
                    $fee = ($this->db->query("select regvendor_name as name,regvendor_fee from  register_vendors Where regvendor_id='".$this->input->post('regvendor_id')."'")->row_array())??'No data available';
                        // print_r($fee);exit;
                        if(is_array($fee) && count($fee)>0){
                            $fees = $fee['regvendor_fee'];
                            $name = $fee['name'];
                            $data = array(
                                "time" => $this->input->post('time'),
                                "date" => $this->input->post('date'),
                                "regvendor_id" => $this->input->post('regvendor_id'),
                                "vendor_name" => $name,
                                "fee" => $fees
                            );
                            $json    =   $this->api_model->jsonencode("5",$data);
                        }
                    
                }
            }
        }

        
        echo $json;
    }
    public function payment()
   {
        $json = $this->api_model->jsonencode("1","Some fields are required");
         $payment_id = $this->input->post('payment_id');
        $regvendor_id = $this->input->post('regvendor_id');
        $date = $this->input->post('date');
        $timeslot = $this->input->post('timeslot');
        $email = $this->input->post('email');
        if($email != ""  && $regvendor_id != "" && $date != "" && $timeslot != "" )
        {   
            $check_razar_pays = '';
            $pms["whereCondition"]  =   "(register_email = '".$email."')";
            $get_user     =   $this->registration_model->getRegistration($pms);
            $json = $this->api_model->jsonencode("2","This email not registered");
            if(is_array($get_user) and count($get_user)>0)
            {
                $reg_id = $get_user['registration_id'];
                if(empty($payment_id)){
                    $check_razar_pay = "";
                    $amount = 0;
                    $currency = "INR";
                }else{
                    $check_razar_pay  = $this->check_razar_pay($payment_id);
                    $data             = json_decode($check_razar_pay);//print_r($check_razar_pay);exit;
                    $amount           = ((int)$data->amount)/100;
                    $currency         = $data->currency;
                }
                $check_razar_pays = $this->check_razar_capture($payment_id,$amount,$currency);
        /*if($this->input->post('email') != "")
        {
            $id = $this->input->post('id');
            $doctor_id = $this->input->post('doctor_id');
            $email = $this->input->post('email');
            $pms["whereCondition"]  =   "(register_email = '".$email."')";
            $get_user     =   $this->registration_model->getRegistration($pms);
            $json = $this->api_model->jsonencode("2","This email not registered");
            if(is_array($get_user) and count($get_user)>0)
            {
                $reg_id = $get_user['registration_id'];
                $check_razar_pay = $this->check_razar_pay($id);
                $data =  json_decode($check_razar_pay);
                $amount = ((int)$data->amount)/100;
                $currency = $data->currency;
                // $check_razar_capture = $this->check_razar_capture($id,$amount,$currency);
                $dta = array(
                    'payment_id' => $id,
                    'doctor_id'  => $doctor_id,
                    'user_id'    => $reg_id,
                    'amount'     => $amount,
                    'payment_response' => $check_razar_pay,
                    'currency'   => $currency,
                    'payment_method'=> $data->method
                );
                $save_payment_info = $this->api_model->save_payment_info($dta);*/
                $dta = array(
                    'membership_payment_id'         => $payment_id,
                    'membership_id'                 => "1USPK",
                    'membership_register_id'        => $reg_id,
                    'membership_amount'             => $amount,
                    'membership_payment_response'   => ($check_razar_pays!="")?$check_razar_pays:$check_razar_pay,
                    'membership_taken_on'           => date("Y-m-d H:i:s"),
                    'membership_purchase_on'        => date("Y-m-d H:i:s"),
                    'membership_purchase_by'        => $reg_id,
                );
                $save_payment_info = $this->api_model->bookappointmentMembershipPurchase($dta);
                
                //send notification
                $title = 'Sujeevan Homecare ';
                $message = 'Homecare Package Purchased successful.';
                $id = $reg_id;
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
                //END send notification
                $json    =   $this->api_model->jsonencode("4","Payment Successfull");
            }
        }      
        echo $json;
   }
   public function check_razar_pay($id){
       //print_r($id);exit;
        $url = 'https://api.razorpay.com/v1/payments/'.$id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cnpwX2xpdmVfOGV3dXZwRFhJd3RJbEo6WUV6RFNIaXFjTWZ1a0NIM1F5SE1aM2xz'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);//print_r($response);exit;
        return $response;
    }
    public function check_razar_capture($id,$amount,$currency){
            $amounts = $amount*100;
            $url ="https://api.razorpay.com/v1/payments/".$id."/capture";
            $dta = '{
                        "amount": '.$amount.',
                        "currency": "'.$currency.'"
                    }';
            $dtas = "amount=$amounts&currency=$currency";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$dtas,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Basic cnpwX2xpdmVfOGV3dXZwRFhJd3RJbEo6WUV6RFNIaXFjTWZ1a0NIM1F5SE1aM2xz",
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                    "postman-token: c9f8ecea-6894-7cf6-b506-a9db4abfe09c"
                  ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            return $response;
    }
    public function health_category_list()
    {
            $module_id = $this->input->post('module_id');
            $email = $this->input->post('email');
            $json = $this->api_model->jsonencode("1","Some fields are required");
            if($email != "")
            {
                $json = $this->api_model->jsonencode("4",'list empty');
                $result = $this->api_model->health_category_list();
                if(is_array($result) and count($result)>0)
                {
                $json = $this->api_model->jsonencode("3",$result);
                }
            }
            echo $json;
    }
    public function health_sub_category_list()
    {
            $email = $this->input->post('email');
            $json = $this->api_model->jsonencode("1","Some fields are required");
            if($email != "")
            {
                $json = $this->api_model->jsonencode("4",'list empty');
                $result = $this->api_model->health_sub_category_list();
                if(is_array($result) and count($result)>0)
                {
                $json = $this->api_model->jsonencode("3",$result);
                }
            }
            echo $json;
    }
    public function likes()
    {
        $email = $this->input->post('email');
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($email != "")
        {
            $pms["whereCondition"]  =   "(register_email = '".$email."')";
            $pms["columns"]         =   "registration_id";
            $get_user     =   $this->registration_model->getRegistration($pms);
             $json = $this->api_model->jsonencode("4","Something went wrong");
            if($get_user)
            {
            $registration_id = $get_user['registration_id'];
            $save_likes = $this->api_model->likes($registration_id);
            if($save_likes==1)
            {
                $json = $this->api_model->jsonencode("3","Saved successfully");
            }
            if($save_likes==2)
            {
                $json = $this->api_model->jsonencode("3","Updated successfully");
            }
            
            }
        }
        echo $json;

    }
    public function blog_likes()
    {
        $email = $this->input->post('email');
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($email != "")
        {
            $pms["whereCondition"]  =   "(register_email = '".$email."')";
            $pms["columns"]         =   "registration_id";
            $get_user     =   $this->registration_model->getRegistration($pms);
             $json = $this->api_model->jsonencode("4","Something went wrong");
            if($get_user)
            {
            $registration_id = $get_user['registration_id'];
            $save_likes = $this->api_model->blog_likes($registration_id);
            if($save_likes==1)
            {
                $json = $this->api_model->jsonencode("3","Saved successfully");
            }
            if($save_likes==2)
            {
                $json = $this->api_model->jsonencode("3","Updated successfully");
            }
            
            }
        }
        echo $json;

    }
    public function customer_details()
    {
        $email = $this->input->post('email');
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($email != "")
        {
            $customer_details_save = $this->api_model->customer_details();
            if($customer_details_save == 1)
            {
                $json = $this->api_model->jsonencode("3","Saved successfully");
            }
            else
            {
                $json = $this->api_model->jsonencode("1","Something went wrong");
            }
        }
        echo $json;
    }
    public function booked_dates()
    {
        $email = $this->input->post('email');
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($email != "")
        {
            $result = $this->api_model->booked_dates();
            if(is_array($result) and count($result)>0)
            {
                $json = $this->api_model->jsonencode("2",$result);
            }
            else
            {
                $json = $this->api_model->jsonencode("3",[]);
            }
        }
        echo $json;
    }
    public function check_availability()
    {
        $email = $this->input->post('email');
        $date_type = $this->input->post('date_type');
        $single_date = $this->input->post('single');
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($email != "")
        {
            if($date_type==0)
            {
                $result = $this->api_model->save_single_date($single_date);
                $json = $this->api_model->jsonencode("3","Something went wrong try again"); 
                if($result==TRUE)
                {
                   $json = $this->api_model->jsonencode("2","Single date inserted"); 
                }
            }
            else
            {
                $result = $this->api_model->check_booked_dates();
                if(count($result)>0 and $this->input->post('accept') == 0)
                {
                    $json = $this->api_model->jsonencode("3",$result);
                }
                else
                {
                    $save_multiple_dates = $this->api_model->save_multiple_dates();
                    $json = $this->api_model->jsonencode("2",$save_multiple_dates);
                }
            }
        }
        echo $json;
    }
    public function user_profile()
    {
        $json    =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')!= ''){
            $json    =   $this->api_model->jsonencode('3',"Something went wrong.");
            $user_check          =   $this->api_model->getProfile();
            if(is_array($user_check) and count($user_check)>0)
            {
                $json = $this->api_model->jsonencode("2",$user_check);
            }
        }
        echo ($json);
    }
    public function homecare_chatbot()
    {
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email') != "" && $this->input->post('submodule_id') != "")
        {
            $json = $this->api_model->jsonencode("2","Questions not found");
            $result = $this->api_model->homecare_chatbot();
            if(is_array($result) && count($result)>0)
            {
                $json = $this->api_model->jsonencode('3',$result);
            }
        }
        echo $json;
    }
    public function homecareMembership(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Home Packages data are available");
                $dsta    =   $this->api_model->homecareMembership();
              	if(is_array($dsta) && count($dsta) > 0){
                    $json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function homecare_chatbot_save()
    {
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email') != "" && $this->input->post('submodule_id') != "" && $this->input->post('list') != "")
        {
            
            $json    =   $this->api_model->jsonencode("2","Not saved.Please try again");
            $save_basic_chatbot = $this->api_model->homecare_chatbot_save();
            if($save_basic_chatbot)
            {
                $json    =   $this->api_model->jsonencode("4","Saved successfully");
            }

        }

        
        echo $json;
    }
    public function Doctor_list(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"Doctors are not available");
                $dsta    =   $this->api_model->Doctor_list();
              	if(is_array($dsta) && count($dsta) > 0){
                    $json    =   $this->api_model->jsonencode('3',$dsta);
                }
            }
        }
        echo $json;
    }
    public function homecare_click(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("homecare-click") != "" &&  $this->input->post("sub_module_id") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"Update Failed");
                $dsta    =   $this->api_model->homecare_click();
              	if($dsta){
                    $json    =   $this->api_model->jsonencode('3',"successfully updated");
                }
            }
        }
        echo $json;
    }
    public function homecareMembershipPurchase(){
        $json = $this->api_model->jsonencode("1","Some fields are required");
        $payment_id = $this->input->post('payment_id');
        $membership_id = $this->input->post('membership_id');
        $email = $this->input->post('email');
        if($email != "" && $membership_id != "" && $payment_id != "")
        {   
            $pms["whereCondition"]  =   "(register_email = '".$email."')";
            $get_user     =   $this->registration_model->getRegistration($pms);
            $json = $this->api_model->jsonencode("2","This email not registered");
            if(is_array($get_user) and count($get_user)>0)
            {
                $reg_id = $get_user['registration_id'];
                $check_razar_pay = $this->check_razar_pay($payment_id);
                $data =  json_decode($check_razar_pay);
                $amount = ((int)$data->amount)/100;
                $currency = $data->currency;
                // $check_razar_capture = $this->check_razar_capture($payment_id,$amount,$currency);
                $dta = array(
                    'membership_payment_id'         => $payment_id,
                    'membership_id'                 => $membership_id,
                    'membership_register_id'        => $reg_id,
                    'membership_amount'             => $amount,
                    'membership_payment_response'   => $check_razar_pay,
                    'membership_taken_on'           => date("Y-m-d H:i:s"),
                    'membership_purchase_on'        => date("Y-m-d H:i:s"),
                    'membership_purchase_by'        => $reg_id,
                );
                $save_payment_info = $this->api_model->homecareMembershipPurchase($dta,$reg_id);
                    //send notification
                    $title = 'Sujeevan Homecare ';
                    $message = 'Homecare Package Purchased successful.';
                    $id = $reg_id;
                    $push_type = 'Customer';
                    $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
                $json    =   $this->api_model->jsonencode("4","Payment Successfull");
            }
        }      
        echo $json;
    }
    public function homecare_chatbot_test_ios()
    {
        $json = $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email') != "" && $this->input->post('submodule_id') != "")
        {
            $json = $this->api_model->jsonencode("1","Questions not found");
            $result = $this->api_model->homecare_chatbot_test_ios();
            if(is_array($result) && count($result)>0)
            {
                $json = $this->api_model->jsonencode('3',$result);
            }
        }
        echo $json;
    }
    public function customer_support_request(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("mobile") != ""){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"request submission failed");
                $dsta    =   $this->api_model->customer_support_request();
              	if($dsta){
                	$json    =   $this->api_model->jsonencode('3','request submitted successfully');
                }
            }
        }
        echo $json;
    }
    public function previous_reports(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')!='' || $this->input->post('registration_id')!=''){
            // $dta   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            // $eck  =   $this->api_model->checkregacstatus();
            // if($eck == 3){
              	$dta    =   $this->api_model->jsonencode('4',"failed");
                $dsta    =   $this->api_model->previous_reports();
              	if($dsta){
                	$dta    =   $this->api_model->jsonencode('3',$dsta);
                }
            // }
        }
        echo ($dta);
    }
    public function medicine_list(){
        $dta    =   $this->api_model->jsonencode('1',"no results available");
        $dsta    =   $this->api_model->medicine_list();
             if($dsta){
        	$dta    =   $this->api_model->jsonencode('3',$dsta);
        }
            
        echo ($dta);
    }
    public function lab_test_list(){
        $dta    =   $this->api_model->jsonencode('1',"no results available");
        $dsta    =   $this->api_model->lab_test_list();
        if($dsta){
        	$dta    =   $this->api_model->jsonencode('3',$dsta);
        }
            
        echo ($dta);
    }
    public function purchase_history(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post('email')!='' || $this->input->post('registration_id')!='' )){
            $dsta    =   $this->api_model->purchase_history();
            if($dsta){
            	$dta    =   $this->api_model->jsonencode('3',$dsta);
            }else{
                $dta    =   $this->api_model->jsonencode('2',"no data available");
            }
        }
        echo ($dta);
    }
    public function homecare_daywise(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post('email')!='' || $this->input->post('registration_id')!='' ) && $this->input->post('membership_purchase_id')!=''){
            $dsta    =   $this->api_model->homecare_daywise();
            if($dsta){
            	$dta    =   $this->api_model->jsonencode('3',$dsta);
            }else{
                $dta    =   $this->api_model->jsonencode('2',"no data available");
            }
        }
        echo ($dta);
    }
    public function prescription_history(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post('email')!='' || $this->input->post('registration_id')!='' )){
            $dsta    =   $this->api_model->prescription_history();
            if($dsta){
            	$dta    =   $this->api_model->jsonencode('3',$dsta);
            }else{
                $dta    =   $this->api_model->jsonencode('2',"no data available");
            }
        }
        echo ($dta);
    }
    public function prescription_download(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if(($this->input->post('email')!='' || $this->input->post('registration_id')!='' )){
            $dsta    =   $this->api_model->prescription_download();
            if($dsta){
            	$dta    =   $this->api_model->jsonencode('3',$dsta);
            }else{
                $dta    =   $this->api_model->jsonencode('2',"no data available");
            }
        }
        echo ($dta);
    }
    public function support(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email') !=  ''){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"No Data Available");
                $supo   =   array(
                    "site_email"    => sitedata("site_email"),
                    "site_contact"  => sitedata("site_contact"),
                );
                $dta	=   $this->api_model->jsonencode("3",$supo);
            }
        }
        echo ($dta);    
    }
    public function vaccine_request(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" ){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"Vaccine Request submisssion Failed");
                $dsta    =   $this->api_model->vaccine_request();
              	if($dsta){
                	$json    =   $this->api_model->jsonencode('3',"Vaccine Request Submitted Successfull");
                }
            }
        }
        echo $json;
    }
    public function available_doctors_with_slots(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("time") != "" && $this->input->post("date") != ""){
            $times  =   $this->get_slots();
            // $doctors  =   $this->api_model->get_doctors($times[0]['time']);//echo $times[0]['time'];exit;
            $json    =   $this->api_model->jsonencode('4',"No slots available for selected date");
            if(!empty($times[0])){
                $json    =   $this->api_model->jsonencode('3',array("slots" =>$times));//,"doctors" =>$doctors
            }
            
        }
        echo $json;
    }
    public function available_doctors(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post("email") != "" && $this->input->post("timeslot") != "" && $this->input->post("date") != "" &&  $this->input->post('vendor_id')!=""){
            $doctors  =   $this->api_model->get_doctors($this->input->post("timeslot"));
            $json    =   $this->api_model->jsonencode('3',array("doctors" =>$doctors));
        }
        echo $json;
    }
    public function get_slots(){
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
        $now = new DateTime(date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"))+60*60));
        $now_time = new DateTime(date("h:iA",strtotime($this->input->post('time'))));
        
        $begin = new DateTime(date("Y-m-d").'T00:30:00');
        $end = new DateTime(date("Y-m-d").'T23:30:00');
        // DatePeriod won't include the final period by default, so increment the end-time by our interval
        $end->add($interval);
        
        // Convert into array to make it easier to work with two elements at the same time
        $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));
        
        $start = array_shift($periods);
        $times = array();$i=0;
        foreach ($periods as $time) { 
            if(date("Y-m-d") == date("Y-m-d",strtotime($this->input->post('date')))){ $times[$i] =array();
                if($now->format("H:i:s") <=  $start->format('H:i:s') && $now_time->format("H:i:s") <=  $start->format('H:i:s')){
                    $times[$i]['time'] = $start->format('h:iA'). ' - '. $time->format('h:iA');
                    $i++;
                }
            }else{
                if($now_time->format("H:i:s") <=  $start->format('H:i:s')){
                    $times[$i]['time'] = $start->format('h:iA'). ' - '. $time->format('h:iA');
                    $i++;
                }
            }
            
            $start = $time;
        }
        return $times;
    }
    public function weekdays(){
        $data[0] = array("id" => "Monday","name" => "Monday");
        $data[1] = array("id" =>"Tuesday" ,"name" =>"Tuesday" );
        $data[2] = array("id" =>"Wednesday" ,"name" =>"Wednesday" );
        $data[3] = array("id" =>"Thursday" ,"name" => "Thursday");
        $data[4] = array("id" =>"Friday" ,"name" =>"Friday" );
        $data[5] = array("id" =>"Saturday" ,"name" =>"Saturday" );
        $data[6] = array("id" =>"Sunday" ,"name" =>"Sunday" );
        $json    =   $this->api_model->jsonencode('3',$data);
        echo $json;
    }
    public function bookappointment_request(){
        $json   =   $this->api_model->jsonencode("1","Some fields are required");
        $regvendor_id = $this->input->post('regvendor_id');
        $date = $this->input->post('date');
        $timeslot = $this->input->post('timeslot');
        $email = $this->input->post('email');
        if($email != "" && $regvendor_id != "" && $date != "" && $timeslot != "" ){
            $json   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            $eck  =   $this->api_model->checkregacstatus();
            if($eck == 3){
              	$json    =   $this->api_model->jsonencode('4',"Book Appointment Request submisssion Failed");
                $dsta    =   $this->api_model->bookappointment_request();
              	if($dsta){
                	$json    =   $this->api_model->jsonencode('3',"Book Appointment Request Submitted Successfull");
                }
            }
        }
        echo $json;
    }
    public function notification_history(){
        $json   =   $this->api_model->jsonencode("0","Some fields are required");
        if($this->input->post('email') != "" ){
            $dta    =   $this->api_model->jsonencode('1',"no results available");
            $dsta    =   $this->api_model->notification_history();
            if($dsta){
            	$dta    =   $this->api_model->jsonencode('3',$dsta);
            }
        }    
        echo ($dta);
    }
    public function health_files(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')!='' || $this->input->post('registration_id')!=''){
            // $dta   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            // $eck  =   $this->api_model->checkregacstatus();
            // if($eck == 3){
              	$dta    =   $this->api_model->jsonencode('4',"failed");
                $dsta    =   $this->api_model->health_files();
              	if($dsta){
                	$dta    =   $this->api_model->jsonencode('3',$dsta);
                }
            // }
        }
        echo ($dta);
    }
    public function delete_health_files(){
        $dta	=	$this->api_model->jsonencode("1","Some fields are required");
        if($this->input->post('email')!='' && $this->input->post('health_files_id')!=''){
            // $dta   =   $this->api_model->jsonencode("2","Mobile No. has been blocked.Please contact administrator");
            // $eck  =   $this->api_model->checkregacstatus();
            // if($eck == 3){
              	$dta    =   $this->api_model->jsonencode('4',"failed");
                $dsta    =   $this->api_model->delete_health_files();
              	if($dsta){
                	$dta    =   $this->api_model->jsonencode('3',$dsta);
                }
            // }
        }
        echo ($dta);
    }
    public function checkLogin(){
            $vsao   =   $this->api_model->viewappversion();
            // echo "<pre>";print_R($vsao);exit;
            if(count($vsao) > 0){
                $dta    =   array(
                    "status"            =>  6,
                    "status_message"    =>  "Update APP Version"
                );
            }else{
                $dta    =   array(
                    "status"            =>  1,
                    "status_message"    =>  "APP Version is upto date"
                );    
            }
            echo json_encode($dta); 
        }
    public function __destruct() {
            $this->db->close();
    }
}