<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['Sujeevan-Admin/Permissions']                        =   'permissions/index';  
$route['Sujeevan-Admin/AjaxPermission']                     =   'permissions/AjaxPermission';  
$route['Sujeevan-Admin/Dashboard']                          =   'dashboard/index';  
$route['Sujeevan-Admin/Logout']                             =   'login/logout';  

$route['Sujeevan-Admin/Ajax-Role-Check']                    =   'role/unique_role_name';  
$route['Sujeevan-Admin/AjaxRoleCheck']                      =   'role/uniquerolename'; 
$route['Sujeevan-Admin/Ajax-Role-Active']                   =   'role/activedeactive';  
$route['Sujeevan-Admin/Roles']                              =   'role/index';  
$route['Sujeevan-Admin/viewRole/(:num)']                    =   'role/viewRole/$1';  
$route['Sujeevan-Admin/Update-Role/(:any)']                 =   'role/update_role/$1';  
$route['Sujeevan-Admin/Delete-Role/(:any)']                 =   'role/delete_role/$1';  

$route['Sujeevan-Admin/unique_user_name']                   = 'users/unique_user_name';
$route['Sujeevan-Admin/users']                              = 'users';
$route['Sujeevan-Admin/viewUser/(:num)']                    = 'users/viewUser/$1';
$route['Sujeevan-Admin/update-user/(:any)']                 = 'users/update_user/$1';
$route['Sujeevan-Admin/delete-user/(:any)']                 = 'users/delete_user/$1';
$route['Sujeevan-Admin/Ajax-Login-Users-Active']            = 'users/activedeactive';

$route['Sujeevan-Admin/Widgets']                            =   'widgets/index'; 
$route['Sujeevan-Admin/viewWidget/(:num)']                  =   'widgets/viewWidget/$1'; 
$route['Sujeevan-Admin/Update-Widget/(:any)']               =   'widgets/update_widget/$1'; 
$route['Sujeevan-Admin/Delete-Widget/(:any)']               =   'widgets/delete_widget/$1'; 
$route['Sujeevan-Admin/Ajax-Widget-Check']                  =   'widgets/unique_widget_name';

$route['Sujeevan-Admin/Modules']                            =   'allmodules/index';
$route['Sujeevan-Admin/Ajax-Module-Active']                 =   'allmodules/activedeactive';
$route['Sujeevan-Admin/viewModules/(:any)']                 =   'allmodules/viewModules/$1';
$route['Sujeevan-Admin/Update-Module/(:any)']               =   'allmodules/update_module/$1';



$route['Sujeevan-Admin/Sub-Module']                         =   'allmodules/submodules/index'; 
$route['Sujeevan-Admin/viewSubModule/(:num)']               =   'allmodules/submodules/viewSubModule/$1'; 
$route['Sujeevan-Admin/Create-Sub-Module']                  =   'allmodules/submodules/create_sub_module'; 
$route['Sujeevan-Admin/Update-Sub-Module/(:any)']           =   'allmodules/submodules/update_sub_module/$1'; 
$route['Sujeevan-Admin/Delete-Sub-Module/(:any)']           =   'allmodules/submodules/delete_sub_module/$1'; 
$route['Sujeevan-Admin/Ajax-Sub-Module-Active']             =   'allmodules/submodules/activedeactive';
$route['Sujeevan-Admin/Ajax-Submodule-Check']               =   'allmodules/submodules/unique_submodule_name'; 


$route['Sujeevan-Admin/Ajax-Content-Page-Active']           =   'content_pages/activedeactive';
$route['Sujeevan-Admin/Content-Pages']                      =   'content_pages/index'; 
$route['Sujeevan-Admin/Create-Content-Pages']               =   'content_pages/create_content'; 
$route['Sujeevan-Admin/viewContent/(:num)']                 =   'content_pages/viewContent/$1'; 
$route['Sujeevan-Admin/Update-Content-Page/(:any)']         =   'content_pages/update_content_page/$1'; 
$route['Sujeevan-Admin/Delete-Content-Page/(:any)']         =   'content_pages/delete_content_page/$1';

$route['Sujeevan-Admin/Blogs']                              =   'blogs/index'; 
$route['Sujeevan-Admin/viewBlog/(:num)']                    =   'blogs/viewBlog/$1'; 
$route['Sujeevan-Admin/Create-Blog']                        =   'blogs/create_blog'; 
$route['Sujeevan-Admin/Update-Blog/(:any)']                 =   'blogs/update_blog/$1'; 
$route['Sujeevan-Admin/Delete-Blog/(:any)']                 =   'blogs/delete_blog/$1'; 
$route['Sujeevan-Admin/Ajax-Blog-Active']                   =   'blogs/activedeactive';
$route['Sujeevan-Admin/Ajax-Blog-Options']                  =   'blogs/ajax_options';


$route['Sujeevan-Admin/Video-Type']                         =   'video_type/index'; 
$route['Sujeevan-Admin/viewVideoType/(:num)']               =   'video_type/viewvideo_type/$1'; 
$route['Sujeevan-Admin/Create-Video-Type']                  =   'video_type/create_video_type'; 
$route['Sujeevan-Admin/Update-Video-Type/(:any)']           =   'video_type/update_video_type/$1'; 
$route['Sujeevan-Admin/Delete-Video-Type/(:any)']           =   'video_type/delete_video_type/$1'; 
$route['Sujeevan-Admin/Ajax-Video-Type-Active']             =   'video_type/activedeactive';


$route['Sujeevan-Admin/Question-Answers']                   =   'questions/index'; 
$route['Sujeevan-Admin/viewQa/(:num)']                      =   'questions/viewqa/$1'; 
$route['Sujeevan-Admin/Create-Question-Answer']             =   'questions/create_qa'; 
$route['Sujeevan-Admin/Update-Question-Answer/(:any)']      =   'questions/update_qa/$1'; 
$route['Sujeevan-Admin/Delete-Question-Answer/(:any)']      =   'questions/delete_qa/$1'; 
$route['Sujeevan-Admin/Ajax-Question-Answer-Active']        =   'questions/activedeactive';

