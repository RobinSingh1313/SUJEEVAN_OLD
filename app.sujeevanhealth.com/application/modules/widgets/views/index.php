<?php
$cr     =   $this->session->userdata("create-role");
$ur     =   $this->session->userdata("update-role");
$dr     =   $this->session->userdata("delete-role");
$ct     =   "0";
if($ur  == 1 || $dr == '1'){
        $ct     =   1;
}
?>
<div class="row row-sm">
    <?php if($cr == 1) { ?>
    <div class="col-sm-6 col-lg-4">
      <div class="card shadow-base bd-0">
         <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Create Widget</h6>
         </div>
         <!-- card-header -->
         <div class="card-body">
            <form method="post" action="" novalidate="" autocomplete="off" class="validatform">
               <?php $this->load->view("success_error");?> 
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Widget Name <span class="required text-danger">*</span></label>
                        <input name="widget_display_name" type="text" class="form-control-sm form-control widget_display_name text-capitalize" placeholder="Widget Name" value="<?php echo set_value('widget_display_name');?>" required="" minlength="3" maxlength="50"/>
                        <?php echo form_error('widget_display_name');?> 
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save </button>
            </form>
         </div>
         <!-- card-body -->
      </div>
      <!-- card -->
   </div>
   <!-- col-4 -->
    <?php } ?>
   <div class="col-sm-6 col-lg-8 mg-t-20 mg-sm-t-0">
      <div class="card shadow-base bd-0">
         <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h6 class="card-title tx-uppercase text-info tx-12 mg-b-0">View Widgets</h6>
         </div>
         <!-- card-header -->
         <div class="card-body">
            <?php $this->load->view("allsearch");?>	
         </div>
         <!-- card-body -->
      </div>
      <!-- card -->
   </div>
   <!-- col-4 -->
</div>