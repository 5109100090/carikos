<?php $row = $detail_kos->row() ?>
<html>
<head>
<title>CariKos Online</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/style_profile.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/jquery-ui-1.8.16.custom.css">
<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA8n1NNoWYFgYv_GWU1p2c4RSuWGiLoZo0pQsY_ZKUl9WIx_UksRSmwNPugXlOCCuLIdnHq6MZ0Ohn0g"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.jscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.gmap-1.1.0-min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var addressx = document.getElementById("address").value;
		$("#map_canvas").gMap({ markers: [{ address: addressx, html: "_address" }], zoom: 16 });

		$(".scroll_search_box").jScroll({speed : "very-fast"});
		$(".scroll_search_box").jScroll({top : 0});
		$(".scroll_search_bawah").jScroll({speed : "very-fast"});
		$(".scroll_search_bawah").jScroll({top : 10});
		
		$("#reload-suggestion").submit(function(){
			var x = parseInt($("#limit_suggestion").val());
			$("#limit_suggestion").val(x + 5);
			$("#reload-suggestion-loading").fadeIn(1000);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('profile/suggestion_kos') ?>",
				data: $(this).serialize(),
				success: function(data) {
					$("#content div.main div.bar div.suggestion div.content div.viewer").html('');
					$("#content div.main div.bar div.suggestion div.content div.viewer").html(data);
				}
			});
			$("#reload-suggestion-loading").hide();
			return false;
		});
		$("#kawasan").change(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('kawasan/get_kelurahan') ?>",
				data: $(this).serialize(),
				success: function(data) {
					$("div#kelurahan").html(data);
				}
			});
			return false;
		});
		$( "#dialog_peta_button" ).click(function(){
			$( "#dialog_peta_content" ).dialog({
				draggable: false,
				resizeable: false,
				width:600,
				height:400
			});
		});
	});
</script>
</head>
<body>
<div id="fb-root"></div> 
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script> 
<script type="text/javascript"> 
FB.init({ appId: '127772973968963', status: true, cookie: true, xfbml: true });
</script>

