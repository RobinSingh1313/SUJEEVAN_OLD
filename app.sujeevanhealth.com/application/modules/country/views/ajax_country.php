<?php
$sr     =   $this->session->userdata("active-deactive-country");
$cr     =   $this->session->userdata("create-country");
$ur     =   $this->session->userdata("update-country");
$dr     =   $this->session->userdata("delete-country");
$ageurl     =   $this->session->userdata("arr".$pageurl);
$ar         =   $dar    =   (is_array($ageurl) && array_key_exists("offset", $ageurl))?$ageurl["offset"]:"0";
$ct     =   "0";
if($ur  == 1 || $dr == '1' || $sr == 1){
        $ct     =   1;
}
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
                <th><a href="javascript:void(0);" data-type="order" data-field="country_name" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Country Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_currency" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Currency <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_code" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Country Code <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_employee_prefix" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Employee Prefix <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_trip_prefix" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Trip Prefix <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_piligrim_prefix" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Pilgirm Prefix <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_piligrimrelative_prefix" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Relative Prefix <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_timezone" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Time Zone <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="country_acde" urlvalue="<?php echo adminurl('viewCountry/');?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $vad    =   ucwords($ve->country_acde);
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
                <td><?php echo $ve->country_name;?></td>
                <td><?php echo $ve->country_currency;?></td>
                <td><?php echo $ve->country_code;?></td>
                <td><?php echo $ve->country_employee_prefix;?></td>
                <td><?php echo $ve->country_trip_prefix;?></td>
                <td><?php echo $ve->country_piligrim_prefix;?></td>
                <td><?php echo $ve->country_piligrimrelative_prefix;?></td>
                <td><?php echo $ve->country_timezone;?></td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Country-Active','<?php echo $ar;?>')" fields="<?php echo $ve->country_id;?>" data-toggle='tooltip' title="<?php echo $vadv;?>" titlevalue="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Country/".$ve->country_id);?>' data-toggle='tooltip' title="Update Country" class="text-success mh-sm"><i class="fa fa-edit"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Country','<?php echo $dar;?>')"  data-toggle='tooltip' attrvalue="<?php echo adminurl("Delete-Country/".$ve->country_id);?>"   title="Delete Country" class="text-danger"><i class="fa fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Countries are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>
<script>
    dod();
</script>