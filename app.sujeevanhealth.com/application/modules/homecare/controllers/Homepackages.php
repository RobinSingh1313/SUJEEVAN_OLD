<?php
class Homepackages extends CI_Controller{
  	public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-homecare-packages") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_package_name(){
        $cpsl   =       $this->homecare_model->unique_id_check_package();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function package_name(){
        $vsp	=	$this->homecare_model->unique_id_check_package();
        if($vsp){
                $this->form_validation->set_message("package_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Home Care Packages",
                "vtil"      =>  "",
                "til"       =>	"Create Package",
                "content"   =>  "homecare"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("package_name","package Name","required|callback_package_name|trim");
                if($this->form_validation->run()){
                    $ins    = $this->homecare_model->create_package();
                    if($ins){
                        $this->session->set_flashdata("suc","Created package Successfully.");
                        redirect(sitedata("site_admin")."/Homecare-Packages");
                    }else{
                        $this->session->set_flashdata("err","Not Created package.Please try again");
                        redirect(sitedata("site_admin")."/Homecare-Packages");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"packageid";  
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
        $dta["pageurl"]   =   $pageurl    =   "CarePackages";
        $dta["urlvalue"]  =   adminurl("viewHomecarepackages/");
        $this->load->view("inner_template",$dta);
    }
    public function viewHomecarepackages(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CarePackages";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"packageid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->homecare_model->cntviewpackage($conditions);  
            $config['base_url']     =   adminurl('viewHomecarepackages');
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
        $dta["urlvalue"]           	=   adminurl('viewHomecarepackages/');
        $dta["view"]               	=   $view	=	$this->homecare_model->viewpackage($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewHomecarepackages/");
        $this->load->view("ajax_homecare",$dta);
    }
    public function update_carepackages(){
      	if($this->session->userdata("update-homecare-packages") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "package_id = '".$uri."'";
        $view	=	$this->homecare_model->getpackage($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  = array(
                "til"		=>	"Update Package",
                "view"		=>	$view,
                "title"		=>	"Update Home Care Packages",
                "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Homecare-Packages")."'>Home Care Packages</a></li>",
                "content"	=>	"create_homecare"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("package_name","package Name","required|callback_package_name|trim");
                if($this->form_validation->run()){
                    $ins    = $this->homecare_model->update_package($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated package Successfully.");
                        redirect(sitedata("site_admin")."/Homecare-Packages");
                    }else{
                        $this->session->set_flashdata("err","Not Updated package.Please try again");
                        redirect(sitedata("site_admin")."/Homecare-Packages");
                    }
                }                        
            }
            $this->load->view("inner_template",$data); 
        }else{
            $this->session->set_flashdata("war","Not Updated Home Care packages.Please try again");
            redirect(sitedata("site_admin")."/Homecare-Packages");
        }
    }
    public function  delete_carepackages(){
        $vsp    =   "0";
        if($this->session->userdata("delete-homecare-packages") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "package_id = '".$uri."'";
		    $vue    =   $this->homecare_model->getpackage($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->homecare_model->delete_package($uri); 
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
        if($this->session->userdata("active-deactive-homecare-packages") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "package_id = '".$uri."'";
		    $vue    =   $this->homecare_model->getpackage($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->homecare_model->activedeactive($uri,$status); 
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