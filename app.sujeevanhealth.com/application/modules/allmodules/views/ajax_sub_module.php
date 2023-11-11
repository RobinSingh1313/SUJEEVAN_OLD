<?php
$sr     =   $this->session->userdata("active-deactive-sub-module");
$ur     =   $this->session->userdata("update-sub-module");
$dr     =   $this->session->userdata("delete-sub-module");
$ct     =   "0";
if($ur  == 1 || $sr == 1){
        $ct     =   1;
}
?>
<div class="row">
  	<?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $sub_module_id  =   $ve["sub_module_id"];
                    $vad        =   ucwords($ve["sub_module_acde"]);
                    if($vad == "Active"){
                        $icon   =   "times-circle";
                        $vadv   =   "Deactive";
                        $textico    =   "text-warning";
                        $vdata  =   "<label class='label label-success'>".$vad."</label>";
                    }else{
                        $vdata  =   "<label class='label  label-danger'>".$vad."</label>";
                        $vadv   =   "Active";
                        $textico    =   "text-primary";
                        $icon       =   "check-circle";
                    }
                    $fname      =   $ve["sub_module_image"];
                    $target_dir =   $this->config->item("upload_dest")."modules/";
                    $oml        =   base_url()."uploads/image_not_available.png";
                    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
                    if (file_exists($filename)) {
                        $oml   =   base_url().$target_dir.'/'.$fname;
                    }
            ?>
  	<div class="col-sm-3 col-md-3 col-lg-3 mb-3">
      	<div class="card-header">
        	<?php echo $ve["sub_module_name"];?>  
      	</div>
    	<div class="card-body">
        	<img src="<?php echo $oml;?>" class="img img-responsive" height="100px"/>
      	</div>  
      	<div class="card-footer">
          	<?php echo $vdata;?>
            <?php if($sr == '1'){?>
            <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Sub-Module-Active')" fields="<?php echo $sub_module_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?>"></i></a>
            <?php } if($ur == '1'){?>
            <a href='<?php echo adminurl("Update-Sub-Module/".$sub_module_id);?>' data-toggle='tooltip-primary' title="Update Sub Module" class="text-success tip-left"><i class="fa fa-edit m-l-5 m-r-5"></i></a>
            <?php } if($dr == '1'){?>
            <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Sub-Module')"  data-toggle='tooltip-primary' title="Delete Sub Module"  attrvalue="<?php echo adminurl("Delete-Sub-Module/".$sub_module_id);?>" class="text-danger tip-left"><i class="fa fa-trash"></i></a>
            <?php } ?>  
      	</div>
  	</div>
  		<?php } 
   }?>
</div>
<div class="row">
  <div class="col-lg-12 m-t-10">
    	<?php echo $this->ajax_pagination->create_links();?>
  </div>
</div>