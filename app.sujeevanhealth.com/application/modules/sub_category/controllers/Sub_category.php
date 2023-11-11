<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sub_category extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-sub-category") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_sub_category(){
        $data  = array(
                        "title"		=>	"Create Sub Category ",
                     	"vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Sub-Category")."'>Sub Category</a></li>",
                        "content"	=>	"create_sub_category"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("sub_category_name","Sub Category Name ","required|callback_sub_category_name");
                $this->form_validation->set_rules("category","Category","required");
                $this->form_validation->set_rules("module","Module","required");
                if($this->form_validation->run()){
                    $ins    = $this->sub_category_model->create_sub_category();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Sub Category Successfully.");
                        redirect(sitedata("site_admin")."/Sub-Category");
                    }else{
                        $this->session->set_flashdata("err","Not Created Sub Category.Please try again");
                        redirect(sitedata("site_admin")."/Sub-Category");
                    }
            }                        
        }
        $conditions     =   array();
        $data['module']	=	$this->common_model->viewModules($conditions);
        $this->load->view("inner_template",$data);
    }
    public function sub_category_name(){
        $vsp	=	$this->sub_category_model->unique_id_check_sub_category();
        if($vsp){
                $this->form_validation->set_message("sub_category_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Sub Category",
                "vtil"      =>  "",
                "content"   =>  "sub_category"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"sub_categoryid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Sub_category";
        $dta["urlvalue"]  =   adminurl("viewSubCategory/");

        $this->load->view("inner_template",$dta);
    }
    public function viewsub_category(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Sub_category";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"sub_categoryid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->sub_category_model->cntviewSub_category($conditions);  
            $config['base_url']     =   adminurl('viewSubCategory');
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
        $dta["urlvalue"]           	=   adminurl('viewSubCategory/');
        $dta["view"]               	=   $view	=	$this->sub_category_model->viewSub_category($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewSubCategory/");
        $this->load->view("ajax_sub_category",$dta);
    }
    public function update_sub_category(){
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "sub_category_id = '".$uri."'";
        $view	=	$this->sub_category_model->getSub_category($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  	= array(
                            "view"		=>	$view,
                            "title"		=>	"Update Sub Category ",
                            "vtil"     =>      "<li class='breadcrumb-item'><a href='". adminurl("Sub-Category")."'>Sub Category</a></li>",
                            "content"	=>	"update_sub_category"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("sub_category_name","Sub_category Name ","required");
                $this->form_validation->set_rules("module","Module","required");
                $this->form_validation->set_rules("category","Category","required");
                if($this->form_validation->run()){
                    $ins    = $this->sub_category_model->update_sub_category($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Sub Category Successfully.");
                        redirect(sitedata("site_admin")."/Sub-Category");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Sub Category.Please try again");
                        redirect(sitedata("site_admin")."/Sub-Category");
                    }
                }                        
            }
            $conditions     =   array();
            $data['module']	=	$this->common_model->viewModules($conditions);
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Sub Category does not exists");
            redirect(sitedata("site_admin")."/Sub-Category");
        }
    }
    public function  delete_sub_category(){
        $vsp    =   "0";
        if($this->session->userdata("delete-sub-category") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "sub_category_id = '".$uri."'";
		    $vue    =   $this->sub_category_model->getSub_category($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->sub_category_model->delete_sub_category($uri); 
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
        if($this->session->userdata("active-deactive-sub-category") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "sub_category_id = '".$uri."'";
		    $vue    =   $this->sub_category_model->getSub_category($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->sub_category_model->activedeactive($uri,$status); 
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