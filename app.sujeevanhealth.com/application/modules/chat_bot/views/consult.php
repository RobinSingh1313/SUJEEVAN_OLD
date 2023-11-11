<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-chat-bot") == "1"){ ?>
<?php $this->load->view("create_chatbot");?>
<?php } ?>
<?php $this->load->view("viewfile");?>