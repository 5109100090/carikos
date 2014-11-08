<html>
<head>
<title>CariKos Online</title>
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-ui-1.8.14.custom.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url() ?>static/js/slider/jquery_002.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/slider/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/slider/jquery_003.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/slider/init.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/slider/easySlider1.5.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
    <script type="text/javascript" src="http://code.google.com/apis/gears/gears_init.js"></script>
	
	<link href="<?php echo base_url() ?>static/css/base.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>static/css/style_scrollpage.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/jquery-ui-1.8.14.custom.css">
	<!-- include Cycle plugin -->
	<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.cycle.all.2.74.js"></script>

<script type="text/javascript">	
	
	var infoWindow = new google.maps.InfoWindow();
	var directionsService = new google.maps.DirectionsService();
	var directionsDisplay;
	var map;
	
	var mainMarker = [];
	var markers = [];
	var htmls = [];
    var to_htmls = [];
	var from_htmls = [];
	var dista = 0;
	
	function getDirections() {
		var start = document.getElementById('saddr').value;
        var end = document.getElementById('daddr').value;

        var directionsService = new google.maps.DirectionsService();
		var directionsDisplay = new google.maps.DirectionsRenderer();
		directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('directions-panel'));
		
		var request = {
		  origin: start, 
		  destination: end,
		  travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		directionsService.route(request, function(response, status) {
		  if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);
		  }
		});
    }
	  
	function tohere(i) {
		infoWindow.setContent(to_htmls[i]);
		infoWindow.setPosition(markers[i].location);
		infoWindow.open(map);
	}
	
	function myclick(i) {
		infoWindow.setContent(htmls[i]);
		infoWindow.setPosition(markers[i].location);
		infoWindow.open(map);
	}
		
	function fromhere(i) {
		infoWindow.setContent(from_htmls[i]);
		infoWindow.setPosition(markers[i].location);
		infoWindow.open(map);
	}
		
	function generate_direction(latlng1, latlng2){
		directionsDisplay.setMap(map);
		directionsDisplay.setOptions( { suppressMarkers: true } );
		//directionsDisplay.setPanel(document.getElementById('directions_panel'));
		var request = {
			origin: latlng1, 
			destination: latlng2,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
				
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
				dista = response.routes[0].legs[0].distance.text;
			}
		});
	}
		
	function clear_map(){
		directionsDisplay.setMap(null);
		infoWindow.open(null);
	}
	$(document).ready(function(){
		 $('.slideshow').cycle({
			fx: 'fade'// choose your transition type, ex: fade, scrollUp, shuffle, etc...
		});
		 $('.slideshow2').cycle({
			fx: 'fade'// choose your transition type, ex: fade, scrollUp, shuffle, etc...
		});

		$("#login-form").submit(function(){
			$.post($(this).attr("action"), $(this).serialize(), function(data) {
				$("#message-box-login").html(data);
			}); return false;
		});
		
		$("#register-form").submit(function(){
			$.post($(this).attr("action"), $(this).serialize(), function(data) {
				$("#message-box-register").html(data);
			}); return false;
		});
		
		// initial state
		initialLocation = new google.maps.LatLng('-7.2652778', '112.7425');
		var myOptions = {
			zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: initialLocation
		};
		map = new google.maps.Map(document.getElementById("map"), myOptions);
		
		
		var base_url = '<?php echo base_url() ?>static/';
		var site_url = '<?php echo site_url() ?>';
		
		var marker = new google.maps.Marker({
            position: initialLocation,
            clickable: true,
			draggable: true,
            map: map,
			icon : base_url + 'images/template/home/tag_cari.png',
			title : 'drop me'
        });
		
		function codeLatLng(lat1, lng1) {
			var geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(lat1, lng1);
			geocoder.geocode({'latLng': latlng}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						document.getElementById("geocode_address").value = results[0].formatted_address;
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
            document.getElementById("lat").value = newLat;
            document.getElementById("lng").value = newLng;
			
			var newLatLng = new google.maps.LatLng(newLat, newLng);
			
			$.ajax({
				type: "POST",
				url: $("#search_by_map").attr('action'),
				data: $("#search_by_map").serialize(),
				dataType: 'json',
				success: function(json) {
					clearOverlays();
					if (json.Locations.length > 0) {
						for (i=0; i<json.Locations.length; i++) {
							var location = json.Locations[i];
							addLoc(map, location);
						}
					}
				}
			});
			clear_map();
			return false;
        });
        mainMarker.push(marker);
	
		function clearOverlays() {
			if (markers) {
				for (i in markers) {
					markers[i].setMap(null);
				}
			}
		}
	
		function addLoc(map, location){
			var i = markers.length;
			var point = new google.maps.LatLng(location.kos_lat, location.kos_lng);
			directionsDisplay = new google.maps.DirectionsRenderer();
			var image = 'static/images/template/home/tagkos.png';
			var marker = new google.maps.Marker({
					position: point,
					clickable: true,
					draggable: false,
					map: map,
					icon : image,
					title : location.kos_nama
				});
			
			var html = '<a class="class_map" href="' + site_url + 'profile/view/' + location.kos_id +'" target="_blank">' + location.kos_nama + '<\/a>';
			html = html + '<br>'+'Rp'+ location.min_harga +' - Rp' + location.max_harga;
			html = html + '<br>'+location.kos_alamat;
			to_htmls[i] = html + '<br>Rute: <b>Ke sini<\/b> - <a href="javascript:fromhere(' + i + ')">Dari sini<\/a>' +
			   '<br>Asal:<form action="javascript:getDirections()">' +
			   '<input type="text" SIZE=40 MAXLENGTH=40 name="saddr" id="saddr" value="" /><br>' +
			   '<INPUT value="Cari Rute" TYPE="SUBMIT"><br>' +
			   'Jalan kaki <input type="checkbox" name="walk" id="walk" /> &nbsp; Hindari jalan raya <input type="checkbox" name="highways" id="highways" />' +
			   '<input type="hidden" id="daddr" value="'+name+"@"+ point.lat() + ',' + point.lng() + 
			   '"/>';
			// The info window version with the "from here" form open
			from_htmls[i] = html + '<br>Rute: <a href="javascript:tohere(' + i + ')">Ke sini<\/a> - <b>Dari sini<\/b>' +
			   '<br>Tujuan:<form action="javascript:getDirections()">' +
			   '<input type="text" SIZE=40 MAXLENGTH=40 name="daddr" id="daddr" value="" /><br>' +
			   '<INPUT value="Cari Rute" TYPE="SUBMIT"><br>' +
			   'Jalan kaki <input type="checkbox" name="walk" id="walk" /> &nbsp; Hindari jalan raya <input type="checkbox" name="highways" id="highways" />' +
			   '<input type="hidden" id="saddr" value="'+name+"@"+ point.lat() + ',' + point.lng() +
			   '"/>';
			// The inactive version of the direction info
			var newId = (location.kos_id % 4) + 1;
			html = html + '<br><img src="'+ base_url +'images/profile/'+newId+'-1.jpg" width="140px">';
			//html = html + '<br>Rute: <a href="javascript:tohere('+i+')">Ke sini<\/a> - <a href="javascript:fromhere('+i+')">Dari sini<\/a>';

			google.maps.event.addListener(marker, "click", function() {	
				var lng1 = document.getElementById('lng').value;
				var lat1 = document.getElementById('lat').value;
				var latlng1 = new google.maps.LatLng(lat1, lng1);
				
				var lat2 = marker.getPosition().lat().toString();
				var lng2 = marker.getPosition().lng().toString();
				var latlng2 = new google.maps.LatLng(lat2, lng2);

				generate_direction(latlng1, latlng2);
				
				xc = "<br>jarak : " + dista ;
				infoWindow.setContent(html + xc);
				infoWindow.setPosition(point);
				infoWindow.open(map);
			});
			markers.push(marker);
		}
		
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
//---------------------------------------------------------------start icon home switch icon map--------------------	
		$('.nexp').addClass("nexp1");
		$('.prep').addClass("prep2");
		
		$(".nexp").click(function(){
			$(".space_hal2").animate({
			  "height": "+=40",
			  opacity:1
			}, "slow");
			
			$(".head_hal2").animate({
			  "height": "-=5%",
			  opacity:1
			}, "slow");
			
			$(".backlogin").animate({
			  "top": "-=80",
			  opacity:1
			}, "slow");
			
			$('.nexp').addClass("nexp2");
			$('.nexp').removeClass('nexp1').addClass('nexp2');
			$('.prep').addClass("prep1");
			$('.prep').removeClass('prep2').addClass('prep1');			
		});
		
		
		$(".prep").click(function(){
			$(".space_hal2").animate({
			  "height": "-=40",
			  opacity:1
			}, "slow");
			
			$(".head_hal2").animate({
			  "height": "+=5%",
			  opacity:1
			}, "slow");
			
			$(".backlogin").animate({
			  "top": "+=80",
			  opacity:1
			}, "slow");
			$('.nexp').addClass("nexp1");
			$('.nexp').removeClass('nexp2').addClass('nexp1');
			$('.prep').addClass("prep2");
			$('.prep').removeClass('prep1').addClass('prep2');			
		});
//---------------------------------------------------------------end icon home switch icon map--------------------	
//---------------------------------------------------------------start switch mode registrasi sama login--------------------			
		
		$('.loginpage').addClass("loginpage1").removeClass('loginpage2').addClass('loginpage1');
		$('.registerpage').addClass("registerpage2").removeClass('registerpage1').addClass('registerpage2');	
		$(".link_daftar").click(function(){
			$(".registerpage").animate({opacity:1}, "slow");
			$(".loginpage").animate({pacity:0}, "slow");
			$('.loginpage').addClass("loginpage2").removeClass('loginpage1').addClass('loginpage2');
			$('.registerpage').addClass("registerpage1").removeClass('registerpage2').addClass('registerpage1');		
		});
		$(".link_masuk").click(function(){
			$(".registerpage").animate({opacity:0}, "slow");
			$(".loginpage").animate({opacity:1}, "slow");
			$('.loginpage').addClass("loginpage1").removeClass('loginpage2').addClass('loginpage1');
			$('.registerpage').addClass("registerpage2").removeClass('registerpage1').addClass('registerpage2');		
		});
//---------------------------------------------------------------end switch mode registrasi sama login--------------------			
		var r=0;
		var h=0;
		$(".login_but").click(function(){
			if (r==0)
			{
				  if(h==0)
				  {
					$(this).text('Home');
					$(".layer_login_dll").animate({
					  "top": "+=100%",
					  opacity:1
					}, "slow");//login , register, dll
					$(".layer_about_dll").animate({
					  "top": "+=100%",
					  opacity:0
					}, "slow");//other dll			
					$(".container").animate({
					  "top": "+=130%", opacity:0
					}, "slow");//home
					$(".container2").animate({
					  "top": "+=800%", opacity:0
					}, "slow");	//search box
					$(".container2-1").animate({
					  "top": "+=100%"
					}, "slow");//map
					$(".other_but").animate({
					  "top": "-=500"
					}, "slow");				
					h=1;
				  }
				  r=1;
			}
			else
			{
			  if(h==1)
			  {
				$(this).text('Masuk');
					$(".layer_login_dll").animate({
					  "top": "-=100%",
					  opacity:0
					}, "slow");//login , register, dll					
					$(".layer_about_dll").animate({
					  "top": "-=100%",
					  opacity:1
					}, "slow");//other dll			
					$(".container").animate({
					  "top": "-=130%", opacity:1
					}, "slow");//home
					$(".container2").animate({
					  "top": "-=800%", opacity:1
					}, "slow");	//search box
					$(".container2-1").animate({
					  "top": "-=100%"
					}, "slow");//map
					$(".other_but").animate({
					  "top": "+=500"
					}, "slow");							
				  h=0;
			  }
			  r=0;
			}
		});
		
		$(".inputan").mouseover(function(){
				$(".mapnotif").animate({
					opacity:1
				});
		});
		$(".inputan").mouseleave(function(){
				$(".mapnotif").animate({
					opacity:0
				});
		});		
		
		var a=0;
		var b=0;
		$(".other_butt").click(function(){
			if (a==0)
			{
				  if(b==0)
				  {
					$(".layer_about_dll").animate({
					  "left": "-=100%",
					  opacity:1
					}, "slow");//login , register, dll					
					$(".container").animate({
					  "left": "-=130%"
					}, "slow");//home
					$(".container2").animate({
					  "left": "-=130%"
					}, "slow");	//search box
					$(".container2-1").animate({
					  "left": "-=100%"
					}, "slow");//map						
					b=1;
				  }
				  a=1;
			}
			else
			{
			  if(b==1)
			  {
					$(".layer_about_dll").animate({
					  "left": "+=100%",
					  opacity:0
					}, "slow");//login , register, dll					
					$(".container").animate({
					  "left": "+=130%",
					  opacity:1
					}, "slow");//home
					$(".container2").animate({
					  "left": "+=130%",
					  opacity:1
					}, "slow");	//search box
					$(".container2-1").animate({
					  "left": "+=100%",
					  opacity:1
					}, "slow");//map									
					b=0;
			  }
			  a=0;
			}
		});
		

		//---------------------------------------------------------------start switch mode about-contact-sitemap--------------------			
		
		$('.isi_about').addClass("isi_about2").removeClass('isi_about1').addClass('isi_about2');
		$('.isi_contact').addClass("isi_contact1").removeClass('isi_contact2').addClass('isi_contact1');	
		$('.isi_sitemap').addClass("isi_sitemap2").removeClass('isi_sitemap1').addClass('isi_sitemap2');	
		
		$(".tapcontact").click(function(){
			$(".isi_contact").animate({opacity:1}, "slow");
			$(".isi_sitemap").animate({opacity:0}, "slow");
			$(".isi_about").animate({opacity:0}, "slow");
			$('.isi_about').addClass("isi_about2").removeClass('isi_about1').addClass('isi_about2');
			$('.isi_contact').addClass("isi_contact1").removeClass('isi_contact2').addClass('isi_contact1');	
			$('.isi_sitemap').addClass("isi_sitemap2").removeClass('isi_sitemap1').addClass('isi_sitemap2');				
		});
		
		$(".tapsitemap").click(function(){
			$(".isi_contact").animate({opacity:0}, "slow");
			$(".isi_sitemap").animate({opacity:1}, "slow");
			$(".isi_about").animate({opacity:0}, "slow");
			$('.isi_about').addClass("isi_about2").removeClass('isi_about1').addClass('isi_about2');
			$('.isi_contact').addClass("isi_contact2").removeClass('isi_contact1').addClass('isi_contact2');	
			$('.isi_sitemap').addClass("isi_sitemap1").removeClass('isi_sitemap2').addClass('isi_sitemap1');		
		});
		
		$(".tapabout").click(function(){
			$(".isi_contact").animate({opacity:0}, "slow");
			$(".isi_sitemap").animate({opacity:0}, "slow");
			$(".isi_about").animate({opacity:1}, "slow");
			$('.isi_about').addClass("isi_about1").removeClass('isi_about2').addClass('isi_about1');
			$('.isi_contact').addClass("isi_contact2").removeClass('isi_contact1').addClass('isi_contact2');	
			$('.isi_sitemap').addClass("isi_sitemap2").removeClass('isi_sitemap1').addClass('isi_sitemap2');	
		});
//---------------------------------------------------------------endswitch mode about-contact-sitemap--------------------		
		
		$('.other_butt').addClass("other_butt1").removeClass('other_butt2').addClass('other_butt1');	
		var r=0;
		var z=0;
		$(".other_butt").click(function(){
			if (r==0)
			{
				  if(z==0)
				  {
					$('.other_butt').addClass("other_butt2").removeClass('other_butt1').addClass('other_butt2');						
					z=1;
				  }
				  r=1;
			}
			else
			{
			  if(z==1)
			  {
					$('.other_butt').addClass("other_butt1").removeClass('other_butt2').addClass('other_butt1');								
					z=0;
			  }
			  r=0;
			}
		});
	});
	
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-18930419-10', 'eamca.com');
  ga('send', 'pageview');

