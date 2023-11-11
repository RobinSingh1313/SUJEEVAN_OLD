<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Widget_model extends CI_Model{
        public function query_widget($params   =   array()){
                $tta    =   array(
                    "widget_open"   =>  1,
                    "widget_status"   =>  1,
                );
                $sel    =   '*';
                if(array_key_exists("columns",$params)){
                    $sel    =   $params["columns"]; 
                }
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                $this->db->select("$sel")
                        ->from("widgets")
                        ->where($tta);
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(widget_display_name LIKE '%".$params['keywords']."%')");
                }
                if(array_key_exists("unique_measure",$params)){
                        $this->db->where("(measure_unit LIKE '".$params["unique_measure"]."')");
                }
                if(array_key_exists("where_condition",$params)){
                        $this->db->where("(".$params["where_condition"].")");
                }   
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("order_by",$params) && array_key_exists("tipoOrderby",$params)){
                        $this->db->order_by($params["tipoOrderby"],$params['order_by']);
                }   
//                $this->db->get();echo $this->db->last_query();exit;
                return  $this->db->get();
        } 
        public function cntviewWidget($params  =    array()){
                $params["cnt"]      =   "1"; 
                $val    =   $this->query_widget($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function view_widget($params   =   array()){
//                $this->query_widget($params);echo $this->db->last_query();exit;
                return $this->query_widget($params)->result();
        } 
        public function get_users(){ 
                if($this->session->userdata("user_type") != '1utype'){
                       $this->db->where("id > ","2"); 
                }
                return $this->db->get_where("usertype",array("ut_open" => "1"))->result();
        }
        public function get_widget($uri){  
                $params["where_condition"]  =   "widget_id lIKE '".$uri."'";
                return $this->query_widget($params)->row_array();
        }
        public function unique_id_name($str){
            $pms["whereCondition"]  =   "widget_alias_name = '".$str."'";
            $vsp    =   $this->query_widget($pms);
            if(is_array($vsp) && count($vsp) > 0){
                return true;
            }
            return false;
        }
        public function get_widgetquery(){  
                return $this->db->select("*")->from("widgets"); 
        } 
        public function get_acwidgets(){  
                return $this->db->get_where("widgets",array("widget_open" => "1","widget_ac_de" => 'Active'))->result();
        }
        public function get_acwidgets_upd($vue){ 
            $lt = $vue->cpage_leftsidebar;
            $ct = $vue->cpage_content;
            $rt = $vue->cpage_rightbar;
            $sidebr = $lt . "," . $ct . "," . $rt;
            $sidebar_arr = explode(', ', $sidebr);
            //$fd = !in_array($sidebar_arr, $widgets);

            $wid = array_column($widgets, 'widget_id');
            $data = $this->db->where_in('id', $sidebar_arr ,array("widget_open" => "1","widget_ac_de" => 'Active'))->get("widgets")->result();

            $this->db->select('*');
            $this->db->where_in('widget_id',$sidebar_arr);
            $getdata=$this->db->get("widgets");
            return $getdata;   
        }
        public function get_widgets(){  
                return $this->db->select("widget_alias_name")->from("widgets"); 
        }
        public function unique_widgets($val){
                $this->db->where('widget_alias_name',str_replace(" ","_",$val));
                $vsp    =   $this->get_widgetquery()->get()->result(); 
                if(count($vsp) == 0){
                        return "true";
                }
                return "false";
        }
        public function cntview_widget($params = array()){
                $this->db->select("count(*) as cnt");
                if(array_key_exists("keywords",$params)){
                    $this->db->where("(widget_display_name LIKE '%".$params['keywords']."%')");
                }
                $vsp    =   $this->db->get_where("widgets",array("widget_open" => "1"))->row();
                return $vsp->cnt;
        }
        public function get_userwidgets(){
                $this->db->where("id > ","2");  
                $this->db->order_by("widget_display_name","DESC");
                return $this->db->get_where("widgets",array("widget_open" => "1"))->result();
        } 
        public function create_widget(){
                $ftp    =   $this->pages_model->get_variable("widgets")."wid"; 
                $ft     =   array(
                    "widget_id"                 =>  $ftp,
                    "widget_display_name"       =>  $this->input->post("widget_display_name"),
                    "widget_alias_name"         =>  strtolower($this->mobile_otp->cleanstr($this->input->post("widget_display_name"))),
                    "widget_created_on"         =>  date("Y-m-d h:i:s"),
                    "widget_created_by"         =>  $this->session->userdata("login_id")
                );  
                $this->db->insert("widgets",$ft);
                return $this->db->insert_id();
        }
        public function update_widget($uri) {
            $ft     =   $this->input->post('widget_alias_name');
            $sft     =   $this->input->post('widgetvalue');
            $tg     =   widget_path().'/'.$ft.'.php';
            if (!write_file($tg , $sft))
                echo 'Unable to write the file';
            else{
                $ft     =   array( 
                        "widget_modified_on"   =>     date("Y-m-d h:i:s"),
                        "widget_modified_by"   =>     $this->session->userdata("login_id")
                );
                $this->db->update("widgets",$ft,array("widget_id" => $uri));
                return TRUE;
            }
            return FALSE;
        }
        public function activedeactive($uri,$status) {
            $dta    =   array( 
                            "widget_ac_de"           =>      $status,
                            "widget_modified_on"     =>      date("Y-m-d h:i:s"),
                            "widget_modified_by"     =>      $this->session->userdata("login_id")
                        );
            $this->db->update("widgets",$dta,array("widget_id" => $uri));
            if($this->db->affected_rows() >  0){
                return TRUE;
            }
            return FALSE;
        }
        public function delete_widget($uri) {
               $ft     =   array( 
                        "widget_open"           =>  "0",
                        "widget_modified_on"    =>  date("Y-m-d h:i:s"),
                        "widget_modified_by"    =>  $this->session->userdata("login_id")
                ); 
                $this->db->update("widgets",$ft,array("widget_id" => $uri));
                return $this->db->affected_rows(); 
        } 
    
}