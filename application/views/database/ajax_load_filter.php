<div class="form-group">
	<div class="row">
		<div class="col-md-2">
			<select name="colomn[]" id="" class="form-control">
				<?php 
				foreach($table_header as $header):
				?>
					<option><?= $header ?></option>
				<?php 
				endforeach;
				?>
			</select>
		</div>
		<div class="col-md-1">
			<select name="operator[]" id="" class="form-control">
				<option>=</option>
				<option>!=</option>
				<option><</option>
				<option><=</option>
				<option>></option>
				<option>>=</option>
				<option>contain</option>
				<option>does not contain</option>
				<option>begin with </option>
				<option>does not with</option>
				<option>end with</option>
				<option>does not end with</option>
				<option>is null</option>
				<option>is not null</option>
			</select>
		</div>
		<div class="col-md-2">
			<input type="text" name="value[]" class="form-control">
		</div>
	</div>
</div>
<hr>	