</script>

</head>
<body>
<div id="floatbar">
Website ini  dalam tahap pengembangan dan merupakan prototype yang digunakan untuk mengikuti kompetisi Gemastik IV 2011. Kontak: <a href="mailto:spondbob@eamca.com">spondbob [at] eamca [dot] com</a>
</div>
<div class="backlogin">
	<?php if($this->dx_auth->is_logged_in()) : ?>
	<div class="login_but"><?php echo anchor('panel', 'Panel') ?></div>
	<?php else : ?>
	<div class="login_but">Masuk</div>
	<?php endif; ?>
	<div class="other_butt"></div>
</div>


<!--<div class="other_but"></div>-->


<div class="layer_login_dll">
	<center>
		<div class="layer1">
			<div class="header11">
				<center><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>static/images/template/home/logocarikos.png"></a><center>
			</div>
			<div class="content11">
				
				<div class="switch">
					<div class="showslide">	
							<center>
								<div class="slideshow2">
									<img src="<?php echo base_url() ?>static/images/r1.png">
									<img src="<?php echo base_url() ?>static/images/r2.png">
								</div>
							</center>
					
					</div>
					<div class="loginpage">
						<center>
							<div id="message-box-login" style="color:#fff"></div>
							<form method="post" id="login-form" action="<?php echo site_url('auth/login') ?>">
								<div id="box_form_emaillogin">
									<input type="text" name="username" class="inputanlog"
									onFocus="if(this.value=='username') this.value='';" 
									onblur="if(this.value=='') this.value='username';"
									value="username" />
								</div>
								<div id="box_form_passwordlogin">
									<input type="password" name="password" class="inputanlog"
									onFocus="if(this.value=='password') this.value='';" 
									onblur="if(this.value=='') this.value='password';"
									value="password" />
								</div>
								<input type="submit" class="buttonlog" value="" />
							
							<li><a  href="#"> Lupa Password </a></li>
							<li> Belum Mempunyai Kun CariKos Online?? <a class="link_daftar" href="#">Daftar Sekarang </a></li>
							
							</form>
						</center>
					</div>
					<div class="registerpage">
					<center>
						<div id="message-box-register" style="color:#fff"></div>
							<form method="post" id="register-form" action="<?php echo site_url('auth/register') ?>">
								<div id="box_form_emaildaftar">
									<input type="text" name="email" class="inputanlog"
									onFocus="if(this.value=='email') this.value='';" 
									onblur="if(this.value=='') this.value='email';"
									value="email" />
								</div>
								<div id="box_form_pass1">
									<input type="password" name="password" class="inputanlog"
									onFocus="if(this.value=='password1') this.value='';" 
									onblur="if(this.value=='') this.value='password1';"
									value="password1" />
								</div>
								<div id="box_form_pass2">
									<input type="password" name="confirm_password" class="inputanlog"
									onFocus="if(this.value=='password2') this.value='';" 
									onblur="if(this.value=='') this.value='password2';"
									value="password2" />
								</div>
								<input type="submit" class="buttondaf" value="" />
								<li> Sudah punya Akun CariKos Online?? <a class="link_masuk" href="#"> Masuk Sekarang </a></li>
							</form>
						</center>
					</div>
				</div>
			</div>
		</div>
	</center>
