<?php
$sr     =   $this->session->userdata("active-deactive-registration");
$ur     =   $this->session->userdata("update-registration");
$dr     =   $this->session->userdata("delete-registration");
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
                <th><a href="javascript:void(0);" data-type="order" data-field="user_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="user_mobile" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Mobile <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="user_email" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Email <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="otp_verification" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Otp<i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="user_login_status" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Login Status<i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="user_status" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $registration_id  =   $ve["user_id"];
                    $vad        =   ucwords($ve["user_acde"]);
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
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["user_name"];?></td>
                <td><?php echo $ve["user_mobile"];?></td>
                <td><?php echo $ve["user_email"];?></td>
                <td><?php echo ($ve["otp_verification"]==1)?'Verified':'not Verified';?></td>
                <td><?php echo ($ve["user_login_status"]==1)?'Logged In':'not Logged In';?></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Registration-Active')" fields="<?php echo $registration_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Registration')"  data-toggle='tooltip-primary' title="Delete Registration"  attrvalue="<?php echo adminurl("Delete-Registration/".$registration_id);?>" class="text-danger tip-left"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Registrations are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>
