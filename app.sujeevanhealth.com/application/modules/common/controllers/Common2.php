<?php

class Common2 extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function packages(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "All packages",
                "vtil"      =>  "",
                "content"   =>  "viewfile"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regpackageid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "packages";
        $dta["urlvalue"]  =   adminurl("viewPackages/");
        $this->load->view("inner_template",$dta);
    }
    public function viewPackages(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "packages";
        $dta["offset"]    =   $offset;
        $keywords         =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regpackageid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->vendor_registration_model->cntviewPackages($conditions);  
            $config['base_url']     =   adminurl('viewpackages');
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
        $dta["urlvalue"]           	=   adminurl('viewPackages/');
        $dta["view"]            =   $view	=	$this->vendor_registration_model->viewPackages($conditions);
        $dta["totalrows"]       =   $totalRec-count($view);
        $dta["offset"]          =   $offset;
        $this->load->view("ajax_packages",$dta);
    }
    public function specialities(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "All Specialities",
                "vtil"      =>  "",
                "content"   =>  "viewfile"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"specialitiesid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "SPECIALITIES";
        $dta["urlvalue"]  =   adminurl("viewSpecialities/");
        $this->load->view("inner_template",$dta);
    }
    public function viewSpecialities(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "SPECIALITIES";
        $dta["offset"]    =   $offset;
        $keywords         =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"specialitiesid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->product_model->cntviewspecialities($conditions);  
            $config['base_url']     =   adminurl('viewSpecialities');
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
        $dta["urlvalue"]           	=   adminurl('viewSpecialities/');
        $dta["view"]            =   $view	=	$this->product_model->viewspecialities($conditions);
        $dta["totalrows"]       =   $totalRec-count($view);
        $dta["offset"]          =   $offset;
        $this->load->view("ajax_specialities",$dta);
    }
    public function facilities(){
    	$dta       =   array(
    			"limit"     =>  '1',
    			"title"     =>  "All facilities",
    			"vtil"      =>  "",
    			"content"   =>  "viewfile"
    	);
    	$orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
    	$tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"facilitesid";  
    	$conditions     =   array();
    	if(!empty($orderby) && !empty($tipoOrderby)){ 
    		$dta['orderby']        =   $conditions["orderby"]       =   $orderby;
    		$dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
    	} 
    	$keywords   =   $this->input->get('keywords'); 
    	if(!empty($keywords)){
    		$conditions['keywords'] = $keywords;
    	}
    	$dta["pageurl"]   =   $pageurl    =   "facilities";
    	$dta["urlvalue"]  =   adminurl("viewFacilities/");
    	$this->load->view("inner_template",$dta);
    }
    public function viewFacilities(){
    	$conditions =   array();
    	$page       =   $this->uri->segment('3');
    	$offset     =   (!$page)?"0":$page;
    	
    	$dta["pageurl"]   =   $pageurl    =   "facilities";
    	$dta["offset"]    =   $offset;
    	$keywords         =   $this->input->post('keywords');
    	if(!empty($keywords)){
    		$dta['keywords']        = $keywords;
    		$conditions['keywords'] = $keywords;
    	}  
    	$this->session->set_userdata("arr".$pageurl,$dta); 
    	$perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
    	$orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
    	$tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"facilitesid";
    	if($perpage != $this->config->item("all")){
    		$totalRec               =   $this->product_model->cntviewfacilites($conditions);  
    		$config['base_url']     =   adminurl('viewFacilities');
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
    	$dta["urlvalue"]           	=   adminurl('viewFacilities/');
    	$dta["view"]            =   $view	=	$this->product_model->viewfacilites($conditions);
    	$dta["totalrows"]       =   $totalRec-count($view);
    	$dta["offset"]          =   $offset;
    	$this->load->view("ajax_facilities",$dta);
    }
    public function __destruct(){
        $this->db->close();
    }
}