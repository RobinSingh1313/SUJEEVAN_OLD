<?php
class Health_tip_model extends CI_Model{
    public function queryHealthtips($params = array()){
        
    }
    public function cntviewHealthtips($params = array()){
        $params['cnt']      =   '1';
        $lcp    =   $this->health_tip_model->queryHealthtips($params)->row_array();
        return 0;
    }
    public function viewHealthtips($params = array()){
        return $this->health_tip_model->queryHealthtips($params)->result_array();
    }
}