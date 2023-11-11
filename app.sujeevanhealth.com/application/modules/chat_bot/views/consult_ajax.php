<?php
$sr     =   $this->session->userdata("active-deactive-consult-chat-bot");
$cr     =   $this->session->userdata("create-consult-chat-bot");
$ur     =   $this->session->userdata("update-consult-chat-bot");
$dr     =   $this->session->userdata("delete-consult-chat-bot");
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
                <th><a href="javascript:void(0);" data-type="order" data-field="healthcategory_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Health Category <i class="fas font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="healthsubcategory_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Health Sub Category <i class="fas font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="consult_question" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Question <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="consult_options" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Options <i class="fas font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="consult_acde" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $vebotauto_id  =   $ve["consult_id"];
                    $vad    =   ucwords($ve["consult_acde"]);
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
                <td><?php echo $ve["healthcategory_name"];?></td>
                <td><?php echo $ve['healthsubcategory_name'];?></td>
                <td><?php echo $ve["consult_question"];?></td>
                <td><?php 
                    $csp    =   array_filter(explode(",",$ve["consult_options"]));
                    foreach ($csp as $ved){
                        echo "<span class='label label-info mr-1'>".$ved."</span>";
                    }
                ?></div></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Chat-Consult-Active')" fields="<?php echo $vebotauto_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-ConsultChat-Bot/".$vebotauto_id);?>' data-toggle='tooltip' data-original-title="Update Consult Chat Bot" class="text-success tip-left"><i class="fas fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Consult Chat Bot','<?php echo $dar;?>')"  data-toggle='tooltip' attrvalue="<?php echo adminurl("Delete-ConsultChat-Bot/".$vebotauto_id);?>"   data-original-title="Delete Chat Bot" class="text-danger"><i class="fas fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fas fa-info-circle"></i> Chat Bots are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>