<?php
$lpl	=	$quotation_image    =   '';
$dl		=	'required=""';
if(is_array($view) && count($view) > 0){
    $dl			=	'';
    $fname      =   $view["package_image"];
    $target_dir =   $this->config->item("upload_dest")."homecare/";
    $oml        =   $quotation_image    =   base_url()."uploads/image_not_available.png";
    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
    if (file_exists($filename)) {
        $oml   	=   base_url().$target_dir.'/'.$fname;
      	$lpl	=	'<img src="'.$oml.'" class="img img-responsive"/>';
    }
    $quotation_imagefname      =   $view["quotation_image"];
    $target_dir =   $this->config->item("upload_dest")."homecare/"; 
    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$quotation_imagefname;
    if (file_exists($filename)) {
        $oml   	=   base_url().$target_dir.'/'.$quotation_imagefname;
      	$quotation_image	=	'<img src="'.$oml.'" class="img img-responsive"/>';
    }
}
?>
<div class="card mg-b-10">
  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
      <h6 class="card-title tx-uppercase tx-12 mg-b-0"><?php echo $til;?></h6>
    </div>
  <div class="card-body">
    <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <input type="hidden" name="package_id" class="package_id" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_id"]:"";?>"/>
            <label>Package Name <span class="required text-danger">*</span></label>
            <input name="package_name" type="text" class="form-control package_name" placeholder="Enter Package Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["package_name"]:set_value("package_name");?>"/>
            <?php echo form_error('package_name');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group">
            <label>Upload Image <span class="text-danger">*</span></label>
            <input name="module_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
            <div class="imgclaslobdg mg-t-15"><?php echo $lpl;?></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Quotation By <span class="required text-danger">*</span></label>
            <input name="quotation_by" type="text" class="form-control" placeholder="Enter Quotation By" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["quotation_by"]:set_value("quotation_by");?>"/>
            <?php echo form_error('quotation_by');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group">
            <label>Quotation <span class="text-danger">*</span></label>
            <textarea name="quotation" type="text" class="form-control" placeholder="Enter Quotation" required="" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["quotation"]:set_value("quotation");?></textarea>
            <?php echo form_error('quotation');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group">
            <label>Banner Image <span class="text-danger">*</span></label>
            <input name="quotation_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdgicon"/>
            <div class="imgsloscicon mg-t-15"><?php echo $quotation_image;?></div>
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
  </div>
</div>