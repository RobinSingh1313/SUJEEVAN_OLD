<?php if($this->session->userdata("create-medicine_list") == "1"){ ?>
<?php $this->load->view("create_medicine_list");?>
<?php } ?>
<?php $this->load->view("viewfile");?>