/** Health Category ****/
$route['Sujeevan-Admin/Ajax-Category-Check']                =   'health_category/unique_category_name'; 
$route['Sujeevan-Admin/Health-Category']                    =   'health_category/index'; 
$route['Sujeevan-Admin/viewCategoryHealth/(:num)']          =   'health_category/viewCategoryHealth/$1'; 
$route['Sujeevan-Admin/Update-Health-Category/(:any)']      =   'health_category/update_category/$1'; 
$route['Sujeevan-Admin/Delete-Health-Category/(:any)']      =   'health_category/delete_category/$1'; 
$route['Sujeevan-Admin/Ajax-Health-Category-Active']        =   'health_category/activedeactive';
$route['Sujeevan-Admin/Health-Specialization-Assign']       =   'health_category/assignspecialization';
$route['Sujeevan-Admin/assignHealthSpecialization/(:num)']  =   'health_category/assignHealthSpecialization/$1';
$route['Sujeevan-Admin/Update-Assign-Specialization/(:any)']=   'health_category/update_assign_specialization/$1';
$route['Sujeevan-Admin/Delete-Assign-Specialization/(:any)']=   'health_category/delete_assign_specialization/$1';

$route['Sujeevan-Admin/Ajax-Health-Category']               =   "common/healthcategory";
$route['Sujeevan-Admin/Ajax-Health-Sub-Category']           =   "common/healthsubcategory";
$route['Sujeevan-Admin/Ajax-Sub-Module']                    =   "common/ajax_submodules";

/** Health Category ****/
$route['Sujeevan-Admin/Ajax-Category-Check']                =   'health_category/sub_health/unique_category_name'; 
$route['Sujeevan-Admin/Health-Sub-Category']                =   'health_category/sub_health/index'; 
$route['Sujeevan-Admin/viewsubCategoryHealth/(:num)']       =   'health_category/sub_health/viewsubCategoryHealth/$1'; 
$route['Sujeevan-Admin/Update-Sub-Health-Category/(:any)']  =   'health_category/sub_health/update_category/$1'; 
$route['Sujeevan-Admin/Delete-Sub-Health-Category/(:any)']  =   'health_category/sub_health/delete_category/$1'; 
$route['Sujeevan-Admin/Ajax-Sub-Health-Category-Active']    =   'health_category/sub_health/activedeactivesubcate';

/*** Packages *******/


$route['Sujeevan-Admin/Ajax-Package-CheckValues']           =   'package/unique_packagenametype'; 
$route['Sujeevan-Admin/Package']                            =   'package/index'; 
$route['Sujeevan-Admin/viewPackage/(:num)']                 =   'package/viewpackage/$1'; 
// $route['Sujeevan-Admin/Create-Package']                  =   'package/create_package'; 
$route['Sujeevan-Admin/Update-Package/(:any)']              =   'package/update_package/$1'; 
$route['Sujeevan-Admin/Delete-Package/(:any)']              =   'package/delete_package/$1'; 
$route['Sujeevan-Admin/Ajax-Package-Active']                =   'package/activedeactive';


$route['Sujeevan-Admin/Ajax-Package-Details-Check']         =   'package_details/unique_package_details_name'; 
$route['Sujeevan-Admin/Package-Details']                    =   'package_details/index'; 
$route['Sujeevan-Admin/viewPackageDetails/(:num)']          =   'package_details/viewpackage_details/$1'; 
$route['Sujeevan-Admin/Create-Package-Details']             =   'package_details/create_package_details'; 
$route['Sujeevan-Admin/Update-Package-Details/(:any)']      =   'package_details/update_package_details/$1'; 
$route['Sujeevan-Admin/Delete-Package-Details/(:any)']      =   'package_details/delete_package_details/$1'; 
$route['Sujeevan-Admin/Ajax-Package-Details-Active']        =   'package_details/activedeactive';


/*** Medicine List *******/


$route['Sujeevan-Admin/Ajax-Medicine-List-CheckValues']     =   'medicine_list/unique_medicine_listnametype'; 
$route['Sujeevan-Admin/Medicine-List']                      =   'medicine_list/index'; 
$route['Sujeevan-Admin/viewMedicine-List/(:num)']           =   'medicine_list/viewmedicine_list/$1'; 
$route['Sujeevan-Admin/Update-Medicine-List/(:any)']        =   'medicine_list/update_medicine_list/$1'; 
$route['Sujeevan-Admin/Delete-Medicine-List/(:any)']        =   'medicine_list/delete_medicine_list/$1'; 
$route['Sujeevan-Admin/Ajax-Medicine-List-Active']          =   'medicine_list/activedeactive';

/*** Lab Test List *******/


$route['Sujeevan-Admin/Ajax-Lab-Test-List-CheckValues']     =   'lab_test_list/unique_lab_test_listnametype'; 
$route['Sujeevan-Admin/Lab-Test-List']                      =   'lab_test_list/index'; 
$route['Sujeevan-Admin/viewLab-Test-List/(:num)']           =   'lab_test_list/viewlab_test_list/$1'; 
$route['Sujeevan-Admin/Update-Lab-Test-List/(:any)']        =   'lab_test_list/update_lab_test_list/$1'; 
$route['Sujeevan-Admin/Delete-Lab-Test-List/(:any)']        =   'lab_test_list/delete_lab_test_list/$1'; 
$route['Sujeevan-Admin/Ajax-Lab-Test-List-Active']          =   'lab_test_list/activedeactive';

/*** Hospital Facilities *******/


