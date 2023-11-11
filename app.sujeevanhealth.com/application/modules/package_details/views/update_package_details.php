<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Package Name<span class="required text-danger">*</span></label>
                                <select class="form-control" name="package_id" required>
                                    <option value="">Select Package Name</option>
                                    <?php 
                                    if(is_array($package) && count($package) > 0){
                                        foreach($package as $m){ ?>
                                            <option value="<?php echo $m['package_id'];?>"  <?php echo ($view["package_id"] == $m["package_id"])?"selected=selected":set_select("module",$m['package_id']);?>><?php echo $m['package_name'];?></option>
                                     <?php } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('module');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Package Price<span class="required text-danger">*</span></label>
                                <input name="package_price" type="text" class="form-control" placeholder="Enter Package Price" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_price"]:set_value("package_price");?>"/>
                                <?php echo form_error('package_price');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Package Discount<span class="required text-danger">*</span></label>
                                <input name="package_discount" type="text" class="form-control" placeholder="Enter Package Discount" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_discount"]:set_value("package_discount");?>"/>
                                <?php echo form_error('package_discount');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Package Valid From<span class="required text-danger">*</span></label>
                                <input name="package_from" type="date" class="form-control" placeholder="Enter Package Valid From" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_date_from"]:set_value("package_from");?>"/>
                                <?php echo form_error('package_from');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Package Valid To<span class="required text-danger">*</span></label>
                                <input name="package_to" type="date" class="form-control" placeholder="Enter Package Valid To" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_date_to"]:set_value("package_to");?>"/>
                                <?php echo form_error('package_to');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div> 