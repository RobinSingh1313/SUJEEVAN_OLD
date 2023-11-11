<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Api_model extends CI_Model{
        public function checkAuthorizationvalid(){
            $default_status =   "0";
            $auth           =   sitedata('authorization');
            $getallheaders  =   getallheaders();
           // print_r($getallheaders);exit;
            $authorization_key = '';
            if(isset($getallheaders) && is_array($getallheaders) && count($getallheaders) > 0){
                if((isset($getallheaders['Authorization']) && $getallheaders['Authorization'] !='')|| (isset($getallheaders['Authorization1']) && $getallheaders['Authorization1'] !='')) {
                    $authorization_key = isset($getallheaders['Authorization'])?$getallheaders['Authorization']:$getallheaders['Authorization1']; 
                }
                if(isset($authorization_key) && $authorization_key !=''){
                    $authorization_key = str_replace("key=","",$authorization_key);
                    $authorization_key = str_replace('"',"",$authorization_key);
                    $authorization_key = str_replace("'","",$authorization_key);
                    $authorization_key = trim($authorization_key);
                    if($authorization_key == trim($auth)){
                        $default_status = 1;
                    }
                }
            }
            return $default_status;
        }
        public function jsonencode($status,$status_message,$check = '1'){ 
            $json   =   array(
                "status"            =>  $status,
                "status_messsage"   =>  $status_message,
            );
            if($check == '0'){
                return $json;
            }
            return json_encode($json);
        }
        public function checkUnique(){
                $email     =   $this->input->post('email');
                $mobile    =   $this->input->post('mobile_no');
                $pms["whereCondition"]  =   "(register_email = '".$email."' or register_mobile = '".$mobile."')";
                $sleper     =   $this->registration_model->getRegistration($pms);
                if(is_array($sleper) && count($sleper) > 0){
                    return true;
                }
                return false;
        }
        public function checkregacstatus(){
                $mobile    =   $this->input->post('mobile_no');
                $email     =   $this->input->post('email');
                $pms["whereCondition"]  =   "(register_email = '".$email."' or register_mobile = '".$email."' or register_mobile = '".$mobile."')";
                $sleper     =   $this->registration_model->getRegistration($pms); 
                if(is_array($sleper) && count($sleper) > 0){
                    $clps   =   $sleper['register_acde'];
                    if($clps == "Deactive"){
                        return 1;
                    }else{
                        if($sleper['register_otp'] == 0){
                            return 2;   
                        }
                    }
                    if($sleper['register_name'] == "")
                    {
                        return 5;
                    }
                    return 3;
                }
                return false;
        }
        public function signup(){
            $data = array(
                'register_email'           => $this->input->post('email'),
                'register_mobile'          => $this->input->post('mobile_no'),
                'register_password'        => base64_encode($this->input->post('password')),
                'register_created_on'      => date("Y-m-d H:i:s")
            );
            $this->db->insert("registration",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $uniq   =   "PAT". str_pad($vsp, 6, "0", STR_PAD_LEFT);  
                $dat    =   array(
                                "registration_id"       =>  $vsp."USR",
                                "register_unique"       =>  $uniq,
                                'register_created_by'   =>  $vsp."USR"
                            );		
                $this->db->update("registration",$dat,array("registrationid" => $vsp));	
                $vpsl   =   $this->api_model->sendotp();
                return true;
            }
            return false;
            
        }
        public function sendotp($otp_type = 0){
            $mobile     =   $this->input->post("mobile_no");
            $otp_key    =   rand(0000,9999);
            $str        =   "Dear Customer, The OTP to authenticate your identity is $otp_key. We thank you for your interest in SuJeevan. Please key in to confirm purchase - SuJeevan Health and Wellness Services.";
            $messge     =   urlencode($str);
            $vsp        =   $this->common_config->sendmessagemobile($mobile,$messge,$otp_key);
            if($vsp){
                $dta    =   array(
                    "otp_type"          =>  $otp_type,
                    "otp_key"           =>  $otp_key,
                    "otp_mobile_no"     =>  $mobile,
                    "otp_sent_time"     =>  date("Y-m-d H:i:s")
                );
                $this->db->insert("otp_log",$dta);
                return TRUE;
            }
            return FALSE;
        } 
        public function verifyotp(){
            $this->db->select('*')
                    ->from('otp_log')
                    ->where('otp_key',$this->input->post('otp_no'))
                    ->where('otp_mobile_no',$this->input->post("mobile_no"))
                    ->where("TIMEDIFF(TIME(otp_sent_time), '".date("H:i:s")."') <= '10'")
                    ->where('otp_status','0'); 
            $response 	= 	$this->db->get();  
//            echo $this->db->last_query();exit;
            $result 	= 	$response->row_array();  
            if(is_array($result) && count($result)>0){
                $this->db->where('otpid', $result['otpid']);
                $this->db->update('otp_log',array('otp_status'=>'1'));
                if($result["otp_type"] == 0){
                    $data = array(
                        'register_mobile'     	=> $this->input->post("mobile_no")
                    );
                    $dta    =   array(
                        'register_otp'          => 1,
                        "register_modified_on"  => date("Y-m-d H:i:s")
                    );
                    $this->db->update("registration",$dta,$data); 
                }else{
                    $data = array(
                        'regvendor_mobile'     	=> $this->input->post("mobile_no")
                    );
                    $dta    =   array(
                        'regvendor_otp'          => 1,
                        "regvendor_modified_on"  => date("Y-m-d H:i:s")
                    );
                    $this->db->update("register_vendors",$dta,$data); 
                }
                return TRUE;   
            }
            return FALSE;
        }
        public function customer_forget_password_change(){
            $vspl   =   $this->input->post('password');
            if(!empty($vspl)){
                $dta    =   array(
                    'register_password'    =>  base64_encode($vspl),
                    "register_modified_on" =>  date("Y-m-d H:i:s")
                );
                $this->db->update("registration",$dta,array("register_mobile" => $this->input->post('mobile_no')));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
            }
            return false;
        }
        public function add_basic_details(){
            $data = array(
                'register_email'     	=> $this->input->post('email'),
            );
            $dta    =   array(
                'register_name'         => $this->input->post('full_name') ,
                'register_age'          => $this->input->post('age') ,
                'register_gender'       => $this->input->post('gender') ,
                "register_modified_on"  => date("Y-m-d H:i:s"),
                'register_height'       => $this->input->post('height'),
                'register_weight'       => $this->input->post('weight'),
                'register_address'       => $this->input->post('address'),
                'register_state'       => $this->input->post('state'),
                'register_city'       => $this->input->post('city'),
            );
                   $picture ='';
            if(is_array($_FILES) && count($_FILES) > 0 )
            {
                    $target_dir     =   $this->config->item("upload_dest");
                    $direct         =   $target_dir."/user";
                    if (file_exists($direct)){
                    }else{mkdir($target_dir."/user");}
                    $tmpFilePath = $_FILES['image']['tmp_name'];
                   // $tmpFilePath = date('Y-m-d') . '-' . $_FILES['image']['tmp_name'];
                    if ($tmpFilePath != ""){    
                        $newFilePath = $direct."/".$_FILES['image']['name'];
                        
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $picture       =  $_FILES['image']['name']  ;   
                        }
                        if($picture!= 'noname'){
                             $dta["register_image"]  =   $picture;
                        }
                       
                    }
            }
            // print_r($dta);exit;
            $this->db->update("registration",$dta,$data);
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function login(){  
            $pd     =   base64_encode($this->input->post('password'));
            $condition['whereCondition']    =   "register_email  = '".$this->input->post('email')."' OR register_mobile  = '".$this->input->post('email')."'";
            $res =  $this->registration_model->getRegistration($condition);
            if(!empty($res) && count($res) > 0){
                if($res["register_password"] != $pd){
                    return 3;
                }
                else if($res["register_acde"] == "Active"){
                    $dta    =   array(
                        'register_login_status' => "1",
                        'register_login_time'   =>  date("Y-m-d H:i:s")
                    );
                    $this->db->update("registration",$dta,array("registration_id" => $res["registration_id"]));
                    $vsp   =    $this->db->affected_rows();
                    if($vsp > 0){
                        return 1;
                    }
                }
                return  2;
            }
            return 0;
        }
        public function saveToken($usertype){
            $token        =   $this->input->post("firebase_token");
            $device_id        =   $this->input->post("device_id");
            $device_type        =   $this->input->post("device_type");
            $registration_id = $this->get_registration_id();
            $this->db->where("registration_id = '".$registration_id."' AND device_id = '$device_id'");
            $vsp    =   $this->db->get("tokens")->row_array();
            $dta   =    array(
                
                            "registration_id"   =>  $registration_id,
                            'firebase_token'    =>  $token,
                            'user_type'         =>  $usertype,
                            'device_id'         =>  $device_id,
                            'device_type'       =>  $device_type,
                        );
            if(isset($vsp)){
                if(count($vsp) > 0){
                    $dta["token_update"] = date("Y-m-d H:i:s");
                    $this->db->update("tokens",$dta,array("token_id" => $vsp['token_id']));
                    if($this->db->affected_rows() > 0){
                        return TRUE;
                    }
                }
            }else{ 
                $dta["token_add_date"]  =  date("Y-m-d H:i:s");
                $this->db->insert("tokens",$dta);
                if($this->db->insert_id() > 0){
                    $vsp   =    $this->db->insert_id();
                    if($vsp > 0){
                        $dat    =   array("token_id" => $vsp."TKN");	
                        $this->db->update("tokens",$dat,"tokenid='".$vsp."'");
                        return true;   
                    }
                }
            }
            return FALSE;
        }
        public function logout(){
            $data   =   array(
                'register_email'     	=> $this->input->post('email'),
            );
            $dta    =   array(
                'register_login_status' =>  0,
                "register_modified_on"  =>  date("Y-m-d H:i:s")
            );
            $this->db->update("registration",$dta,$data);
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function splash(){     
            $condition['whereCondition']    =   "register_email  LIKE '".$this->input->post('email')."'";
            $res =  $this->registration_model->getRegistration($condition);
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function changepassword(){
            $condition['whereCondition']    =   "register_mobile  LIKE '".$this->input->post('mobile_no')."'";
            if($this->input->post('email') != ""){
                $condition['whereCondition']    =   "register_email  = '".$this->input->post('email')."'";
            }
            $vpl =  $this->registration_model->getRegistration($condition);
            $vspl   =   $this->input->post('new_password');
            $spl    =   base64_decode($vpl["register_password"]);
            if($spl==$this->input->post('current_password')){
                if($spl   ==  $vspl){
                    return 1;
                }
                $dta    =   array(
                    'register_password'    =>  base64_encode($vspl),
                    "register_modified_on" =>  date("Y-m-d H:i:s")
                );
                $this->db->update("	registration",$dta,array("registration_id" => $vpl['registration_id']));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return 2;
                }
                return 0;
            }
            return 3;
        }
        public function getProfile(){ 
            $target_dir             =   base_url().$this->config->item("upload_dest")."user/";
            $condition['columns']           =   "registration_id,register_unique,register_email,register_mobile,register_name,register_age,register_gender,register_otp,CASE WHEN register_height is null THEN '' ELSE register_height END AS register_height,CASE WHEN register_weight is null THEN '' ELSE register_weight END AS register_weight,CASE WHEN register_address is null THEN '' ELSE register_address END AS register_address,CASE WHEN district_name is null THEN '' ELSE district_name END AS district_name,CASE WHEN state_name is null THEN '' ELSE state_name END AS state_name,CASE WHEN register_state is null THEN '' ELSE register_state END AS state_id,CASE WHEN register_city is null THEN '' ELSE register_city END AS district_id,CASE WHEN register_image is null THEN '' ELSE  concat('".$target_dir."',register_image) END as  customer_image";
            $condition['whereCondition']    =   "register_email  = '".$this->input->post('mobile_no')."' OR register_mobile  LIKE '".$this->input->post('mobile_no')."'";
            if($this->input->post('email') != ""){
                $condition['whereCondition']    =   "register_email  = '".$this->input->post('email')."' OR register_mobile  = '".$this->input->post('email')."'";
            }
            $res =  $this->registration_model->getRegistration($condition);
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function submodules($mdol){  
            $target_dir             =   base_url().$this->config->item("upload_dest")."modules/";
            $conditions["columns"]          =   "sub_module_id,sub_module_name,concat('".$target_dir."',sub_module_image) as  sub_module_image,moduleid,(case when submodule_isblog = 1 then 'api-blogs' else (case when submodule_isquestions = 1 then 'api-questions' else (case when submodule_isconsult = 1 then 'api-consultation' else submodule_api end) end) end) as submodule_api,(case when submodule_isdesc = 1 then sub_module_desc else '' end) as sub_module_desc";
            $conditions['whereCondition']   =   "submodule_ismodule = '".$mdol."' and sub_module_acde = 'Active' and sub_module_module_id  = '".$this->input->post('module_id')."'";
            $conditions['tipoOrderby']   = 'sub_module_order';
            $conditions['order_by']   = 'ASC';
            $res =  $this->sub_module_model->viewSub_module($conditions);
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function blogs(){  
            $target_dir                     =   base_url().$this->config->item("upload_dest")."modules/";
            $conditions["columns"]          =    "blog_id,blog_title,blog_alias_name,module_name,blog_description,blogid as blog_images,blog_created_on,blog_created_by";
            $conditions['whereCondition']   =   "moduleid  = '".$this->input->post('module_id')."' and blog_acde = 'Active' and blog_type='1'";
            $conditions2["columns"]          =    "blog_id,blog_title,blog_alias_name,module_name,blog_description,blogid as blog_images,blog_created_on,blog_created_by";
            $conditions2['whereCondition']   =   "moduleid  = '".$this->input->post('module_id')."' and blog_acde = 'Active' and blog_type='2'";
            $res['general_blogs'] =  $this->blog_model->viewBlogs($conditions);
            $res['heart_related_blogs'] =  $this->blog_model->viewBlogs($conditions2);
            if(is_array($res['general_blogs']) && count($res['general_blogs']) > 0 || is_array($res['heart_related_blogs']) && count($res['heart_related_blogs']) > 0){
              	foreach($res['general_blogs'] as $ld  => $ve){
              	    $vol            =   $ve["blog_created_by"];
              	    $vplcr          =   $this->api2_model->getProfile($vol);
              	    $vtimerc        =   (is_array($vplcr) && count($vplcr) > 0)?$vplcr["regvendor_name"]:"";
                    //print_r($vplcr);exit;
              	    //$timer          =   $ve["blog_created_on"];
              	    //$vtimer         =   $this->common_config->get_timeago(strtotime($timer));
                    $vtimer         =   date("d m y",strtotime($ve["blog_created_on"]));
                    $vtime         =   date("H:i:s",strtotime($ve["blog_created_on"]));
              	    
                  	$blog_image	=	base_url().$this->config->item("upload_dest")."blog/";
                  	$lsp	=	$this->db->select("concat('".$blog_image."',blog_image_path) as  blog_image_path")->get_where("blog_image",array("blog_image_blog_id" => $ve['blog_id']))->row_array();
                
                  	$res['general_blogs'][$ld]["blog_images"]	    =	is_array($lsp)?$lsp["blog_image_path"]:"";
                  	$res['general_blogs'][$ld]["blog_created_on"]	=	$vtimer;
                  	$res['general_blogs'][$ld]["blog_created_time"]	=	$vtime;
                  	$res['general_blogs'][$ld]["blog_created_by"]	=	ucwords($vtimerc);
                }
                
                foreach($res['heart_related_blogs'] as $ld1  => $ve1){
                    $vol            =   $ve1["blog_created_by"];
                    $vplcr          =   $this->api2_model->getProfile($vol);
                    $vtimerc        =   (is_array($vplcr) && count($vplcr) > 0)?$vplcr["regvendor_name"]:"";
                    //print_r($vplcr);exit;
                    //$timer          =   $ve["blog_created_on"];
                    //$vtimer         =   $this->common_config->get_timeago(strtotime($timer));
                    $vtimer         =   date("d M Y",strtotime($ve1["blog_created_on"]));
                    
                    $blog_image =   base_url().$this->config->item("upload_dest")."blog/";
                    $lsp    =   $this->db->select("concat('".$blog_image."',blog_image_path) as  blog_image_path")->get_where("blog_image",array("blog_image_blog_id" => $ve1['blog_id']))->row_array();
                
                    $res['heart_related_blogs'][$ld1]["blog_images"]       =   is_array($lsp)?$lsp["blog_image_path"]:"";
                    $res['heart_related_blogs'][$ld1]["blog_created_on"]   =   $vtimer;
                    $res['heart_related_blogs'][$ld1]["blog_created_by"]   =   ucwords($vtimerc);
                }
                
                return $res;
            }
            return array();
        }
        public function blogsid(){  
            $target_dir                     =   base_url().$this->config->item("upload_dest")."modules/";
            $conditions["columns"]          =   "blog_image,blogid,blog_id,blog_title,blog_alias_name,module_name,blog_description,blogid as blog_images,blog_created_on,blog_created_by";
            $conditions['whereCondition']   =   "blog_id  = '".$this->input->post('blog_id')."' and blog_acde = 'Active'";
            $res =  $this->blog_model->getBlogs($conditions);
            $user_check          =   $this->api_model->getProfile();
            $user_registration_id = $user_check['registration_id'];
            if(is_array($res) && count($res) > 0){
                    $ve    =   $res;
            //   	foreach($res as $ld  => $ve){
              	    $vol            =   $ve["blog_created_by"];
              	    $vplcr          =   $this->api2_model->getProfile($vol);
              	    $vtimerc        =   (is_array($vplcr) && count($vplcr) > 0)?$vplcr["regvendor_name"]:"";

              	    // $timer          =   $ve["blog_created_on"];
              	    // $vtimer         =   $this->common_config->get_timeago(strtotime($timer));
                    $check_like = $this->db->query("select * from blog_likes where user_registration_id='".$user_registration_id."' and blog_id='".$ve['blogid']."' ")->row_array();
                    //print_r($user_registration_id);exit;
                    if(is_array($check_like) && count($check_like)>0)
                    {
                        $like = $check_like['status'];
                    }
                    else
                    {
                        $like = 0;
                    }

                    $vtimer         =   date("d M Y",strtotime($ve["blog_created_on"]));
              	    /** Images **/
                  	$blog_image	=	base_url().$this->config->item("upload_dest")."blog/";
                  	$lsp	=	$this->db->select("concat('".$blog_image."',blog_image_path) as  blog_image_path")->get_where("blog_image",array("blog_image_blog_id" => $ve['blog_id']))->result_array();
                  	$vlsp	=	$this->db->select("concat('".$blog_image."',blog_image_path) as  blog_image_path")->get_where("blog_image",array("blog_image_blog_id" => $ve['blog_id']))->row_array();
                    /** Videos **/
                    $res['likes']               =   $like;
                    $res['regvendor_id']        =   $ve['blog_created_by'];
                  	$blog_viedo	    =	base_url().$this->config->item("upload_dest")."blog/";
                  	$lssp	        =	$this->db->select("blog_video_type,(case when blog_video_type = 'Youtube' then blog_video_path else concat('".$blog_image."',blog_video_path) end) as  blog_video_path")->get_where("blog_video",array("blog_video_blog_id" => $ve['blog_id']))->result_array();
                  	$res["blog_videos"]	        =	$lssp;
                  	$res["blog_images"]	        =	is_array($vlsp)?$vlsp["blog_image_path"]:"";
                    $res["blog_image"]       =   (array_key_exists("blog_image",$ve) && $ve['blog_image']!='')?$blog_image.$ve['blog_image']:'';
                  	$res["blog_images_all"]	    =	$lsp;
                  	$res["blog_created_on"]	    =	$vtimer;
                  	$res["blog_created_by"]	    =	ucwords($vtimerc);
                    
                    //unset($res['blogid']);
                // }
                return $res;
            }
            return array();
        }
        public function questions(){  
            $blog_image						=	base_url().$this->config->item("upload_dest")."blog/";
            $conditions["columns"]  		=   "qa_id,qa_question,concat('".$blog_image."',qa_image_path) as qa_image_path, qa_created_on as date,qa_created_by,qa_modified_by,ans_answer,ans_regvendor_id,answerid";
            $conditions['whereCondition']   =   "qa_module_id  = '".$this->input->post('module_id')."'";
            $conditions['tipoOrderby'] = "qaid";
            $conditions['order_by'] = "desc";
            $conditions['group_by'] = "qa_id";
            $conditions['join'] = "inner";

            $res =  $this->questions_model->viewQa($conditions);
            //print_r($this->db->last_query());exit;
            //print_r($res);exit;
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function user_questions()
        {
            $condition['columns']           =   "registration_id";
            $condition["whereCondition"]    =   "register_email = '".$this->input->post("email")."'";
            $vpo    =   $this->registration_model->getRegistration($condition);
            $blog_image                     =   base_url().$this->config->item("upload_dest")."blog/";
            $conditions["columns"]  		=   "qa_id,qa_question,concat('".$blog_image."',qa_image_path) as qa_image_path, qa_created_on as date,qa_created_by,qa_modified_by,ans_answer,ans_regvendor_id,answerid";    
            $conditions['whereCondition']   =   "qa_module_id  = '".$this->input->post('module_id')."' and qa_created_by = '".$vpo['registration_id']."' ";
            $conditions['tipoOrderby'] = "qaid";
            $conditions['order_by'] = "desc";
            $conditions['group_by'] = "qa_id";

            $res =  $this->questions_model->viewQa($conditions);
            //print_r($res);exit;
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function hometest(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."homecare/";
            $conditions["columns"]  =    "homecaretest_id,homecaretest_name,concat('".$target_dir."',homecaretest_image) as  homecaretest_image,homecaretest_actual_price,homecaretest_offer_price";
            $conditions['whereCondition']    =   "moduleid  = '".$this->input->post('module_id')."'";
            $res =  $this->hometest_model->viewTest($conditions);
          	if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function homepackages(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."homecare/";
            $conditions["columns"]  =    "package_id,package_name,concat('".$target_dir."',package_image) as package_image";
            $conditions['whereCondition']    =   "package_module_id  = '".$this->input->post('module_id')."'";
            $res =  $this->homecare_model->viewpackage($conditions);
          	if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function dashboard(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."modules/";
            $conons["whereCondition"]       =   "module_program = 1";
            $conons["columns"]              =   "moduleid,module_name,concat('".$target_dir."',module_image) as  module_image,concat('".$target_dir."',module_back_image) as  module_back_image";
            $conons['tipoOrderby']     =   "module_order";
            $conons['order_by']        =   "ASC";
            $conditions["whereCondition"]   =   "module_program = 0";
            $conditions['tipoOrderby']     =   "module_order";
            $conditions['order_by']        =   "ASC";
            $conditions["columns"]  =   "moduleid,module_name,concat('".$target_dir."',module_image) as  module_image,book_id";
            $dad    =   array(
                "profile"           =>  $this->api_model->getProfile(),
                "banners"           =>  $this->banners(),
                "tophealth"         =>  $this->common_model->viewModules($conons),
                "book_appointment"  =>  $this->common_model->viewModules($conditions),
                "wow"               =>  $this->api_model->wellness(),
                "health_score"      =>  $this->api_model->allscores(),
                "track_activity"    =>  array(
                                            array("track_name"    =>  "Steps","track_image"   =>  $target_dir."image_not_available.png"),
                                            array("track_name"    =>  "Sleep","track_image"   =>  $target_dir."sleep.png"),
                                            array("track_name"    =>  "Weight","track_image"   =>  $target_dir),
                                            array("track_name"    =>  "Calories","track_image"   =>  $target_dir),
                                        ),
                "other_services"    =>  array(
                                            array("service_id" => "13","service_name"    =>  "Insurance","service_image"   =>  $target_dir."image_not_available.png"),
                                            array("service_id" => "13","service_name"    =>  "Sleep","service_image"   =>  $target_dir."sleep.png"),
                                            array("service_id" => "13","service_name"    =>  "Weight","service_image"   =>  $target_dir),
                                            array("service_id" => "13","service_name"    =>  "Calories","service_image"   =>  $target_dir),
                                        ),
                "packages"          =>  array(
                                            array("package_id" => "13","package_name"    =>  "Steps","package_image"   =>  $target_dir."image_not_available.png"),
                                            array("package_id" => "13","package_name"    =>  "Sleep","package_image"   =>  $target_dir."sleep.png"),
                                            array("package_id" => "13","package_name"    =>  "Weight","package_image"   =>  $target_dir),
                                            array("package_id" => "13","package_name"    =>  "Calories","package_image"   =>  $target_dir),
                                        )
            );
            return $dad;
        }
        public function allscores(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."scores/";
            $this->db->select("score_full_name,score_name as score_api_name,concat('".$target_dir."',score_full_icon) as  score_full_icon,score_about");
            return $this->db->get_where("score_formulas",array("score_open" => 1))->result_array();
        }
        public function vendors(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."modules/";
            $conditions["columns"]  =   "vendor_id,vendor_name,concat('".$target_dir."',vendor_icon) as  vendor_icon";
            return $this->vendor_model->viewVendors($conditions);
        }
        public function wellness(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."wellness/";
            $conditions["columns"]  =   "wellness_id,wellness_name,wellness_description,concat('".$target_dir."',wellness_image) as  wellness_image";
            return $this->wellness_model->viewWellness($conditions);
        }
        public function banners(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."banner/";
            $conditions["columns"]  =   "banner_id,banner_name,concat('".$target_dir."',banner_image) as  banner_image,module_id,module_name";
            return $this->banners_model->viewBanner($conditions);
        }
        public function wellness_details(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."wellness/";
            $conditions["columns"]  =   "wellness_id,wellness_name,wellness_description,concat('".$target_dir."',wellness_main_image) as  wellness_main_image";
            $conditions["whereCondition"]  = "wellness_id = '".$this->input->post('wellness_id')."'";
            return $this->wellness_model->getWellness($conditions);
        }
        public function getPackages(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."homecare/";
            $conditions["columns"]  =   "package_id,package_name,concat('".$target_dir."',package_image) as package_image,quotation_by,quotation,concat('".$target_dir."',quotation_image) as how_itworks";
            $conditions['whereCondition']    =   "package_id  = '".$this->input->post('package_id')."'";
            $res =  $this->homecare_model->getpackage($conditions);
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function subitems(){
            $conditions["columns"]          =   "item_package_item,item_id,'' as subitems";
            $conditions['whereCondition']   =   "package_id  = '".$this->input->post('package_id')."'";
            $res        =   $this->works_model->viewworks($conditions);
            $vslp       =   array();
            if(is_array($res) && count($res) > 0){
                foreach($res as $kl =>  $ver){
                    $item_id                        =   $ver['item_id'];
                    $res[$kl]["item_id"]            =   $item_id;
                    $res[$kl]["item_package_item"]  =   $ver["item_package_item"];
                    $dmpp["columns"]                =   "subitem_name,subitem_quantity";
                    $dmpp["whereCondition"]         =   "subitem_item_id = '".$item_id."'";
                    $res[$kl]["subitems"]           =   $this->works_model->viewsubworks($dmpp);
                }
                return $res;
            }
            return array();
        }
        public function createqueries(){
            $condition['columns']           =   "registration_id";
            $condition["whereCondition"]    =   "register_email = '".$this->input->post("email")."'";
            $vpo    =   $this->registration_model->getRegistration($condition);
           // print_r($this->session->all_userdata());exit;
            $data = array(
                        'qa_question'                 =>  $this->input->post('qa_question'),
                        'qa_module_id'                =>  $this->input->post('module'),
                        'qa_healthcategory_id'        =>  $this->input->post('health_category_id'),
                        'qa_healthsubcategory_id'        =>  $this->input->post('health_sub_category_id'),
                        "qa_created_on"               =>  date("Y-m-d h:i:s"),
                        "qa_created_by"               =>  $vpo['registration_id']
            );
            if(is_array($_FILES) && count($_FILES) > 0){
                    $target_dir     =   $this->config->item("upload_dest");
                    $direct         =   $target_dir."/question";
                    if (file_exists($direct)){
                    }else{mkdir($target_dir."/question");}
                    $tmpFilePath = $_FILES['question_image']['tmp_name'];
                    if ($tmpFilePath != ""){    
                        $newFilePath = $direct."/".$_FILES['question_image']['name'];
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $picture       =  $_FILES['question_image']['name']  ;   
                        }
                        $data["qa_image"]  =   $picture;
                    }
            }
            $this->db->insert("questions",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                    	$dat    =   array("qa_id" => $vsp."QA");	
                        $this->db->update("questions",$dat,"qaid='".$vsp."'");
                        return true;   
            }
            return false;
        }
        public function consultation(){
            $condition['columns']           =   "r.*,vendor_name,specialization_name,state_name,district_name,sub_module_name";
            $condition["whereCondition"]    =   "sub_module_id = '".$this->input->post("sub_module_id")."'";
            $vpo    =   $this->vendor_registration_model->viewRegistration($condition);
            if(is_array($vpo) && count($vpo) > 0){
                return $vpo;
            }
            return array();
        }
        public function consultationview(){
            $condition['columns']           =   "r.*,vendor_name,specialization_name,state_name,district_name,sub_module_name,'' as educations";
            $condition["whereCondition"]    =   "regvendor_id = '".$this->input->post("regvendor_id")."'";
            $vpo    =   $this->vendor_registration_model->getRegistration($condition);
            if(is_array($vpo) && count($vpo) > 0){
                $vpo['educations']  =   $this->api2_model->qualifications();
                return $vpo;
            }
            return array();
        }
        public function consultationpackages(){
            $condition['columns']           =   "r.*,vendor_name,specialization_name,state_name,district_name,sub_module_name,'' as educations";
            $condition["whereCondition"]    =   "regvendor_id = '".$this->input->post("regvendor_id")."'";
            $vpo    =   $this->vendor_registration_model->getRegistration($condition);
            if(is_array($vpo) && count($vpo) > 0){
                $vpo['educations']  =   $this->api2_model->qualifications();
                return $vpo;
            }
            return array();
        }
        public function scorepoint($scorename){
            $serum      =   $this->input->post("serum");
            $age        =   $this->input->post("age");
            $if_black   =   $this->input->post("if_black");
            $if_female  =   $this->input->post("if_female");
            
            /** Heart Score **/    
            $history    =   $this->input->post("history");
            $agevalue   =   $this->input->post("age");
            $risk       =   $this->input->post("risk");
            $ekg        =   $this->input->post("ekg"); 
            $troponin   =   $this->input->post("troponin"); 
            
            $height     =   $this->input->post("height");
            
            //swa (($weight/((($feet*30.48))*(($feet*30.48))))*1000000 : old calc)
            $heightinc     =   $this->input->post("heightinc");
            
            $fttomtr = $height * 0.3048;
            if($heightinc != ''){
                $inctomtr = $heightinc * 0.0254;
            }else{
                $inctomtr = 0;
            }
            $ttlmtr = $fttomtr+$inctomtr;
            
            $meter       =   $ttlmtr;
            //swa
            //$feet       =   $height;
            $weight     =   $this->input->post("weight");
            $fasting_insulin    =   $this->input->post("fasting_insulin");
            $fasting_glucose    =   $this->input->post("fasting_glucose");
            $daa    =   array(
                            "score_name"    =>  $scorename
                        );
                            
            $target_dir  =   base_url().$this->config->item("upload_dest")."scores/";
            $this->db->select("*,concat('".$target_dir."',score_png) as  score_png");
            $vpo    =   $this->db->get_where("score_formulas",$daa)->row_array();
            if(is_array($vpo) && count($vpo) > 0){
                $vlpa   =   $vpo["score_formula"];
                if($if_female == '1'){
                    $vlpa   =   $vlpa."*0.742";
                }
                if($if_black == '1'){
                    $vlpa   =   $vlpa."*1.212";
                }
                $cslp   =   eval("return ".$vlpa.";");
                $cml    =   round($cslp,2); 
                $spl    =   "";
                if($history != ""){
                    if($cml >= 0 && $cml <= 3){
                        $spl    =   "Low Score (0-3 points) <br/> Risk of MACE of 0.9-1.7%.";
                    }
                    if($cml >= 4 && $cml <= 6){
                        $spl    =   "Moderate Score (0-3 points) <br/> Risk of MACE of 12-16.6%.";
                    }
                    if($cml >= 7){
                        $spl    =   "High Score (>= 7 points) <br/> Risk of MACE of 50-65%.";
                    }
                }
                return array(
                        "score_result"  =>  $cml,
                        "score_desc"    =>  $vpo['score_desc'],
                        "score_png"         =>  $vpo['score_png'],
                        "score_result_text" =>  $spl
                    );
            }
            return array();
        }
        public function chatroom(){     
            $condition['columns']           =   "chat_message as from_message,chat_to as to_message";
            $condition['whereCondition']    =   "register_mobile  LIKE '".$this->input->post('mobile_no')."' and chat_message is not null";
            if($this->input->post('email') != ""){
                $condition['whereCondition']    =   "register_email  = '".$this->input->post('email')."'  and chat_message is not null";
            }
            $res =  $this->registration_model->viewChatroom($condition);
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function consultchatroom($registration_id){     
            $condition['columns']           =   "symptomchat_from,symptomchat_message,symptomchat_options,symptomchat_to";
            $condition['whereCondition']    =   "(symptomchat_to like '".$registration_id."' or symptomchat_from like '".$registration_id."')";
            if($this->input->post('email') != ""){
                $condition['whereCondition']    =   "(symptomchat_to like '".$registration_id."' or symptomchat_from like '".$registration_id."')";
            }
            $res =  $this->registration_model->viewconsultChatroom($condition);
            if(is_array($res) && count($res) > 0){
                return $res;
            }
            return array();
        }
        public function viewHalthcategory(){
            $target_dir             =   base_url().$this->config->item("upload_dest")."healthcategory/";
            $condition['columns']   =   'healthcategory_id,healthcategory_name,concat("'.$target_dir.'",healthcategory_image) as  healthcategory_image';
            $res =  $this->health_category_model->viewCategory($condition);
            return $res;
        }
        public function consultdoctors(){     
            $vslp   =   $this->api_model->getProfile();
            $registration_id        =   $vslp['registration_id'];
            $vslp   =   $this->api_model->consultchatroom($registration_id);
            if(is_array($vslp) && count($vslp) == 0){
                $dns['tipoOrderby']     =   "symptoms_order";
                $dns['order_by']        =   "ASC";
                $dns['whereCondition']  =   "symptoms_auto_start = 1";
                $ll     =   $this->symptoms_model->viewSymptomsbot($dns);
                if(is_array($ll) && count($ll) > 0){
                    foreach($ll as $le){
                        $data[] = array(
                            'symptomchat_from'         => "bot",
                            'symptomchat_message'      => $le['symptoms_question'],
                            'symptomchat_options'      => $le['symptoms_options'],
                            'symptomchat_to'           => $registration_id,
                            'symptomchat_created_on'   => date("Y-m-d H:i:s")
                        );
                    }
                    $this->db->insert_batch("symptom_chat_room",$data);
                }
            }
            $thims  =   $this->input->post("message");
            if($thims != ""){
                $da= array(
                    'symptomchat_from'         => $registration_id,
                    'symptomchat_message'      => $thims,
                    'symptomchat_options'      => "",
                    'symptomchat_to'           => "bot",
                    'symptomchat_created_on'   => date("Y-m-d H:i:s")
                );
                $this->db->insert("symptom_chat_room",$da);
            }
            $symptom_health     =   $this->api_model->viewHalthcategory();
            $cslp   =   $this->api_model->consultchatroom($registration_id);
            if(is_array($cslp) && count($cslp) > 0){
                foreach($cslp as $ki => $vd){
                    $symptomchat_options    =   explode(",",$vd['symptomchat_options']);
                    foreach($symptomchat_options as $vrf){
                        $slcp[]['option_key']     =   $vrf;
                    }
                    $cslp[$ki]['symptomchat_options']   =   $slcp;
                }
            }
            $csxlp['symptom_health']    =   $symptom_health;
            $csxlp['symptom_message']   =   $cslp;
            return $csxlp;
        }
        public function symptoms_checker(){
            $condition['whereCondition']   =   "healthcategory_acde = 'Active'";
            $condition['columns']   =   'healthcategory_name,healthcategory_id,"" as health_subcats';
            $res =  $this->health_category_model->viewCategory($condition);
            if(is_array($res) && count($res) > 0){
                $target_dir             =   base_url().$this->config->item("upload_dest")."modules/";
                foreach($res as $kl =>  $fr){
                    $lcp                            =   $fr["healthcategory_id"];
                    $condition['whereCondition']    =   "healthsubcategory_health_id = '".$lcp."'";
                    $condition['columns']   =   'healthsubcategory_id,healthsubcategory_name,concat("'.$target_dir.'",healthsubcategory_image) as  healthsubcategory_image';
                    $lvpdd =  $this->health_category_model->viewsubCategory($condition);
                    $res[$kl]['health_subcats']    =   $lvpdd;
                }
                return $res;
            }
            return array();
        }
        /*** Chat room ***/
        public function chatroom_create(){
            $vslp   =   $this->api_model->getProfile();
            $msk    =   $this->input->post('message');
            $pms['whereCondition']  =   "(find_in_set('$msk',botauto_tags) > 0) and botauto_acde = 'Active'";
            $vdlp                   =   $this->botconfiguation_model->getBotsreply($pms);
            $registration_id        =   $vslp['registration_id'];
            $data = array(
                'chat_from'         => $registration_id,
                'chat_message'      => $msk,
                'chat_to'           => $vdlp,
                'chat_created_on'   => date("Y-m-d H:i:s")
            );
            $this->db->insert("chat_room",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                return true;
            }
            return false;
        }
        /*** Health Sub Categorry ****/
        public function viewsubCategory(){
            $helathid   =   $this->input->post("healthcategory_id");
            $mpsm['columns']        =   'healthsubcategory_id,healthsubcategory_name';
            $mpsm['whereCondition'] =   'healthsubcategory_health_id = "'.$helathid.'"';
            return $this->health_category_model->viewsubCategory($mpsm);
        }
        public function doctors_list()
        {
                
            $health_sub_category = $this->input->post('health_sub_category');
            $sub_category_array = explode(",",$health_sub_category);
            $sub_category_str = implode("','",$sub_category_array);
            $target_dir             =   base_url().$this->config->item("upload_dest")."vendors/";
           $response = $this->db->query(
                                        "select a.regvendor_id,
                                        GROUP_CONCAT(b.degreevendor_degree) regvendor_degree,s.specialization_name,a.regvendor_experience_yrs,a.regvendor_name,a.regvendor_phone,concat('".$target_dir."',a.regvendor_upload_picture) as vendor_image,a.regvendor_address,round(a.regvendor_fee,0) as regvendor_fee,a.regvendor_language,a.regvendor_type_of_consultation
                                        FROM  register_vendors a
                                        LEFT JOIN specialization s ON a.regvendor_specialization=s.specialization_id
                                        LEFT JOIN register_vendor_degree b
                                        ON a.regvendor_id IN (b.degreevendor_regvendor_id)     
                                        WHERE a.regvendor_vendor_id='5VT' and a.regvendor_specialization 
                                        IN 
                                        (select spec_id from assign_specialization where subhealthcategory_id in ('$sub_category_str'))
                                        GROUP BY a.regvendor_id"
                                        )->result_array();    
        return $response;

    }
    public function vendor_list()
    {
                
            $vendor_id = $this->input->post('vendor_id');
            $target_dir             =   base_url().$this->config->item("upload_dest")."vendors/";
           $response = $this->db->query(
                                        "select a.regvendor_id,
                                        GROUP_CONCAT(b.degreevendor_degree) regvendor_degree,s.specialization_name,a.regvendor_experience_yrs,a.regvendor_name,a.regvendor_phone,concat('".$target_dir."',a.regvendor_upload_picture) as vendor_image,a.regvendor_address,round(a.regvendor_fee,0) as regvendor_fee,a.regvendor_language,a.regvendor_type_of_consultation
                                        FROM  register_vendors a
                                        LEFT JOIN specialization s ON a.regvendor_specialization=s.specialization_id
                                        LEFT JOIN register_vendor_degree b
                                        ON a.regvendor_id IN (b.degreevendor_regvendor_id)     
                                        WHERE a.regvendor_vendor_id='".$vendor_id."' and a.regvendor_specialization 
                                        GROUP BY a.regvendor_id")
                                        ->result_array();   
       
        return $response;

    }
    
    public function doctor_info($regvendor_id)
    {
        $target_dir =   base_url().$this->config->item("upload_dest")."vendors/";
           
        $result = $this->db->query("select regvendor_name,specialization_name,regvendor_experience_yrs,concat('".$target_dir."',regvendor_upload_picture) profile_picture,regvendor_language,regvendor_type_of_consultation,
                                        GROUP_CONCAT(degreevendor_degree) regvendor_degree
        FROM    register_vendors a
        LEFT JOIN specialization s ON a.regvendor_specialization=s.specialization_id
        LEFT JOIN register_vendor_degree b ON a.regvendor_id IN (b.degreevendor_regvendor_id)
        WHERE a.regvendor_id = '".$regvendor_id."'
        GROUP BY a.regvendor_id"
         )->row_array();

        $degree = $this->db->query("select degreevendor_degree,degreevendor_university
        FROM  register_vendor_degree
        
        WHERE degreevendor_regvendor_id = '".$regvendor_id."'"
        
         )->result_array();
        $dta = array();
        $dta['doctor_name'] = $result['regvendor_name'];
        $dta['doctor_specialization'] = $result['specialization_name'];
        $dta['doctor_experience'] = $result['regvendor_experience_yrs'];
        $dta['doctor_profile_pic'] = $result['profile_picture'];
        $dta['doctor_known_language'] = $result['regvendor_language'];
        $dta['doctor_degree'] = $result['regvendor_degree'];
        $consultation = explode(",", $result["regvendor_type_of_consultation"]);
        $consultation = array_map('trim', $consultation);
        $dta['consultation_type_0']="";
        $dta['consultation_type_1']="";
        $dta['consultation_type_2']="";
        foreach ($consultation as $key => $consult) {
            $dta['consultation_type_'.$key]=$consult;
        }
        foreach ($degree as $key => $value) {
            $dta['degree'][$key]['name'] = $value['degreevendor_degree'];
            $dta['degree'][$key]['university'] = $value['degreevendor_university'];
        }
                
        return $dta;
    }
    public function basic_chatbot($regvendor_id)
    {          
        $result = $this->db->query("select consult_question,consult_options
        FROM consult_chat_box
        WHERE consult_open='1' AND consult_status='1'
        ORDER BY consult_order"   
         )->result_array();
         $reg  = $this->db->query("select regvendor_name from register_vendors where regvendor_id='".$regvendor_id."'")->row_array();
         $chatbox = array();
         $chatbox['doctor_name'] = $reg['regvendor_name'];
         $chatbox['date'] = "24 Mar 2020";
         $chatbox['time'] = "11 AM";
         foreach ($result as $key => $value) {
            $options = $value['consult_options'];
            $options_array = explode(",", $options);
            $chatbox["list"][$key]['question'] = $value['consult_question'];
            $chatbox["list"][$key]['options_0'] = "";
            $chatbox["list"][$key]['options_1'] = "";
            foreach ($options_array as $key1 => $ar) 
            {
                $chatbox["list"][$key]['options_'.$key1] = $ar; 
                
            }
               
           }  
        return $chatbox;
    }
    public function basic_chatbot_save()
    {
        $data = array(
                'email'           => $this->input->post('email'),
                'list_of_answers'          => $this->input->post('list')
            );

        $pms["whereCondition"]  =   "(register_email = '".$data['email']."')";
        $get_user     =   $this->registration_model->getRegistration($pms);
        $reg_id = $get_user['registration_id'];
        $data['registration_id'] = $reg_id;
        unset($data['email']);
        $this->db->insert("basicchat_info",$data);
        $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function health_category_list()
    {
        $moduleid = $this->input->post('module_id');
        $condition['columns']   =   'healthcategory_id,healthcategory_name';
        $condition['whereCondition'] =   'healthcategory_module_id = "'.$moduleid.'"';
        $res =  $this->health_category_model->viewCategory($condition);
        return $res;
    }
    public function health_sub_category_list()
    {
        $healthcategoryid = $this->input->post('health_category_id');
        $condition['columns']   =   'healthsubcategory_id,healthsubcategory_name';
        $condition['whereCondition'] =   'healthsubcategory_health_id = "'.$healthcategoryid.'"';
        $res =  $this->health_category_model->viewsubCategory($condition);
        return $res;
    }
    public function save_payment_info($data)
    {
        $insert = $this->db->insert("payments",$data);
        if($insert)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function question_list()
    {

            $conditions["columns"]          =   "qa_id,qa_question";
            $conditions['whereCondition']   =   "qa_id  = '".$this->input->post('qa_id')."'";
            $conditions['tipoOrderby'] = "qaid";
            $conditions['order_by'] = "desc";
            $res =  $this->questions_model->getQa($conditions);
            return $res;
    }
    public function multiple_answer_list()
    {
        $target_dir             =   base_url().$this->config->item("upload_dest")."answers/";
        $conditions["columns"]          =   "answerid,ans_answer,concat('".$target_dir."',ans_image) as answer_image,ans_regvendor_id,created_at";
        $conditions['whereCondition']   =   "ans_question_id  = '".$this->input->post('qa_id')."'";
        $conditions['tipoOrderby'] = "answerid";
        $conditions['order_by'] = "desc";
        $answers = $this->questions_model->viewAns($conditions);
        return $answers;
    }
    public function likes($registration_id)
    {
        $like_status = $this->input->post('like_status');
        $regvendor_id = $this->input->post('regvendor_id');
        $user_registration_id = $registration_id;
        $answer_id = $this->input->post('answer_id');
        $check_like = $this->db->query("select * from likes where user_registration_id='".$user_registration_id."' and answer_id='".$answer_id."' ")->row_array();
        //print_r(count($check_like));exit;
        if($check_like)
        {
            $data = array(
                "updated_at"=>date('Y-m-d H:i:s'),
                "status" => $like_status
            );
            $result = $this->db->update('likes',$data,array("user_registration_id"=>$user_registration_id,"answer_id"=>$answer_id));
            if($result)
            {
                return 2;
            }
        }
        else
        {
            $data = array(
                "regvendor_id" => $regvendor_id,
                "user_registration_id" => $user_registration_id,
                "answer_id"=> $answer_id,
                "created_at"=>date('Y-m-d H:i:s'),
                "updated_at"=>date('Y-m-d H:i:s'),
                "status" => $like_status
            );
            $result = $this->db->insert('likes',$data);
            if($result)
            {
                return 1;
            }
        }
        return 0;
        
    }
    public function likes_count($answerid,$reg_id)
    {
        $result = $this->db->query("select * from likes where answer_id='".$answerid."' and user_registration_id='".$reg_id."'")->row_array();
        //print_r($answerid);exit;
        if($result)
        {
            if($result['status']==1)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }

    }
    public function blog_view_check()
        {
            $email = $this->input->post('email');
            $blog_id = $this->input->post('blog_id');
            $pms["whereCondition"]  =   "(register_email = '".$email."')";
            $pms["columns"]  =   "registration_id";
            $get_user =   $this->registration_model->getRegistration($pms);
            $blog["whereCondition"] = "(blog_blog_id = '".$blog_id."' and user_id = '".$get_user['registration_id']."')";
            $get_blog_view = $this->blog_model->getBlogView($blog);
            if($get_blog_view)
            {
                return 0;
            }
            else
            {
                $create_blog_view = $this->blog_model->create_blog_view($get_user['registration_id'],$blog_id);
                return $create_blog_view;
            }
        }
    public function blog_likes($registration_id)
    {
        $like_status = $this->input->post('like_status');
        $regvendor_id = $this->input->post('regvendor_id');
        $user_registration_id = $registration_id;
        $blog_id = $this->input->post('blog_id');
        $check_like = $this->db->query("select * from blog_likes where user_registration_id='".$user_registration_id."' and blog_id='".$blog_id."' ")->row_array();
        //print_r(count($check_like));exit;
        if($check_like)
        {
            $data = array(
                "updated_at"=>date('Y-m-d H:i:s'),
                "status" => $like_status
            );
            $result = $this->db->update('blog_likes',$data,array("user_registration_id"=>$user_registration_id,"blog_id"=>$blog_id));
            if($result)
            {
                return 2;
            }
        }
        else
        {
            $data = array(
                "regvendor_id" => $regvendor_id,
                "user_registration_id" => $user_registration_id,
                "blog_id"=> $blog_id,
                "created_at"=>date('Y-m-d H:i:s'),
                "updated_at"=>date('Y-m-d H:i:s'),
                "status" => $like_status
            );
            $result = $this->db->insert('blog_likes',$data);
            if($result)
            {
                return 1;
            }
        }
        return 0;
        
    }
    public function blog_likes_count($blogid,$reg_id)
    {
        $result = $this->db->query("select * from blog_likes where blog_id='".$blogid."' and user_registration_id='".$reg_id."'")->row_array();
        //print_r($answerid);exit;
        if($result)
        {
            if($result['status']==1)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }

    }
    public function customer_details()
    {
        $data = array(
            'patient_name' => $this->input->post('patient_name'),
            'patient_age' => $this->input->post('patient_age'),
            'patient_number' => $this->input->post('patient_number'),
            'patient_area' => $this->input->post('patient_area'),
            'patient_street_no' => $this->input->post('patient_street_no'),
            'patient_city' => $this->input->post('patient_city'),
            'patient_state' => $this->input->post('patient_state'),
            'patient_pincode' => $this->input->post('patient_pincode'),
            'patient_type' => $this->input->post('patient_type'),
            'latitude' => $this->input->post('patient_latitude'),
            'longitude' => $this->input->post('patient_longitude'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'customer_id' => "",
            'regvendor_id' => "",


        );
        $pms["whereCondition"]  =   "(register_email = '".$this->input->post('email')."')";
        $pms["columns"]         =   "registration_id";
        $get_user     =   $this->registration_model->getRegistration($pms);
        
        if($get_user)
        {
            $data['customer_id'] = $get_user['registration_id'];
            
        }
        $condition["whereCondition"]    =   "regvendor_id = '".$this->input->post('regvendor_id')."'";
        $condition["columns"]           =   "regvendor_id";
        $vpo    =   $this->vendor_registration_model->getRegistration($condition);
        if(is_array($vpo) && count($vpo) > 0)
        {
            $data['regvendor_id'] = $vpo['regvendor_id'];
        }
        if($data['customer_id'] == "" or $data['regvendor_id'] == "")
        {
            return 0;
        }
        else
        {
            $insert_customer_details = $this->db->insert("customer_details",$data);
            if($insert_customer_details)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }
    public function booked_dates()
    {
        $regvendor_id = $this->input->post('regvendor_id');
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $booked_dates  = $this->db->select('id,DATE_FORMAT(
                date,"%Y-%m-%d") as date')
              ->where('MONTH(date)', $month)
              ->where('YEAR(date)', $year)
              ->where('regvendor_id',$regvendor_id)
              ->get("check_availability")
              ->result_array();
        return $booked_dates;
    }
    public function check_booked_dates()
    {
        $regvendor_id = $this->input->post('regvendor_id');
        $pms["whereCondition"]  =   "(register_email = '".$this->input->post('email')."')";
        $pms["columns"]         =   "registration_id";
        $get_user     =   $this->registration_model->getRegistration($pms);
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $booked_dates  = $this->db->select('date')
              ->where('date BETWEEN "'. date('Y-m-d', strtotime($from_date)). '" and "'. date('Y-m-d', strtotime($to_date)).'"')
              ->where('regvendor_id',$regvendor_id)
              ->get("check_availability")
              ->result_array();
        return $booked_dates;
    }
    public function check_single_date($date)
    {
        $regvendor_id = $this->input->post('regvendor_id');
        
        $date = $date;
        $booked_date  = $this->db->select('date')
              ->where('date',$date)
              ->where('regvendor_id',$regvendor_id)
              ->get("check_availability")
              ->result_array();
        return $booked_date;
    }
    public function save_multiple_dates()
    {
        $get_booked_dates = $this->check_booked_dates();
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $array = [];
        if(count($get_booked_dates)>0)
        {
            $datediff = (strtotime($to_date) - strtotime($from_date));
            $days = floor($datediff / (60 * 60 * 24))+1;
            $count_booked_dates = count($get_booked_dates);
            $remaining_days = $days-$count_booked_dates;
            $period = new DatePeriod(
                new DateTime($from_date),
                new DateInterval('P1D'),
                new DateTime($to_date)
            );
            foreach ($period as $key => $value) 
            {
                $date = $value->format('Y-m-d');    
                $array[] = $date;  
            }
            if(is_array($array) and is_array($get_booked_dates))
            {
                $array2 = [];
                foreach($get_booked_dates as $key1=>$dates)
                {
                    foreach($dates as $date)
                    {
                        $array2[] = $date;
                    }
                }
                
                $final =  array_diff($array, $array2);
                $next_date = date('Y-m-d', strtotime($to_date .' +1 day'));
                if(count($final)>0)
                {
                    foreach ($final as $finalkey => $finalvalue) 
                    {
                        $save = $this->save_single_date($finalvalue);
                    }
                }                
                for($i=0;$i<$count_booked_dates;$i++)
                {
                    $check_single_date = $this->check_single_date($next_date);
                    if(count($check_single_date)>0)
                    {
                        $i--;
                        $next_date = date('Y-m-d', strtotime($next_date .' +1 day'));
                        continue;
                    }
                    else
                    {
                        $save = $this->save_single_date($next_date);
                        $final[] = $next_date; 
                        $next_date = date('Y-m-d', strtotime($next_date .' +1 day')); 
                    }
                    
                }
                return array_values($final);
            
            }
            
        }
        else
        {
            $period = new DatePeriod(
                new DateTime($from_date),
                new DateInterval('P1D'),
                new DateTime($to_date)
            );
             foreach ($period as $key => $value) 
             {
                $date = $value->format('Y-m-d'); 
                $save = $this->save_single_date($date);   
                $dates[] = $date;   
             }
             return $dates;

        }
    }
    public function save_single_date($date)
    {
        $regvendor_id = $this->input->post('regvendor_id');
        $pms["whereCondition"]  =   "(register_email = '".$this->input->post('email')."')";
        $pms["columns"]         =   "registration_id";
        $get_user     =   $this->registration_model->getRegistration($pms);
        //$date = $this->input->post('single');
        $data = array(
            'user_id' => $get_user['registration_id'],
            'regvendor_id' => $regvendor_id,
            'date' => $date,
            'created_at' => date('Y-m-d H:i:s')
        );
        $insert = $this->db->insert("check_availability",$data);
        if($insert)
        {
            return TRUE;
        }
    }
    public function create_wellness_contact(){
        $data = array(
            'wellness_contact_wellness_id'        => ($this->input->post('wellness_id'))??'',
            'wellness_contact_first_name'        => ($this->input->post('first_name'))??'',
            'wellness_contact_last_name'        => ($this->input->post('last_name'))??'',
            'wellness_contact_mobile'           => ($this->input->post('mobile_no'))??'',
            'wellness_contact_email'            => ($this->input->post('email_id'))??'',
            'wellness_contact_msg'              => ($this->input->post('message'))??'',
            'wellness_contact_created_by'       => ($this->input->post('email'))??'',
            'wellness_contact_created_on'       => date('Y-m-d H:i:s')
        );
        $this->db->insert("wellness_contact",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp)
        {
            $dat    =   array(
                "wellness_contact_id    "=> $vsp."WCI"
            );	
            $this->db->update("wellness_contact",$dat,"wellness_contactid='".$vsp."'");
            return true;   
        }
        
    }
    public function homecare_chatbot()
    {   
        $chatbox=array();
        $result = $this->db->query("select homecare_chat_question,homecare_chat_options
        FROM homecare_chat_box
        WHERE homecare_chat_open='1' AND homecare_chat_status='1' AND homecare_chat_acde = 'Active' AND homecare_chat_sub_module = '".$this->input->post('submodule_id')."'
        ORDER BY homecare_chat_order"   
         )->result_array();
        //  $type = array('select','text','checkbox','checkbox','checkbox','checkbox');
         foreach ($result as $key => $value) {
            $options = $value['homecare_chat_options'];
            $options_array = explode(",", $options);
            $chatbox["list"][$key]['question'] = $value['homecare_chat_question'];
            $chatbox["list"][$key]['options_0'] = "";
            $chatbox["list"][$key]['options_1'] = "";
            // $chatbox["list"][$key]['type'] = $type[$key];
            foreach ($options_array as $key1 => $ar) 
            {
                $chatbox["list"][$key]['options_'.$key1] = $ar; 
                
            }
               
           }  
        return $chatbox;
    }
    public function homecareMembership(){
        $vspld = $this->get_registration_id();
        $target_dir =   base_url().$this->config->item("upload_dest")."membership/";
        $conditions["columns"]  =   "module_name,user_package_name,user_package_id,membership_name,user_package_price,user_package_after_disc,
                                    (user_package_price-user_package_after_disc) as discount,user_package_days,user_package_about,
                                    concat('".$target_dir."',membership_image) as back_image,user_package_assigns,user_package_created_on";
        $conditions["whereCondition"]   =   "registration_id = '".$vspld."' and user_package_id not in 
                                            (select membership_id from membership_purchase where membership_purchase_by='".$vspld."')";
        $conditions['tipoOrderby'] = 'user_package_created_on';
        $conditions['order_by'] = 'desc';
        $ress =  $this->user_package_model->viewuser_package($conditions);
        $vendors = $this->vendors();
        $vendors_list = array();
        foreach($vendors as $d){
            $id = $d["vendor_id"];
            $name = $d["vendor_name"];
            $vendors_list[$id] = $name;
        }
        $res = array();
        if(is_array($ress) && count($ress) > 0){
            foreach($ress as $r){
                $ar = array();
                foreach(json_decode($r['user_package_assigns']) as $det ){
                    //array_push($ar,$vendors_list[$det->vendor_id]." for ".$det->days." days");
                    $ar[] = $vendors_list[$det->vendor_id]." for ".$det->days." days";
                }
                $re = $r;
                //$re['details'] =  json_encode($ar);
                $re['details'] =  implode(', ',$ar);
                array_push($res,$re);
            }
            return $res;
        }
        return array();
    }
    public function homecare_chatbot_save()
    {
        $data = array(
                'email'                                 => $this->input->post('email'),
                'list_of_answers'                       => $this->input->post('list'),
                'submodule_id'                          => $this->input->post('submodule_id'),
                'homecare_chat_response_cr_on'          => date("Y-m-d h:i:s")
            );

        $pms["whereCondition"]  =   "(register_email = '".$data['email']."')";
        $get_user     =   $this->registration_model->getRegistration($pms);
        $reg_id = $get_user['registration_id'];
        $data['registration_id'] = $reg_id;
        unset($data['email']);
        $this->db->insert("homecare_chat_response",$data);
        $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function homecare_click(){
            $result = $this->db->update('registration',array("register_homecare_click" => $this->input->post("sub_module_id"),"register_homecare_click_at"=> date("Y-m-d h:i:s")),array("register_email"=>$this->input->post("email")));
            if($result)
            {
                return TRUE;
            }
            return FALSE;
    }
    public function Doctor_list(){
        $target_dir             =   base_url().$this->config->item("upload_dest")."doctor/";
        $conditions["columns"]  =   "doctor_id,doctor_name,CASE WHEN doctor_image is null THEN '' ELSE  concat('".$target_dir."',doctor_image) END as  doctor_image,doctor_experience,doctor_specialization,doctor_education,doctor_language";
        $conditions["whereCondition"]  = "doctor_acde = 'Active'";
        $res =  $this->doctor_model->viewDoctor($conditions);
        if(is_array($res) && count($res) > 0){
            return $res;
        }
        return array();
    }
    public function homecareMembershipPurchase($data,$reg_id){
        $this->db->insert("membership_purchase",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp > 0){
            $membership_id = $this->input->post('membership_id');
            $conditions["columns"]  =   "user_package_days,user_package_about,user_package_sub_module_id,user_package_name,user_package_price,user_package_after_disc,user_package_assigns";
            $conditions["whereCondition"]  =   "user_package_id = '".$membership_id."' AND user_package_acde ='Active'";
            $res =  $this->user_package_model->getUser_package($conditions);
            $dat    =   array(
                "membership_purchase_id"        => $vsp."MEMPUR",
                "membership_valid_upto"         => date("Y-m-d H:i:s",strtotime("+".$res['user_package_days']." days")),
                "membership_benfits"            => $res['user_package_about'],
                "membership_module_id"          => ($res['user_package_module_id'])??'',
                "membership_sub_module_id"      => ($res['user_package_sub_module_id'])??'',
                "membership_name"               => $res['user_package_name'],
                "membership_price"              => $res['user_package_price'],
                "membership_after_disc"         => $res['user_package_after_disc'],
                "membership_assigns"            => $res['user_package_assigns'],
            );	
            $this->db->update("membership_purchase",$dat,"membership_purchaseid='".$vsp."'");
            $title = 'Purchased Package';
            $message = 'Your Package purchased Successfully';
            $id = $reg_id;
            $push_type = 'Customer';
            $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            
            return true;   
        }
    }
    public function homecare_chatbot_test_ios()
    {   
        $chatbox=array();
        $result = $this->db->query("select homecare_chat_question,homecare_chat_options
        FROM homecare_chat_box
        WHERE homecare_chat_open='1' AND homecare_chat_status='1' AND homecare_chat_acde = 'Active' AND homecare_chat_sub_module = '".$this->input->post('submodule_id')."'
        ORDER BY homecare_chat_order"   
         )->result_array();
         $type = array('select','text','checkbox','checkbox','checkbox','checkbox');
        foreach ($result as $key => $value) {
            $options = $value['homecare_chat_options'];
            $options_array = explode(",", $options);
            $chatbox["list"][$key]['question'] = $value['homecare_chat_question'];
            $chatbox["list"][$key]['options'] = array();
            $chatbox["list"][$key]['type'] = $type[$key];
            foreach ($options_array as $key1 => $ar) 
            {
                array_push($chatbox["list"][$key]['options'],$ar);
                // $chatbox["list"][$key]['options_'.$key1] = $ar; 
                
            }
               
        }  
        return $chatbox;
    }
    public function customer_support_request(){
        $data = array(
            'customer_support_mobile'           => ($this->input->post('mobile'))??'',
            'customer_support_email'            => ($this->input->post('email'))??'',
            'customer_support_cr_on'            => date('Y-m-d H:i:s')
        );
        $this->db->insert("customer_support_request",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp)
        {
            $dat    =   array(
                "customer_support_id    "=> $vsp."WCI"
            );	
            $this->db->update("customer_support_request",$dat,"customer_supportid='".$vsp."'");
            return true;   
        }
        
    }
    public function previous_reports(){
        $dta = array();
        if(!empty($this->input->post('email'))){
            $vspld = $this->get_registration_id();
        }else{
            $vspld =$this->input->post('registration_id');
        }
        
        if(count($_FILES) > 0){
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/previous_reports/";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/previous_reports");}
            $i=0;
            if(!empty($_FILES["image"]) ){
                foreach($_FILES["image"]["name"] as $image){
                    $fname      =   $image;
                    if($fname != "noname"){
                        $vsp        =   explode(".",$fname);
                        $fname      =   "COR_".time().$i.".".$vsp['1'];
                        $uploadfile =   $direct . basename($fname);
                        $vsp 	=	move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploadfile); 
                        if($vsp){
                            $dta=array(
                                "previous_reports_image"    =>  $fname,
                                "previous_reports_cr_on" => date("Y-m-d H:i:s"),
                                "registration_id"       =>  $vspld,
                                "is_pdf"                =>  0,
                                "previous_reports_cr_by" => $vspld,
                            );
                            $this->db->insert("previous_reports",$dta);
                            $vsp   =    $this->db->insert_id();
                            if($vsp > 0){
                                $dat    =   array("previous_reports_id" => $vsp."PRER");	
                                $this->db->update("previous_reports",$dat,"previous_reportsid='".$vsp."'");
                            }
                        }
                    }
                    $i++;
                }
            }
                
            if(!empty($_FILES["pdf_file"]["name"])){
                $fname      =   $_FILES["pdf_file"]["name"];
                if($fname != "noname"){
                    $vsp        =   explode(".",$fname);
                    $fname      =   "COR_".time().".".$vsp['1'];
                    $uploadfile =   $direct . basename($fname);
                    $vsp 	=	move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadfile); 
                    if($vsp){
                        $dta=array(
                            "previous_reports_image"    =>  $fname,
                            "previous_reports_cr_on" => date("Y-m-d H:i:s"),
                            "registration_id"       =>  $vspld,
                            "is_pdf"                =>  1,
                            "previous_reports_cr_by" => $vspld,
                        );
                        $this->db->insert("previous_reports",$dta);
                        $vsp   =    $this->db->insert_id();
                        if($vsp > 0){
                            $dat    =   array("previous_reports_id" => $vsp."PRER");	
                            $this->db->update("previous_reports",$dat,"previous_reportsid='".$vsp."'");
                        }
                    }
                }
            }
            return "Uploaded images Successfully";
        }else{
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   base_url().$target_dir."/previous_reports/";
            $data = $this->db->query("select concat('".$direct."',previous_reports_image) as image,is_pdf from  previous_reports Where registration_id='".$vspld."'")->result();
            return $data;
        }
        
    }
    public function get_registration_id(){
        $data = $this->db->query("select registration_id from  registration Where register_email='".$this->input->post('email')."'")->row_array();
        return $data['registration_id'];
    }
    public function medicine_list(){
        $data = $this->db->query("select concat(medicine_list_name,' - ',medicine_brand)  as medicine_list_name from  medicine_list Where medicine_list_name LIKE '%".$this->input->post('search_keyword')."%' AND medicine_list_open = '1' AND medicine_list_acde = 'Active'")->result();
        return $data;
    }
    public function lab_test_list(){
        $data = $this->db->query("select concat(lab_test_list_name,' - ',lab_test_price) as lab_test_list_name from  lab_test_list Where lab_test_list_name LIKE '%".$this->input->post('search_keyword')."%' AND lab_test_list_open = '1' AND lab_test_list_acde = 'Active'")->result();
        return $data;
    }
    public function purchase_history(){
        if($this->input->post("email") != ""){
            $registration_id = $this->get_registration_id();
        }else{
            $registration_id = ($this->input->post("registration_id"))??'';
        }
        $ress = $this->db->query("select 
        membership_purchase_id,
        DATE_FORMAT(membership_valid_upto,'%d %b %Y') as membership_valid_upto,
        DATE_FORMAT(membership_valid_upto,'%d %b %Y') as appointment_on,
        DATE_FORMAT(membership_taken_on,'%d %b %Y') as membership_taken_on,
        membership_benfits as about,
        membership_assigns,
        membership_name,
        membership_amount,
        sub_module_name,
        IF(mp.membership_id ='1USPK', 'Your Appointment',module_name) as module_name ,
        IF(mp.membership_id ='1USPK', 1, 0) as book_an_appointment
        from  membership_purchase as mp
        LEFT JOIN sub_module as s
        ON mp.membership_sub_module_id=s.sub_module_id
        LEFT JOIN modules as m
        ON mp.membership_module_id=m.moduleid
        Where membership_register_id = '".$registration_id."'
        ORDER BY DATE(membership_taken_on) DESC
        ")->result();
        // print_r($ress);exit;
        // return $data;
        $vendors = $this->vendors();
        $vendors_list = array();
        foreach($vendors as $d){
            $id = $d["vendor_id"];
            $name = $d["vendor_name"];
            $vendors_list[$id] = $name;
        }
        $res = array();
        if(is_array($ress) && count($ress) > 0){
            foreach($ress as $r){
                $ar = '';
                if(is_array($r) && count($r->membership_assigns)>0){
                    foreach(json_decode($r->membership_assigns) as $det ){
                        // array_push($ar,$vendors_list[$det->vendor_id]." for ".$det->days." days<br>");
                        $ar.=$vendors_list[$det->vendor_id]." for ".$det->days." days<br>";
                    }
                }
                
                $re = $r;
                $re->details =  $ar;
                unset($re->membership_assigns);
                $future = strtotime($r->membership_valid_upto); //Future date.
                $timefromdb = strtotime(date("Y-m-d H:i:s"));
                $timeleft = $future-$timefromdb;
                $daysleft = round((($timeleft/24)/60)/60); 
                if($daysleft<=0){
                    $re->days_left = 'Expired';
                }else{
                    $re->days_left = $daysleft.' days';
                }
                
                array_push($res,$re);
            }
            return $res;
        }
    }
    public function homecare_daywise(){
        if($this->input->post("email") != ""){
            $registration_id = $this->get_registration_id();
        }else{
            $registration_id = ($this->input->post("registration_id"))??'';
        }
        $timee_now=time();
        $plus_min = date("H:i:s", strtotime('-30 minutes', $timee_now));
        $minus_min =  date("H:i:s", strtotime('+30 minutes', $timee_now));
        //IF(DATE(membership_assign_date_from) = DATE(NOW())  AND (time_from <= '".$plus_min."' OR time_to >= '".$minus_min."'), membership_assign_otp, '') as membership_assign_otp,
        //IF(DATE(membership_assign_date_from) = DATE(NOW())  AND (time_from <= '".$plus_min."' OR time_to >= '".$minus_min."'), zoom_url, '') as zoom_url,
        $ress = $this->db->query("select 
        health_condition,
        time_from,
        time_to,
        membership_valid_upto,
        specialization_name,
        membership_name,
        membership_amount,
        vendor_name as vendor_type,
        regvendor_name as vendor_name,
        membership_assign_date_from as date,
        DATE_FORMAT(membership_taken_on,'%d %b %Y') as membership_taken_on,
        IF(DATE(membership_assign_date_from) = DATE(NOW()), membership_assign_otp, '') as membership_assign_otp,
        membership_assign_status,
        membership_assign_description,
        DATE_FORMAT(membership_valid_upto,'%d %b %Y') as membership_valid_upto,
        membership_benfits as about,
        membership_assigns,
        IF(DATE(membership_assign_date_from) = DATE(NOW()), zoom_url, '') as zoom_url,
        sub_module_name,
        module_name,
        IF(mp.membership_id ='1USPK', 1, 0) as book_an_appointment
        from  membership_assign as ma 
        LEFT JOIN membership_purchase as mp 
        ON mp.membership_purchase_id = ma.membership_purchase_id
        LEFT JOIN register_vendors as rv 
        ON rv.regvendor_id = ma.membership_assign_vendor
        LEFT JOIN vendors as v 
        ON v.vendor_id = ma.membership_assign_vendor_type
        LEFT JOIN specialization as s 
        ON s.specialization_id = rv.regvendor_specialization
        LEFT JOIN sub_module as sm
        ON mp.membership_sub_module_id=sm.sub_module_id
        LEFT JOIN modules as m
        ON mp.membership_module_id=m.moduleid
        Where membership_register_id = '".$registration_id."' 
        AND ma.membership_purchase_id = '".$this->input->post('membership_purchase_id')."' 
        AND ma.membership_assign_open ='1'
        ORDER BY date
        ")->result();
        // echo $this->db->last_query();exit;
        $vendors = $this->vendors();
        $vendors_list = array();
        foreach($vendors as $d){
            $id = $d["vendor_id"];
            $name = $d["vendor_name"];
            $vendors_list[$id] = $name;
        }
        $res = array();
        $res['membership_details']  = array();
        $res['membership_history'] = array();
        $dates = array();
        if(is_array($ress) && count($ress) > 0){
            foreach($ress as $r){
                $ar = '';
                if(is_array($r) && count($r->membership_assigns)>0){
                    foreach(json_decode($r->membership_assigns) as $det ){
                        // array_push($ar,$vendors_list[$det->vendor_id]." for ".$det->days." days");
                        $ar.=$vendors_list[$det->vendor_id]." for ".$det->days." days<br>";
                    }
                }
                
                $re = array(
                    "valid_upto"        =>  date("d-M-Y",strtotime($r->membership_valid_upto)),
                    "purchased_date"    =>  date("d-M-Y",strtotime($r->membership_taken_on)),
                    "about"             =>  $r->about,
                    "book_an_appointment"   => $r->book_an_appointment,
                    "health_condition"  =>  $r->health_condition ,
                    "membership_name"   =>  $r->membership_name,
                    "membership_amount" =>  $r->membership_amount ,
                    "module_name"       =>  $r->module_name,
                    "sub_module_name"   =>  $r->sub_module_name,
                    "details"           =>  '',
                    "days_left"         =>  ''
                );
                $ree = array(
                    "specialization_name"           => ($r->specialization_name!="")?$r->specialization_name:'',
                    "date"                          => date("d-M-Y",strtotime($r->date)),
                    "vendor_type"                   => $r->vendor_type,
                    "vendor_name"                   => $r->vendor_name,
                    "timeslot"                      =>  date("h:iA",strtotime($r->time_from))." - ".date("h:iA",strtotime($r->time_to)),
                    "membership_assign_otp"         => $r->membership_assign_otp,
                    "membership_assign_status"      => $r->membership_assign_status,
                    "zoom_url"                      => $r->zoom_url,
                    "membership_assign_description" => ($r->membership_assign_description)??'',
                );
                $re['details'] =  $ar;
                $future = strtotime($r->membership_valid_upto); //Future date.
                $timefromdb = strtotime(date("Y-m-d H:i:s"));
                $timeleft = $future-$timefromdb;
                $daysleft = round((($timeleft/24)/60)/60); 
                if($daysleft<=0){
                    $re['days_left'] = 'Expaired';
                }else{
                    $re['days_left'] = $daysleft.' days';
                }
                $res['membership_details']  =   $re;
                $check=0;$z=0;
                foreach($res['membership_history'] as $h){
                    if(date("d-M-Y",strtotime($r->date)) == $h['date']){
                        array_push($res['membership_history'][$z]['dateinfo'],$ree);
                        $check = 1;
                    }
                    $z++;
                }
                if($check == 0){
                    $da = array(
                        "date" =>date("d-M-Y",strtotime($r->date)),
                        "dateinfo" =>array($ree )
                        );
                        array_push($res['membership_history'],$da);
                }
                // if(in_array(date("d-M-Y",strtotime($r->date)),$res['membership_history']['date'])){
                    
                // }
                // if (array_key_exists(date("d-M-Y",strtotime($r->date)),$res['membership_history'])){
                // }else{
                //     $res['membership_history'][date("d-M-Y",strtotime($r->date))] = array();
                // }
                // array_push($res['membership_history'][date("d-M-Y",strtotime($r->date))],$ree);
            }
            return $res;
        }
    }
    public function prescription_history(){
        if($this->input->post("email") != ""){
            $registration_id = $this->get_registration_id();
        }else{
            $registration_id = ($this->input->post("registration_id"))??'';
        }
        $dd = array();
        $dd['case_sheet'] = ($this->db->query("select prescription_cheif_complaints, prescription_past_history, prescription_social_history, prescription_family_history, 
                                prescription_drug_allergies, prescription_provisional_diagnosis, prescription_final_diagnosis from  prescription 
                                Where registration_id='".$registration_id."' order by prescriptionid desc")->row_array())??'No data available';
        $dd['vitals'] = ($this->db->query("select vital_weight, vital_temperature, vital_pulse_rate, vital_respiratory_rate, vital_spo2, 
                                            vital_bp, vital_cvs, vital_cns from vital 
                                            Where registration_id='".$registration_id."' order by vitalid desc")->row_array())??'No data available';
        $dd['medication']   =   $this->medication_history($registration_id);
        $dd['investigation']   =   $this->investigation_history($registration_id);
        $dd['notes']   =   $this->Notes($registration_id);
        return $dd;
    }
    public function medication_history($registration_id){
        $ress = $this->db->query("select 
        medication_id,
        medication_key,
        membership_assign_date_from as date,
        regvendor_name, sp.specialization_name
        from medication as m
        LEFT JOIN membership_assign as ma 
        ON m.membership_assign_id = ma.membership_assign_id
        LEFT JOIN register_vendors as rv 
        ON m.regvendor_id = rv.regvendor_id
        LEFT JOIN specialization as sp 
        ON sp.specialization_id = rv.regvendor_specialization
        Where m.registration_id = '".$registration_id."'
        ORDER BY date DESC
        ")->result();
        $res = array();
        $res['membership_history'] = array();
        $dates = array();
        if(is_array($ress) && count($ress) > 0){
            foreach($ress as $r){
                $ar = '';
                $ree = (array)json_decode($r->medication_key);
                $check=0;$z=0;
                foreach($res['membership_history'] as $h){
                    if(date("d-M-Y",strtotime($r->date)) == $h['date']){
                        $rss = (array)$ree[0];
                        if($r->specialization_name!=''){
                            $rss['vendor_name'] = $r->regvendor_name.', '.$r->specialization_name;
                        } else {
                            $rss['vendor_name'] = $r->regvendor_name.', Health Coach';
                        }
                        array_push($res['membership_history'][$z]['dateinfo'],$rss);
                        $check = 1;
                    }
                    $z++;
                }
                if($check == 0){
                    $rss = (array)$ree[0];
                        if($r->specialization_name!=''){
                            $rss['vendor_name'] = $r->regvendor_name.', '.$r->specialization_name;
                        } else {
                            $rss['vendor_name'] = $r->regvendor_name.', Health Coach';
                        }
                        $da = array(
                        "date" =>date("d-M-Y",strtotime($r->date)),
                        "dateinfo" =>array($rss)
                        );
                        array_push($res['membership_history'],$da);
                }
            }
            return $res['membership_history'];
        }
    }
    public function investigation_history($registration_id){
        $ress = $this->db->query("select 
        investigation_id,
        investigation_key,
        membership_assign_date_from as date,
        regvendor_name,sp.specialization_name
        from investigation as i
        LEFT JOIN membership_assign as ma 
        ON i.membership_assign_id = ma.membership_assign_id
        LEFT JOIN register_vendors as rv 
        ON i.regvendor_id = rv.regvendor_id
        LEFT JOIN specialization as sp 
        ON sp.specialization_id = rv.regvendor_specialization
        Where i.registration_id = '".$registration_id."'
        ORDER BY date DESC
        ")->result();
        $res = array();
        $res['membership_history'] = array();
        $dates = array();
        if(is_array($ress) && count($ress) > 0){
            foreach($ress as $r){
                $ar = '';
                $ree = (array)json_decode($r->investigation_key);
                
                $check=0;$z=0;
                foreach($res['membership_history'] as $h){
                    if(date("d-M-Y",strtotime($r->date)) == $h['date']){
                        // $ree[0][0]['givenby']=$r->regvendor_name;
                        $rss = (array)$ree[0];
                        if($r->specialization_name!=''){
                            $rss['vendor_name'] = $r->regvendor_name.', '.$r->specialization_name;
                        } else {
                            $rss['vendor_name'] = $r->regvendor_name.', Health Coach';
                        }
                        array_push($res['membership_history'][$z]['dateinfo'],$rss);
                        $check = 1;
                    }
                    $z++;
                }
                if($check == 0){
                    $rss = (array)$ree[0];
                    if($r->specialization_name!=''){
                        $rss['vendor_name'] = $r->regvendor_name.', '.$r->specialization_name;
                    } else {
                        $rss['vendor_name'] = $r->regvendor_name.', Health Coach';
                    }
                    $da = array(
                        "date" =>date("d-M-Y",strtotime($r->date)),
                        "dateinfo" =>array($rss)
                        );
                        array_push($res['membership_history'],$da);
                }
            }
            return $res['membership_history'];
        }
    }
    public function Notes($registration_id){
        $ress = $this->db->query("select 
        membership_assign_description,
        regvendor_name,
        membership_assign_date_from as date,sp.specialization_name
        from membership_assign as ma
        LEFT JOIN membership_purchase as mp 
        ON mp.membership_purchase_id = ma.membership_purchase_id
        LEFT JOIN register_vendors as rv 
        ON ma.membership_assign_vendor = rv.regvendor_id
        LEFT JOIN specialization as sp 
        ON sp.specialization_id = rv.regvendor_specialization
        Where mp.membership_register_id = '".$registration_id."' 
        AND ma.membership_assign_description <> ''
        ORDER BY date DESC
        ")->result();
        $res = array();
        $res['membership_history'] = array();
        $dates = array();
        if(is_array($ress) && count($ress) > 0){
            foreach($ress as $r){
                $ar = '';
                $ree['notes'] = $r->membership_assign_description;
                
                $check=0;$z=0;
                foreach($res['membership_history'] as $h){
                    if(date("d-M-Y",strtotime($r->date)) == $h['date']){
                        // $ree[0][0]['givenby']=$r->regvendor_name;
                        $rss = (array)$ree;
                        if($r->specialization_name!=''){
                            $rss['vendor_name'] = $r->regvendor_name.', '.$r->specialization_name;
                        } else {
                            $rss['vendor_name'] = $r->regvendor_name.', Health Coach';
                        }
                        array_push($res['membership_history'][$z]['dateinfo'],$rss);
                        $check = 1;
                    }
                    $z++;
                }
                if($check == 0){
                    $rss = (array)$ree;
                    if($r->specialization_name!=''){
                        $rss['vendor_name'] = $r->regvendor_name.', '.$r->specialization_name;
                    } else {
                        $rss['vendor_name'] = $r->regvendor_name.', Health Coach';
                    }
                    $da = array(
                        "date" =>date("d-M-Y",strtotime($r->date)),
                        "dateinfo" =>array($rss)
                        );
                        array_push($res['membership_history'],$da);
                }
            }
            return $res['membership_history'];
        }
    }
    public function prescription_download(){
        if($this->input->post("email") != ""){
            $registration_id = $this->get_registration_id();
        }else{
            $registration_id = ($this->input->post("registration_id"))??'';
        }
        $dd = array();
        $html = '<style>
        table{
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          margin-top:15px;
          width: 100%;
        }
        td,th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        tr:nth-child(even){background-color: #f2f2f2;}
        
        tr:hover {background-color: #ddd;}
        
        th {
          padding-top: 6px;
          padding-bottom: 6px;
          text-align: left;
          background-color: #FFCF79;
          color: black;
        }
        .cen{
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: center;
          background-color: #4FC3A1;
          color:white;
        }
        </style>';
        
        $basic_details = ($this->db->query("select register_name,register_gender,register_age,register_email,register_mobile from  registration Where registration_id='".$registration_id."'")->row_array())??'No data available';
        if(is_array($basic_details) && count($basic_details)>0){
            $html .= '<table>';
            $html .= '<tr><th colspan="2" class="cen"> Basic Details </th></tr>';
            $html .='<tr><td>Name : </td><td>'.$basic_details["register_name"].'</td></tr>
            <tr><td>Age / Gender : </td><td>'.$basic_details["register_age"].'/'.$basic_details["register_gender"].'</td></tr>
            <tr><td>Email : </td><td>'.$basic_details["register_email"].'</td></tr>
            <tr><td>Mobile : </td><td>'.$basic_details["register_mobile"].'</td></tr>';
            $html .= '</table>';
        }
        
        $case_sheet = ($this->db->query("select prescription_cheif_complaints, prescription_past_history, prescription_social_history, prescription_family_history, prescription_drug_allergies, prescription_provisional_diagnosis, prescription_final_diagnosis from  prescription Where registration_id='".$registration_id."' ORDER BY prescriptionid DESC LIMIT 1")->row_array())??'No data available';
        if(is_array($case_sheet) && count($case_sheet)>0){
            $html .= '<table>';
            $html .= '<tr><th colspan="2" class="cen"> Case History </th></tr>';
            $html .='<tr><td>Cheif Complaints : </td><td>'.$case_sheet["prescription_cheif_complaints"].'</td></tr>
            <tr><td>Past History : </td><td>'.$case_sheet["prescription_past_history"].'</td></tr>
            <tr><td>Social History : </td><td>'.$case_sheet["prescription_social_history"].'</td></tr>
            <tr><td>Family History : </td><td>'.$case_sheet["prescription_family_history"].'</td></tr>
            <tr><td>Drug Allergies : </td><td>'.$case_sheet["prescription_drug_allergies"].'</td></tr>
            <tr><td>Provisional Diagnosis : </td><td>'.$case_sheet["prescription_provisional_diagnosis"].'</td></tr>
            <tr><td>Final Diagnosis : </td><td>'.$case_sheet["prescription_final_diagnosis"].'</td></tr>';
            $html .= '</table>';
        }
        
        $vitals = ($this->db->query("select vital_weight, vital_temperature, vital_pulse_rate, vital_respiratory_rate, vital_spo2, vital_bp, vital_cvs, vital_cns from  vital Where registration_id='".$registration_id."'")->row_array())??'No data available';
        if(is_array($vitals) && count($vitals)>0){
            $html .= '<table>';
            $html .= '<tr><th colspan="2" class="cen"> Vitals</th></tr>';
            $html .='<tr><td>Weight : </td><td>'.$vitals["vital_weight"].'</td></tr>
            <tr><td>Temperture : </td><td>'.$vitals["vital_temperature"].'</td></tr>
            <tr><td>Pulse Rate : </td><td>'.$vitals["vital_pulse_rate"].'</td></tr>
            <tr><td>Respiratory Rate : </td><td>'.$vitals["vital_respiratory_rate"].'</td></tr>
            <tr><td>Spo2 : </td><td>'.$vitals["vital_spo2"].'</td></tr>
            <tr><td>BP : </td><td>'.$vitals["vital_bp"].'</td></tr>
            <tr><td>CVS : </td><td>'.$vitals["vital_cvs"].'</td></tr>
            <tr><td>CNS : </td><td>'.$vitals["vital_cns"].'</td></tr>';
            $html .= '</table>';
        }
        $html1 = '';
        $medication   =   $this->medication_history($registration_id);
        if(is_array($medication) && count($medication)>0){
            $html1 .= '<table>';
            $html1 .= '<tr><th colspan="2" class="cen"> Prescription</th></tr>';
            foreach($medication as $m){
                $html1 .= '<tr><th colspan="2"> '.$m["date"].'</th></tr>';
                $sno = 1;
                foreach($m["dateinfo"] as $ii){ 
                    $html1 .='<tr><td> '.$sno.') 
                            <b>'.$ii['productName'].'-'.$ii['DosageForm'].'</b><br>
                            Qty : '.$ii['Quantity'].'<br>
                            Dose : '. $ii['Dose'].'<br>
                            Duration : '.$ii['Duration'].'<br>
                            Frequency : '.$ii['Frequency'].'<br>
                            Route : '.$ii['RouteAdministration'].'<br>
                            Instructions : '.$ii['Instructions'].'</td><td>
                            prescribed By : '.$ii['vendor_name'].'</td></tr>';
                    $sno++;
                    
                }
            }
            $html1 .= '</table>';
            
        }
        $investigation   =   $this->investigation_history($registration_id);
        if(is_array($investigation) && count($investigation)>0){
            $html1 .= '<table>';
            $html1 .= '<tr><th colspan="2" class="cen">Investigation</th></tr>';
            foreach($investigation as $i){
                $html1 .= '<tr><th colspan="2">'.$i["date"].'</th></tr>';
                $sno = 1;
                foreach($i["dateinfo"] as $ii){ 
                    $html1 .='<tr><td>'.$sno.')'.$ii['lab_name'].'<br></td><td>By : '.$ii['vendor_name'].'</td></tr> ';
                    $sno++;
                }
            }
            $html1 .= '</table>';
            
        }
        
        $notes   =   $this->Notes($registration_id);
        if(is_array($notes) && count($notes)>0){
            $html1 .= '<table>';
            $html1 .= '<tr><th colspan="2" class="cen">Notes</th></tr>';
            foreach($notes as $i){
                $html1 .= '<tr><th colspan="2">'.$i["date"].'</th></tr>';
                $sno = 1;
                foreach($i["dateinfo"] as $ii){ 
                    $html1 .='<tr><td>'.$sno.')'.$ii['notes'].'<br></td><td>By : '.$ii['vendor_name'].'</td></tr> ';
                    $sno++;
                }
            }
            $html1 .= '</table>';
            
        }
        
        $filename = 'sdfk.pdf';
		$logo_url	=base_url().'assets/logo-name.png';
        $mpdftest = $this->mpdftest->indexval();
		$mpdftest->SetHTMLHeader ('<img src="'.$logo_url.'" height="50px"></img>');
		$mpdftest->SetHTMLFooter('
		            <div style="width: 100%; overflow: hidden;">
		            <hr>
                        <div style="width:33%;float: left;padding:0px;margin:0px;">{DATE j-M-Y}</div>
                        <div style="margin-left:33%;width:33%;text-align: center;padding:0px;margin:0px;">{PAGENO}/{nbpg}</div>
                        <div style="width:33%;float: right;text-align: right;padding:0px;margin:0px;">Sujeevan Health</div>
                    </div>
                        ');
// 		$mpdftest->AddPage();
// AddPage ( $orientation $type $resetpagenum $pagenumstyle $suppress $margin-left $margin-right $$margin-top $$margin-bottom $$margin-header $margin-footer )
        $mpdftest->AddPage('','','','','',15,15,30,30,10,10);
		$mpdftest->SetWatermarkText('Sujeevan Health',0.05);
        $mpdftest->showWatermarkText = true;
		$mpdftest->WriteHTML('<h2 style="text-align:center;">Sujeevan User Case Sheet</h2>');
		$mpdftest->WriteHTML("$html");
		$mpdftest->AddPage('','','','','',15,15,30,30,10,10);
		$mpdftest->WriteHTML("$html1");
		if($this->input->post('share')==1){
		    $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/usercasehistory";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/usercasehistory");}
            $target_dir =   $this->config->item("upload_dest")."usercasehistory/";
            $name =str_replace("=","",base64_encode($registration_id));
		    $mpdftest->Output($target_dir.'usercasehistory_'.$name.'.pdf', 'F');
		    $rrr['name'] = ($basic_details["register_name"])??'';
		    $rrr['url'] = base_url().$target_dir.'usercasehistory_'.$name.'.pdf';
		    return $rrr;
		}else{
		    $mpdftest->Output($filename, 'D');
		  //   return 'File Downloading';
		}
		
    }
    public function vaccine_request(){
        $data = array(
            'vaccine_request_for'           => ($this->input->post('vaccine_request_for'))??'',
            'vaccine_request_mobile'        => ($this->input->post('vaccine_request_mobile'))??'',
            'vaccine_request_age'           => ($this->input->post('vaccine_request_age'))??'',
            'vaccine_request_name'          => ($this->input->post('vaccine_request_name'))??'',
            'vaccine_request_by'            => ($this->input->post('email'))??'',
            'vaccine_request_on'            => date('Y-m-d H:i:s')
        );
        $this->db->insert("vaccine_request",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp)
        {
            $dat    =   array(
                "vaccine_request_id    "=> $vsp."VREQ"
            );	
            $this->db->update("vaccine_request",$dat,"vaccine_requestid='".$vsp."'");
            return true;   
        }
        
    }
    public function get_doctors($time_slot){
        $day = $day = date('l', strtotime($this->input->post('date')));
        $date = date("Y-m-d", strtotime($this->input->post('date')));
        $time_slot = explode(' - ',$time_slot);
        $start_time = ($time_slot[0])?date('H:i:s',strtotime($time_slot[0])):'';
        $end_time = ($time_slot[1])?date('H:i:s',strtotime($time_slot[1])):'';
        // $health_sub_category = $this->input->post('health_sub_category');
        // $sub_category_array = explode(",",$health_sub_category);
        // $sub_category_str = implode("','",$sub_category_array);
        $target_dir =   base_url().$this->config->item("upload_dest")."vendors/";
        $where = '';
        $vendor_id = $this->input->post('vendor_id');
        // if(empty($this->input->post('vendor_id'))){
        //     $vendor_id = "5VT";
        //     $where = "AND a.regvendor_specialization IN (select spec_id from assign_specialization where subhealthcategory_id in ('$sub_category_str'))";
        // }else{
        //     $vendor_id = $this->input->post('vendor_id');
        //     if($vendor_id=="5VT"){
        //         $where = "AND a.regvendor_specialization IN (select spec_id from assign_specialization where subhealthcategory_id in ('$sub_category_str'))";
        //     }
        // }
        if(!empty($this->input->post('specialization_id'))){
            $where .=" AND a.regvendor_specialization = '".$this->input->post('specialization_id')."' ";
        }
        if(!empty($this->input->post('city_id'))){
            $where .=" AND a.regvendor_city = ".$this->input->post('city_id')." ";
        }
        $response = $this->db->query(
                        "select a.regvendor_id,
                        GROUP_CONCAT(b.degreevendor_degree) regvendor_degree,
                        s.specialization_name,
                        a.regvendor_experience_yrs,
                        a.regvendor_name,
                        a.regvendor_phone,
                        d.district_name,
                        t.state_name,
                        concat('".$target_dir."',a.regvendor_upload_picture) as vendor_image,
                        a.regvendor_address,
                        round(a.regvendor_fee,0) as regvendor_fee,
                        a.regvendor_language,
                        a.regvendor_type_of_consultation 
                        FROM doctor_availability as da
                        LEFT JOIN register_vendors as a ON a.regvendor_id = da.regvendor_id
                        LEFT JOIN state as t ON t.state_status = 1 and a.regvendor_state = t.state_id
                        LEFT JOIN district as d ON d.district_status = 1 and d.district_id = a.regvendor_city
                        LEFT JOIN specialization s ON a.regvendor_specialization=s.specialization_id
                        LEFT JOIN register_vendor_degree b  ON a.regvendor_id IN (b.degreevendor_regvendor_id)  
                        LEFT JOIN membership_assign as ma ON a.regvendor_id = ma.membership_assign_vendor 
                                AND ma.membership_assign_date_from = '".$date."'
                                AND (ma.time_from BETWEEN '".$start_time."' AND '".$end_time."'
                                OR ma.time_to BETWEEN '".$start_time."' AND '".$end_time."')
                        WHERE da.doctor_availability_day = '".$day."'
                        AND da.doctor_availability_from <= '".$start_time."'
                        AND da.doctor_availability_to >= '".$end_time."'
                        AND ma.membership_assignid IS NULL
                        AND regvendor_fee IS NOT NULL
                        AND a.regvendor_vendor_id='".$vendor_id."'
                        ".$where."
                        GROUP BY a.regvendor_id")->result_array();
                        // echo $this->db->last_query();exit;
        // $title = 'New Appointment';
        //     $message = 'New Appointment Booked';
        //     $id = "217USR";
        //     $push_type = 'Vendor';
        //     $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
        //     echo $e;exit;
        return $response;
        

    }
    public function bookappointmentMembershipPurchase($data){
        $this->db->insert("membership_purchase",$data);
        $vsp   =    $this->db->insert_id();
        $fee = ($this->db->query("select regvendor_fee from  register_vendors Where regvendor_id='".$this->input->post('regvendor_id')."'")->row_array())??'No data available';
        if(is_array($fee) && count($fee)>0){
            $fee = $fee['regvendor_fee'];
        }
        if($vsp > 0){
            $membership_id = "1USPK";
            $conditions["columns"]  =   "user_package_days,user_package_about,user_package_module_id,user_package_sub_module_id,user_package_name,user_package_price,user_package_after_disc,user_package_assigns";
            $conditions["whereCondition"]  =   "user_package_id = '".$membership_id."' AND user_package_acde ='Active'";
            $res =  $this->user_package_model->getUser_package($conditions);
            $dat    =   array(
                "membership_purchase_id"        => $vsp."MEMPUR",
                "membership_valid_upto"         => date("Y-m-d",strtotime($this->input->post('date'))),
                "membership_benfits"            => $res['user_package_about'],
                "membership_module_id"          => ($res['user_package_module_id'])??'',
                "membership_sub_module_id"      => ($res['user_package_sub_module_id'])??'',
                "membership_name"               => $res['user_package_name'],
                "membership_price"              => ($fee)??'',
            );	
            $this->db->update("membership_purchase",$dat,"membership_purchaseid='".$vsp."'");
            
            
        
            
            // add to assign
            
            $rand_otp = rand(1000,9999);
            $time_slot = $this->input->post('timeslot');
            $time_slot = explode(' - ',$time_slot);
            $start_time = ($time_slot[0])?date('H:i:s',strtotime($time_slot[0])):'';
            $end_time = ($time_slot[1])?date('H:i:s',strtotime($time_slot[1])):'';
            $ven_sel ='';
            if(!empty($this->input->post('regvendor_id'))){
                $dataaa = $this->db->query("select regvendor_vendor_id from  register_vendors Where regvendor_id='".$this->input->post('regvendor_id')."'")->row_array();
                $ven_sel = $dataaa['regvendor_vendor_id'];
            }
            
            $dta= array(
                    "membership_assign_vendor"              =>  $this->input->post('regvendor_id'),
                    "membership_assign_date_from"           =>  date("Y-m-d",strtotime($this->input->post('date'))),
                    "membership_assign_vendor_type"         =>  ($ven_sel)??'',
                    "time_from"                             =>  $start_time,
                    "time_to"                               =>  $end_time,
                    "membership_assign_otp"                 =>  $rand_otp,
                    "membership_assign_status"              =>  (!empty($ven_sel) && $ven_sel=='5VT')?"Visited":"Assigned",
                    "membership_purchase_id"                =>  $vsp."MEMPUR",
                    "membership_assign_open"                =>  1
                );
            $arr['topic']='Appointment meet by sujeevann';
            date_default_timezone_set("Asia/Kolkata");
            $arr['start_date']=date("Y-m-d H:i:s",strtotime($this->input->post('date') .' '.$start_time) - 60*60*8);
            $arr['duration']=60;
            $arr['password']='sujeevan';
            $arr['type']='2';
            $result=$this->zoom_meet->createMeeting($arr);
            if(isset($result->id)){
            	$dta['zoom_url']=$result->join_url;
            	$dta['zoom_meet_id']=$result->id;
            }
            $dta['membership_assign_cr_on']=date("Y-m-d h:i:s");
            $dta['membership_assign_cr_by']=($this->session->userdata("login_id"))??'';
            $this->db->insert("membership_assign",$dta);
            $vsp   =    $this->db->insert_id();
            
            if($vsp > 0){
                $dat    =   array(
                            "membership_assign_id    "=> $vsp."MEMASS"
                        );	
                $this->db->update("membership_assign",$dat,"membership_assignid='".$vsp."'");
            }
            $registration_id = $this->get_registration_id();
            $title = 'Purchased Package';
            $message = 'Your Appointment Booked Successfully';
            $id = $registration_id;
            $push_type = 'Customer';
            $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            $title = 'New Appointment';
            $message = 'New Appointment Booked';
            $id = $this->input->post("regvendor_id");
            $push_type = 'Vendor';
            $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            
            return true;   
        }
    }
    public function bookappointment_request(){
        $registration_id = $this->get_registration_id();
        $data = array(
            'registration_id'           => ($registration_id)??'',
            'regvendor_id'              => ($this->input->post('regvendor_id'))??'',
            'vendor_id'                 => ($this->input->post('vendor_id'))??'',
            'date'                      => ($this->input->post('date'))??'',
            'timeslot'                  => ($this->input->post('timeslot'))??'',
            'fee'                       => ($this->input->post('fee'))??'',
            'cr_by'                         => ($this->input->post('email'))??'',
            'cr_on'                         => date('Y-m-d H:i:s')
        );
        $this->db->insert("bookappointment_request",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp)
        {
            $dat    =   array(
                "bookappointment_request_id    "=> $vsp."BREQ"
            );	
            $this->db->update("bookappointment_request",$dat,"bookappointment_requestid='".$vsp."'");
            return true;   
        }
        
    }
    public function notification_history(){
        if($this->input->post("email") != ""){
            $registration_id = $this->get_registration_id();
        }
        $data = $this->db->query("select  * from  notification Where notification_user_id = '".$registration_id."' AND notification_type ='CUSTOMER' ORDER BY notification_id DESC")->result();
        return $data;
    }
    public function health_files(){
        $dta = array();
        if(!empty($this->input->post('email'))){
            $vspld = $this->get_registration_id();
        }else{
            $vspld =$this->input->post('registration_id');
        }
        
        if(count($_FILES) > 0){
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/health_files/";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/health_files");}
            $i=0;
            if(!empty($_FILES["image"]) ){
                foreach($_FILES["image"]["name"] as $image){
                    $fname      =   $image;
                    if($fname != "noname"){
                        $vsp        =   explode(".",$fname);
                        $fname      =   "COR_".time().$i.".".$vsp['1'];
                        $uploadfile =   $direct . basename($fname);
                        $vsp 	=	move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploadfile); 
                        if($vsp){
                            $dta=array(
                                "health_files_image"    =>  $fname,
                                "health_files_cr_on" => date("Y-m-d H:i:s"),
                                "registration_id"       =>  $vspld,
                                "is_pdf"                =>  0,
                                "health_files_cr_by" => $vspld,
                            );
                            $this->db->insert("health_files",$dta);
                            $vsp   =    $this->db->insert_id();
                            if($vsp > 0){
                                $dat    =   array("health_files_id" => $vsp."HFLE");	
                                $this->db->update("health_files",$dat,"health_filesid='".$vsp."'");
                            }
                        }
                    }
                    $i++;
                }
            }
                
            if(!empty($_FILES["pdf_file"]["name"])){
                $fname      =   $_FILES["pdf_file"]["name"];
                if($fname != "noname"){
                    $vsp        =   explode(".",$fname);
                    $fname      =   "COR_".time().".".$vsp['1'];
                    $uploadfile =   $direct . basename($fname);
                    $vsp 	=	move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadfile); 
                    if($vsp){
                        $dta=array(
                            "health_files_image"    =>  $fname,
                            "health_files_cr_on" => date("Y-m-d H:i:s"),
                            "registration_id"       =>  $vspld,
                            "is_pdf"                =>  1,
                            "health_files_cr_by" => $vspld,
                        );
                        $this->db->insert("health_files",$dta);
                        $vsp   =    $this->db->insert_id();
                        if($vsp > 0){
                            $dat    =   array("health_files_id" => $vsp."HFLE");	
                            $this->db->update("health_files",$dat,"health_filesid='".$vsp."'");
                        }
                    }
                }
            }
            return "Uploaded images Successfully";
        }else{
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   base_url().$target_dir."/health_files/";
            $data = $this->db->query("select health_files_id,concat('".$direct."',health_files_image) as image,is_pdf from  health_files Where registration_id='".$vspld."'")->result();
            return $data;
        }
        
    }
    public function delete_health_files(){
        $health_files_id = $this->input->post("health_files_id");
        $target_dir     =   $this->config->item("upload_dest");
        $direct         =   $target_dir."/health_files/";
        $data = $this->db->query("select health_files_id,concat('".$direct."',health_files_image) as image from  health_files Where health_files_id='".$health_files_id."'")->row_array();
        if(count($data)>0){
            $this->db->delete('health_files', array('health_files_id' => $data['health_files_id']));
            unlink($data['image']);
            return "deleted file Successfully";
        }
         return "contact support"; 
    }
        public function viewappversion($params = array()){
                //$params["whereCondition"]   =   "version_no = '".$this->input->post("version_no")."'";
                $device_os  =   $this->input->post("device_os");
                $app_type  =   ($this->input->post("app_type"))??0;
                if($device_os == ''){
                    $device_os =0;
                }
                $params["limit"]    =   "1";
                $params["order_by"] =   "DESC";
                $params['tipoOrderby']  =   "versionid";
                $params["whereCondition"]   =   "version_os = '".$device_os."' AND app_type = '".$app_type."'";
                $vsp    =   (array)$this->query_appversion($params)->row_array();
                if(count($vsp) > 0){
                    if($vsp['version_no'] > $this->input->post("version_no")){
                        return $vsp;
                    }
                }
                return array();
        }
        public  function query_appversion($params = array()){
                $dt         =   array(
                                    "version_open"      =>     '1',
                                    "version_status"    =>  1
                            );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("app_versions")
                            ->where($dt); 
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                } 
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(version_no LIKE '%".$params["keywords"]."%')");
                }  
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
                // $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
               
        }
}