<?php 
if(!isset($vslp)){
  	$this->load->view("success_error");
}
?>	
<div class="card">
    <div class="card-body">
        <?php $this->load->view("allsearch");?>	
    </div>
</div>