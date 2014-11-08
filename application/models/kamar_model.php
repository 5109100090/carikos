<?php
class Kamar_model extends CI_Model{

	var $table = 'kamar';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('pagination');
	}
	
	function total_data(){
		return $this->db->get($this->table)->num_rows();
	}
	
	public function list_kamar(){
		return $this->db->get_where($this->table, array('kos_id' => $id));
	}
	
	public function detail_kos($id){
		return $this->db->get_where($this->table, array('kos_id' => $id));
	}
	
	public function get_minmax_harga(){
		$q = $this->db->query("SELECT MIN(kamar_harga) as min_harga, MAX(kamar_harga) as max_harga FROM ".$this->table);
		return $q->row();
	}
	
	public function generate_list_harga(){
		$harga = $this->get_minmax_harga();
		$min = $harga->min_harga;
		$max = $harga->max_harga;
	}
	
	public function process_kamar($data, $mode){
		if($mode == "insert"){
			$this->db->insert($this->table, $data); 
			//redirect('panel/kos/'.$data['kos_id']);
		}else if($mode == "update"){
			$this->db->update($this->table, $data, array('kamar_id' => $data['kamar_id']));
		}else{
			$this->db->delete($this->table, array('kamar_id' => $data['kamar_id'])); 
		}
	}
}
?>