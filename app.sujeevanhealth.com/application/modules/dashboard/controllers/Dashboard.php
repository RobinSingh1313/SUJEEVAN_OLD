<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard extends CI_Controller{
        public function __construct() {
                parent::__construct();
        }
        public function index(){
                if($this->session->userdata("login_id") == ''){
                    redirect("/");
                }
                $dat    =   array(
                    "title"     =>  "Dashboard",
                    "content"   =>  "dashboard"
                );
                $this->load->view("inner_template",$dat);
        }
        public function __destruct() {
                $this->db->close();
        }
}