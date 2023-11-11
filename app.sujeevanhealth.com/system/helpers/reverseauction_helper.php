<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! function_exists('sitedata')){ 
        function sitedata($uri){
                $CI =& get_instance();
                $vsp 	=	$CI->common_model->get_config($uri);
                return $vsp['siteval'];
        }
}  
if ( ! function_exists('adminurl')){ 
        function adminurl($uri = ""){
                return base_url(). sitedata("site_admin")."/".$uri;
        }
}