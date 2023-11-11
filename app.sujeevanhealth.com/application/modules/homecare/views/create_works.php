<?php
$lpl	=	$quotation_image    =   '';
$dl		=	'required=""';
if(is_array($view) && count($view) > 0){
    $dl			=	'';
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
            <label>Package <span class="required text-danger">*</span></label>
            <select class="form-control select2" name="package_id" <?php echo $dl;?>>
                <option value="">Select Title</option>
                <?php 
                if(is_array($pkgs) && count($pkgs) > 0){
                    foreach($pkgs as $ve){
                        $package_id =   $ve["package_id"];
                        ?>
                <option value="<?php echo $package_id;?>" <?php echo (is_array($view) && count($view) > 0 && $view["item_package_id"] == $package_id)?"selected=selected":set_select("package_id",$package_id);?>><?php echo $ve["package_name"];?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <?php echo form_error('package_id');?> 
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
          <div class="form-group">
            <label>Item <span class="required text-danger">*</span></label>
            <input name="package_item" type="text" class="form-control package_item" placeholder="Enter Item" <?php echo $dl;?> autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["item_package_item"]:set_value("package_item");?>"/>
            <?php echo form_error('package_item');?> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ternsconfition">
            <?php  
            if(is_array($vissp) && count($vissp) > 0){ 
                foreach ($vissp as $ckl => $ver){
                ?>
            <div class='mtop-10 form-group row rowtval<?php echo $ckl;?>'>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                    <label>Sub Item <span class="required text-danger">*</span></label>
                    <input type="hidden" name="termid[<?php echo $ckl;?>]" value="<?php echo $ver["subitem_id"];?>"/>
                    <input class="form-control" value="<?php echo $ver["subitem_name"];?>" name="item[<?php echo $ckl;?>]" placeholder="Item Name" <?php echo $dl;?>/>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                    <label>Quantity</label>
                    <input class="form-control" value="<?php echo $ver["subitem_quantity"];?>" name="quantity[<?php echo $ckl;?>]" placeholder="Quantity"/>
                </div>
                <?php if($ckl > 0) { ?>
                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-12'><a onclick='removeterms("<?php echo $ckl;?>")' class='text-danger'><i class='fa fa-trash '></i></a></div>
                <?php } ?>
            </div>
                <?php
                }
            }else{
                ?>
            <div class='mtop-10 form-group row rowtval0'>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                    <label>Sub Item <span class="required text-danger">*</span></label>
                    <input type="hidden" name="termid[0]" value="0"/>
                    <input class="form-control" name="item[0]" placeholder="Item Name" <?php echo $dl;?>/>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                    <label>Quantity</label>
                    <input class="form-control" name="quantity[0]" placeholder="Quantity"/>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <div class="float-right"> 
                <a href="javascript:void(0);" onclick="addvlauepes()" class="btn btn-sm btn-primary btn_termsattr" payattr="1">Add Sub Item</a>
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