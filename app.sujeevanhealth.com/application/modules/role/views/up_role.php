<div class="row row-sm">
    <div class="col-sm-6 col-lg-4">
      <div class="card shadow-base bd-0">
         <div class="card-body">
            <form method="post" action="" novalidate="" autocomplete="off" class="validatform">
               <?php $this->load->view("success_error");?> 
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Role Name <span class="required text-danger">*</span></label>
                        <input name="roleid" type="hidden" class="form-control form-control-sm roleid" placeholder="Role Name" value="<?php echo  $view["ut_id"];?>"/>
                        <input name="rolename" type="text" roleid="<?php echo  $view["ut_id"];?>" class="form-control rolename" placeholder="Role Name" value="<?php echo $view['ut_name'];?>" required="" minlength="3" maxlength="50"/>
                        <?php echo form_error('rolename');?>
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
</div>