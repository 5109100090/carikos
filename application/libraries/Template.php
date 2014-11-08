<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template{
	
	var $CI = null;
	
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('kos_helper');
		$this->CI->load->model('fasilitas_model');
		$this->CI->load->model('kamar_model');
	}
	
	public function get_header($mode){
		$this->CI->load->model('kawasan_model');
		$data['list_kawasan'] = $this->CI->kawasan_model->list_kawasan();
		$data['list_fasilitas'] = $this->CI->fasilitas_model->list_fasilitas();
		$harga = $this->CI->kamar_model->get_minmax_harga();
		$data['max_harga'] = $harga->max_harga;
		$data['min_harga'] = $harga->min_harga;
		
	    $this->CI->load->view('template/start_'.$mode);
	    $this->CI->load->view('template/header'.($mode == "panel" ? '_panel' : ''), $data);
	}
	
	public function get_footer($mode){
		$this->CI->load->view('template/footer'.($mode == "panel" ? '_panel' : ''));
	}
}
?>