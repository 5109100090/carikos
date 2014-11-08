<?php
class Kawasan extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model(array('kawasan_model', 'kos_model'));
	}
	
	public function index(){
		redirect('/');
	}
	
	public function get_kelurahan(){
		$id = $this->input->post('kawasan_form');
		$q = $this->kawasan_model->list_kelurahan($id);
		echo '
<script type="text/javascript">
	$(document).ready(function(){
		$("#kelurahan_form").change(function(){
			//alert($(this).val());
			var x = $("#kelurahan_form option[value="+ $(this).val() +"]").text();
			$("#kelurahan").val(x);
			$("#display_kelurahan").text(x);
		});
	});
</script>
		
			<input type="hidden" name="kelurahan" id="kelurahan" value="">
			<div id="display_kelurahan" class="inputan" style="width:180px">- Kelurahan -</div>
			<div id="box_form_kelurahan_target">
			<select name="kelurahan_form" id="kelurahan_form" class="inputan1" multiple>';
			foreach($q->result() as $r){
				echo "<option value='".$r->kelurahan_id."'>".$r->kelurahan_nama."</option> ";
			}
			echo '
			</select>
		</div>
		';
		//echo "<select name='kelurahan_form' class='inputan' multiple>";
			//<option value='' disabled>- Kelurahan -</option>
		//foreach($q->result() as $r){
		//	echo "<option value='".$r->kelurahan_id."'>".$r->kelurahan_nama." (".$this->kos_model->count_on_kelurahan($r->kelurahan_id).")</option> ";
		//}
		//echo "</select>";
	}
	
	public function get_kelurahan2(){
		$id = $this->input->post('kawasan');
		$q = $this->kawasan_model->list_kelurahan($id);
		echo "<select name='kelurahan'>
			<option value='' disabled>- Kelurahan -</option>";
		foreach($q->result() as $r){
			echo "<option value='".$r->kelurahan_id."'>".$r->kelurahan_nama."</option> ";
		}
		echo "</select>";
	}
	
	public function get_kawasan_nama(){
		$id = $this->input->post('kawasan_form');
		$q = $this->kawasan_model->get_name('kawasan', $id);
		if($q != false)	echo $q;
	}
}
?>