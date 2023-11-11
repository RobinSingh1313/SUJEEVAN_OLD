<div class="row mb-2">
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
                                <label>Medicine List Name <span class="required text-danger">*</span></label>
                                <input name="medicine_listnametype" type="text" class="form-control medicine_listnametype" placeholder="Enter Medicine List Name" required="" autocomplete="off" value="<?php echo set_value("medicine_listnametype");?>"/>
                                <?php echo form_error('medicine_listnametype');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Medicine Brand Name</label>
                                <input name="medicine_brand" type="text" class="form-control medicine_brand" placeholder="Enter Medicine Brand" autocomplete="off" value="<?php echo set_value("medicine_brand");?>"/>
                                <?php echo form_error('medicine_brand');?> 
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