<?php
$sr     =   $this->session->userdata("active-deactive-homecare-packages");
$ur     =   $this->session->userdata("update-homecare-packages");
$dr     =   $this->session->userdata("delete-homecare-packages");
$ct     =   "0";
if($ur  == 1 || $sr == 1){
        $ct     =   1;
}
?>
<div class="table-responsive"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="package_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Package <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="package_image" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Image <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="package_acde" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $blog_id  =   $ve["package_id"];
                    $vad        =   ucwords($ve["package_acde"]);
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
                    $fname      =   $ve["package_image"];
                    $target_dir =   $this->config->item("upload_dest")."homecare/";
                    $oml        =   base_url()."uploads/image_not_available.png";
                    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
                    if (file_exists($filename)) {
                        $oml   =   base_url().$target_dir.'/'.$fname;
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["package_name"];?></td>
              	<td>
                    <img src="<?php echo $oml;?>" class="img img-responsive"/>
              	</td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Home-Packages-Active')" fields="<?php echo $blog_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Home-Packages/".$blog_id);?>' data-toggle='tooltip-primary' title="Update Home Packages" class="text-success tip-left"><i class="fa fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Home Packages')"  data-toggle='tooltip-primary' title="Delete Home Packages"  attrvalue="<?php echo adminurl("Delete-Home-Packages/".$blog_id);?>" class="text-danger tip-left"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Home care packages are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>