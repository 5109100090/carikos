<html>
<head>
<title>CariKos Online</title>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.jscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-ui-1.8.14.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/style_search.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/jquery-ui-1.8.16.custom.css">

<script type="text/javascript">
	$(document).ready(function(){
		$(".scroll_search_box").jScroll({speed : "very-fast"});
		$(".scroll_search_box").jScroll({top : 0});
		$(".scroll_search_bawah").jScroll({speed : "very-fast"});
		$(".scroll_search_bawah").jScroll({top : 10});
		 
		$("#kawasan_form").change(function(){
			var x = $("#kawasan_form option[value='"+ $(this).val() +"']").text();
			$("#kawasan").val(x);
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
		});
		$("#jenis_form").change(function(){
			var x = $("#jenis_form option[value='"+ $(this).val() +"']").text();
			$("#jenis").val(x);
		});
		$("#harga_form").change(function(){
			var x = $("#harga_form option[value='"+ $(this).val() +"']").text();
			$("#harga").val($(this).val());
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
	});
</script>

</head>
<body>
<div class="container">
    <!--start scroll-animation header-->
    <div class="scroll_search_box">
        <div id="search">
            
			<div class="content1">
            <center>
				<form method="post" action="<?php echo site_url('search/result') ?>">
				<div id="box_form_kawasan">
					<input type="text" name="kawasan" id="kawasan" class="inputan" value="- Kawasan -" disabled>
					
					<div id="box_form_kawasan_target" style="display:none; position:absolute; margin:45px 0 0 0; width:100%">
						<select name="kawasan_form" id="kawasan_form" class="inputan" multiple>
							<?php foreach($list_kawasan->result() as $r) : ?>
							<option value="<?php echo $r->kawasan_id ?>"><?php echo $r->kawasan_nama ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div id="box_form_kelurahan">
					<input type="text" name="kelurahan" id="kelurahan" class="inputan" value="- Kelurahan -" disabled>
					<div id="box_form_kelurahan_target" style="display:none; position:absolute; margin:45px 0 0 200px; width:100%">
					<select name="kelurahan_form" id="kelurahan_form" class="inputan" multiple>
						<option value="0">- Kelurahan -</option>
					</select>
					</div>
				</div>
				<div id="box_form_jenis">
					<input type="text" name="jenis" id="jenis" class="inputan" value="- Jenis -" disabled>
					<div id="box_form_jenis_target" style="display:none; position:absolute; margin:45px 0 0 400px; width:100%">
					<select name="jenis_form" id="jenis_form" class="inputan" multiple>
						<?php $i=0; foreach(jenis_kos() as $p) : if($i != 0) :?>
						<option value="<?php echo $i; ?>"><?php echo $p ?></option>
						<?php endif; $i++; endforeach; ?>
					</select>
					</div>
				</div>
				<div id="box_form_harga">
					<input type="text" name="harga" id="harga" class="inputan" value="- Harga -" disabled>
					<div id="box_form_harga_target" style="display:none; position:absolute; margin:45px 0 0 600px; width:100%">
					<select name="harga_form" id="harga_form" class="inputan" multiple>
						<?php $range = 500000; for($i = $min_harga; $i < $max_harga; $i+=$range) : $x = $i+$range?>
						<option value="<?php echo $i.'-'.$x; ?>">
							<?php echo number_format($i).' - '.number_format($x); ?>
						</option>
						<?php endfor; ?>
					</select>
					</div>
				</div>
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
        <div id="AJAXcontent">
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
        <?php foreach($list_kos->result() as $row) : ?>
            <a href="<?php echo site_url('profile/view/'.$row->kos_id); ?>">
                <div class="box-result">
                    <div class="result-view">
                        <li class="nama_kos"> <?php echo $row->kos_nama ?></li> <br/>
                        <li class="foto"><img src="<?php echo base_url().get_photo($row->kos_id, true) ?>" height="140"></li>
                        <li class="detil" ><?php echo 'Alamat : '.$row->kos_alamat ?></li>
                        <li class="detil" ><?php echo 'Fasilitas : '.$row->kos_fasilitas ?></li><br />
                    </div>
                </div>
                
            </a>
        <?php endforeach; ?>
		<div id="AJAXmenu"><?php echo ($create_links ? $create_links : ''); ?></div>
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
