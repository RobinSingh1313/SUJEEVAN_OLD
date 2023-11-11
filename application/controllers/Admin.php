<?php
	ob_start();
	error_reporting(0);
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Admin extends CI_Controller 
	{
		public function __construct()
		{
			parent :: __construct();
			date_default_timezone_set('Asia/Kolkata');
            if($this->uri->segment(1)=="admin" && !empty($this->uri->segment(2)))
            {
                if(empty($this->session->userdata('alcm_id')))
                {
                    header('Content-Type: application/json');
                    echo json_encode(
                        [
                            'status' => '400', 
                            'message' => 'unauthorized access or session expired', 
                            'data' => ['id' => sha1(mt_rand(11111,99999))
                        ]
                    ],
                    JSON_PRETTY_PRINT
                    );
                    die();
                }
            }
		}
        function index()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'GET');
            if(!empty($this->session->userdata('alcm_id')))
            {
                redirect('admin/dashboard');
            }
            else
            {
                $this->load->view('admin/index');
            }
        }
        function auth()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $this->form_validation->set_rules('alcm_username','Username','required|xss_clean');
            $this->form_validation->set_rules('alcm_password','Password','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                $this->load->view('admin/index');
            }
            else
            {
                $alcm_username = $this->input->post('alcm_username');
                $alcm_password = sha1($this->input->post('alcm_password'));
                $query = alcm_sql1();
                $params = [$alcm_username,$alcm_password,1];
                $auth = $this->sql->ExecuteQuery($query,$params,'read');
                if(!empty($auth))
                {
                    $admin_sess = ['alcm_id' => $auth[0]->alcm_id];
                    $this->session->set_userdata($admin_sess);
                    redirect('admin/dashboard');
                }
                else
                {
                    get_flash_message('Login Failed.. Incorrect Credentials',0);
                    $this->load->view('admin/index');
                }
            }
        }
        function dashboard()
        {
            $query1 = alcm_sql4();
            $params1 = [];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
            $pageData = [
                'title'         =>      'Admin Dashboard',
                'breadcrumbs'   =>      ['Dashboard','Home','Dashboard','Data'],
                'counts'        =>      $data1
            ];
            $this->load->view('admin/pages/dashboard',$pageData);
        }
        function change_password()
        {
            $pageData = [
                'title'         =>      'Change Password',
                'breadcrumbs'   =>      ['Change Password','Home','','Change Password']
            ];
            $this->load->view('admin/pages/change_password',$pageData);
        }
        function update_password()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $this->form_validation->set_rules('alcm_old_password','Old Password', 'required|xss_clean');
            $this->form_validation->set_rules('alcm_new_password','New Password', 'required|xss_clean');
            $this->form_validation->set_rules('alcm_confirm_password','Confirm Password', 'required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->change_password();
            }
            else
            {
                $alcm_old_password = $this->input->post('alcm_old_password');
                $alcm_new_password = $this->input->post('alcm_new_password');
                $alcm_confirm_password = $this->input->post('alcm_confirm_password');
                $query1 = alcm_sql2();
                $params1 = [$_SESSION['alcm_id'],1];
                $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
                if($data1[0]->alcm_password!=sha1($alcm_old_password))
                {
                    get_flash_message('Old Password is incorrect',0);
                    return $this->change_password();
                }
                elseif($alcm_new_password!=$alcm_confirm_password)
                {
                    get_flash_message('New Password and Confirm Password do not match',0);
                    return $this->change_password();
                }
                else
                {
                    $query2 = alcm_sql3();
                    $params2 = [sha1($alcm_new_password),$_SESSION['alcm_id'],1];
                    $data2 = $this->sql->ExecuteQuery($query2,$params2,'update');
                    get_flash_message('Your Passsord has been updated successfully',1);
                    redirect('admin/change-password');
                }
            }
        }
        function logout()
        {
            $this->session->unset_userdata('alcm_id');
            redirect('admin');
        }
        function add_category_form($data=array())
        {
            $pageData = [
                'title'         =>      'Add Blog Category Form',
                'breadcrumbs'   =>      ['Add Blog Category Form','Home','Blog','Add Blog Category Form'],
                'post_data'     =>      $data
            ];
            $this->load->view('admin/pages/add_category',$pageData);
        }
        function save_category()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $this->form_validation->set_rules('mcim_name','Category Name','required|xss_clean');
            $this->form_validation->set_rules('mcim_status','Status','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->add_category_form($_POST);
            }
            else
            {
                $mcim_name = $this->input->post('mcim_name');
                $mcim_status = $this->input->post('mcim_status');
                $query = mcim_sql1();
                $params = [$mcim_name,$mcim_status];
                $data = $this->sql->ExecuteQuery($query,$params,'insert');
                if($data==1062)
                {
                    get_flash_message('Category Already Exists',0);
                    return $this->add_category_form($params);
                }
                else
                {
                    get_flash_message('Category has been added successfully',1);
                    redirect('admin/add-category-form');
                }
            }
        }
        function categories_list()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'GET');
            $query = mcim_sql2();
            $params = [];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'             =>       'Categories List',
                'breadcrumbs'       =>       ['Categories List', 'Home', 'Categories', 'Categories List'],
                'categories_list'   =>       $data
            ];
            $this->load->view('admin/pages/categories_list',$pageData);
        }
        function edit_category($id)
        {
            $query = mcim_sql3();
            $params = [base64_decode($id)];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'         =>          'Edit Category',
                'breadcrumbs'   =>          ['Edit Category','Home','Categories','Edit Category'],
                'edit_category' =>          $data          
            ];
            $this->load->view('admin/pages/add_category',$pageData);
        }
        function update_category($id)
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $mcim_id = base64_decode($id);
            $this->form_validation->set_rules('mcim_name','Category Name','required|xss_clean');
            $this->form_validation->set_rules('mcim_status','Status','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->edit_category($id);
            }
            else
            {
                $mcim_name = $this->input->post('mcim_name');
                $mcim_status = $this->input->post('mcim_status');
                $query = mcim_sql4();
                $params = [$mcim_name,$mcim_status,$mcim_id];
                $data = $this->sql->ExecuteQuery($query,$params,'update');
                if($data==1062)
                {
                    get_flash_message('Category Already Exists',0);
                    return $this->edit_category($id);
                }
                else
                {
                    get_flash_message('Category has been updated successfully',1);
                    return $this->edit_category($id);
                }
            }
        }
        function add_post_page($post_data=array())
        {
            $query = mcim_sql5();
            $params = [1];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'             =>          'Add Blog Post Form',
                'breadcrumbs'       =>          ['Add Blog Post Form','Home','Blog','Add Blog Post Form'],
                'categories_data'   =>          $data,
                'post_data'         =>          $post_data
            ];
            $this->load->view('admin/pages/add_post',$pageData);
        }
        function add_webinar($webinar_data=array())
        {
            $pageData = [
                'title'                =>          'Add Webinar Form',
                'breadcrumbs'          =>          ['Add Webinar Form','Home','Webinars','Add Webinar Form'],
                'webinar_data'         =>          $webinar_data
            ];
            $this->load->view('admin/pages/add_webinar',$pageData);
        }
        function add_podcast($podcast_data=array())
        {
            $pageData = [
                'title'                =>          'Add Podcast Form',
                'breadcrumbs'          =>          ['Add Podcast Form','Home','Podcasts','Add Podcast Form'],
                'podcast_data'         =>          $podcast_data
            ];
            $this->load->view('admin/pages/add_podcast',$pageData);
        }
        function stripQuotes($text) {
          return str_replace('"','',preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $text));
        } 
        function save_post()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            if(empty($_FILES['mcdp_image']['name']))
            {
                return $this->add_post_page($this->input->post());
            }
            $this->form_validation->set_rules('mcdp_category_id','Category Name','required|xss_clean');
            $this->form_validation->set_rules('mcdp_title','Title','required|xss_clean');
            $this->form_validation->set_rules('mcdp_date_of_post','Date','required|xss_clean');
            // $this->form_validation->set_rules('mcdp_post_content','Content','required|xss_clean');
            $this->form_validation->set_rules('mcdp_status','Status','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->add_post_page($_POST);
            }
            else
            {
                $mcdp_category_id = $this->input->post('mcdp_category_id');
                $mcdp_sub_category_id = $this->input->post('mcdp_sub_category_id');
                $mcdp_title = $this->input->post('mcdp_title');
                $mcdp_date_of_post = $this->input->post('mcdp_date_of_post') ? $this->input->post('mcdp_date_of_post') : "";
                $mcdp_post_content = $this->stripQuotes(str_replace('</pre>','',str_replace('<pre>','',$this->input->post('mcdp_post_content'))));
                $mcdp_status = $this->input->post('mcdp_status');
                $mcdp_image = upload_file('./file_uploads/posts/','jpg|JPG|png|PNG|jpeg|gif|GIF|jfif|JFIF|JPEG','mcdp_image','512');
                $params = [$mcdp_category_id,$mcdp_title,$mcdp_date_of_post,$mcdp_image,$mcdp_post_content,$mcdp_status];
                if($mcdp_image==0)
                {
                    get_flash_message('There is an error in the file you have uploaded!! File size should be less than 500 KB and type should be image format',0);
                    return $this->add_post_page($params);
                }
                $query = mcdp_sql1();
                $data = $this->sql->ExecuteQuery($query,$params,'insert');
                get_flash_message('Post has been added successfully',1);
                redirect('admin/add-post-page');
            }
        }
        function save_webinar()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            if(empty($_FILES['wdm_thumbnail_img']['name']))
            {
                return $this->add_webinar($this->input->post());
            }
            $this->form_validation->set_rules('wdm_content','Content','required|xss_clean');
            $this->form_validation->set_rules('wdm_title','Title','required|xss_clean');
            $this->form_validation->set_rules('wdm_youtube_url','Youtube Embed Source Url','required|xss_clean');
            $this->form_validation->set_rules('wdm_status','Status','required|xss_clean');
            $this->form_validation->set_rules('wdm_date_of_webinar','Date of webinar','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->add_webinar($_POST);
            }
            else
            {
                $wdm_title = $this->input->post('wdm_title');
                $wdm_youtube_url = $this->input->post('wdm_youtube_url');
                $wdm_status = $this->input->post('wdm_status');
                $wdm_date_of_webinar = $this->input->post('wdm_date_of_webinar');
                $wdm_content = $this->stripQuotes(str_replace('</pre>','',str_replace('<pre>','',$this->input->post('wdm_content'))));
                $wdm_thumbnail_img = upload_file('./file_uploads/webinar/','jpg|JPG|png|PNG|jpeg|gif|GIF|jfif|JFIF|JPEG','wdm_thumbnail_img','512');
                $params = [$wdm_thumbnail_img,$wdm_content,$wdm_title,$wdm_youtube_url,$wdm_status,$wdm_date_of_webinar];
                if($wdm_thumbnail_img==0)
                {
                    get_flash_message('There is an error in the file you have uploaded',0);
                    return $this->add_webinar($params);
                }
                $query = wdm_sql1();
                $data = $this->sql->ExecuteQuery($query,$params,'insert');
                get_flash_message('Webinar has been added successfully',1);
                redirect('admin/add-webinar');
            }
        }
        function save_podcast()
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            if(empty($_FILES['p_image']['name']) || empty($_FILES['p_audio']['name']))
            {
                return $this->add_podcast($this->input->post());
            }
            $this->form_validation->set_rules('p_title','Title','required|xss_clean');
            $this->form_validation->set_rules('p_description','Description','required|xss_clean');
            $this->form_validation->set_rules('p_status','Status','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->add_podcast($_POST);
            }
            else
            {
                $p_title = $this->input->post('p_title');
                $p_status = $this->input->post('p_status');
                $p_description = $this->stripQuotes(str_replace('</pre>','',str_replace('<pre>','',$this->input->post('p_description'))));
                $p_image = upload_file('./file_uploads/podcast/','jpg|JPG|png|PNG|jpeg|gif|GIF|jfif|JFIF|JPEG','p_image','512');
                $p_audio = upload_file('./file_uploads/podcast/','mp3','p_audio','51200000');
                $params = [$p_title,$p_image,$p_description,$p_audio,$p_status];
                if($p_image==0 || $p_audio==0)
                {
                    get_flash_message('There is an error in the file you have uploaded',0);
                    return $this->add_podcast($params);
                }
                $query = p_sql1();
                $data = $this->sql->ExecuteQuery($query,$params,'insert');
                get_flash_message('Podcast has been added successfully',1);
                redirect('admin/add-podcast');
            }
        }
        function posts_list($data=[])
        {
            $query = mcim_sql6();
            $params = [];
            $category_data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'         =>      'Posts List',
                'breadcrumbs'   =>      ['Posts List','Home','Posts','Posts List'],
                'posts_list'    =>      $data,
                'category_list' =>      $category_data,
                'year'          =>      $_POST['year'],
                'month'         =>      $_POST['month'],
                'category_id'   =>      $_POST['category_id']
            ];
            $this->load->view('admin/pages/posts_list',$pageData);
        }
        function webinar_list($data=[])
        {
            $query = wdm_sql2();
            $params = [];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'         =>      'Webinar List',
                'breadcrumbs'   =>      ['Webinar List','Home','Webinar','Webinar List'],
                'webinar_list'  =>      $data
            ];
            $this->load->view('admin/pages/webinar_list',$pageData);
        }
        function podcast_list($data=[])
        {
            $query = p_sql2();
            $params = [];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'         =>      'Podcast List',
                'breadcrumbs'   =>      ['Podcast List','Home','Podcast','Podcast List'],
                'podcast_list'  =>      $data
            ];
            $this->load->view('admin/pages/podcast_list',$pageData);
        }
        function filter_posts()
        {
            $this->form_validation->set_rules('category_id','Category Id','required|xss_clean');
            $this->form_validation->set_rules('year','Year','required|xss_clean');
            $this->form_validation->set_rules('month','Month','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->posts_list();
            }
            else
            {
                $category_id = $this->input->post('category_id');
                $year = $this->input->post('year');
                $month = $this->input->post('month');
                $query = mcdp_sql2();
                $params = [$category_id,$year,$month];
                $data = $this->sql->ExecuteQuery($query,$params,'read');
                return $this->posts_list($data);
            }
        }
        function edit_post($id)
        {
            $query = mcdp_sql3();
            $params = [base64_decode($id)];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $query2 = mcim_sql6();
            $params2 = [];
            $data2 = $this->sql->ExecuteQuery($query2,$params2,'read');
            $pageData = [
                'title'             =>          'Edit Post',
                'breadcrumbs'       =>          ['Edit Post','Home','Posts','Edit Post'],
                'edit_post'         =>          $data,
                'categories_data'   =>          $data2
            ];
            $this->load->view('admin/pages/add_post',$pageData);
        }
        function edit_webinar($id)
        {
            $query = wdm_sql3();
            $params = [base64_decode($id)];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'             =>          'Edit Webinar',
                'breadcrumbs'       =>          ['Edit Webinar','Home','Webinar','Edit Webinar'],
                'edit_webinar'         =>          $data
            ];
            $this->load->view('admin/pages/add_webinar',$pageData);
        }
        function edit_podcast($id)
        {
            $query = p_sql3();
            $params = [base64_decode($id)];
            $data = $this->sql->ExecuteQuery($query,$params,'read');
            $pageData = [
                'title'             =>          'Edit Podcast',
                'breadcrumbs'       =>          ['Edit Podcast','Home','Podcast','Edit Podcast'],
                'edit_podcast'      =>          $data
            ];
            $this->load->view('admin/pages/add_podcast',$pageData);
        }
        function update_post($id)
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $query1 = mcdp_sql4();
            $params1 = [base64_decode($id)];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
            $this->form_validation->set_rules('mcdp_category_id','Category Name','required|xss_clean');
            $this->form_validation->set_rules('mcdp_title','Title','required|xss_clean');
            $this->form_validation->set_rules('mcdp_date_of_post','Date','required|xss_clean');
            // $this->form_validation->set_rules('mcdp_post_content','Content','required|xss_clean');
            $this->form_validation->set_rules('mcdp_status','Status','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->edit_post($id);
            }
            else
            {
                $mcdp_category_id = $this->input->post('mcdp_category_id');
                $mcdp_title = $this->input->post('mcdp_title');
                $mcdp_date_of_post = $this->input->post('mcdp_date_of_post');
                $mcdp_post_content = $this->stripQuotes(str_replace('</pre>','',str_replace('<pre>','',$this->input->post('mcdp_post_content'))));
                $mcdp_status = $this->input->post('mcdp_status');
                $mcdp_id = base64_decode($id);
                if(!empty($_FILES['mcdp_image']['name']))
                {
                    unlink('file_uploads/posts/'.$data1[0]->mcdp_image);
                    $mcdp_image = upload_file('./file_uploads/posts/','jpg|JPG|png|PNG|jpeg|gif|GIF|jfif|JFIF|JPEG','mcdp_image','512');
                }
                else
                {
                    $mcdp_image = $data1[0]->mcdp_image ? $data1[0]->mcdp_image : 0;
                }
                $params2 = [$mcdp_category_id,$mcdp_title,$mcdp_date_of_post,$mcdp_image,$mcdp_post_content,$mcdp_status,$mcdp_id];
                if($mcdp_image==0)
                {
                    get_flash_message('There is an error in the file you have uploaded',0);
                    return $this->edit_post($id);
                }
                $query = mcdp_sql5();
                $data = $this->sql->ExecuteQuery($query,$params2,'update');
                get_flash_message('Post has been updated',1);
                redirect('admin/edit-post/'.$id);
            }
        }
        function update_webinar($id)
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $query1 = wdm_sql3();
            $params1 = [base64_decode($id)];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
            $this->form_validation->set_rules('wdm_content','Content','required|xss_clean');
            $this->form_validation->set_rules('wdm_title','Title','required|xss_clean');
            $this->form_validation->set_rules('wdm_youtube_url','Youtube Embed Source Url','required|xss_clean');
            $this->form_validation->set_rules('wdm_status','Status','required|xss_clean');
            $this->form_validation->set_rules('wdm_date_of_webinar','Date of webinar','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->edit_webinar($id);
            }
            else
            {
                $wdm_title = $this->input->post('wdm_title');
                $wdm_youtube_url = $this->input->post('wdm_youtube_url');
                $wdm_status = $this->input->post('wdm_status');
                $wdm_date_of_webinar = $this->input->post('wdm_date_of_webinar');
                $wdm_content = $this->stripQuotes(str_replace('</pre>','',str_replace('<pre>','',$this->input->post('wdm_content'))));
                $wdm_id = base64_decode($id);
                if(!empty($_FILES['wdm_thumbnail_img']['name']))
                {
                    unlink('file_uploads/webinar/'.$data1[0]->wdm_thumbnail_img);
                    $wdm_thumbnail_img = upload_file('./file_uploads/webinar/','jpg|JPG|png|PNG|jpeg|gif|GIF|jfif|JFIF|JPEG','mcdp_image','512');
                }
                else
                {
                    $wdm_thumbnail_img = $data1[0]->wdm_thumbnail_img ? $data1[0]->wdm_thumbnail_img : 0;
                }
                $params2 = [$wdm_title,$wdm_youtube_url,$wdm_status,$wdm_date_of_webinar,$wdm_content,$wdm_thumbnail_img,$wdm_id];
                if($wdm_thumbnail_img==0)
                {
                    get_flash_message('There is an error in the file you have uploaded',0);
                    return $this->edit_webinar($id);
                }
                $query = wdm_sql4();
                $data = $this->sql->ExecuteQuery($query,$params2,'update');
                get_flash_message('Webinar has been updated',1);
                redirect('admin/edit-webinar/'.$id);
            }
        }
        function update_podcast($id)
        {
            check_request_method($_SERVER['REQUEST_METHOD'],'POST');
            $query1 = p_sql3();
            $params1 = [base64_decode($id)];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
            $this->form_validation->set_rules('p_title','Title','required|xss_clean');
            $this->form_validation->set_rules('p_description','Description','required|xss_clean');
            $this->form_validation->set_rules('p_status','Status','required|xss_clean');
            if($this->form_validation->run()==FALSE)
            {
                return $this->edit_podcast($id);
            }
            else
            {
                $p_title = $this->input->post('p_title');
                $p_status = $this->input->post('p_status');
                $p_description = $this->stripQuotes(str_replace('</pre>','',str_replace('<pre>','',$this->input->post('p_description'))));
                $p_id = base64_decode($id);
                if(!empty($_FILES['p_image']['name']))
                {
                    unlink('file_uploads/podcast/'.$data1[0]->p_image);
                    $p_image = upload_file('./file_uploads/podcast/','jpg|JPG|png|PNG|jpeg|gif|GIF|jfif|JFIF|JPEG','p_image','512');
                }
                else
                {
                    $p_image = $data1[0]->p_image ? $data1[0]->p_image : 0;
                }
                if(!empty($_FILES['p_audio']['name']))
                {
                    unlink('file_uploads/podcast/'.$data1[0]->p_audio);
                    $p_audio = upload_file('./file_uploads/podcast/','mp3','p_audio','5120000');
                }
                else
                {
                    $p_audio = $data1[0]->p_audio ? $data1[0]->p_audio : 0;
                }
                $params2 = [$p_title,$p_image,$p_description,$p_audio,$p_status,$p_id];
                if($p_image==0 || $p_audio==0)
                {
                    get_flash_message('There is an error in the file you have uploaded',0);
                    return $this->edit_podcast($id);
                }
                $query = p_sql4();
                $data = $this->sql->ExecuteQuery($query,$params2,'update');
                get_flash_message('Podcast has been updated',1);
                redirect('admin/edit-podcast/'.$id);
            }
        }
        function contacts_list()
        {
            $query1 = wcim_sql2();
            $params1 = [1];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
            $pageData = [
                'title'         =>      'Contacts List',
                'breadcrumbs'   =>      ['Contacts List','Home','Contacts','Contacts List'],
                'contacts'      => $data1
            ];
            $this->load->view('admin/pages/contacts',$pageData);
        }
        function subscribers_list()
        {
            $pageData = [
                'title'         =>      'Subscribers List',
                'breadcrumbs'   =>      ['Subscribers List','Home','Subscribers','Subscribers List'],
                'subscribers'   =>      $this->db->select('*')->from('subscribers')->order_by('s_id','desc')->get()->result()
            ];
            $this->load->view('admin/pages/subscribers',$pageData);
        }
        function business_enquiries_list()
        {
            $query1 = be_sql1();
            $params1 = [1];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'read');
            $pageData = [
                'title'         =>      'Business Enquiries List',
                'breadcrumbs'   =>      ['Business Enquiries List','Home','Business Enquiries','Business Enquiries List'],
                'contacts'      => $data1
            ];
            $this->load->view('admin/pages/business_enquries',$pageData);
        }
        function delete_contact($id)
        {
            $query1 = wcim_sql3();
            $params1 = [base64_decode($id)];
            $data1 = $this->sql->ExecuteQuery($query1,$params1,'delete');
            get_flash_message('Contact Deleted Successfully',1);
            redirect('admin/contacts-list');
        }
        function delete_business_enquiry($id)
        {
            $this->db->where('be_id',base64_decode($id))->delete('business_enquries');
            get_flash_message('Business enquiry Deleted Successfully',1);
            redirect('admin/business-enquiries-list');
        }
        function schedule_demos_list()
        {
            $data1 = $this->db->select('*')->from('schedule_demos')->order_by('sd_id','desc')->get()->result();
            $pageData = [
                'title'         =>      'Scheduled Demos List',
                'breadcrumbs'   =>      ['Scheduled Demos List','Home','Scheduled Demos','Scheduled Demos List'],
                'contacts'      =>      $data1
            ];
            $this->load->view('admin/pages/scheduled_demos',$pageData);
        }
        function delete_demo($id)
        {
            $this->db->where('sd_id',base64_decode($id))->delete('schedule_demos');
            get_flash_message('Deleted Successfully',1);
            redirect('admin/schedule-demos-list');
        }
	}
?>
