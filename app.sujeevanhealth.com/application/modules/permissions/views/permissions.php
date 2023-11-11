<div class="row">
    <div class="col-lg-12">
        <form method="post" action="" novalidate="">
            <div class="card">
                <div class="card-body">
                    <?php $this->load->view("success_error");?> 
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>   
                                <select title="Select Role" class="form-control  select2 user_roles" name="user_roles[]" required="" multiple="" onchange="user_role()">
                                    <?php 
                                    if(count($user) > 0) {
                                        foreach($user as $us){
                                        ?>
                                    <option value="<?php echo $us->ut_id;?>" <?php echo set_select("user_roles[]",$us->ut_id);?>><?php echo $us->ut_name;?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error("user_roles[]");?> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Modules </label>  
                                <select title="Select Module" class="form-control select2 user_modules" name="user_modules[]" multiple="" onchange="user_role()">
                                    <?php 
                                    if(count($modules) > 0) {
                                        foreach($modules as $uds){
                                        ?>
                                        <option  value="<?php echo $uds->page_module;?>"><?php echo $uds->page_module;?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>  
                            </div>
                        </div> 
                    </div>
                    <div class="row"> 
                        <input type="hidden" id="permiurlvalue" name="permiurlvalue" value="<?php echo adminurl('AjaxPermission/');?>"> 
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php $this->load->view("loader");?> 
                            <div class='ajaxListPer'></div>
                        </div>   
                    </div>					
                </div> 
                <div class="card-footer">
                    <div class="clearfix">
                        <div class="pull-left">
                            <button type="submit" class="btn  btn-sm btn-success" name="submit" value="submit"> Save </button>
                        </div>
                     </div>
                 </div>
            </div>
        </form>
    </div>
</div>