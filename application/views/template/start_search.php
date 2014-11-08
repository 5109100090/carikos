<!DOCTYPE html>
<html>
<head>
<title>CariKos Online</title>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.jscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-ui-1.8.14.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/style_template.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/search.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>static/css/jquery-ui-1.8.16.custom.css">
<script type="text/javascript">
	$(document).ready(function(){
		$(".scroll_search_box").jScroll({speed : "very-fast"});
		$(".scroll_search_box").jScroll({top : 0});
		$(".scroll_search_bawah").jScroll({speed : "very-fast"});
		$(".scroll_search_bawah").jScroll({top : 10});
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