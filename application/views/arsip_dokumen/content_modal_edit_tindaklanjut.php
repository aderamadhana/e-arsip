<div class="table-responsive">
	<table class="table table-bordered table-striped table-condensed" id="table-edit-tindak-lanjut">
		<thead>
			<tr>
				<th>Catatan</th>
				<th style="width:10px;">File</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if(count($list_lampiran)>0):
					foreach($list_lampiran as $index=> $lampiran):
			?>
					<tr>
						<td >
							<input type="hidden" name="adld_id[]" value="<?= $lampiran['adld_id'] ?>">
							<input type="hidden" name="id[]" value="<?= $lampiran['id'] ?>">
							<input type="hidden" name="is_delete[]" value="n" id="delete-<?= $lampiran['id'] ?>">
							<textarea readonly required class="form-control" name="adld_catatan_tindaklanjut[]"><?= $lampiran['catatan_tindaklanjut'] ?></textarea>
						</td>
						<td>
							<input accept=".pdf" type="file" name="adld_file_tindaklanjut[]">
						</td>
						<td>
							<?php 
							if($index==0):
							?>
								<button type="button" onclick="addRowEdit('table-edit-tindak-lanjut')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
							<?php 
							else:
							?>
								<button type="button" onclick='$("#delete-<?=$lampiran['id'] ?>").val("y").change();$(this).closest("tr").hide();' class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
							<?php 
							endif;
							?>

						</td>
					</tr>
			<?php 
				endforeach;
			else:
			?>
				<tr>
					<td >
						<input type="hidden" name="adld_id[]" value="<?= $adld_id ?>">
						<input name="id[]" value="" type="hidden">
						<input type="hidden" name="is_delete[]" value="n">
						<textarea required class="form-control" name="adld_catatan_tindaklanjut[]"></textarea>
					</td>
					<td>
						<input type="file" accept=".pdf" name="adld_file_tindaklanjut[]">
					</td>
					<td>
						<button type="button" onclick="addRowEdit('table-edit-tindak-lanjut')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
					</td>
				</tr>	
			<?php 
			endif;
			?>
		</tbody>
		
	</table>
</div> 