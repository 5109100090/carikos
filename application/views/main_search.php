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
                        <li class="foto"><img src="<?php echo get_photo($row->kos_id, true) ?>" height="140"></li>
                        <li class="detil" ><?php echo 'Rp'.number_format($row->min_harga).' - Rp'.number_format($row->max_harga) ?></li>
                        <li class="detil" ><?php echo 'Alamat : '.$row->kos_alamat ?></li>
                        <li class="detil" >Fasilitas : 
							<?php
								$f = $this->fasilitas_model->get_fasilitas($row->kos_id);
								$i = 1; $n = $f->num_rows(); $l = 4;
								foreach($f->result() as $r){
									if($i > $l) break;
									echo $r->fasilitas_name.($i != $n && $i < $l ? ', ' : '.');
									$i++;
								}
							?>
						</li><br />
                    </div>
                </div>
                
            </a>
        <?php endforeach; ?>
		<div id="AJAXmenu"><?php echo ($create_links ? $create_links : ''); ?></div>
		</div>
    </div>