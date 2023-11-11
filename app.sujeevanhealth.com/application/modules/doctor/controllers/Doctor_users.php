<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Doctor_users extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-doctor-users") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function viewDoctorCustomers(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERDoctor";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $conditions['whereCondition'] ="register_acde ='Active'";
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"registrationid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->registration_model->cntviewRegistration($conditions);  
                    $config['base_url']     =   adminurl('viewDoctorCustomers');
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
                $dta["urlvalue"]           	=   adminurl('viewDoctorCustomers/');
                $dta["view"]            =   $view	=	$this->registration_model->viewRegistration($conditions);
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_doctor_customers",$dta);
        }
        public function indexcustomers(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "All Doctor Customers",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regvendorid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERDoctor";
                $dta["urlvalue"]  =   adminurl("viewDoctorCustomers/");
                $this->load->view("inner_template",$dta);
        }
        public function __destruct() {
                $this->db->close();
        }
}