$route['Sujeevan-Admin/Ajax-Hospital-Facilities-CheckValues']     =   'hospital_facilities/unique_hospital_facilitiesnametype'; 
$route['Sujeevan-Admin/Hospital-Facilities']                      =   'hospital_facilities/index'; 
$route['Sujeevan-Admin/viewHospital-Facilities/(:num)']           =   'hospital_facilities/viewhospital_facilities/$1'; 
$route['Sujeevan-Admin/Update-Hospital-Facilities/(:any)']        =   'hospital_facilities/update_hospital_facilities/$1'; 
$route['Sujeevan-Admin/Delete-Hospital-Facilities/(:any)']        =   'hospital_facilities/delete_hospital_facilities/$1'; 
$route['Sujeevan-Admin/Ajax-Hospital-Facilities-Active']          =   'hospital_facilities/activedeactive';


/*** Hospital Specialities *******/


$route['Sujeevan-Admin/Ajax-Hospital-Specialities-CheckValues']     =   'hospital_specialities/unique_hospital_specialitiesnametype'; 
$route['Sujeevan-Admin/Hospital-Specialities']                      =   'hospital_specialities/index'; 
$route['Sujeevan-Admin/viewHospital-Specialities/(:num)']           =   'hospital_specialities/viewhospital_specialities/$1'; 
$route['Sujeevan-Admin/Update-Hospital-Specialities/(:any)']        =   'hospital_specialities/update_hospital_specialities/$1'; 
$route['Sujeevan-Admin/Delete-Hospital-Specialities/(:any)']        =   'hospital_specialities/delete_hospital_specialities/$1'; 
$route['Sujeevan-Admin/Ajax-Hospital-Specialities-Active']          =   'hospital_specialities/activedeactive';

/*** Hospital Sub Specialities *******/


$route['Sujeevan-Admin/Ajax-Hospital-Sub-Specialities-CheckValues']     =   'hospital_specialities/hospital_sub_specialities/unique_hospital_sub_specialitiesnametype'; 
$route['Sujeevan-Admin/Hospital-Sub-Specialities']                      =   'hospital_specialities/hospital_sub_specialities/index'; 
$route['Sujeevan-Admin/viewHospital-Sub-Specialities/(:num)']           =   'hospital_specialities/hospital_sub_specialities/viewhospital_sub_specialities/$1'; 
$route['Sujeevan-Admin/Update-Hospital-Sub-Specialities/(:any)']        =   'hospital_specialities/hospital_sub_specialities/update_hospital_sub_specialities/$1'; 
$route['Sujeevan-Admin/Delete-Hospital-Sub-Specialities/(:any)']        =   'hospital_specialities/hospital_sub_specialities/delete_hospital_sub_specialities/$1'; 
$route['Sujeevan-Admin/Ajax-Hospital-Sub-Specialities-Active']          =   'hospital_specialities/hospital_sub_specialities/activedeactive';


/*** Membership *******/


$route['Sujeevan-Admin/Ajax-Membership-CheckValues']        =   'membership/unique_membershipnametype'; 
$route['Sujeevan-Admin/Membership']                         =   'membership/index'; 
$route['Sujeevan-Admin/viewMembership/(:num)']              =   'membership/viewmembership/$1'; 
$route['Sujeevan-Admin/Update-Membership/(:any)']           =   'membership/update_membership/$1'; 
$route['Sujeevan-Admin/Delete-Membership/(:any)']           =   'membership/delete_membership/$1'; 
$route['Sujeevan-Admin/Ajax-Membership-Active']             =   'membership/activedeactive';


$route['Sujeevan-Admin/Ajax-Category-Check']                =   'category/unique_category_name'; 
$route['Sujeevan-Admin/Category']                           =   'category/index'; 
$route['Sujeevan-Admin/viewCategory/(:num)']                =   'category/viewcategory/$1'; 
$route['Sujeevan-Admin/Create-Category']                    =   'category/create_category'; 
$route['Sujeevan-Admin/Update-Category/(:any)']             =   'category/update_category/$1'; 
$route['Sujeevan-Admin/Delete-Category/(:any)']             =   'category/delete_category/$1'; 
$route['Sujeevan-Admin/Ajax-Category-Active']               =   'category/activedeactive';

$route['Sujeevan-Admin/Homecare-Packages']                  =   'homecare/homepackages/index'; 
$route['Sujeevan-Admin/viewHomecarepackages/(:num)']        =   'homecare/homepackages/viewHomecarepackages/$1'; 
$route['Sujeevan-Admin/Update-Home-Packages/(:any)']        =   'homecare/homepackages/update_carepackages/$1'; 
$route['Sujeevan-Admin/Delete-Home-Packages/(:any)']        =   'homecare/homepackages/delete_carepackages/$1'; 
$route['Sujeevan-Admin/Ajax-Home-Packages-Active']          =   'homecare/homepackages/activedeactive';
$route['Sujeevan-Admin/Ajax-Package-Check']                 =   "homecare/homepackages/unique_package_name";


$route['Sujeevan-Admin/Specialization']                     =   'specialization/index'; 
$route['Sujeevan-Admin/Ajax-Specialization-Check']          =   'specialization/unique_specialization_name'; 
$route['Sujeevan-Admin/viewSpecialization/(:num)']          =   'specialization/viewSpecialization/$1'; 
$route['Sujeevan-Admin/Update-Specialization/(:any)']       =   'specialization/update_specialization/$1'; 
$route['Sujeevan-Admin/Delete-Specialization/(:any)']       =   'specialization/delete_specialization/$1'; 
$route['Sujeevan-Admin/Ajax-Specialization-Active']         =   'specialization/activedeactive';



