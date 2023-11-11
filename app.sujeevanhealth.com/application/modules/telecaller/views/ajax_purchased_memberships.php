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
                <th><a href="javascript:void(0);" data-type="order" data-field="register_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">User Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="membership_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Package Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="membership_amount" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Package Price <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="membership_valid_upto" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Package valid <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="membership_purchase_on" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Package Purchased On <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $registration_id  =   $ve["registration_id"];
                    $vad        =   ucwords($ve["register_acde"]);
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
                <td><a class="user<?php echo $ve["registration_id"];?>" onclick="user_history_mempur('<?php echo $ve["registration_id"];?>','<?php echo $ve["membership_purchase_id"];?>')"><?php echo $ve["register_name"];?></a>
                <div class="loader<?php echo $ve["membership_purchase_id"];?>" style="display:none;">
                    
                </div>
                
                </td>
                <td><?php echo $ve["membership_name"];?></td>
                <td><?php echo $ve["membership_amount"];?></td>
                <td><?php echo $ve["membership_valid_upto"];?></td>
                <td><?php echo $ve["membership_purchase_on"];?></td>
                
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