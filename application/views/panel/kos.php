<script type="text/javascript">
	$(document).ready(function(){
		$("#kawasan").change(function(){
			//var x = $("#kawasan option[value='"+ $(this).val() +"']").text();
			//$("#kawasan").val(x);
			//$("#display_kawasan").text(x);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('kawasan/get_kelurahan2') ?>",
				data: $(this).serialize(),
				success: function(data) {
					$("div#box_kelurahan").html(data);
					$("div#box_kelurahan select").addClass('porm');
				}
			});
			return false;
		});
		$("#data-kos").submit(function(){
			$.post($(this).attr("action"), $(this).serialize(), function(data) {
				$("#message-box-kos").html(data);
			}); return false;
		});
		$("#data-fasilitas").submit(function(){
			$.post($(this).attr("action"), $(this).serialize(), function(data) {
				$("#message-box-fasilitas").html(data);
			}); return false;
		});
		
		var lat = $("#kos_lat").val();
		var lng = $("#kos_lng").val();
		var addr = $("#kos_alamat").val();
		
		if(lat == '' && lng == ''){
			lat = '-7.318881730366743'; lng = '112.7197265625';
		}
		
		var myOptions = {
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("googlemap2"), myOptions);
		initialLocation = new google.maps.LatLng(lat, lng);
        map.setCenter(initialLocation);
		
		var mainMarker = [];
		var base_url = "<?php echo base_url() ?>";
        var marker = new google.maps.Marker({
            position: initialLocation,
            clickable: true,
			draggable: true,
            map: map,
			icon : base_url+'static/images/template/home/tag_cari.png',
			title : 'drop me'
        });
		
		function codeLatLng(lat1, lng1) {
			var geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(lat1, lng1);
			geocoder.geocode({'latLng': latlng}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						$("#kos_alamat").val(results[0].formatted_address);
					}
				} else {
					return ("Geocoder failed due to: " + status);
				}
			});
		}
		
		google.maps.event.addListener(marker, "dragend", function () {
			var newLat = marker.getPosition().lat().toString();
			var newLng = marker.getPosition().lng().toString();
			codeLatLng(newLat, newLng);
			$("#kos_lat").val(newLat);
			$("#kos_lng").val(newLng);
        });
        mainMarker.push(marker);
		/*
		$("form.form_kamar").submit(function() {
			$('input[type="submit"].update_kamar').attr('disabled', 'disabled');
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(data) {
					$('input[type="submit"].update_kamar').removeAttr('disabled');
				}
			}) return false;
		});
		$('button[name="delete"]').click(function(){
			var id = $(this).attr('value');
			$.post("<?php echo site_url('panel_process/process_kamar/delete')?>", {kamar_id: id}, function(){ $("tr#kamar_"+id).remove(); });
		});
		$('input.fasilitas_checkbox').click(function(){
			var val = $(this).attr('value');
			var f_id = $(this).attr('f_id');
			var k_id = <?php echo $kos_id ?>;
			alert(val + ' - ' + f_id + ' - ' + k_id);
			/*if($(this).is(':checked')){
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('panel_process/process_fasilitas/delete')?>",
					data: $.param({kos_fasilitas_id: f_id, fasilitas_id: val, kos_id: k_id}),
					dataType: 'json',
					success: function(data){
						alert(data.fasilitas_id + ' - ' + data.kos_id + ' - ' + data.kos_fasilitas_id);
					}
				}) return false;
				//$.post("<?php echo site_url('panel_process/process_fasilitas/delete')?>", {kos_fasilitas_id: f_id, fasilitas_id: val, kos_id: k_id}, function(data){ alert(data.fasilitas_id); });
			}else{
				$.post("<?php echo site_url('panel_process/process_fasilitas/insert')?>", {kos_fasilitas_id: f_id, fasilitas_id: val, kos_id: k_id});
			}
		});*/
	});
