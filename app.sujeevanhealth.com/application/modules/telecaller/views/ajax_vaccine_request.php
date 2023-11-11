<?php
$sr     =   $this->session->userdata("active-deactive-module");
$ur     =   $this->session->userdata("update-module");
$ct     =   "0";
if($ur  == 1 || $sr == 1){
        $ct     =   1;
}
?>
<div class="table-responsive"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>`
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="vaccine_request_for" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Registered For <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="vaccine_request_mobile" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Mobile <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="vaccine_request_age" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Age <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="vaccine_request_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="vaccine_request_on" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Date <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve->vaccine_request_for;?></td>
                <td><?php echo $ve->vaccine_request_mobile;?></td>
                <td><?php echo $ve->vaccine_request_age;?></td>
                <td><?php echo $ve->vaccine_request_name;?></td>
                <td><?php echo $ve->vaccine_request_on;?></td>
                <td>
                    <select class="form-control" onchange="vaccine_request_status('<?php echo $ve->vaccine_request_id;?>')" id="statt<?php echo $ve->vaccine_request_id;?>">
                        <option value="">Select Status</option>
                        <option value="Not Called" <?php if($ve->vaccine_request_status=="Not Called"){echo 'selected';}?>>Not Called</option>
                        <option value="Called" <?php if($ve->vaccine_request_status=="Called"){echo 'selected';}?>>Called</option>
                    </select>
                </td>
                
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Registers are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 

<?php echo $this->ajax_pagination->create_links();?>