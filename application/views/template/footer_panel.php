    
    <div id="footer">
        <div class="content-footer"></div>
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
					  "top": "+=65px",
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
				  "top": "-=65px",
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