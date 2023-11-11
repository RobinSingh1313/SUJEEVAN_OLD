<?php
require_once APPPATH .'../vendor/autoload.php';
class Mpdftest { 
    public function indexval(){ 
        $mpdf = new \Mpdf\Mpdf(); 
        return $mpdf;
    } 
}