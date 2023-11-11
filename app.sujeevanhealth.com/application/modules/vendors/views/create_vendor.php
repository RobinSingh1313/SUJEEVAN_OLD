<?php 
$vendorsubmodule_api    =   $this->config->item("moduleapi");
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
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Vendor Name <span class="required text-danger">*</span></label>
                                <input name="vendor_id" type="hidden" class="form-control vendor_id" value="<?php echo (is_array($view) && count($view) > 0)?$view["vendor_id"]:set_value("vendor_id");?>"/>
                                <input name="vendor_name" type="text" class="form-control vendor_name" placeholder="Enter Vendor" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vendor_name"]:set_value("vendor_name");?>"/>
                                <?php echo form_error('vendor_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <?php
                                if(is_array($view) && count($view) > 0){
                                    $fname      =   $view["vendor_icon"];
                                    $target_dir =   $this->config->item("upload_dest")."modules/";
                                    $oml        =   "";
                                    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.$fname;
                                    if (file_exists($filename)) {
                                        $finame   =   base_url().$target_dir.'/'.$fname;
                                        $oml    =   "<img src='".$finame."' class='img imglogoho img-thumbnail mt-1 img-responsive'/>";
                                    }
                                    ?>
                                <label>Upload Image </label>
                                <input name="module_image" type="file"accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
                                <div class="imgslosc"><?php echo $oml;?></div>
                                    <?php
                                }else{
                                    ?>
                                <label>Upload Image <span class="text-danger">*</span></label>
                                <input name="module_image" type="file" required="" accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
                                <div class="imgslosc"></div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <?php
                                if(is_array($view) && count($view) > 0){
                                    $fname      =   $view["vendor_background"];
                                    $target_dir =   $this->config->item("upload_dest")."modules/";
                                    $oml        =   "";
                                    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.$fname;
                                    if (file_exists($filename)) {
                                        $finame   =   base_url().$target_dir.'/'.$fname;
                                        $oml    =   "<img src='".$finame."' class='img imglogoho img-thumbnail mt-1 img-responsive'/>";
                                    }
                                    ?>
                                <label>Vendor Background </label>
                                <input name="vendor_background" type="file" accept=".png,.jpg,.jpeg" class="form-control imgclaslobdgbg"/>
                                <div class="imgclaslobdgbgicon"><?php echo $oml;?></div>
                                    <?php
                                }else{
                                    ?>
                                <label>Vendor Background <span class="text-danger">*</span></label>
                                <input name="vendor_background" type="file" required="" accept=".png,.jpg,.jpeg" class="form-control imgclaslobdgbg"/>
                                <div class="imgclaslobdgbgicon"></div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <?php
                                if(is_array($view) && count($view) > 0){
                                    $fname      =   $view["vendor_profile_icon"];
                                    $target_dir =   $this->config->item("upload_dest")."modules/";
                                    $oml        =   "";
                                    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.$fname;
                                    if (file_exists($filename)) {
                                        $finame   =   base_url().$target_dir.'/'.$fname;
                                        $oml    =   "<img src='".$finame."' class='img imglogoho img-thumbnail mt-1 img-responsive'/>";
                                    }
                                    ?>
                                <label>Profile Icon </label>
                                <input name="vendor_profile_icon" type="file" accept=".png,.jpg,.jpeg" class="form-control imgclaslobdgicon"/>
                                <div class="imgsloscicon"><?php echo $oml;?></div>
                                    <?php
                                }else{
                                    ?>
                                <label>Profile Icon <span class="text-danger">*</span></label>
                                <input name="vendor_profile_icon" type="file" required="" accept=".png,.jpg,.jpeg" class="form-control imgclaslobdgicon"/>
                                <div class="imgsloscicon"></div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group"> 
                                <label>Vendor Create Profile <span class="required text-danger">*</span></label>
                                <textarea name="vendor_profile_create" type="text" class="form-control" placeholder="Enter Vendor Create" required="" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["vendor_profile_create"]:set_value("vendor_profile_create");?></textarea>
                                <?php echo form_error('vendor_profile_create');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Vendor Stage 1 <span class="required text-danger">*</span></label>
                                <select class="form-control select2" name="vendor_stage_1[]" multiple="">
                                    <option value="">Select Type</option>
                                    <?php 
                                        $viewvendor_stage_1 =   (is_array($view) && $view["vendor_stage_1"] != "")?array_filter(explode(",",$view["vendor_stage_1"])):array();
                                        foreach($vendorsubmodule_api  as $ksu => $ve){
                                        $sl     =   in_array($ksu,$viewvendor_stage_1)?"selected='selected'":set_select("vendor_stage_2",$ksu);
                                        ?>
                                        <option value="<?php echo $ksu;?>" <?php echo $sl;?>><?php echo $ve;?></option>
                                    <?php }?>
                                </select>
                                <?php echo form_error('vendorsubmodule_api');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Vendor Stage 2</label>
                                <select class="form-control select2" name="vendor_stage_2[]" multiple="">
                                    <option value="">Select Type</option>
                                    <?php 
                                        $viewvendor_stage_2 =   (is_array($view) && $view["vendor_stage_2"] != "")?array_filter(explode(",",$view["vendor_stage_2"])):array();
                                        foreach($vendorsubmodule_api  as $ksu => $ve){
                                        $sl     =   in_array($ksu,$viewvendor_stage_2)?"selected='selected'":set_select("vendor_stage_2",$ksu);
                                        ?>
                                        <option value="<?php echo $ksu;?>" <?php echo $sl;?>><?php echo $ve;?></option>
                                    <?php }?>
                                </select>
                                <?php echo form_error('vendor_stage_2');?> 
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