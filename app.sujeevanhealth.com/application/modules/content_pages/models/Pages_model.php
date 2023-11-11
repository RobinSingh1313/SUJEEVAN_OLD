<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Pages_model extends CI_Model{
        public function get_layouts(){
                $this->db->order_by("layout_name","DESC");
                return $this->db->get_where("layouts",array("layout_open" => "1"))->result();
        }
        public function get_contentform(){
                $this->db->order_by("content_from_name","DESC");
                return $this->db->get_where("content_from",array("content_from_open" => "1"))->result();
        }  
        public function get_variable($tbl){
                $this->db->select("max(id) as maxid");
                $valp 	=	$this->db->get($tbl)->row();
                return $valp->maxid+1;
        }
        public function create_page(){
            $con = $this->config->item("news_for");
                 $seo    =   array(
                        "meta_keys" =>  $this->input->post("meta_keys"),
                        "meta_desc" =>  $this->input->post("meta_desc")
                );
                $cpfm   =   $this->input->post("cpage_content_from");
                $lft    =   $this->input->post("cpage_leftsidebar")?$this->input->post("cpage_leftsidebar"):"";
                $cnt    =   $this->input->post("cpage_content")?$this->input->post("cpage_content"):"";
                $rht    =   $this->input->post("cpage_rightbar")?$this->input->post("cpage_rightbar"):"";
                if($cpfm == '3cfrom'){
                        $lft    =   $this->input->post("left_contentval")?$this->input->post("left_contentval"):"";
                        $cnt    =   $this->input->post("page_conentval")?$this->input->post("page_conentval"):"";
                        $rht    =   $this->input->post("right_contentval")?$this->input->post("right_contentval"):"";
                }
                //$ftp    =   $this->pages_model->get_variable("content_pages")."cpage";
                $uq     =   rand(111111,999999);
                $ft     =   array(
                                "cpage_title"            =>     $this->input->post("page_title"),
                                "cpage_alias_name"       =>     $this->mobile_otp->cleanstr($this->input->post("page_title")),
                                "cpage_content_url"      =>     $this->input->post("post_url")?$this->input->post("post_url"):"",
                                "cpage_layout"           =>     $this->input->post("page_layout"),
                                "cpage_content_from"     =>     $cpfm,
                                "cpage_leftsidebar"      =>     $lft, 
                                "cpage_rightbar"         =>     $rht, 
                                "cpage_content"           =>    $cnt, 
                                "cpage_show_menu"         =>    ($this->input->post("is_menu_header") == '')?"0":"1",
                                "cpage_seo_settings"      =>    serialize($seo),
                                "cpage_created_on"        =>    date("Y-m-d h:i:s"),
                                "cpage_created_by"        =>    $this->session->userdata("login_id")
                       ); 
                $this->db->insert("content_pages",$ft);
                $vps    =  $this->db->insert_id(); 
                if($vps > 0){
                        $cpage_id   =   $vps."CPAG";
                        $this->db->update("content_pages",array("cpage_id" => $cpage_id),array("cpageid" => $vps));
                        return TRUE;
                }
                return FALSE;
        }
        public function contentquery($params = array()){
                $dt     =   array(
                                "content_pages.cpage_open"          =>  "1",
                                "layouts.layout_open"               =>  "1",
                                "content_from.content_from_open"    =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('content_pages')
                           ->join('layouts','layouts.layout_id=content_pages.cpage_layout',"INNER")
                            ->join('content_from','content_from.content_from_id= content_pages.cpage_content_from',"INNER")
                            ->where($dt); 
                if(array_key_exists("uri",$params)){
                        $this->db->limit("cpage_id",$params['uri']);
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(cpage_title LIKE '%".$params['keywords']."%' OR content_from_name LIKE '%".$params['keywords']."%' OR layout_name LIKE '%".$params['keywords']."%')");
                }
                if(array_key_exists("where_condition",$params)){
                        $this->db->where("(".$params["where_condition"].")");
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
                return $this->db->get();
        }
        public function cntview_contentpages($params = array()){
                $params["cnt"]  =   '1';
                $vsp    =   $this->contentquery($params)->row_array();
                if($vsp != ""){
                    if(count($vsp) > 0){
                        return $vsp['cnt'];
                    }
                }
                return '0';
        }
        public function view_active_home($params = array()){
                $this->db->where('(cpage_status = "1" AND cpage_show_menu = "1" AND cpage_home_menu = "1")');  
                return  $this->contentquery($params)->row_array();
        } 
        public function view_pages_content($contid){
                $params =   array();
                $this->db->where('(cpage_status = "1" AND cpage_show_menu = "1" AND cpage_unique = "'.$contid.'")');  
                return  $this->contentquery($params)->row();
        }
        public function view_contentpages($params = array()){
                return  $this->contentquery($params)->result();
        }
        public function get_pages_not_in_menu($menu){
    		if(is_array($menu) && count($menu)>0){
                        $this->db->where_not_in('cpage_id', $menu);
                    }
                    $this->db->where('(cpage_status = "1" AND cpage_show_menu = "1")');  
    		return  $this->contentquery()->result();
    	}
        public function get_contentpages($uri){ 
                $this->db->where('(cpage_id = "'.$uri.'" AND cpage_status = "1" AND cpage_show_menu = "1")');  
                return  $this->contentquery()->row();
        }  
        public function update_page($uri){
                $seo    =   array(
                                    "meta_keys" =>  $this->input->post("meta_keys"),
                                    "meta_desc" =>  $this->input->post("meta_desc"),
                                    "meta_crawl" =>  $this->input->post("meta_crawl")
                            );
                $cpfm   =   $this->input->post("cpage_content_from");
                $lft    =   $this->input->post("cpage_leftsidebar")?$this->input->post("cpage_leftsidebar"):"";
                $cnt    =   $this->input->post("cpage_content")?$this->input->post("cpage_content"):"";
                $rht    =   $this->input->post("cpage_rightbar")?$this->input->post("cpage_rightbar"):"";
                if($cpfm == '3cfrom'){
                        $lft    =   $this->input->post("left_contentval")?$this->input->post("left_contentval"):"";
                        $cnt    =   $this->input->post("page_conentval")?$this->input->post("page_conentval"):"";
                        $rht    =   $this->input->post("right_contentval")?$this->input->post("right_contentval"):"";
                } 
                $ft     =   array( 
                                "cpage_title"            =>     $this->input->post("page_title"),
                                "cpage_alias_name"       =>     $this->mobile_otp->cleanstr($this->input->post("page_title")),
                                "cpage_content_url"      =>     $this->input->post("post_url")?$this->input->post("post_url"):"",
                                "cpage_layout"           =>     $this->input->post("page_layout"),
                                "cpage_content_from"     =>     $cpfm,
                                "cpage_leftsidebar"      =>     $lft, 
                                "cpage_rightbar"         =>     $rht, 
                                "cpage_content"           =>    $cnt, 
                                "cpage_show_menu"         =>    ($this->input->post("is_menu_header") == '')?"0":"1",
                                "cpage_seo_settings"      =>    serialize($seo),
                                "cpage_modified_on"       =>    date("Y-m-d h:i:s"),
                                "cpage_modified_by"       =>    $this->session->userdata("user_id") 
                            );    
                $this->db->update("content_pages",$ft,array("cpage_id" => $uri));
                return $this->db->affected_rows();
        }
        public function delete_page($uri){ 
                $ft     =   array(  
                                "cpage_open"      =>    '0',
                                "cpage_status"      =>    '0',
                                "cpage_modified_on"        =>    date("Y-m-d h:i:s"),
                                "cpage_modified_by"        =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("content_pages",$ft,array("cpage_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "cpage_ac_de"       =>    $status,
                            "cpage_modified_on" =>    date("Y-m-d h:i:s"),
                            "cpage_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("content_pages",$ft,array("cpage_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function query_pages($params = array()){
                $dt     =   array(
                                "cp.cpage_open"          =>  "1", 
                                "mp.content_from_open"   =>  "1" 
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                $this->db->select("$sel")
                            ->from('content_pages as cp')
                            ->join('content_from as mp','mp.content_from_id= cp.cpage_content_from',"INNER")
                            ->join('layouts as lp','lp.layout_id =  cp.cpage_layout',"LEFT")
                            ->where($dt); 
                if(array_key_exists("uri",$params)){
                        $this->db->where("cpage_id",$params['uri']);
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(cpage_title LIKE '%".$params['keywords']."%' OR content_from_name LIKE '%".$params['keywords']."%' OR layout_name LIKE '%".$params['keywords']."%')");
                }
                if(array_key_exists("cpage_acde",$params)){
                        $this->db->where("cpage_ac_de",$params['cpage_acde']);
                }
                if(array_key_exists("where_condition",$params)){
                        $this->db->where("(".$params['where_condition'].")");
                }
                if(array_key_exists("order_by_asc",$params)){
                        $this->db->order_by($params['cpage_acde'],"ASC");
                }
                if(array_key_exists("order_by_desc",$params)){
                        $this->db->order_by($params['order_by_desc'],"DESC");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                } 
//                $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function get_pagearray($uir){
            $params['uri']    =   $uir;
            return      $this->query_pages($params)->row_array();
        }
        public function get_pagehere($uir){
            $params['where_condition']    =   "cpage_alias_name LIKE '".$uir."' and cpage_content_from != '1cfrom'";
            return      $this->query_pages($params)->row_array();
        }
        public function getcontentpagehere($uir){
            $params['where_condition']    =   "cpage_alias_name LIKE '".$uir."'";
            return      $this->query_pages($params)->row_array();
        }
        public function get_page($uir){
            $params['uri']    =   $uir;
            return      $this->query_pages($params)->row_array();
        }
}