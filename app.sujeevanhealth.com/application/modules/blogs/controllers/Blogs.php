<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Blogs extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-blogs") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function create_blog(){
                $data  = array(
                                "title"		=>	"Create Blog ",
                             	"vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Blogs")."'>Blogs</a></li>",
                                "content"	=>	"create_blog"
                );
                if($this->input->post("submit")){
                        $this->form_validation->set_rules("blog_title","Blog Title","required");
                        $this->form_validation->set_rules("blog_description","Blog Description","required");
                        $this->form_validation->set_rules("module","module","required");
                        $this->form_validation->set_rules("regvendor_id","Name","required");
                        if($this->form_validation->run()){
                            $ins    = $this->blog_model->create_blog();
                            if($ins){
                                $this->session->set_flashdata("suc","Created Blog Successfully.");
                                redirect(sitedata("site_admin")."/Blogs");
                            }else{
                                $this->session->set_flashdata("err","Not Created Blog.Please try again");
                                redirect(sitedata("site_admin")."/Blogs");
                            }
                    }                        
                }
          		$citions["whereCondition"]	=	"submodule_isblog = 1";
                $data['module']	=	$this->sub_module_model->viewSub_module($citions);
                $vendorconditions["columns"]     =   "regvendor_id,regvendor_name";
                $data['RegVendor']  =   $this->vendor_registration_model->viewRegistration($vendorconditions);
                $data['video_type']	=	$this->video_type_model->viewVideo_type();
                $this->load->view("inner_template",$data);
        }
        public function index(){
                $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Blogs",
                        "vtil"      =>  "",
                        "content"   =>  "blogs"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"blogid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "Blogs";
                $dta["urlvalue"]  =   adminurl("viewBlog/");
                $this->load->view("inner_template",$dta);
        }
        public function viewBlog(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "Blogs";
                $dta["offset"]    =   $offset;
                $keywords       =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"blogid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->blog_model->cntviewBlogs($conditions);  
                    $config['base_url']     =   adminurl('viewBlog');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                    $conditions['start']    =   $offset;
                    $conditions['limit']    =   $perpage;
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =   $conditions['order_by']   =   $orderby;
                        $dta['tipoOrderby']    =   $conditions['tipoOrderby']   =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewBlog/');
                $dta["view"]               	=   $view	=	$this->blog_model->viewBlogs($conditions) ;
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $dta["urlvalue"]    =   adminurl("viewBlog/");
                $this->load->view("ajax_blogs",$dta);
        }
        public function update_blog(){
            if($this->session->userdata("update-blog") != '1'){
                redirect(sitedata("site_admin")."/Dashboard");
            }
            $uri    =   $this->uri->segment('3');
            $conditions["whereCondition"]   =   "blog_id = '".$uri."'";
            $view	=	$this->blog_model->getBlogs($conditions);
            if(is_array($view) && count($view)  > 0){
                $data  =    array(
                                "title"     =>	"Update Blog ",
                                "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Blogs")."'>Blogs</a></li>",
                                "content"   =>	"update_blog",
                                "view"      =>  $view,
                            );
                if($this->input->post("submit")){
                    $this->form_validation->set_rules("blog_title","Blog Title","required");
                    $this->form_validation->set_rules("blog_description","Blog Description","required");
                    $this->form_validation->set_rules("module","module","required");
                    $this->form_validation->set_rules("regvendor_id","Name","required");
                    if($this->form_validation->run()){
                        $ins    = $this->blog_model->update_blog($uri);
                        if($ins){
                            $this->session->set_flashdata("suc","Updated Blog Successfully.");
                            redirect(sitedata("site_admin")."/Blogs");
                        }else{
                            $this->session->set_flashdata("err","Not Updated Blog.Please try again");
                            redirect(sitedata("site_admin")."/Blogs");
                        }
                    }                        
                }
                $regconditions["columns"]     =   "regvendor_id,regvendor_name";
                $citions["whereCondition"]	=	"submodule_isblog = 1";
                $data['module']         =	$this->sub_module_model->viewSub_module($citions);
                //print_r($data['module']);exit;
                $data["RegVendor"]              =   $this->vendor_registration_model->viewRegistration($regconditions);
                $data['video_type']	=	$this->video_type_model->viewVideo_type();
                $this->load->view("inner_template",$data);
            }else{
                $this->session->set_flashdata("war","Blog does not exists.");
                redirect(sitedata("site_admin")."/Blogs");
            }
    	}
        public function  delete_blog(){
                $vsp    =   "0";
                if($this->session->userdata("delete-blog") != '1'){
                    $vsp    =   "0";
                }else {
                    $uri    =   $this->uri->segment("3");
                    $params["whereCondition"]   =   "blog_id = '".$uri."'";
			        $vue    =   $this->blog_model->getBlogs($params);
                    if(count($vue) > 0){
                        $bt     =   $this->blog_model->delete_blog($uri); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function activedeactive(){
                $vsp    =   "0";
                if($this->session->userdata("active-deactive-blog") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields");
                    $params["whereCondition"]   =   "blog_id = '".$uri."'";
			        $vue    =   $this->blog_model->getBlogs($params);
                    if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->blog_model->activedeactive($uri,$status); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function ajax_options(){
            $conditions     =   array();
            $data['video_type']	=	$this->video_type_model->viewVideo_type($conditions);
            $this->load->view("ajax_options",$data);
        }
        public function __destruct() {
                $this->db->close();
        }
}