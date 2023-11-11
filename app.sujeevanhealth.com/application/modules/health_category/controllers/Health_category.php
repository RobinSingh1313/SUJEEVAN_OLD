<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Health_category extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-health-category") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        else if($this->session->userdata("manage-specialization") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    } 
    public function unique_category_name(){
        $cpsl   =       $this->health_category_model->unique_id_check_category();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function category_name(){
        $vsp	=	$this->health_category_model->unique_id_check_category();
        if($vsp){
                $this->form_validation->set_message("category_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Health Category",
                "vtil"      =>  "",
                "content"   =>  "category"
        );
        
        if($this->input->post("submit")){
                $this->form_validation->set_rules("category_name","Category Name","required|callback_category_name|trim");
                $this->form_validation->set_rules("module","Module","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_category_model->create_category();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Category Successfully.");
                        redirect(sitedata("site_admin")."/Health-Category");
                    }else{
                        $this->session->set_flashdata("err","Not Created Category.Please try again");
                        redirect(sitedata("site_admin")."/Health-Category");
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
        $dta["pageurl"]   =   $pageurl    =   "Category";
        $dta["urlvalue"]  =   adminurl("viewCategoryHealth/");
        $this->load->view("inner_template",$dta);
    }
    public function assignspecialization(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Assign Specialization",
                "vtil"      =>  "",
                "content"   =>  "assign_specialization"
        );
        
        if($this->input->post("submit")){
                $this->form_validation->set_rules("specialization","Specialization Name","required");
                $this->form_validation->set_rules("health_category","Health Category","required");
                $this->form_validation->set_rules("health_sub_category","Health Sub Category","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_category_model->create_assign_specialization();
                    if($ins){
                        $this->session->set_flashdata("suc","Created  Successfully.");
                        redirect(sitedata("site_admin")."/Health-Specialization-Assign");
                    }else{
                        $this->session->set_flashdata("err","Not Created.Please try again");
                        redirect(sitedata("site_admin")."/Health-Specialization-Assign");
                    }
            }                        
        }
        $conditions     =   array();
        $dta['Specialization']  =   $this->common_model->specializationList();
        $dta['HealthCategory']  =   $this->common_model->healthCategoryList();
        $dta['HealthSubCategory']  =   $this->common_model->healthSubCategoryList();
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
        $dta["pageurl"]   =   $pageurl    =   "Specialization";
        $dta["urlvalue"]  =   adminurl("assignHealthSpecialization/");
        $this->load->view("inner_template",$dta);
    }
    public function assignHealthSpecialization(){
       
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Specialization";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        } 
        $conditions['columns'] = "id,specialization_name,healthcategory_name,healthsubcategory_name"; 
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"id";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->health_category_model->cntviewCategory($conditions);  
            $config['base_url']     =   adminurl('viewCategoryHealth');
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
        $dta["limit"]               =   (int)$offset+1;
        $dta["urlvalue"]            =   adminurl('assignHealthSpecialization/');
        $dta["view"]                =   $view   =   $this->health_category_model->viewAssignSpecialization($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("assignHealthSpecialization/");
        $this->load->view("ajax_assign_specialization",$dta);
    }
    public function viewCategoryHealth(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Category";
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
            $totalRec               =   $this->health_category_model->cntviewCategory($conditions);  
            $config['base_url']     =   adminurl('viewCategoryHealth');
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
        $dta["urlvalue"]           	=   adminurl('viewCategoryHealth/');
        $dta["view"]               	=   $view	=	$this->health_category_model->viewCategory($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewCategoryHealth/");
        $this->load->view("ajax_category",$dta);
    }
    public function update_category(){
        if($this->session->userdata("update-health-category") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri    =   $this->uri->segment('3');
        $conditions["whereCondition"]   =   "healthcategory_id = '".$uri."'";
        $vew	=	$this->health_category_model->getCategory($conditions);
        if(is_array($vew) && count($vew) > 0){
            $data  = array(
                            "title"		=>	"Update Health Category",
                            "view"      =>  $vew,
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Health-Category")."'>Health Category</a></li>",
                            "content"	=>	"update_category"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("category_name","Category Name","required|callback_category_name|trim");
                $this->form_validation->set_rules("module","Module","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_category_model->update_category($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Category Successfully.");
                        redirect(sitedata("site_admin")."/Health-Category");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Category.Please try again");
                        redirect(sitedata("site_admin")."/Health-Category");
                    }
                }                        
            }
            $conditions     =   array();
            $data['module']	=	$this->common_model->viewModules($conditions);
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Health Category does not exists.");
            redirect(sitedata("site_admin")."/Health-Category");
        }
    }
    public function update_assign_specialization(){
        if($this->session->userdata("update-specialization") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri    =   $this->uri->segment('3');
        //print_r($uri);exit;
        //$conditions["whereCondition"]   =   "specialization_id = '".$uri."'";
        $vew    =   $this->health_category_model->getSpecialization($uri);
        $vew_hc    =   $this->health_category_model->getHealthCategory($uri);
        $vew_hsc    =   $this->health_category_model->getHealthSubCategory($uri);
        //print_r($vew["specialization_id"]);exit;
        if(is_array($vew) && count($vew) > 0){
            $data  = array(
                            "title"     =>  "Update Assign Specialization",
                            "view"      =>  $vew,
                            "view_hc"   =>  $vew_hc,
                            "view_hsc"  =>  $vew_hsc,
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Health-Category")."'>Assign Specialization</a></li>",
                            "content"   =>  "update_assign_specialization"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("specialization","Specialization Name","required");
                $this->form_validation->set_rules("health_category","Health Category","required");
                $this->form_validation->set_rules("sub_health_category","Health Sub Category","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_category_model->update_assign_specialization($uri);
                    //print_r($ins);exit;
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Successfully.");
                        redirect(sitedata("site_admin")."/Health-Specialization-Assign");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Category.Please try again");
                        redirect(sitedata("site_admin")."/Health-Specialization-Assign");
                    }
                }                        
            }
            $conditions     =   array();
            $data['Specialization'] =   $this->common_model->specializationList($conditions);
            $data['HealthCategory']  =   $this->common_model->healthCategoryList();
            $data['HealthSubCategory']  =   $this->common_model->healthSubCategoryList();
            //print_r($data['Specialization']);exit;
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Specialization does not exists.");
            redirect(sitedata("site_admin")."/Health-Specialization-Assign");
        }
    }
    public function  delete_category(){
        $vsp    =   "0";
        if($this->session->userdata("delete-health-category") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "healthcategory_id = '".$uri."'";
		    $vue    =   $this->health_category_model->getCategory($params);
            if(count($vue) > 0){
                $bt     =   $this->health_category_model->delete_category($uri); 
                if($bt > 0){
                    $vsp    =   1;
                }
            }else{
                $vsp    =   2;
            } 
        } 
        echo $vsp;
    }
    public function  delete_assign_specialization(){
        $vsp    =   "0";
        if($this->session->userdata("delete-specialization") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            //$params["whereCondition"]   =   "id = '".$uri."'";
            $vue    =   $this->health_category_model->getSpecialization($uri);

            if(count($vue) > 0){
                $bt     =   $this->health_category_model->delete_assign_specialization($uri); 
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
        if($this->session->userdata("active-deactive-health-category") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "healthcategory_id = '".$uri."'";
		    $vue    =   $this->health_category_model->getCategory($params);
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