$route['Sujeevan-Admin/Wellness']                           =   'wellness/index'; 
$route['Sujeevan-Admin/Ajax-Wellness-Check']                =   'wellness/unique_wellness_name'; 
$route['Sujeevan-Admin/viewWellness/(:num)']                =   'wellness/viewWellness/$1'; 
$route['Sujeevan-Admin/Update-Wellness/(:any)']             =   'wellness/update_wellness/$1'; 
$route['Sujeevan-Admin/Delete-Wellness/(:any)']             =   'wellness/delete_wellness/$1'; 
$route['Sujeevan-Admin/Ajax-Wellness-Active']               =   'wellness/activedeactive';
$route['Sujeevan-Admin/Wellness-Contact']                   =   'wellness/wellness_contact'; 
$route['Sujeevan-Admin/viewWellnessContact/(:num)']         =   'wellness/viewWellnessContact/$1'; 



$route['Sujeevan-Admin/Banners']                            =   'banners/index'; 
$route['Sujeevan-Admin/Ajax-Banner-Check']                  =   'banners/unique_banner_name'; 
$route['Sujeevan-Admin/viewBanner/(:num)']                  =   'banners/viewBanner/$1'; 
$route['Sujeevan-Admin/Update-Banner/(:any)']               =   'banners/update_banner/$1'; 
$route['Sujeevan-Admin/Delete-Banner/(:any)']               =   'banners/delete_banner/$1'; 
$route['Sujeevan-Admin/Ajax-Banner-Active']                 =   'banners/activedeactive';



$route['Sujeevan-Admin/Homecare-Tests']                     =   'homecare/hometests/index'; 
$route['Sujeevan-Admin/viewHomecaretests/(:num)']           =   'homecare/hometests/viewHomecaretests/$1'; 
$route['Sujeevan-Admin/Update-Home-Tests/(:any)']           =   'homecare/hometests/update_caretests/$1'; 
$route['Sujeevan-Admin/Delete-Home-Tests/(:any)']           =   'homecare/hometests/delete_caretests/$1'; 
$route['Sujeevan-Admin/Ajax-Home-Tests-Active']             =   'homecare/hometests/activedeactive';
$route['Sujeevan-Admin/Ajax-Test-Check']                    =   "homecare/hometests/unique_test_name";

$route['Sujeevan-Admin/Create-Works']                       =   'homecare/works/create_works'; 
$route['Sujeevan-Admin/Works']                              =   'homecare/works/index'; 
$route['Sujeevan-Admin/viewWorks/(:num)']    	            =   'homecare/works/viewWorks/$1'; 
$route['Sujeevan-Admin/Update-Works/(:any)']                =   'homecare/works/update_works/$1'; 
$route['Sujeevan-Admin/Delete-Works/(:any)']                =   'homecare/works/delete_works/$1'; 
$route['Sujeevan-Admin/Ajax-Works-Active']                  =   'homecare/works/activedeactive';
/** Health Tips ***/ 
$route['Sujeevan-Admin/Health-Tips']                        =   'healthtips/index'; 
$route['Sujeevan-Admin/viewHealthtips/(:num)']    	        =   'healthtips/viewHealthtips/$1'; 
$route['Sujeevan-Admin/Update-Health-Tip/(:any)']           =   'healthtips/update_healthtips/$1'; 
$route['Sujeevan-Admin/Delete-Health-Tip/(:any)']           =   'healthtips/delete_healthtips/$1'; 
$route['Sujeevan-Admin/Ajax-Health-Tip-Active']             =   'healthtips/activedeactive';

$route['Sujeevan-Admin/Vendors']             	            =   'vendors/index'; 
$route['Sujeevan-Admin/Ajax-Vendor-Check']                  =   'vendors/unique_vendor_name'; 
$route['Sujeevan-Admin/Create-Vendor']                      =   'vendors/create_Vendors'; 
$route['Sujeevan-Admin/viewVendors/(:num)']    	            =   'vendors/viewVendors/$1'; 
$route['Sujeevan-Admin/Update-Vendor/(:any)']               =   'vendors/update_vendors/$1'; 
$route['Sujeevan-Admin/Delete-Vendor/(:any)']               =   'vendors/delete_vendors/$1'; 
$route['Sujeevan-Admin/Ajax-Vendor-Active']                 =   'vendors/activedeactive';

$route['Sujeevan-Admin/Sub-Vendors']             	        =   'vendors/sub_vendors/index'; 
$route['Sujeevan-Admin/Create-Sub-Vendor']                  =   'vendors/sub_vendors/create_sub_vendors'; 
$route['Sujeevan-Admin/viewSubVendors/(:num)']    	        =   'vendors/sub_vendors/viewsub_vendors/$1'; 
$route['Sujeevan-Admin/Update-Sub-Vendor/(:any)']           =   'vendors/sub_vendors/update_sub_vendors/$1'; 
$route['Sujeevan-Admin/Delete-Sub-Vendor/(:any)']           =   'vendors/sub_vendors/delete_sub_vendors/$1'; 
$route['Sujeevan-Admin/Ajax-Sub-Vendor-Active']             =   'vendors/sub_vendors/activedeactive';


$route['Sujeevan-Admin/Sub-Category']                       =   'sub_category/index'; 
$route['Sujeevan-Admin/viewSubCategory/(:num)']             =   'sub_category/viewsub_category/$1'; 
$route['Sujeevan-Admin/Create-Sub-Category']                =   'sub_category/create_sub_category'; 
$route['Sujeevan-Admin/Update-Sub-Category/(:any)']         =   'sub_category/update_sub_category/$1'; 
$route['Sujeevan-Admin/Delete-Sub-Category/(:any)']         =   'sub_category/delete_sub_category/$1'; 
$route['Sujeevan-Admin/Ajax-Sub-Category-Active']           =   'sub_category/activedeactive';
$route['Sujeevan-Admin/Ajax-Category-List']                 =   'sub_category/ajax_category'; 


