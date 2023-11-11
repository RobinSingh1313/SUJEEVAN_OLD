<?php if($this->session->userdata("create-hospital_specialities") == "1"){ ?>
<?php $this->load->view("create_hospital_specialities");?>
<?php } ?>
<?php $this->load->view("viewfile");?>