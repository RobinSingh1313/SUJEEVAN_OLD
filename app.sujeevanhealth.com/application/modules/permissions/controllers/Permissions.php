<?php 
class Permissions extends CI_Controller{
        public function __construct(){
                parent::__construct();  
                if($this->session->userdata("manage-permission") != "1"){
                        redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function index(){
                $data 	=	array(
                                "title" 	=>	"Permissions",
                                "content"	=>	"permissions",
                                "vtil"          =>      "", 
                                "user"          =>      $this->role_model->view_types(array("ad_id" => '0',"tipoOrderby" => "ut_order","order_by" => "asc")), 
                                "modules"       =>      $this->permission_model->page_module()
                ); 	
                if($this->input->post("submit")){ 
                    $this->form_validation->set_rules("user_roles[]","User Role","required");
                    if($this->form_validation->run() == TRUE){
                        $ins = $this->permission_model->update_permission();
                        if($ins == 1){								
                                $valp 	= $this->permission_model->get_permission($this->session->userdata('login_typeid'));
                                if(count($valp) > 0){
                                    foreach($valp  as $vp){
                                      	$this->session->set_userdata($vp->page_name,$vp->per_status);
                                    }
                                }
                                $this->session->set_flashdata("suc","Updated Permissions Successfully.");
                                redirect(sitedata("site_admin")."/Permissions");
                        }else{
                                $this->session->set_flashdata("err","Not Updated Permissions.");
                                redirect(sitedata("site_admin")."/Permissions");
                        }
                    }
                } 
                $this->load->view("inner_template",$data);
        } 
        public function ajaxPermission(){
                $dta    =   $this->input->post('vale')?array_filter($this->input->post('vale')):array(); 
                $srg    =   $this->input->post('modiul')?array_filter($this->input->post('modiul')):array(); 
                $params     =   array();
                if(count($srg) > 0){
                    $vsp    =   "";
                    foreach($srg as $fr){
                            $vsp    .=  "page_module LIKE '".$fr."' OR ";
                    }   
                    $vsp    =   substr($vsp,0,-3);
                    $params['condition']    =       $vsp;
                }
                $gtd    =       "ut_open = 1 and ut_order <> '0'";
                if(count($dta) > 0){
                        $gtd    .=  " AND (";
                        foreach($dta as $gt){
                                $gtd    .=  "ut_id = '".$gt."' OR ";
                        }
                        $gtd    =   substr($gtd,0,-3)." ) ";
                }
                $data 	=	array( 
                                "user"          =>      $this->role_model->viewtypes($gtd),
                                "perm"          =>      $this->permission_model->get_pages($params),
                                "shares"        =>      $this->permission_model->get_shares()
                );  
                $this->load->view("ajaxPermission",$data);
        }
        public function __destruct() {
            $this->db->close();
        }
}