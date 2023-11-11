<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Common_model extends CI_Model{
        public function get_config($uri){ 
            $this->db->select("$uri as siteval");
            return $this->db->get_where("config_settings",array("id" => '1'))->row_array(); 
        } 
        public function getLanguages(){ 
            return $this->db->get_where("languages",array("language_open" => '1'))->result_array(); 
        } 
        public function cntviewModules($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querymodules($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewModules($params = array()){
            return $this->querymodules($params)->result_array();
        }
        public function getModules($params = array()){
            return $this->querymodules($params)->row_array();
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "module_acde"       =>    $status,
                            "module_modified_on" =>    date("Y-m-d h:i:s"),
                            "module_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("modules",$ft,array("moduleid" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function update_module($uri){
                $ft     =   array(  
                            "module_name"           =>    $this->input->post("module_name"),
                            "module_program"        =>    ($this->input->post("module_program") != "")?$this->input->post("module_program"):"0",
                            "module_modified_on"    =>    date("Y-m-d h:i:s"),
                            "module_modified_by"    =>    $this->session->userdata("login_id") 
                       ); 
                $target_dir =   $this->config->item("upload_dest")."modules/";
                if(count($_FILES) > 0){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
//                        $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
//                        $vsp        =   explode(".",$fname);
//                        $ect        =   end($vsp);  
//                        if (file_exists($filename)) {
//                            $fname      =   basename($fname,".".$ect)."_".date("YmdHis").".".$ect;
//                        }
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $ft['module_image']  =   $fname;
                        }
                    }
                }
                $this->db->update("modules",$ft,array("moduleid" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function querymodules($params = array()){
                 $dt     =   array(
                                "module_open"          =>  "1",
                                "module_status"        =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('modules')
                            ->where($dt); 
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
//                $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewStates($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryStates($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewStates($params = array()){
            return $this->queryStates($params)->result_array();
        }
        public function getStates($params = array()){
            return $this->queryStates($params)->row_array();
        }
        public function getStatenames($uri){
            $params["whereCondition"]   =   "state_id = '".$uri."'";
            $dreturn    =   $this->queryStates($params)->row_array();
            if(is_array($dreturn) && count($dreturn) > 0){
                return $dreturn["state_name"];
            }
            return "";
        }
        public function getDistrictsname($uri){
            $params["whereCondition"]   =   "district_id = '".$uri."'";
            $dreturn    =   $this->queryDistricts($params)->row_array();
            if(is_array($dreturn) && count($dreturn) > 0){
                return $dreturn["district_name"];
            }
            return "";
        }
        public function queryStates($params = array()){
                 $dt     =   array(
                                "state_status"        =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('state')
                            ->where($dt); 
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
//                $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewDistricts($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryDistricts($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewDistricts($params = array()){
            return $this->queryDistricts($params)->result_array();
        }
        public function getDistricts($params = array()){
            return $this->queryDistricts($params)->row_array();
        }
        public function queryDistricts($params = array()){
                 $dt     =   array(
                                "district_status"        =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('district')
                            ->where($dt); 
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
//                $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        /** Reports **/
        public function exceldownload($reporytvalu,$conditions = array(),$quid = ""){
            $verfil 	=	"";
            $feils      =   array();
            $view       =   array();
            if($reporytvalu == "Symptoms Chat Bot"){
                $conditions["columns"]      =   "module_name as 'Module',healthcategory_name as 'Health Category',healthsubcategory_name as 'Health Sub Category',symptoms_question as 'Question',symptoms_options as 'Options'";
                $verfil =   $this->symptoms_model->querySymptomsbot($conditions);
                $feils 	=   $verfil->list_fields();
                $view 	=   $verfil->result_array();
            } 
            $this->load->library('excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $vsg  	=	$aplj 		=	'A';
            $vsp 	=	2;
            $datarow	=	"3"; 
            $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'size' => 13,
                        'color' => array('rgb' => '000000'),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
            );
            $vstyleArray = array(
                'font' => array(
                    'bold' => true,
                    'size' => 15,
                    'color' => array('rgb' => 'ffffff'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $bodyStyleArray = array(
                  'font' => array(
                    'color' => array('rgb' => '000000'),
                  ),
                  'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  ),
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
            );
            $vsarray 	=	array();
            $sheet = $objPHPExcel->getActiveSheet();
            if(is_array($feils) && count($feils) > 0){
                foreach($feils as $efer){
                    $vsarray[]	=	$efer;
                    $aplj	=	$vsg++;
                    $vspva 	=	$aplj.$vsp;
                    $sheet->setCellValue($vspva,$efer);
                    $sheet->getStyle($vspva)->applyFromArray($styleArray)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('37e884');
                    $sheet->getColumnDimension($aplj)->setAutoSize(true);
                } 
            } 
            $sheet->setCellValue('A1',$reporytvalu)->mergeCells("A1:".$aplj."1");
            $sheet->getStyle("A1")->applyFromArray($vstyleArray)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FC8118');
            $sheet->freezePane("A".$datarow);
            if(is_array($view) && count($view) > 0){
                foreach ($view as $key => $ve) {
                    $vaplj 	=	'A';
                    foreach($vsarray as $vef){
                        $mkc    =   $vaplj.$datarow;
                        $svo 	=	$ve[$vef];
                        $sheet->getCell($mkc)->setValue($svo);
                        if($vlmkc == 1){
                            $sheet->getStyle($mkc)->getAlignment()->setWrapText(true);
                        }
                        $sheet->getStyle($mkc)->applyFromArray($bodyStyleArray)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor();
                        $vaplj++;
                    }
                    $datarow++;
                }
            }
            $vsrepotv 	=	$reporytvalu;
            $fileanme 	=	$vsrepotv.date("d-m-Y h:i:s A").".xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='.$fileanme);
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');
            exit;
        }
        public function specializationList()
        {
            $result = $this->db->query("select specialization_id,specialization_name from specialization where specialization_open='1'")->result_array();
            return $result;
        }
        public function healthCategoryList()
        {
            $result = $this->db->query("select healthcategory_id,healthcategory_name from health_issues_category where healthcategory_open='1'")->result_array();
            return $result;
        }
        public function healthSubCategoryList()
        {
            $result = $this->db->query("select healthsubcategory_id,healthsubcategory_name from subcategory_issues where healthsubcategory_open='1'")->result_array();
            return $result;
        }
        public function update_time_slot(){
            $data = array(
                    "book_appointment_time_type"        =>  ($this->input->post("book_appointment_time_type"))??'',
                    "book_appointment_time"             =>  ($this->input->post("book_appointment_time"))??'',
                    "updated_on"                        =>  date("Y-m-d h:i:s"),
                    "updated_by"                        =>  $this->session->userdata("login_id")
            );
            $this->db->update("book_appointment_time_slot",$data,"book_appointment_time_id = 1");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
}