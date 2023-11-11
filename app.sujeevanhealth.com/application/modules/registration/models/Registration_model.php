<?php

class Registration_model extends CI_Model{
        public function cntviewRegistration($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryRegistration($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewRegistration($params = array()){
            return $this->queryRegistration($params)->result_array();
        }
        public function getRegistration($params = array()){
            return $this->queryRegistration($params)->row_array();
        }
        public function delete_registration($uro){
                $dta    =   array(
                    "register_open"            =>  0, 
                    "register_modified_on" =>    date("Y-m-d h:i:s"),
                    "register_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("registration",$dta,array("register_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "register_acde"       =>    $status,
                            "register_modified_on" =>    date("Y-m-d h:i:s"),
                            "register_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("registration",$ft,array("registration_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryRegistration($params = array()){
                 $dt     =   array(
                                "register_open"         =>  "1",
                                "register_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('registration')
                            ->join('state',"state.state_id  = registration.register_state","left")
                            ->join('district',"district.district_id  = registration.register_city","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(register_name LIKE '%".$params["keywords"]."%' OR register_acde = '".$params["keywords"]."' OR register_mobile LIKE '%".$params["keywords"]."%' OR register_email LIKE '%".$params["keywords"]."%'  )");
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
        public function queryRegistrationchat($params = array()){
                 $dt     =   array(
                                "register_open"         =>  "1",
                                "register_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('registration')
                            ->join('chat_room as cd',"cd.chat_from = registration_id","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(register_name LIKE '%".$params["keywords"]."%' OR register_acde = '".$params["keywords"]."' OR register_mobile LIKE '%".$params["keywords"]."%' OR register_email LIKE '%".$params["keywords"]."%'  )");
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
        public function cntviewChatroom($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryRegistrationchat($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewChatroom($params = array()){
            return $this->queryRegistrationchat($params)->result_array();
        }
        public function queryRegistrationconchat($params = array()){
                 $dt     =   array(
                                "register_open"         =>  "1",
                                "register_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('registration')
                            ->join('symptom_chat_room as cd',"(cd.symptomchat_to = registration_id or cd.symptomchat_from = registration_id)","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(register_name LIKE '%".$params["keywords"]."%' OR register_acde = '".$params["keywords"]."' OR register_mobile LIKE '%".$params["keywords"]."%' OR register_email LIKE '%".$params["keywords"]."%'  )");
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
        public function cntviewconChatroom($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryRegistrationconchat($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewconsultChatroom($params = array()){
            return $this->queryRegistrationconchat($params)->result_array();
        }
        public function assignTellecaller($userid,$status){
                $dtaa   =   array(
                    "assigned_telecaller"    =>  $status,
                    "register_modified_on" =>  date("Y-m-d H:i:s"),
                    "register_modified_on" =>  $this->session->userdata("login_id")
                );
                $this->db->update("registration",$dtaa,array("registration_id" => $userid));
                return TRUE;
        } 
        public function assignDoctor($userid,$status){
                $dtaa   =   array(
                    "assigned_doctor"    =>  $status,
                    "register_modified_on" =>  date("Y-m-d H:i:s"),
                    "register_modified_by" =>  $this->session->userdata("login_id")
                );
                $this->db->update("registration",$dtaa,array("registration_id" => $userid));
                return TRUE;
        } 
        
}