<?php
class Api_scores extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $sv     =   $this->api_model->checkAuthorizationvalid();
            $dta    =   $this->api_model->jsonencode("0","Authorization key Invalid");
            if($sv != "1"){
                echo $dta;
                exit;
            }
        }
        public function gfr(){
            $avl    =   $this->input->post("serum");
            $gvl    =   $this->input->post("age");
            $sv    =   $this->api_model->checkAuthorizationvalid();
            $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
            if($sv == "1"){
                $dta	=	$this->api_model->jsonencode("1","Some fields are required");
                if($avl != '' && $gvl !=''){
                    $adkol  =   $this->api_model->scorepoint("api-gfr");
                    $dta	=	$this->api_model->jsonencode("2",$adkol);
                }
            }
            echo ($dta);
        }
        public function insulin_resistance(){
            $avl    =   $this->input->post("fasting_insulin");
            $gvl    =   $this->input->post("fasting_glucose");
            $sv    =   $this->api_model->checkAuthorizationvalid();
            $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
            if($sv == "1"){
                $dta	=	$this->api_model->jsonencode("1","Some fields are required");
                if($avl != '' && $gvl !=''){
                    $adkol  =   $this->api_model->scorepoint("api-insulin-resistance");
                    $dta	=	$this->api_model->jsonencode("2",$adkol);
                }
            }
            echo ($dta);
        }
        public function bmi(){
            $avl    =   $this->input->post("height");
            $avlinc    =   $this->input->post("heightinc");
            $gvl    =   $this->input->post("weight");
            $sv    =   $this->api_model->checkAuthorizationvalid();
            $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
            if($sv == "1"){
                $dta	=	$this->api_model->jsonencode("1","Some fields are required");
                if($avl != '' && $gvl !=''){
                    $adkol  =   $this->api_model->scorepoint("api-bmi");
                    $dta	=	$this->api_model->jsonencode("3","wrong inputs given");
                    if(is_array($adkol)){
                        $dta	=	$this->api_model->jsonencode("2",$adkol);
                    }
                    
                }
            }
            echo ($dta);
        }
        public function heart_score(){
            $avl    =   $this->input->post("history");
            $gvl    =   $this->input->post("age");
            $rvl    =   $this->input->post("risk");
            $tvl    =   $this->input->post("troponin");
            $sv    =   $this->api_model->checkAuthorizationvalid();
            $dta   =   $this->api_model->jsonencode("0","Authorization key Invalid");
            if($sv == "1"){
                $dta	=	$this->api_model->jsonencode("1","Some fields are required");
                if($avl != '' && $gvl !='' && $rvl != "" && $tvl != ""){
                    $adkol  =   $this->api_model->scorepoint("api-heart-score");
                    $dta	=	$this->api_model->jsonencode("2",$adkol);
                }
            }
            echo ($dta);
        }
        public function __destruct(){
            $this->db->close();
        }
}