/*********** Specialization Chat Bot ********/
$route["Sujeevan-Admin/Symptoms-Chat-Bot"]                  =   "chat_bot/symptoms/index";
$route["Sujeevan-Admin/viewSymptomsbot/(:num)"]             =   "chat_bot/symptoms/viewSymptomsbot/$1";
$route["Sujeevan-Admin/Delete-SymptomChat-Bot/(:any)"]      =   "chat_bot/symptoms/deletebot/$1";
$route["Sujeevan-Admin/Update-SymptomChat-Bot/(:any)"]      =   "chat_bot/symptoms/updatebot/$1";
$route['Sujeevan-Admin/Ajax-Chat-Symptom-Active']           =   'chat_bot/symptoms/activedeactive';


/*********** Homecare Chat Bot ********/
$route["Sujeevan-Admin/Homecare-Chat-Bot"]                  =   "chat_bot/homecare/index";
$route["Sujeevan-Admin/viewHomecarebot/(:num)"]             =   "chat_bot/homecare/viewHomecarebot/$1";
$route["Sujeevan-Admin/Delete-HomecareChat-Bot/(:any)"]     =   "chat_bot/homecare/deletebot/$1";
$route["Sujeevan-Admin/Update-HomecareChat-Bot/(:any)"]     =   "chat_bot/homecare/updatebot/$1";
$route['Sujeevan-Admin/Ajax-Chat-Homecare-Active']          =   'chat_bot/homecare/activedeactive';

/** Consult Chat Bot ****/
$route["Sujeevan-Admin/Consult-Chat-Bot"]                   =   "chat_bot/consult/index";
$route["Sujeevan-Admin/viewConsultbot/(:num)"]              =   "chat_bot/consult/viewconsultbot/$1";
$route["Sujeevan-Admin/Delete-ConsultChat-Bot/(:any)"]      =   "chat_bot/consult/deletebot/$1";
$route["Sujeevan-Admin/Update-ConsultChat-Bot/(:any)"]      =   "chat_bot/consult/updatebot/$1";
$route['Sujeevan-Admin/Ajax-Chat-Consult-Active']           =   'chat_bot/consult/activedeactive';


/*********** Bot Room ********/
$route["Sujeevan-Admin/Chat-Room-Configuration"]            =   "complaints/botconfiguration/index";
$route["Sujeevan-Admin/viewBotconfig/(:num)"]               =   "complaints/botconfiguration/viewBotconfig/$1";
$route["Sujeevan-Admin/Delete-bot/(:any)"]                  =   "complaints/botconfiguration/deleteebot/$1";
$route["Sujeevan-Admin/Update-bot/(:any)"]                  =   "complaints/botconfiguration/updatebot/$1";
$route['Sujeevan-Admin/Ajax-bot-Active']                    =   'complaints/botconfiguration/activedeactive';


$route['Sujeevan-Admin/Registration']                       =   'registration/index'; 
$route['Sujeevan-Admin/viewRegistration/(:num)']            =   'registration/viewregistration/$1';  
$route['Sujeevan-Admin/Delete-Registration/(:any)']         =   'registration/delete_registration/$1'; 
$route['Sujeevan-Admin/Ajax-Registration-Active']           =   'registration/activedeactive';


/************* Doctors *************/

$route['Sujeevan-Admin/Doctor']                             =   'employee/doctor/index'; 
$route['Sujeevan-Admin/Ajax-Doctor-Check']                  =   'employee/doctor/unique_doctor_name'; 
$route['Sujeevan-Admin/viewDoctor/(:num)']                  =   'employee/doctor/viewDoctor/$1'; 
$route['Sujeevan-Admin/Update-Doctor/(:any)']               =   'employee/doctor/update_doctor/$1'; 
$route['Sujeevan-Admin/Delete-Doctor/(:any)']               =   'employee/doctor/delete_doctor/$1'; 
$route['Sujeevan-Admin/Ajax-Doctor-Active']                 =   'employee/doctor/activedeactive';
$route['Sujeevan-Admin/Doctor-Contact']                     =   'employee/doctor/doctor_contact'; 
$route['Sujeevan-Admin/viewDoctorContact/(:num)']           =   'employee/doctor/viewDoctorContact/$1';


$route['Sujeevan-Admin/Specialities']                       =   'common/common2/specialities'; 
$route['Sujeevan-Admin/viewSpecialities/(:num)']            =   'common/common2/viewSpecialities/$1';  
$route['Sujeevan-Admin/Packages']                           =   'common/common2/packages'; 
$route['Sujeevan-Admin/viewPackages/(:num)']                =   'common/common2/viewPackages/$1';  
$route['Sujeevan-Admin/Facilities']                         =   'common/common2/facilities'; 
$route['Sujeevan-Admin/viewFacilities/(:num)']              =   'common/common2/viewFacilities/$1';  


$route['Sujeevan-Admin/App-Vendors']                        =   'app_users/index'; 
$route['Sujeevan-Admin/viewAppvendors/(:num)']              =   'app_users/viewAppvendors/$1';  
$route['Sujeevan-Admin/App-Customers']                      =   'app_users/indexcustomers'; 
$route['Sujeevan-Admin/viewAppCustomers/(:num)']            =   'app_users/viewAppCustomers/$1';  
$route['Sujeevan-Admin/Upload-Video-Files']                 =   'common/uploaduserfilefiles'; 
$route['Sujeevan-Admin/Remove-Video']                       =   'common/removevideo'; 
$route['Sujeevan-Admin/Assign-Telecaller']                  =   'app_users/assignTelecaller';
$route['Sujeevan-Admin/Assign-Doctor']                      =   'app_users/assignDoctor';
$route['Sujeevan-Admin/Ajax-Register-Active']               =   'app_users/activedeactive'; 
    

