
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <?php 
    $sel_module_id = !empty($this->input->get('moduleid'))?$this->input->get('moduleid'):'';
    $history_id = !empty($this->input->get('history_id'))?$this->input->get('history_id'):'';
    if($sel_module_id!='' && $history_id!=''){
        $response = $this->db->query("select homecare_chat_responseid,list_of_answers,submodule_id FROM homecare_chat_response 
                        WHERE homecare_chat_responseid='".$history_id."'
                        ORDER BY homecare_chat_responseid DESC")->row_array();
        $result = $this->db->query("select homecare_chat_question,homecare_chat_options FROM homecare_chat_box
                                WHERE homecare_chat_open='1' AND homecare_chat_status='1' AND homecare_chat_acde = 'Active' AND 
                                homecare_chat_sub_module = '".$response['submodule_id']."'
                                ORDER BY homecare_chat_order")->result_array();
    }
    ?>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Module<span class="required text-danger">*</span></label>
                                <select class="form-control pd-y-12" name="module_id" id="module_id" onchange="getsubmoduleSelect()" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    foreach($module as $m){ ?>
                                        <option value="<?php echo $m->moduleid; ?>" <?php if($sel_module_id==$m->moduleid){ echo 'selected'; } ?>><?php echo $m->module_name; ?></option>
                                    <?php } ?>
                                </select> 
                             </div><!-- form-group -->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Sub Module</label>
                                <input type="hidden" id="sub_module_id" value="<?php echo isset($response['submodule_id'])?$response['submodule_id']:'';?>">
                                <select class="form-control pd-y-12" name="homecare_category" id="submodule" onchange="update_response($(this))">
                                    <option value="">Select Sub Module</option>
                                </select> 
                                  <input type="hidden" name="registration_id" id="registration_id" value="<?php echo $this->input->get('user_id'); ?>"/>
                             </div>
                        </div>
                        <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> -->
                        <!--    <div class="form-group">-->
                        <!--        <label>Homecare Category<span class="required text-danger">*</span></label>-->
                        <!--        <select class="form-control pd-y-12" name="homecare_category" onchange="update_response($(this))">-->
                        <!--            <option value="">Select Homecare Category</option>-->
                             <?php 
                                // foreach($sub_module as $s){
                        ?>
                        <!--                <option value="<?php //echo $s->sub_module_id; ?>"><?php //echo $s->sub_module_name; ?></option>-->
                                   <?php //} ?>
                        <!--        </select> -->
                              
                        <!--     </div> form-group -->
                        <!--</div>-->
                    </div>
                    <?php
                    if($sel_module_id!='' && $history_id!=''){ ?>
                        <div class="" id="update_response">
                            <div class="pd-x-30 pd-y-10 row">
                                <div class="col-md-6"> <h3 class="tx-inverse  mg-b-5">Chatbot Questions</h3></div>
                            </div>
                            <div class="pd-x-30 pd-y-10 row">
                                <?php
                                if(!empty($response['list_of_answers'])){
                                    echo '<input type="hidden" name="homecare_chat_responseid" value="'.$response['homecare_chat_responseid'].'"/>';
                                     foreach(json_decode($response['list_of_answers']) as $res){
                                         $respon[$res->question] = $res->option;
                                     }
                                 }
                                //  print_r($respon);
                                foreach ($result as $key => $value) {
                                    $options = $value['homecare_chat_options'];
                                    if(!empty($options)){
                                     ?>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                        <div class="form-group">
                                        <label><?php echo $value['homecare_chat_question'];?></label>
                                        <input type="hidden" name="question[<?php echo $key;?>]" value="<?php echo $value['homecare_chat_question'];?>" />
                                        <br>
                                        <?php
                                        $chatbox["list"][$key]['options'] = array();
                                        
                                        $options_array = explode(",", $options);
                                        if(is_array($options_array) && count($options_array)>0 ){
                                            foreach ($options_array as $key1 => $ar) 
                                            { 
                                                if(!empty($ar)){ ?>
                                                    <input type="radio" id="<?php echo $key.$key1;?>" name="option[<?php echo $key;?>]" value="<?php echo $ar;?>" <?php if(array_key_exists($value['homecare_chat_question'],$respon) && $respon[$value['homecare_chat_question']] == $ar){ echo 'checked';}?>  required>
                                                        <label for="<?php echo $key.$key1;?>"><?php echo $ar;?></label><br>
                                                    <?php
                                                    array_push($chatbox["list"][$key]['options'],$ar);
                                                    // $chatbox["list"][$key]['options_'.$key1] = $ar; 
                                                
                                              }
                                                
                                            }
                                        } 
                                        echo '</div></div>';
                                    }
                                }  
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6"> 
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save</button>
                                </div>
                            </div>
                             <div class="col-md-6"><a target="_blank" class="btn btn-info float-right" href="<?php echo base_url("Sujeevan-Admin/Chatbot-Response?user_id=").$this->input->get('user_id')?>">Chat Box Response</a></div>
                        </div>
                    <?php } ?>
                </form>
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div> 
<script type="text/javascript">
getsubmoduleSelect();
var sub_module_id = $('#sub_module_id').val();
$('#submodule').val(sub_module_id);
</script>