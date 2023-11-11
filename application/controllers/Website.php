<?php
	ob_start();
	// error_reporting(0);
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Website extends CI_Controller 
	{
		public function __construct()
		{
			parent :: __construct();
			date_default_timezone_set('Asia/Kolkata');
		}
		function page_not_found()
		{
			header('Content-Type: application/json');
			echo(json_encode(
				[
					'status'	=>	400,
					'message'	=>	'the page you requested was not found',
					'data'		=>	[]
				],
				JSON_PRETTY_PRINT
			));
		}
		function index()
		{
			$this->load->view('website/pages/index');
		}
		function about_us()
		{
			$this->load->view('website/pages/about_us');
		}
		function footer()
		{
			return $this->load->view('website/includes/footer');
		}
		function diet_nutrition()
		{
		    $blogs = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_category_id','2')->where('mcdp_status',1)->order_by('mcdp_id','desc')->limit(4)->get()->result();
		    $data['blogs'] = $blogs;
			$this->load->view('website/pages/diet_nutrition',$data);
		}
		function doctor_consultation()
		{
		    $blogs = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_category_id','4')->where('mcdp_status',1)->order_by('mcdp_id','desc')->limit(4)->get()->result();
		    $data['blogs'] = $blogs;
			$this->load->view('website/pages/doctor_consultation',$data);
		}
		function fitness()
		{
		    $blogs = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_category_id','3')->where('mcdp_status',1)->order_by('mcdp_id','desc')->limit(4)->get()->result();
		    $data['blogs'] = $blogs;
			$this->load->view('website/pages/fitness',$data);
		}
		function health_life_coaching()
		{
		    $blogs = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_category_id','1')->where('mcdp_status',1)->order_by('mcdp_id','desc')->limit(4)->get()->result();
		    $data['blogs'] = $blogs;
			$this->load->view('website/pages/health-life-coaching',$data);
		}
		function get_blogs_by_category($category_id)
		{
		    $blogs = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_category_id',$category_id)->where('mcdp_status',1)->order_by('mcdp_id','desc')->get()->result();
		    $data['blogs'] = $blogs;
		    $data['category'] = $category_id;
			$this->load->view('website/pages/category_blogs',$data);
		}
		function blog_details($blog_id)
		{
		    $data['blog_details'] = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_id',$blog_id)->get()->result();
		    $this->load->view('website/pages/blog-details',$data);
		}
		function why_sujeevan()
		{
			$this->load->view('website/pages/why_sujeevan');
		}
		function healthwellness_programs()
		{
			$this->load->view('website/pages/healthwellness-programs');
		}
		function weight_loss_program()
		{
			$this->load->view('website/pages/weight_loss_program');
		}
		function diabetic_care_program()
		{
			$this->load->view('website/pages/diabetic_care_program');
		}
		function cardiac_care_program()
		{
			$this->load->view('website/pages/cardiac_care_program');
		}
		function hypertension_care_program()
		{
			$this->load->view('website/pages/hypertension_care_program');
		}
		function pregnancy_care_program()
		{
			$this->load->view('website/pages/pregnancy_care_program');
		}
		function stress_management_programs()
		{
			$this->load->view('website/pages/stress_management_programs');
		}
		function blogs()
		{
		    $categories = $this->db->select('mcim_id, mcim_name')->from('main_categories_information_master')->get()->result();
		    for($i=0;$i<count($categories);$i++){
		        $blogs = $this->db->select('*')->from('main_categories_data_postings')->where('mcdp_category_id',$categories[$i]->mcim_id)->where('mcdp_status',1)->order_by('mcdp_id','desc')->get()->result();
		        $categories[$i]->blogs = $blogs;
		    }
		    $data['blogs'] = $categories;
			$this->load->view('website/pages/blogs',$data);
		}
		function contactus()
		{
			$this->load->view('website/pages/contactus');
		}
		function save_contact()
		{
		    if($_POST)
			{
				$data = [
					'wcim_name'		=>		$_POST['wcim_name'],
					'wcim_mobile'	=>		$_POST['wcim_mobile'],
					'wcim_email'	=>		$_POST['wcim_email'],
					'wcim_city'		=>		$_POST['wcim_city'],
					'wcim_state'	=>		$_POST['wcim_state'],
					'wcim_dept'		=>		$_POST['wcim_dept'],
					'wcim_message'  =>      $_POST['wcim_message']
				];
				$config['upload_path'] = './file_uploads/contacts';
				$config['allowed_types'] = '*';
				$config['remove_spaces'] = TRUE;
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if(!empty($_FILES['wcim_profile_photo']['name'])){
				    $this->upload->do_upload('wcim_profile_photo');
				    $upload_info1 = $this->upload->data();
				    $data['wcim_profile_photo'] = $upload_info1['file_name'];
				}
				if(!empty($_FILES['wcim_medical_report']['name'])){
				    $this->upload->do_upload('wcim_medical_report');
				    $upload_info2 = $this->upload->data();
				    $data['wcim_medical_report'] = $upload_info2['file_name'];
				}
				$this->db->insert('website_contacts_information_master',$data);
				$html = '<html>
                            <head>
                            <style>
                            table {
                              font-family: arial, sans-serif;
                              border-collapse: collapse;
                              width: 100%;
                            }
                            
                            td, th {
                              border: 1px solid #dddddd;
                              text-align: left;
                              padding: 8px;
                            }
                            
                            tr:nth-child(even) {
                              background-color: #dddddd;
                            }
                            </style>
                            </head>
                            <body>
                            
                            <h2>Contact details</h2>
                            
                            <table>
                              <tr>
                                <th>Name</th>
                                <th>'.$_POST['wcim_name'].'</th>
                              </tr>
                              <tr>
                                <th>Mobile</th>
                                <th>'.$_POST['wcim_mobile'].'</th>
                              </tr>
                               <tr>
                                <th>Email</th>
                                <th>'.$_POST['wcim_email'].'</th>
                              </tr>
                               <tr>
                                <th>Time</th>
                                <th>'.$_POST['wcim_message'].'</th>
                              </tr>
                            </table>
                            
                            </body>
                        </html>';
				$this->sendMail("wellness@sujeevanhealth.com","wellness@sujeevanhealth.com","New Contact Received",$html);
				$this->sendMail("wellness@sujeevanhealth.com",$_POST['wcim_email'],"Contact Received",$html);
				redirect('success');
			}
			else
			{
				redirect('/');
			}
		}
		function success()
		{
		    $this->load->view('website/pages/success');
		}
		function save_appointment()
		{
			if($_POST)
			{
				$data = [
					'sd_name'		=>		$_POST['sd_name'],
					'sd_mobile'		=>		$_POST['sd_mobile'],
					'sd_email'		=>		$_POST['sd_email'],
					'sd_time'		=>		$_POST['sd_time'],
					'sd_date'		=>		$_POST['sd_date'],
					'sd_address'	=>		$_POST['sd_address'],
					'sd_city'		=>		$_POST['sd_city'],
					'sd_state'		=>		$_POST['sd_state'],
					'sd_message'	=>		$_POST['sd_message']
				];
				$this->db->insert('schedule_demos',$data);
				$html = '<html>
                            <head>
                            <style>
                            table {
                              font-family: arial, sans-serif;
                              border-collapse: collapse;
                              width: 100%;
                            }
                            
                            td, th {
                              border: 1px solid #dddddd;
                              text-align: left;
                              padding: 8px;
                            }
                            
                            tr:nth-child(even) {
                              background-color: #dddddd;
                            }
                            </style>
                            </head>
                            <body>
                            
                            <h2>Appointment details</h2>
                            
                            <table>
                              <tr>
                                <th>Name</th>
                                <th>'.$_POST['sd_name'].'</th>
                              </tr>
                              <tr>
                                <th>Mobile</th>
                                <th>'.$_POST['sd_mobile'].'</th>
                              </tr>
                               <tr>
                                <th>Email</th>
                                <th>'.$_POST['sd_email'].'</th>
                              </tr>
                               <tr>
                                <th>Time</th>
                                <th>'.$_POST['sd_time'].'</th>
                              </tr>
                             <tr>
                                <th>Date</th>
                                <th>'.$_POST['sd_date'].'</th>
                              </tr>
                              <tr>
                                <th>Address</th>
                                <th>'.$_POST['sd_address'].'</th>
                              </tr>
                              <tr>
                                <th>City</th>
                                <th>'.$_POST['sd_city'].'</th>
                              </tr>
                              <tr>
                                <th>State</th>
                                <th>'.$_POST['sd_state'].'</th>
                              </tr>
                              <tr>
                                <th>Message</th>
                                <th>'.$_POST['sd_message'].'</th>
                              </tr>
                            </table>
                            
                            </body>
                        </html>';
				$this->sendMail("wellness@sujeevanhealth.com","wellness@sujeevanhealth.com","New Appointment Received",$html);
				$this->sendMail("wellness@sujeevanhealth.com",$_POST['sd_email'],"Appointment Details",$html);
				redirect('success');
			}
			else
			{
				redirect('/');
			}
		}
		function get_timeslots_by_date(){
		    $booked_slots= [];
			$sd_date = $this->input->post('sd_date');
			$get_time_slots = $this->db->select('*')->from('schedule_demos')->where('sd_date',$sd_date)->get()->result();
			for($i=0;$i<count($get_time_slots);$i++){
			    array_push($booked_slots,$get_time_slots[$i]->sd_time);
			}
			if(empty($get_time_slots)){
			?>
			<option value="09:00AM - 09:30AM">09:00AM - 09:30AM</option>
			<option value="09:30AM - 10:00AM">09:30AM - 10:00AM</option>
			<option value="10:00AM - 10:30AM">10:00AM - 10:30AM</option>
			<option value="10:30AM - 11:00AM">10:30AM - 11:00AM</option>
			<option value="11:00AM - 11:30AM">11:00AM - 11:30AM</option>
			<option value="12:00PM - 12:30PM">12:00PM - 12:30PM</option>
			<option value="12:30PM - 01:00PM">12:30PM - 01:00PM</option>
			<option value="01:00PM - 01:30PM">01:00PM - 01:30PM</option>
			<option value="01:30PM - 02:00PM">01:30PM - 02:00PM</option>
			<option value="02:00PM - 02:30PM">02:00PM - 02:30PM</option>
			<option value="02:30PM - 03:00PM">02:30PM - 03:00PM</option>
			<option value="03:00PM - 03:30PM">03:00PM - 03:30PM</option>
			<option value="03:30PM - 04:00PM">03:30PM - 04:00PM</option>
			<option value="04:00PM - 04:30PM">04:00PM - 04:30PM</option>
			<option value="04:30PM - 05:00PM">04:30PM - 05:00PM</option>
			<option value="05:00PM - 05:30PM">05:00PM - 05:30PM</option>
			<option value="05:30PM - 06:00PM">05:30PM - 06:00PM</option>
			<option value="06:00PM - 06:30PM">06:00PM - 06:30PM</option>
			<option value="06:30PM - 07:00PM">06:30PM - 07:00PM</option>
			<option value="07:00PM - 07:30PM">07:00PM - 07:30PM</option>
			<option value="07:30PM - 08:00PM">07:30PM - 08:00PM</option>
			<option value="08:00PM - 08:30PM">08:00PM - 08:30PM</option>
			<option value="08:30PM - 09:00PM">08:30PM - 09:00PM</option>
			<?php
			}else{
				?>
			<option <?php if(in_array("09:00AM - 09:30AM",$booked_slots)){ echo "disabled";}?> value="09:00AM - 09:30AM">09:00AM - 09:30AM</option>
			<option <?php if(in_array("09:30AM - 10:00AM",$booked_slots)){ echo "disabled";}?> value="09:30AM - 10:00AM">09:30AM - 10:00AM</option>
			<option <?php if(in_array("10:00AM - 10:30AM",$booked_slots)){ echo "disabled";}?> value="10:00AM - 10:30AM">10:00AM - 10:30AM</option>
			<option <?php if(in_array("10:30AM - 11:00AM",$booked_slots)){ echo "disabled";}?> value="10:30AM - 11:00AM">10:30AM - 11:00AM</option>
			<option <?php if(in_array("11:00AM - 11:30AM",$booked_slots)){ echo "disabled";}?> value="11:00AM - 11:30AM">11:00AM - 11:30AM</option>
			<option <?php if(in_array("12:00PM - 12:30PM",$booked_slots)){ echo "disabled";}?> value="12:00PM - 12:30PM">12:00PM - 12:30PM</option>
			<option <?php if(in_array("12:30PM - 01:00PM",$booked_slots)){ echo "disabled";}?> value="12:30PM - 01:00PM">12:30PM - 01:00PM</option>
			<option <?php if(in_array("01:00PM - 01:30PM",$booked_slots)){ echo "disabled";}?> value="01:00PM - 01:30PM">01:00PM - 01:30PM</option>
			<option <?php if(in_array("01:30PM - 02:00PM",$booked_slots)){ echo "disabled";}?> value="01:30PM - 02:00PM">01:30PM - 02:00PM</option>
			<option <?php if(in_array("02:00PM - 02:30PM",$booked_slots)){ echo "disabled";}?> value="02:00PM - 02:30PM">02:00PM - 02:30PM</option>
			<option <?php if(in_array("02:30PM - 03:00PM",$booked_slots)){ echo "disabled";}?> value="02:30PM - 03:00PM">02:30PM - 03:00PM</option>
			<option <?php if(in_array("03:00PM - 03:30PM",$booked_slots)){ echo "disabled";}?> value="03:00PM - 03:30PM">03:00PM - 03:30PM</option>
			<option <?php if(in_array("03:30PM - 04:00PM",$booked_slots)){ echo "disabled";}?> value="03:30PM - 04:00PM">03:30PM - 04:00PM</option>
			<option <?php if(in_array("04:00PM - 04:30PM",$booked_slots)){ echo "disabled";}?> value="04:00PM - 04:30PM">04:00PM - 04:30PM</option>
			<option <?php if(in_array("04:30PM - 05:00PM",$booked_slots)){ echo "disabled";}?> value="04:30PM - 05:00PM">04:30PM - 05:00PM</option>
			<option <?php if(in_array("05:00PM - 05:30PM",$booked_slots)){ echo "disabled";}?> value="05:00PM - 05:30PM">05:00PM - 05:30PM</option>
			<option <?php if(in_array("05:30PM - 06:00PM",$booked_slots)){ echo "disabled";}?> value="05:30PM - 06:00PM">05:30PM - 06:00PM</option>
			<option <?php if(in_array("06:00PM - 06:30PM",$booked_slots)){ echo "disabled";}?> value="06:00PM - 06:30PM">06:00PM - 06:30PM</option>
			<option <?php if(in_array("06:30PM - 07:00PM",$booked_slots)){ echo "disabled";}?> value="06:30PM - 07:00PM">06:30PM - 07:00PM</option>
			<option  <?php if(in_array("07:00PM - 07:30PM",$booked_slots)){ echo "disabled";}?> value="07:00PM - 07:30PM">07:00PM - 07:30PM</option>
			<option  <?php if(in_array("07:30PM - 08:00PM",$booked_slots)){ echo "disabled";}?> value="07:30PM - 08:00PM">07:30PM - 08:00PM</option>
			<option  <?php if(in_array("08:00PM - 08:30PM",$booked_slots)){ echo "disabled";}?> value="08:00PM - 08:30PM">08:00PM - 08:30PM</option>
			<option  <?php if(in_array("08:30PM - 09:00PM",$booked_slots)){ echo "disabled";}?> value="08:30PM - 09:00PM">08:30PM - 09:00PM</option>
				<?php
			}
		}
		function sendMail($from,$to,$subject,$body){
		    require 'vendor/autoload.php'; // If you're using Composer (recommended)
            // Comment out the above line if not using Composer
            // require("<PATH TO>/sendgrid-php.php");
            // If not using Composer, uncomment the above line and
            // download sendgrid-php.zip from the latest release here,
            // replacing <PATH TO> with the path to the sendgrid-php.php file,
            // which is included in the download:
            // https://github.com/sendgrid/sendgrid-php/releases
            
            $email = new \SendGrid\Mail\Mail(); 
            $email->setFrom($from, "Sujeevan");
            $email->setSubject($subject);
            $email->addTo($to, "Wellness Sujeevan");
            $email->addTo("sujeevanhealth@gmail.com", "Wellness Sujeevan");
            $email->addContent("text/plain", "Hi, Sujeevan, You have received an appointment for which you need to take action, Please find the details below");
            $email->addContent(
                "text/html", $body
            );
            $sendgrid = new \SendGrid('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');
            try {
                $response = $sendgrid->send($email);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
            echo "<h1>Your information is received!! We will get back to you soon</h1>";
        }
        function subscribe()
        {
            	if($_POST)
			{
				$data = [
					's_name'		=>		$_POST['s_name'],
					's_mobile'		=>		$_POST['s_mobile'],
					's_email'		=>		$_POST['s_email'],
					's_date'        =>      Date('Y-m-d')
				];
				$this->db->insert('subscribers',$data);
				$html = '<html>
                            <head>
                            <style>
                            table {
                              font-family: arial, sans-serif;
                              border-collapse: collapse;
                              width: 100%;
                            }
                            
                            td, th {
                              border: 1px solid #dddddd;
                              text-align: left;
                              padding: 8px;
                            }
                            
                            tr:nth-child(even) {
                              background-color: #dddddd;
                            }
                            </style>
                            </head>
                            <body>
                            
                            <h2>Subscription Received</h2>
                            
                            <table>
                              <tr>
                                <th>Name</th>
                                <th>'.$_POST['s_name'].'</th>
                              </tr>
                              <tr>
                                <th>Mobile</th>
                                <th>'.$_POST['s_mobile'].'</th>
                              </tr>
                               <tr>
                                <th>Email</th>
                                <th>'.$_POST['s_email'].'</th>
                              </tr>
                            </table>
                            
                            </body>
                        </html>';
				$this->sendMail("wellness@sujeevanhealth.com","wellness@sujeevanhealth.com","Subscription Received",$html);
				$this->sendMail("wellness@sujeevanhealth.com",$_POST['s_email'],"Subscription Received",$html);
				redirect('success');
			}
			else
			{
				redirect('/');
			}
        }
        function book_your_plan()
        {
            $this->load->view('website/pages/book_your_plan');
        }
        function save_booking_plan()
        {
            if($_POST)
			{
				$data = [
					'b_name'		=>		$_POST['b_name'],
					'b_email'		=>		$_POST['b_email'],
					'b_mobile'		=>		$_POST['b_mobile'],
					'b_address'     =>      $_POST['b_address'],
					'b_program'     =>      $_POST['b_program'],
					'b_package'     =>      $_POST['b_package'],
					'b_plan'        =>      $_POST['b_plan'],
					'b_message'     =>      $_POST['b_message']
				];
				if(count($_POST['b_program'])>0){
				    $data['b_program'] = implode(',',$_POST['b_program']);
				}else{
				    $data['b_program'] = '';
				}
				$this->db->insert('bookings',$data);
				$html = '<html>
                            <head>
                            <style>
                            table {
                              font-family: arial, sans-serif;
                              border-collapse: collapse;
                              width: 100%;
                            }
                            
                            td, th {
                              border: 1px solid #dddddd;
                              text-align: left;
                              padding: 8px;
                            }
                            
                            tr:nth-child(even) {
                              background-color: #dddddd;
                            }
                            </style>
                            </head>
                            <body>
                            
                            <h2>Booking Received</h2>
                            
                            <table>
                              <tr>
                                <th>Name</th>
                                <th>'.$_POST['b_name'].'</th>
                              </tr>
                              <tr>
                                <th>Mobile</th>
                                <th>'.$_POST['b_mobile'].'</th>
                              </tr>
                               <tr>
                                <th>Email</th>
                                <th>'.$_POST['b_email'].'</th>
                              </tr>
                               <tr>
                                <th>Address</th>
                                <th>'.$_POST['b_address'].'</th>
                              </tr>
                               <tr>
                                <th>Program</th>
                                <th>'.$_POST['b_program'].'</th>
                              </tr>
                               <tr>
                                <th>Package</th>
                                <th>'.$_POST['b_package'].'</th>
                              </tr>
                               <tr>
                                <th>Plan</th>
                                <th>'.$_POST['b_plan'].'</th>
                              </tr>
                               <tr>
                                <th>Message</th>
                                <th>'.$_POST['b_message'].'</th>
                              </tr>
                            </table>
                            
                            </body>
                        </html>';
				$this->sendMail("wellness@sujeevanhealth.com","wellness@sujeevanhealth.com","Booking Received",$html);
				$this->sendMail("wellness@sujeevanhealth.com",$_POST['b_email'],"Booking Details",$html);
				redirect('booking-success');
			}
			else
			{
				redirect('/');
			}
        }
        function booking_success()
        {
            $this->load->view('website/pages/booking_succes');
        }
	}
?>
