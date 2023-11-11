<?php if($this->session->userdata("create-vendor") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
            <?php /*
          	<a  href="<?php echo adminurl("Create-Vendor");?>" class="btn btn-sm btn-info">Create Vendor</a>
          	
          	*/?>
        </div>
  	</div>
</div>
<?php } ?>
<?php $this->load->view("viewfile");?>