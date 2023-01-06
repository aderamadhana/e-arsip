<?php 
	dump_variable($_POST);
?>
<table class="table table-bordered table-hover" id="table-playground">
	<thead>
			<tr class="info">
				<?php 
				foreach($table_header as $header):
				?>
					<th><?= $header ?></th>
				<?php 
				endforeach;
				?>
			</tr>
	</thead>
	<tbody>
		<?php 
		foreach($data_table as $dt):
		?>
			<tr>
				<?php 
				foreach($table_header as $header):
				?>
					<td><?= $dt[$header] ?></td>
				<?php 
				endforeach;
				?>
			</tr>
		<?php 
		endforeach;
		?>
	</tbody>
</table>

<script>
	$("#table-playground").DataTable()
</script>