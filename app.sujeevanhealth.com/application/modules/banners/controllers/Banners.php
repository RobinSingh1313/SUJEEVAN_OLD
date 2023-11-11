<?php
class Banners extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-banners") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_banner_name(){
        $cpsl   =       $this->banners_model->unique_id_check_banner();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function banner_name(){
        $vsp	=	$this->banners_model->unique_id_check_banner($this->uri->segment("3"));
        if($vsp){
                $this->form_validation->set_message("banner_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $conditionss     =   array("whereCondition" => "module_acde = 'Active'");
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Banner",
                "vtil"      =>  "",
                "til"       =>  "Create Banner",
                "content"   =>  "banner",
                "module"    => $this->common_model->viewModules($conditionss)
        );
        if($this->input->post("submit")){
                // if($this->form_validation->run()){
                    $ins    = $this->banners_model->create_banner();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Banner Successfully.");
                        redirect(sitedata("site_admin")."/Banners");
                    }else{
                        $this->session->set_flashdata("err","Not Created Banner.Please try again");
                        redirect(sitedata("site_admin")."/Banners");
                    }
            // }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"bannerid";  
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
        $dta["pageurl"]   =   $pageurl    =   "CareBanner";
        $dta["urlvalue"]  =   adminurl("viewBanner/");
        $this->load->view("inner_template",$dta);
    }
    public function viewBanner(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CareBanner";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"bannerid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->banners_model->cntviewBanner($conditions);  
            $config['base_url']     =   adminurl('viewBanner');
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
        $dta["urlvalue"]           	=   adminurl('viewBanner/');
        $dta["view"]               	=   $view	=	$this->banners_model->viewBanner($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]        =   adminurl("viewBanner/");
        $this->load->view("ajax_banner",$dta);
    }
    public function update_banner(){
      	if($this->session->userdata("update-banners") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "banner_id = '".$uri."'";
        $view	=	$this->banners_model->getBanner($conditions);
      	if(is_array($view) && count($view) > 0){
            $conditionss     =   array("whereCondition" => "module_acde = 'Active'");
            $data  = array(
                            "til"		=>	"Update Banner",
                            "view"		=>	$view,
                            "title"		=>	"Update Banner",
                            "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Banners")."'>Banner</a></li>",
                            "content"	=>	"create_banner",
                            "module"    => $this->common_model->viewModules($conditionss)
            );
            if($this->input->post("submit")){
                // if($this->form_validation->run()){
                    $ins    = $this->banners_model->update_banner($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Banner Successfully.");
                        redirect(sitedata("site_admin")."/Banners");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Banner.Please try again");
                        redirect(sitedata("site_admin")."/Banners");
                    }
                // }                        
            }
            $this->load->view("inner_template",$data); 
        }else{
            $this->session->set_flashdata("war","Not Updated Banner.Please try again");
            redirect(sitedata("site_admin")."/Banners");
        }
    }
    public function  delete_banner(){
        $vsp    =   "0";
        if($this->session->userdata("delete-banners") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "banner_id = '".$uri."'";
		    $vue    =   $this->banners_model->getBanner($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->banners_model->delete_banner($uri); 
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
        if($this->session->userdata("active-deactive-banners") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "banner_id = '".$uri."'";
            $vue    =   $this->banners_model->getBanner($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->banners_model->activedeactive($uri,$status); 
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