<?php
$lpl	=	'';
$dl		=	'required=""';
if(is_array($view) && count($view) > 0){
  	$dl			=	'';
    $fname      =   $view["homecaretest_image"];
    $target_dir =   $this->config->item("upload_dest")."homecare/";
    $oml        =   base_url()."uploads/image_not_available.png";
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
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
          <div class="form-group">
              <input type="hidden" value="<?php echo (is_array($view) && count($view) > 0)?$view["homecaretest_id"]:'';?>" name="homecaretest_id" class="homecaretest_id"/>
            <label>Test Name <span class="required text-danger">*</span></label>
            <input name="test_name" type="text" class="form-control test_name" placeholder="Enter Test Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["homecaretest_name"]:set_value("test_name");?>"/>
            <?php echo form_error('test_name');?> 
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
          <div class="form-group">
            <label>Actual Price <span class="required text-danger">*</span></label>
            <input name="actual_price" type="text" class="form-control input_geo" placeholder="Enter Actual Price" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["homecaretest_actual_price"]:set_value("actual_price");?>"/>
            <?php echo form_error('actual_price');?> 
          </div>
        </div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
          <div class="form-group">
            <label>Offer Price <span class="required text-danger">*</span></label>
            <input name="offer_price" type="text" class="form-control input_geo" placeholder="Enter Offer Price" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["homecaretest_offer_price"]:set_value("offer_price");?>"/>
            <?php echo form_error('offer_price');?> 
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
          <div class="form-group">
            <label>Upload Image <span class="text-danger">*</span></label>
            <input name="module_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
            <div class="imgslosc mg-t-15"><?php echo $lpl;?></div>
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