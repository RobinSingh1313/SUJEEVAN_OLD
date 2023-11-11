<?php 
$configss = array("0" => "Seconds","1" => "Minutes","2" => "Hours","3" => "Days")
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Time</label>  
                                <input type="number" class="form-control" name="book_appointment_time" value="<?= $time_slot['book_appointment_time'] ?>" placeholder="Enter Time For Book appointment slots"/>
                                
                            </div>
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Type</label>  
                                <select title="Select Module" class="form-control select2" name="book_appointment_time_type">
                                    <?php 
                                    if(count($configss) > 0) {
                                        foreach($configss as $key=>$val){
                                        ?>
                                        <option  value="<?php echo $key;?>" <?php if($key == $time_slot['book_appointment_time_type']){echo 'selected';} ?>><?php echo $val;?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>  
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