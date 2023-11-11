<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("engsnaplayout/success_error");?> 
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="activity" novalidate="">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Room Name <span class="required text-danger">*</span></label>
                                <input name="chat_room_name" type="text" class="form-control input_numchar text-capitalize" placeholder="Room Name" value="<?php echo set_value('chat_room_name');?>" required="" maxlength="50"/>
                                <?php echo form_error('chat_room_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Chat Room User <span class="required text-danger">*</span></label>
                                <input name="chat_room_user" type="text" class="form-control text-capitalize" placeholder="Chat Room User" value="<?php echo set_value('chat_room_user');?>" required=""  maxlength="50"/>
                                <?php echo form_error('chat_room_user');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Login Name <span class="required text-danger">*</span></label>
                                <input name="chat_login_name" type="text" class="form-control input_numchar chat_login_name text-capitalize" placeholder="Login Name" value="<?php echo set_value('chat_login_name');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_login_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Password <span class="required text-danger">*</span></label>
                                <input name="chat_login_password" type="text" class="form-control text-capitalize" placeholder="Login Password" value="<?php echo set_value('chat_login_password');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_login_password');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Language <span class="required text-danger">*</span></label>
                                <input name="chat_language" type="text" class="form-control text-capitalize" placeholder="Language" value="<?php echo set_value('chat_language');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_language');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Region <span class="required text-danger">*</span></label>
                                <select required="" class="regionSelect form-control" name="regionname">
                                    <option value="">Select Region</option>
                                </select>
                                <?php echo form_error('regionname');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-raised btn-success waves-effect" name="submit" value="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--end card-body-->
        </div>
    </div>
</div>      