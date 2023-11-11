<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#########################################################################################
// admin_login_credentials_master
#########################################################################################
if ( ! function_exists('alcm_sql1'))
{
	function alcm_sql1()
	{
		return "SELECT alcm_id FROM admin_login_credentials_master WHERE alcm_username=? AND alcm_password=? AND alcm_status=? LIMIT 1";
	}
}
if ( ! function_exists('alcm_sql2'))
{
	function alcm_sql2()
	{
		return "SELECT alcm_password FROM admin_login_credentials_master WHERE alcm_id=? AND alcm_status=? LIMIT 1";
	}
}
if ( ! function_exists('alcm_sql3'))
{
	function alcm_sql3()
	{
		return "UPDATE admin_login_credentials_master SET alcm_password=? WHERE alcm_id=? AND alcm_status=?";
	}
}
if ( ! function_exists('alcm_sql4'))
{
	function alcm_sql4()
	{
		return "SELECT (SELECT count(admin_login_credentials_master.alcm_id) FROM admin_login_credentials_master) as admins_count,(SELECT count(main_categories_data_postings.mcdp_id) FROM main_categories_data_postings) as posts_count,(SELECT count(website_contacts_information_master.wcim_id) FROM website_contacts_information_master) as contacts_count, (SELECT count(main_categories_information_master.mcim_id) FROM main_categories_information_master) as categories_count, (SELECT count(main_categories_data_postings.mcdp_id) FROM main_categories_data_postings) as postings_count from admin_login_credentials_master";
	}
}
if ( ! function_exists('alcm_sql5'))
{
	function alcm_sql5()
	{
		return "";
	}
}
if ( ! function_exists('alcm_sql6'))
{
	function alcm_sql6()
	{
		return "INSERT INTO `admin_login_credentials_master` (`alcm_status`, `alcm_admin_type`, `alcm_username`, `alcm_password`, `alcm_created_at`) VALUES (?,?,?,?,now())";
	}
}
if ( ! function_exists('alcm_sql7'))
{
	function alcm_sql7()
	{
		return "SELECT alcm_id,alcm_username,alcm_password,alcm_status FROM admin_login_credentials_master WHERE alcm_admin_type=?";
	}
}
if ( ! function_exists('alcm_sql8'))
{
	function alcm_sql8()
	{
		return "SELECT alcm_id,alcm_username,alcm_password,alcm_status FROM admin_login_credentials_master WHERE alcm_id=?";
	}
}
if ( ! function_exists('alcm_sql9'))
{
	function alcm_sql9()
	{
		return "UPDATE admin_login_credentials_master SET alcm_username=?,alcm_password=?,alcm_status=? WHERE alcm_id=?";
	}
}
##########################################################################################
// main_categories_information_master
##########################################################################################
if ( ! function_exists('mcim_sql1'))
{
	function mcim_sql1()
	{
		return "INSERT INTO `main_categories_information_master` (`mcim_name`, `mcim_status`, `mcim_created_at`) VALUES (?,?,now());";
	}
}
if ( ! function_exists('mcim_sql2'))
{
	function mcim_sql2()
	{
		return "SELECT mcim_id,mcim_name,mcim_status FROM main_categories_information_master;";
	}
}
if ( ! function_exists('mcim_sql3'))
{
	function mcim_sql3()
	{
		return "SELECT mcim_id,mcim_name,mcim_status FROM main_categories_information_master WHERE mcim_id=?";
	}
}
if ( ! function_exists('mcim_sql4'))
{
	function mcim_sql4()
	{
		return "UPDATE main_categories_information_master SET mcim_name=?,mcim_status=? WHERE mcim_id=?";
	}
}
if ( ! function_exists('mcim_sql5'))
{
	function mcim_sql5()
	{
		return "SELECT mcim_id,mcim_name FROM main_categories_information_master WHERE mcim_status=?";
	}
}
if ( ! function_exists('mcim_sql6'))
{
	function mcim_sql6()
	{
		return "SELECT mcim_id,mcim_name FROM main_categories_information_master;";
	}
}
if ( ! function_exists('mcim_sql7'))
{
	function mcim_sql7()
	{
		return "SELECT mcim_id,mcim_name FROM main_categories_information_master WHERE mcim_status=? AND mcim_navbar_display_status=? ORDER BY RAND() LIMIT ?;";
	}
}
if ( ! function_exists('mcim_sql8'))
{
	function mcim_sql8()
	{
		return "SELECT mcim_id,mcim_name FROM main_categories_information_master WHERE mcim_status=? AND mcim_navbar_display_status=? ORDER BY mcim_id ASC LIMIT ?;";
	}
}
###########################################################################################
// main_categories_data_postings
###########################################################################################
if ( ! function_exists('mcdp_sql1'))
{
	function mcdp_sql1()
	{
		return "INSERT INTO `main_categories_data_postings` (`mcdp_category_id`, `mcdp_title`, `mcdp_date_of_post`, `mcdp_image`, `mcdp_post_content`, `mcdp_status`, `mcdp_created_at`) VALUES (?,?,?,?,?,?,now());";
	}
}

