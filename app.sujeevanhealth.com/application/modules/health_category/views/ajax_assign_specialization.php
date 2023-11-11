<?php
$sr     =   $this->session->userdata("active-deactive-health-category");
$ur     =   $this->session->userdata("update-health-category");
$dr     =   $this->session->userdata("delete-health-category");
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
                <th><a href="javascript:void(0);" data-type="order" data-field="specialization_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Specialization <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="healthcategory_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Health Category <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="healthsubcategory_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Health Sub Category <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $category_id  =   $ve["id"];
                   
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["specialization_name"];?></td>
                <td><?php echo $ve["healthcategory_name"];?></td>
                <td><?php echo $ve["healthsubcategory_name"];?></td>
                <?php if($ct == '1'){?>
                <td> 
                    
                   
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Assign-Specialization/".$ve['id']);?>' data-toggle='tooltip-primary' title="Update Assign Specialization" class="text-success tip-left"><i class="fa fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Specialization')"  data-toggle='tooltip-primary' title="Delete Assign Specialization"  attrvalue="<?php echo adminurl("Delete-Assign-Specialization/".$ve['id']);?>" class="text-danger tip-left"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                </td>
               
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Categories are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>
