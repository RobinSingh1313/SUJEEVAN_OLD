<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sub_health extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-health-sub-category") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    } 
    public function unique_category_name(){
        $cpsl   =       $this->health_category_model->unique_id_check_subcategory();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function category_name(){
        $vsp	=	$this->health_category_model->unique_id_check_subcategory();
        if($vsp){
                $this->form_validation->set_message("subcategory_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Health Sub Category",
                "vtil"      =>  "",
                "content"   =>  "sub_category"
        );
        
        if($this->input->post("submit")){
                $this->form_validation->set_rules("subcategory_name","Sub Category Name","required|callback_category_name|trim");
                $this->form_validation->set_rules("module","Module","required");
                $this->form_validation->set_rules("healthcategory","Health Category","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_category_model->createsubcategory();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Health Sub Category Successfully.");
                        redirect(sitedata("site_admin")."/Health-Sub-Category");
                    }else{
                        $this->session->set_flashdata("err","Not Created  Health Sub Category.Please try again");
                        redirect(sitedata("site_admin")."/Health-Sub-Category");
                    }
            }                        
        }
        $conditions     =   array();
        $dta['module']	=	$this->common_model->viewModules($conditions);
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"healthcategoryid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "SubHealthCategory";
        $dta["urlvalue"]  =   adminurl("viewsubCategoryHealth/");
        $this->load->view("inner_template",$dta);
    }
    public function viewsubCategoryHealth(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "SubHealthCategory";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"healthcategoryid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->health_category_model->cntviewsubCategory($conditions);  
            $config['base_url']     =   adminurl('viewsubCategoryHealth');
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
        $dta["urlvalue"]           	=   adminurl('viewsubCategoryHealth/');
        $dta["view"]               	=   $view	=	$this->health_category_model->viewsubCategory($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewsubCategoryHealth/");
        $this->load->view("ajax_sub",$dta);
    }
    public function update_category(){
        if($this->session->userdata("update-health-sub-category") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri    =   $this->uri->segment('3');
        $conditions["whereCondition"]   =   "healthsubcategory_id = '".$uri."'";
        $vew	=	$this->health_category_model->getsubCategory($conditions);
        if(is_array($vew) && count($vew) > 0){
            $data  = array(
                            "title"		=>	"Update Health Sub Category",
                            "view"      =>  $vew,
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Health-Sub-Category")."'>Health Sub Category</a></li>",
                            "content"	=>	"update_sub"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("subcategory_name","Sub Category Name","required|callback_category_name|trim");
                $this->form_validation->set_rules("module","Module","required");
                $this->form_validation->set_rules("healthcategory","Health Category","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_category_model->update_subcategory($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated  Health Sub  Category Successfully.");
                        redirect(sitedata("site_admin")."/Health-Sub-Category");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Health Sub Category.Please try again");
                        redirect(sitedata("site_admin")."/Health-Sub-Category");
                    }
                }                        
            }
            $conditions     =   array();
            $data['module']	=	$this->common_model->viewModules($conditions);
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Health Sub Category does not exists.");
            redirect(sitedata("site_admin")."/Health-Sub-Category");
        }
    }
    public function  delete_category(){
        $vsp    =   "0";
        if($this->session->userdata("delete-health-sub-category") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "healthcategory_id = '".$uri."'";
		    $vue    =   $this->health_category_model->getsubCategory($params);
            if(count($vue) > 0){
                $bt     =   $this->health_category_model->delete_subcategory($uri); 
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
        if($this->session->userdata("active-deactive-health-sub-category") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "healthcategory_id = '".$uri."'";
		    $vue    =   $this->health_category_model->getsubCategory($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->health_category_model->activedeactive($uri,$status); 
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