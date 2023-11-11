
<style>
    .tablehrcover th, .tablehrcover td{
        vertical-align: middle;
    }
</style>
<div class="table-responsive"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_first_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">First Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_last_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Last Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_mobile" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Mobile <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_email" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Email <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_msg" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Message<i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_created_by" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Submitted By <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="wellness_contact_created_on" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Submitted On <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                   
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["wellness_contact_first_name"];?></td>
                <td><?php echo $ve["wellness_contact_last_name"];?></td>
                <td><?php echo $ve["wellness_contact_mobile"];?></td>
                <td><?php echo $ve["wellness_contact_email"];?></td>
                <td>
                    <div style='width:400px'>
                        <?php echo $ve["wellness_contact_msg"];?>
                    </div>
                </td>
                <td><?php echo $ve["wellness_contact_created_by"];?></td>
                <td><?php echo $ve["wellness_contact_created_on"];?></td>
                
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Contact us requests are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>
