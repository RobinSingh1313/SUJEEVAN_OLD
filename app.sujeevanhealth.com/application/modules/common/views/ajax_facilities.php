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
                <th><a href="javascript:void(0);" data-type="order" data-field="facilites_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="facilites_description" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Description <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="facilities_images" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Image <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <!--<th>Action</th>-->
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $packages_id  =   $ve["facilites_id"];
                    $fname      =   $ve["facilites_images"];
                    $target_dir =   $this->config->item("upload_dest")."products/";
                    if($fname != ""){
                        $oml        =   base_url()."uploads/image_not_available.png";
                        $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
                        if (file_exists($filename)) {
                            $oml   =   base_url().$target_dir.'/'.$fname;
                        }
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["facilites_name"];?></td>
                <td><?php echo $ve["facilites_description"];?></td>
                <td>
                    <?php if($fname != "") { ?>
                    <img src="<?php echo $oml;?>" class="img img-responsive" height="50px"/>
                    <?php } ?>
                </td>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> packages are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>