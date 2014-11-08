<script type="text/javascript">
	$(document).ready(function(){
		$("#data-form").submit(function(){
			$.post($(this).attr("action"), $(this).serialize(), function(data) {
				$("#message-box-data").html(data);
			}); return false;
		});
	});
</script>
    <?php $row = $pemilik->row(); ?>
	<div id="content">
		<p>Selamat datang <?php echo $row->name ?> | <?php echo anchor('auth/logout', 'keluar &raquo;') ?></p>
		<div id="message-box-data"></div>
		<form method="post" id="data-form" action="<?php echo site_url('panel_process/update_data') ?>">
		<table border="0" width="100%">
			<tr>
				<td width="20%">Nama</td>
				<td width="20%">: <input type="text" name="pemilik" value="<?php echo $row->name ?>"></td>
				<td rowspan="4" valign="top">
					Kos yang anda kelola saat ini : <br />
					<?php foreach($list_kos->result() as $r) : ?>
						<?php echo anchor('panel/kos/'.$r->kos_id, $r->kos_nama).' | ' ?>
					<?php endforeach; ?>
				</td>
			</tr><tr>
				<td>Password lama</td>	<td>: <input type="password" name="old_password"></td>
			</tr><tr>
				<td>Password baru</td>	<td>: <input type="password" name="password"></td>
			</tr><tr>
				<td>Ulangi</td>		<td>: <input type="password" name="again"></td>
			</tr><tr>	
				<td colspan="2"><input type="submit" value="simpan"></td>
			</tr>
        </table>
		</form>
	<?php if($form_data) : ?></div><?php endif; ?>