<?php $this->load->view("engsnaplayout/success_error");?> 
<div class="row">
    <?php if($this->session->userdata("create-chat-room") == "1") { ?>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo adminurl('Create-Chat-Room');?>">
            <div class="card bg-info mini-stat position-relative">
                <div class="card-body">
                        <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-90">Create Chat Room</h6>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="fas fa-compact-disc display-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } if($this->session->userdata("chat-room-settings") == "1") { ?>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo adminurl('Chat-Room-Settings');?>">
            <div class="card bg-warning mini-stat position-relative">
                <div class="card-body">
                        <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-90">Chat Room Settings</h6>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="fas fa-cogs display-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } if($this->session->userdata("chat-room-configuration") == "1") { ?>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo adminurl('Chat-Room-Configuration');?>">
            <div class="card bg-danger mini-stat position-relative">
                <div class="card-body">
                        <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-90">Auto Box Reply Configuration</h6>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="fas fa-cogs display-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } if($this->session->userdata("complaints-logs") == "1") { ?>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo adminurl('Complaints-Logs');?>">
            <div class="card bg-primary mini-stat position-relative">
                <div class="card-body">
                        <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-90">Complaints Log</h6>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="fas fa-cogs display-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title text-success">Chat Room</h4> <hr/>
                <?php $this->load->view("engsnaplayout/allsearch");?>
            </div>
        </div>
    </div>
</div>