<?php
class Hometests extends CI_Controller{
  	public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-homecare-tests") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_test_name(){
        $cpsl   =       $this->hometest_model->unique_id_check_hometest();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function test_name(){
        $vsp	=	$this->hometest_model->unique_id_check_hometest();
        if($vsp){
                $this->form_validation->set_message("test_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Home Care Tests",
                "vtil"      =>  "",
                "til"       =>  "Create Home Care Test",
                "content"   =>  "homecaretest"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("test_name","Test Name","required|callback_test_name");
              	$this->form_validation->set_rules("actual_price","Actual Price","required");
              	$this->form_validation->set_rules("offer_price","Offer Price","required");
                if($this->form_validation->run()){
                    $ins    = $this->hometest_model->create_hometest();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Test Successfully.");
                        redirect(sitedata("site_admin")."/Homecare-Tests");
                    }else{
                        $this->session->set_flashdata("err","Not Created Test.Please try again");
                        redirect(sitedata("site_admin")."/Homecare-Tests");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"homecaretestid";  
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
        $dta["pageurl"]   =   $pageurl    =   "CareTests";
        $dta["urlvalue"]  =   adminurl("viewHomecaretests/");
        $this->load->view("inner_template",$dta);
    }
    public function viewHomecaretests(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CareTests";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"homecaretestid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->hometest_model->cntviewTest($conditions);  
            $config['base_url']     =   adminurl('viewHomecaretests');
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
        $dta["urlvalue"]           	=   adminurl('viewHomecaretests/');
        $dta["view"]               	=   $view	=	$this->hometest_model->viewTest($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewHomecaretests/");
        $this->load->view("ajax_hometest",$dta);
    }
    public function update_caretests(){
      	if($this->session->userdata("update-homecare-tests") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "homecaretest_id = '".$uri."'";
        $view	=	$this->hometest_model->getTest($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  = array(
              				"til"		=>	"Update Home Care Test",
              				"view"		=>	$view,
                            "title"		=>	"Update Home Care Tests",
                             "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Homecare-Tests")."'>Home Care Tests</a></li>",
                            "content"	=>	"create_hometest"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("test_name","Test Name","required");
              	$this->form_validation->set_rules("actual_price","Actual Price","required");
              	$this->form_validation->set_rules("offer_price","Offer Price","required");
                if($this->form_validation->run()){
                    $ins    = $this->hometest_model->update_hometest($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Home Care Test Successfully.");
                        redirect(sitedata("site_admin")."/Homecare-Tests");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Home Care Test.Please try again");
                        redirect(sitedata("site_admin")."/Homecare-Tests");
                    }
                }                        
            }
            $this->load->view("inner_template",$data); 
        }else{
            $this->session->set_flashdata("war","Not Updated Home Care Tests.Please try again");
            redirect(sitedata("site_admin")."/Homecare-Tests");
        }
    }
    public function  delete_caretests(){
        $vsp    =   "0";
        if($this->session->userdata("delete-homecare-tests") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "homecaretest_id = '".$uri."'";
		    $vue    =   $this->hometest_model->getTest($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->hometest_model->delete_hometest($uri); 
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
        if($this->session->userdata("active-deactive-homecare-tests") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "homecaretest_id = '".$uri."'";
		    $vue    =   $this->hometest_model->getTest($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->hometest_model->activedeactive($uri,$status); 
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