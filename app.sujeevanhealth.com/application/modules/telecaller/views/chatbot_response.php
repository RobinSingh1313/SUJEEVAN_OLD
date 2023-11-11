<?php 
$v = $this->input->get('user_id', TRUE);
$vs = $this->input->get('submodule_id', TRUE);
$response = $this->db->query("select list_of_answers,register_name,register_mobile,module_name,sub_module_name from  homecare_chat_response as r
                              INNER JOIN registration as u ON r.registration_id = u.registration_id
                              INNER JOIN sub_module as s ON r.submodule_id = s.sub_module_id
                              INNER JOIN modules as m ON s.sub_module_module_id = m.moduleid
                              Where r.registration_id LIKE '".$v."' ")->result();
                             // echo $this->db->last_query();exit;
//echo "<pre>";print_r($response);exit;
$er = "";
$user = "";
$submodule = "";
$module = "";
$phone = "";
    if(is_array($response) && count($response) > 0){
        $er = (array)$response[0];
        $user = $er['register_name'];
        $phone = $er['register_mobile'];
        $module = $er['module_name'];
        $submodule = $er['sub_module_name'];
    }
?>
  <?php if(is_array($response) && count($response) > 0){ ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                  <h5 class="text-center"><?php echo $user;?></h6>
                  <p class="text-center"><?php echo $phone;?></p>
            </div>
            <!--<div class="col-lg-6 col-md-6 "> -->
            <!--    <div class="d-flex justify-content-center">-->
            <!--        <h6 class="pd-x-12">Module:</h6>-->
            <!--        <p><?php echo $module;?></p>-->
                   
            <!--     </div>-->
            <!--</div>-->
            <!--<div class="col-lg-6 col-md-6"> -->
            <!--    <div class="d-flex justify-content-center">-->
            <!--        <h6 class="pd-x-12">Sub Module:</h6>-->
            <!--        <p><?php echo $submodule;?></p>-->
            <!--     </div>-->
            <!--</div>-->
        </div>
        <div class="row">
             <?php
                foreach($response as $res){ 
                    $subm = $res->sub_module_name;
                    if($subm == $res->sub_module_name){
                       
                   
            ?>
            <div class="col-md-6 mg-y-20">
                <div class="row">
                    <div class="col-lg-6 col-md-6 "> 
                        <div class="d-flex ">
                            <h6 class="pd-x-12">Module:</h6>
                            <p><?php echo $res->module_name;?></p>
                         </div>
                    </div>
                    <div class="col-lg-6 col-md-6"> 
                        <div class="d-flex float-right">
                            <h6 class="pd-x-12">Sub Module:</h6>
                            <p><?php echo $subm;?></p>
                         </div>
                    </div>
                </div>
                  <table class="table">
                    <tbody>
                        <?php
                             $list_of_answers = json_decode($res->list_of_answers);
                             if(is_array($list_of_answers) && count($list_of_answers) > 0){
                                foreach($list_of_answers as $l){
                        ?>
                         <tr>
                            <td><strong><?php echo $l->question;?></strong></td>
                            <td> <?php echo $l->option; ?></td>
                        </tr>
                           <?php } }  ?>
                    </tbody>
                </table> 
            </div>
            <?php }  }  ?>
            
        </div>
        <!--<div class="row mg-t-20">-->
        <!--    <div class="col-md-12">-->
        <!--        <table class="table">-->
        <!--            <tbody>-->
                   <?php
                  //foreach($response as $key =>$res){
                          
                       //$list_of_answers = json_decode($res->list_of_answers);
                         // if(is_array($list_of_answers) && count($list_of_answers) > 0){
                                
                             //foreach($list_of_answers as $key1=>$l){
                         ?>
        <!--                <tr>-->
        <!--                    <td><strong><?php echo $l->question;?></strong></td>-->
        <!--                    <td> <?php echo $l->option; ?></td>-->
        <!--                </tr>-->
                    <?php  //}  } }
                 ?>
        <!--            </tbody>-->
        <!--        </table>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
</div>
<?php }else{ ?>
<h6 class="text-danger text-center pd-y-50">No Chat Box Response</h6>
<?php }?>
