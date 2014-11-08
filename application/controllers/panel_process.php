<?php
class Panel_process extends CI_Controller{
	private $pid = null;
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'kos_helper', 'file'));
		$this->load->library(array('template', 'form_validation', 'dx_auth'));
		if(!$this->dx_auth->is_logged_in())	redirect('/');
		
		$this->load->model(array('kawasan_model', 'kos_model', 'pemilik_model', 'fasilitas_model', 'kamar_model'));
		$this->pid = $this->dx_auth->get_user_id();
	}
	
	public function index(){
		redirect('/');
	}
	
	public function process_kamar($mode){
		$data = array(
			'kos_id' => $this->input->post('kos_id'),
			'kamar_id' => $this->input->post('kamar_id'),
			'kamar_nama' => $this->input->post('nama'),
			'kamar_dimensi' => $this->input->post('dimensi'),
			'kamar_kapasitas' => $this->input->post('kapasitas'),
			'kamar_jumlah' => $this->input->post('jumlah'),
			'kamar_harga' => $this->input->post('harga'),
			'kamar_tersedia' => $this->input->post('tersedia')
		);
		if($this->input->post("delete")) $mode = 'delete';
		$this->kamar_model->process_kamar($data, $mode);
		redirect('panel/kos/'.$data['kos_id']);
	}
	
	public function process_fasilitas(){
		$in = $this->input->post('fasilitas_checkbox');
		$id = $this->input->post('kos_id');
		$this->fasilitas_model->clear_fasilitas($id);
		for($i=0; $i<count($in); $i++){
			$this->fasilitas_model->insert_fasilitas(array('kos_id' => $id, 'fasilitas_id' => $in[$i]));
		}
		echo 'data tersimpan.';
	}
	
	public function process_kos($mode){
		$val = $this->form_validation;
		$val->set_rules('nama', 'Nama', 'trim|required|min_length[5]|max_length[30]|xss_clean');
		$val->set_rules('desc', 'Deskripsi', 'trim|required|min_length[5]|max_length[140]|xss_clean');
		$val->set_rules('kelurahan', 'Kelurahan', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$val->set_rules('telp', 'Telp/HP', 'trim|required|xss_clean');
		$val->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$val->set_rules('jenis', 'Jenis Kos', 'trim|required|xss_clean');
		if($val->run()){
			$data = array(
				'kos_nama' => $val->set_value('nama'),
				'kelurahan_id' => $val->set_value('kelurahan'),
				'kos_alamat' => $val->set_value('alamat'),
				'kos_hp' => $val->set_value('telp'),
				'kos_email' => $val->set_value('email'),
				'kos_jenis' => $val->set_value('jenis'),
				'kos_lat' => $this->input->post('kos_lat'),
				'kos_lng' => $this->input->post('kos_lng'),
				'kos_description' => $val->set_value('desc'),
				'pemilik_id' => $this->pid
			);
			if($mode == "insert"){
				$id = $this->kos_model->insert_kos($data);
				echo 'data tersimpan. '.anchor('panel/kos/'.$id, 'edit lebih lanjut &raquo;');
			}else{
				$id = $this->input->post('kos_id');
				$this->kos_model->update_kos($id, $data);
				echo 'data tersimpan.';
			}
		}else{
			echo validation_errors(' ', ' ');
		}
	}
	
	public function update_data(){
		if($this->dx_auth->is_logged_in()){
			$val = $this->form_validation;
			$val->set_rules('pemilik', 'Nama', 'trim|required|xss_clean');
			
			if(trim($this->input->post('password')) != ""){
				$val->set_rules('old_password', 'Password lama', 'trim|required|xss_clean');
				$val->set_rules('password', 'Password baru', 'trim|required|xss_clean|min_length[4]|max_length[20]|matches[again]');
				$val->set_rules('again', 'Ulangi', 'trim|required|xss_clean');

				if(!$this->dx_auth->change_password($this->input->post('old_password'), $this->input->post('password')))
					echo $this->dx_auth->get_auth_error();
			}
			if($val->run()){
				$data = array(
					'id' => $this->pid,
					'name' => $val->set_value('pemilik')
				);
				//if(trim($this->input->post('password')) != "")
					//if(!$this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('password')))
						//echo $this->dx_auth->get_auth_error();
				$this->pemilik_model->update_data($data);
			}else{
				echo validation_errors(' ', ' ');
			}
		}
	}
	
	private function get_image_id($id){
		$file = get_filenames('static/images/profile/');
		$i = 0;
		foreach($file as $a){
			$e = explode('-', $a);
			if($e[0] == $id){
				$i++;
			}
		}
		return $i;
	}
	
	public function upload(){
		$kos_id = $this->input->post('kos_id');
		$config['upload_path'] = './static/images/profile/';
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '100';
		$config['max_width']  = '600';
		$id = $this->get_image_id($kos_id);
		if($id == 0)	$id = 1;
		else			$id = $id + 1;
		$config['file_name']  = $kos_id.'-'.$id;

		$this->load->library('upload', $config);
		$this->upload->do_upload();
		redirect('/panel/kos/'.$kos_id);
	}
}
?>