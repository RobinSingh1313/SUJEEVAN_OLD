<div class="row">
   <div class="col-lg-12">
      <?php $this->load->view("success_error");?> 
   </div>
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <div class="form-group">
                        <label>Module <span class=" text-danger">*</span></label>
                        <select class="form-control" name="module" required>
                           <option value="">Select Module</option>
                           <?php if(is_array($module) && count($module) > 0){
                           foreach($module as $m){ ?>
                           <option value="<?php echo $m['sub_module_id'];?>" <?php echo set_select("module",$m["sub_module_id"]);?>><?php echo $m['module_name']." - ".$m["sub_module_name"];?></option>
                           <?php }
                           }?>
                        </select>
                        <?php echo form_error('module');?> 
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <div class="form-group">
                        <label>Blog Title <span class=" text-danger">*</span></label>
                        <input name="blog_title" type="text" class="form-control" placeholder="Blog Title" required="" autocomplete="off" value="<?php echo set_value("blog_title");?>"/>
                        <?php echo form_error('blog_title');?> 
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <div class="form-group">
                        <label>Select Your Name<span class=" text-danger">*</span></label>
                        <select class="form-control select2" name="regvendor_id" required>
                           <option value="">Select Your Name</option>
                            <?php if(is_array($RegVendor) && count($RegVendor) > 0){

                              foreach($RegVendor as $rv){ ?>
                           <option value="<?php echo $rv['regvendor_id'];?>" <?php echo set_select("regvendor_id",$rv["regvendor_id"]);?>><?php echo $rv['regvendor_name'];?></option>
                           <?php }
                            }?>
                        </select>
                        <?php echo form_error('regvendor_id');?> 
                     </div>
                  </div>
               
                <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">-->
                <!--     <div class="form-group">-->
                <!--        <label>Blog Type <span class=" text-danger">*</span> </label>-->
                <!--        <select class="form-control" name="blog_type" required>-->
                <!--           <option value="">Select Blog type</option>-->
                <!--           <option value="1">Normal</option>-->
                <!--           <option value="2">Heart Related</option>-->
                <!--        </select>-->
                        <?php //echo form_error('blog_type');?> 
                <!--     </div>-->
                <!--  </div>-->
               </div>
               <?php /* <div class="row">
                  <span class="text-danger col-md-12 col-sm-12 col-lg-12 col-xs-12">Add Yotube Last Keys</span>
                  <div class="col-sm-5  col-md-5 col-lg-5 col-xs-12">
                     <div class="form-group">
                        <select class="form-control videotype ms" onchange="videotypes()">
                           <option value="">Select Video type</option>
                           <?php 
                              if(count($video_type) > 0){
                                foreach($video_type as $v){ ?>
                           <option value="<?php echo $v['video_type_id'];?>" video_type_text="<?php echo $v["video_type_text"];?>"><?php echo $v['video_type_name'];?></option>
                           <?php }
                              }
                              ?> 
                        </select>
                        <span class="text-danger videotype_err"></span>
                     </div>
                  </div>
                  <div class="col-sm-5  col-md-5 col-lg-5 col-xs-12">
                     <div class="form-group">
                        <div class="formupload">
                           <input type="text" class="form-control video_url text-capitalize" placeholder="Video URL"/>
                        </div>
                        <span class="text-danger videourl_err"></span>
                        <br/>
                        <div class="video progress" style="display:none;">
                           <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-2  col-md-2 col-lg-2 col-xs-12">
                     <a href="javascript:void(0)" valueattr="0" onclick="addvideo($(this))" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Video</a>
                  </div>
               </div> 
               <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 partpurchase">
                     <table class="table table-bordered table-striped">
                        <thead class="text-success">
                           <tr>
                              <th>Video Type</th>
                              <th>Video URL</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody></tbody>
                     </table>
                  </div>
               </div> */ ?>
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label>Blog Image </label>
                        <input type="file" name="blog_image" id="files" accept=".jpeg,.jpg,.png,.gif" type="text" class="form-control"/>
                        <?php echo form_error('blog_image');?> 
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label>Blog Description <span class=" text-danger">*</span> </label>
                        <textarea name="blog_description" type="text" class="form-control" placeholder="Blog Description" id="summernote" autocomplete="off" required><?php echo set_value("blog_description");?></textarea>
                        <?php echo form_error('blog_description');?> 
                     </div>
                  </div>
                  <h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-success">SEO Optimization</h4>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label>Seo Meta Keywords </label>
                        <input name="keywords" type="text" class="form-control" placeholder="Enter SEO meta Keywords"  autocomplete="off" value="<?php echo set_value("keywords");?>"/>
                        <?php echo form_error('keywords');?> 
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label>Seo Meta Description</label>
                        <textarea name="seo_description" class="form-control" placeholder="Enter SEO meta description"  autocomplete="off" ><?php echo set_value("seo_description");?></textarea>
                        <?php echo form_error('seo_description');?> 
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
      </div>
   </div>
</div>