<div class="container">
	<!--<div class="background"></div>
    <div class="background_coklat"></div>-->
    <!--<div class="panah_kanan"></div>-->
    <!--<div class="panah_kiri"></div>-->

    <!--start scroll-animation header-->
    <div class="scroll_search_box">
        <div id="search">
            <div class="content1">
				<center>
				<form method="post" action="<?php echo site_url('search/result') ?>">
				<select name="kawasan" id="kawasan" class="inputan">
					<option value="0">- Kawasan -</option>
					<?php foreach($list_kawasan->result() as $r) : ?>
					<option value="<?php echo $r->kawasan_id ?>"><?php echo $r->kawasan_nama ?></option>
					<?php endforeach; ?>
				</select>
				<div id="kelurahan" style="display:inline">
				<select id="kelurahan" name="kelurahan" class="inputan">
					<option value="0">- Kelurahan -</option>
				</select>
				</div>
				<select name="jenis" class="inputan" >
					<?php $i=0; foreach(jenis_kos() as $p) : ?>
					<option value="<?php echo $i; ?>"><?php echo $p ?></option>
					<?php $i++; endforeach; ?>
				</select>
				<select name="harga" class="inputan">
					<option value="0">- Harga -</option>
					<?php $range = 500000; for($i = $min_harga; $i < $max_harga; $i+=$range) : $x = $i+$range?>
					<option value="<?php echo $i.'-'.$x; ?>">
						<?php echo 'Rp '.number_format($i).' - Rp '.number_format($x); ?>
					</option>
					<?php endfor; ?>
				</select>
				<input type="submit" class="button" value="Cari" />
				</form>
				</center>
            </div>        
        </div>
        <div id="restore_detail"></div>
    	<div id="block_detail">
			<div class="content">
			&nbsp;
				<table border="0" align="center"><tr>
				<?php $i=0; foreach($list_fasilitas->result() as $r) : ?>
					<?php if($i%6==0 && $i!=0)  echo '</tr><tr>'; ?>
					<td><input type="checkbox" class="checkbox" name="fasilitas" value="<?php echo $r->fasilitas_id ?>" /><?php echo $r->fasilitas_name ?> &nbsp;</td>
				<?php $i++; endforeach; ?>
				</tr>
				</table>
			</div>
		</div>
    </div>
    
    <div class="scroll_search_bawah" >
    	<div class="searchleft"></div>
        <div class="searchright"></div>
    </div>
    <!--start scroll-animation header-->

    <div id="header">
        <a href="<?php echo site_url('page/main') ?>">
        <center><img src="<?php echo base_url() ?>static/images/template/home/logocarikos.png" width="300" border="0px"><center>
        </a>
    </div>
    
    <div id="content">
       <div id="space"></div>
		<div class="header">
			<div class="pp">
				<div class="title">Foto</div>
				<div class="content"><img src="<?php echo base_url().get_photo($row->kos_id, true) ?>" width="330"></div>
			</div>
			<div class="head">
				<div class="name"><h3><?php echo $row->kos_nama ?></h3></div>
				<div class="text"><?php echo $row->kos_description ?></div>
				<div id="spacephoto"></div>
				<div class="photo">
					<img src="<?php echo base_url() ?>static/images/template/home/left-gallery.png" width="20" >
					<img class="ft" src="<?php echo base_url() ?>static/images/profile/<?php echo rand(1, 2) ?>.jpg" height="90">
					<img class="ft" src="<?php echo base_url() ?>static/images/profile/<?php echo rand(2, 3) ?>.jpg" height="90">
					<img class="ft" src="<?php echo base_url() ?>static/images/profile/<?php echo rand(3, 4) ?>.jpg" height="90">
					<img src="<?php echo base_url() ?>static/images/template/home/right-gallery.png" width="20" >
				</div>
			</div>
		</div>
		
		<div class="main">
			<div class="bar">
				<div class="map">
					<div class="title">Lokasi</div>
					<div class="content">
						<div id="map_canvas" style="height:300px;width:100%"></div> 
					</div>
				</div>
				<div class="suggestion">
					<div class="title">Pilihan Lain</div>
					<div class="content">
						<div class="viewer" >
						<?php foreach($suggestion_kos->result() as $r) : ?>
							<div  class="kotak">
								<img class="foto_kcl" src="<?php echo base_url().get_photo($r->kos_id, true) ?>" width="90" style="float:left">
								<div class="deskrip" >
										<li class="nm"> <?php echo anchor('profile/view/'.$r->kos_id, $r->kos_nama)?></li>
										<li class="al"> <?php echo $r->kos_alamat?></li>
								</div><br>
							</div>
						<?php endforeach; ?>
						</div>
						<div id="reload-suggestion-loading" style="display:none">tunggu sebentar</div>
						<form id="reload-suggestion">
							<input type="hidden" name="kos_id" value="<?php echo $row->kos_id ?>">
							<input type="hidden" id="limit_suggestion" name="limit_suggestion" value="5">
							<input type="submit" value="lihat lagi">
						</form>
					</div>
				</div>
			</div>
			<div class="description">
				<div class="title">Profil</div>
				<div class="content">
					<h4>Identitas</h4>
					<table border="0">
						<tr><td>Pemilik</td><td>: <?php echo $row->pemilik_id ?></td></tr>
						<tr><td>Kawasan</td><td>: <?php echo $this->kawasan_model->get_name('kawasan', $this->kawasan_model->get_kawasan_id($row->kelurahan_id)) ?></td></tr>
						<tr><td>Kelurahan</td><td>:
							<?php echo $t = $this->kawasan_model->get_name('kelurahan', $row->kelurahan_id);
							echo '&nbsp;';
							if($t) echo "<a href='#' id='dialog_peta_button'>lihat di peta</a>" ?>
							<div id="dialog_peta_content" title="Peta Kelurahan <?php echo $t ?>" style="padding:0;display:none">
								<script type="text/javascript">
									$("#map_canvas_kelurahan").gMap({ markers: [
									<?php
										$q = $this->kos_model->get_kelurahan($row->kelurahan_id);
										$n = $q->num_rows(); $i=0;foreach($q->result() as $r) : ?>
									{ address: "<?php echo $r->kos_alamat ?>", html: "<?php echo $r->kos_nama.'<br>'.$r->kos_alamat ?>" }<?php echo($i<$n-1 ? ',' : ''); ?>
									<?php  $i++; endforeach; ?> ],
									zoom: 12 });
								</script>
								<div id="map_canvas_kelurahan" style="height:100%;width:100%"></div>
							</div>
						</td></tr>
						<tr><td>Alamat</td><td>: <?php echo $row->kos_alamat ?><input type="hidden" id="address" value="<?php echo $row->kos_alamat ?>"></td></tr>
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
								<td><?php echo ($r->kamar_tersedia == 0 ? '-' : anchor('#', 'Pesan Sekarang')) ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="comments">
				<div class="title">Komentar</div>
				<div class="content"><fb:comments url="<?php echo site_url("profile/view/".$row->kos_id); ?>" numposts="10" send_notification_uid="100002099601420" publish_feed="true" canpost="true" title="<?php echo $row->kos_nama; ?>" simple="true"></fb:comments></div>
			</div>
		</div>
        
       
    </div>
    
    <div id="footer">
        <div class="content-footer"></div>
		<div class="text">
			<?php echo anchor('page/about', 'Tentang').' &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; '.anchor('page/contact', 'Kontak').' &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; '.anchor('page/sitemap', 'Sitemap') ?>
		</div>
    </div>
</div>


<script>
	var r=0;
	var h=0;
	$("#restore_detail").click(function(){
	if (r==0)
	{
		  if(h==0)
		  {
			  $("#block_detail").animate({
				  "top": "+=80px",
				  opacity:0.95
			  }, "slow");
			  h=1;
		  }
		  r=1;
	}
	else
	{
	  if(h==1)
	  {
		  $("#block_detail").animate({
			  "top": "-=80px",
			  opacity:0
		  }, "slow");
		  h=0;
	  }
	  r=0;
  	}
	});

	//--------------panah-kanan-kiri----------------//
	var b=0;
	$("#content").mouseleave(function(){
	if(b==0)
	{
			 $(".panah_kiri").animate({
				  "top": "+=100px",
				  opacity:0.8
			  }, "slow");
			  
			  $(".panah_kanan").animate({
				  "top": "+=100px",
				  opacity:0.8
			  }, "slow");
			  b=1;
		 }
	});
	
	$("#content").mouseover(function(){
		 if(b==1)
		 {
			 $(".panah_kiri").animate({
				  "top": "-=100px",
				  opacity:0
			  }, "slow");
			  
			  $(".panah_kanan").animate({
				  "top": "-=100px",
				  opacity:0
			  }, "slow");
			  b=0;
		 }
	});
	//--------------------------------------------//
</script>

</body></html>
