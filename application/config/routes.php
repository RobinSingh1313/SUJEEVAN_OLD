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

// default routings
$route['default_controller'] = 'Website';
$route['404_override'] = 'Website/page_not_found';
$route['translate_uri_dashes'] = FALSE;

// admin routings
$route['admin'] = 'Admin/index';
$route['admin-auth'] = 'Admin/auth';
$route['admin/change-password'] = 'Admin/change_password';
$route['admin/logout'] = 'Admin/logout';
$route['admin/update-password'] = 'Admin/update_password';
$route['admin/add-category-form'] = 'Admin/add_category_form';
$route['admin/save-category'] = 'Admin/save_category';
$route['admin/categories-list'] = 'Admin/categories_list';
$route['admin/edit-category/(:any)'] = 'Admin/edit_category/$1';
$route['admin/update-category/(:any)'] = 'Admin/update_category/$1';
$route['admin/add-post-page'] = 'Admin/add_post_page';
$route['admin/save-post'] = 'Admin/save_post';
$route['admin/posts-list'] = 'Admin/posts_list';
$route['admin/filter-posts'] = 'Admin/filter_posts';
$route['admin/edit-post/(:any)'] = 'Admin/edit_post/$1';
$route['admin/update-post/(:any)'] = 'Admin/update_post/$1';
$route['admin/contacts-list'] = 'Admin/contacts_list';
$route['admin/delete-contact/(:any)'] = 'Admin/delete_contact/$1';
$route['admin/schedule-demos-list'] = 'Admin/schedule_demos_list';
$route['admin/delete-demo/(:any)'] = 'Admin/delete_demo/$1';
$route['admin/business-enquiries-list'] = 'Admin/business_enquiries_list';
$route['admin/delete-business-enquiry/(:any)'] = 'Admin/delete_business_enquiry/$1';
$route['admin/add-webinar'] = 'Admin/add_webinar';
$route['admin/save-webinar'] = 'Admin/save_webinar';
$route['admin/webinar-list'] = 'Admin/webinar_list';
$route['admin/edit-webinar/(:any)'] = 'Admin/edit_webinar/$1';
$route['admin/update-webinar/(:any)'] = 'Admin/update_webinar/$1';
$route['admin/add-podcast'] = 'Admin/add_podcast';
$route['admin/save-podcast'] = 'Admin/save_podcast';
$route['admin/podcast-list'] = 'Admin/podcast_list';
$route['admin/edit-podcast/(:any)'] = 'Admin/edit_podcast/$1';
$route['admin/update-podcast/(:any)'] = 'Admin/update_podcast/$1';
$route['admin/subscribers-list'] = 'Admin/subscribers_list';
// other routings
$route['static-website'] = 'Website/serve_static_website';
//website routings
$route['about-us'] = 'Website/about_us';
$route['doctor-consultation'] = 'Website/doctor_consultation';
$route['diet-nutrition'] = 'Website/diet_nutrition';
$route['fitness'] = 'Website/fitness';
$route['health-life-coaching'] = 'Website/health_life_coaching';
$route['why-sujeevan'] = 'Website/why_sujeevan';
$route['healthwellness-programs'] = 'Website/healthwellness_programs';
$route['weight_loss_program'] = 'Website/weight_loss_program';
$route['diabetic_care_program'] ='Website/diabetic_care_program';
$route['cardiac_care_program'] ='Website/cardiac_care_program';
$route['hypertension_care_program'] ='Website/hypertension_care_program';
$route['pregnancy_care_program'] ='Website/pregnancy_care_program';
$route['stress_management_programs'] ='Website/stress_management_programs';
$route['blogs'] ='Website/blogs';
$route['contactus'] = 'Website/contactus';
$route['save-appointment'] = 'Website/save_appointment';
$route['get-time-slots-by-date'] = 'Website/get_timeslots_by_date';
$route['blogs/(:any)/(:any)'] = 'Website/get_blogs_by_category/$2';
$route['success'] = 'Website/success';
$route['book-your-plan'] = 'Website/book_your_plan';
$route['save-booking-plan'] = 'Website/save_booking_plan';
$route['booking-success'] = 'Website/booking_success';