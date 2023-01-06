<div class="pull-right">
	<button class="btn btn-primary btn-flat btn-filtered hide"><i class="fa fa-filter"></i> Filter</button>
</div>
<div class="form-group">
	<button type="button" class="btn btn-flat btn-filter"><i class="fa fa-plus"></i> Tambah Filter</button>
</div>

<div id="filter">	
</div>

<div class="table-responsive" id="div-playground">
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
</div>

<script>
	$("#table-playground").DataTable()

	$(".btn-filter").click(function(){
		$(".btn-filtered").removeClass('hide')
		var nama_table = '<?= $nama_table ?>'
		$.get('<?= base_url("Database/ajaxLoadFilter?table=") ?>'+nama_table,function(e){
			$("#filter").append(e)
		})
	})

	$(".btn-filtered").click(function(){
		var nama_table = '<?= $nama_table ?>'
		var colomn = $("select[name='colomn[]']").val()
		var operator = $("select[name='operator[]']").val()
		var value = $("input[name='value[]']").val()

		alert(colomn)
		$.post('<?= base_url("Database/ajaxLoadTable?table=") ?>'+nama_table,{test:'test',colomn:colomn,operator:operator,value:value},function(e){
			$("#div-playground").html('<i class="fa fa-load fa-spinner"> Loading</i>').html(e)
		})	
	})
</script>