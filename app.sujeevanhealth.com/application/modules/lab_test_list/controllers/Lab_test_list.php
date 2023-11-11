<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Lab_test_list extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-lab_test_list") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_lab_test_listnametype(){
        $cpsl   =       $this->lab_test_list_model->unique_id_check_lab_test_list();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function lab_test_listnametype(){
        $vsp	=	$this->lab_test_list_model->unique_id_check_lab_test_list();
        if($vsp){
                $this->form_validation->set_message("lab_test_listnametype","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Lab Test List",
                "vtil"      =>  "",
                "content"   =>  "lab_test_list"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("lab_test_listnametype","Lab Test List Name ","required|callback_lab_test_listnametype");
                $this->form_validation->set_rules("lab_test_price","Lab Test Price ","required");
                if($this->form_validation->run()){
                    $ins    = $this->lab_test_list_model->create_lab_test_list();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Lab Test List Successfully.");
                        redirect(sitedata("site_admin")."/Lab-Test-List");
                    }else{
                        $this->session->set_flashdata("err","Not Created Lab Test List.Please try again");
                        redirect(sitedata("site_admin")."/Lab-Test-List");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"lab_test_listid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Lab_test_list";
        $dta["urlvalue"]  =   adminurl("viewLab-Test-List/");
        $this->load->view("inner_template",$dta);
    }
    public function viewlab_test_list(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Lab_test_list";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"lab_test_listid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->lab_test_list_model->cntviewLab_test_list($conditions);  
            $config['base_url']     =   adminurl('viewLab-Test-List');
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
        $dta["urlvalue"]           	=   adminurl('viewLab-Test-List/');
        $dta["view"]               	=   $view	=	$this->lab_test_list_model->viewLab_test_list($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewLab-Test-List/");
        $this->load->view("ajax_lab_test_list",$dta);
    }
    public function update_lab_test_list(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Lab Test List ",
                         "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Lab-Test-List")."'>Lab Test List</a></li>",
                        "content"	=>	"update_lab_test_list"
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("lab_test_listnametype","Lab Test List Name ","required");
            $this->form_validation->set_rules("lab_test_price","Lab Test Price ","required");
            if($this->form_validation->run()){
                $ins    = $this->lab_test_list_model->update_lab_test_list($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Lab Test List Successfully.");
                    redirect(sitedata("site_admin")."/Lab-Test-List");
                }else{
                    $this->session->set_flashdata("err","Not Updated Lab Test List.Please try again");
                    redirect(sitedata("site_admin")."/Lab-Test-List");
                }
            }                        
        }
        $conditions     =   array();
        $conditions["whereCondition"]   =   "lab_test_list_id = '".$uri."'";
        $data['view']	=	$this->lab_test_list_model->getLab_test_list($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_lab_test_list(){
        $vsp    =   "0";
        if($this->session->userdata("delete-lab_test_list") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "lab_test_list_id = '".$uri."'";
		    $vue    =   $this->lab_test_list_model->getLab_test_list($params);
            if(count($vue) > 0){
                $bt     =   $this->lab_test_list_model->delete_lab_test_list($uri); 
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
        if($this->session->userdata("active-deactive-lab_test_list") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "lab_test_list_id = '".$uri."'";
		    $vue    =   $this->lab_test_list_model->getLab_test_list($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->lab_test_list_model->activedeactive($uri,$status); 
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