<div class='table-responsive table-responsive-m'>
   <table class="table table-bordered  tabledatamap">
       <thead class="text-primary">
            <tr>	
                <th>Pages</th>
               <?php 
                   $i = count($user);  $j = 0;
                   if(count($user) > 0) {
                       foreach($user as $us){
                           ?>
                            <th>
                                <input type="checkbox" id="md_checkbox_<?php echo $us->ut_id;?>" class="filled-in chk-col-light-green" onclick='master_check($(this))' value="<?php echo $us->ut_id;?>">
                                <label for="md_checkbox_<?php echo $us->ut_id;?>"><?php echo $us->ut_name;?></label>     
                            </th>
                           <?php
                       }
                   }
               ?>
            </tr>
       </thead>
       <tbody>
           <?php  
               $sko = array();
               foreach($shares as $sh){
                    $sko[$sh->detail] = $sh->per_status;
               }  
               if(count($perm) > 0) {
                    foreach($perm as $dey => $pm){
                         ?>
                         <tr>	 
                                 <td><?php echo ucwords(str_replace("-"," ",$pm->page_name));?></td>
                                 <?php 
                                  if(count($user) > 0) {
                                      foreach($user as $usk => $us){
                                          $vlp      =	$us->ut_id.'-'.$pm->page_id; 
                                          $ds       =   $dey.$usk;
                                          ?>
                                          <th>
                                              <input type="checkbox" id="md_checkbox_<?php echo $ds;?>" class='filled-in chk-col-light-green checsjs check_<?php echo $us->ut_id;?>' name="permission[<?php echo $us->ut_id;?>][<?php echo $pm->page_id;?>]" value = '1' <?php echo (array_key_exists($vlp,$sko) && (1 == $sko[$vlp])) ? 'checked=checked' : '';?> />
                                              <label for="md_checkbox_<?php echo $ds;?>"></label>  
                                          </th>
                                          <?php
                                      }
                                 }
                                 ?>
                         </tr>
                         <?php
                    }
               }
           ?>
       </tbody>
   </table>
</div>