<?php
class Submodules extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-sub-module") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_sub_module(){
        $data  = array(
            "title"	=>  "Create Sub Module ",
            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Submodules")."'>Sub Modules</a></li>",
            "content"	=>  "create_sub_module"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("sub_module_name","Sub Module Name","required|trim|xss_clean|callback_checkmodule_name");
                $this->form_validation->set_rules("module","Module","required");
                if($this->form_validation->run()){
                    $ins    = $this->sub_module_model->create_sub_module();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Sub Module Successfully.");
                        redirect(sitedata("site_admin")."/Sub-Module");
                    }else{
                        $this->session->set_flashdata("err","Not Created Sub Module.Please try again");
                        redirect(sitedata("site_admin")."/Sub-Module");
                    }
            }                        
        }
        $conditions     =   array("whereCondition" => "module_acde = 'Active'");
        $data['module']	=	$this->common_model->viewModules($conditions);
        $ocndi["whereCondition"]    =   "vendor_acde = 'Active'";
        $data['vendor'] =   $this->vendor_model->viewVendors($ocndi);
        $this->load->view("inner_template",$data);
    }
    public function unique_submodule_name(){
        $cpsl   =       $this->sub_module_model->unique_submodule_name();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function checkmodule_name(){
        $vsp	=	$this->sub_module_model->unique_submodule_name();
        if($vsp){
                $this->form_validation->set_message("checkmodule_name","Sub Module Name already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Sub Module",
                "vtil"      =>  "",
                "content"   =>  "sub_module"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"sub_moduleid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Sub_module";
        $dta["urlvalue"]  =   adminurl("viewSubModule/");

        $this->load->view("inner_template",$dta);
    }
    public function viewSubModule(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Sub_module";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        // $conditions["whereCondition"]    =   "sub_module_module_id = '7'";
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"sub_moduleid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->sub_module_model->cntviewSub_module($conditions);  
            $config['base_url']     =   adminurl('viewSubModule');
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
        $dta["urlvalue"]           	=   adminurl('viewSubModule/');
        $dta["view"]               	=   $view	=	$this->sub_module_model->viewSub_module($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewSubModule/");
        $this->load->view("ajax_sub_module",$dta);
    }
    public function update_sub_module(){
        $uri    =   $this->uri->segment('3');
        $conditions["whereCondition"]   =   "sub_module_id = '".$uri."'";
        $view	=	$this->sub_module_model->getSub_module($conditions);
        if(is_array($view) && count($view) > 0){
            $data   =   array(
                            'view'      =>  $view,
                            "title"     =>	"Update Sub module ",
                            "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Sub-Module")."'>Sub Module</a></li>",
                            "content"	=>	"update_sub_module"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("sub_module_name","Sub_module Name ","required|trim|callback_checkmodule_name");
                $this->form_validation->set_rules("module","Module","required");
                if($this->form_validation->run()){
                    $ins    = $this->sub_module_model->update_sub_module($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Sub Module Successfully.");
                        redirect(sitedata("site_admin")."/Sub-Module");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Sub Module.Please try again");
                        redirect(sitedata("site_admin")."/Sub-Module");
                    }
                }                        
            }
            $conditions     =   array("whereCondition" => "module_acde = 'Active'");
            $data['module']	=	$this->common_model->viewModules($conditions);
            $ocndi["whereCondition"]    =   "vendor_acde = 'Active'";
            $data['vendor'] =   $this->vendor_model->viewVendors($ocndi);
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Sub Module does not exists.Please try again");
            redirect(sitedata("site_admin")."/Sub-Module");
        }
    }
    public function  delete_sub_module(){
        $vsp    =   "0";
        if($this->session->userdata("delete-sub-module") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "sub_module_id = '".$uri."'";
            $vue    =   $this->sub_module_model->getSub_module($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->sub_module_model->delete_sub_module($uri); 
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
        if($this->session->userdata("active-deactive-sub-module") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "sub_module_id = '".$uri."'";
		    $vue    =   $this->sub_module_model->getSub_module($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->sub_module_model->activedeactive($uri,$status); 
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