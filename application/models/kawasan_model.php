<?php
class Kawasan_model extends CI_Model{

	var $table = 'kawasan';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('pagination');
	}
	
	public function list_kawasan(){
		return $this->db->get_where($this->table);
	}
	
	public function list_kelurahan($id){
		return $this->db->get_where('kelurahan', array('kawasan_id' => $id));
	}
	
	public function get_kawasan_id($id){
		$q = $this->db->get_where('kelurahan', array('kelurahan_id' => $id));
		$q = $q->row();
		if($q)	return $q->kawasan_id;
		else	return false;
	}
	
	public function get_name($mode, $id){
		$q = $this->db->get_where($mode, array($mode.'_id' => $id));
		$q = $q->row();
		if($q)	return ($mode == 'kawasan' ? $q->kawasan_nama : $q->kelurahan_nama);
		else	return false;
	}
}
?>