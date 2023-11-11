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
                                <label>Hospital Speciality Name<span class="required text-danger">*</span></label>
                                <input name="hospital_specialitiesnametype" type="text" class="form-control" placeholder="Enter Hospital Speciality Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["hospital_specialities_name"]:set_value("hospital_specialitiesnametype");?>"/>
                                <?php echo form_error('hospital_specialitiesnametype');?> 
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