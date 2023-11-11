<?php
class Doctor extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-doctor") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_doctor_name(){
        $cpsl   =       $this->doctor_model->unique_id_check_doctor();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function doctor_name(){
        $vsp	=	$this->doctor_model->unique_id_check_doctor($this->uri->segment("3"));
        if($vsp){
                $this->form_validation->set_message("doctor_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Doctor",
                "vtil"      =>  "",
                "til"       =>  "Create Doctor",
                "content"   =>  "doctor/doctor"
        );
        if($this->input->post("submit")){
            // echo '<pre>';print_r($this->input->post());exit;
            $this->form_validation->set_rules("doctor_name","Doctor Name","required|callback_doctor_name");
            $this->form_validation->set_rules("doctor_experience","Doctor Experience","required");
            $this->form_validation->set_rules("doctor_specialization","Doctor Specialization","required");
            $this->form_validation->set_rules("doctor_education","Doctor Education","required");
            $this->form_validation->set_rules("doctor_language","Doctor Language","required");
            $this->form_validation->set_rules("user_name","User Name","required|xss_clean|trim|min_length[3]|max_length[50]|callback_check_user_name");
            $this->form_validation->set_rules("email","Email","required|callback_check_email");
            $this->form_validation->set_rules("password","Password","required");
            if($this->form_validation->run()){
                $ins    = $this->doctor_model->create_doctor();
                if($ins){
                    $this->session->set_flashdata("suc","Created Doctor Successfully.");
                    redirect(sitedata("site_admin")."/Doctor");
                }else{
                    $this->session->set_flashdata("err","Not Created Doctor.Please try again");
                    redirect(sitedata("site_admin")."/Doctor");
                }
            }else{
                $this->session->set_flashdata("err",validation_errors());
                    redirect(sitedata("site_admin")."/Doctor");
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"doctorid";  
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
        $dta["pageurl"]   =   $pageurl    =   "CareDoctor";
        $dta["urlvalue"]  =   adminurl("viewDoctor/");
        $this->load->view("inner_template",$dta);
    }
    public function check_user_name($str){ 
            $vsp	=	$this->users_model->check_unique_user($str); 
            if($vsp){
                    $this->form_validation->set_message("check_user_name","User Name already exists.");
                    return FALSE;
            }	
            return TRUE; 
    }
    public function check_email($str){ 
            $vsp	=	$this->users_model->check_email($str); 
            if($vsp){
                    $this->form_validation->set_message("check_email","Email already exists.");
                    return FALSE;
            }	
            return TRUE; 
    }
    public function viewDoctor(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CareDoctor";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"doctorid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->doctor_model->cntviewDoctor($conditions);  
            $config['base_url']     =   adminurl('viewDoctor');
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
        $dta["urlvalue"]           	=   adminurl('viewDoctor/');
        $dta["view"]               	=   $view	=	$this->doctor_model->viewDoctor($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]        =   adminurl("viewDoctor/");
        $this->load->view("doctor/ajax_doctor",$dta);
    }
    public function update_doctor(){
      	if($this->session->userdata("update-doctor") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "doctor_id = '".$uri."'";
        $view	=	$this->doctor_model->getDoctor($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  = array(
                            "til"		=>	"Update Doctor",
                            "view"		=>	$view,
                            "title"		=>	"Update Doctor",
                            "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Doctor")."'>Doctor</a></li>",
                            "content"	=>	"doctor/create_doctor"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("doctor_name","Doctor Name","required|callback_doctor_name");
                $this->form_validation->set_rules("doctor_experience","Doctor Experience","required");
                $this->form_validation->set_rules("doctor_specialization","Doctor Specialization","required");
                $this->form_validation->set_rules("doctor_education","Doctor Education","required");
                $this->form_validation->set_rules("doctor_language","Doctor Language","required");
                $this->form_validation->set_rules("user_name","User Name","required");
                $this->form_validation->set_rules("email","Email","required");
                $this->form_validation->set_rules("password","Password","required");
                if($this->form_validation->run()){
                    $ins    = $this->doctor_model->update_doctor($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Doctor Successfully.");
                        redirect(sitedata("site_admin")."/Doctor");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Doctor.Please try again");
                        redirect(sitedata("site_admin")."/Doctor");
                    }
                }                        
            }
            $this->load->view("inner_template",$data); 
        }else{
            $this->session->set_flashdata("war","Not Updated Doctor.Please try again");
            redirect(sitedata("site_admin")."/Doctor");
        }
    }
    public function  delete_doctor(){
        $vsp    =   "0";
        if($this->session->userdata("delete-doctor") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "doctor_id = '".$uri."'";
		    $vue    =   $this->doctor_model->getDoctor($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->doctor_model->delete_doctor($uri); 
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
        if($this->session->userdata("active-deactive-doctor") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "doctor_id = '".$uri."'";
            $vue    =   $this->doctor_model->getDoctor($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->doctor_model->activedeactive($uri,$status); 
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