<?php
    ob_start();
    error_reporting(0);
    defined('BASEPATH') or exit('No direct script access allowed');
    class Sql_Model extends CI_Model
    {
        public function __construct()
        {
            parent:: __construct();
            date_default_timezone_set('Asia/kolkata');
            // $this->db->db_debug = false;
        }
        function ExecuteQuery($query,$params,$query_type)
        {
            if($query_type=="read")
            {
                return $this->db->query($query,$params)->result();
            }
            else
            {
                $this->db->query($query,$params);
                $err = $this->db->error();
                if(!empty($err))
                {
                    return $err['code'];
                }
            }
        }
    }
?>