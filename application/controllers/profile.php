<?php
class Profile extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model(array('kos_model', 'kamar_model', 'kawasan_model', 'fasilitas_model', 'pemilik_model'));
		$this->load->helper(array('url', 'kos_helper', 'file'));
		$this->load->library('template');
		browser_compatibility();
	}
	
	public function view($id){
		$data['detail_kos'] = $this->kos_model->detail_kos($id);
		$data['list_kamar'] = $this->kamar_model->detail_kos($id);
		$data['fasilitas'] = $this->fasilitas_model->get_fasilitas($id);
		$sug['id'] = $id;
		$sug['limit'] = 5;
		$data['suggestion_kos'] = $this->kos_model->suggestion_kos($sug);
		$f = array();
		$file = get_filenames('static/images/profile/');
		$i = 0;
		foreach($file as $a){
			$e = explode('-', $a);
			if($e[0] == $id){
				$f[$i] = $a;
				$i++;
			}
		}
		$data['photos'] = $f;
		
		$this->template->get_header('profile');
		$this->load->view('main_profile', $data);
		$this->template->get_footer('search');
	}
	
	public function suggestion_kos(){
		$kos_id = $this->input->post('kos_id');
		$limit_suggestion = $this->input->post('limit_suggestion');
		$sug['id'] = $kos_id;
		$sug['limit'] = $limit_suggestion;
		$s = $this->kos_model->suggestion_kos($sug);
		foreach($s->result() as $r) : echo '
			<div  class="kotak">
			<img class="foto_kcl" src="'.base_url().get_photo($r->kos_id, true).'" width="90" height="60" style="float:left">
			<div class="deskrip" >
				<li class="nm">'.anchor("profile/view/".$r->kos_id, $r->kos_nama).'</li>
				<li class="al">'.$r->kos_alamat.'</li>
			</div><br></div>';
		endforeach;
	}
}
?>