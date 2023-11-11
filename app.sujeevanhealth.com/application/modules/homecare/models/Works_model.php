<?php
class Works_model extends CI_Model{
        public function create_works(){
            $data = array(
                'item_package_item'                  =>  ucfirst($this->input->post('package_item')),
                'item_package_id'                    =>  ($this->input->post('package_id')),
                'item_package_alias_name'            =>  $this->common_config->cleanstr($this->input->post('package_item')),
                "item_package_created_on"            =>  date("Y-m-d H:i:s"),
                "item_package_created_by"            =>  $this->session->userdata("login_id")
            );
            $this->db->insert("how_it_works",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $clp    =   $vsp."IM";
                $dat    =   array("item_id"	=> $clp);	
                $this->db->update("how_it_works",$dat,array("itemid" => $vsp));
                $item       =   $this->input->post("item");
                $quantity   =   $this->input->post("quantity");
                if(is_array($item) && count($item) > 0){
                    foreach ($item as $key  =>  $el){
                        $dsata = array(
                            'subitem_item_id'               =>  $clp,
                            'subitem_name'                  =>  $el,
                            'subitem_quantity'              =>  (array_key_exists($key, $quantity))?$quantity[$key]:"",
                            "subitem_created_on"            =>  date("Y-m-d H:i:s"),
                            "subitem_created_by"            =>  $this->session->userdata("login_id")
                        );
                        $this->db->insert("how_subitems",$dsata);
                        $vsps   =    $this->db->insert_id();
                        if($vsps > 0){
                            $dclp    =   $vsps."IM";
                            $dast    =   array("subitem_id"	=> $dclp);	
                            $this->db->update("how_subitems",$dast,array("subitemid" => $vsps));
                        }
                    }
                }
                return true;   
            }
            return false;
        }
        public function cntviewworks($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryworks($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewworks($params = array()){
            return $this->queryworks($params)->result_array();
        }
        public function getworks($params = array()){
            return $this->queryworks($params)->row_array();
        }
        public function update_works($vsp){
            $data = array(
                'item_package_item'               =>  ucfirst($this->input->post('package_item')),
                'item_package_id'                 =>  ($this->input->post('package_id')),
                'item_package_alias_name'         =>  $this->common_config->cleanstr($this->input->post('package_item')),
                "item_package_modified_on"        =>  date("Y-m-d H:i:s"),
                "item_package_modified_by"        =>  $this->session->userdata("login_id")
            );
            $this->db->update("how_it_works",$data,array("item_id" => $vsp));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                $term       =   $this->input->post("termid");
                $item       =   $this->input->post("item");
                $quantity   =   $this->input->post("quantity");
                if(is_array($item) && count($item) > 0){
                    foreach ($item as $key  =>  $el){
                        $vpsl   =   (array_key_exists($key, $term))?$term[$key]:"0";
                        if($vpsl == "0"){
                            $dsata = array(
                                'subitem_item_id'               =>  $vsp,
                                'subitem_name'                  =>  $el,
                                'subitem_quantity'              =>  (array_key_exists($key, $quantity))?$quantity[$key]:"",
                                "subitem_created_on"            =>  date("Y-m-d H:i:s"),
                                "subitem_created_by"            =>  $this->session->userdata("login_id")
                            );
                            $this->db->insert("how_subitems",$dsata);
                            $vsps   =    $this->db->insert_id();
                            if($vsps > 0){
                                $dclp    =   $vsps."IM";
                                $dast    =   array("subitem_id"	=> $dclp);	
                                $this->db->update("how_subitems",$dast,array("subitemid" => $vsps));
                            }
                        }else{
                            $dast = array(
                                'subitem_name'                  =>  $el,
                                'subitem_quantity'              =>  (array_key_exists($key, $quantity))?$quantity[$key]:"",
                                "subitem_modified_on"           =>  date("Y-m-d H:i:s"),
                                "subitem_modified_by"           =>  $this->session->userdata("login_id")
                            );
//                            echo "<pre>";print_R($dast);exit;
                            $this->db->update("how_subitems",$dast,array("subitem_id" => $vpsl));
                        }
                    }
                }
                return true;   
            }
            return false;
    	}
        public function delete_works($uro){
                $dta    =   array(
                    "item_package_open"        =>   0, 
                    "item_package_modified_on" =>   date("Y-m-d H:i:s"),
                    "item_package_modified_by" =>   $this->session->userdata("login_id") 
                );
                $this->db->update("how_it_works",$dta,array("item_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "item_package_acde"        =>    $status,
                            "item_package_modified_on" =>    date("Y-m-d H:i:s"),
                            "item_package_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("how_it_works",$ft,array("item_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryworks($params = array()){
                 $dt     =   array(
                                "item_package_status"     =>  "1",
                                "item_package_open"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('how_it_works as c')
                            ->join('homecare_package as p',"p.package_id = c.item_package_id and package_open = 1 and package_status = 1","inner")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(package_item LIKE '%".$params["keywords"]."%' oR item_package_acde = '%".$params["keywords"]."%')");
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
        public function unique_id_check_works(){
                $str    =       $this->input->post('package_item');
                $item_package_id        =   $this->input->post('package_item');
                $pms["whereCondition"]  =   "item_package_item = '".$str."' and item_package_id = '".$item_package_id."'";
                $vsp    =   $this->queryworks($pms)->row_array();
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
        public function cntviewsubworks($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querysubworks($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewsubworks($params = array()){
            return $this->querysubworks($params)->result_array();
        }
        public function getsubworks($params = array()){
            return $this->querysubworks($params)->row_array();
        }
        public function querysubworks($params = array()){
                 $dt     =   array(
                                "subitem_open"      =>  "1",
                                "subitem_status"    =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('how_subitems as c')
                            ->join('how_it_works as cr',"cr.item_id = c.subitem_item_id and item_package_status = 1 and item_package_open = 1","inner")
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(package_item LIKE '%".$params["keywords"]."%' oR item_package_acde = '%".$params["keywords"]."%')");
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