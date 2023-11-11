<?php
$lpl	=	$quotation_image    =   '';
$lpl1	=	$quotation_image    =   '';
$dl		=	'required=""';
if(is_array($view) && count($view) > 0){
    $dl			=	'';
    $fname      =   $view["doctor_image"];
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
            <label>Doctor Name <span class="required text-danger">*</span></label>
            <input name="doctor_name" type="text" class="form-control doctor_name" placeholder="Enter Doctor Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["doctor_name"]:set_value("doctor_name");?>"/>
            <?php echo form_error('doctor_name');?> 
          </div>
        </div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Doctor Experience <span class="required text-danger">*</span></label>
            <input name="doctor_experience" type="text" class="form-control doctor_experience" placeholder="Enter Doctor Experience" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["doctor_experience"]:set_value("doctor_experience");?>"/>
            <?php echo form_error('doctor_experience');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group">
            <label>Profile Image <span class="text-danger">*</span></label>
            <input name="module_image" type="file" <?php echo $dl;?> accept=".png,.jpg,.jpeg" class="form-control imgclaslobdg"/>
            <div class="imgclaslobdg mg-t-15"><?php echo $lpl;?></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Doctor Specialization <span class="required text-danger">*</span></label>
            <input name="doctor_specialization" type="text" class="form-control doctor_specialization" placeholder="Enter Doctor Specialization" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["doctor_specialization"]:set_value("doctor_specialization");?>"/>
            <?php echo form_error('doctor_specialization');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Doctor Education <span class="required text-danger">*</span></label>
            <input name="doctor_education" type="text" class="form-control doctor_education" placeholder="Enter Doctor Education" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["doctor_education"]:set_value("doctor_education");?>"/>
            <?php echo form_error('doctor_education');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Language Known <span class="required text-danger">*</span></label>
            <input name="doctor_language" type="text" class="form-control doctor_language" placeholder="Enter Doctor Language" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["doctor_language"]:set_value("doctor_language");?>"/>
            <?php echo form_error('doctor_language');?> 
          </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>User Name <span class="required text-danger">*</span></label>
            <input name="user_name" type="text" class="form-control user_name" placeholder="Enter Doctor User Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["login_name"]:set_value("user_name");?>"/>
            <?php echo form_error('user_name');?> 
          </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Doctor Email <span class="required text-danger">*</span></label>
            <input name="email" type="text" class="form-control email" placeholder="Enter Doctor Email" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["login_email"]:set_value("email");?>"/>
            <?php echo form_error('email');?> 
          </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Password <span class="required text-danger">*</span></label>
            <input name="password" type="password" class="form-control password" placeholder="Enter Doctor Password" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?base64_decode($view["login_password"]):set_value("password");?>"/>
            <?php echo form_error('password');?> 
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