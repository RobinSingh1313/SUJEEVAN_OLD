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
                <th><a href="javascript:void(0);" data-type="order" data-field="cr_by" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Email <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="regvendor_id" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Vendor Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="vendor_id" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Type <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="date" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Date <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="timeslot" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Timeslot <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="fee" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Fee <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
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
                <td><?php echo $ve->cr_by;?></td>
                <td><?php echo $ve->regvendor_id;?></td>
                <td><?php echo $ve->vendor_id;?></td>
                <td><?php echo $ve->date;?></td>
                <td><?php echo $ve->timeslot;?></td>
                <td><?php echo $ve->fee;?></td>
                <td>
                    <select class="form-control" onchange="bookappointment_request_status('<?php echo $ve->bookappointment_request_id;?>')" id="statt<?php echo $ve->bookappointment_request_id;?>">
                        <option value="">Select Status</option>
                        <option value="Not Called" <?php if($ve->bookappointment_request_status=="Not Called"){echo 'selected';}?>>Not Called</option>
                        <option value="Called" <?php if($ve->bookappointment_request_status=="Called"){echo 'selected';}?>>Called</option>
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