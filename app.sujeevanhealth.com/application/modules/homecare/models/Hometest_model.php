<?php
class Hometest_model extends CI_Model{
        public function create_hometest(){
                $data = array(
                        'homecaretest_name'                 =>  ucfirst($this->input->post('test_name')),
                        'homecaretest_actual_price'			=>	$this->input->post('actual_price'),
                        'homecaretest_offer_price'			=>	$this->input->post('offer_price'),
                        "homecaretest_created_on"           =>  date("Y-m-d H:i:s"),
                        "homecaretest_created_by"           =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/homecare";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/homecare");}
                $target_dir =   $this->config->item("upload_dest")."homecare/";
                if(count($_FILES) > 0){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['homecaretest_image']  =   $fname;
                        }
                    }
                }
                $this->db->insert("homecare_test",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    	$dat    =   array("homecaretest_id"	=> $vsp."VT");	
                        $this->db->update("homecare_test",$dat,"homecaretestid='".$vsp."'");
                        return true;   
                }
        }

        public function cntviewTest($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryhometest($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewTest($params = array()){
            return $this->queryhometest($params)->result_array();
        }
        public function getTest($params = array()){
            return $this->queryhometest($params)->row_array();
        }
        public function update_hometest($str){
            $data = array(
                        'homecaretest_name'                 =>  ucfirst($this->input->post('test_name')),
                        'homecaretest_actual_price'			=>	$this->input->post('actual_price'),
                        'homecaretest_offer_price'			=>	$this->input->post('offer_price'),
                    "homecaretest_modified_on"             =>  date("Y-m-d H:i:s"),
                    "homecaretest_modified_by"             =>  $this->session->userdata("login_id")
            );
          	$target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/homecare";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/homecare");}
            $target_dir =   $this->config->item("upload_dest")."homecare/";
            if(count($_FILES) > 0){
              $fname      =   $_FILES["module_image"]["name"]; 
              if($fname != ''){
                $uploadfile =   $target_dir . ($fname);
                if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                  $pic =  $fname;
                  $data['hometest_image']  =   $fname;
                }
              }
            }
            $this->db->update("homecare_test",$data,"homecaretest_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    	}
        public function delete_hometest($uro){
                $dta    =   array(
                    "homecaretest_open"            =>  0, 
                    "homecaretest_modified_on" =>    date("Y-m-d H:i:s"),
                    "homecaretest_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("homecare_test",$dta,array("homecaretest_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "homecaretest_acde"       =>    $status,
                    "homecaretest_modified_on" =>    date("Y-m-d H:i:s"),
                    "homecaretest_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("homecare_test",$ft,array("homecaretest_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryhometest($params = array()){
                 $dt     =   array(
                                "homecaretest_open"         =>  "1",
                                "homecaretest_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('homecare_test as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(homecaretest_name   LIKE '%".$params["keywords"]."%' oR homecaretest_actual_price   LIKE '%".$params["keywords"]."%' oR homecaretest_offer_price  LIKE '%".$params["keywords"]."%' oR homecaretest_acde = '%".$params["keywords"]."%')");
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
        public function unique_id_check_hometest(){
                $str    =       ($this->input->post('hometest_name') != "")?$this->input->post('hometest_name'):$this->input->post('test_name');
                $homecaretest_id        =   $this->input->post("homecaretest_id");
                $mks    =   "";
                if($homecaretest_id != ""){
                    $mks    =   " and homecaretest_id not like '".$homecaretest_id."'";
                }
                $pms["whereCondition"]  =   "lower(homecaretest_name) like '".strtolower($str)."' $mks";
                // $this->queryhometest($pms);echo $this->db->last_query();exit;
                $vsp    =   $this->getTest($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}