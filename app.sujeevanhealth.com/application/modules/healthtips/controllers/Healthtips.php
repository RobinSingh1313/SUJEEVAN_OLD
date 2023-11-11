<?php
class Healthtips extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-health-tips") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_category(){
        $data  = array(
                        "title"		=>	"Create Category ",
                     	"vtil"      =>   "<li class='breadcrumb-item'><a href='". adminurl("Category")."'>Category</a></li>",
                        "content"	=>	"create_category"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("category_name","Category Name","required|callback_category_name|trim");
                $this->form_validation->set_rules("module","Module","required");
                if($this->form_validation->run()){
                    $ins    = $this->health_tip_model->create_category();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Category Successfully.");
                        redirect(sitedata("site_admin")."/Category");
                    }else{
                        $this->session->set_flashdata("err","Not Created Category.Please try again");
                        redirect(sitedata("site_admin")."/Category");
                    }
            }                        
        }
        $conditions     =   array();
        $data['module']	=	$this->common_model->viewModules($conditions);
        $this->load->view("inner_template",$data);
    }
    public function unique_category_name(){
        $cpsl   =       $this->health_tip_model->unique_id_check_category();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function category_name(){
        $vsp	=	$this->health_tip_model->unique_id_check_category();
        if($vsp){
                $this->form_validation->set_message("category_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Health Tips",
                "vtil"      =>  "",
                "content"   =>  "health_tips"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"categoryid";  
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
        $dta["urlvalue"]  =   adminurl("viewHealthtips/");
        $this->load->view("inner_template",$dta);
    }
    public function viewHealthtips(){
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
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"categoryid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->health_tip_model->cntviewHealthtips($conditions);  
            $config['base_url']     =   adminurl('viewHealthtips');
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
        $dta["urlvalue"]           	=   adminurl('viewHealthtips/');
        $dta["view"]               	=   $view	=	$this->health_tip_model->viewHealthtips($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewHealthtips/");
        $this->load->view("ajax_health",$dta);
    }
    public function update_category(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Category ",
                        "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Category")."'>Category</a></li>",
                        "content"	=>	"update_category"
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("category_name","Category Name","required|callback_category_name|trim");
            $this->form_validation->set_rules("module","Module","required");
            if($this->form_validation->run()){
                $ins    = $this->health_tip_model->update_category($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Category Successfully.");
                    redirect(sitedata("site_admin")."/Category");
                }else{
                    $this->session->set_flashdata("err","Not Updated Category.Please try again");
                    redirect(sitedata("site_admin")."/Category");
                }
            }                        
        }
        $conditions     =   array();
        $data['module']	=	$this->common_model->viewModules($conditions);
        $conditions["whereCondition"]   =   "category_id = '".$uri."'";
        $data['view']	=	$this->health_tip_model->getCategory($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_category(){
        $vsp    =   "0";
        if($this->session->userdata("delete-health-tips") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "category_id = '".$uri."'";
		    $vue    =   $this->health_tip_model->getCategory($params);
            if(count($vue) > 0){
                $bt     =   $this->health_tip_model->delete_category($uri); 
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
        if($this->session->userdata("active-deactive-health-tips") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "category_id = '".$uri."'";
		    $vue    =   $this->health_tip_model->getCategory($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->health_tip_model->activedeactive($uri,$status); 
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