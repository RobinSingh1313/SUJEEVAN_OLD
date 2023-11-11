<?php

class Vendor_registration_model extends CI_Model{
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
                    "regvendor_open"            =>  0, 
                    "regvendor_modified_on" =>    date("Y-m-d h:i:s"),
                    "regvendor_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("register_vendors",$dta,array("regvendor_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "regvendor_acde"       =>    $status,
                            "regvendor_modified_on" =>    date("Y-m-d h:i:s"),
                            "regvendor_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("register_vendors",$ft,array("regvendor_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryRegistration($params = array()){
                 $dt     =   array(
                                "regvendor_open"         =>  "1",
                                "regvendor_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('register_vendors as r')
                            ->join("vendors as v","v.vendor_id = r.regvendor_vendor_id and v.vendor_status = 1 and v.vendor_open = 1","left")
                            ->join("specialization as sv","sv.specialization_id = r.regvendor_specialization and specialization_status = 1 and specialization_open = 1","left")
                            ->join("state as t","t.state_status = 1 and r.regvendor_state = t.state_id","left")
                            ->join("district as d","d.district_status = 1 and d.district_id = r.regvendor_city","left")
                            ->join("sub_module as sm","sm.sub_vendor_id = v.vendor_id and sub_module_open = 1 and sub_module_status = 1","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(regvendor_name LIKE '%".$params["keywords"]."%'  or regvendor_dob LIKE '%".$params["keywords"]."%'  or regvendor_age LIKE '%".$params["keywords"]."%'  or  LIKE '%".$params["keywords"]."%'  or district_name LIKE '%".$params["keywords"]."%'  or regvendor_gender LIKE '%".$params["keywords"]."%'  or regvendor_address LIKE '%".$params["keywords"]."%'  or regvendor_phone LIKE '%".$params["keywords"]."%'  or specialization_name LIKE '%".$params["keywords"]."%'  or regvendor_mobile LIKE '%".$params["keywords"]."%'  or regvendor_email_id LIKE '%".$params["keywords"]."%'  or regvendor_landline LIKE '%".$params["keywords"]."%'  or regvendor_registration_no LIKE '%".$params["keywords"]."%'  or regvendor_registration_council LIKE '%".$params["keywords"]."%'  or regvendor_year	int(11) LIKE '%".$params["keywords"]."%'  or regvendor_experience_yrs LIKE '%".$params["keywords"]."%'  or regvendor_current_working LIKE '%".$params["keywords"]."%'  or regvendor_gst_no LIKE '%".$params["keywords"]."%'  or regvendor_other_name LIKE '%".$params["keywords"]."%'  or regvendor_certification_name LIKE '%".$params["keywords"]."%'  or regvendor_verify_certificate_no LIKE '%".$params["keywords"]."%'  or regvendor_gym_no LIKE '%".$params["keywords"]."%'  or regvendor_gym_certificate LIKE '%".$params["keywords"]."%'  or regvendor_gym_description LIKE '%".$params["keywords"]."%'  or regvendor_acde LIKE '%".$params["keywords"]."%' )");
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
                if(array_key_exists("group_by",$params)){
                    $this->db->group_by($params["group_by"]); 
                }
                // $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function queryPackages($params = array()){
                 $dt     =   array(
                                "regpackage_status"      =>  "1",
                                "regpackage_open"        =>  "1",
                                "regvendor_open"         =>  "1",
                                "regvendor_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('register_vendor_packages as p')
                            ->join('register_vendors as r',"r.regvendor_id = p.regpackage_regvendor_id")
                            ->join("vendors as v","v.vendor_id = r.regvendor_vendor_id and v.vendor_status = 1 and v.vendor_open = 1","left")
                            ->join("specialization as sv","sv.specialization_id = r.regvendor_specialization and specialization_status = 1 and specialization_open = 1","left")
                            ->join("state as t","t.state_status = 1 and r.regvendor_state = t.state_id","left")
                            ->join("district as d","d.district_status = 1 and d.district_id = r.regvendor_city","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(regvendor_name LIKE '%".$params["keywords"]."%'  or regpackage_service_description LIKE '%".$params["keywords"]."%'  or regpackage_service_price LIKE '%".$params["keywords"]."%' or regpackage_service_name LIKE '%".$params["keywords"]."%' )");
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
        public function cntviewPackages($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryPackages($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewPackages($params = array()){
            return $this->queryPackages($params)->result_array();
        }
        public function getPackages($params = array()){
            return $this->queryPackages($params)->row_array();
        }
        public function queryBanks($params = array()){
                 $dt     =   array(
                                "regbank_status"      =>  "1",
                                "regbank_open"        =>  "1",
                                "regvendor_open"         =>  "1",
                                "regvendor_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('register_vendor_banks as p')
                            ->join('register_vendors as r',"r.regvendor_id = p.regbank_regvendor_id")
                            ->join("vendors as v","v.vendor_id = r.regvendor_vendor_id and v.vendor_status = 1 and v.vendor_open = 1","left")
                            ->join("specialization as sv","sv.specialization_id = r.regvendor_specialization and specialization_status = 1 and specialization_open = 1","left")
                            ->join("state as t","t.state_status = 1 and r.regvendor_state = t.state_id","left")
                            ->join("district as d","d.district_status = 1 and d.district_id = r.regvendor_city","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(regvendor_name LIKE '%".$params["keywords"]."%'  or regpackage_service_description LIKE '%".$params["keywords"]."%'  or regpackage_service_price LIKE '%".$params["keywords"]."%' or regpackage_service_name LIKE '%".$params["keywords"]."%' )");
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
        public function cntviewBanks($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryBanks($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewBanks($params = array()){
            return $this->queryBanks($params)->result_array();
        }
        public function getBanks($params = array()){
            return $this->queryBanks($params)->row_array();
        }
        public function queryDegrees($params = array()){
                 $dt     =   array(
                                "degreevendor_open"      =>  "1",
                                "degreevendor_status"        =>  "1",
                                "regvendor_open"         =>  "1",
                                "regvendor_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('register_vendor_degree as p')
                            ->join('register_vendors as r',"r.regvendor_id = p.degreevendor_regvendor_id","inner")
                            ->join("vendors as v","v.vendor_id = r.regvendor_vendor_id and v.vendor_status = 1 and v.vendor_open = 1","left")
                            ->join("specialization as sv","sv.specialization_id = r.regvendor_specialization and specialization_status = 1 and specialization_open = 1","left")
                            ->join("state as t","t.state_status = 1 and r.regvendor_state = t.state_id","left")
                            ->join("district as d","d.district_status = 1 and d.district_id = r.regvendor_city","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(regvendor_name LIKE '%".$params["keywords"]."%'  or regpackage_service_description LIKE '%".$params["keywords"]."%'  or regpackage_service_price LIKE '%".$params["keywords"]."%' or regpackage_service_name LIKE '%".$params["keywords"]."%' )");
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
        public function cntviewDegrees($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryDegrees($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewDegrees($params = array()){
            return $this->queryDegrees($params)->result_array();
        }
        public function getDegrees($params = array()){
            return $this->queryDegrees($params)->row_array();
        }
        public function queryAvailability($params = array()){
                 $dt     =   array(
                                "availability_open"      =>  "1",
                                "availability_status"        =>  "1",
                                "regvendor_open"         =>  "1",
                                "regvendor_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('register_availability as p')
                            ->join('register_vendors as r',"r.regvendor_id = p.availability_regvendor_id","inner")
                            ->join("vendors as v","v.vendor_id = r.regvendor_vendor_id and v.vendor_status = 1 and v.vendor_open = 1","left")
                            ->join("specialization as sv","sv.specialization_id = r.regvendor_specialization and specialization_status = 1 and specialization_open = 1","left")
                            ->join("state as t","t.state_status = 1 and r.regvendor_state = t.state_id","left")
                            ->join("district as d","d.district_status = 1 and d.district_id = r.regvendor_city","left")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(regvendor_name LIKE '%".$params["keywords"]."%'  or regpackage_service_description LIKE '%".$params["keywords"]."%'  or regpackage_service_price LIKE '%".$params["keywords"]."%' or regpackage_service_name LIKE '%".$params["keywords"]."%' )");
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
        public function cntviewAvailability($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryAvailability($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewAvailability($params = array()){
            return $this->queryAvailability($params)->result_array();
        }
        public function getAvailability($params = array()){
            return $this->queryAvailability($params)->row_array();
        }
}