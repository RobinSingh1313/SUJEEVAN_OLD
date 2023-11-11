<?php

class User_package_model extends CI_Model{
        public function create_user_package(){
            if(is_array($this->input->post('vendor_selected')) && count($this->input->post('vendor_selected'))>0 ){
                $amounts = $this->input->post('vendor_amount');
                $days = $this->input->post('vendor_days');
                $arr = array();$i=0;
                foreach($this->input->post('vendor_selected') as $ven_sel){
                    $arry = array(
                        "vendor_id" => $ven_sel,
                        "days"      =>  $days[$i],
                        "amount"    =>  $amounts[$i]
                        );
                        array_push($arr,$arry);
                        $i++;
                }
            }
            
            $data = array(
                    'user_package_name'                    =>  ucfirst($this->input->post('user_packagenametype')),
                    'user_package_alias_name'              =>  $this->common_config->cleanstr($this->input->post('user_packagenametype')),
                    'user_package_price'                   =>  $this->input->post('user_package_price'),
                    'user_package_after_disc'              =>  $this->input->post('user_package_after_disc'),
                    'user_package_module_id'               =>  $this->input->post('module_id'),
                    'user_package_sub_module_id'           =>  $this->input->post('homecare_category'),
                    'membership_id'                        =>  $this->input->post('membership_id'),
                    'user_package_assigns'                 =>  json_encode($arr),
                    'registration_id'                      =>  $this->input->post('registration_id'),
                    'user_package_days'                    =>  $this->input->post('user_package_days'),
                    'user_package_about'                   =>  $this->input->post('user_package_about'),
                    "user_package_created_on"              =>  date("Y-m-d h:i:s"),
                    "user_package_created_by"              =>  $this->session->userdata("login_id")
            );
            $this->db->insert("user_package",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array(
                                "user_package_id    "=> $vsp."USPK"
                            );	
                    $this->db->update("user_package",$dat,"user_packageid='".$vsp."'");
                    $module_details = $this->db->query("SELECT module_name FROM modules where moduleid='".$this->input->post('module_id')."'")->row();
                    $title = 'Sujeevan '.$module_details->module_name;
                    $message = 'New '.$module_details->module_name.' created for you';
                    $id = $this->input->post("registration_id");
                    $push_type = 'Customer';
                    $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
                    return true;   
             }
        }

        public function cntviewUser_package($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryUser_package($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewUser_package($params = array()){
            return $this->queryUser_package($params)->result_array();
        }
        public function getUser_package($params = array()){
            return $this->queryUser_package($params)->row_array();
        }
        public function update_user_package($str){
            if(is_array($this->input->post('vendor_selected')) && count($this->input->post('vendor_selected'))>0 ){
                $amounts = $this->input->post('vendor_amount');
                $days = $this->input->post('vendor_days');
                $arr = array();$i=0;
                foreach($this->input->post('vendor_selected') as $ven_sel){
                    $arry = array(
                        "vendor_id" => $ven_sel,
                        "days"      =>  $days[$i],
                        "amount"    =>  $amounts[$i]
                        );
                        array_push($arr,$arry);
                        $i++;
                }
            }
            $data = array(
                    'user_package_name'                    =>  ucfirst($this->input->post('user_packagenametype')),
                    'user_package_alias_name'              =>  $this->common_config->cleanstr($this->input->post('user_packagenametype')),
                    'user_package_price'                   =>  $this->input->post('user_package_price'),
                    'user_package_after_disc'              =>  $this->input->post('user_package_after_disc'),
                    'user_package_module_id'               =>  $this->input->post('module_id'),
                    'user_package_sub_module_id'           =>  $this->input->post('homecare_category'),
                    'membership_id'                        =>  $this->input->post('membership_id'),
                    'user_package_assigns'                 =>  json_encode($arr),
                    'registration_id'                      =>  $this->input->post('registration_id'),
                    'user_package_days'                    =>  $this->input->post('user_package_days'),
                    'user_package_about'                   =>  $this->input->post('user_package_about'),
                    "user_package_modified_on"             =>  date("Y-m-d h:i:s"),
                    "user_package_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("user_package",$data,"user_package_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                    $title = 'Sujeevan Homecare Package';
                    $message = 'Home care package updated';
                    $id = $this->input->post("registration_id");
                    $push_type = 'Customer';
                    $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
                return true;
            }
            return FALSE;
    }
    public function delete_user_package($uro){
            $dta    =   array(
                "user_package_open"            =>  0, 
                "user_package_modified_on" =>    date("Y-m-d h:i:s"),
                "user_package_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("user_package",$dta,array("user_package_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "user_package_acde"       =>    $status,
                            "user_package_modified_on" =>    date("Y-m-d h:i:s"),
                            "user_package_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("user_package",$ft,array("user_package_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryUser_package($params = array()){
                 $dt     =   array(
                                "user_package_open"         =>  "1",
                                "user_package_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('user_package as c')
                            ->join('membership as m','m.membership_id = c.membership_id','left')
                            ->join('modules as md','md.moduleid = c.user_package_module_id','left')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(user_package_name LIKE '%".$params["keywords"]."%' OR user_package_acde = '".$params["keywords"]."'  )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
}