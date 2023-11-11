<?php
class Role_model extends CI_Model{
        public function get_max($col,$tbl){
                $this->db->select("max($col) as maxid");
                $valp 	=	$this->db->get($tbl)->row();
                return $valp->maxid+1;
        }
        public function create_role(){
                $dta    =   array(
                                    "ut_id"             =>      $this->role_model->get_max("id","usertype")."utype",
                                    "ut_name"           =>      ucwords($this->input->post("role_name")),
                                    "ut_created_on"     =>      date("Y-m-d h:i:s"),
                                    "ut_created_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->insert("usertype",$dta);
//                echo $this->db->last_query();exit; 
                if($this->db->insert_id() >  0){ 
                        return TRUE;
                }
                return FALSE;
        }
        public function query_roles($params = array()){
                $dt         =   array(
                                    "ut_open"      =>     '1'
                            );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("usertype")
                            ->where($dt);
                if(array_key_exists("unique_role",$params)){
                        $this->db->where("(ut_name LIKE '".$params["unique_role"]."')");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(ut_name LIKE '%".$params["keywords"]."%')");
                }
                if(array_key_exists("uri",$params)){
                        $this->db->where("ut_id",$params["uri"]);
                }
                if(array_key_exists("ad_id",$params)){
                        $this->db->where("id > ",$params["ad_id"]);
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
                
//                $this->db->get();echo $this->db->last_query();exit;
                return  $this->db->get();
        }
        public function cntview_role($params  =    array()){
                $params["cnt"]      =   "1";
                $params["ad_id"]    =   "2";
                $val    =   $this->query_roles($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function view_role($params  =    array()){
                $params["ad_id"]    =   "2";  
                return  $this->query_roles($params)->result();
        }
        public function view_roleswise($params  =    array()){ 
                $params["ad_id"]    =   "2"; 
                $this->db->order_by("ut_name","asc");
                return  $this->query_roles($params)->result();
        }
        public function getRoleview($params  =    array()){ 
                return  $this->query_roles($params)->row_array();
        }
        public function view_types($params  =    array()){ 
                return  $this->query_roles($params)->result();
        }
        public function viewtypes($uri){ 
                $params["tipoOrderby"]	=	"ut_order";
                $params["order_by"]	=	"asc"; 
//                $params["all_uid"]  =   $uri;
                return  $this->query_roles($params)->result();
        }
        public function get_role($uri){
                $params["uri"]    =   $uri;
                return  $this->query_roles($params)->row_array();
        }
        public function update_role($uri) {
                $dta    =   array( 
                                    "ut_name"            =>      ucwords($this->input->post("rolename")),
                                    "ut_modified_on"     =>      date("Y-m-d h:i:s"),
                                    "ut_modified_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->update("usertype",$dta,array("ut_id" => $uri));
                if($this->db->affected_rows() >  0){
//                        $this->transaction_log->save_log("Updated Role","Role","Update","",$this->session->userdata("login_id"));
                        return TRUE;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status) {
                $dta    =   array( 
                                    "ut_acde"            =>      $status,
                                    "ut_modified_on"     =>      date("Y-m-d h:i:s"),
                                    "ut_modified_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->update("usertype",$dta,array("ut_id" => $uri));
                if($this->db->affected_rows() >  0){
//                        $this->transaction_log->save_log("Updated Role","Role","Update","",$this->session->userdata("login_id"));
                        return TRUE;
                }
                return FALSE;
        }
        public function delete_role($uri) {
                $dta    =   array( 
                                    "ut_open"            =>      '0',
                                    "ut_modified_on"     =>      date("Y-m-d h:i:s"),
                                    "ut_modified_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->update("usertype",$dta,array("ut_id" => $uri));
                if($this->db->affected_rows() >  0){
//                        $this->transaction_log->save_log("Deleted Role","Role","Delete","",$this->session->userdata("login_id"));
                        return TRUE;
                }
                return FALSE;
        }
        public function unique_role($uri){
                $params["cnt"]              =   '1';
                $params["unique_role"]      =   $uri;
                $params["ad_id"]            =   "1";
                $vsl        =   $this->query_roles($params)->row(); 
                if($vsl->cnt > 0){
                    return "false";
                }
                return "true";
        }
        public function uniquerole($uri,$roleid){
                $params["cnt"]              =   '1';
                $params["whereCondition"]   =   "ut_name like '".$uri."' and ut_id <>  '".$roleid."'";
                $params["ad_id"]            =   "1";
                $vsl        =   $this->query_roles($params)->row_array(); 
                if(is_array($vsl) && count($vsl) > 0){
                    if($vsl["cnt"] > 0){
                        return "false";
                    }
                }
                return "true";
        }
        public function checkrolename($uri,$roleid){
                $params["cnt"]              =   '1';
                $params["whereCondition"]   =   "ut_name like '".$uri."' and ut_id <>  '".$roleid."'";
                $params["ad_id"]            =   "1";
                $vsl        =   $this->query_roles($params)->row(); 
                if($vsl->cnt ==  0){
                        return FALSE;
                }                       
                return TRUE;
        }
        public function check_unique_role($uri){
                $params["cnt"]              =   '1';
                $params["unique_role"]      =   $uri;
                $params["ad_id"]            =   "1";
                $vsl        =   $this->query_roles($params)->row(); 
                if($vsl->cnt ==  0){
                        return FALSE;
                }                       
                return TRUE;
        }
}