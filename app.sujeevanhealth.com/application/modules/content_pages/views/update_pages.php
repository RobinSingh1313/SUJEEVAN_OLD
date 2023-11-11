<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="">
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Page Title<span class="required text-danger">*</span></label>
                                    <input name="page_title" value="<?php echo (count($view) > 0)?$view["cpage_title"]:set_value("page_title");?>" type="text" class="form-control" placeholder="Page Title" required="" autocomplete="off" />
                                </div>
                                <?php echo form_error('page_title');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Page Content <span class="required text-danger">*</span></label>
                                    <select data-live-search="true" required="" onchange="pageform()"  title="Select Content" class="form-control page_content show-tick" name="cpage_content_from">
                                        <?php 
                                        if(count($contentform) > 0){
                                            foreach ($contentform as $cer){
                                                ?>
                                        <option atrvalue="<?php echo $cer->content_val;?>" <?php echo ($view['cpage_content_from'] ==  $cer->content_from_id)?"selected=selected":"";?> value="<?php echo $cer->content_from_id;?>"><?php echo $cer->content_from_name;?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php echo form_error('cpage_content_from');?> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Page Layout <span class="required text-danger">*</span></label>
                                    <select data-live-search="true" required="" onchange="pageform()"  title="Select Layout" class="form-control page_layout show-tick" name="page_layout">
                                        <?php 
                                        if(count($layouts) > 0){
                                            foreach ($layouts as $cer){
                                                ?>
                                        <option atrvalue="<?php echo $cer->layout_val;?>" <?php echo ($view['cpage_layout'] == $cer->layout_id)?"selected=selected":"";?> value="<?php echo $cer->layout_id;?>"><?php echo $cer->layout_name;?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php echo form_error('cpage_content_from');?> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" value="1" <?php echo ($view['cpage_show_menu'] == '1')?"checked=checked":"";?>  name="is_menu_header" id="md_checkbox_31" class="filled-in chk-col-light-green">
                                    <label for="md_checkbox_31">Is Menu Header</label>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row pageurl">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Page URL <span class="text-danger">*</span></label>
                                    <input name="post_url" value="<?php echo $view["cpage_content_url"];?>" type="text" class="form-control" placeholder="Page URL" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_nest">
                        <div class="form-group  pagewidgets">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="text-info">Widgets</h4>
                                    <div class="dd nestable-with-handle">
                                        <ol class="draggable-list dd-list">
                                            <?php
                                                $left   =   $view['cpage_leftsidebar'];
                                                $cntt   =   $view['cpage_content'];
                                                $rght   =   $view['cpage_rightbar'];  
                                                $msp    =   $left.",".$cntt.",".$rght;
                                                $vsp    =   array_filter(explode(",",$msp)); 
                                                if(count($widgets) > 0){
                                                    foreach ($widgets as $wd){
                                                    if(!in_array($wd->widget_id,$vsp)){
                                                     ?>
                                                    <li class="draggable-item dd-item" data-id="<?php echo $wd->widget_id;?>">
                                                    <div class="dd-handle"><?php echo $wd->widget_display_name;?></div>
                                                    </li> 
                                            <?php 
                                                        }
                                                    } 
                                                }
                                            ?>
                                        </ol>
                                    </div>
                                    <input type="hidden" name="left_contentval" class="left_contentval" values="[]">
                                    <input type="hidden" name="page_conentval" class="page_conentval" values="[]">
                                    <input type="hidden" name="right_contentval" class="right_contentval" values="[]">
                               </div> 
                                <div class="col-sm-8">
                                    <div class="left_widget">	
                                        <h5>Left Widget</h5>
                                        <div class="dd" id="left_widget_1">
                                            <div class="dd-empty">
                                                <?php 
                                                $lvsp   = array_filter(explode(",",$left)); 
                                                if(count($lvsp) > 0){
                                                    if(count($widgets) > 0){
                                                        foreach ($widgets as $lst){
                                                            if(in_array($lst->widget_id,$lvsp)){
                                                            ?> 
                                                            <li class="draggable-item dd-item" data-id="<?php echo $lst->widget_id;?>">
                                                                <div class="dd-handle"><?php echo $lst->widget_display_name;?></div>
                                                            </li> 
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                }else {
                                                        echo '<div class="dd-empty"></div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php echo form_error("left_contentval");?>
                                    </div>
                                    <div class="contet_widget">	 
                                        <h5>Content Widget</h5>
                                        <div class="dd" id="content_widget_1">
                                            <div class="dd-empty">
                                            <?php 
                                            $lvsp   = array_filter(explode(",",$cntt)); 
                                            if(count($lvsp) > 0){
                                                if(count($widgets) > 0){
                                                    foreach ($widgets as $lst){
                                                        if(in_array($lst->widget_id,$lvsp)){
                                                        ?> 
                                                        <li class="draggable-item dd-item" data-id="<?php echo $lst->widget_id;?>">
                                                            <div class="dd-handle"><?php echo $lst->widget_display_name;?></div>
                                                        </li> 
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }else {
                                                    echo '<div class="dd-empty"></div>';
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <?php echo form_error("page_conentval");?>
                                    </div>
                                    <div class="right_widget">	 
                                        <h5>Right Widget</h5>
                                        <div class="dd" id="right_widget_1">
                                            <div class="dd-empty">
                                            <?php 
                                            $lvsp   = array_filter(explode(",",$rght)); 
                                            if(count($lvsp) > 0){
                                                if(count($widgets) > 0){
                                                    foreach ($widgets as $lst){
                                                        if(in_array($lst->widget_id,$lvsp)){
                                                        ?> 
                                                        <li class="draggable-item dd-item" data-id="<?php echo $lst->widget_id;?>">
                                                            <div class="dd-handle"><?php echo $lst->widget_display_name;?></div>
                                                        </li> 
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }else {
                                                    echo '<div class="dd-empty"></div>';
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <?php echo form_error("right_contentval");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">   
                        <div class="row">
                            <div class="col-sm-12 form-group leftcontent">
                                <label>Left Content</label>
                                <textarea name="cpage_leftsidebar" id="cpage_leftsidebar" class="form-control cpage_leftsidebar tutovalue" rows="10" cols="80"><?php echo $left;?></textarea>
                            </div>
                            <div class="col-sm-12 form-group contentpage">
                                <label>Content</label>
                                <textarea name="cpage_content" id="cpage_content"  class="form-control cpage_rightbar tutovalue" rows="10" cols="80"><?php echo $cntt;?></textarea>
                            </div>
                            <div class="col-sm-12 form-group rightcontent">
                                <label>Right Content</label>
                                <textarea name="cpage_rightbar" id="cpage_rightbar"  class="form-control cpage_rightbar tutovalue" rows="10" cols="80"><?php echo $rght;?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-info">Manage SEO Settings</h4><hr/>
                            </div> 
                            <div class="col-sm-6">
                                <?php  $seo = unserialize($view['cpage_seo_settings']);?>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Meta Keywords </label>
                                        <textarea name="meta_keywords" placeholder="Meta Keywords" class="form-control"><?php echo $seo['meta_keys'];?></textarea>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Meta Description </label>
                                        <textarea name="meta_desc" placeholder="Meta Description" class="form-control"><?php echo $seo['meta_desc'];?></textarea>
                                    </div>
                                </div>
                            </div>  
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-raised btn-success waves-effect" name="submit" value="submit"> Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    