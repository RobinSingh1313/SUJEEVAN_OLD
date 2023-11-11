<?php


class Users_model extends CI_Model{
        public function create_user(){
                $dta    =   array(
                                    "login_name"        =>      $this->input->post("user_name"),
                                    "login_email"       =>      $this->input->post("email"),
                                    "login_password"       =>   base64_encode ($this->input->post("password")),
                                    "login_type"       =>      $this->input->post("role"),
                                    "login_cr_on"     =>      date("Y-m-d h:i:s"),
                                    "login_cr_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->insert("login",$dta);
                $vsp    =   $this->db->insert_id();
                if($vsp){
                    $dat=array(
                                "login_id" 				        => $vsp.'login'
                        );		
                    $this->db->update("login",$dat,"lid ='".$vsp."'");
                    return TRUE;
                }
                return FALSE;
        }
        public function query_users($params = array()){
                $dt         =   array(
                                    "login_open"      =>     '1'
                            );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("login as l")
                            ->join("usertype as u","u.ut_id=l.login_type","LEFT")
                            ->where($dt);
                if(array_key_exists("unique_user",$params)){
                        $this->db->where("(login_name LIKE '".$params["unique_user"]."')");
                }
                if(array_key_exists("unique_email",$params)){
                        $this->db->where("(login_email LIKE '".$params["unique_email"]."')");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(login_name LIKE '%".$params["keywords"]."%')");
                }
                if(array_key_exists("uri",$params)){
                        $this->db->where("login_id",$params["uri"]);
                }
                if(array_key_exists("ad_id",$params)){
                        $this->db->where("lid > ",$params["ad_id"]);
                }
                if(array_key_exists("all_uid",$params)){
                        $this->db->where("(".$params["all_uid"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
                
             //   $this->db->get();echo $this->db->last_query();exit;
                return  $this->db->get();
        }
        public function cntview_user($params  =    array()){
                $params["cnt"]      =   "1";
                $params["ad_id"]    =   "2";
                $val    =   $this->query_users($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function view_user($params  =    array()){
                $params["ad_id"]    =   "2";  
                return  $this->query_users($params)->result();
        }
        public function view_userswise($params  =    array()){ 
                $params["ad_id"]    =   "2"; 
                $this->db->order_by("ut_name","asc");
                return  $this->query_users($params)->result();
        }
        public function view_types($params  =    array()){ 
                return  $this->query_users($params)->result();
        }
        public function viewtypes($uri){ 
                $params["all_uid"]  =   $uri;
                return  $this->query_users($params)->result();
        }
        public function get_user($uri){
                $params["uri"]    =   $uri;
                return  $this->query_users($params)->row_array();
        }
        public function update_user($uri) {
                $dta    =   array( 
                                    "login_name"        =>      $this->input->post("user_name"),
                                    "login_email"       =>      $this->input->post("email"),
                                    "login_password"       =>   base64_encode ($this->input->post("password")),
                                    "login_type"       =>      $this->input->post("role"),
                                    "login_md_on"     =>      date("Y-m-d h:i:s"),
                                    "login_md_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->update("login",$dta,array("login_id" => $uri));
                if($this->db->affected_rows() >  0){
                       return $this->db->affected_rows();
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "login_acde"        =>    $status,
                            "login_md_on" =>    date("Y-m-d h:i:s"),
                            "login_md_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("login",$ft,array("login_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function delete_user($uri) {
                $dta    =   array( 
                                    "login_open"            =>      '0',
                                    "login_md_on"     =>      date("Y-m-d h:i:s"),
                                    "login_md_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->update("login",$dta,array("login_id" => $uri));
                if($this->db->affected_rows() >  0){
                        $this->transaction_log->save_log("Deleted User","User","Delete","",$this->session->userdata("login_id"));
                        return TRUE;
                }
                return FALSE;
        }
        public function unique_user($uri){
                $params["cnt"]              =   '1';
                $params["unique_user"]      =   $uri;
                $params["ad_id"]            =   "2";
                $vsl        =   $this->query_users($params)->row(); 
                if($vsl->cnt > 0){
                    return "false";
                }
                return "true";
        }
        public function check_unique_user($uri){
                $params["cnt"]              =   '1';
                $params["unique_user"]      =   $uri;
                $params["ad_id"]            =   "2";
                $vsl        =   $this->query_users($params)->row(); 
                if($vsl->cnt ==  0){
                        return FALSE;
                }                       
                return TRUE;
        }
        
        public function check_email($uri){
                $params["cnt"]              =   '1';
                $params["unique_email"]      =   $uri;
                $params["ad_id"]            =   "2";
                $vsl        =   $this->query_users($params)->row(); 
                if($vsl->cnt ==  0){
                        return FALSE;
                }                       
                return TRUE;
        }
        public function assign_doctor(){
            $ft     =   array(  
                        "membership_assign_doctor"        =>    $this->input->post('doctor_id'),
                        "membership_doctor_specialization"        =>    $this->input->post('specialization_id'),
                        "membership_purchase_md_on" =>    date("Y-m-d h:i:s"),
                        "membership_purchase_md_by" =>    $this->session->userdata("login_id") 
                   );  
            $this->db->update("membership_purchase",$ft,array("membership_purchase_id" => $this->input->post('membership_id')));
            if($this->db->affected_rows() > 0){
                return TRUE;
            }
            echo $this->db->last_query();exit;
            return FALSE;
        }
        public function update_health_condition(){
            $ft     =   array(  
                        "health_condition"        =>    ($this->input->post('health_condition'))??'',
                        "visit_address"        =>    ($this->input->post('visit_address'))??'',
                        "membership_purchase_md_on" =>    date("Y-m-d h:i:s"),
                        "membership_purchase_md_by" =>    $this->session->userdata("login_id") 
                   );  
            $this->db->update("membership_purchase",$ft,array("membership_purchase_id" => $this->input->post('membership_id')));
            if($this->db->affected_rows() > 0){
                return TRUE;
            }
            echo $this->db->last_query();exit;
            return FALSE;
        }
}