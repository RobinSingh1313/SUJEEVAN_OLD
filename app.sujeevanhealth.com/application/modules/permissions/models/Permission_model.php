<?php
class Permission_model extends CI_Model{ 
        public function get_permission($vlp){
                $this->db->select("p.page_name,s.per_status");
                $this->db->from("pages as p");
                $this->db->join("permissions as s","s.per_page_id = p.page_id","LEFT");
                $this->db->where("s.per_usertype",$vlp);
                $vkp = $this->db->get(); 
                // echo $this->db->last_query();exit;
                return  $vkp->result(); 
        }
        public function page_module(){
                $this->db->distinct();
                $this->db->select("page_module");
                $this->db->from("pages")->order_by("page_order");
                return $this->db->get()->result();
        }
        public function get_pages($params = array()){
                $this->db->select("*");
                $this->db->from("pages");
                $this->db->where("page_name != 'manage-permission'")
                        ->order_by("page_order");
                if(array_key_exists('condition', $params)){
                        $this->db->where("(".$params['condition'].")");
                }
//                $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get()->result();
        }
        public function get_shares(){ 
                $this->db->select('CONCAT(per_usertype,"-",per_page_id) AS detail,per_status');
                $this->db->from("permissions"); 
                //$this->db->get();echo $this->db->last_query();exit;
                return $this->db->get()->result();
        }
        public function get_shre($pg,$ut){ 
                $this->db->select('per_status');
                $this->db->from("permissions"); 
                $this->db->where("per_page_id",$pg); 
                $this->db->where("per_usertype",$ut); 
                $this->db->get(); 
                if($this->db->affected_rows() > 0){
                        return "1";
                }else{
                        $dt = array(
                                "per_page_id"	=>	$pg,
                                "per_usertype"	=>	$ut,
                                "per_status"	=>	0,
                        );
                        $this->db->insert("permissions",$dt);
                        if($this->db->insert_id() > 0){
                                return "1";
                        }else{
                                return "0";
                        }
                }
        }
        public function update_permission(){	 
                $dta    =       $this->input->post('user_roles[]')?($this->input->post('user_roles[]')):array(); 
                $srg    =       $this->input->post('user_modules[]')?array_filter($this->input->post('user_modules[]')):array();
                $params     =   array();
                if(count($srg) > 0){
                    $vsp    =   "";
                    foreach($srg as $fr){
                            $vsp    .=  "page_module LIKE '".$fr."' OR ";
                    }   
                    $vsp    =   substr($vsp,0,-3);
                    $params['condition']    =       $vsp;
                }
                $gtd    =       "ut_open = 1 AND ";
                if(count($dta) > 0){
                        $gtd    .=  " (";
                        foreach($dta as $gt){
                                $gtd    .=  "ut_id = '".$gt."' OR ";
                        }
                        $gtd    =   substr($gtd,0,-3)." ) ";
                        $mgy    =   $this->role_model->viewtypes($gtd);
                } else{
                        $mgy    =   $this->role_model->view_types(array("ad_id" => '0'));
                }
                $users 	=	$mgy;
                $pages 	=	$this->get_pages($params);
                $share 	=	$this->get_shares();
                foreach($pages as $pg){
                        foreach($users as $ur){ 
                                $vlpa = $this->get_shre($pg->page_id,$ur->ut_id);
                                if($vlpa == "1"){
                                        $vala 	=	$this->input->post('permission['.$ur->ut_id.']['.$pg->page_id.']');
                                        $valp	=	$vala?$vala:0;
                                        $dt = array(
                                                "per_page_id"	=>	$pg->page_id,
                                                "per_usertype"	=>	$ur->ut_id
                                        ); 
                                        $this->db->update("permissions",array("per_status" => $valp),$dt);  
                                }
                        }
                }
                $login_type    =    $this->session->userdata("login_type"); 
                $roles         =    $this->permission_model->get_permission($login_type);   
                if(count($roles) > 0){
                        foreach($roles  as $vp){
                                $this->session->set_userdata($vp->page_name,$vp->per_status);
                        }
                }  
                return "1";
        } 
}
?>