<?php
class Chat_bot extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function __destruct(){
        $this->db->close();
    }
}