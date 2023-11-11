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
                <th><a href="javascript:void(0);" data-type="order" data-field="customer_support_email" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Registered Mail <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="customer_support_mobile" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Mobile <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="customer_support_status" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="customer_support_response" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Response <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve->customer_support_email;?></td>
                <td><?php echo $ve->customer_support_mobile;?></td>
                <td>
                    <select class="form-control" onchange="customer_request_status('<?php echo $ve->customer_support_id;?>')" id="statt<?php echo $ve->customer_support_id;?>">
                        <option value="">Select Status</option>
                        <option value="Not Called" <?php if($ve->customer_support_status=="Not Called"){echo 'selected';}?>>Not Called</option>
                        <option value="Called" <?php if($ve->customer_support_status=="Called"){echo 'selected';}?>>Called</option>
                    </select>
                </td>
                <td>
                    <textarea class="from-control"  id="contact_response<?php echo $ve->customer_support_id;?>"><?php echo $ve->customer_support_response;?></textarea> 
                    <a onclick="update_contact_response('<?php echo $ve->customer_support_id;?>');" class="btn btn-success" style="color:white">Update</a>
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