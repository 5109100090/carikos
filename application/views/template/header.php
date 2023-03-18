<body>
<div id="floatbar">
Website ini dalam tahap pengembangan dan merupakan prototype yang digunakan untuk mengikuti kompetisi Gemastik IV 2011. Kontak: <a href="mailto:spondbob@eamca.com">spondbob [at] eamca [dot] com</a>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#kawasan_form").change(function(){
			var x = $("#kawasan_form option[value='"+ $(this).val() +"']").text();
			$("#kawasan").val(x);
			$("#display_kawasan").text(x);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('kawasan/get_kelurahan') ?>",
				data: $(this).serialize(),
				success: function(data) {
					$("div#box_form_kelurahan").html(data);
				}
			});
			return false;
		});
		$("#kelurahan_form").change(function(){
			var x = $("#kelurahan_form option[value='"+ $(this).val() +"']").text();
			$("#kelurahan").val(x);
			$("#display_kelurahan").text(x);
		});
		$("#jenis_form").change(function(){
			var x = $("#jenis_form option[value='"+ $(this).val() +"']").text();
			$("#jenis").val(x);
			$("#display_jenis").text(x);
		});
		$("#harga_form").change(function(){
			var x = $("#harga_form option[value='"+ $(this).val() +"']").text();
			$("#harga").val($(this).val());
			$("#display_harga").text(x);
		});
		
		$("#box_form_kawasan").click(function(){
			$("#box_form_kawasan_target").slideToggle();
		});
		$("#box_form_kelurahan").click(function(){
			$("#box_form_kelurahan_target").slideToggle();
		});
		$("#box_form_jenis").click(function(){
			$("#box_form_jenis_target").slideToggle();
		});
		$("#box_form_harga").click(function(){
			$("#box_form_harga_target").slideToggle();
		});
		
		$("#kawasan").change(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('kawasan/get_kelurahan2') ?>",
				data: $(this).serialize(),
				success: function(data) {
					$("div#box_kelurahan").html(data);
				}
			});
			return false;
		});
	});
</script>
<div class="container">
	<div class="background"></div>
    <div class="background_coklat"></div>
   <!-- <div class="panah_kanan"></div>
    <div class="panah_kiri"></div>

    <!--start scroll-animation header-->
    <div class="scroll_search_box">
        <div id="search">
			<div class="spacebox"></div>
			<div class="content1">
			
            <center>
				<form method="post" action="<?php echo site_url('search/result') ?>">
				<div id="box_form_kawasan">
					<div id="display_kawasan" class="inputan" style="width:180px">- Kawasan -</div>
					<div id="box_form_kawasan_target">
					<select name="kawasan_form" id="kawasan_form" class="inputan1" multiple>
						<?php foreach($list_kawasan->result() as $r) : ?>
						<option value="<?php echo $r->kawasan_id ?>"><?php echo $r->kawasan_nama ?></option>
						<?php endforeach; ?>
					</select>
					</div>
				</div>
				<div id="box_form_kelurahan">
					<input type="hidden" name="kelurahan" id="kelurahan" value="">
					<div id="display_kelurahan" class="inputan" style="width:180px">- Kelurahan -</div>
					<div id="box_form_kelurahan_target">
					<select name="kelurahan_form" id="kelurahan_form" class="inputan1" multiple>
						<option value="0">- Kelurahan -</option>
					</select>
					</div>
				</div>
				<div id="box_form_jenis">
					<input type="hidden" name="jenis" id="jenis" value="">
					<div id="display_jenis" class="inputan" style="width:180px">- Jenis -</div>
					<div id="box_form_jenis_target"">
					<select name="jenis_form" id="jenis_form" class="inputan1" multiple>
						<?php $i=0; foreach(jenis_kos() as $p) : if($i != 0) :?>
						<option value="<?php echo $i; ?>"><?php echo $p ?></option>
						<?php endif; $i++; endforeach; ?>
					</select>
					</div>
				</div>
				<div id="box_form_harga">
					<input type="hidden" name="harga" id="harga" value="">
					<div id="display_harga" class="inputan" style="width:180px">- Harga -</div>
					<div id="box_form_harga_target">
					<select name="harga_form" id="harga_form" class="inputan1" multiple>
						<?php $range = 500000; for($i = $min_harga; $i < $max_harga; $i+=$range) : $x = $i+$range?>
						<option value="<?php echo $i.'-'.$x; ?>">
							<?php echo number_format($i).' - '.number_format($x); ?>
						</option>
						<?php endfor; ?>
					</select>
					</div>
				</div>
				<input type="submit" class="button" value=" " />
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
    
    <!--<div class="scroll_search_bawah" >
    	<div class="searchleft"></div>
        <div class="searchright"></div>
    </div>
    <!--start scroll-animation header-->

    <div id="header">
        <a href="<?php echo base_url() ?>">
       <center><img src="https://raw.githubusercontent.com/itsnotrisky/carikos-static/gh-pages/images/template/home/logocarikos.png" width="300" border="0px"><center>
        </a>
    </div>