<?php

class Product_model extends CI_Model{
        public function cntviewProduct($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryProduct($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewProduct($params = array()){
            return $this->queryProduct($params)->result_array();
        }
        public function getProduct($params = array()){
            return $this->queryProduct($params)->row_array();
        }
        public function delete_Product($uro){
                $dta    =   array(
                    "product_open"        =>  0, 
                    "product_modified_on" =>    date("Y-m-d H:i:s"),
                    "product_modified_by" =>    ($this->session->userdata("login_id") != "")?$this->session->userdata("login_id"):$this->input->post("regvendor_id")
                );
                $this->db->update("products",$dta,array("product_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    $dta    =   array(
                        "product_image_open"        =>   0, 
                        "product_image_modified_on" =>   date("Y-m-d H:i:s"),
                        "product_image_modified_by" =>   ($this->session->userdata("login_id") != "")?$this->session->userdata("login_id"):$this->input->post("regvendor_id")
                    );
                    $this->db->update("product_image",$dta,array("product_image_productid" => $uro));
                    $vsp   =    $this->db->affected_rows();
                    return true;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "product_acde"       =>    $status,
                            "product_modified_on" =>    date("Y-m-d H:i:s"),
                            "product_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("products",$ft,array("product_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryProductImage($params = array()){
                $dt     =   array(
                                "product_image_open"         =>  "1",
                                "product_image_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('product_image')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(product_image_path LIKE '%".$params["keywords"]."%' )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewProductImage($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryProductImage($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewProductImage($params = array()){
            return $this->queryProductImage($params)->result_array();
        }
        public function getProductImage($params = array()){
            return $this->queryProductImage($params)->row_array();
        }
        public function delete_ProductImage($uro){
                $dta    =   array(
                    "product_image_open"        =>  0, 
                    "product_image_modified_on" =>    date("Y-m-d H:i:s"),
                    "product_image_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("product_image",$dta,array("product_image_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactiveImage($uri,$status){
                $ft     =   array(  
                            "product_image_acde"        =>    $status,
                            "product_image_modified_on" =>    date("Y-m-d H:i:s"),
                            "product_image_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("product_image",$ft,array("product_image_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryProduct($params = array()){
                 $dt     =   array(
                                "product_open"         =>  "1",
                                "product_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('products')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(product_name LIKE '%".$params["keywords"]."%' OR product_acde LIKE '%".$params["keywords"]."%' OR product_stock_availibility LIKE '%".$params["keywords"]."%' OR product_quantity LIKE '%".$params["keywords"]."%' OR product_actual_price LIKE '%".$params["keywords"]."%' OR product_offer_price LIKE '%".$params["keywords"]."%'  OR product_description LIKE '%".$params["keywords"]."%' )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        /** Facilities **/
        public function queryfacilites($params = array()){
                 $dt     =   array(
                                "facilites_open"         =>  "1",
                                "facilites_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('facilites')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(facilites_name LIKE '%".$params["keywords"]."%' OR facilites_acde = '".$params["keywords"]."' OR facilites_description LIKE '%".$params["keywords"]."%' )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewfacilites($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryfacilites($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewfacilites($params = array()){
            return $this->queryfacilites($params)->result_array();
        }
        public function getfacilites($params = array()){
            return $this->queryfacilites($params)->row_array();
        }
        public function delete_facilites($uro){
                $dta    =   array(
                    "facilites_open"        =>  0, 
                    "facilites_modified_on" =>    date("Y-m-d H:i:s"),
                    "facilites_modified_by" =>    ($this->session->userdata("login_id") != "")?$this->session->userdata("login_id"):$this->input->post("regvendor_id")
                );
                $this->db->update("facilites",$dta,array("facilites_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        /** specialities **/
        public function queryspecialities($params = array()){
                 $dt     =   array(
                                "specialities_open"         =>  "1",
                                "specialities_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('specialities')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(specialities_name LIKE '%".$params["keywords"]."%' or specialities_doctors  LIKE '%".$params["keywords"]."%' OR specialities_acde LIKE '%".$params["keywords"]."%' OR specialities_description LIKE '%".$params["keywords"]."%' )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewspecialities($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryspecialities($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewspecialities($params = array()){
            return $this->queryspecialities($params)->result_array();
        }
        public function getspecialities($params = array()){
            return $this->queryspecialities($params)->row_array();
        }
        public function delete_specialities($uro){
                $dta    =   array(
                    "specialities_open"        =>  0, 
                    "specialities_modified_on" =>    date("Y-m-d H:i:s"),
                    "specialities_modified_by" =>    ($this->session->userdata("login_id") != "")?$this->session->userdata("login_id"):$this->input->post("regvendor_id")
                );
                $this->db->update("specialities",$dta,array("specialities_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        /** doctors **/
        public function querydoctors($params = array()){
                 $dt     =   array(
                                "doctors_open"         =>  "1",
                                "doctors_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('doctors')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(doctors_name LIKE '%".$params["keywords"]."%' or doctors_availbility  LIKE '%".$params["keywords"]."%' OR doctors_acde LIKE '%".$params["keywords"]."%' OR doctors_description LIKE '%".$params["keywords"]."%' )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewdoctors($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querydoctors($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewdoctors($params = array()){
            return $this->querydoctors($params)->result_array();
        }
        public function getdoctors($params = array()){
            return $this->querydoctors($params)->row_array();
        }
        public function delete_doctors($uro){
                $dta    =   array(
                    "doctors_open"        =>  0, 
                    "doctors_modified_on" =>    date("Y-m-d H:i:s"),
                    "doctors_modified_by" =>    ($this->session->userdata("login_id") != "")?$this->session->userdata("login_id"):$this->input->post("regvendor_id")
                );
                $this->db->update("doctors",$dta,array("doctors_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
}