$route['Sujeevan-Admin/Clearfilter']                        =   'common/clearfilter';  
$route['Sujeevan-Admin/Book-Appointment-Time-Slot']      	=   'common/BookAppointmentTimeSlot'; 
$route['Sujeevan-Admin']                                    =   'login';  
$route['Forgot-Password']      	                            =   'login/forgot'; 
$route['Sujeevan-Admin/Ajax-Vendors']      	                =   'common/vendorsajax'; 
$route['Ajax-User-Email']      	                            =   'login/checkemailexist'; 
$route['Ajax-User-Exist']      	                            =   'login/checkusernameexist'; 
$route['default_controller']                                =   'login';


/**************************  telecaller *******************************/

$route['Sujeevan-Admin/Healthcare-Coordinator-Customers']               =   'telecaller/telecaller_users/indexcustomers'; 
$route['Sujeevan-Admin/viewTelecallerCustomers/(:num)']     =   'telecaller/telecaller_users/viewTelecallerCustomers/$1';
$route['Sujeevan-Admin/AjaxCustomersDetails/(:num)']        =   'telecaller/telecaller_users/AjaxCustomersDetails/$1';
$route['Sujeevan-Admin/Ajax-User-History']                  =   'telecaller/telecaller_users/AjaxUserHistory';
$route['Sujeevan-Admin/Ajax-Update-Response']               =   'telecaller/telecaller_users/AjaxUpdateResponse';
$route['Sujeevan-Admin/Ajax-Doctor-Select']                 =   'telecaller/telecaller_users/AjaxDoctorSelect';
$route['Sujeevan-Admin/Ajax-Doctor-Assign']                 =   'telecaller/telecaller_users/AjaxDoctorAssign';
$route['Sujeevan-Admin/Ajax-Update-Health-Condition']       =   'telecaller/telecaller_users/AjaxUpdateHealthCondition';
$route['Sujeevan-Admin/User-Package']                       =   'telecaller/telecaller_users/UserPackage';
$route['Sujeevan-Admin/Chatbot']                            =   'telecaller/telecaller_users/Chatbot';

$route['Sujeevan-Admin/Chatbot-Response']                   =   'telecaller/telecaller_users/chatbot_response';


$route['Sujeevan-Admin/Case-Sheet']                         =   'telecaller/telecaller_users/CaseSheet';
$route['Sujeevan-Admin/Vital']                              =   'telecaller/telecaller_users/Vitals';
$route['Sujeevan-Admin/Previous-Reports']                   =   'telecaller/telecaller_users/PreviousReports';

$route['Sujeevan-Admin/Case-Sheet-History']                 =   'telecaller/telecaller_users/CaseSheetHistory';
$route['Sujeevan-Admin/Vital-History']                      =   'telecaller/telecaller_users/VitalsHistory';
$route['Sujeevan-Admin/Previous-Reports-History']           =   'telecaller/telecaller_users/PreviousReportsHistory';


$route['Sujeevan-Admin/Membership-Purchase']                =   'telecaller/telecaller_users/membership_purchase';
$route['Sujeevan-Admin/Assign-Membership']                  =   'telecaller/telecaller_users/membership_assign';
$route['Sujeevan-Admin/Ajax-Select-VendorList']             =   'telecaller/telecaller_users/AjaxSelectVendorList';
$route['Sujeevan-Admin/Ajax-Membership-Assign-Feilds']      =   'telecaller/telecaller_users/AjaxMembershipAssignFeilds';
$route['Sujeevan-Admin/Ajax-Get-Package-Details']           =   'telecaller/telecaller_users/AjaxGetPackageDetails';
$route['Sujeevan-Admin/Healthcare-Coordinator-Customer-Requests']       =   'telecaller/telecaller_users/customersrequest'; 
$route['Sujeevan-Admin/viewCustomersRequest/(:num)']        =   'telecaller/telecaller_users/viewCustomersRequest/$1';
$route['Sujeevan-Admin/Ajax-Customer-Request-Status']       =   'telecaller/telecaller_users/AjaxCustomerRequestStatus';
$route['Sujeevan-Admin/Ajax-Update-Contact-Response']       =   'telecaller/telecaller_users/AjaxUpdateContactResponse';
$route['Sujeevan-Admin/Investigation']                      =   'telecaller/telecaller_users/Investigation';
$route['Sujeevan-Admin/Medication']                         =   'telecaller/telecaller_users/Medication';
// $route['Sujeevan-Admin/Ajax-Sub-Module']                    =   'telecaller/telecaller_users/ajax_submodules';
$route['Sujeevan-Admin/Purchased-Memberships']               =   'telecaller/telecaller_users/PurchasedMemberships'; 
$route['Sujeevan-Admin/viewPurchasedMemberships/(:num)']     =   'telecaller/telecaller_users/viewPurchasedMemberships/$1';
$route['Sujeevan-Admin/Healthcare-Coordinator-Vaccine-Requests']       =   'telecaller/telecaller_users/vaccinerequest'; 
$route['Sujeevan-Admin/viewVaccineRequest/(:num)']        =   'telecaller/telecaller_users/viewVaccineRequest/$1';
$route['Sujeevan-Admin/Ajax-Vaccine-Request-Status']       =   'telecaller/telecaller_users/AjaxVaccineRequestStatus';
$route['Sujeevan-Admin/Healthcare-Coordinator-bookappointment-Requests']       =   'telecaller/telecaller_users/bookappointmentrequest'; 
$route['Sujeevan-Admin/viewbookappointmentRequest/(:num)']        =   'telecaller/telecaller_users/viewbookappointmentRequest/$1';
$route['Sujeevan-Admin/Ajax-bookappointment-Request-Status']       =   'telecaller/telecaller_users/AjaxbookappointmentRequestStatus';
$route['Sujeevan-Admin/Healthcare-Coordinator-Customer-Recent-Requests']       =   'telecaller/telecaller_users/customersrecentrequest'; 
$route['Sujeevan-Admin/viewCustomersRecentRequest/(:num)']        =   'telecaller/telecaller_users/viewCustomersRecentRequest/$1';
$route['Sujeevan-Admin/check_doctor_timeslot']                         =   'telecaller/telecaller_users/check_doctor_timeslot';


