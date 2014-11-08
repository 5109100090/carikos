<div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
FB.init({ appId: '127772973968963', status: true, cookie: true, xfbml: true });
</script>
<?php $row = $detail_kos->row() ?>
    <div id="content">
		<div id="spaceprofil"></div>
		<div class="header">
			<div class="title">Foto</div>
				<div class="pp">
					<div class="content"><img src="<?php echo get_photo($row->kos_id, true) ?>" width="320"></div>
				</div>
				<div class="head">
					<div class="name">
						<h3><?php echo $row->kos_nama ?></h3>
					</div>
					<div class="text"><?php echo $row->kos_description ?></div>
					<div class="photo">
					<?php if(count($photos) > 1) : $i=0; foreach($photos as $p) : if($i!=0) : ?>
						<div class="fotolain"><img src="http://spondbob.github.io/carikos-static/images/profile/<?php echo $p ?>"></div>
					<?php endif; $i++; endforeach; else : ?>
						<div class="fotolain"><img src="http://spondbob.github.io/carikos-static/images/profile/<?php echo rand(1,2).'-'.rand(1,2) ?>.jpg"></div>
						<div class="fotolain"><img src="http://spondbob.github.io/carikos-static/images/profile/<?php echo rand(3,4).'-'.rand(1,2) ?>.jpg"></div>
						<div class="fotolain"><img src="http://spondbob.github.io/carikos-static/images/profile/<?php echo rand(5,6).'-'.rand(1,2) ?>.jpg"></div>
					<?php endif; ?>
					</div>
				</div>
		</div>
		
		<div class="main">
			<div class="bar">
				
				<div class="map">
					<div class="title">Lokasi</div>
					<div class="content">
						<div id="map_canvas" style="height:300px;width:100%;margin-top:5px;margin-bottom:5px;"></div> 
					</div>
				</div>
				
				<div class="suggestion">
					<div class="title">Pilihan Lain</div>
					<div class="content">
						<div class="viewer" >
						<?php foreach($suggestion_kos->result() as $r) : ?>
							<a href="<?php echo site_url('profile/view/'.$r->kos_id) ?>">
							<div class="kotak">
								<img class="foto_kcl" src="<?php echo get_photo($r->kos_id, true) ?>" width="90" height="60" style="float:left">
								<div class="deskrip" >
										<li class="nm"> <?php echo $r->kos_nama?></li>
										<li class="al"> <?php echo $r->kos_alamat?></li>
								</div><br>
								</a>
							</div>
						<?php endforeach; ?>
						</div>
						<div id="reload-suggestion-loading" style="display:none">tunggu sebentar</div>
						<form id="reload-suggestion">
							<input type="hidden" name="kos_id" value="<?php echo $row->kos_id ?>">
							<input type="hidden" id="limit_suggestion" name="limit_suggestion" value="5">
							<input type="submit" value="lihat lagi" class="lihat_lagi">
						</form>
					</div>
				</div>
			</div>
			
			
			<div class="description">
				<div class="title">Profil</div>
				<div class="content_isi">
					<h4>Identitas</h4>
					<table border="0">
						<tr><td>Pemilik</td><td>: <?php $q = $this->pemilik_model->detail_pemilik($row->pemilik_id); if($q->row()!=null){ $r = $q->row(); echo $r->name; } ?></td></tr>
						<tr><td>Kawasan</td><td>: <?php echo $this->kawasan_model->get_name('kawasan', $this->kawasan_model->get_kawasan_id($row->kelurahan_id)) ?></td></tr>
						<tr><td>Kelurahan</td><td>:
							<?php echo $this->kawasan_model->get_name('kelurahan', $row->kelurahan_id); ?>
						</td></tr>
						<tr><td>Alamat</td><td>: <?php echo $row->kos_alamat ?>
							<input type="hidden" id="kos_lat" value="<?php echo $row->kos_lat ?>">
							<input type="hidden" id="kos_lng" value="<?php echo $row->kos_lng ?>">
							<input type="hidden" id="kos_alamat" value="<?php echo $row->kos_alamat ?>">
						</td></tr>
						<tr><td>Telp/HP</td><td>: <?php echo $row->kos_hp ?></td></tr>
						<tr><td>Email</td><td>: <?php echo $row->kos_email ?></td></tr>
						<tr><td>Jenis Kos</td><td>: <?php echo jenis_kos($row->kos_jenis) ?></td></tr>
					</table>
					
					<h4>Fasilitas</h4>
					<?php //echo $row->kos_fasilitas ?>
					<?php $i=0; $x = $fasilitas->num_rows(); foreach($fasilitas->result() as $r) : ?>
					<?php echo $r->fasilitas_name.($i == $x-1 ? '.' : ', ') ?>
					<?php $i++;endforeach; ?>
					<h4>Luas dan Jumlah Kamar</h4>
						<?php foreach($list_kamar->result() as $r) : ?>
							<?php echo $r->kamar_nama.' : '.$r->kamar_dimensi.', kapasitas '.$r->kamar_kapasitas.' orang, jumlah '.$r->kamar_jumlah.' kamar.<br>' ?>
						<?php endforeach; ?>
					<h4>Harga Kamar</h4>
						<?php foreach($list_kamar->result() as $r) : ?>
							<?php echo $r->kamar_nama.' : Rp '.$r->kamar_harga.',- /Bulan<br>' ?>
						<?php endforeach; ?>
					<h4>Persediaan Kamar</h4>
					<table border="1" cellspacing="0" cellpadding="4">
						<tr><td>Tipe Kamar</td><td>Tersedia</td><td>Harga (Rp)</td><td>Pemesanan</td></tr>
						<?php foreach($list_kamar->result() as $r) : ?>
							<tr>
								<td><?php echo $r->kamar_nama ?></td>
								<td><?php echo $r->kamar_tersedia ?></td>
								<td><?php echo $r->kamar_harga ?></td>
								<td><?php echo ($r->kamar_tersedia == 0 ? '-' : '<button class="dialog_pesan_button">Pesan Sekarang</button>') ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
					<div class="dialog_pesan_content" style="display:none" title="Form Pemesanan">
						<form method="post" action="<?php echo site_url('order/send/') ?>">
							<table border="0">
								<tr><td>nama</td><td> : <input type="text" name="nama"></td></tr>
								<tr><td>email</td><td> : <input type="text" name="email"></td></tr>
								<tr><td>hp</td><td> : <input type="text" name="hp"></td></tr>
								<tr><td>pesan</td><td> : <input type="text" name="message"></td></tr>
								<tr><td colspan="2" align="right"><input type="button" value="kirim"></td></tr>
							</table>
						</form>
					</div>
				</div>
			</div>
			
			<div class="description">
				<div class="title">Komentar</div>
				<div class="content_isi">
					<div class="content"><fb:comments url="<?php echo site_url("profile/view/".$row->kos_id); ?>" numposts="10" send_notification_uid="100002099601420" publish_feed="true" canpost="true" title="<?php echo $row->kos_nama; ?>" simple="true" data-width="480"></fb:comments></div>
				</div>
			</div>
			
		</div>
    </div>