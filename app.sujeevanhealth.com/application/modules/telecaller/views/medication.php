
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <?php 
                            $list = array();
                            if(is_array($view) && count($view) >0){
                                foreach(json_decode($view['medication_key']) as $ii){ ?>
                                    
                                    <div class="col-md-6">
                                        <p> DosageForm : <?php echo $ii->DosageForm?><br>
                                        Dose : <?php echo $ii->Dose; ?><br>
                                        Duration : <?php echo $ii->Duration; ?><br>
                                        Frequency : <?php echo $ii->Frequency; ?><br>
                                        Instructions : <?php echo $ii->Instructions; ?><br>
                                        Quantity : <?php echo $ii->Quantity; ?><br>
                                        RouteAdministration : <?php echo $ii->RouteAdministration; ?><br>
                                        productName : <?php echo $ii->productName; ?></p> 
                                    </div>
                               <?php }
                            }
                            // echo '<pre>';print_r(json_decode($view['medication_key']));
                        ?> 
                </div>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->
</div>