<div class="br-header">
   <div class="br-header-left">
      <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
   </div>
   <!-- br-header-left -->
   <div class="br-header-right">
      <nav class="nav">
         <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
               <i class="icon ion-ios-compose-outline tx-24"></i> LANG
            </a>
            <div class="dropdown-menu dropdown-menu-header">
               <div class="dropdown-menu-label">
                  <label>Language </label>
               </div>
               <!-- d-flex -->
               <div class="media-list">
                  <?php
                    $pcl    =   $this->common_model->getLanguages();
                    foreach ($pcl as $cfe){
                        ?>
                  <a href="" class="media-list-link">
                     <div class="media">
                        <div class="media-body">
                           <div>
                              <p><?php echo $cfe['language_value'];?></p>
                              <span><?php echo $cfe['language_name'];?></span>
                           </div>
                        </div>
                     </div>
                  </a>
                        <?php 
                    }
                  ?>
                  <div class="dropdown-footer">
                     <a href=""><i class="fa fa-angle-down"></i> Show All Messages</a>
                  </div>
               </div>
               <!-- media-list -->
            </div>
            <!-- dropdown-menu -->
         </div>
         <!-- dropdown -->
         <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
               <i class="icon ion-ios-bell-outline tx-24"></i>
               <!-- start: if statement -->
               <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
               <!-- end: if statement -->
            </a>
            <div class="dropdown-menu dropdown-menu-header">
               <div class="dropdown-menu-label">
                  <label>Notifications</label>
                  <a href="">Mark All as Read</a>
               </div>
               <!-- d-flex -->
               <div class="media-list">
                  <!-- loop starts here -->
                  <a href="" class="media-list-link read">
                     <div class="media">
                        <img src="https://via.placeholder.com/500" alt="">
                        <div class="media-body">
                           <p class="noti-text"><strong>Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                           <span>October 03, 2017 8:45am</span>
                        </div>
                     </div>
                     <!-- media -->
                  </a>
                  <!-- loop ends here -->
                  <a href="" class="media-list-link read">
                     <div class="media">
                        <img src="https://via.placeholder.com/500" alt="">
                        <div class="media-body">
                           <p class="noti-text"><strong>Mellisa Brown</strong> appreciated your work <strong>The Social Network</strong></p>
                           <span>October 02, 2017 12:44am</span>
                        </div>
                     </div>
                     <!-- media -->
                  </a>
                  <a href="" class="media-list-link read">
                     <div class="media">
                        <img src="https://via.placeholder.com/500" alt="">
                        <div class="media-body">
                           <p class="noti-text">20+ new items added are for sale in your <strong>Sale Group</strong></p>
                           <span>October 01, 2017 10:20pm</span>
                        </div>
                     </div>
                     <!-- media -->
                  </a>
                  <a href="" class="media-list-link read">
                     <div class="media">
                        <img src="https://via.placeholder.com/500" alt="">
                        <div class="media-body">
                           <p class="noti-text"><strong>Julius Erving</strong> wants to connect with you on your conversation with <strong>Ronnie Mara</strong></p>
                           <span>October 01, 2017 6:08pm</span>
                        </div>
                     </div>
                     <!-- media -->
                  </a>
                  <div class="dropdown-footer">
                     <a href=""><i class="fa fa-angle-down"></i> Show All Notifications</a>
                  </div>
               </div>
               <!-- media-list -->
            </div>
            <!-- dropdown-menu -->
         </div>
         <!-- dropdown -->
         <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <span class="logged-name hidden-md-down"><?php echo $this->session->userdata("login_name");?></span>
            <img src="https://via.placeholder.com/500" class="wd-32 rounded-circle" alt="">
            <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
               <div class="tx-center">
                  <a href=""><img src="https://via.placeholder.com/500" class="wd-80 rounded-circle" alt=""></a>
                  <h6 class="logged-fullname"><?php echo $this->session->userdata("login_name");?></h6>
                  <p><?php echo $this->session->userdata("login_users");?></p>
               </div>
               <hr>
               <ul class="list-unstyled user-profile-nav">
                  <li><a href=""><i class="icon ion-ios-person"></i> Edit Profile</a></li>
                  <li><a href=""><i class="icon ion-ios-gear"></i> Settings</a></li>
                  <li><a href="<?php echo adminurl("Logout");?>"><i class="icon ion-power"></i> Sign Out</a></li>
               </ul>
            </div>
         </div>
      </nav>
   </div>
</div>