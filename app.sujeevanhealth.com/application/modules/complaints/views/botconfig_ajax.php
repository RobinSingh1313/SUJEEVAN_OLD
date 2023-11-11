<?php
$sr     =   $this->session->userdata("active-deactive-chat-bot");
$cr     =   $this->session->userdata("create-chat-bot");
$ur     =   $this->session->userdata("update-chat-bot");
$dr     =   $this->session->userdata("delete-chat-bot");
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
                <th><a href="javascript:void(0);" data-type="order" data-field="botauto_tags" urlvalue="<?php echo adminurl('viewBotconfig/');?>" onclick="getdatafiled($(this))">Tags <i class="fas font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="botauto_answer" urlvalue="<?php echo adminurl('viewBotconfig/');?>" onclick="getdatafiled($(this))">Answer <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>    
                <th><a href="javascript:void(0);" data-type="order" data-field="botauto_acde" urlvalue="<?php echo adminurl('viewBotconfig/');?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-amount-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $vebotauto_id  =   $ve["botautotag_id"];
                    $vad    =   ucwords($ve["botauto_acde"]);
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
                <td><?php 
                    $csp    =   array_filter(explode(",",$ve["botauto_tags"]));
                    foreach ($csp as $ved){
                        echo "<span class='label label-info mr-1'>".$ved."</span>";
                    }
                ?></div></td>
                <td><?php echo $ve["botauto_answer"];?></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-bot-Active')" fields="<?php echo $vebotauto_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-bot/".$vebotauto_id);?>' data-toggle='tooltip' data-original-title="Update Chat Bot" class="text-success tip-left"><i class="fas fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Chat Bot','<?php echo $dar;?>')"  data-toggle='tooltip' attrvalue="<?php echo adminurl("Delete-bot/".$vebotauto_id);?>"   data-original-title="Delete Chat Bot" class="text-danger"><i class="fas fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="5"><i class="fas fa-info-circle"></i> Chat Bots are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>