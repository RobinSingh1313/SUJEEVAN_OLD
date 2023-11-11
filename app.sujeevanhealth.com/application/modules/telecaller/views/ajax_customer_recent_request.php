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
                <th><a href="javascript:void(0);" data-type="order" data-field="register_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_email" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Email <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_mobile" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Mobile <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="module_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Module <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="sub_module_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Sub Module <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="homecare_chat_response_cr_on" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Submitted Date<i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                
                <td>
                    <a class="user<?php echo $ve->homecare_chat_responseid;?>" onclick="user_history_new('<?php echo $ve->registration_id;?>','<?php echo $ve->homecare_chat_responseid;?>','<?php echo $ve->moduleid;?>')"><?php echo $ve->register_name;?></a>
                    <div class="loader<?php echo $ve->homecare_chat_responseid;?>" style="display:none;"></div>
                </td>
                <td><?php echo $ve->register_email;?></td>
                <td><?php echo $ve->register_mobile;?></td>
                <td><?php echo $ve->module_name;?></td>
                <td><?php echo $ve->sub_module_name;?></td>
                <td><?php echo $ve->homecare_chat_response_cr_on;?></td>
                
                
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

        <div id="modaldemo6" class="modal fade">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content bd-0 bg-transparent rounded overflow-hidden" id="user_history">
                
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->