/*----------------------------------Pinky 21-03-2022------------------------------------------*/
$route['Sujeevan-Admin/App-Updates']         =   'app_updates'; 
$route['Sujeevan-Admin/notify_appointusers']  =   'app_updates/notify_appointusers';

/*----------------------------------Pinky 21-03-2022------------------------------------------*/
/**************************  Doctor *******************************/

$route['Sujeevan-Admin/Doctor-Customers']                   =   'doctor/doctor_users/indexcustomers'; 
$route['Sujeevan-Admin/viewDoctorCustomers/(:num)']         =   'doctor/doctor_users/viewDoctorCustomers/$1';




/********** Scores ********/
$route['api-gfr']                                           =   "api/api_scores/gfr";
$route['api-bmi']                                           =   "api/api_scores/bmi";
$route['api-heart-score']                                   =   "api/api_scores/heart_score";
$route['api-insulin-resistance']                            =   "api/api_scores/insulin_resistance";


$route['apiregisterview']                                   =   "api/register";
$route['api-send-otp']                                      =   "api/sendotp";
$route['api-otp-verify']                                    =   "api/otp_verify";
$route['api-customer-forget-password-change']               =   "api/customer_forget_password_change";
$route['apiadddetails']                                     =   "api/update_basic_details";
$route['api-login']                                         =   "api/login";
$route['api-splash']                                        =   "api/splash";
$route['api-changepassword']                                =   "api/changepassword";
$route['api-token']                                         =   "api/token";
$route['api-logout']                                        =   "api/logout";
$route['api-sub-module']                                    =   "api/submodule";
$route['api-subviewmodule']                                 =   "api/submoduleview";
$route['api-blogs']    		                                =   "api/blogs";
$route['api-blogs-view']    	                            =   "api/blogsview";
$route['api-questions']    	                                =   "api/questions";
$route['api-update-details']                                =   "api/update_basic_details";
$route['api-home-packages']    	                            =   "api/homepackages";
$route['api-home-tests']    	                            =   "api/hometest";
$route['api-packages']                                      =   "api/getPackages";
$route['api-homecare-membership']                           =   "api/homecareMembership";
$route['api-homecare-membership-purchase']                  =   "api/homecareMembershipPurchase";
$route['api-wellness']                                      =   "api/wellness";
$route['api-wellness-detials']                              =   "api/wellness_details";
$route['api-wellness-contact']                              =   "api/wellness_contact";
$route['api-queries']                                       =   "api/queries";
$route['api-consultation']                                  =   "api/consultation";
$route['api-consultation-view']                             =   "api/consultationview";
$route['api-chat-room']                                     =   "api/chatroom";
$route['api-symptoms-checker']                              =   "api/consultdoctors";
$route['api-consult-doctor']                                =   "api/symptoms_checker";
$route['api-sub-health-symptoms']                           =   'api/healthsymptoms';
$route['api-customer-support']                              =   "api/support";
$route['api-vaccine-request']                               =   "api/vaccine_request";
$route['api-bookappointment-request']                       =   "api/bookappointment_request";
$route['api-available-doctors-with-slots']                  =   "api/available_doctors_with_slots";
$route['api-available-doctors']                             =   "api/available_doctors";
$route['api-weekdays']                                      =   "api/weekdays";


