<?php
$sr     =   $this->session->userdata("active-deactive-health-category");
$ur     =   $this->session->userdata("update-health-category");
$dr     =   $this->session->userdata("delete-health-category");
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
                <th><a href="javascript:void(0);" data-type="order" data-field="healthcategory_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="module_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Module <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="healthcategory_image" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Image <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="healthcategory_acde" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $category_id  =   $ve["healthcategory_id"];
                    $vad        =   ucwords($ve["healthcategory_acde"]);
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
                     $fname      =   $ve["healthcategory_image"];
                    $target_dir =   $this->config->item("upload_dest")."healthcategory/";
                    $oml        =   base_url()."uploads/image_not_available.png";
                    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
                    if ($fname != "") {
                        $oml   =   base_url().$target_dir.'/'.$fname;
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["healthcategory_name"];?></td>
                <td><?php echo $ve["module_name"];?></td>
                <td> <img src="<?php echo $oml;?>" class="img imglogoho img-responsive"/> </td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Health-Category-Active')" fields="<?php echo $category_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Health-Category/".$category_id);?>' data-toggle='tooltip-primary' title="Update Category" class="text-success tip-left"><i class="fa fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Category')"  data-toggle='tooltip-primary' title="Delete Category"  attrvalue="<?php echo adminurl("Delete-Health-Category/".$category_id);?>" class="text-danger tip-left"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Categories are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>
