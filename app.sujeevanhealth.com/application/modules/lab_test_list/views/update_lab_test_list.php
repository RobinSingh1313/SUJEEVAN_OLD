<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Lab Test List Name<span class="required text-danger">*</span></label>
                                <input name="lab_test_listnametype" type="text" class="form-control" placeholder="Enter Lab Test List Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["lab_test_list_name"]:set_value("lab_test_listnametype");?>"/>
                                <?php echo form_error('lab_test_listnametype');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Lab Test Price <span class="required text-danger">*</span></label>
                                <input name="lab_test_price" type="number" step="0.01" class="form-control lab_test_price" placeholder="Enter Lab Test Price" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["lab_test_price"]:set_value("lab_test_price");?>"/>
                                <?php echo form_error('lab_test_price');?> 
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