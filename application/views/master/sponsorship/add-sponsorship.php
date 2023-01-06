<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>
<style>
	.mg-5 {
		margin-left: -5px !important;
		margin-right: -5px !important;
	}

	.mg-5>.col-md-3,
	.mg-5>.col-md-9 {
		padding-left: 5px !important;
		padding-right: 5px !important;
	}

	.table-custom {
		margin-bottom: 0px;
	}

	.table-custom>tbody>tr>td,
	.table-custom>tbody>tr>th {
		border: 1px solid #7d7d7d;
		vertical-align: middle;
	}

	.table-custom>tbody+tbody {
		border: none;
	}

	.tab-content {
		border: 1px solid #ddd;
		border-top: none;
		padding: 10px;
	}

	.nav-tabs {
		background: #efefef;
		border-radius: 4px 4px 0 0;
		border-bottom: none;
	}

	.nav-tabs>li>a {
		color: #333;
	}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Sponsorship
			<small>Master</small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<a href="#"><i class="fa fa-dashboard"></i> Home</a>
			</li>
			<li><a href="#">master</a></li>
			<li class="active">Sponsorship</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<form method="POST" action="<?= base_url('master/Sponsorship/store') ?>" id="upload-create" enctype="multipart/form-data">
					<div class="panel">
						<div class="panel-body">
							<div role="tabpanel">
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
														<input type="text" class="form-control" id="form-nama_kegiatan" placeholder="Masukan Nama kegiatan" name="dt[nama_kegiatan]" />
														<small class="text-danger">* Inputkan sesuai nama acara</small>
													</td>
													<td style="width:10%">Tanggal Acara / Kegiatan</td>
													<td style="width:40%">
														<input type="text" class="form-control tgl" id="form-tanggal" placeholder="Masukan Tanggal" name="dt[tanggal]" value="<?= date('Y-m-d') ?>" />
													</td>
												</tr>
												<tr>
													<td style="width:10%">Gambaran Umum Acara</td>
													<td colspan="3">
														<textarea name="dt[tentang_acara]" class="form-control"></textarea>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Permohonan Nilai Sponsor</td>
													<td colspan="3">
														<input type="text" class="form-control input-sm money" name="dt[permohonan_nilai_sponsor]" id="" />
													</td>
												</tr>

												<tr>
													<td style="width:10%">Peserta </td>
													<td colspan="3">
														<select name="dt[peserta]" class="form-control select2" onchange="changePeserta()" id="peserta">
															<option value="Umum">Umum</option>
															<option value="Mahasiswa">Mahasiswa</option>
															<option value="Tamu atau Undangan">Tamu atau Undangan</option>
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
															<option value="Kurang dari 500">Kurang dari 500</option>
															<option value="500 sampai 1000">500 sampai 1000</option>
															<option value="Lebih dari 1000">Lebih dari 1000</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lokasi Kegiatan</td>
													<td colspan="3">
														<textarea name="dt[lokasi_kegiatan]" class="form-control"></textarea>
														<small>*) mohon tuliskan lokasi kegiatan dilaksanakan</small>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Range Usia</td>
													<td colspan="3">
														<select name="dt[rage_usia]" class="form-control select2">
															<option value="Dibawah 20">Dibawah 20</option>
															<option value="20 - 40">20 - 40</option>
															<option value="Lebih dari 40">Lebih dari 40</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Gender</td>
													<td colspan="3">
														<select name="dt[gender]" class="form-control select2">
															<option value="Laki - Laki">Laki - Laki</option>
															<option value="Perempuan">Perempuan</option>
															<option value="Mix">Mix</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Konsep Acara</td>
													<td colspan="3">
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="konsep_acara[]" id="live" value="live" class="form-check-input" onclick="checkKonsepAcara(this)" /> Live/on air
															</label>
															<input type="text" class="form-control hide" name="media[]" placeholder="Media Platform" id="for-live">
														</div>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="konsep_acara[]" id="tapping" value="tapping" class="form-check-input" onclick="checkKonsepAcara(this)" /> Tapping/off air
															</label>
															<input type="text" class="form-control hide" name="media[]" placeholder="Media Platform" id="for-tapping">
														</div>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="konsep_acara[]" id="private" value="private" class="form-check-input" onclick="checkKonsepAcara(this)" /> Private
															</label>
															<div id="for-private" class="hide">

																<select name="media[]" class="form-control hide select2" style="width: 100%;">
																	<option value="Musyawarah">Musyawarah</option>
																	<option value="Rapat Kerja">Rapat Kerja</option>
																	<option value="Workshop">Workshop</option>
																</select>
															</div>
														</div>
														<script>
															function checkKonsepAcara(checkbox_this) {
																if ($(checkbox_this).is(':checked')) {
																	$('#for-' + checkbox_this.id).removeClass('hide');
																} else {
																	$('#for-' + checkbox_this.id).addClass('hide');
																}

															}
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
														<select name="dt[klasifikasi_id]" class="form-control select2" id="form-klasifikasi_id" style="width: 100%;" onchange="checkklasifikasi()">
															<?php
															foreach ($klasifikasi as $klasifikasi_record) {
																echo "<option value=" . $klasifikasi_record['id'] . ">" . $klasifikasi_record['klasifikasi'] . "</option>";
															}
															?>
															<option value="0">Lainnya</option>
														</select>
														<input type="text" name="dt[klasifikasi_nama]" class="form-control" id="form-klasifikasi_nama" />
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
														<select name="dt[lingkup_id]" id="form-lingkup_id" class="form-control select2" style="width: 100%;" onchange="checklingkup()">
															<?php
															$lingkup = $this->mymodel->selectWhere('lingkup', null);
															foreach ($lingkup as $lingkup_record) {
																echo "<option value=" . $lingkup_record['id'] . ">" . $lingkup_record['lingkup'] . "</option>";
															}
															?>
															<option value="0">Lainnya</option>
														</select>
														<input type="text" name="dt[lingkup_nama]" class="form-control" id="form-lingkup_nama" />
														<script>
															function checklingkup() {
																let lingkup = $("#form-lingkup_id").val();
																if (lingkup == 0) $("#form-lingkup_nama").show();
																else $("#form-lingkup_nama").hide();
															}

															checklingkup();
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Pic Sponsorship</td>
													<td colspan="3">
														<select name="pic[]" class="form-control select2" style="width: 100%;" multiple="multiple">
															<?php
															$user = $this->mymodel->selectWhere('user', ['departemen' => 2]);
															foreach ($user as $user_record) {
																echo "<option value=" . $user_record['id'] . ">" . $user_record['name'] . "</option>";
															} ?>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lembaga/Organisasi Pengaju Sponsorship</td>
													<td>
														<input type="text" name="dt[lembaga_pengaju]" class="form-control" placeholder="Masukkan Lembaga/Organisasi Pengaju Sponsorship">
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
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="unit_kerja[]" id="individu" value="individu" class="form-check-input" onclick="checkUnitKerja(this)" /> Individu
															</label>
															<div id="for-individu" class="hide">
																<select name="individu_kantor_id" class="form-control select2" style="width: 100%;">
																	<?php
																	$kantor = $this->mymodel->selectWhere('kantor', null);
																	foreach ($kantor as $kantor_record) {
																		echo "
																	<option value=" . $kantor_record['id'] . ">" . $kantor_record['kantor'] . "</option>
																	";
																	} ?>
																</select>
															</div>
														</div>
														<div class="form-check">
															<label class="form-check-label">
																<input type="checkbox" name="unit_kerja[]" id="sharing" value="sharing" class="form-check-input" onclick="checkUnitKerja(this)" /> Sharing
															</label>
															<div id="for-sharing" class="hide">
																<select name="sharing_kantor_id[]" class="form-control select2" style="width: 100%;" multiple="multiple">
																	<?php
																	$kantor = $this->mymodel->selectWhere('kantor', null);
																	foreach ($kantor as $kantor_record) {
																		echo "
																	<option value=" . $kantor_record['id'] . ">" . $kantor_record['kantor'] . "</option>
																	";
																	} ?>
																</select>
															</div>
														</div>
														<script>
															function checkUnitKerja(checkbox_this) {
																if ($(checkbox_this).is(':checked')) {
																	$('#for-' + checkbox_this.id).removeClass('hide');
																} else {
																	$('#for-' + checkbox_this.id).addClass('hide');
																}

															}
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Lingkup Kerjasama/Keuntungan</td>
													<td colspan="3">
														<textarea name="dt[lingkup_kerjasama]" class="form-control" rows="10"></textarea>
													</td>
												</tr>



											</tbody>
										</table>
									</div>

									<div role="tabpanel" class="tab-pane" id="4">
										<?php $keuntungan = $this->mymodel->selectWhere('keuntungan', null); ?>
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
																		<input type="checkbox" name="keuntungan_id[]" id="" value="<?= $value['id'] ?>" class="form-check-input" />
																		<?= $value['keuntungan'] ?>
																		<?php if ($value['keuntungan'] == 'Lain-Lain') { ?>
																			<input type="text" class="form-control input-sm" name="keuntungan_id[]" id="txt-keuntungan-lain" data-role="tagsinput" style="width: 100%;" />
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
															<tbody id="body-files"></tbody>
														</table>

													</td>
												</tr>





												<tr>
													<td style="width:10%">Logo</td>
													<td colspan="3">
														<div class="row">
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" id="" value="Sponsor Tunggal / Tittling Name" class="form-check-input" /> Sponsor Tunggal / Tittling Name
																</label>
															</div>
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" id="" value="Main Sponsor" class="form-check-input" /> Main Sponsor
																</label>
															</div>
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" id="" value="Sponsor Bersama" class="form-check-input" /> Sponsor Bersama
																</label>
															</div>
															<div class="form-check col-xs-3">
																<label class="form-check-label">
																	<input type="checkbox" name="keuntungan_logo[]" id="" value="Minor Sponsor" class="form-check-input" /> Minor Sponsor
																</label>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Ukuran Logo</td>
													<td colspan="3">
														<select name="dt[ukuran_logo]" class="form-control hide select2" style="width: 100%;">
															<option value="Besar">Besar</option>
															<option value="Sedang">Sedang</option>
															<option value="Kecil">Kecil</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Jumlah Logo</td>
													<td colspan="3">
														<select name="dt[jumlah_logo]" class="form-control hide select2" style="width: 100%;">
															<option value="Banyak">Banyak</option>
															<option value="Sedang">Sedang</option>
															<option value="Sedikit">Sedikit</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Benefit/Pemasaran Produk BRI</td>
													<td colspan="3">
														<input type="radio" name="dt[benefit_produk]" value="Ya" onchange="changeBenefitProduk()" /> Ya
														<input type="radio" name="dt[benefit_produk]" value="Tidak" onchange="changeBenefitProduk()" /> Tidak
														<br>
														<textarea name="dt[keterangan_benefit_produk]" class="form-control" rows="5" id="keterangan_benefit_produk" style="display: none;"></textarea>
														<script>
															function changeBenefitProduk() {
																if ($("input[name='dt[benefit_produk]']:checked").val() == 'Ya') $("#keterangan_benefit_produk").show();
																else $("#keterangan_benefit_produk").hide().val('');
															}
														</script>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Pertimbangan Sponsor/Bantuan Dana</td>
													<td colspan="3">
														<textarea name="dt[pertimbangan_sponsor]" class="form-control" id="" rows="10"></textarea>
													</td>
												</tr>
											</tbody>
										</table>
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
														<input type="text" class="form-control tgl" name="dt[tanggal_realisasi]" id="txt-tgl-realisasi" onchange="getbreakdown()" />
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
														<input type="text" class="form-control input-sm money" name="dt[nilai_sponsor]" id="txt-total-nilai" onchange="checknilaisponsor()" />
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
														<input type="text" class="form-control input-sm money" name="dt[total_realisasi]" id="txt-total-realisasi" readonly />
													</td>
													<td style="width:10%">Sisa Anggaran</td>
													<td style="width: 20%;">
														<input type="text" class="form-control input-sm money" name="dt[sisa_anggaran]" id="txt-sisa-anggaran" readonly />
													</td>
												</tr>
												<tr>
													<td style="width:10%">Nilai Sponsor Termasuk Pajak ?</td>
													<td colspan="5">
														<input type="radio" name="dt[is_sponsor]" value="1" id="" /> Ya
														<input type="radio" name="dt[is_sponsor]" value="0" id="" /> Tidak
													</td>
												</tr>
												<tr>
													<td style="width:10%">Termin Pembayaran</td>
													<td colspan="5">
														<select class="form-control" name="dt[termin_pembayaran]" id="sel-termin-pembayaran" onchange="changeInfoPembayaran()">
															<option value="" selected="" disabled="">Pilih Termin</option>
															<?php for ($i = 1; $i <= 10; $i++) { ?>
																<option value="<?= $i ?>"><?= $i ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Informasi Pembayaran</td>
													<td colspan="5">
														<input type="radio" name="dt[informasi_pembayaran]" value="Sudah Bayar" onchange="changeInfoPembayaran()" /> Sudah Bayar
														<input type="radio" name="dt[informasi_pembayaran]" value="Belum Bayar" onchange="changeInfoPembayaran()" /> Belum Bayar
														<script>
															function changeInfoPembayaran() {
																if ($("input[name='dt[informasi_pembayaran]']:checked").val() == 'Sudah Bayar') {
																	getsetinformasitemrin();
																	$("#keterangan_belum_bayar").hide().val('');
																} else if ($("input[name='dt[informasi_pembayaran]']:checked").val() == 'Belum Bayar') {
																	$(".keterangan_informasi_pembayaran").hide().val('');
																	$("#keterangan_belum_bayar").show();
																}
															}
														</script>
													</td>
												</tr>
												<tr id="keterangan_belum_bayar" style="display: none">
													<td style="width:10%">Catatan</td>
													<td colspan="5">
														<textarea name="dt[catatan_belum_bayar]" class="form-control" id="" rows="10"></textarea>
													</td>
												</tr>

												<?php for ($i = 1; $i <= 10; $i++) { ?>
													<tr id="keterangan_informasi_pembayaran<?= $i ?>" class="keterangan_informasi_pembayaran" style="display: none">
														<td style="width:10%">Tanggal Realisasi (Termin <?= $i ?>)</td>
														<td style="width: 20%">
															<input type="text" class="form-control tgl" name="tanggal_transfer[]" id="" />
														</td>
														<td style="width:10%">Nominal Transfer (Termin <?= $i ?>)</td>
														<td style="width: 30%">
															<input type="text" class="form-control money" name="nominal_transfer[]" id="txt-nominal<?= $i ?>" onchange="ceknominaltrasfer()" />
														</td>
														<td style="width:10%">Bukti Transfer (Termin <?= $i ?>)</td>
														<td style="width: 20%">
															<input type="file" class="form-control" name="bukti_transfer<?= $i ?>" id="" />
														</td>
													</tr>
												<?php } ?>
												<script type="text/javascript">
													function ceknominaltrasfer() {
														var totalnilai = parseFloat($('#txt-total-nilai').val().replace(/,/g, ""));
														var arraynominal = [];
														let sum = 0;
														for (var i = 1; i <= 10; i++) {
															if ($('#txt-nominal' + i).val()) {
																arraynominal.push(parseFloat($('#txt-nominal' + i).val().replace(/,/g, "")));
															}
														}

														for (var i = 0; i < arraynominal.length; i++) {
															sum += arraynominal[i];
														}
														console.log(arraynominal);

														// alert(sum);

														if (sum > totalnilai) {
															alert("Total nilai Nominal transfer melebihi Nilai sponsor disetujui");
															$('.btn-send').hide();
														} else {
															$('.btn-send').show();
														}
													}
												</script>
												<tr>
													<td style="width:10%">Sharing Dana</td>
													<td colspan="5">
														<input type="radio" name="dt[is_sharing_dana]" value="1" onchange="changesharing()" /> Ya
														<input type="radio" name="dt[is_sharing_dana]" value="0" onchange="changesharing()" /> Tidak
														<br>
														<table class="table table-condensed table-hover table-bordered" id="table-sharing">
															<thead>
																<tr style="background: #f3f3f3;">
																	<th>Kantor Wilayah/Divisi</th>
																	<th width="30%">Persentase</th>
																	<th width="30%">Nominal</th>
																	<th style="width: 25px"><button type="button" class="btn btn-success btn-xs" onclick="addrowstable()"><i class="fa fa-plus"></i></button></th>
																</tr>
															</thead>
															<tbody id="body-sharing"></tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td style="width:10%">Kegiatan Terlaksana?</td>
													<td colspan="5">
														<input type="radio" name="dt[is_kegiatan_terlaksana]" value="1" id="" /> Ya
														<input type="radio" name="dt[is_kegiatan_terlaksana]" value="0" id="" /> Tidak
													</td>
												</tr>
												<tr>
													<td style="width:10%">Catatan Kegiatan</td>
													<td colspan="5">
														<textarea name="dt[catatan_kegiatan]" class="form-control" id="" rows="10"></textarea>
														<small class="text-danger">Catatan Kegiatan, diisi apabila: 1. Kegiatan tidak terlaksana. 2. Kegiatan terdapat hasil memuaskan</small>
													</td>
												</tr>
												<tr>
													<td style="width:10%">PIC Pelaksana</td>
													<td colspan="5">
														<input type="text" class="form-control" name="dt[pic_terlaksana]" id="" />
													</td>
												</tr>
												<tr>
													<td style="width:10%">No Kontak Pelaksana</td>
													<td colspan="5">
														<input type="text" class="form-control" name="dt[nomor_kontak_pelaksana]" id="" />
													</td>
												</tr>
												<tr>
													<td style="width:10%">Alamat Pelaksana</td>
													<td colspan="5">
														<input type="text" class="form-control" name="dt[alamat_pelaksana]" id="" />
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
										</script>
									</div>
								</div>
							</div>
							<a href="<?= base_url('master/Sponsorship') ?>" class="btn btn-default">
								<< Kembali Ke Sponsorship </a>
									<div class="pull-right">
										<!-- <button type="submit" name="dt[cv_status]" value="draft" type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Draft</button> -->
										<input type="hidden" name="tab_index" value="#1">
										<button type="submit" class="btn btn-primary btn-sm btn-send">SIMPAN SPONSORSHIP</button>
									</div>
						</div>
					</div>
				</form>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
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
		$("#body-files").append(rows);
	}

	function addrowstable() {
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
	setTimeout(() => {
		$("#table-sharing").hide();
	}, 1000);

	function changesharing() {
		if ($("input[name='dt[is_sharing_dana]']:checked").val() == 1) $("#table-sharing").show();
		else $("#table-sharing").hide();
	}

	changesharing();

	tinymce.remove();
	tinymce.init({
		selector: ".tinymce",
		plugins: "localautosave",
		toolbar1: "localautosave",
		las_seconds: 15,
		las_nVersions: 15,
		las_keyName: "LocalAutoSave",
		las_callback: function() {
			var content = this.content; //content saved
			var time = this.time; //time on save action
		},
	});

	// $("#upload-create").submit(function () {
	// 	var form = $(this);
	// 	var mydata = new FormData(this);
	// 	$.ajax({
	// 		type: "POST",
	// 		url: form.attr("action"),
	// 		data: mydata,
	// 		cache: false,
	// 		contentType: false,
	// 		processData: false,
	// 		beforeSend: function () {
	// 			$(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr("disabled", true);
	// 			form.find(".show_error").slideUp().html("");
	// 		},
	// 		success: function (response, textStatus, xhr) {
	// 			// alert(mydata);
	// 			var str = response;
	// 			if (str.indexOf("success") != -1) {
	// 				Swal.fire({
	// 					title: "It works!",
	// 					text: "Successfully added data",
	// 					icon: "success",
	// 				});
	// 				// form.find(".show_error").hide().html(response).slideDown("fast");
	// 				setTimeout(function () {
	// 					window.location.href = "<?= base_url('master/Sponsorship') ?>";
	// 				}, 1000);
	// 				$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr("disabled", false);
	// 			} else {
	// 				Swal.fire({
	// 					title: "Oppss!",
	// 					html: str,
	// 					icon: "error",
	// 				});
	// 				// form.find(".show_error").hide().html(response).slideDown("fast");
	// 				$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr("disabled", false);
	// 			}
	// 		},
	// 		error: function (xhr, textStatus, errorThrown) {
	// 			console.log(xhr);
	// 			Swal.fire({
	// 				title: "Oppss!",
	// 				text: xhr,
	// 				icon: "error",
	// 			});
	// 			$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr("disabled", false);
	// 			// form.find(".show_error").hide().html(xhr).slideDown("fast");
	// 		},
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