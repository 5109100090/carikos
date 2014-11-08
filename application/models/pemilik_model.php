<?php
class Pemilik_model extends CI_Model{

	var $table = 'pemilik_kos';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('pagination');
	}
	
	public function detail_pemilik($id){
		return $this->db->get_where('users', array('id' => $id));
	}
	
	public function get_pemilik_kos($id){
		/*$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('kos', $this->table.'.kos_id = kos.kos_id');
		$this->db->where($this->table.'.pemilik_id', $id);
		return $this->db->get();*/
		return $this->db->get_where('kos', array('pemilik_id' => $id));
		
	}
	
	public function update_data($data){
		$this->db->update('users', $data, array('id'=> $data['id']));
	}
}
?>