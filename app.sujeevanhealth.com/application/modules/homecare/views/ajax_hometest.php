<?php
$sr     =   $this->session->userdata("active-deactive-homecare-tests");
$ur     =   $this->session->userdata("update-homecare-tests");
$dr     =   $this->session->userdata("delete-homecare-tests");
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
                <th><a href="javascript:void(0);" data-type="order" data-field="homecaretest_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Test Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="homecaretest_actual_price" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Actual Price<i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="homecaretest_offer_price" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Offer Price<i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="homecaretest_acde" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $blog_id  =   $ve["homecaretest_id"];
                    $vad        =   ucwords($ve["homecaretest_acde"]);
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
                <td><?php echo $ve["homecaretest_name"];?></td>
                <td><?php echo $ve["homecaretest_actual_price"];?></td>
                <td><?php echo $ve["homecaretest_offer_price"];?></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Home-Tests-Active')" fields="<?php echo $blog_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Home-Tests/".$blog_id);?>' data-toggle='tooltip-primary' title="Update Home Tests" class="text-success tip-left"><i class="fa fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Home Tests')"  data-toggle='tooltip-primary' title="Delete Home Tests"  attrvalue="<?php echo adminurl("Delete-Home-Tests/".$blog_id);?>" class="text-danger tip-left"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Home Care Tests are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>