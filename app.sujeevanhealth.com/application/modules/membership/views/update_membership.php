<?php 
    $dl         = 'Required';
    $lpl        = '';
    $fname      =   $view["membership_image"];
    $target_dir =   $this->config->item("upload_dest")."membership/";
    $oml        =   $quotation_image    =   base_url()."uploads/image_not_available.png";
    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
    if (file_exists($filename)) {
        $dl         = '';
        $oml   	=   base_url().$target_dir.'/'.$fname;
      	$lpl	=	'<img src="'.$oml.'" class="img img-responsive"/>';
    }
    ?>
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
                                <label>Homecare Category<span class="required text-danger">*</span></label>
                                <select class="form-control pd-y-12" name="homecare_category" required>
                                    <option value="">Select Homecare Category</option>
                                    <?php 
                                    foreach($sub_module as $s){ ?>
                                        <option value="<?php echo $s->sub_module_id; ?>" <?php if($view["membership_sub_module_id"]==$s->sub_module_id){ echo 'selected'; } ?>><?php echo $s->sub_module_name; ?></option>
                                    <?php } ?>
                                </select> 
                             </div><!-- form-group -->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Membership Name<span class="required text-danger">*</span></label>
                                <input name="membershipnametype" type="text" class="form-control" placeholder="Enter Membership Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["membership_name"]:set_value("membershipnametype");?>"/>
                                <?php echo form_error('membershipnametype');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Membership Price <span class="required text-danger">*</span></label>
                                <input name="membership_price" type="number" step="0.01" class="form-control membership_price" placeholder="Enter Membership Price" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["membership_price"]:set_value("membership_price");?>"/>
                                <?php echo form_error('membership_price');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Membership Price (after discount) <span class="required text-danger">*</span></label>
                                <input name="membership_after_disc" type="number" step="0.01" class="form-control membership_after_disc" placeholder="Enter membership price after discount" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["membership_after_disc"]:set_value("membership_after_disc");?>"/>
                                <?php echo form_error('membership_after_disc');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Membership expiry in days <span class="required text-danger">*</span></label>
                                <input name="membership_days" type="text" class="form-control membership_days" placeholder="Enter membership expiry in days" required="" autocomplete="off" value="<?php echo $view["membership_days"];?>"/>
                                <?php echo form_error('membership_days');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Membership Type <span class="required text-danger">*</span></label>
                                <select class="form-control membership_typee" name="membership_typee">
                                    <option>Select membership type</option>
                                    <option value="1" <?php if($view['membership_typee']== '1'){echo 'selected';}?>>Basic</option>
                                    <option value="2" <?php if($view['membership_typee']== '2'){echo 'selected';}?>>Normal</option>
                                </select>
                                <?php echo form_error('membership_typee');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>About <span class="required text-danger">*</span></label>
                                <textarea name="membership_about" type="text" class="form-control membership_about" placeholder="Enter about membership" required="" autocomplete="off"><?php echo $view["membership_about"];?></textarea>
                                <?php echo form_error('membership_about');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group">
                            <label>Background Image <span class="text-danger">*</span></label>
                            <input name="module_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
                            <div class="imgclaslobdg mg-t-15"><?php echo $lpl;?></div>
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