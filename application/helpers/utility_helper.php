<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('check_request_method'))
{
	function check_request_method($incoming_request_method, $accepted_request_method)
	{
		if($incoming_request_method==$accepted_request_method)
		{
			return true;
		}
		else
		{
			echo json_encode(['status' => '400', 'message' => 'invalid request method','data' => []]);
			die;
		}
	}
}
if ( ! function_exists('upload_file'))
{
	function upload_file($path,$allowed_types,$file,$size)
	{
		$instance = get_instance();
		$config['upload_path'] = $path;
		$config['allowed_types'] = $allowed_types;
		$config['max_size'] = $size;
		$config['remove_spaces'] = TRUE;
		$config['file_name'] = mt_rand(111111,999999).time();
		$instance->load->library('upload',$config);
		$instance->upload->initialize($config);
		$instance->upload->do_upload($file);
		$uploaded_info = $instance->upload->data();
		if(!empty($instance->upload->display_errors()))
		{
			return 0;
		}
		else
		{
			return $uploaded_info['file_name'];
		}
	}
}
if ( ! function_exists('validate_image_dimensions'))
{
	function validate_image_dimensions($image,$width_to_be_validated,$height_to_be_validated)
	{
		$data = getimagesize($image);
        $width = (!empty($data[0])) ?  $data[0] : '1';
        $height = (!empty($data[1])) ?  $data[1] : '2';
        if($width==$width_to_be_validated && $height==$height_to_be_validated)
        {
        	return 1;
        }
        else
        {
        	return 0;
        }
	}
}
if ( ! function_exists('get_flash_message'))
{
	function get_flash_message($message,$type)
	{
		if($type==0)
		{
			return get_instance()->session->set_flashdata('flash','<div class="alert alert-warning"><strong style="color:red;">'.$message.'</strong></div>');
		}
		else
		{
			return get_instance()->session->set_flashdata('flash','<div class="alert alert-success"><strong style="color:green;">'.$message.'</strong></div>');
		}
	}
}
if ( ! function_exists('get_sql_secret_concat_string'))
{
	function get_sql_secret_concat_string()
	{
		return "!#~ak~#!";
	}
}
if ( ! function_exists('encode_string'))
{
	function encode_string($string)
	{
		return base64_encode(base64_encode(base64_encode($string)));
	}
}
if ( ! function_exists('decode_string'))
{
	function decode_string($string)
	{
		return base64_decode(base64_decode(base64_decode($string)));
	}
}
if ( ! function_exists('get_base64_user_icon'))
{
	function get_base64_user_icon()
	{
		return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAABENJREFUaEPtmV1oW2UYx//PSdquq52UMb8v3KaysnZok3QMq050NElRWzWbH92JN84bP2B+dIIXAW9snSjWG0VBcrJN6bRVsScZKCkriM1JsdYWJ7ruQuZA7GDGNVvM+0iqRWmT5pz3nKUOdm7P8/8//9953pP3nBPCRX7QRZ4flwBWeoKOTmBzKFS9OlPbxYT7mNFCwHUFQAZ+JsI4gYbO1p0dmhoYOO8UuGMA3mD4ARaij4g2LB+OfyLGC6m49rETELYBQqGQ60RmdS+Dn7USiIH96a0behCJCCu6xbW2AXyB8H6r4f8NwX2GrvWsGEBh2YD5sJ0ADNGV1mNDsh7SEyjcsLWZVdMAbZRtPn+DE2aydXObZG9saQBfQN3FwAd2wi9omXlnOq4NyHhJA7QEwocU8EMyTRdrGHwgrWvdMl7SAJ6A+gMBN8o0XQqAY2k9uknGSxrAG1B/B3CZTNMimoyhR+tlvP4XAAycSevRyysK4PGrx4hwk0zTJRri741hrVHGS34CQfUgGA/LNF0KIGLGcGy3jJc0gC8Y3snMH8o0LaIJGXpUakOUBvB49lTRFdlpADfYgWDm49n6bGPFN7JCaJ9/9/1M9JEdABA6jeHoJ7Ie0hNYaOgJqK8S8JxMAAJ6U3p0n4x2QWMbAJGI4h07/goYz1sLwn3G1o0vrvjj9EJob1B9AswvA7RueRD+lYCXUrr2jjXg4tX2JhCJKL6xmQeZ+SkAtwKmPxIwEY0CeCvVuv6wnSlIA/ja1btZ4dcA2mLnSjJhgpn3juvalzI+lgG2hUK1uUxtL4AnLVzxctmYgTfr55R9yeT72XLF/z1vCaC545GGGuH+FECblSamawW+Vv5Ex9gX0d/MakwDtN6lrs1X8wiBNps1l6pjTFZx1favEu/NmtGbApjfddfNJUB0pxlTuzVEdPQ0r9nxo95/rpyXKQBvQO3/Z82X83PyfL+hR58uZ1gWoNWvbhPgURAp5cwcPc8sBPP28UTs6HK+5QDI61cnQGh2NJxpM/7W0LWb//46KbGReQLdnQRl0HS/C1BI4HtTuvaZFEBLQE0qwB0XIJd5S+akEddK/niUXEK+4GNXscifBFG5ZWY+jEwlzx/XphOxX4rJSwMEwnsY/LZMT6c1THg8PRx91xKA1999EKQ4885rlygvYsaR4u/MJSfg8T86Q+S63m5vJ/QseCad0Ir+71AaoL17lhSlwYkAdj2Y87Pp+IG1lpbQLTt2nXK5a66029wJfS6fOzVx5NDVlgCabuuarqmra6z0Brw4JLPA+bk/piZHBpusAbR1vkEuesZdvQqKy13xX1NmBos8cueyEODXp0YG91oCaG7raIBS9R0D1zixDGQ9CDgJkWuaHP38tCWAQvGW2+9ZL+AqvH21A1gjG0JSd0YIEa92Kz3fJIdOSD1KSDauqGxlHxMcQL0E4MBFtGXxF0awa0BwZeOnAAAAAElFTkSuQmCC";
	}
}
if ( ! function_exists('get_empty_text'))
{
	function get_empty_text($string)
	{
		return "<h5 style='color:red;'>".$string."</h5>";
	}
}
?>