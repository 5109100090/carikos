<html>
<head>
<title>CariKos Online</title>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.jscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-ui-1.8.14.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/style_home.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/jquery-ui-1.8.14.custom.css">

<!-- include Cycle plugin -->
<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.2.74.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/sitemapstyler.js"></script>
<link href="<?php echo base_url() ?>static/css/sitemapstyler.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
	
	
	$(document).ready(function(){
		$(function() {
			$('#ajax-loading').ajaxStart(function(){
				$(this).fadeIn();
			}).ajaxStop(function(){
				$(this).hide();
			});
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
		
		var r=0;
		var h=0;		
		$(".login_button").click(function(){
				if (r==0)
				{
					  if(h==0)
					  {
						  $(".back_head").animate({
							  "top": "+=100px"
						  }, "slow");

						  $(".back_head_drop").animate({
							  "top": "+=100px"
						  }, "slow");
						  
						  $(".header_log").animate({
							  "top": "+=80px"
						  }, "slow");
						  
						  $(".content_log").animate({
							  "top": "+=80px",
							  opacity:1
						  }, "slow");
						  
						  $("#main").animate({
							  "z-index": "0","top": "+=80px",
							  opacity:0
						  }, "slow");
						  h=1;
					  }
					  r=1;
				}
				else
				{
				  if(h==1)
				  {
						$(".back_head_drop").animate({
							  "top": "-=100px"
						  }, "slow");
				  
						$(".back_head").animate({
							  "top": "-=100px"
						  }, "slow");
						$(".header_log").animate({
							  "top": "-=80px"
						  }, "slow");
					    $(".content_log").animate({
							  "top": "-=80px",
							  opacity:0
						  }, "slow");
					    $("#main").animate({
							  "z-index": "100","top": "-=80px",
							  opacity:1
						  }, "slow");
					  h=0;
				  }
				  r=0;
				}
		});
	});
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('.gallery').cycle({
		fx: 'fade'// choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});

    $('.slides').cycle({
		fx: 'scrollLeft'// choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
</head>
<body>

<!--<div class="back_head"></div>
<div class="back_head_drop"></div>-->
<div class="login_button"> Daftar </div>
<div id="main">
	<div class="header_logo"></div>
	<div id="content">
		<div id="kotak_slider">
			<div style="text-align:left">
<ul id="sitemap">
	<li><?php echo anchor('', 'Halaman Depan') ?></li>
	<li><?php echo anchor('search/all', 'Halaman Pencarian') ?></li>
	<li><?php echo anchor('page/sitemap', 'Sitemap') ?></li>
	<li><?php echo anchor('page/about', 'Tentang CariKos') ?></li>
	<li><?php echo anchor('page/contact', 'Kontak') ?></li>
</ul>
			</div>
		</div>
		
		<div id="kotak_form">
			<div id="box-search">
				
				<div id="box_form">
					<form method="post" action="<?php echo site_url('search/result') ?>">
						<select name="jenis" class="inputan" >
							<option value="0">- Jenis -</option>
							<option value="1">Pria</option>
							<option value="2">Wanita</option>
							<option value="3">Pria dan Wanita</option>
						</select>
						<select name="kawasan" id="kawasan" class="inputan">
							<option value="0">- Kawasan -</option>
							<?php foreach($list_kawasan->result() as $r) : ?>
							<option value="<?php echo $r->kawasan_id ?>"><?php echo $r->kawasan_nama ?></option>
							<?php endforeach; ?>
						</select>
						<div id="kelurahan">
						<select name="kelurahan" class="inputan">
							<option value="0">- Kelurahan -</option>
						</select>
						</div>
						<select name="harga" class="inputan">
							<option value="0">- Harga -</option>
						<?php $range = 500000; for($i = $min_harga; $i < $max_harga; $i+=$range) : $x = $i+$range?>
							<option value="<?php echo $i.'-'.$x; ?>">
								<?php echo 'Rp '.number_format($i).' - Rp '.number_format($x); ?>
							</option>
						<?php endfor; ?>
						</select>
						<input type="submit" id="button" value="Cari">
						<?php //echo anchor('search/all', 'Lihat daftar kos terbaru') ?>
				</div>
				
			</div>
		</div>
	</div>
</div>

<div id="footer">
	<h4> Cari Kos-Kosan tebaik untuk anda dengan mudah, tepat, dan cepat !!!- </h4>
</div>

<div class="login_page" >
	<div class="header_log" ><center><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>static/images/template/home/logocarikos.png" height="160"  border:none; ></a><center></div>
	<div class="content_log" >
		<div class="slides">
			<img  id="gambar" src="<?php echo base_url() ?>static/images/1.gif" style="position:absolute; " alt="h1" />
			<img  id="gambar" src="<?php echo base_url() ?>static/images/2.gif" style="position:absolute; " alt="h1" />
		</div>
		<div class="forms"></div>
	</div>
</div>


<script type="text/javascript">
	var t;
	var int = self.setInterval("mode_ukuran()",20);
	function mode_ukuran(){
		t = $("#content").css("height");
		t=t.replace("px","");
		
		if ( t <= 490 )
		{   //landscape mode
			$('#kotak_slider').addClass("kotak_slider2");
			$('#kotak_slider').removeClass('kotak_slider1').addClass('kotak_slider2');
			
			$('#kotak_form').addClass("kotak_form2");
			$('#kotak_form').removeClass('kotak_form1').addClass('kotak_form2');
			
			$('#slide').addClass("slide2");
			$('#slide').removeClass('slide1').addClass('slide2');
			
			$('#box-search').addClass("box-search2");
			$('#box-search').removeClass('box-search1').addClass('box-search2');
			
			$('.inputan').addClass("inputan2");
			$('.inputan').removeClass('inputan1').addClass('inputan2');
			
			$('#button').addClass("button2");
			$('#button').removeClass('button1').addClass('button2');
			
			$('.gallery').addClass("gallery2");
			$('.gallery').removeClass('gallery1').addClass('gallery2');

			$('.kotak_slide').addClass("kotak_slide2");
			$('.kotak_slide').removeClass('kotak_slide1').addClass('kotak_slide2');

			//$('#gambar').addClass("gambar2");
			//$('#gambar').removeClass('gambar1').addClass('gambar2');				
			
		}
		else
			{	//potrait mode
				$('#kotak_slider').removeClass('kotak_slider2').addClass('kotak_slider1');
				$('#kotak_form').removeClass('kotak_form2').addClass('kotak_form1');
				$('#slide').removeClass('slide2').addClass('slide1');
				$('#box-search').removeClass('box-search2').addClass('box-search1');
				$('.inputan').removeClass('inputan2').addClass('inputan1');
				$('#button').removeClass('button2').addClass('button1');
				$('.gallery').removeClass('gallery2').addClass('gallery1');
				$('.kotak_slide').removeClass('kotak_slide2').addClass('kotak_slide1');
				//$('#gambar').removeClass('gambar2').addClass('gambar1');
			}
	}
	
</script>


</body>
</html>