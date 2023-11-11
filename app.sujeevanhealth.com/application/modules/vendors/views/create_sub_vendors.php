<?php
$lpl	=	$valueatr   = $ddl  =   '';
$dl	=	'required=""';
if(is_array($view) && count($view) > 0){
    $valueatr   =	$view["vendorsubmodule_vendor_id"];
    $ddl		=	'vedgincmoere';
    $dl =   "";
}
$vendorsubmodule_api    =   $this->config->item("module_api");
?>
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
                                <label>Vendor <span class="required text-danger">*</span></label>
                                <select class="vendorSelect <?php echo $ddl;?> form-control" valueatr="<?php echo $valueatr;?>" name="vendor" <?php echo $dl;?>></select>
                                <?php echo form_error('vendor');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Vendor <span class="required text-danger">*</span></label>
                                <select class="form-control" name="vendorsubmodule_api" <?php echo $dl;?>>
                                    <option value="">Select Type</option>
                                    <?php foreach($vendorsubmodule_api  as $ksu => $ve){?>
                                        <option value="<?php echo $ksu;?>" <?php echo (is_array($view) && $view["vendorsubmodule_api"] == $ksu)?"selected='selected'":set_select("vendorsubmodule_api",$ksu);?>><?php echo $ve;?></option>
                                    <?php }?>
                                </select>
                                <?php echo form_error('vendorsubmodule_api');?> 
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Sub Vendor Name <span class="required text-danger">*</span></label>
                                <input name="sub_vendor_name" type="text" class="form-control vendor_name" placeholder="Enter Sub Vendor" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vendorsubmodule_name"]:set_value("sub_vendor_name");?>"/>
                                <?php echo form_error('sub_vendor_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
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