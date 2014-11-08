<?php
class Page extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'kos_helper'));
		$this->load->model(array('kawasan_model', 'kamar_model'));
		$this->load->library(array('session', 'DX_Auth'));
		browser_compatibility();
	}
	
	public function index(){
		$this->main();
	}
	
	public function main(){
		$data['list_kawasan'] = $this->kawasan_model->list_kawasan();
		$harga = $this->kamar_model->get_minmax_harga();
		$data['max_harga'] = $harga->max_harga;
		$data['min_harga'] = $harga->min_harga;
		$this->load->view('main', $data);
	}
}
?>