</script>
<?php ($form_data ? $row = $detail_kos->row() : '') ?>
    <?php if($form_data) : ?><div id="content"><?php endif; ?>
		<?php if($form_data) : ?>
		<?php echo 'Data Kos : '.$row->kos_nama.' '.anchor('profile/view/'.$row->kos_id, 'lihat profil &raquo;') ?><br/>
		<?php $photo = ($row->kos_id % 4) + 1; ?>
		<?php foreach($photos as $p) : ?>
			<img src="<?php echo base_url().'static/images/profile/'.$p ?>" width="180">&nbsp;
		<?php endforeach; ?>
		<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="<?php echo site_url('panel_process/upload') ?>">
			<input type="hidden" name="kos_id" value="<?php echo ($form_data ? $row->kos_id : '')?>">
			<input type="file" name="userfile" value=""  /> <input type="submit" name="upload" value="upload" />
		</form>
		<?php endif; ?>
		<p>Identitas Kos</p>
        <div id="googlemap2" class="googlemap"></div>
        <div id="message-box-kos"></div>
		<form id="data-kos" method="post" action="<?php echo site_url('panel_process/process_kos/'.($form_data ? 'update' : 'insert')) ?>">
		<input type="hidden" name="kos_id" value="<?php echo ($form_data ? $row->kos_id : '')?>">
		<input type="hidden" name="kos_lat" id="kos_lat" value="<?php echo ($form_data ? $row->kos_lat : '')?>">
		<input type="hidden" name="kos_lng" id="kos_lng" value="<?php echo ($form_data ? $row->kos_lng : '') ?>">
		<table border="0">
			<tr>
				<td>Nama</td>		<td>: <input class="porm" type="text" name="nama" value="<?php echo ($form_data ? $row->kos_nama : '') ?>">
			</tr>
			<tr>
				<td>Deskripsi</td>		<td>: <input class="porm" type="text" name="desc" maxlength="140" value="<?php echo ($form_data ? $row->kos_description : '') ?>">
			</tr>
			<tr>
				<td>Kawasan</td>		<td>: <select class="porm" name="kawasan" id="kawasan">
				<option value="0">- Kawasan -</option>
				<?php ($form_data ? $kawasan_id = $this->kawasan_model->get_kawasan_id($row->kelurahan_id) : ''); foreach($kawasan->result() as $r) : ?>
				<option value="<?php echo $r->kawasan_id ?>" <?php echo ($form_data ? ($kawasan_id == $r->kawasan_id ? 'selected' : '') : '') ?>><?php echo $r->kawasan_nama ?></option>
				<?php endforeach; ?></select>
			</tr>
			
			<tr>
				<td>Kelurahan</td>		
				<td>: <div class="porm" id="box_kelurahan" style="display:inline">
				
				<select name="kelurahan" class="porm">
					<option value="0">- Kelurahan -</option>
					<?php foreach($this->kawasan_model->list_kelurahan($kawasan_id)->result() as $r) : ?>
					<option class="porm" value="<?php echo $r->kelurahan_id ?>" <?php echo ($row->kelurahan_id == $r->kelurahan_id ? 'selected' : '') ?>><?php echo $r->kelurahan_nama ?></option>
					<?php endforeach; ?>
				</select>
				</div></td>
			</tr>
			<tr>
				<td>Alamat</td>	
				<td>: <textarea id="kos_alamat" class="porm" name="alamat"><?php echo ($form_data ? $row->kos_alamat : '') ?></textarea>
			</tr>
			<tr>
				<td>Telp/HP</td>		
				<td>: <input class="porm" type="text" name="telp" value="<?php echo ($form_data ? $row->kos_hp : '') ?>"></td>
			</tr>
			<tr>
				<td>Email</td>			
				<td>: <input class="porm" type="text" name="email" value="<?php echo ($form_data ? $row->kos_email : '') ?>"></td>
			</tr>
			<tr>
				<td>Jenis Kos</td>		
				<td>: <select name="jenis" class="porm">
				<?php $i=0; foreach(jenis_kos() as $r) : ?>
				<option value="<?php echo ($i != '' ? $i : '') ?>" <?php echo ($form_data && $i == $row->kos_jenis ? 'selected' : '') ?>><?php echo $r ?></option>
				<?php $i++; endforeach; ?>
				</select>
				</td>
			</tr>
			<tr><td colspan="2"><input type="submit" value="simpan"></td></tr>
        </table>
		</form>
		
		
		<?php if($form_data) : ?>
		
		<div style="height:20px;"></div>
		<p>Fasilitas Kos</p>
		<div id="message-box-fasilitas"></div>
		<form id="data-fasilitas" method="post" action="<?php echo site_url('panel_process/process_fasilitas') ?>">
		<input type="hidden" name="kos_id" value="<?php echo ($form_data ? $row->kos_id : '')?>">
		<table border="0" align="center"><tr>
		<?php
			if($form_data) :
				$q = $fasilitas->result_array();
				$j=0;
				foreach($list_fasilitas->result() as $r) :
					if($j%6==0 && $j!=0)  echo '</tr><tr>';
					$checked = false;
					$count = count($q);
					for($i=0; $i<$count; $i++){
						if($r->fasilitas_id == $q[$i]['fasilitas_id']){
							$checked = true;
							break;
							//unset($q[$i]);
						}
					}
			?>
			<td><input type="checkbox" name="fasilitas_checkbox[]" class="fasilitas_checkbox" value="<?php echo $r->fasilitas_id ?>" <?php echo ($checked ? 'checked' : '') ?> f_id="<?php echo ($i<$count ? $q[$i]['kos_fasilitas_id'] : '') ?>" />
			<?php echo $r->fasilitas_name ?> &nbsp;</td>
		<?php $j++; endforeach; endif; ?>
		<?php
			if($form_data == false) :
				$j=0;
				foreach($list_fasilitas->result() as $r) :
					if($j%6==0 && $j!=0)  echo '</tr><tr>';
			?>
			<td><input type="checkbox" name="fasilitas" class="fasilitas_checkbox" value="<?php echo $r->fasilitas_id ?>" />
			<?php echo $r->fasilitas_name ?> &nbsp;</td>
		<?php $j++; endforeach; endif; ?>
		</tr>
		<tr><td colspan="6" align="center"><input type="submit" value="simpan" /></td></tr>
		</table>
		</form>
		
		<div style="height:10px;"></div>
		<p>Persediaan Kos</p>
		<table border="0" cellspacing="0" cellpadding="0">
			<tr><td>Tipe Kamar</td><td>Dimensi</td><td>Kapasitas</td><td>Harga (Rp)</td><td>Tersedia/Jumlah</td><td>Simpan</td></tr>
			<?php if($form_data) : foreach($list_kamar->result() as $r) : ?>
			<tr id="kamar_<?php echo $r->kamar_id ?>">
			<form method="post" action="<?php echo site_url('panel_process/process_kamar/update')?>" class="form_kamar">
				<input type="hidden" name="kamar_id" value="<?php echo $r->kamar_id ?>">
				<input type="hidden" name="kos_id" value="<?php echo $kos_id ?>">
					<td><input type="text" name="nama" value="<?php echo $r->kamar_nama ?>" /></td>
					<td><input type="text" name="dimensi" value="<?php echo $r->kamar_dimensi ?>" /></td>
					<td><input type="text" name="kapasitas" value="<?php echo $r->kamar_kapasitas ?>" size="2" /></td>
					<td><input type="text" name="harga" value="<?php echo $r->kamar_harga ?>" size="5" /></td>
					<td><input type="text" name="tersedia" value="<?php echo $r->kamar_tersedia ?>" size="2" /> / <input type="text" name="jumlah" value="<?php echo $r->kamar_jumlah ?>" size="2" /></td>
					<td><input type="submit" value="simpan" class="update_kamar" /></td>
					<td><input type="submit" name="delete" value="hapus"/></td>
			</form>
			</tr>
			<?php endforeach; endif; ?>
			<form method="post" action="<?php echo site_url('panel_process/process_kamar/insert')?>">
				<input type="hidden" name="kamar_id" value="">
				<?php if($form_data) : ?><input type="hidden" name="kos_id" value="<?php echo $kos_id ?>"><?php endif; ?>
				<tr>
					<td><input type="text" name="nama" /></td>
					<td><input type="text" name="dimensi" /></td>
					<td><input type="text" name="kapasitas" size="2" /></td>
					<td><input type="text" name="harga" size="5" /></td>
					<td><input type="text" name="tersedia" size="2" /> / <input type="text" name="jumlah" size="2" /></td>
					<td><input type="submit" value="tambah" /></td>
				</tr>
			</form>
		</table>
		
		<?php endif; ?>
		
		<?php echo ($form_data ? anchor('panel', '&laquo; kembali') : '') ?>
    </div>