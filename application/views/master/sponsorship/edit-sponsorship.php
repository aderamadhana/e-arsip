<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Sponsorship
			<small>Master</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">master</a></li>
			<li class="active">Sponsorship</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<form method="POST" action="<?= base_url('master/Sponsorship/update') ?>" id="upload-create" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?= $sponsorship['id'] ?>">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel">
						<div class="panel-body">
							<div role="tabpanel">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#1" aria-controls="awal" role="tab" data-toggle="tab" style="color:#000">Kegiatan</a>
									</li>
									<li role="presentation">
										<a href="#2" aria-controls="kategori-lingkup" role="tab" style="color:#000" data-toggle="tab">Kategori & Lingkup</a>
									</li>
									<li role="presentation">
										<a href="#3" aria-controls="pemberi-sponsor" role="tab" style="color:#000" data-toggle="tab">Pemberi Sponsor</a>
									</li>
									<li role="presentation">
										<a href="#4" aria-controls="keuntungan" role="tab" style="color:#000" data-toggle="tab">Keuntungan</a>
									</li>
									<li role="presentation">
										<a href="#5" aria-controls="keterangan" role="tab" style="color:#000" data-toggle="tab">Keterangan</a>
									</li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="1">
										<table class="table table-bordered table-condensed table-custom">
											<tbody>
												<tr style="background: #ddd;">
													<td colspan="4"><b>Kegiatan</b></td>
												</tr>
												<tr>
													<td style="width:10%">Nama Acara / Kegiatan</td>
													<td style="width:40%">
														<input type="text" class="form-control" id="form-nama_kegiatan" placeholder="Masukan Nama kegiatan" name="dt[nama_kegiatan]" value="<?= $sponsorship['nama_kegiatan'] ?>">
														<small class="text-danger">* Inputkan sesuai nama acara</small>
													</td>
													<td style="width:10%">Tanggal Acara / Kegiatan</td>
													<td style="width:40%">
														<input type="text" class="form-control tgl" id="form-tanggal" placeholder="Masukan Tanggal" name="dt[tanggal]" value="<?= $sponsorship['tanggal'] ?>">
													</td>
												</tr>
												<tr>
													<td style="width:10%">Gambaran Umum Acara</td>
													<td colspan="3">
														<textarea name="dt[tentang_acara]" class="form-control"><?= $sponsorship['tentang_acara'] ?></textarea>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Permohonan Nilai Sponsor</td>
													<td colspan="3">
														<input type="text" class="form-control input-sm money" name="dt[permohonan_nilai_sponsor]" value="<?= $sponsorship['permohonan_nilai_sponsor'] ?>" id="">
													</td>
												</tr>


												<tr>
													<td style="width:10%">Peserta </td>
													<td colspan="3">
														<select name="dt[peserta]" class="form-control select2" onchange="changePeserta()" id="peserta">
															<option value="Umum" <?= ($sponsorship['peserta'] == "Umum") ? "selected" : "" ?>>Umum</option>
															<option value="Mahasiswa" <?= ($sponsorship['peserta'] == "Mahasiswa") ? "selected" : "" ?>>Mahasiswa</option>
															<option value="Tamu atau Undangan" <?= ($sponsorship['peserta'] == "Tamu atau Undangan") ? "selected" : "" ?>>Tamu atau Undangan</option>
														</select>
														<br>
														<table class="table table-condensed table-hover table-bordered" id="table-tamu-undangan">
															<thead>
																<tr style="background: #f3f3f3;">
																	<th>Informasi Tambahan</th>
																	<th style="width: 25px"><button type="button" class="btn btn-success btn-xs" onclick="addRowTamuUndangan()"><i class="fa fa-plus"></i></button></th>
																</tr>
															</thead>
															<tbody>
																<?php foreach (json_decode($sponsorship['peserta_detail']) as $key => $value) { ?>
																	<tr>
																		<td>
																			<input type="text" class="form-control" name="peserta_detail[]" value="<?= $value ?>">
																		</td>
																		<td>
																			<a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
																		</td>

																	</tr>
																<?php } ?>
															</tbody>
														</table>
														<script>
															function changePeserta() {
																let peserta = $('#peserta').val();

																if (peserta == 'Tamu atau Undangan') {
																	$('#table-tamu-undangan').removeClass('hide');
																} else {
																	$('#table-tamu-undangan tbody').empty();
																	$('#table-tamu-undangan').addClass('hide');
																}
															}
															changePeserta();

															function addRowTamuUndangan() {
																let html = `<tr>
																<td>
																	<input type="text" class="form-control" name="peserta_detail[]">
																</td>
																<td>
																	<a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
																</td>

															</tr>`;
																$('#table-tamu-undangan').append(html);
															}
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Jumlah Peserta</td>
													<td colspan="3">
														<select name="dt[jumlah_peserta]" class="form-control select2">
															<option value="Kurang dari 500" <?= ($sponsorship['jumlah_peserta'] == "Kurang dari 500") ? "selected" : "" ?>>Kurang dari 500</option>
															<option value="500 sampai 1000" <?= ($sponsorship['jumlah_peserta'] == "500 sampai 1000") ? "selected" : "" ?>>500 sampai 1000</option>
															<option value="Lebih dari 1000" <?= ($sponsorship['jumlah_peserta'] == "Lebih dari 1000") ? "selected" : "" ?>>Lebih dari 1000</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lokasi Kegiatan</td>
													<td colspan="3">
														<textarea name="dt[lokasi_kegiatan]" class="form-control"><?= $sponsorship['lokasi_kegiatan'] ?></textarea>
														<small>*) mohon tuliskan lokasi kegiatan dilaksanakan</small>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Range Usia</td>
													<td colspan="3">
														<select name="dt[rage_usia]" class="form-control select2">
															<option value="Dibawah 20" <?= ($sponsorship['rage_usia'] == "Dibawah 20") ? "selected" : "" ?>>Dibawah 20</option>
															<option value="20 - 40" <?= ($sponsorship['rage_usia'] == "20 - 40") ? "selected" : "" ?>>20 - 40</option>
															<option value="Lebih dari 40" <?= ($sponsorship['rage_usia'] == "Lebih dari 40") ? "selected" : "" ?>>Lebih dari 40</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Gender</td>
													<td colspan="3">
														<select name="dt[gender]" class="form-control select2">
															<option value="Laki - Laki" <?= ($sponsorship['gender'] == "Laki - Laki") ? "selected" : "" ?>>Laki - Laki</option>
															<option value="Perempuan" <?= ($sponsorship['gender'] == "Perempuan") ? "selected" : "" ?>>Perempuan</option>
															<option value="Mix" <?= ($sponsorship['gender'] == "Mix") ? "selected" : "" ?>>Mix</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Konsep Acara</td>
													<td colspan="3">
														<?php
														$media = json_decode($sponsorship['media']);
														?>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="konsep_acara[]" id="live" value="live" class="form-check-input" onclick="checkKonsepAcara(this)" <?= (in_array('live', json_decode($sponsorship['konsep_acara']))) ? "checked" : "" ?> /> Live/on air
															</label>
															<input type="text" class="form-control <?= (!in_array('live', json_decode($sponsorship['konsep_acara']))) ? "hide" : "" ?>" name="media[]" placeholder="Media Platform" id="for-live" value="<?= @$media[0] ?>">
														</div>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="konsep_acara[]" id="tapping" value="tapping" class="form-check-input" onclick="checkKonsepAcara(this)" <?= (in_array('tapping', json_decode($sponsorship['konsep_acara']))) ? "checked" : "" ?> /> Tapping/off air
															</label>
															<input type="text" class="form-control <?= (!in_array('tapping', json_decode($sponsorship['konsep_acara']))) ? "hide" : "" ?>" name="media[]" placeholder="Media Platform" id="for-tapping" value="<?= @$media[1] ?>">
														</div>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="konsep_acara[]" id="private" value="private" class="form-check-input" onclick="checkKonsepAcara(this)" <?= (in_array('private', json_decode($sponsorship['konsep_acara']))) ? "checked" : "" ?> /> Private
															</label>
															<div id="for-private" class="<?= (!in_array('live', json_decode($sponsorship['konsep_acara']))) ? "hide" : "" ?>">

																<select name="media[]" class="form-control hide select2" style="width: 100%;">
																	<option value="Musyawarah" <?= (@$media[2] == 'Musyawarah') ? "selected" : "" ?>>Musyawarah</option>
																	<option value="Rapat Kerja" <?= (@$media[2] == 'Rapat Kerja') ? "selected" : "" ?>>Rapat Kerja</option>
																	<option value="Workshop" <?= (@$media[2] == 'Workshop') ? "selected" : "" ?>>Workshop</option>
																</select>
															</div>
														</div>
														<?php
														$konsepacara = json_decode($sponsorship['konsep_acara']);
														?>
														<script>
															function checkKonsepAcara(checkboxid) {
																if ($('#' + checkboxid).is(':checked')) {
																	$('#for-' + checkboxid).removeClass('hide');
																} else {
																	$('#for-' + checkboxid).addClass('hide');
																}

															}
															<?php foreach ($konsepacara as $key => &$value) { ?>
																checkKonsepAcara('<?= $value ?>');
															<?php } ?>
														</script>



													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="informasi-kegiatan"></div>


									<div role="tabpanel" class="tab-pane" id="2">
										<table class="table table-bordered table-condensed table-custom">

											<tbody>
												<tr style="background:#ddd">
													<th colspan="4">Kategori Lingkup</th>
												</tr>
												<tr>
													<td style="width:10%">Klasifikasi Kegiatan</td>
													<td colspan="3">
														<?php $klasifikasi = $this->mymodel->selectWhere('klasifikasi', null); ?>
														<select name="dt[klasifikasi_id]" class="form-control select2" id="form-klasifikasi_id" style="width:100%" onchange="checkklasifikasi()">
															<?php
															$klasifikasi = $this->mymodel->selectWhere('klasifikasi', null);
															foreach ($klasifikasi as $klasifikasi_record) {
																if ($sponsorship['klasifikasi_id'] == $klasifikasi_record['id']) {
																	echo "<option value=" . $klasifikasi_record['id'] . " selected>" . $klasifikasi_record['klasifikasi'] . "</option>";
																} else {
																	echo "<option value=" . $klasifikasi_record['id'] . ">" . $klasifikasi_record['klasifikasi'] . "</option>";
																}
															}
															?>
															<option value="0" <?php if ($sponsorship['klasifikasi_id'] == 0) echo "selected" ?>>Lainnya</option>
														</select>
														<input type="text" name="dt[klasifikasi_nama]" class="form-control" id="form-klasifikasi_nama" value="<?= $sponsorship['klasifikasi_nama'] ?>">
														<script>
															function checkklasifikasi() {
																let klasifikasi = $("#form-klasifikasi_id").val();
																if (klasifikasi == 0) $("#form-klasifikasi_nama").show();
																else $("#form-klasifikasi_nama").hide();
															}

															checkklasifikasi()
														</script>
														<script>
															function checkklasifikasi() {
																let klasifikasi = $("#form-klasifikasi_id").val();
																if (klasifikasi == 0) $("#form-klasifikasi_nama").show();
																else $("#form-klasifikasi_nama").hide();
															}

															checkklasifikasi();
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lingkup Kegiatan</td>
													<td colspan="3">
														<select name="dt[lingkup_id]" id="form-lingkup_id" class="form-control select2" style="width:100%" onchange="checklingkup()">
															<?php
															$lingkup = $this->mymodel->selectWhere('lingkup', null);
															foreach ($lingkup as $lingkup_record) {
																if ($sponsorship['lingkup_id'] == $lingkup_record['id']) {
																	echo "<option value=" . $lingkup_record['id'] . " selected>" . $lingkup_record['lingkup'] . "</option>";
																} else {
																	echo "<option value=" . $lingkup_record['id'] . ">" . $lingkup_record['lingkup'] . "</option>";
																}
															}
															?>
															<option value="0" <?php if ($sponsorship['lingkup_id'] == 0) echo "selected" ?>>Lainnya</option>
														</select>
														<input type="text" name="dt[lingkup_nama]" class="form-control" id="form-lingkup_nama" value="<?= $sponsorship['lingkup_nama'] ?>">
														<script>
															function checklingkup() {
																let lingkup = $("#form-lingkup_id").val();
																if (lingkup == 0) $("#form-lingkup_nama").show();
																else $("#form-lingkup_nama").hide();
															}

															checklingkup()
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Pic Sponsorship</td>
													<td colspan="3">
														<select name="pic[]" class="form-control select2" style="width:100%" multiple="multiple">
															<?php
															$pic = json_decode($sponsorship['pic']);
															$user = $this->mymodel->selectWhere('user', ['departemen' => 2]);
															foreach ($user as $user_record) {
																if (in_array($user_record['id'], $pic)) {
																	echo "<option value=" . $user_record['id'] . " selected>" . $user_record['name'] . "</option>";
																} else {
																	echo "<option value=" . $user_record['id'] . ">" . $user_record['name'] . "</option>";
																}
															}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lembaga/Organisasi Pengaju Sponsorship</td>
													<td>
														<input type="text" name="dt[lembaga_pengaju]" class="form-control" placeholder="Masukkan Lembaga/Organisasi Pengaju Sponsorship" value="<?= $sponsorship['lembaga_pengaju'] ?>">
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div role="tabpanel" class="tab-pane" id="3">
										<table class="table table-bordered table-condensed table-custom">
											<tbody>
												<tr style="background:#ddd">
													<th colspan="4">Pemberi Sponsor</th>
												</tr>
												<tr>
													<td style="width:10%">Unit Kerja Pengusul Sponsor</td>
													<td colspan="3">
														<?php
														$unitdata = json_decode($sponsorship['data_unit'], true);
														// print_r($unitdata['sharing']);
														?>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="unit_kerja[]" id="individu" value="individu" class="form-check-input" onclick="checkUnitKerja(this.value)" <?= (in_array('individu', json_decode($sponsorship['unit_kerja']))) ? "checked" : "" ?> /> Individu
															</label>
															<div id="for-individu" class="hide">
																<select name="individu_kantor_id" class="form-control select2" style="width: 100%;">
																	<?php
																	$kantor = $this->mymodel->selectWhere('kantor', null);
																	foreach ($kantor as $kantor_record) {
																		if ($kantor_record['id'] == $unitdata['individu']) {
																			echo '<option value="' . $kantor_record['id'] . '" selected>' . $kantor_record['kantor'] . '</option>';
																		} else {
																			echo '<option value="' . $kantor_record['id'] . '">' . $kantor_record['kantor'] . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="unit_kerja[]" id="sharing" value="sharing" class="form-check-input" onclick="checkUnitKerja(this.value)" <?= (in_array('sharing', json_decode($sponsorship['unit_kerja']))) ? "checked" : "" ?> /> Sharing
															</label>
															<div id="for-sharing" class="hide">
																<select name="sharing_kantor_id[]" class="form-control select2" style="width: 100%;" multiple="multiple">
																	<?php
																	$kantor = $this->mymodel->selectWhere('kantor', null);
																	foreach ($kantor as $kantor_record) {
																		if (in_array($kantor_record['id'], $unitdata['sharing'])) {
																			echo '<option value="' . $kantor_record['id'] . '" selected>' . $kantor_record['kantor'] . '</option>';
																		} else {
																			echo '<option value="' . $kantor_record['id'] . '">' . $kantor_record['kantor'] . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
														</div>
														<?php
														$unitkerja = json_decode($sponsorship['unit_kerja']);
														?>
														<script>
															function checkUnitKerja(checkbox_this) {
																if ($('#' + checkbox_this).is(':checked')) {
																	$('#for-' + checkbox_this).removeClass('hide');
																} else {
																	$('#for-' + checkbox_this).addClass('hide');
																}
															}
															<?php foreach ($unitkerja as $key => &$valunit) { ?>
																checkUnitKerja('<?= $valunit ?>');
															<?php } ?>
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lingkup Kerjasama/Keuntungan</td>
													<td colspan="3">
														<textarea name="dt[lingkup_kerjasama]" class="form-control" rows="10"><?= $sponsorship['lingkup_kerjasama'] ?></textarea>
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div role="tabpanel" class="tab-pane" id="4">
										<?php
										$keuntungan_id = json_decode($sponsorship['keuntungan_id']);
										$keuntungan = $this->mymodel->selectWhere('keuntungan', null);
										foreach ($keuntungan_id as $k) {
											if (!is_numeric($k)) $text = $k;
										}
										?>
										<table class="table table-bordered table-condensed table-custom">

											<tbody>
												<tr style="background:#ddd">
													<th colspan="4">Keuntungan</th>
												</tr>
												<tr>
													<td style="width:10%">Keuntungan</td>
													<td colspan="3">
														<div class="row">
															<?php foreach ($keuntungan as $key => $value) { ?>
																<div class="form-check col-xs-3">
																	<label class="form-check-label">
																		<input type="checkbox" name="keuntungan_id[]" id="" <?php if ($value['keuntungan'] == 'Lain-Lain' && $text) echo "checked" ?> <?php if (in_array($value['id'], $keuntungan_id)) echo "checked" ?> value="<?= $value['id'] ?>">
																		<?= $value['keuntungan'] ?>
																		<?php if ($value['keuntungan'] == 'Lain-Lain') { ?>
																			<input type="text" class="form-control input-sm" name="keuntungan_id[]" id="txt-keuntungan-lain" data-role="tagsinput" value="<?= $text ?>" style="width: 100%;">
																			<small style="color: red;">Jika keuntungan lebih dari 1 pisahkan menggunakan , (koma)</small>
																		<?php } ?>
																	</label>
																</div>
															<?php } ?>
														</div>
														<script>
															$("#txt-keuntungan-lain").tagsinput('items');
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Dokumen Laporan Pertanggungjawaban</td>
													<td colspan="3">
														<table class="table table-condensed table-bordered table-hover">
															<thead>
																<tr style="background: #f3f3f3;">
																	<th>Nama Dokumen</th>
																	<th>File</th>
																	<th style="width: 25px"><button type="button" class="btn btn-success btn-xs" onclick="addrow()"><i class="fa fa-plus"></i></button></th>
																</tr>
															</thead>
															<tbody id="body-files">
																<?php
																foreach (json_decode($sponsorship['files']) as $files) {
																?>
																	<tr>
																		<td><?= $files->name ?>
																			<input type="hidden" name="nama_files_old[]" value="<?= $files->name ?>" id="">
																			<input type="hidden" name="files_old[]" value="<?= $files->dir ?>" id="">
																		</td>
																		<td><a href="<?= base_url($files->dir) ?>" target="_blank"><?= $files->dir ?></a></td>
																		<td>
																			<a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
																		</td>
																	</tr>
																<?php
																}
																?>
															</tbody>
														</table>

													</td>
												</tr>
												<tr>
													<td style="width:10%">Logo</td>
													<td colspan="3">
														<div class="row">
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" <?= (in_array('Sponsor Tunggal / Tittling Name', json_decode($sponsorship['keuntungan_logo']))) ? "checked" : "" ?> value="Sponsor Tunggal / Tittling Name" class="form-check-input" /> Sponsor Tunggal / Tittling Name
																</label>
															</div>
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" <?= (in_array('Main Sponsor', json_decode($sponsorship['keuntungan_logo']))) ? "checked" : "" ?> value="Main Sponsor" class="form-check-input" /> Main Sponsor
																</label>
															</div>
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" <?= (in_array('Sponsor Bersama', json_decode($sponsorship['keuntungan_logo']))) ? "checked" : "" ?> value="Sponsor Bersama" class="form-check-input" /> Sponsor Bersama
																</label>
															</div>
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" <?= (in_array('Minor Sponsor', json_decode($sponsorship['keuntungan_logo']))) ? "checked" : "" ?> value="Minor Sponsor" class="form-check-input" /> Minor Sponsor
																</label>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Ukuran Logo</td>
													<td colspan="3">
														<select name="dt[ukuran_logo]" class="form-control hide select2" style="width: 100%;">
															<option value="Besar" <?= ($sponsorship['ukuran_logo'] == 'Besar') ? "selected" : "" ?>>Besar</option>
															<option value="Sedang" <?= ($sponsorship['ukuran_logo'] == 'Sedang') ? "selected" : "" ?>>Sedang</option>
															<option value="Kecil" <?= ($sponsorship['ukuran_logo'] == 'Kecil') ? "selected" : "" ?>>Kecil</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Jumlah Logo</td>
													<td colspan="3">
														<select name="dt[jumlah_logo]" class="form-control hide select2" style="width: 100%;">
															<option value="Banyak" <?= ($sponsorship['ukuran_logo'] == 'Banyak') ? "selected" : "" ?>>Banyak</option>
															<option value="Sedang" <?= ($sponsorship['ukuran_logo'] == 'Sedang') ? "selected" : "" ?>>Sedang</option>
															<option value="Sedikit" <?= ($sponsorship['ukuran_logo'] == 'Sedikit') ? "selected" : "" ?>>Sedikit</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Benefit/Pemasaran Produk BRI</td>
													<td colspan="3">
														<input type="radio" name="dt[benefit_produk]" value="Ya" onchange="changeBenefitProduk()" <?= ($sponsorship['benefit_produk'] == 'Ya') ? "checked" : "" ?> /> Ya
														<input type="radio" name="dt[benefit_produk]" value="Tidak" onchange="changeBenefitProduk()" <?= ($sponsorship['benefit_produk'] == 'Tidak') ? "checked" : "" ?> /> Tidak
														<br>
														<textarea name="dt[keterangan_benefit_produk]" class="form-control" rows="5" id="keterangan_benefit_produk" style="<?= ($sponsorship['benefit_produk'] == 'Tidak') ? "display: none;" : "" ?>"><?= $sponsorship['keterangan_benefit_produk'] ?></textarea>
														<script>
															function changeBenefitProduk() {
																if ($("input[name='dt[benefit_produk]']:checked").val() == 'Ya') $("#keterangan_benefit_produk").show();
																else $("#keterangan_benefit_produk").hide().val('');
															}
															changeBenefitProduk();
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Pertimbangan Sponsor/Bantuan Dana</td>
													<td colspan="3">
														<textarea name="dt[pertimbangan_sponsor]" class="form-control" id="" rows="10"><?= $sponsorship['pertimbangan_sponsor'] ?></textarea>
													</td>
												</tr>
											</tbody>
										</table>
										<script>
											function addrow() {
												let rows = `
                                  <tr>
                                    <td>
                                      <input type="text" class="form-control input-sm" name="nama_files[]">
                                    </td>
                                    <td>
                                      <input type="file" name="files[]">
                                    </td>
                                    <td>
                                       <a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
                                    </td>
                                  </tr>
                                  `;
												$("#body-files").append(rows)
											}
										</script>
									</div>

									<div role="tabpanel" class="tab-pane" id="5">
										<table class="table table-bordered table-condensed table-custom">

											<tbody>
												<tr style="background:#ddd">
													<th colspan="6">Keterangan</th>
												</tr>
												<tr>
													<td style="width:10%">Tanggal Realisasi</td>
													<td colspan="5">
														<input type="text" class="form-control tgl" name="dt[tanggal_realisasi]" id="txt-tgl-realisasi" onchange="getbreakdown()" value="<?= $sponsorship['total_realisasi'] ?>" />
														<script type="text/javascript">
															function getbreakdown() {
																var tanggal = $('#txt-tgl-realisasi').val();
																$.ajax({
																	url: '<?= base_url('master/Master_breakdown/getbreakdown') ?>',
																	type: 'post',
																	dataType: 'json',
																	data: {
																		tanggal: tanggal
																	},
																	success: function(response) {
																		$('#txt-total-realisasi').val(response.total_realisasi);
																		$('#txt-sisa-anggaran').val(response.sisa_anggaran);
																	}
																});
															}
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Nilai Sponsor Disetujui (Komitmen)</td>
													<td style="width: 30%;">
														<input type="text" class="form-control input-sm money" name="dt[nilai_sponsor]" id="txt-total-nilai" onchange="checknilaisponsor()" value="<?= $sponsorship['nilai_sponsor'] ?>" />
														<script type="text/javascript">
															function checknilaisponsor() {
																var total_realisasi = $('#txt-total-realisasi').val();
																var nilai_sponsor = $('#txt-total-nilai').val();
																if (nilai_sponsor > total_realisasi) {
																	alert("Nilai Sponsor Disetujui melebihi total realisasi");
																	$('.btn-send').hide();
																} else {
																	$('.btn-send').show();
																}
															}
														</script>
													</td>
													<td style="width:10%">Total Realisasi</td>
													<td style="width: 20%;">
														<input type="text" class="form-control input-sm money" name="dt[total_realisasi]" id="txt-total-realisasi" readonly value="<?= $sponsorship['total_realisasi'] ?>" />
													</td>
													<td style="width:10%">Sisa Anggaran</td>
													<td style="width: 20%;">
														<input type="text" class="form-control input-sm money" name="dt[sisa_anggaran]" id="txt-sisa-anggaran" readonly value="<?= $sponsorship['sisa_anggaran'] ?>" />
													</td>
												</tr>
												<tr>
													<td style="width:10%">Nilai Sponsor Termasuk Pajak ?</td>
													<td colspan="5">
														<input type="radio" name="dt[is_sponsor]" value="1" id="" <?= ($sponsorship['is_sponsor'] == 1) ? 'checked' : '' ?>> Ya
														<input type="radio" name="dt[is_sponsor]" value="0" id="" <?= ($sponsorship['is_sponsor'] == 0) ? 'checked' : '' ?>> Tidak
													</td>
												</tr>
												<tr>
													<td style="width:10%">Termin Pembayaran</td>
													<td colspan="5">
														<select class="form-control" name="dt[termin_pembayaran]" id="sel-termin-pembayaran" onchange="changeInfoPembayaran()">
															<option value="" selected="" disabled="">Pilih Termin</option>
															<?php for ($i = 1; $i <= 10; $i++) { ?>
																<option value="<?= $i ?>" <?= ($sponsorship['termin_pembayaran'] == $i) ? "selected" : "" ?>><?= $i ?></option>
															<?php } ?>

														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Informasi Pembayaran</td>
													<td colspan="5">
														<input type="radio" name="dt[informasi_pembayaran]" value="Sudah Bayar" onchange="changeInfoPembayaran()" <?= ($sponsorship['informasi_pembayaran'] == 'Sudah Bayar') ? "checked" : "" ?> /> Sudah Bayar
														<input type="radio" name="dt[informasi_pembayaran]" value="Belum Bayar" onchange="changeInfoPembayaran()" <?= ($sponsorship['informasi_pembayaran'] == 'Belum Bayar') ? "checked" : "" ?> /> Belum Bayar
														<script>
															function changeInfoPembayaran() {
																if ($("input[name='dt[informasi_pembayaran]']:checked").val() == 'Sudah Bayar') {
																	getsetinformasitemrin();
																	$("#keterangan_belum_bayar").hide().val('');
																} else if ($("input[name='dt[informasi_pembayaran]']:checked").val() == 'Belum Bayar') {
																	$(".keterangan_informasi_pembayaran").hide();
																	$("#keterangan_belum_bayar").show();
																} else {
																	$(".keterangan_informasi_pembayaran").hide();
																	$("#keterangan_belum_bayar").hide();
																}

															}
															changeInfoPembayaran();
														</script>
													</td>
												</tr>
												<tr id="keterangan_belum_bayar" style="display: none;">
													<td style="width:10%">Catatan</td>
													<td colspan="5">
														<textarea name="dt[catatan_belum_bayar]" class="form-control" id="" rows="10"><?= $sponsorship['catatan_belum_bayar'] ?></textarea>
													</td>
												</tr>
												<?php
												$tanggal_transfer = json_decode($sponsorship['tanggal_transfer'], true);
												$nominal_transfer = json_decode($sponsorship['nominal_transfer'], true);
												$bukti_transfer = json_decode($sponsorship['bukti_transfer'], true);
												?>

												<?php
												$no = 0;
												for ($i = 1; $i <= 10; $i++) { ?>
													<tr id="keterangan_informasi_pembayaran<?= $i ?>" style="display: none;" class="keterangan_informasi_pembayaran">
														<td style="width:10%">Tanggal Realisasi (Termin <?= $i ?>)</td>
														<td style="width: 20%">
															<input type="text" class="form-control tgl" name="tanggal_transfer[]" id="" value="<?= $tanggal_transfer[$no] ?>" />
														</td>
														<td style="width:10%">Nominal Transfer (Termin <?= $i ?>)</td>
														<td style="width: 30%">
															<input type="text" class="form-control money" name="nominal_transfer[]" id="" value="<?= $nominal_transfer[$no] ?>" />
														</td>
														<td style="width:10%">Bukti Transfer (Termin <?= $i ?>)</td>
														<td style="width: 20%">
															<input type="file" class="form-control" name="bukti_transfer<?= $i ?>" id="" />
															<?php if ($bukti_transfer[$no]) { ?>
																<a href="<?= base_url($bukti_transfer[$no]) ?>" target="_blank" class="btn btn-warning btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Unduh</a>
															<?php } ?>
														</td>
													</tr>
												<?php $no++;
												} ?>
												<tr>
													<td style="width:10%">Sharing Dana</td>
													<td colspan="5">
														<input type="radio" name="dt[is_sharing_dana]" value="1" onchange="changesharing()" <?= ($sponsorship['is_sharing_dana'] == 1) ? 'checked' : '' ?>> Ya
														<input type="radio" name="dt[is_sharing_dana]" value="0" onchange="changesharing()" <?= ($sponsorship['is_sharing_dana'] == 0) ? 'checked' : '' ?>> Tidak
														<br>
														<?php
														$datasharing = json_decode($sponsorship['sharing']);
														?>
														<table class="table table-condensed table-hover table-bordered" id="table-sharing">
															<thead>
																<tr style="background: #f3f3f3;">
																	<th>Kantor Wilayah/Divisi</th>
																	<th width="30%">Persentase</th>
																	<th width="30%">Nominal</th>
																	<th style="width: 25px"><button type="button" class="btn btn-success btn-xs" onclick="addrowstable()"><i class="fa fa-plus"></i></button></th>
																</tr>
															</thead>
															<tbody id="body-sharing">
																<?php foreach ($datasharing as $key => &$valdatasharing) { ?>
																	<tr>
																		<td>
																			<input type="text" class="form-control input-sm" name="kantor[]" id="" value="<?= $valdatasharing->kantor ?>">
																		</td>
																		<td>
																			<input type="number" class="form-control input-sm" name="presentase[]" id="" value="<?= $valdatasharing->presentase ?>">
																		</td>
																		<td>
																			<input type="text" class="form-control input-sm" name="nominal[]" id="" value="<?= $valdatasharing->nominal ?>">
																		</td>
																		<td>
																			<a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Kegiatan Terlaksana?</td>
													<td colspan="5">
														<input type="radio" name="dt[is_kegiatan_terlaksana]" value="1" id="" <?= ($sponsorship['is_kegiatan_terlaksana'] == 1) ? 'checked' : '' ?>> Ya
														<input type="radio" name="dt[is_kegiatan_terlaksana]" value="0" id="" <?= ($sponsorship['is_kegiatan_terlaksana'] == 0) ? 'checked' : '' ?>> Tidak
													</td>
												</tr>
												<tr>
													<td style="width:10%">Catatan Kegiatan</td>
													<td colspan="5">
														<textarea name="dt[catatan_kegiatan]" class="form-control" id="" rows="10"><?= $sponsorship['catatan_kegiatan'] ?></textarea>
														<small class="text-danger">Catatan Kegiatan, diisi apabila: 1. Kegiatan tidak terlaksana. 2. Kegiatan terdapat hasil memuaskan</small>
													</td>
												</tr>
												<tr>
													<td style="width:10%">PIC Pelaksana</td>
													<td colspan="5">
														<input type="text" class="form-control" name="dt[pic_terlaksana]" id="" value="<?= $sponsorship['pic_terlaksana'] ?>">
													</td>
												</tr>
												<tr>
													<td style="width:10%">No Kontak Pelaksana</td>
													<td colspan="5">
														<input type="text" class="form-control" name="dt[nomor_kontak_pelaksana]" id="" value="<?= $sponsorship['nomor_kontak_pelaksana'] ?>">
													</td>
												</tr>
												<tr>
													<td style="width:10%">Alamat Pelaksana</td>
													<td colspan="5">
														<input type="text" class="form-control" name="dt[alamat_pelaksana]" id="" value="<?= $sponsorship['alamat_pelaksana'] ?>">
													</td>
												</tr>
											</tbody>
										</table>
										<script>
											function getsetinformasitemrin() {
												$('.keterangan_informasi_pembayaran').hide();
												var termin = $('#sel-termin-pembayaran').val();
												for (var i = 1; i <= termin; i++) {
													$('#keterangan_informasi_pembayaran' + i).show();
												}
											}
											changeInfoPembayaran();
										</script>
									</div>
								</div>
							</div>
							<a href="<?= base_url('master/Sponsorship') ?>" class="btn btn-default">
								<< Kembali Ke Sponsorship </a>
									<div class="pull-right">
										<!-- <button type="submit" name="dt[cv_status]" value="draft" type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Draft</button> -->
										<input type="hidden" name="tab_index">
										<button type="submit" class="btn btn-primary btn-sm">SIMPAN SPONSORSHIP</button>
									</div>
									<!-- /.box -->
									<!-- /.box -->
						</div>
					</div>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</form>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
	tinymce.remove();
	tinymce.init({
		selector: '.tinymce',
		plugins: "localautosave",
		toolbar1: "localautosave",
		las_seconds: 15,
		las_nVersions: 15,
		las_keyName: "LocalAutoSave",
		las_callback: function() {
			var content = this.content; //content saved
			var time = this.time; //time on save action
		}
	});

	// $("#upload-create").submit(function(){
	// 		var form = $(this);
	// 	var mydata = new FormData(this);
	// 	$.ajax({
	// 				type: "POST",
	// 			url: form.attr("action"),
	// 			data: mydata,
	// 			cache: false,
	// 			contentType: false,
	// 			processData: false,
	// 			beforeSend : function(){
	// 						$(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
	// 					form.find(".show_error").slideUp().html("");
	// 			},
	// 			success: function(response, textStatus, xhr) {

	// 						// alert(mydata);
	// 				 var str = response;
	// 					if (str.indexOf("success") != -1){
	// 								Swal.fire({
	// 										title: "It works!",
	// 										text: "Successfully added data",
	// 										icon: "success"
	// 								});
	// 								// form.find(".show_error").hide().html(response).slideDown("fast");
	// 							setTimeout(function(){ 
	// 									 window.location.href = "<?= base_url('master/Sponsorship') ?>";
	// 							}, 1000);
	// 							$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
	// 					}else{
	// 							Swal.fire({
	// 								title: "Oppss!",
	// 								html: str,
	// 								icon: "error"
	// 							});
	// 								// form.find(".show_error").hide().html(response).slideDown("fast");
	// 							$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

	// 					}
	// 			},
	// 			error: function(xhr, textStatus, errorThrown) {
	// 					console.log(xhr);
	// 					Swal.fire({
	// 							title: "Oppss!",
	// 							text: xhr,
	// 							icon: "error"
	// 					});
	// 					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
	// 					// form.find(".show_error").hide().html(xhr).slideDown("fast");
	// 			}
	// 	});
	// 	return false;

	// });
	$(function() {
		// here we are looking for our tab header
		hash = window.location.hash;
		elements = $('a[href="' + hash + '"]');
		if (elements.length === 0) {
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
		} else {
			elements.click();
		}
		$("input[name='tab_index']").val(hash).change()
	});
</script>
<script>
	function changesharing() {
		if ($("input[name='dt[is_sharing_dana]']:checked").val() == 1) $("#table-sharing").show();
		else $("#table-sharing").hide();
	}

	function addrowstable() {
		$('.money').simpleMoneyFormat();
		let rows = `
				<tr>
				<td>
					<input type="text" class="form-control input-sm" name="kantor[]" id="">
				</td>
				<td>
					<input type="number" class="form-control input-sm" name="presentase[]" id="">
				</td>
				<td>
					<input type="text" class="form-control input-sm money" name="nominal[]" id="">
				</td>
				<td>
					<a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				`;
		$("#body-sharing").append(rows);
		$('.money').simpleMoneyFormat();
	}
	changesharing();
</script>