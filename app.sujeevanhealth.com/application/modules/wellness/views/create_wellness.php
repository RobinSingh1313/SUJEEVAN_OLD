<?php
$lpl	=	$quotation_image    =   '';
$lpl1	=	$quotation_image    =   '';
$dl		=	'required=""';
if(is_array($view) && count($view) > 0){
    $dl			=	'';
    $fname      =   $view["wellness_image"];
    $target_dir =   $this->config->item("upload_dest")."homecare/";
    $oml        =   $quotation_image    =   base_url()."uploads/image_not_available.png";
    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
    if (file_exists($filename)) {
        $oml   	=   base_url().$target_dir.'/'.$fname;
      	$lpl	=	'<img src="'.$oml.'" class="img img-responsive"/>';
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
            <label>Wellness Title <span class="required text-danger">*</span></label>
            <input name="wellness_name" type="text" class="form-control wellness_name" placeholder="Enter Wellness Title" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["wellness_name"]:set_value("wellness_name");?>"/>
            <?php echo form_error('wellness_name');?> 
          </div>
        </div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Wellness Description <span class="required text-danger">*</span></label>
            <input name="wellness_description" type="text" class="form-control wellness_description" placeholder="Enter Wellness Description" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["wellness_description"]:set_value("wellness_description");?>"/>
            <?php echo form_error('wellness_description');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group">
            <label>Thumbnail Image <span class="text-danger">*</span></label>
            <input name="module_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
            <div class="imgclaslobdg mg-t-15"><?php echo $lpl;?></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group">
            <label>Main Image <span class="text-danger">*</span></label>
            <input name="main_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdgicon"/>
            <div class="imgsloscicon mg-t-15"><?php echo $lpl;?></div>
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