/*** Vendor ****/
$route['apivendorregister']                                 =   "api/vendor_api/register";
$route['api-send-vendor-otp']                               =   "api/vendor_api/sendotp";
$route['api-verify-otp']                                    =   "api/vendor_api/otp_verify";
$route['api-forget-password-change']                        =   "api/vendor_api/forget_password_change";
$route['api-vendor-token']                                  =   "api/vendor_api/token";
$route['api-vendor-profile']                                =   "api/vendor_api/vendoriconcreate";
$route['api-vendors']    	                                =   "api/vendor_api/vendors";
$route['api-masters']   	                                =   "api/vendor_api/alldata";
$route['api-cities']                                        =   "api/vendor_api/cities";
$route['api-measures']                                      =   "api/vendor_api/measures";
$route['api-doctors']   	                                =   "api/vendor_api/doctors";
$route['api-vendor-splash']                                 =   "api/vendor_api/splash";
$route['api-vendor-login']                                  =   "api/vendor_api/login";
$route['api-vendor-logout']                                 =   "api/vendor_api/logout";
$route['api-vendor-stage']                                  =   "api/vendor_api/stage_profile";
$route['api-vendor-create']                                 =   "api/vendor_api/create_profile";
$route['api-vendor-rating']                                 =   "api/vendor_api/rating";
$route['api-vendor-support']                                =   "api/vendor_api/support";
$route['api-vendor-changepassword']                         =   "api/vendor_api/changepassword";
$route['api-vendor-accounts']                               =   "api/vendor_api/accounts";
$route['api-vendor-packages']                               =   "api/vendor_api/packages";
// $route['api-vendor-availbility']                         =   "api/vendor_api/availbility";
$route['api-vendor-visibility']                             =   "api/vendor_api/visibility";
$route['api-vendor-blogs']                                  =   "api/vendor_api/blogs";
$route['api-vendor-queries']                                =   "api/vendor_api/queries";
$route['api-update-profile']                                =   "api/vendor_api/update_profile";
$route['api-vendor-qualification']                          =   "api/vendor_api/qualificaitons";
$route['api-vendor-availability']                           =   "api/vendor_api/register_availability";
$route['api-vendor-earnings']                               =   "api/vendor_api/earnings";
$route['api-vendor-transaction']                            =   "api/vendor_api/transaction";
$route['api-vendor-appointments']                           =   "api/vendor_api/register_appointments";
$route['api-vendor-medications']                            =   "api/vendor_api/vital_medications";
$route['api-vendor-bp']                                     =   "api/vendor_api/vital_bp";
$route['api-vendor-nurse-vitals']                           =   "api/vendor_api/vital_nursemedications";
$route['api-vendor-products']                               =   "api/vendor_api/products";
$route['api-vendor-doctors']                                =   "api/vendor_api/doctors";
$route['api-vendor-specialities']                           =   "api/vendor_api/specialities";
$route['api-vendor-facilities']                             =   "api/vendor_api/facilites";
$route['api-doctors-list']                                  =   "api/doctors_list";
$route['api-vendor-list']                                   =   "api/vendor_list";
$route['api-doctor-info']                                   =   "api/doctor_info";
$route['api-basic-chatbot']                                 =   "api/basic_chatbot";
$route['api-homecare-chatbot']                              =   "api/homecare_chatbot";
$route['api-basic-chatbot-save']                            =   "api/basic_chatbot_save";
$route['api-homecare-chatbot-save']                         =   "api/homecare_chatbot_save";
$route['api-user-questions']                                =   "api/user_questions";
$route['api-multiple-answers']                              =   "api/multiple_answer_list";
$route['api-likes']                                         =   "api/likes";
$route['api-blog-likes']                                    =   "api/blog_likes";
$route['api-payments']                                      =   "api/payment";
$route['api-health-category']                               =   "api/health_category_list";
$route['api-health-sub-category']                           =   "api/health_sub_category_list";
$route['api-customer-details']                              =   "api/customer_details";
$route['api-booked-dates']                                  =   "api/booked_dates";
$route['api-check-availability']                            =   "api/check_availability";
$route['api-user-profile']                                  =   "api/user_profile";
$route['api-user-homecare-click']                           =   "api/homecare_click";
$route['api-employee-doctor-list']                          =   "api/Doctor_list";
$route['api-previous-reports']                              =   "api/previous_reports";
$route['api-health-files']                                  =   "api/health_files";
$route['api-delete-health-files']                           =   "api/delete_health_files";
$route['api-medicine-list']                                 =   "api/medicine_list";
$route['api-lab-test-list']                                 =   "api/lab_test_list";  
$route['api-prescription-history']                          =   "api/prescription_history";  
$route['api-prescription-download']                          =   "api/prescription_download";  

$route['api-purchase-history']                              =   "api/purchase_history"; 
$route['api-homecare-daywise']                              =   "api/homecare_daywise"; 
$route['api-appiontment-otp-verify']                        =   "api/vendor_api/appiontment_otp_verify"; 
$route['api-membership-assign-description']                 =   "api/vendor_api/membership_assign_description";
$route['api-get-membership-assign-description']             =   "api/vendor_api/get_membership_assign_description";
$route['api-notification-history']                              =   "api/notification_history"; 


$route['api-customer-support-request']                      =   "api/customer_support_request";
$route['api-assigned-customer']                             =   "api/vendor_api/assigned_customer";
$route['api-assigned-history']                              =   "api/vendor_api/assigned_customer_history";
$route['api-vendor-prescription']                           =   "api/vendor_api/prescription";
$route['api-vendor-prescription-all']                       =   "api/vendor_api/prescription_all";
$route['api-vendor-prescription-update']                    =   "api/vendor_api/prescription_update";
$route['api-vendor-vital']                                  =   "api/vendor_api/vital";
$route['api-vendor-vital-all']                              =   "api/vendor_api/vital_all";
$route['api-vendor-vital-update']                           =   "api/vendor_api/vital_update";
$route['api-vendor-investigation']                          =   "api/vendor_api/investigation";
$route['api-vendor-investigation-update']                   =   "api/vendor_api/investigation_update";
$route['api-vendor-result']                                 =   "api/vendor_api/result";
$route['api-vendor-result-update']                          =   "api/vendor_api/result_update";
$route['api-vendor-medication']                             =   "api/vendor_api/medication";
$route['api-vendor-medication-update']                      =   "api/vendor_api/medication_update";
$route['api-vendor-review']                                 =   "api/vendor_api/review";
$route['api-vendor-review-update']                          =   "api/vendor_api/review_update";
$route['api-blog-modules']                                  =   "api/vendor_api/blog_modules";
$route['api-search-facility']                               =   "api/vendor_api/search_facility";
$route['api-search-speciality']                             =   "api/vendor_api/search_speciality";
$route['api-search-sub-speciality']                         =   "api/vendor_api/search_sub_speciality";
$route['api-create-vendor-availability']                    =   "api/vendor_api/create_vendor_availability";
$route['api-update-vendor-availability']                    =   "api/vendor_api/update_vendor_availability";
$route['api-delete-vendor-availability']                    =   "api/vendor_api/delete_vendor_availability";
$route['api-get-vendor-availability']                       =   "api/vendor_api/get_vendor_availability";
$route['api-get-vendor-day-availability']                   =   "api/vendor_api/get_vendor_day_availability";
$route['api-vendor-availability']                           =   "api/vendor_api/vendor_availability";
$route['api-available-slots']                               =   "api/vendor_api/available_slots";

$route['api_check_user']                                    = 'api/checkLogin';
$route['api_check_vendor']                                  = 'api/vendor_api/checkLogin';



$route['api-homecare-chatbot-test-ios']                     =   "api/homecare_chatbot_test_ios";



// $route['api-signup']    = "api/signup";
// $route['api-content']   = "api/content";
// $route['api-countries'] = "api/countries";
// $route['api-login']     = "api/login";
// $route['api-contact']   = "api/contactus";
// $route['api-forgot']   = "api/forgot";
// $route['api-splash']   = "api/splash";
$route['translate_uri_dashes'] = FALSE;