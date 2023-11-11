<div class="br-sideleft sideleft-scrollbar">
   <label class="sidebar-label pd-x-10 mg-t-20 op-3"><?php echo sitedata("site_name");?></label>
   <ul class="br-sideleft-menu">
      <li class="br-menu-item">
         <a href="<?php echo adminurl("Dashboard");?>" class="br-menu-link Dashboard">
            <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
            <span class="menu-item-label">Dashboard</span>
         </a>
      </li>
      <?php if($this->session->userdata("manage-permission") == "1" || $this->session->userdata("manage-roles") == "1" || $this->session->userdata("manage-users") == "1"){ ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Roles Permissions users">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Administration</span>
         </a><!-- br-menu-link -->
         <ul class="br-menu-sub spPermissions spRoles spusers">
             <?php if($this->session->userdata("manage-permission") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Permissions");?>" class="Permissions sub-link">Permissions</a></li>
             <?php } if($this->session->userdata("manage-roles") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("Roles");?>" class="Roles sub-link">Roles</a></li>
             <?php } if($this->session->userdata("manage-users") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("users");?>" class="users sub-link">Users</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php } if($this->session->userdata("manage-video-type") == "1" || $this->session->userdata("manage-wheel-wellness") == "1" || $this->session->userdata("manage-lab_test_list") == "1" || $this->session->userdata("manage-medicine_list") == "1"  || $this->session->userdata("manage-hospital_specialities") == "1"  || $this->session->userdata("manage-hospital_facilities") == "1"|| $this->session->userdata("manage-hospital_sub_specialities") == "1" || $this->session->userdata("manage-manage-appointment-time-slot") == "1" ){ ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Video-Type States Update-Video-Type Create-Video-Type Wellness Update-Wellness Lab-Test-List Update-Lab-Test-List Medicine-List Update-Medicine-List Hospital-Specialities Hospital-Sub-Specialities Hospital-Facilities Book-Appointment-Time-Slot">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Masters</span>
         </a><!-- br-menu-link -->
         <ul class="br-menu-sub spVideo-Type spStates spUpdate-Video-Type spCreate-Video-Type spWellness spUpdate-Wellness spWellness-Contact spUpdate-Wellness-Contact spLab-Test-List spUpdate-Lab-Test-List spMedicine-List spUpdate-Medicine-List spHospital-Specialities spHospital-Sub-Specialities spHospital-Facilities spBook-Appointment-Time-Slot">
             <?php if($this->session->userdata("manage-appointment-time-slot") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Book-Appointment-Time-Slot");?>" class="Book-Appointment-Time-Slot Update-Video-Type sub-link">Book Appointment Time Slot</a></li>
             <?php } if($this->session->userdata("manage-video-type") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Video-Type");?>" class="Video-Type Update-Video-Type Create-Video-Type sub-link">Video Type</a></li>
             <?php } if($this->session->userdata("manage-lab_test_list") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Lab-Test-List");?>" class="Lab-Test-List Update-Lab-Test-List Create-Lab-Test-List sub-link">Lab Test List</a></li>
             <?php } if($this->session->userdata("manage-hospital_specialities") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Hospital-Specialities");?>" class="Hospital-Specialities Update-Hospital-Specialities Create-Hospital-Specialities sub-link">Hospital Specialities</a></li>
             <?php } if($this->session->userdata("manage-hospital_sub_specialities") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Hospital-Sub-Specialities");?>" class="Hospital-Sub-Specialities Update-Hospital-Sub-Specialities Create-Hospital-Sub-Specialities sub-link">Hospital Sub Specialities</a></li>
             <?php } if($this->session->userdata("manage-hospital_facilities") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Hospital-Facilities");?>" class="Hospital-Facilities Update-Hospital-Facilities Create-Hospital-Facilities sub-link">Hospital Facilities</a></li>
             <?php } if($this->session->userdata("manage-medicine_list") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Medicine-List");?>" class="Medicine-List Update-Medicine-List Create-Medicine-List sub-link">Medicine List</a></li>
             <?php } if($this->session->userdata("manage-wheel-wellness") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Wellness");?>" class="Wellness Update-Wellness sub-link">Wheel of Wellness</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Wellness-Contact");?>" class="Wellness-Contact Update-Wellness-contact sub-link">Wow Contact Requests</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php } if($this->session->userdata("manage-widgets") == "1" || $this->session->userdata("manage-content-pages") == "1"){ ?>
        <li class="br-menu-item">
            <a href="javascript:void(0);" class="br-menu-link with-sub Content-Pages Widgets Create-Content-Pages">
               <i class="menu-item-icon icon ion-bookmark tx-20"></i>
               <span class="menu-item-label">Content Management</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub spContent-Pages spWidgets spCreate-Content-Pages">
                <?php if($this->session->userdata("manage-widgets") == "1") { ?>
                <li class="sub-item"><a href="<?php echo adminurl("Widgets");?>" class="Widgets sub-link">Widgets</a></li>
                <?php } if($this->session->userdata("manage-content-pages") == "1"){ ?>
                <li class="sub-item "><a href="<?php echo adminurl("Content-Pages");?>" class="Content-Pages Create-Content-Pages sub-link">Pages</a></li>
                <?php } ?>
            </ul>
        </li>
      <?php }  if($this->session->userdata("manage-modules") == "1" || $this->session->userdata("manage-sub-module") == "1") { ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub  Update-Sub-Module Update-Module Modules Create-Sub-Module Sub-Module">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Modules</span>
         </a>
         <ul class="br-menu-sub spUpdate-Sub-Module spSub-Module spUpdate-Module spModules spCreate-Sub-Module">
             <?php if($this->session->userdata("manage-modules") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Modules");?>" class="Update-Module Modules sub-link">Modules</a></li>
             <?php } if($this->session->userdata("manage-sub-module") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("Sub-Module");?>" class="Sub-Module Create-Sub-Module Update-Sub-Module sub-link">Sub Modules</a></li>
             <?php } ?>
         </ul>
      </li>
       <?php } if($this->session->userdata("manage-doctor") == "1"){ ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Doctor Update-Doctor">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Employee</span>
         </a><!-- br-menu-link -->
         <ul class="br-menu-sub spDoctor spUpdate-Doctor">
             <?php if($this->session->userdata("manage-doctor") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Doctor");?>" class="Doctor sub-link">Doctor</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php } if($this->session->userdata("manage-category") == "1" || $this->session->userdata("manage-sub-category") == "1") { ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Update-Sub-Category Create-Sub-Category Sub-Category Update-Category Category Create-Category">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Categories</span>
         </a>
         <ul class="br-menu-sub spSub-Category spUpdate-Sub-Category spCreate-Sub-Category spUpdate-Category spCreate-Category spCategory">
             <?php if($this->session->userdata("manage-category") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Category");?>" class="Update-Category Create-Category Category sub-link">Category</a></li>
             <?php } if($this->session->userdata("manage-sub-category") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("Sub-Category");?>" class="Create-Sub-Category Sub-Category Update-Sub-Category sub-link">Sub Categories</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php }  if($this->session->userdata("manage-specialization") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Specialization");?>" class="br-menu-link Specialization">
                <i class="menu-item-icon icon ion-disc tx-24"></i>
                <span class="menu-item-label">Specialization</span>
            </a>
      </li>
      <?php }  if($this->session->userdata("manage-vendors") == "1" || $this->session->userdata("manage-sub-vendors") == "1"){ ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link Create-Sub-Vendor with-sub Vendors Sub-Vendors Create-Vendor Update-Sub-Vendor Update-Vendor">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Vendors</span>
         </a>
         <ul class="br-menu-sub spVendors spUpdate-Vendor spSub-Vendors spUpdate-Sub-Vendor spCreate-Sub-Vendor spCreate-Vendor">
             <?php if($this->session->userdata("manage-vendors") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Vendors");?>" class="Vendors Create-Vendor sub-link Update-Vendor">Vendors</a></li>
             <?php } if($this->session->userdata("manage-sub-vendors") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("Sub-Vendors");?>" class="Update-Sub-Vendor Create-Sub-Vendor Sub-Vendors sub-link">Sub Vendors</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php }  if($this->session->userdata("manage-homecare") == "1"){ ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Homecare-Packages Homecare-Tests Create-Works Updte-Works Works Update-Home-Tests Update-Home-Packages">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Home Care</span>
         </a>
         <ul class="br-menu-sub spHomecare-Packages spUpdate-Home-Packages spWorks spUpdate-Works spCreate-Works spHomecare-Tests spUpdate-Home-Tests">
             <?php if($this->session->userdata("manage-homecare-packages") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Homecare-Packages");?>" class="Homecare-Packages Create-Works Updte-Works Works Update-Home-Packages sub-link">Packages</a></li>
             <?php } if($this->session->userdata("manage-homecare-tests") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("Homecare-Tests");?>" class="Update-Home-Tests Homecare-Tests sub-link">Tests</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php } if($this->session->userdata("manage-package") == "1" || $this->session->userdata("manage-package-details") == "1" || $this->session->userdata("manage-membership") == "1"){ ?>
        <li class="br-menu-item">
            <a href="javascript:void(0);" class="br-menu-link with-sub Update-Package-Details Package-Details Package Update-Package Membership Update-Membership">
               <i class="menu-item-icon icon ion-bookmark tx-18"></i>
               <span class="menu-item-label">Packages</span>
            </a>
            <ul class="br-menu-sub spPackage spUpdate-Package spUpdate-Package-Details spPackage-Details spMembership spUpdate-Membership ">
                <?php if($this->session->userdata("manage-package") == "1") { ?>
                <li class="sub-item"><a href="<?php echo adminurl("Package");?>" class="Widgets sub-link">Packages</a></li>
                <?php } if($this->session->userdata("manage-package-details") == "1"){ ?>
                <li class="sub-item "><a href="<?php echo adminurl("Package-Details");?>" class="Update-Package-Details Package-Details sub-link">Package Details</a></li>
                <?php } if($this->session->userdata("manage-membership") == "1"){ ?>
                <li class="sub-item "><a href="<?php echo adminurl("Membership");?>" class="Update-Membership Membership sub-link">Homecare Membership</a></li>
                <?php } ?>
            </ul>
        </li>
      <?php }   if($this->session->userdata("manage-blogs") == "1") { ?>
        <li class="br-menu-item">
            <a href="<?php echo adminurl("Blogs");?>" class="br-menu-link Blogs Update-Blog Create-Blog">
                <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
                <span class="menu-item-label">Blogs</span>
            </a><!-- br-menu-link -->
        </li>
      <?php }  if($this->session->userdata("manage-question-answers") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Question-Answers");?>" class="br-menu-link Question-Answers Create-Question-Answer Update-Question-Answer">
                <i class="menu-item-icon icon ion-ios-help-outline tx-24"></i>
                <span class="menu-item-label">Question & Answers</span>
            </a>
      </li>
      <?php } if($this->session->userdata("manage-app-users") == "1") { ?>
       <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub App-Vendors App-Customers">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">APP Users</span>
         </a>
         <ul class="br-menu-sub sp">
             <li class="sub-item"><a href="<?php echo adminurl("App-Vendors");?>" class="App-Vendors sub-link">Vendors</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("App-Customers");?>" class="App-Customers sub-link">Customers</a></li>
         </ul>
      </li>
      <?php } if($this->session->userdata("manage-hospitals") == "1") { ?>
       <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Specialities Packages Facilities">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Hospitals</span>
         </a>
         <ul class="br-menu-sub sp">
             <li class="sub-item"><a href="<?php echo adminurl("Specialities");?>" class="Specialities sub-link">Specialities</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Packages");?>" class="Packages sub-link">Packages</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Facilities");?>" class="Facilities sub-link">Facilities</a></li>
         </ul>
      </li>
      <?php } if($this->session->userdata("manage-health-category") == "1" || $this->session->userdata("manage-health-sub-category") == "1") { ?>
      <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Update-Health-Sub-Category Create-Health-Sub-Category Health-Sub-Category Health-Update-Category Health-Category Create-Health-Category">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Health Categories</span>
         </a>
         <ul class="br-menu-sub spHealth-Sub-Category spUpdate-Sub-Health-Category spUpdate-Health-Category spHealth-Category">
             <?php if($this->session->userdata("manage-health-category") == "1") { ?>
             <li class="sub-item"><a href="<?php echo adminurl("Health-Category");?>" class="Update-Health-Category Health-Category sub-link">Health Category</a></li>
             <?php } if($this->session->userdata("manage-health-sub-category") == "1"){ ?>
             <li class="sub-item "><a href="<?php echo adminurl("Health-Sub-Category");?>" class="Health-Sub-Category Update-Sub-Health-Category sub-link">Sub Health Categories</a></li>
             <li class="sub-item "><a href="<?php echo adminurl("Health-Specialization-Assign");?>" class="Health-Specialization-Assign Update-Health-Specialization sub-link">Assign Specialization</a></li>
             <?php } ?>
         </ul>
      </li>
      <?php } if($this->session->userdata("chat-room-configuration") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Chat-Room-Configuration");?>" class="br-menu-link Update-bot Chat-Room-Configuration">
                <i class="menu-item-icon icon ion-disc tx-24"></i>
                <span class="menu-item-label">Auto Chat Bot</span>
            </a>
      </li>
      <?php }  if($this->session->userdata("manage-symptoms-chat-bot") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Symptoms-Chat-Bot");?>" class="br-menu-link Symptoms-Chat-Bot">
                <i class="menu-item-icon icon ion-disc tx-24"></i>
                <span class="menu-item-label">Symptoms Chat Bot</span>
            </a>
      </li>
      <?php }  if($this->session->userdata("manage-homecare-chat-bot") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Homecare-Chat-Bot");?>" class="br-menu-link Homecare-Chat-Bot">
                <i class="menu-item-icon icon ion-disc tx-24"></i>
                <span class="menu-item-label">Homecare Chat Bot</span>
            </a>
      </li>
      <?php }  if($this->session->userdata("manage-consult-chat-bot") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Consult-Chat-Bot");?>" class="br-menu-link Consult-Chat-Bot">
                <i class="menu-item-icon icon ion-disc tx-24"></i>
                <span class="menu-item-label">Consult Basic Chat Bot</span>
            </a>
      </li>
      <?php }  if($this->session->userdata("manage-health-tips") == "1") { ?>
      <li class="br-menu-item">
            <a href="<?php echo adminurl("Health-Tips");?>" class="br-menu-link Health-Tips">
                <i class="menu-item-icon icon ion-ios-help-outline tx-24"></i>
                <span class="menu-item-label">Health Tips</span>
            </a>
      </li>
      <?php } 
      
      /**************   Telecaller *****************************/
      
      if($this->session->userdata("manage-telecaller-users") == "1") { ?>
       <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Healthcare-Coordinator-Customers Healthcare-Coordinator-Customer-Requests Purchased-Memberships Healthcare-Coordinator-Vaccine-Requests Healthcare-Coordinator-bookappointment-Requests ">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">APP Users</span>
         </a>
         <ul class="br-menu-sub sp">
             <li class="sub-item"><a href="<?php echo adminurl("Healthcare-Coordinator-Customers");?>" class="Healthcare-Coordinator-Customers sub-link">Customers</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Healthcare-Coordinator-Customer-Recent-Requests");?>" class="Healthcare-Coordinator-Customer-Recent-Requests sub-link">Customer Recent Requests</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Healthcare-Coordinator-Customer-Requests");?>" class="Healthcare-Coordinator-Customer-Requests sub-link">Customer Requests</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Purchased-Memberships");?>" class="Purchased-Memberships sub-link">Purchased Packages</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Healthcare-Coordinator-Vaccine-Requests");?>" class="Healthcare-Coordinator-Vaccine-Requests sub-link">Vaccine Requests</a></li>
             <li class="sub-item"><a href="<?php echo adminurl("Healthcare-Coordinator-bookappointment-Requests");?>" class="Healthcare-Coordinator-bookappointment-Requests sub-link">Bookappointment Requests</a></li>
             
         </ul>
      </li>
     
      <?php }
      
        //if($this->session->userdata("manage-app-update") == "1") { ?>
      <!-- <li class="br-menu-item">-->
      <!--   <a href="<?php //echo adminurl('App-Updates') ?>" class="br-menu-link ">-->
      <!--      <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>-->
      <!--      <span class="menu-item-label">APP Updates</span>-->
      <!--   </a>-->
         
      <!--</li>-->
     
      <?php //}
      
        /**************   Doctor *****************************/
        
       if($this->session->userdata("manage-doctor-users") == "1") { ?>
       <li class="br-menu-item">
         <a href="javascript:void(0);" class="br-menu-link with-sub Doctor-Customers">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">APP Users</span>
         </a>
         <ul class="br-menu-sub sp">
             <li class="sub-item"><a href="<?php echo adminurl("Doctor-Customers");?>" class="Doctor-Customers sub-link">Customers</a></li>
         </ul>
      </li>
      <?php }  ?>
   </ul>
</div>