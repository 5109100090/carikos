<?php
class Panel extends CI_Controller{
	private $pid = null;
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'kos_helper', 'file'));
		browser_compatibility();
		$this->load->library(array('template', 'DX_Auth'));
		if(!$this->dx_auth->is_logged_in())	redirect('/');
		
		$this->load->model(array('kawasan_model', 'kos_model', 'pemilik_model', 'fasilitas_model', 'kamar_model'));
		$this->pid = $this->dx_auth->get_user_id();
	}
	
	public function index(){
		$this->dashboard();
	}
	
	public function dashboard(){
		$data['form_data'] = false;
		$data['pemilik'] = $this->pemilik_model->detail_pemilik($this->pid);
		$data['list_kos'] = $this->pemilik_model->get_pemilik_kos($this->pid);
		$data['kawasan'] = $this->kawasan_model->list_kawasan();
		$data['list_fasilitas'] = $this->fasilitas_model->list_fasilitas();
		
		$this->template->get_header('panel');
		$this->load->view('panel/main', $data);
		$this->load->view('panel/kos', $data);
		$this->template->get_footer('panel');
	}
	
	public function kos($kid = null){
		$data['form_data'] = true;
		$data['kos_id'] = $kid;
		$data['detail_kos'] = $this->kos_model->detail_kos($data['kos_id']);
		$data['kawasan'] = $this->kawasan_model->list_kawasan();
		$data['list_fasilitas'] = $this->fasilitas_model->list_fasilitas();
		$data['fasilitas'] = $this->fasilitas_model->get_fasilitas($data['kos_id']);
		$data['list_kamar'] = $this->kamar_model->detail_kos($data['kos_id']);

		$f = array();
		$file = get_filenames('static/images/profile/');
		$i = 0;
		foreach($file as $a){
			$e = explode('-', $a);
			if($e[0] == $kid){
				$f[$i] = $a;
				$i++;
			}
		}		
		$data['photos'] = $f;
		
		$this->template->get_header('panel');
		$this->load->view('panel/kos', $data);
		$this->template->get_footer('panel');
	}
}
?>