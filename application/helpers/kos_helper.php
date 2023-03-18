<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function jenis_kos($opt = -1) {
		$data = array(
			0 => '- Jenis -',
			1 => 'Pria',
			2 => 'Wanita',
			3 => 'Pria dan Wanita',
		);
		if($opt != -1)	return $data[$opt];
		return $data;
	}
	
	function get_photo($id, $return){
		//$id = ($id%4)+1;
		$image = "https://raw.githubusercontent.com/itsnotrisky/carikos-static/gh-pages/images/profile/".$id."-1.jpg";
		$val = true;
		/*
		if(!file_exists(FCPATH.$image)){
			$image = "static/images/profile/no_image.jpg";
			$val = false;
		}
		*/
		if($return) return $image;
		return $val;
	}
	
	function browser_compatibility(){
		$CI = & get_instance();
		$CI->load->library('user_agent');
		if ($CI->agent->is_browser('MSIE') || $CI->agent->is_browser('Internet Explorer')){
			echo 'Situs ini dapat dilihat maksimal pada browser Google Chrome atau Mozilla Firefox';
			exit;
		}
	}
?>