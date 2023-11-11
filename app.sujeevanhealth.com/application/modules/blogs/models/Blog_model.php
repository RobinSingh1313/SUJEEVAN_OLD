<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Blog_model extends CI_Model{
        public function create_blog(){
                $data = array(
                        'blog_description'              =>  ($this->input->post('blog_description'))??'',
                        'blog_alias_name'               =>  $this->common_config->cleanstr($this->input->post('blog_title')),
                        'blog_title'                    =>  ucfirst($this->input->post('blog_title')),
                        'blog_seo_keywords'             =>  ($this->input->post('keywords'))??'',
                        'blog_seo_description'          =>  ($this->input->post('seo_description'))??'',
                        'blog_module_id'                =>  $this->input->post('module'),
                        "blog_created_on"               =>  date("Y-m-d h:i:s"),
                        "blog_created_by"               =>  $this->input->post('regvendor_id'),
                        "blog_modified_by"              =>  $this->input->post('regvendor_id'),
                        "blog_type"                     =>  ($this->input->post('blog_type'))??''
                );
                $this->db->insert("blogs",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                            $target_dir     =   $this->config->item("upload_dest");
                            $direct         =   $target_dir."/blog";
                            if (file_exists($direct)){
                            }else{mkdir($target_dir."/blog");}
                            $tmpFilePath = $_FILES['blog_image']['tmp_name'];
                            if ($tmpFilePath != ""){    
                                $newFilePath = $direct."/".$_FILES['blog_image']['name'];
                                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                    $blog_image = $_FILES['blog_image']['name'];
                                }
                             }
                        $dat    =   array("blog_id    "=> $vsp."BLG");	
                        $dat['blog_image'] = ($blog_image)??'';
                        $id     =   $vsp;	
                        $this->db->update("blogs",$dat,array("blogid" => $vsp));
                        /*$total = count($_FILES['blog_image']['name']);
                        for( $i=0 ; $i < $total ; $i++ ) {
                            
                        } 
                  		$videourl	=	$this->input->post("videourl");
                  		$videotypes	=	$this->input->post("videotypes");
                  		if(is_array($videourl) && count($videourl) > 0){
                            foreach($videourl as $key	=>	$v) {   
                                $data = array(
                                    'blog_video_path'         => $v,
                                    'blog_video_type'         => $videotypes[$key],
                                    "blog_video_created_on"           => date("Y-m-d H:i:s"),
                                    "blog_video_created_by"           => $this->session->userdata("login_id")
                                 );
                                 $this->db->insert("blog_video",$data);
                                 $vsp   =    $this->db->insert_id();
                                 if($vsp > 0){
                                    $dat=array(
                                         "blog_video_id" 				=> $vsp."BLGI",
                                         "blog_video_blog_id" 			=> $id."BLG"
                                    );		
                                    $this->db->update("blog_video",$dat,"blog_videoid ='".$vsp."'");

                                 }
                            }
                        }*/
                        return true;     
                }
                return false;
        }
        public function update_blog($uri){
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/blog";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/blog");}
            $tmpFilePath = $_FILES['blog_image']['tmp_name'];
            if ($tmpFilePath != ""){    
                $newFilePath = $direct."/".$_FILES['blog_image']['name'];
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $blog_image = $_FILES['blog_image']['name'];
                }
            }
            
            $data = array(
                'blog_description'              =>  ($this->input->post('blog_description'))??'',
                'blog_alias_name'               =>  $this->common_config->cleanstr($this->input->post('blog_title')),
                'blog_title'                    =>  ucfirst($this->input->post('blog_title')),
                'blog_seo_keywords'             =>  ($this->input->post('keywords'))??'',
                'blog_seo_description'          =>  ($this->input->post('seo_description'))??'',
                'blog_module_id'                =>  $this->input->post('module'),
                "blog_modified_on"              =>  date("Y-m-d h:i:s"),
                "blog_modified_by"              =>  $this->input->post('regvendor_id'),
                "blog_type"                     =>  ($this->input->post('blog_type'))??''
            );
            if($blog_image!=''){
                $data['blog_image'] =   $blog_image;
            }
            $this->db->update("blogs",$data,array("blog_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function cntviewBlogs($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryBlogs($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewBlogs($params = array()){
            return $this->queryBlogs($params)->result_array();
        }
        public function getBlogs($params = array()){
            return $this->queryBlogs($params)->row_array();
        }
        public function getBlogView($params = array()){
            return $this->queryBlogView($params)->row_array();
        }
        public function delete_blog($uro,$vpsl = ''){
                $dta    =   array(
                    "blog_open"            =>  0, 
                    "blog_modified_on" =>    date("Y-m-d h:i:s"),
                    "blog_modified_by" =>    ($this->session->userdata("login_id") != "")?$this->session->userdata("login_id"):$vpsl 
                );
                $this->db->update("blogs",$dta,array("blog_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "blog_acde"       =>    $status,
                            "blog_modified_on" =>    date("Y-m-d h:i:s"),
                            "blog_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("blogs",$ft,array("blog_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryBlogs($params = array()){
                 $dt     =   array(
                                "blog_open"         =>  "1",
                                "blog_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('blogs as b')
                            ->join('sub_module as c',"c.sub_module_id  = b.blog_module_id and sub_module_open = 1 and sub_module_status = 1","left")
                            ->join('modules as m','m.moduleid = c.sub_module_module_id and m.module_open = 1 and module_status = 1','left')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(blog_title LIKE '%".$params["keywords"]."%' or sub_module_name like '%".$params["keywords"]."%' or blog_description like '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR blog_acde = '".$params["keywords"]."'  )");
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
         public function mostViewed($oar =array()){
            array_multisort(
                array_column($oar, 'blog_count'),SORT_DESC,
                $oar
            );
            return $oar;
        }
         public function viewBlogList($params = array()){
            $data =array();
            $target_dir                     =   base_url().$this->config->item("upload_dest")."modules/";
            $res = $this->viewBlogs($params);
            if(is_array($res) && count($res) > 0){
                $i=0;
                $this->db->query('SET sql_mode = ""');
                foreach($res as $ve){
                    
                    $con='0';
                    $r = $this->db->query("SELECT `id` FROM `blog_views` WHERE `blog_blog_id` ='".$ve['blog_id']."' GROUP by `user_id`")->result();
                    $likesCount = $this->db->query("SELECT count(likesid) as likes FROM `blog_likes` WHERE `blog_id` ='".$ve['blog_id']."' AND status = '1'")->row_array();
                    if(is_array($r) && count($r) >0){
                        $con = count($r);
                    }
                    $vol            =   $ve["blog_created_by"];
                    $vplcr          =   $this->api_model->getProfile($vol);
                    $vplcr_v          =   $this->api2_model->getProfile($vol,'regvendor_name');
                    //print_r($vplcr);exit;
                    $vtimerc        =   (is_array($vplcr_v) && count($vplcr_v) > 0)?$vplcr_v["regvendor_name"]:"";
                    $view_condition['cnt'] = "";
                    $view_condition['whereCondition'] = "(blog_blog_id='".$ve['blog_id']."')";
                    $blog_view_count = $this->blog_model->getBlogView($view_condition);
                    $blog_image =   base_url().$this->config->item("upload_dest")."blog/";
                    $vtimer         =   date("d-m-y",strtotime($ve["blog_created_on"]));
                    $likes_status = $this->api_model->blog_likes_count($ve['blogid'],($vplcr['registration_id'])??'');
                    $lsp    =   $this->db->select("concat('".$blog_image."',blog_image_path) as  blog_image_path")->get_where("blog_image",array("blog_image_blog_id" => $ve['blog_id']))->row_array();
                    $data[$i]['blog_id'] = $ve['blog_id'];
                    $data[$i]['blog_title'] = $ve['blog_title'];
                    $data[$i]['blog_alias_name'] = $ve['blog_alias_name'];
                    $data[$i]['module_id'] = ($ve['blog_module_id'])??'';
                    $data[$i]['module_name'] = $ve['module_name'];
                    $data[$i]['blog_description'] = $ve['blog_description'];
                    $data[$i]["blog_images"]       =   is_array($lsp)?$lsp["blog_image_path"]:"";
                    $data[$i]["blog_image"]       =   (array_key_exists("blog_image",$ve) && $ve['blog_image']!='')?$blog_image.$ve['blog_image']:'';
                    $data[$i]["blog_created_on"]   =   $vtimer;
                    $data[$i]["blog_created_time"]   =   date("H:i",strtotime($ve["blog_created_on"]));
                    $data[$i]["blog_created_by"]   =   ucwords($vtimerc);
                    $data[$i]["view_count"]   =   $blog_view_count['cnt'];     
                    $data[$i]["likes"]   =   ($likesCount['likes'])??0;       
                    $data[$i]['blog_count'] = (string)$con;                    
                    $i++;
                }
            }
            return $data;
         }
          public function queryBlogView($params = array()){
                
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('blog_views as b');
                
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                
//                $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function create_blog_view($user_id,$blog_id){
                $data = array(
                        'user_id'              => $user_id,
                        'blog_blog_id'              => $blog_id,
                        "created_at"           =>  date("Y-m-d h:i:s"),
                       
                );
                $insert = $this->db->insert("blog_views",$data);
                if($insert)
                {
                   return true;
                }

                return false;
        }
}