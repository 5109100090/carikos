<?php
class Kos_model extends CI_Model{

	var $table = 'kos';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('pagination');
	}
	
	function total_data(){
		return $this->db->get($this->table)->num_rows();
	}
	
	private function query_search($data){
		$data['limit'] = (empty($data['limit']) ? 9 : $data['limit']);
		$data['order'] = (empty($data['order']) ? '' : $data['order']);
		$data['rel'] = (empty($data['rel']) ? 'AND' : $data['rel']);
		/*
			SELECT kos.*, kamar.*
			FROM kos INNER JOIN kamar
			ON kos.kos_id = kamar.kos_id
			WHERE kos.kos_jenis=1 AND kos.kelurahan_id=1 AND kamar.kamar_harga BETWEEN 100000 AND 300000
			ORDER BY kos.kos_nama
		*/
		$q = "SELECT max(kamar_harga) as max_harga, min(kamar_harga) as min_harga, kos.* FROM ".$this->table." LEFT JOIN kamar ON kos.kos_id = kamar.kos_id";
		$w = "";
		if(trim($data['kos_jenis']) != 0 && !empty($data['kos_jenis'])){
			if(empty($w))	$w .= " WHERE kos_jenis = '".$data['kos_jenis']."'";
			else			$w .= " ".$data['rel']." kos_jenis = '".$data['kos_jenis']."'";
		}
		if(trim($data['kelurahan_id']) != 0 && !empty($data['kelurahan_id'])){
			if(empty($w))	$w .= " WHERE kelurahan_id = '".$data['kelurahan_id']."'";
			else			$w .= " ".$data['rel']." kelurahan_id = '".$data['kelurahan_id']."'";
		}
		if(!empty($data['kos_harga1']) && !empty($data['kos_harga2']) && trim($data['kos_harga1']) != 0 && trim($data['kos_harga2']) != 0){
			if(empty($w))	$w .= " WHERE kamar.kamar_harga BETWEEN '".$data['kos_harga1']."' AND '".$data['kos_harga2']."'";
			else			$w .= " ".$data['rel']." kamar.kamar_harga BETWEEN '".$data['kos_harga1']."' AND '".$data['kos_harga2']."'";
		}
		$w .= " GROUP BY kos.kos_id";
		$config['base_url'] = site_url('search/result_ajax');
		$config['total_rows'] = $this->db->query($q.$w)->num_rows();
		$config['per_page'] = $data['limit'];
		$config['num_links'] = 6;
		$config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';

        $offset = $this->uri->segment(3);
        $offset = ( ! is_numeric($offset) || $offset < 1 || empty($offset) || $this->uri->segment(1) == "profile") ? 0 : $offset;
		$this->pagination->initialize($config); 
		
		return $this->db->query($q.$w." ".$data['order']." LIMIT $offset,".$data['limit']);
		//echo($q.$w." ".$data['order']." LIMIT $offset,".$data['limit']);
	}
	
	public function result(){
		$data['kos_jenis'] = $this->input->post('jenis_form');
		$data['kelurahan_id'] = $this->input->post('kelurahan_form');
		$harga = $this->input->post('harga');
		if($harga != 0){
			$x = explode('-', $harga);
			$data['kos_harga1'] = $x[0];
			$data['kos_harga2'] = $x[1];
		}
		
		return $this->query_search($data);
	}
	
	public function list_kos(){
		$per_page = 9;
		$config['base_url'] = site_url('search/all');
		$config['total_rows'] = $this->total_data();
		$config['per_page'] = $per_page;
		$config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';

        $offset = $this->uri->segment(3);
        $offset = ( ! is_numeric($offset) || $offset < 1 || empty($offset)) ? 0 : $offset;
		$this->pagination->initialize($config); 
		
		return $this->db->query("select * from ".$this->table." GROUP BY kos.kos_id limit $offset,$per_page");
	}
	
	public function detail_kos($id){
		return $this->db->get_where($this->table, array('kos_id' => $id));
	}
	
	public function get_kelurahan($id){
		return $this->db->get_where($this->table, array('kelurahan_id' => $id));
	}
	
	public function suggestion_kos($sug){
		$kos = $this->detail_kos($sug['id']);
		$data = $kos->row_array();
		//$kamar = $kamar->row_array();
		$data['limit'] = (empty($sug['limit']) ? 5 : $sug['limit']);
		$data['rel'] = 'OR';
		//$data['kos_jenis'] = 0;
		//$data['kelurahan_id'] = 0;
		//$data['order'] = 'ORDER BY RAND()';
		//$data['kos_harga1'] = $kamar['kos_harga'];
		return $this->query_search($data);
	}
	
	public function count_on_kelurahan($id){
		return $this->db->get_where($this->table, array('kelurahan_id' => $id))->num_rows();
	}
	
	public function get_pemilik_kos($id){
		$this->db->select('*');
		$this->db->from('pemilik_kos');
		$this->db->join('kos', 'pemilik_kos.kos_id = kos.kos_id');
		$this->db->where('pemilik_kos.pemilik_id', $id);
		return $this->db->get();
		//return $this->db->get_where('pemilik_kos', array('pemilik_id' => $id));
	}
	
	public function get_all(){
		return $this->db->query("
			SELECT min(kamar.kamar_harga) as min_harga, max(kamar.kamar_harga) as max_harga, kos.*, kamar.* FROM `kamar`
			inner join kos on kamar.kos_id=kos.kos_id
			group by kos.kos_id");
	}
	
	public function insert_kos($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update_kos($id, $data){
		$this->db->update($this->table, $data, array('kos_id' => $id));
	}
}
?>