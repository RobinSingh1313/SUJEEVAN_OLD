<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Botconfiguation_model extends CI_Model{
        public function update_botauto($botautoid){
                $data   =   array(
                    "botauto_tags"      =>  $this->input->post("botauto_tags"),
                    "botauto_answer"    =>  $this->input->post("botauto_answer"),
                    "botauto_modified_on"     =>  date("Y-m-d H:i:s"), 
                    "botauto_modified_by"     =>  $this->session->userdata("login_id"),
                ); 
                $this->db->update("botauto_tags",$data,array("botautotag_id" => $botautoid));
                $vsp    =    $this->db->affected_rows();
                if($vsp){  
                    return true;
                }
                return false;
        }
        public function delete_botauto($botautoid){
                $data   =   array(
                    "botauto_open"           =>  0,  
                    "botauto_modified_on"     =>  date("Y-m-d H:i:s"), 
                    "botauto_modified_by"     =>  $this->session->userdata("login_id"),
                ); 
                $this->db->update("botauto_tags",$data,array("botautotag_id" => $botautoid));
                $vsp    =    $this->db->affected_rows();
                if($vsp){  
                    return true;
                }
                return false;
        }
        public function activedeactive($botautoid,$status){
                $data   =   array(
                    "botauto_acde"            =>  $status,  
                    "botauto_modified_on"     =>  date("Y-m-d H:i:s"), 
                    "botauto_modified_by"     =>  $this->session->userdata("login_id"),
                ); 
                $this->db->update("botauto_tags",$data,array("botautotag_id" => $botautoid));
                $vsp    =    $this->db->affected_rows();
                if($vsp){  
                    return true;
                }
                return false;
        }
        public function createBot(){
            $data   =   array(
                "botauto_tags"      =>  $this->input->post("botauto_tags"),
                "botauto_answer"    =>  $this->input->post("botauto_answer"),
                "botauto_created_on"    =>  date("Y-m-d H:i:s"),
                "botauto_created_by"    =>  $this->session->userdata("login_id")
            );
            $this->db->insert("botauto_tags",$data);
            $vsp    =   $this->db->insert_id();
            if($vsp > 0){
                $suplid     =   "BOT".$vsp;
                $vsp    =    $this->db->update("botauto_tags",array("botautotag_id" => $suplid),array("botautotagid" => $vsp)); 
                return true;
            }
        }
        public function queryBots($params = array()){
                $dt         =   array(
                                    "botauto_status"    =>     '1',
                                    "botauto_open"      =>     '1'
                            );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("botauto_tags")
                            ->where($dt);
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(botauto_answer LIKE '%".$params["keywords"]."%' OR botauto_tags LIKE '%".$params["keywords"]."%' OR botauto_acde LIKE '%".$params["keywords"]."%')");
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
        public function cntviewBots($params  =    array()){
                $params["cnt"]      =   "1"; 
                $val    =   $this->queryBots($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function viewBots($params  =    array()){ 
                return  $this->queryBots($params)->result_array();
        }
        public function getBots($params  =    array()){ 
                return  $this->queryBots($params)->row_array();
        }
        public function getBotsreply($params  =    array()){ 
                $vslp   =   $this->queryBots($params)->row_array();
                return ($vslp['botauto_answer'] != "")?$vslp['botauto_answer']:"";
        }
}