</div>

<div class="layer_about_dll">
	<center>
		<div class="layer1-2">
			<div class="header12">
				<center><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>static/images/template/home/logocarikos.png"></a><center>
			</div>
			<div class="content12">
				<div class="tap_about">				
					<div class="tapcontact">Kontak kami</div>
					<div class="tapabout">Tentang kami</div>
					<div class="tapsitemap">Peta situs</div>
				</div>
				<div class="layerisi_tap">
				
					<div class="isi_about">
					<h2>Cari Kos Online</h2><br/>
					<p> Cari Kos Online merupakan situs Pencarian Tempat kos dimana tujuan kami adalah menciptakan sebuah portal situs kos kosan yang terintegrasi , sehingga bagi para pemilik kos mendapatkan keuntungan pengiklanan kos masing masing. Selain itu situs Cari kos Online juga mempermudah para pencari kosan yang umumnya adalah pelajar/mahasiswa yang setiap tahunnya selalu datang dan mencari tempat tinggal baru(kos) di dekat kampus/ tempat dimana dia berkarir.
Anda dapat mencari kos di website ini berdasdarkan kategori yang ingin anda cari atau juga bisa mencari berdasarkan wilayah yang dekat dengan daerah yang anda inginkan.
					</p>
					</div>
					<div class="isi_contact">
						<div class="boxprofil">
							<div class="_nm">
								<li>Sindung Anggar Kusuma</li>
							</div>
							<div class="photo">
								<img src="<?php echo base_url() ?>static/images/profile/sindung.png">
							</div>
							<div class="kontak">
								<li>Anggota 1</li> 
								<li>HP :(+6285790558046)</li>
								<li>Jl Semeru No.79 , Nganjuk, Jawa Timur</li>
								<li>Sindung.its@gmail.com</li>
								<li>Teknik Informatika  Institut Teknologi Sepuluh Nopember Angkatan 2009</li>
							</div>
						</div>
						<div class="boxprofil">
							<div class="_nm">
								<li>Rizky Noor Ichwan </li>
							</div>
							<div class="photo">
								<img src="<?php echo base_url() ?>static/images/profile/rizky.png">
							</div>
							<div class="kontak">
								<li>Anggota 2</li> 
								<li>HP: (+6287-8080-88051)</li> 
								<li>Jl. Batik Liris No 23-24 Perum Gama Asri, Pekalongan, Jawa Tengah</li>
								<li>kos@eamca.com</li>
								<li>Teknik Informatika Institut Teknologi Sepuluh Nopember Angkatan 2009</li>
							</div>
						</div>
						<div class="boxprofil">
							<div class="_nm">
								<li>Umi Laili Yuhana, S.Kom, M.Sc.</li>
							</div>
							<div class="photo">
								<img src="<?php echo base_url() ?>static/images/profile/buyuhana.png">
							</div>
							<div class="kontak">
								<li>Dosen Pembimbing</li> 	
								<li>NIP 	: 	132309747</li>
								<li>Kota Baru Driyorejo, Gresik</li>
								<li>Jurusan/Prodi 	: 	Teknik Informatika</li>
							</div>
						</div>	
					</div>
					<div class="isi_sitemap">
							<ul id="sitemap">
								<li><?php echo anchor('','Halaman Depan') ?></li>
								<li style="witdh:20px;"></li>	<li><?php echo anchor('','Cari Berdasarkan Kategori') ?></li>
								<li style="witdh:20px;"></li>	<li><?php echo anchor('','Cari Melalui Map') ?></li>
								<li><?php echo anchor('search/all', 'Halaman Pencarian') ?></li>
								<li><?php echo anchor('search/all','Halaman Profil Kos') ?></li>
								<li><?php echo anchor('','Tentang Kami') ?></li>
								<li><?php echo anchor('','Kontak Kami') ?></li>
								<li><?php echo anchor('','Peta Situs') ?></li>
							</ul>
					</div>
				
				</div>
				
			</div>
		</div>
	</center>
