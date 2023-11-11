<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Medicine_list extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-medicine_list") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_medicine_listnametype(){
        $cpsl   =       $this->medicine_list_model->unique_id_check_medicine_list();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function medicine_listnametype(){
        $vsp	=	$this->medicine_list_model->unique_id_check_medicine_list();
        if($vsp){
                $this->form_validation->set_message("medicine_listnametype","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Medicine List",
                "vtil"      =>  "",
                "content"   =>  "medicine_list"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("medicine_listnametype","Medicine List Name ","required|callback_medicine_listnametype");
                if($this->form_validation->run()){
                    $ins    = $this->medicine_list_model->create_medicine_list();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Medicine List Successfully.");
                        redirect(sitedata("site_admin")."/Medicine-List");
                    }else{
                        $this->session->set_flashdata("err","Not Created Medicine List.Please try again");
                        redirect(sitedata("site_admin")."/Medicine-List");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"medicine_listid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Medicine_list";
        $dta["urlvalue"]  =   adminurl("viewMedicine-List/");
        $this->load->view("inner_template",$dta);
    }
    public function viewmedicine_list(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Medicine_list";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"medicine_listid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->medicine_list_model->cntviewMedicine_list($conditions);  
            $config['base_url']     =   adminurl('viewMedicine-List');
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
        $dta["urlvalue"]           	=   adminurl('viewMedicine-List/');
        $dta["view"]               	=   $view	=	$this->medicine_list_model->viewMedicine_list($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewMedicine-List/");
        $this->load->view("ajax_medicine_list",$dta);
    }
    public function update_medicine_list(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Medicine List ",
                         "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Medicine-List")."'>Medicine List</a></li>",
                        "content"	=>	"update_medicine_list"
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("medicine_listnametype","Medicine List Name ","required");
            if($this->form_validation->run()){
                $ins    = $this->medicine_list_model->update_medicine_list($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Medicine List Successfully.");
                    redirect(sitedata("site_admin")."/Medicine-List");
                }else{
                    $this->session->set_flashdata("err","Not Updated Medicine List.Please try again");
                    redirect(sitedata("site_admin")."/Medicine-List");
                }
            }                        
        }
        $conditions     =   array();
        $conditions["whereCondition"]   =   "medicine_list_id = '".$uri."'";
        $data['view']	=	$this->medicine_list_model->getMedicine_list($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_medicine_list(){
        $vsp    =   "0";
        if($this->session->userdata("delete-medicine_list") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "medicine_list_id = '".$uri."'";
		    $vue    =   $this->medicine_list_model->getMedicine_list($params);
            if(count($vue) > 0){
                $bt     =   $this->medicine_list_model->delete_medicine_list($uri); 
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
        if($this->session->userdata("active-deactive-medicine_list") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "medicine_list_id = '".$uri."'";
		    $vue    =   $this->medicine_list_model->getMedicine_list($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->medicine_list_model->activedeactive($uri,$status); 
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