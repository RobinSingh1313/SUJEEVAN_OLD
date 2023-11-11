<?php 
$list = array();
if(is_array($view) && count($view) >0){
    foreach(json_decode($view['investigation_key']) as $ii){
        // echo $ii->lab_name.'<br>';
        array_push($list,$ii->lab_name);
        
    }
}
?>
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>List </label>  
                                <select title="Select Module" class="form-control select2" name="lab_name[]" multiple="">
                                    <?php 
                                    if(count($lab_test_list) > 0) {
                                        foreach($lab_test_list as $uds){
                                        ?>
                                        <option  value="<?php echo $uds->lab_test_list_name.' - '.$uds->lab_test_price;?>" <?php if(in_array($uds->lab_test_list_name,$list) || in_array($uds->lab_test_list_name.' - '.$uds->lab_test_price,$list)){echo 'selected';} ?>><?php echo $uds->lab_test_list_name.' - '.$uds->lab_test_price;?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>  
                                <input type="hidden" name="investigation_id" value="<?php echo ($view['investigation_id'])??'';?>"/>
                                <input type="hidden" name="membership_assign_id" value="<?php echo ($this->input->get('membership_assign_id'))??'';?>"/>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->
</div>

