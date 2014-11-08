<?php
class Search extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'kos_helper'));
		$this->load->model(array('kos_model', 'kawasan_model'));
		$this->load->library('template');
		browser_compatibility();
	}
	
	public function all(){
		$this->result();
	}
	public function result(){
		//$data['list_kawasan'] = $this->kawasan_model->list_kawasan();
		//$data['list_fasilitas'] = $this->fasilitas_model->list_fasilitas();
		//$harga = $this->kamar_model->get_minmax_harga();
		//$data['max_harga'] = $harga->max_harga;
		//$data['min_harga'] = $harga->min_harga;
		//$this->load->view('search', $data);
		$data['list_kos'] = $this->kos_model->result();
		$data['create_links'] = $this->pagination->create_links();
		$this->template->get_header('search');
		$this->load->view('main_search', $data);
		$this->template->get_footer('search');
	}
	
	public function result_ajax(){
		$list_kos = $this->kos_model->result();
echo '
<script type="text/javascript">
	$(document).ready(function(){
		$("#AJAXmenu a").click(function() {
				$("#AJAXcontent").slideUp("slow");
				$("#AJAXcontent").html("");
				var url = $(this).attr("href");
				$("#AJAXcontent").load(url).slideDown("slow");
				return false;
			});
		});
</script>
';
		foreach($list_kos->result() as $row) :
            echo "
			<a href='".site_url('profile/view/'.$row->kos_id)."'>
                <div class='box-result'>
                    <div class='result-view'>
                        <li class='nama_kos'> ".$row->kos_nama."</li> <br/>
                        <li class='foto'><img src='".get_photo($row->kos_id, true)."' height='140'></li>
                        <li class='detil' >Alamat : ".$row->kos_alamat."</li>
                        <li class='detil' >Fasilitas : ";
								$f = $this->fasilitas_model->get_fasilitas($row->kos_id);
								$i = 1; $n = $f->num_rows(); $l = 4;
								foreach($f->result() as $r){
									if($i > $l) break;
									echo $r->fasilitas_name.($i != $n && $i < $l ? ', ' : '.');
									$i++;
								}
						echo "</li><br />
                    </div>
                </div>
            </a>";
        endforeach;
		echo '<div id="AJAXmenu">'.$this->pagination->create_links().'</div>';
	}
	
	private function distance($lat1, $lon1, $lat2, $lon2, $unit){
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $dist = $dist * 60 * 1.1515;
        if ($unit == 'K'){
            $dist = $dist * 1.609344;
        }else if (unit == 'N'){
            $dist = $dist * 0.8684;
        }
        return $dist;
    }
	
	public function by_map(){
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		$points = array();
		$q = $this->kos_model->get_all();
		foreach($q->result_array() as $r){
			$x = $this->distance(floatval($lat), floatval($lng), floatval($r['kos_lat']), floatval($r['kos_lng']), 'K');
			if($x <= 1.000){
				array_push($points, $r);
			}
		}
		echo json_encode(array('Locations' => $points));
		exit;
	}
}
?>