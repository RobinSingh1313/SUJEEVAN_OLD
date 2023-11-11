<?php
class Country_model extends CI_Model{
        public function queryCountry($params = array()){ 
                $dta 	=	array(
                        "country_open"	=>	1,
                        "country_status"	=>	1
                );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("country")
                            ->where($dta); 
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(country_name  LIKE '%".$params["keywords"]."%' or country_currency  LIKE '%".$params["keywords"]."%' or country_code  LIKE '%".$params["keywords"]."%' or country_employee_prefix  LIKE '%".$params["keywords"]."%' or country_trip_prefix  LIKE '%".$params["keywords"]."%' or country_piligrim_prefix  LIKE '%".$params["keywords"]."%' or country_piligrimrelative_prefix  LIKE '%".$params["keywords"]."%' or country_timezone LIKE '%".$params["keywords"]."%')");
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
//                $this->db->get();echo $this->db->last_query();exit;
                return  $this->db->get();
        }
        public function cntview_country($params  =    array()){
                $params["cnt"]      =   "1"; 
                $val    =   $this->queryCountry($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function view_country($params  =    array()){ 
                return  $this->queryCountry($params)->result();
        }	
        public function get_country($params  =    array()){ 
                return  $this->queryCountry($params)->row_array();
        } 
        public function check_unique_country($dr,$country_id = ""){
                $hwr    =   "country_name LIKE '$dr'";
                if($country_id != ""){
                    $hwr    .=   " and country_id not LIKE '$country_id'";
                }
                $pmd["whereCondition"]	=	$hwr;
//                $this->queryCountry($pmd);echo $this->db->last_query();exit;
                $vsp	=	$this->queryCountry($pmd)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return true;
                }
                return false;
        }
        public function create_country(){
                $dta    =   array( 
                                "country_name"          =>	$this->input->post("country_name"),
                                "country_currency"      =>	$this->input->post("country_currency"),
                                "country_code"          =>	$this->input->post("country_code"),
                                "country_employee_prefix"   =>	$this->input->post("country_employee_prefix"),
                                "country_trip_prefix"       =>	$this->input->post("country_trip_prefix"),
                                "country_piligrim_prefix"   =>	$this->input->post("country_piligrim_prefix"),
                                "country_piligrimrelative_prefix"	=>	$this->input->post("country_piligrimrelative_prefix"),
                                "country_timezone"	=>	$this->input->post("country_timezone"),
                                "country_created_on"    =>  date("Y-m-d H:i:s"),
                                "country_created_by"    =>  $this->session->userdata("login_id")
                            );
                $this->db->insert("country",$dta);
                $vos    =   $this->db->insert_id();
                $this->db->update("country",array('country_id' => $vos."CTY"),array('countryid' => $vos)); 
                $vsp    =   $this->db->affected_rows();
                if($vsp >  0){
                    return TRUE;
                }
                return FALSE;
        }
        public function update_country($uroi){ 
                $dta    =   array( 
                                "country_name"          =>	$this->input->post("countryname"),
                                "country_currency"      =>	$this->input->post("country_currency"),
                                "country_code"          =>	$this->input->post("country_code"),
                                "country_employee_prefix"   =>	$this->input->post("country_employee_prefix"),
                                "country_trip_prefix"       =>	$this->input->post("country_trip_prefix"),
                                "country_piligrim_prefix"   =>	$this->input->post("country_piligrim_prefix"),
                                "country_piligrimrelative_prefix"	=>	$this->input->post("country_piligrimrelative_prefix"),
                                "country_timezone"	=>	$this->input->post("country_timezone"),
                                "country_modified_on"   =>      date("Y-m-d h:i:s"), 
                                "country_modified_by"   =>      $this->session->userdata("login_id")
                            ); 
                $this->db->update("country",$dta,array('country_id' => $uroi)); 
                $vsp    =   $this->db->affected_rows();
                if($vsp >  0){
                        return TRUE;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status) {
                $dta    =   array( 
                                    "country_acde"            =>      $status,
                                    "country_modified_on"     =>      date("Y-m-d h:i:s"),
                                    "country_modified_by"     =>      $this->session->userdata("login_id")
                            );
                $this->db->update("country",$dta,array("country_id" => $uri));
                if($this->db->affected_rows() >  0){
                        return TRUE;
                }
                return FALSE;
        }
        public function delete_country($uroi){ 
            $dta    =   array( 
                                "country_open"			=>	0,
                                "country_created_on"     =>      date("Y-m-d h:i:s"),
                                "country_created_by"     =>      $this->session->userdata("loginid")
                            ); 
				$this->db->update("country",$dta,array('country_id' => $uroi)); 
                $vsp    =   $this->db->affected_rows();
                if($vsp >  0){
                    return TRUE;
                }
                return FALSE;
        }
}