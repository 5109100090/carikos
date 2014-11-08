<!DOCTYPE html>
<html>
<head>
<title>CariKos Online</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/style_template.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/profile.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/jquery-ui-1.8.16.custom.css">
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.jscroll.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type="text/javascript" src="http://code.google.com/apis/gears/gears_init.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var lat = document.getElementById("kos_lat").value;
		var lng = document.getElementById("kos_lng").value;
		var infoWindow = new google.maps.InfoWindow();
		var myOptions = {
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		initialLocation = new google.maps.LatLng(lat, lng);
        map.setCenter(initialLocation);
		
		var base_url = '<?php echo base_url() ?>static/';
		var mainMarker = [];
        var marker = new google.maps.Marker({
            position: initialLocation,
            map: map,
			icon : base_url+'images/template/home/tagkos.png'
        });

        mainMarker.push(marker);
		
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
		$( ".dialog_pesan_button" ).click(function(){
			$( ".dialog_pesan_content" ).dialog({
				draggable: false,
				resizeable: false,
				width:350,
				height:250
			});
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