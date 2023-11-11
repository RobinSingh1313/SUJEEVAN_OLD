<div class="pd-x-30 pd-y-10 row">
    <div class="col-md-6"> <h3 class="tx-inverse  mg-b-5">Chatbot Questions</h3></div>
</div>
<div class="pd-x-30 pd-y-10 row">
  <?php
        $result = $this->db->query("select homecare_chat_question,homecare_chat_options
        FROM homecare_chat_box
        WHERE homecare_chat_open='1' AND homecare_chat_status='1' AND homecare_chat_acde = 'Active' AND homecare_chat_sub_module = '".$this->input->post('id')."'
        ORDER BY homecare_chat_order"   
         )->result_array();//print_r($result);
         $response = $this->db->query("select homecare_chat_responseid,list_of_answers FROM homecare_chat_response WHERE submodule_id = '".$this->input->post('id')."' AND registration_id = '".$this->input->post('registration_id')."' ORDER BY homecare_chat_responseid DESC")->row_array();
        //  print_r(json_decode($response['list_of_answers']));
         $respon = array();
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