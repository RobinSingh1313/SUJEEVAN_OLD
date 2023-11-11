<?php
$sr     =   $this->session->userdata("active-deactive-chat-room");
$cr     =   $this->session->userdata("create-chat-room");
$ur     =   $this->session->userdata("update-chat-room");
$dr     =   $this->session->userdata("delete-chat-room");
$ct     =   "0";
if($ur  == 1 || $dr == '1' || $sr == 1){
        $ct     =   1;
}
$ageurl     =   $this->session->userdata("arr".$pageurl);
$ar         =   $dar    =   (is_array($ageurl) && array_key_exists("offset", $ageurl))?$ageurl["offset"]:"0";
if($totalrows > 1){
    if($totalrows == $dar){
        $dar     =   $totalrows-1;
    }
}
?>
<div class="table-responsive"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="complaintlog_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Room <i class="fas font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="complaintlog_user" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">User <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="complaintlog_loginname" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Login Name <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="complaintlog_password" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Password <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="complaintlog_languages" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Languages <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="region_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Regions <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="complaintlog_acde" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $vecomplaintlog_id  =   $ve["complaintlog_id"];
                    $vad    =   ucwords($ve["complaintlog_acde"]);
                    if($vad == "Active"){
                        $icon   =   "times";
                        $vadv   =   "Deactive";
                        $textico    =   "text-warning";
                        $vdata  =   "<label class='badge abelsctive badge-success'>".$vad."</label>";
                    }else{
                        $vdata  =   "<label class='badge abelsctive badge-danger'>".$vad."</label>";
                        $vadv   =   "Active";
                        $textico    =   "text-primary";
                        $icon   =   "check";
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["complaintlog_name"];?></td>
                <td><?php echo $ve["complaintlog_user"];?></td>
                <td><?php echo $ve["complaintlog_loginname"];?></td>
                <td><?php echo $ve["complaintlog_password"];?></td>
                <td><?php echo $ve["complaintlog_languages"];?></td>
                <td><?php echo $ve["region_name"];?></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Chat-Room-Active','<?php echo $ar;?>')" fields="<?php echo $vecomplaintlog_id;?>" data-toggle='tooltip' title="<?php echo $vadv;?>"><i class="fas fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Chat-Room/".$vecomplaintlog_id);?>' data-toggle='tooltip' data-original-title="Update Room Configuration" class="text-success tip-left"><i class="fas fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Room Configuration','<?php echo $dar;?>')"  data-toggle='tooltip' attrvalue="<?php echo adminurl("Delete-Chat-Room/".$vecomplaintlog_id);?>"   data-original-title="Delete Room Configuration" class="text-danger"><i class="fas fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="10"><i class="fas fa-info-circle"></i> Complaints Logs are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>