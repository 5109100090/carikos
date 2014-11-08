<?php
class Fasilitas extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('fasilitas_model');
	}
	
	public function index(){
		redirect('/');
	}
	
	public function get_fasilitas($id){
		$this->fasilitas_model->get_fasilitas($id);
	}
}
?>