</div>

<div id="screen">	

		<div id="sections">
			<ul>
<!--start of page search_home----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			
				<li class="search_home">
					
					<div class="container"> 
						<div class="header"><center><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>static/images/template/home/logocarikos.png"></a><center></div>
						<div class="slide">
							<center>
								<div class="slideshow">
									<img src="<?php echo base_url() ?>static/images/s1.png">
									<img src="<?php echo base_url() ?>static/images/s2.png">
									<img src="<?php echo base_url() ?>static/images/s1.png">
								</div>
							</center>
						</div>
					</div><!--end container home-->
				</li>
				<!--end of page search_home-->
<!--end of page search_home----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->					
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->					
				<!--start of page search_map-->
				<li class="search_map_home">
					<div class="ground">
						
						<div class="space_hal2"></div>
						<div class="layer1" >		
							<div class="container2">
							
									<div class="search_box">
										<div class="mapnotif"></div>
										<div id="box_form">
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
													<div id="box_form_jenis_target">
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
										</div><!--end box_form-->
									</div><!--end search_box-->
							</div><!--end conainer2-->
						</div><!--end layer1-->
						<div class="layer2">
								<div class="container2-1">
									<!--<div id="layerprofile"></div>-->
									<div class="content2" >
									
										<div class="head_hal2"> 
										  <a href="#"> Cari Kos Kosan dengan mudah, cepat dan tepat</a>
											<div class="to_map">
												<div class="nexp"></div>
												<div class="prep"></div>
											</div>
										</div>
										<div class="google_map">
											<div class="goo_map" id="map" ></div>
											<div id="directions_panel"></div>
											<form id="search_by_map" method="post" action="<?php echo site_url('search/by_map'); ?>">
												<input type="hidden" name="lat" id="lat" value="-7.318881730366743">
												<input type="hidden" name="lng" id="lng" value="112.7197265625">
												<input style="margin-left:50px; border:none; font-size:16px; background:#fff;" type="text" id="geocode_address" value="Pilih lokasi" size="100" disabled>
											</form>
										</div>
									</div>
								</div>
						</div>
					</div><!--end ground-->
				</li>
<!--end of page search_map----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->					
			</ul>
		</div>
		
</div><!--end of screen-->
</body>
</html>