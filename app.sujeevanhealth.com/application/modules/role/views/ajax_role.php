<?php
$sr     =   $this->session->userdata("active-deactive-role");
$cr     =   $this->session->userdata("create-role");
$ur     =   $this->session->userdata("update-role");
$dr     =   $this->session->userdata("delete-role");
$ageurl     =   $this->session->userdata("arr".$pageurl);
$ar       =   (is_array($ageurl) && array_key_exists("offset", $ageurl))?$ageurl["offset"]:"0";
$ct     =   "0";
if($ur  == 1 || $dr == '1' || $sr == 1){
        $ct     =   1;
}
if($totalrows > 1){
    if($totalrows == $ar){
        $ar     =   $totalrows-1;
    }
}
?>
<div class="table-responsive"> 
    <table class="table table-striped table-hover table-borderless" id="myTable">
        <thead>
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="ut_name" urlvalue="<?php echo adminurl('viewRole/');?>" onclick="getdatafiled($(this))">Role Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="ut_acde" urlvalue="<?php echo adminurl('viewRole/');?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $vad    =   ucwords($ve->ut_acde);
                    if($vad == "Active"){
                        $icon   =   "times";
                        $vadv   =   "Deactive";
                        $textico    =   "text-warning";
                        $vdata  =   "<label class='label label-success'>".$vad."</label>";
                    }else{
                        $vdata  =   "<label class='label label-danger'>".$vad."</label>";
                        $vadv   =   "Active";
                        $textico    =   "text-primary";
                        $icon   =   "check";
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve->ut_name;?></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Role-Active','<?php echo $ar;?>')" fields="<?php echo $ve->ut_id;?>" data-toggle='tooltip' title="<?php echo $vadv;?>" titlevalue="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> mg-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Role/".$ve->ut_id);?>' data-toggle='tooltip-primary' title="Update Role" class="text-success mh-sm"><i class="fa fa-edit mg-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Role','<?php echo $ar;?>')" attrvalue="<?php echo adminurl("Delete-Role/".$ve->ut_id);?>"  data-toggle="tooltip-primary" data-placement="top" title="Delete Role" class="text-danger"><i class="fa fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="5"><i class="fa fa-info-circle"></i> Roles are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>