<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-homecare-chat-bot") == "1"){ ?>
<?php $this->load->view("homecare/create_chatbot");?>
<?php } ?>
<?php $this->load->view("viewfile");?>