if ( ! function_exists('mcdp_sql2'))
{
	function mcdp_sql2()
	{
		return "SELECT (SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,mcdp_id,mcdp_category_id,mcdp_title,mcdp_image,mcdp_status FROM main_categories_data_postings WHERE mcdp_category_id=? AND YEAR(mcdp_date_of_post)=? AND MONTH(mcdp_date_of_post)=? ORDER BY mcdp_id DESC";
	}
}
if ( ! function_exists('mcdp_sql3'))
{
	function mcdp_sql3()
	{
		return "SELECT mcdp_id,mcdp_category_id,mcdp_title,mcdp_date_of_post,mcdp_image,mcdp_post_content,mcdp_status FROM main_categories_data_postings WHERE mcdp_id=?";
	}
}
if ( ! function_exists('mcdp_sql4'))
{
	function mcdp_sql4()
	{
		return "SELECT mcdp_image FROM main_categories_data_postings WHERE mcdp_id=?";
	}
}
if ( ! function_exists('mcdp_sql5'))
{
	function mcdp_sql5()
	{
		return "UPDATE `main_categories_data_postings` SET mcdp_category_id=?,mcdp_title=?,mcdp_date_of_post=?,mcdp_image=?,mcdp_post_content=?,mcdp_status=? WHERE mcdp_id=?";
	}
}
if ( ! function_exists('mcdp_sql6'))
{
	function mcdp_sql6()
	{
		return "SELECT (SELECT mcim_id FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_id,(SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title,mcdp_image,mcdp_document FROM main_categories_data_postings WHERE DATEDIFF(CURRENT_DATE,mcdp_date_of_post)<=? AND mcdp_status=? ORDER BY mcdp_id DESC LIMIT ?";
	}
}
if ( ! function_exists('mcdp_sql7'))
{
	function mcdp_sql7()
	{
		return "SELECT (SELECT mcim_id FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_id,(SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title FROM main_categories_data_postings WHERE DATEDIFF(CURRENT_DATE,mcdp_date_of_post)<=? AND mcdp_status=? ORDER BY mcdp_id ASC LIMIT ?";
	}
}
if ( ! function_exists('mcdp_sql8'))
{
	function mcdp_sql8()
	{
		return "SELECT (SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title,mcdp_image,mcdp_document FROM main_categories_data_postings WHERE mcdp_category_id=? AND mcdp_status=? AND DATEDIFF(CURRENT_DATE,mcdp_date_of_post)<=? ORDER BY mcdp_id ASC LIMIT ?";
	}
}
if ( ! function_exists('mcdp_sql9'))
{
	function mcdp_sql9()
	{
		return "SELECT (SELECT mcim_id FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_id,(SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title,mcdp_image,mcdp_document,LEFT(mcdp_post_content,200) as mcdp_post_content,mcdp_post_content as totalcontent FROM `main_categories_data_postings` WHERE DATEDIFF(CURRENT_DATE,mcdp_date_of_post)<=? AND mcdp_status=? ORDER BY mcdp_id DESC LIMIT ?";
	}
}
if ( ! function_exists('mcdp_sql10'))
{
	function mcdp_sql10()
	{
		return "SELECT (SELECT mcim_id FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_id,(SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title,mcdp_image,mcdp_document,LEFT(mcdp_post_content,200) as mcdp_post_content,mcdp_post_content as totalcontent FROM `main_categories_data_postings` WHERE DATEDIFF(CURRENT_DATE,mcdp_date_of_post)<=? AND mcdp_status=? AND mcdp_category_id=? ORDER BY mcdp_id DESC LIMIT ?";
	}
}
if ( ! function_exists('mcdp_sql11'))
{
	function mcdp_sql11()
	{
		return "SELECT (SELECT mcim_id FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_id,(SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title,mcdp_image,mcdp_document,LEFT(mcdp_post_content,200) as mcdp_post_content,mcdp_post_content as totalcontent FROM `main_categories_data_postings` WHERE DATEDIFF(CURRENT_DATE,mcdp_date_of_post)<=? AND mcdp_status=? AND mcdp_sub_category_id=? ORDER BY mcdp_id DESC LIMIT ?";
	}
}
if ( ! function_exists('mcdp_sql12'))
{
	function mcdp_sql12()
	{
		return "SELECT (SELECT mcim_id FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_id,(SELECT mcim_name FROM main_categories_information_master WHERE main_categories_information_master.mcim_id=main_categories_data_postings.mcdp_category_id) as mcim_name,(SELECT scim_name FROM sub_categories_information_master WHERE sub_categories_information_master.scim_id=main_categories_data_postings.mcdp_sub_category_id) as scim_name,mcdp_id,mcdp_title,mcdp_image,mcdp_document,LEFT(mcdp_post_content,200) as mcdp_post_content,mcdp_post_content as totalcontent,mcdp_date_of_post FROM `main_categories_data_postings` WHERE mcdp_status=? AND mcdp_id=? ORDER BY mcdp_id DESC LIMIT ?";
	}
}
###########################################################################################
// website_contacts_information_master
###########################################################################################
if ( ! function_exists('wcim_sql1'))
{
	function wcim_sql1()
	{
		return "INSERT INTO `website_contacts_information_master` (`wcim_name`, `wcim_mobile`, `wcim_email`, `wcim_message`, `wcim_created_at`) VALUES (?, ?, ?, ?, now());";
	}
}
if ( ! function_exists('wcim_sql2'))
{
	function wcim_sql2()
	{
		return "SELECT * FROM website_contacts_information_master ORDER BY wcim_id DESC";
	}
}
if ( ! function_exists('wcim_sql3'))
{
	function wcim_sql3()
	{
		return "DELETE FROM website_contacts_information_master WHERE wcim_id=?";
	}
}
###########################################################################################
// website_contacts_information_master
###########################################################################################
if ( ! function_exists('be_sql1'))
{
	function be_sql1()
	{
		return "SELECT * FROM business_enquries";
	}
}
###########################################################################################
// webinar_details_master
###########################################################################################
if ( ! function_exists('wdm_sql1'))
{
	function wdm_sql1()
	{
		return "INSERT INTO `webinar_details_master` (`wdm_thumbnail_img`, `wdm_content`, `wdm_title`, `wdm_youtube_url`, `wdm_status`, `wdm_date_of_webinar`, `wdm_created_at`) VALUES (?,?,?,?,?,?,now());";
	}
}
if ( ! function_exists('wdm_sql2'))
{
	function wdm_sql2()
	{
		return "SELECT * FROM `webinar_details_master`";
	}
}
if ( ! function_exists('wdm_sql3'))
{
	function wdm_sql3()
	{
		return "SELECT * FROM `webinar_details_master` WHERE wdm_id=?";
	}
}
if ( ! function_exists('wdm_sql4'))
{
	function wdm_sql4()
	{
		return "UPDATE webinar_details_master SET wdm_title=?, wdm_youtube_url=?, wdm_status=?, wdm_date_of_webinar=?, wdm_content=?, wdm_thumbnail_img=? WHERE wdm_id=?";
	}
}
###########################################################################################
// podcasts
###########################################################################################
if ( ! function_exists('p_sql1'))
{
	function p_sql1()
	{
		return "INSERT INTO `podcasts` (`p_title`, `p_image`, `p_description`, `p_audio`, `p_status`, `p_created_at`) VALUES (?,?,?,?,?,now());";
	}
}
if ( ! function_exists('p_sql2'))
{
	function p_sql2()
	{
		return "SELECT * FROM podcasts";
	}
}
if ( ! function_exists('p_sql3'))
{
	function p_sql3()
	{
		return "SELECT * FROM podcasts WHERE p_id=?";
	}
}
if ( ! function_exists('p_sql4'))
{
	function p_sql4()
	{
		return "UPDATE podcasts SET p_title=?, p_image=?, p_description=?, p_audio=?, p_status=?, p_updated_at=now() WHERE p_id=?";
	}
}
?>