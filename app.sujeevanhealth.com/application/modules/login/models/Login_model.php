<?php
class Login_model extends CI_Model{
        public function checkemailuser($username){  
                $params["whereCondition"]   =   '(l.login_email LIKE "'.$username.'" or l.login_name LIKE "'.$username.'")';
                $rev        =   $this->queryuser($params)->row_array();
                if(is_array($rev) && count($rev) > 0){ 
                    return true; 
                }
                return false;
        }
        public function checkemail($fields,$username){  
                $params["whereCondition"]   =   'l.'.$fields.' LIKE "'.$username.'"';
                $rev        =   $this->queryuser($params)->row_array();
                if(is_array($rev) && count($rev) > 0){ 
                    return true; 
                }
                return false;
        }
        public function queryuser($params = array()){
            $sel    =   "*";
            if(array_key_exists("columns",$params)){
                $sel    =   $params["columns"];
            }
            if(array_key_exists("cnt",$params)){
                $sel    =   "count(*) as cnt";
            }
            $dta        =   array(
                "l.login_status"    =>  '1',
                "l.login_open"      =>  '1',
                "u.ut_open"         =>  '1',
                "u.ut_status"       =>  '1',
            );
            $this->db->select($sel)
                ->from("login as l")
                ->join("usertype as u","u.ut_id = l.login_type","INNER")
                ->where($dta);
            if(array_key_exists('keywords', $params)){
                $scholid    =   $params['keywords'];
                $this->db->where("(login_name LIKE '".$scholid."' OR login_email  LIKE '".$scholid."' OR ut_name  LIKE '".$scholid."')");
            }
            if(array_key_exists('whereCondition', $params)){
                $this->db->where("(".$params['whereCondition'].")");
            }
            if(array_key_exists("ad_id",$params)){
                    $this->db->where("id > ",$params["ad_id"]);
            }
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                    $this->db->order_by($params['tipoOrderby'],$params['order_by']);
            } 
//            $this->db->get();echo $this->db->last_query();exit;
            return $this->db->get();
        }
        public function checkLogin(){ 
            $password       =   base64_encode($this->input->post("password"));
            $emails         =   $this->input->post("username");
            $parms['whereCondition']    =   "(l.login_name='".$emails."' OR l.login_email ='".$emails."') AND"
                    . " l.login_password = '".($password)."' AND l.login_acde = 'Active'";
            $vsp    =    $this->queryuser($parms)->row_array();  
            if(is_array($vsp) && count($vsp) > 0){ 
                $ins   =   $vsp;
                $this->session->set_userdata("login_id",$ins['login_id']);
                $this->session->set_userdata("login_name",$ins['login_name']);
                $this->session->set_userdata("login_type",$ins['login_type']);
                $this->session->set_userdata("login_users",$ins['ut_name']);
                $login_type    =    $this->session->userdata("login_type");
                $roles         =    $this->permission_model->get_permission($login_type);   
                if(count($roles) > 0){
                    foreach($roles  as $vp){
                        $this->session->set_userdata($vp->page_name,$vp->per_status);
                    }
                }
                return TRUE;
            } 
        } 
        public function checkvalueemail($username){  
                $params["whereCondition"]   =   "l.login_name='".$username."' OR l.login_email ='".$username."'";
                $rev        =   $this->queryuser($params)->row_array();
                if(is_array($rev) && count($rev) > 0){ 
                    return true; 
                }
                return false;
        }
        public function checkvalueemailuser($username){  
                $params["whereCondition"]   =   "l.login_email ='".$username."'";
                $rev        =   $this->queryuser($params)->row_array();
                if(is_array($rev) && count($rev) > 0){ 
                    return true; 
                }
                return false;
        }
        public function sendpassword(){
                $emailid 	=	$this->input->post("emailid");  
                $params["whereCondition"]      =   "login_email LIKE '$emailid'"; 
                $vsl        =   $this->queryuser($params)->row_array(); 
                if(is_array($vsl) && count($vsl) > 0){
                    $pass       =   base64_decode($vsl["login_password"]);  
                    $userid     =   $vsl["login_id"];
                    $ustype     =   $vsl["ut_name"];
                    $subject        =       'Forgot Password';
                    $message 	=	"Dear User,<br/><br/>";
                    $message	.=	"Please find the user credentials to login in to the portal.<br/>";
                    $message	.=	"<a href='".base_url()."'>Click Here</a><br/>";
                    $message	.=	"<b>Email Id</b>:".$emailid."<br/>";
                    $message	.=	"<b>Password</b>:".$pass;
                    $message	.=	"<br/><br/>";
                    $message	.=	"<b>Regards</b><br/>";
                    $message	.=	"<b style='color:blue;'>".sitedata("site_name")."</b>";
                    $result =  $this->common_config->configemail($emailid,$subject,$message,$userid,$ustype);
                    if($result){    
                      return TRUE;	
                    }
                }
                return FALSE; 
        }
}