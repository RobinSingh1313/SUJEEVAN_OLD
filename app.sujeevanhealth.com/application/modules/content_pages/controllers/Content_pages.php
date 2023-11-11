<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Content_pages extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-content-pages") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function create_content(){
                $data  = array(
                                "title"		=>	"Pages",
                             	"vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Content-Pages")."'>Content Pages</a></li>",
                                "content"	=>	"create_page",
                                "layouts"       =>      $this->pages_model->get_layouts(),
                                "contentform"   =>      $this->pages_model->get_contentform(),
                                "widgets"       =>      $this->widget_model->get_acwidgets(),
                );
                if($this->input->post("submit")){
                        $this->form_validation->set_rules("page_title","Page Title","required");
                        $this->form_validation->set_rules("cpage_content_from","Content Form","required");
                        if($this->input->post("cpage_content_from") != '1cfrom'){
                                $this->form_validation->set_rules("page_layout","Page Layout","required");
                        }else{
                                $this->form_validation->set_rules("post_url","Post URL","required");
                        } 
                        if($this->form_validation->run()){
                            $ins    = $this->pages_model->create_page();
                            if($ins){
                                $this->session->set_flashdata("suc","Created Page Successfully.");
                                redirect(sitedata("site_admin")."/Content-Pages");
                            }else{
                                $this->session->set_flashdata("err","Not Created Page.Please try again");
                                redirect(sitedata("site_admin")."/Content-Pages");
                            }
                    }                        
                }
                $this->load->view("inner_template",$data);
        }
        public function index(){
                $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Content Pages",
                        "vtil"      =>  "",
                        "content"   =>  "view_pages"
                );
          		$orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"cpageid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "CONTETOAG";
                $dta["urlvalue"]  =   adminurl("viewContent/");
                $this->load->view("inner_template",$dta);
        }
        public function viewContent(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CONTETOAG";
                $dta["offset"]    =   $offset;
                $keywords       =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"cpageid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->pages_model->cntview_contentpages($conditions);  
                    $config['base_url']     =   adminurl('viewContent');
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
                $dta["urlvalue"]           	=   adminurl('viewContent/');
                $conditions["columns"]      =   "cpage_title,content_from_name,layout_name,cpage_show_menu,cpage_ac_de,cpage_id";
                $dta["view"]               	=   $view	=	$this->pages_model->view_contentpages($conditions);
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $dta["urlvalue"]    =   adminurl("viewContent/");
                $this->load->view("ajax_pages",$dta);
        }
        public function update_content_page(){
                if($this->session->userdata("update-content-page") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                } 
                $uri    =   $this->uri->segment("3"); 
                $vue    =   $this->pages_model->get_page($uri);
                if($vue){
                     $data  = array(
                            "title"     =>  "Pages",
                            "content"   =>  "update_pages",
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("View-Content-Pages")."'>All Pages</a></li>",
                            "layouts"       =>      $this->pages_model->get_layouts(),
                            "contentform"   =>      $this->pages_model->get_contentform(),
                            "widgets"       =>      $this->widget_model->get_acwidgets($vue),
                            "view"      =>  $vue
                    );    
                    if($this->input->post("submit")){
                        $this->form_validation->set_rules("page_title","Page Title","required");
                        $this->form_validation->set_rules("cpage_content_from","Content Form","required");
                        if($this->input->post("cpage_content_from") != '1cfrom'){
                                $this->form_validation->set_rules("page_layout","Page Layout","required");
                        }else{
                                $this->form_validation->set_rules("post_url","Post URL","required");
                        } 
                        if($this->form_validation->run() == TRUE){
                                $ins    = $this->pages_model->update_page($uri);
                                if($ins){
                                        $this->session->set_flashdata("suc","Updated page successfully");
                                        redirect(sitedata("site_admin")."/Update-Content-Page/".$uri);
                                }
                                else{
                                        $this->session->set_flashdata("err","Not updated any page successfully");
                                        redirect(sitedata("site_admin")."/Update-Content-Page/".$uri);
                                }
                        }
                    }
                    $this->load->view("inner_template",$data);
                }else{
                        $this->session->set_flashdata("war","Page does not exists."); 
                        redirect(sitedata("site_admin")."/view-content-pages");
                }
        }
        public function  delete_content_page(){
                $vsp    =   "0";
                if($this->session->userdata("delete-content-page") != '1'){
                    $vsp    =   "0";
                }else {
                    $uri    =   $this->uri->segment("3");
                    $vue    =   $this->pages_model->get_page($uri);
                    if(count($vue) > 0){
                        $bt     =   $this->pages_model->delete_page($uri); 
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
                if($this->session->userdata("active-deactive-content-page") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields"); 
                    $vue    =   $this->pages_model->get_page($uri);
                    if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->pages_model->activedeactive($uri,$status); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function __destruct() {
                $this->db->close();
        }
}