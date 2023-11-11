<?php
class Specialization extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-specialization") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_specialization_name(){
       
        $cpsl   =       $this->specialization_model->unique_id_check_specialization();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function specialization_name(){
        $vsp	=	$this->specialization_model->unique_id_check_specialization();
        if($vsp){
                $this->form_validation->set_message("specialization_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Specializations",
                "vtil"      =>  "",
                "til"       =>  "Create Specialization",
                "content"   =>  "specialization"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("specialization_name","Specialization Name","required|callback_specialization_name");
                if($this->form_validation->run()){
                    $ins    = $this->specialization_model->create_specialization();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Specialization Successfully.");
                        redirect(sitedata("site_admin")."/Specialization");
                    }else{
                        $this->session->set_flashdata("err","Not Created Specialization.Please try again");
                        redirect(sitedata("site_admin")."/Specialization");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"specializationid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
      	$dta["vslp"]	  =		'1';
        $dta["pageurl"]   =   $pageurl    =   "CareSpecializations";
        $dta["urlvalue"]  =   adminurl("viewSpecialization/");
        $this->load->view("inner_template",$dta);
    }
    public function viewSpecialization(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CareSpecializations";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"specializationid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->specialization_model->cntviewSpecialization($conditions);  
            $config['base_url']     =   adminurl('viewSpecialization');
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
        $dta["urlvalue"]           	=   adminurl('viewSpecialization/');
        $dta["view"]               	=   $view	=	$this->specialization_model->viewSpecialization($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]        =   adminurl("viewSpecialization/");
        $this->load->view("ajax_specialization",$dta);
    }
    public function update_specialization(){
      	if($this->session->userdata("update-specialization") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "specialization_id = '".$uri."'";
        $view	=	$this->specialization_model->getSpecialization($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  = array(
                            "til"		=>	"Update Specialization",
                            "view"		=>	$view,
                            "title"		=>	"Update Specializations",
                            "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Specialization")."'>Home Care Specializations</a></li>",
                            "content"	=>	"create_specialization",
                            "specialization_id" => $uri,
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("specialization_name","Specialization Name","required");
              	$this->form_validation->set_rules("specialization_order","Order","required");
              	
                if($this->form_validation->run()){
                    $ins    = $this->specialization_model->update_specialization($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Specialization Successfully.");
                        redirect(sitedata("site_admin")."/Specialization");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Specialization.Please try again");
                        redirect(sitedata("site_admin")."/Specialization");
                    }
                }                        
            }
            $this->load->view("inner_template",$data); 
        }else{
            $this->session->set_flashdata("war","Not Updated Specializations.Please try again");
            redirect(sitedata("site_admin")."/Specialization");
        }
    }
    public function  delete_specialization(){
        $vsp    =   "0";
        if($this->session->userdata("delete-specialization") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "specialization_id = '".$uri."'";
		    $vue    =   $this->specialization_model->getSpecialization($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->specialization_model->delete_specialization($uri); 
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
        if($this->session->userdata("active-deactive-specialization") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "specialization_id = '".$uri."'";
            $vue    =   $this->specialization_model->getSpecialization($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->specialization_model->activedeactive($uri,$status); 
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