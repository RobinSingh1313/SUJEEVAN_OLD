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
                                <label>Package Name<span class="required text-danger">*</span></label>
                                <input name="packagenametype" type="text" class="form-control" placeholder="Enter Package Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_name"]:set_value("packagenametype");?>"/>
                                <?php echo form_error('packagenametype');?> 
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