<?php
class Fasilitas_model extends CI_Model{

	var $table = 'fasilitas';
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_fasilitas($id){
		/*
			SELECT kos_fasilitas.*, fasilitas.*
			FROM kos INNER JOIN kamar
			ON kos_fasilitas.fasilitas_id = fasilitas.fasilitas_id
			WHERE kos_fasilitas.kos_id = $id
			GROUP BY kos_fasilitas.kos_fasilitas_id
		*/
		return $this->db->query("
			SELECT kos_fasilitas.*, fasilitas.*
			FROM kos_fasilitas INNER JOIN fasilitas
			ON kos_fasilitas.fasilitas_id = fasilitas.fasilitas_id
			WHERE kos_fasilitas.kos_id = $id
			GROUP BY kos_fasilitas.kos_fasilitas_id
		");
	}
	
	public function get_name($mode, $id){
		$q = $this->db->get_where($mode, array($mode.'_id' => $id));
		$q = $q->row();
		if($q)	return ($mode == 'kawasan' ? $q->kawasan_nama : $q->kelurahan_nama);
		else	return false;
	}
	
	public function list_fasilitas(){
		return $this->db->get($this->table);
	}
	
	public function clear_fasilitas($id){
		$this->db->delete('kos_fasilitas', array('kos_id' => $id));
	}
	
	public function insert_fasilitas($data){
		$this->db->insert('kos_fasilitas', $data);
	}
}
?>