<style>
	.mg-5{
		margin-left: -5px !important;
		margin-right: -5px !important;
	}
	.mg-5>.col-md-3 , .mg-5>.col-md-9{
		padding-left: 5px !important;
		padding-right: 5px !important;
	}
	.table-custom{
		margin-bottom: 0px;
	}
	.table-custom>tbody>tr>td , .table-custom>tbody>tr>th{
		border: 1px solid #7d7d7d;
		vertical-align: middle;
	}
	.table-custom>tbody+tbody{
		border:none;
	}
	.tab-content{
	    border: 1px solid #ddd;
	    border-top: none;
	    padding: 10px;
	}
	.nav-tabs{
		background: #efefef;
		border-radius: 4px 4px 0 0;
		border-bottom: none;
	}
	.nav-tabs>li>a{
		color: #333;
	}
</style>
<div class="content-wrapper" style="background-color: #F5F7FF;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?= $page_name ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url('digitalisasi_cv') ?>"><i class="fa fa-dashboard"></i> List CV</a></li>
			<li class="active"><?= $page_name ?></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- /.col -->
			<div class="col-md-12">
				<form action="<?= base_url('digitalisasi_cv/aksiAdd') ?>" method="POST" enctype="multipart/form-data">
					<div class="box box-primary">
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<div class="col-md-3">
									<label>Tanggal Print</label>
									<input readonly type="text" class="form-control tgl" style="width: 100%;" value="<?= date('Y-m-d') ?>" id="tanggal_print">
								</div>
								<div class="col-md-3">
									<label>Lokasi</label>
									<input type="text" class="form-control" style="width: 100%;"  id="lokasi" placeholder="Jakarta">
								</div>
								<label>&nbsp;</label>
								<br>
								<div class="col-md-6 pull-right">
									<input type="hidden" name="id" value="<?= $data['cv_id'] ?>">
									<a href="#" onclick="cetakDetail()" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
									<a href="<?= base_url('digitalisasi_cv/detail_excel/'.$this->template->sonEncode($data['cv_id'])) ?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Excel</a>
									<a href="#modal-akses" data-toggle="modal" class="btn btn-warning"><i class="fa fa-users"></i> Akses</a>
									<a href="#modal-qrcode" data-toggle="modal" class="btn btn-info"><i class="fa fa-qrcode"></i> QR Code</a>
								</div>
							</div>
							<div role="tabpanel">
								<h4 class="text-center" style="text-decoration: underline;font-weight: bold">DAFTAR RIWAYAT HIDUP</h4>
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#1" aria-controls="1" role="tab" data-toggle="tab">KET. PERORANGAN</a>
									</li>
									<li role="presentation">
										<a href="#2" aria-controls="2" role="tab" data-toggle="tab">SUMMARY/INTEREST/POSISI DIR.</a>
									</li>
									<li role="presentation">
										<a href="#3" aria-controls="3" role="tab" data-toggle="tab">JABATAN</a>
									</li>
									<li role="presentation">
										<a href="#4" aria-controls="4" role="tab" data-toggle="tab">ORGANISASI</a>
									</li>
									<li role="presentation">
										<a href="#5" aria-controls="5" role="tab" data-toggle="tab">PENGHARGAAN/PENDIDIKAN & PELATIHAN</a>
									</li>
									<li role="presentation">
										<a href="#6" aria-controls="6" role="tab" data-toggle="tab">KARYA TULIS/ACARA/REFERENSI</a>
									</li>
									<li role="presentation">
										<a href="#7" aria-controls="7" role="tab" data-toggle="tab">KELUARGA</a>
									</li>
									<li role="presentation">
										<a href="#8" aria-controls="7" role="tab" data-toggle="tab">CATATAN</a>
									</li>
								</ul>
							
								<!-- Tab panes -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="1">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="4"><b>I. KETERANGAN PERERORANGAN</b></td>
											</tr>
											<tr>
												<td style="width: 1px;">1.</td>
												<td style="width: 170px;">Nama Lengkap</td>
												<td><input type="text" class="form-control" name="dt[cv_nama]" value="<?= $data['cv_nama'] ?>"></td>
												<td rowspan="12" style="width: 1px;vertical-align: top;">
													<img src="<?= base_url($data['cv_gambar']) ?>" alt="" style="width: 204px;height: 322px;border:1px solid #7b7b7b;margin-bottom: 10px;object-fit: cover;" id="img-cv">
													<button type="button" class="btn btn-block" onclick="document.getElementById('upload_pas_foto').click()">Upload Pas Foto</button>
													<input type="file" class="form-control" id="upload_pas_foto" name="file" accept="image/*" style="display: none" onchange="loadFile(event)">
												</td>
											</tr>
											<tr>
												<td>2.</td>
												<td>Gelar Akademik</td>
												<td>
													<table class="table table-condensed" id="ktk-akademik" style="margin-bottom: 0px;">
														<?php 
														$akademik = json_decode($data['cv_gelar_akademik'],true);
														if (count($akademik)==0) {
															$akademik[] = '';
														}
														foreach ($akademik as $key => $value): ?>
														<tr id="tr-akademik-<?= $key+1 ?>">
															<td style="vertical-align: middle;">Strata <?= $key+1 ?></td>
															<td><input type="text" class="form-control" name="akademik[]" value="<?= $value ?>"></td>
															<td style="width: 1px;">
																<?php if (($key+1)==1){ ?>
																<button type="button" class="btn btn-success" onclick="addAkademik()"><i class="fa fa-plus"></i></button>
																<?php } else { ?>
																<button type="button" class="btn btn-danger" onclick="deleteAkademik('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
																<?php } ?>
															</td>
														</tr>
														<?php endforeach ?>
													</table>
												</td>
											</tr>
											<tr>
												<td>3.</td>
												<td style="width: 170px;">PN</td>
												<td><input type="text" class="form-control" name="dt[cv_pn]" value="<?= $data['cv_pn'] ?>"></td>
											</tr>
											<tr>
												<td>4.</td>
												<td style="width: 170px;">NIK</td>
												<td><input type="text" class="form-control" name="dt[cv_nik]" value="<?= $data['cv_nik'] ?>"></td>
											</tr>
											<tr>
												<td>5.</td>
												<td style="width: 170px;">Tempat, Tanggal Lahir</td>
												<td>
													<div class="row mg-5">
														<div class="col-md-3">
															<input type="text" class="form-control" name="dt[cv_tempat_lahir]" value="<?= $data['cv_tempat_lahir'] ?>">
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control tgl" name="dt[cv_tanggal_lahir]" value="<?= $data['cv_tanggal_lahir'] ?>">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>6.</td>
												<td style="width: 170px;">Jenis Kelamin</td>
												<td>
													<select name="dt[cv_jenis_kelamin]" class="form-control">
														<option value="">--Jenis Kelamin--</option>
														<option <?= ($data['cv_jenis_kelamin']=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
														<option<?= ($data['cv_jenis_kelamin']=='Perempuan')?'selected':''; ?>>Perempuan</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>7.</td>
												<td style="width: 170px;">Agama</td>
												<td>
													<select name="dt[cv_agama]" class="form-control">
														<option value="">--Agama--</option>
														<option <?= ($data['cv_agama']=='Islam')?'selected':''; ?>>Islam</option>
														<option <?= ($data['cv_agama']=='Katolik')?'selected':''; ?>>Katolik</option>
														<option <?= ($data['cv_agama']=='Hindu')?'selected':''; ?>>Hindu</option>
														<option <?= ($data['cv_agama']=='Buddha')?'selected':''; ?>>Buddha</option>
														<option <?= ($data['cv_agama']=='Konghucu')?'selected':''; ?>>Konghucu</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>8.</td>
												<td style="width: 170px;">Jabatan Terakhir</td>
												<td><input type="text" class="form-control" name="dt[cv_jabatan_terakhir]" value="<?= $data['cv_jabatan_terakhir'] ?>"></td>
											</tr>
											<tr>
												<td>9.</td>
												<td style="width: 170px;">Alamat Rumah</td>
												<td><input type="text" class="form-control" name="dt[cv_alamat_rumah]" value="<?= $data['cv_alamat_rumah'] ?>"></td>
											</tr>
											<tr>
												<td>10.</td>
												<td style="width: 170px;">HP</td>
												<td><input type="text" class="form-control" name="dt[cv_hp]" value="<?= $data['cv_hp'] ?>"></td>
											</tr>
											<tr>
												<td>11.</td>
												<td style="width: 170px;">E-mail</td>
												<td><input type="text" class="form-control" name="dt[cv_email]" value="<?= $data['cv_email'] ?>"></td>
											</tr>
											<tr>
												<td>12.</td>
												<td style="width: 170px;">NPWP</td>
												<td><input type="text" class="form-control" name="dt[cv_npwp]" value="<?= $data['cv_npwp'] ?>"></td>
											</tr>
											<tr>
												<td>13.</td>
												<td style="width: 170px;">Alamat Social Media</td>
												<td><input type="text" class="form-control" name="dt[cv_alamat_social_media]" value="<?= $data['cv_alamat_social_media'] ?>"></td>
											</tr>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="2">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td>
													<b>II. SUMMARY</b> <br>
													<em>(Menggambarkan pernyataan misi pribadi & keahlian atau kompetensi yang dikuasai)</em>
												</td>
											</tr>
											<tr>
												<td>
													<textarea name="dt[cv_summary]" class="form-control" style="height: 100px;"><?= $data['cv_summary'] ?></textarea>
												</td>
											</tr>
										</table>
										<br>
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td>
													<b>III. INTEREST</b> <br>
													<em>(Ilustrasi atas minat/passion yang secara terus-menerus dikembangkan)</em>
												</td>
											</tr>
											<tr>
												<td>
													<textarea name="dt[cv_interest]" class="form-control" style="height: 100px;"><?= $data['cv_interest'] ?></textarea>
												</td>
											</tr>
										</table>
										<br>
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="8">
													<b>IV. PERMINTAAN POSISI DIREKTUR</b> <br>
													<em>(Diperbolehkan memilih lebih dari satu)</em>
												</td>
											</tr>
											<?php 
											$posisi_direktur = array(
												'Direktur Utama',
												'Pemasaran',
												'Investasi',
												'Teknologi Informasi',
												'Keuangan',
												'Pengembangan Bisnis',
												'Procurement/ Pengadaan',
												'Operasional',
												'Commercial Banking',
												'Produksi',
												'Keamanan dan Keselamatan Kerja',
												'Manajemen Aset',
												'Consumer Banking',
												'Teknik',
												'Logistik',
												'Pelayanan / Services',
												'Digital Banking',
												'Resiko Perusahaan',
												'Strategic Portofolio',
												'Kebutuhan / Hukum / Legal',
												'Treasury',
												'Human Capital (SDM)',
												'Supply Chain Management',
												'',
											)
											?>
											<?php 
											$permintaan_posisi_direktur = json_decode($data['cv_permintaan_posisi_direktur'],true);
											foreach (array_chunk($posisi_direktur, 4) as $key_pd => $posisi){ ?>
											<tr>
												<?php foreach ($posisi as $key_p => $value){ ?>
													<?php if ($value==''){ ?>
														<td colspan="2">
															<input type="text" name="dt[cv_permintaan_posisi_direktur_lain]" value="<?= $data['cv_permintaan_posisi_direktur_lain'] ?>" placeholder="*....">
														</td>
													<?php } else { ?>
														<td><?= $value ?></td>
														<td style="text-align: center;width: 80px;">
															<input type="checkbox" name="posisi_direktur[]" value="<?= $value ?>" <?= (in_array($value, $permintaan_posisi_direktur))?'checked':''; ?>>
														</td>
													<?php } ?>
												<?php } ?>
											</tr>
											<?php } ?>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="3">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>V. RIWAYAT JABATAN</b>
												</td>
											</tr>
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>1. Jabatan/ pekerjaan Yang Pernah/ Sedang Diemban</b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Jabatan</th>
												<th style="text-align: center;">Uraian Singkat Tugas dan Kewenangan</th>
												<th style="text-align: center;">Rentang Waktu</th>
												<th style="text-align: center;">Achievement (Maksimal 5 Pencapaian)</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-riwayat_jabatan">
												<?php 
												$riwayat_jabatan = json_decode($data['cv_riwayat_jabatan'],true);
												if (count($riwayat_jabatan)==0) {
													$riwayat_jabatan[] = array('isi');
												}
												foreach ($riwayat_jabatan as $key => $value): ?>
												<tr id="tr-riwayat_jabatan-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="riwayat_jabatan_nama[]" value="<?= $value['jabatan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="riwayat_jabatan_uraian[]" value="<?= $value['uraian'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="riwayat_jabatan_rentang[]" value="<?= $value['rentang_waktu'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="riwayat_jabatan_achievement[]" value="<?= $value['achievement'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="riwayat_jabatan_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="riwayat_jabatan_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addRiwayat_jabatan()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteRiwayat_jabatan('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>2. Penugasan yang berkaitan dengan jabatan Direksi/ Dewan Komisaris/ Dewan Pengawas <span style="color: red;"><em>(bila ada)</em></span></b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Penugasan</th>
												<th style="text-align: center;">Tupoksi</th>
												<th style="text-align: center;">Rentang Waktu</th>
												<th style="text-align: center;">Instansi/ Perusahaan</th>
												<th style="text-align: center;">File</th>
												<th style="text-align: center;">#</th>
											</tr>
											<tbody id="ktk-penugasan">
												<?php 
												$penugasan = json_decode($data['cv_penugasan'],true);
												if (count($penugasan)==0) {
													$penugasan[] = array('isi');
												}
												foreach ($penugasan as $key => $value): ?>
												<tr id="tr-penugasan-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="penugasan_penugasan[]" value="<?= $value['penugasan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="penugasan_uraian[]" value="<?= $value['tupoksi'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="penugasan_rentang[]" value="<?= $value['rentang_waktu'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="penugasan_instansi[]" value="<?= $value['instansi'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="penugasan_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="penugasan_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addPenugasan()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deletePenugasan('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="4">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>VI. KEANGGOTAAN ORGANISASI PROFESI/ KOMUNITAS YANG DIIKUTI</b>
												</td>
											</tr>
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>1. Kegiatan/ organisasi yang pernah/ sedang diikuti <span style="color: red;"><em>(yang terkait dengan pekerjaan/ profesional)</em></span></b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Nama Kegiatan/ Organisasi</th>
												<th style="text-align: center;">Jabatan</th>
												<th style="text-align: center;">Rentang Waktu</th>
												<th style="text-align: center;">Uraian Singkat Kegiatan/Organisasi</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-organisasi_pekerjaan">
												<?php 
												$organisasi_pekerjaan = json_decode($data['cv_organisasi_pekerjaan'],true);
												if (count($organisasi_pekerjaan)==0) {
													$organisasi_pekerjaan[] = array('isi');
												}
												foreach ($organisasi_pekerjaan as $key => $value): ?>
												<tr id="tr-organisasi_pekerjaan-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="organisasi_pekerjaan_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="organisasi_pekerjaan_jabatan[]" value="<?= $value['jabatan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="organisasi_pekerjaan_rentang[]" value="<?= $value['rentang_waktu'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="organisasi_pekerjaan_uraian[]" value="<?= $value['uraian'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="organisasi_pekerjaan_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="organisasi_pekerjaan_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addOrganisasi_pekerjaan()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteOrganisasi_pekerjaan('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>2. Kegiatan/ organisasi yang pernah/ sedang diikuti <span style="color: red;"><em>(non formal)</em></span></b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Nama Kegiatan/ Organisasi</th>
												<th style="text-align: center;">Jabatan</th>
												<th style="text-align: center;">Rentang Waktu</th>
												<th style="text-align: center;">Uraian Singkat Kegiatan/Organisasi</th>
												<th style="text-align: center;">File</th>
												<th style="text-align: center;">#</th>
											</tr>
											<tbody id="ktk-organisasi_nonformal">
												<?php 
												$organisasi_nonformal = json_decode($data['cv_organisasi_nonformal'],true);
												if (count($organisasi_nonformal)==0) {
													$organisasi_nonformal[] = array('isi');
												}
												foreach ($organisasi_nonformal as $key => $value): ?>
												<tr id="tr-organisasi_nonformal-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="organisasi_nonformal_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="organisasi_nonformal_jabatan[]" value="<?= $value['jabatan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="organisasi_nonformal_rentang[]" value="<?= $value['rentang_waktu'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="organisasi_nonformal_uraian[]" value="<?= $value['uraian'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="organisasi_nonformal_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="organisasi_nonformal_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addOrganisasi_nonformal()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteOrganisasi_nonformal('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="5">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>VII. PENGHARGAAN</b> <br>
													<em>(Internal & Eksternal)</em>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Jenis Penghargaan</th>
												<th style="text-align: center;">Tingkat</th>
												<th style="text-align: center;">Diberikan Oleh</th>
												<th style="text-align: center;">Tahun</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-penghargaan">
												<?php 
												$penghargaan = json_decode($data['cv_penghargaan'],true);
												if (count($penghargaan)==0) {
													$penghargaan[] = array('isi');
												}
												foreach ($penghargaan as $key => $value): ?>
												<tr id="tr-penghargaan-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="penghargaan_jenis[]" value="<?= $value['jenis'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="penghargaan_tingkat[]" value="<?= $value['tingkat'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="penghargaan_diberikan_oleh[]" value="<?= $value['diberikan_oleh'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="penghargaan_tahun[]" value="<?= $value['tahun'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="penghargaan_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="penghargaan_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addPenghargaan()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deletePenghargaan('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
										<br>
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="8">
													<b>VIII. RIWAYAT PENDIDIKAN DAN PELATIHAN</b>
												</td>
											</tr>
											<tr style="background: #ddd;">
												<td colspan="8">
													<b>1. Pendidikan Formal</b> <br>
													<em>(Dimulai dari Strata 1)</em>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Jenjang - Penjurusan</th>
												<th style="text-align: center;">Perguruan Tinggi</th>
												<th style="text-align: center;">Tahun Lulus</th>
												<th style="text-align: center;">Kota/Negara</th>
												<th style="text-align: center;">Penghargaan yang didapat</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-pendidikan_formal">
												<?php 
												$pendidikan_formal = json_decode($data['cv_pendidikan_formal'],true);
												if (count($pendidikan_formal)==0) {
													$pendidikan_formal[] = array('isi');
												}
												foreach ($pendidikan_formal as $key => $value): ?>
												<tr id="tr-pendidikan_formal-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="pendidikan_formal_jenjang[]" value="<?= $value['jenjang'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pendidikan_formal_perguruan_tinggi[]" value="<?= $value['perguruan_tinggi'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pendidikan_formal_tahun_lulus[]" value="<?= $value['tahun_lulus'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pendidikan_formal_kota[]" value="<?= $value['kota'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pendidikan_formal_penghargaan[]" value="<?= $value['penghargaan'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="pendidikan_formal_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="pendidikan_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addPendidikan_formal()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deletePendidikan_formal('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
											<tr style="background: #ddd;">
												<td colspan="8">
													<b>2. Pendidikan dan Latihan/ Pengembangan Kompetensi Yang Pernah Diikuti (minimal 16 Jam)</b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Nama Pendidikan dan Latihan/ Pengembangan Kompetensi</th>
												<th style="text-align: center;" colspan="2">Penyelenggara/ Kota</th>
												<th style="text-align: center;">Lama Diklat/ Pengembangan Kompetensi</th>
												<th style="text-align: center;">Nomor Sertifikasi</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tr>
												<td>A.</td>
												<td colspan="7" style="text-decoration: underline;"><b>DIKLAT JABATAN</b></td>
											</tr>
											<tbody id="ktk-diklat_jabatan">
												<?php 
												$diklat_jabatan = json_decode($data['cv_diklat_jabatan'],true);
												if (count($diklat_jabatan)==0) {
													$diklat_jabatan[] = array('isi');
												}
												foreach ($diklat_jabatan as $key => $value): ?>
												<tr id="tr-diklat_jabatan-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="diklat_jabatan_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td colspan="2">
														<input type="text" class="form-control" name="diklat_jabatan_penyelenggara[]" value="<?= $value['penyelenggara'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="diklat_jabatan_durasi[]" value="<?= $value['durasi'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="diklat_jabatan_nomor[]" value="<?= $value['nomor_sertifikat'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="diklat_jabatan_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="diklat_jabatan_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addDiklat_jabatan()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteDiklat_jabatan('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
											<tr>
												<td>B.</td>
												<td colspan="7" style="text-decoration: underline;"><b>DIKLAT FUNGSIONAL</b></td>
											</tr>
											<tbody id="ktk-diklat_fungsional">
												<?php 
												$diklat_fungsional = json_decode($data['cv_diklat_fungsional'],true);
												if (count($diklat_fungsional)==0) {
													$diklat_fungsional[] = array('isi');
												}
												foreach ($diklat_fungsional as $key => $value): ?>
												<tr id="tr-diklat_fungsional-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="diklat_fungsional_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td colspan="2">
														<input type="text" class="form-control" name="diklat_fungsional_penyelenggara[]" value="<?= $value['penyelenggara'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="diklat_fungsional_durasi[]" value="<?= $value['durasi'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="diklat_fungsional_nomor[]" value="<?= $value['nomor_sertifikat'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="diklat_fungsional_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="diklat_fungsional_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addDiklat_fungsional()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteDiklat_fungsional('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
										<span><em>** Tingkat : Organisasi Kerja, Nasional, Internasional</em></span>
									</div>
									<div role="tabpanel" class="tab-pane" id="6">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="5">
													<b>IX. KARYA TULIS (dalam 5 tahun terakhir)</b> <br>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Judul dan Media Publikasi</th>
												<th style="text-align: center;">Tahun</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-karya_tulis">
												<?php 
												$karya_tulis = json_decode($data['cv_karya_tulis'],true);
												if (count($karya_tulis)==0) {
													$karya_tulis[] = array('isi');
												}
												foreach ($karya_tulis as $key => $value): ?>
												<tr id="tr-karya_tulis-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="karya_tulis_judul[]" value="<?= $value['judul'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="karya_tulis_tahun[]" value="<?= $value['tahun'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="karya_tulis_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="karya_tulis_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addKarya_tulis()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteKarya_tulis('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
										<br>
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>X. PENGALAMAN SEBAGAI PEMBICARA/ NARASUMBER/ JURI (dalam 5 tahun terakhir)</b> <br>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Acara / Tema</th>
												<th style="text-align: center;">Penyelenggara</th>
												<th style="text-align: center;">Periode</th>
												<th style="text-align: center;">Lokasi dan Peserta</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-pengalaman_pembicara">
												<?php 
												$pengalaman_pembicara = json_decode($data['cv_pengalaman_pembicara'],true);
												if (count($pengalaman_pembicara)==0) {
													$pengalaman_pembicara[] = array('isi');
												}
												foreach ($pengalaman_pembicara as $key => $value): ?>
												<tr id="tr-pengalaman_pembicara-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="pengalaman_pembicara_acara[]" value="<?= $value['acara'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pengalaman_pembicara_penyelenggara[]" value="<?= $value['penyelenggara'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pengalaman_pembicara_periode[]" value="<?= $value['periode'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pengalaman_pembicara_lokasi[]" value="<?= $value['lokasi'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="pengalaman_pembicara_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="pengalaman_pembicara_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addPengalaman_pembicara()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deletePengalaman_pembicara('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
										<br>
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="7">
													<b>XI. REFERENSI*</b> <br>
													<em>(yang dapat memberikan keterangan … atas keabsahan)</em>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Nama</th>
												<th style="text-align: center;">Perusahaan</th>
												<th style="text-align: center;">Jabatan</th>
												<th style="text-align: center;">Nomor Telp.</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-referensi">
												<?php 
												$referensi = json_decode($data['cv_referensi'],true);
												if (count($referensi)==0) {
													$referensi[] = array('isi');
												}
												foreach ($referensi as $key => $value): ?>
												<tr id="tr-referensi-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="referensi_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="referensi_perusahaan[]" value="<?= $value['perusahaan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="referensi_jabatan[]" value="<?= $value['jabatan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="referensi_no_telp[]" value="<?= $value['no_telp'] ?>">
													</td>
													<td>
														<div class="input-group">
														    <input type="file" class="form-control" name="referensi_file[]">
															<?php if ($value['file']){ ?>
														    	<div class="input-group-btn">
															      <a href="<?= base_url($value['file']) ?>" class="btn btn-info" target="_blank">
															        <i class="fa fa-download"></i>
															      </a>
															    </div>
															<?php } else { ?>
														    	<div class="input-group-btn">
															      <button type="button" class="btn btn-warning" target="_blank">
															        <i class="fa fa-close"></i>
															      </button>
															    </div>
															<?php } ?>
														</div>
														<input type="hidden" name="referensi_file_old[]" value="<?= $value['file'] ?>">
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addReferensi()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteReferensi('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="7">
										<table class="table table-bordered table-condensed table-custom">
											<tr style="background: #ddd;">
												<td colspan="9">
													<b>XII. KETERANGAN KELUARGA*</b>
												</td>
											</tr>
											<tr style="background: #ddd;">
												<td colspan="9">
													<b>1. Istri/Suami</b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Nama</th>
												<th style="text-align: center;">Tempat Lahir</th>
												<th style="text-align: center;">Tanggal Lahir</th>
												<th style="text-align: center;">Tanggal Menikah</th>
												<th style="text-align: center;">Pekerjaan</th>
												<th style="text-align: center;">Keterangan</th>
												<th style="text-align: center;width: 25%;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-pasangan">
												<?php 
												$pasangan = json_decode($data['cv_pasangan'],true);
												if (count($pasangan)==0) {
													$pasangan[] = array('isi');
												}
												foreach ($pasangan as $key => $value): ?>
												<tr id="tr-pasangan-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="pasangan_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pasangan_tempat_lahir[]" value="<?= $value['tempat_lahir'] ?>">
													</td>
													<td>
														<input type="text" class="form-control tgl" name="pasangan_tanggal_lahir[]" value="<?= $value['tanggal_lahir'] ?>">
													</td>
													<td>
														<input type="text" class="form-control tgl" name="pasangan_tanggal_menikah[]" value="<?= $value['tanggal_menikah'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pasangan_tanggal_pekerjaan[]" value="<?= $value['pekerjaan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="pasangan_tanggal_keterangan[]" value="<?= $value['keterangan'] ?>">
													</td>
													<td class="row-file-pasangan">
														<?php
															$file = array();
															if(!empty($value['file'])){
																$file = $value['file'];
															}
														?>
														<?php
														if(!empty($file)){
															foreach($file as $f => $fl){
																?>

														<div class="form-group-">
															<div class="col-md-5 no-padding">
																	<input type="text" class="form-control nama-file" name="pasangan_nama_file_<?=$key?>[]" value="<?=$fl['nama_file']?>">
																</div>
																<div class="col-md-5 no-padding">
																	<input type="hidden" class="file-old" name="pasangan_old_<?=$key?>[]" value="<?=$fl['file']?>">
														    		<input type="file" class="form-control file" name="pasangan_file_<?=$key?>_<?=$f?>">
																</div>
															<?php
															if($f == 0){
																?>
																
																<div class="col-md-2 no-padding">
																	<button type="button" class="btn btn-primary" onclick="addFilePasangan($(this))"><i class="fa fa-plus"></i></button>
																</div>
																<?php
															}
															else{
															?>
															<div class="col-md-2 no-padding">
																	<button type="button" class="btn btn-danger" onclick="aremoveFilePasangan($(this))"><i class="fa fa-remove"></i></button>
																</div>
															<?php
														}
															?>
																<div class="col-md-12 no-padding alert-file">
																	<?php
																	if(!empty($fl['file'])){
																		?>
																		<a href="<?=base_url().$fl['file']?>" target="_blank">Download Last File</a>
																		<?php
																	}
																	?>
																</div>

														</div>
																<?php
															}
														}
														else{
															?>
															<div class="form-group no-padding">
																<div class="col-md-5 no-padding">
																	<input type="text" class="form-control nama-file" name="pasangan_nama_file_<?=$key?>[]">
																</div>
																<div class="col-md-5 no-padding">
																	<input type="hidden" class="file-old" name="pasangan_old_<?=$key?>[]" value="">
														    		<input type="file" class="form-control file" name="pasangan_file_<?=$key?>_0">
																</div>
																<div class="col-md-2 no-padding">
																	<button type="button" class="btn btn-primary" onclick="addFilePasangan($(this))"><i class="fa fa-plus"></i></button>
																</div>
																<div class="col-md-12 no-padding alert-file">
																</div>
															</div>
															<?php
														}
														?>
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addPasangan()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deletePasangan('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
											<tr style="background: #ddd;">
												<td colspan="9">
													<b>2. Anak</b>
												</td>
											</tr>
											<tr style="background: #eee;">
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Nama</th>
												<th style="text-align: center;">Tempat Lahir</th>
												<th style="text-align: center;">Tanggal Lahir</th>
												<th style="text-align: center;">Jenis Kelamin</th>
												<th style="text-align: center;">Pekerjaan</th>
												<th style="text-align: center;">Keterangan</th>
												<th style="text-align: center;width: 250px;">File</th>
												<th style="text-align: center;width: 1px;">#</th>
											</tr>
											<tbody id="ktk-anak">
												<?php 
												$anak = json_decode($data['cv_anak'],true);
												if (count($anak)==0) {
													$anak[] = array('isi');
												}
												foreach ($anak as $key => $value): ?>
												<tr id="tr-anak-<?= $key+1 ?>">
													<td><?= $key+1 ?>.</td>
													<td>
														<input type="text" class="form-control" name="anak_nama[]" value="<?= $value['nama'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="anak_tempat_lahir[]" value="<?= $value['tempat_lahir'] ?>">
													</td>
													<td>
														<input type="text" class="form-control tgl" name="anak_tanggal_lahir[]" value="<?= $value['tanggal_lahir'] ?>">
													</td>
													<td>
														<select name="anak_jenis_kelamin[]" class="form-control">
															<option value="">--Jenis Kelamin--</option>
															<option <?= ($value['jenis_kelamin']=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
															<option <?= ($value['jenis_kelamin']=='Perempuan')?'selected':''; ?>>Perempuan</option>
														</select>
													</td>
													<td>
														<input type="text" class="form-control" name="anak_tanggal_pekerjaan[]" value="<?= $value['pekerjaan'] ?>">
													</td>
													<td>
														<input type="text" class="form-control" name="anak_tanggal_keterangan[]" value="<?= $value['keterangan'] ?>">
													</td>
													<td class="row-file-anak">
														<?php
															$file = array();
															if(!empty($value['file'])){
																$file = $value['file'];
															}
														?>
														<?php
														if(!empty($file)){
															foreach($file as $f => $fl){
																?>

														<div class="form-group">
															<div class="col-md-5 no-padding">
																	<input type="text" class="form-control nama-file" name="anak_nama_file_<?=$key?>[]" value="<?=$fl['nama_file']?>">
																</div>
																<div class="col-md-5 no-padding">
																	<input type="hidden" class="file-old" name="anak_old_<?=$key?>[]" value="<?=$fl['file']?>">
														    		<input type="file" class="form-control file" name="anak_file_<?=$key?>_<?=$f?>">
																</div>
															<?php
															if($f == 0){
																?>
																
																<div class="col-md-2 no-padding">
																	<button type="button" class="btn btn-primary" onclick="addFileAnak($(this))"><i class="fa fa-plus"></i></button>
																</div>
																<?php
															}
															else{
															?>
															<div class="col-md-2 no-padding">
																	<button type="button" class="btn btn-danger" onclick="removeFileAnak($(this))"><i class="fa fa-remove"></i></button>
																</div>
															<?php
														}
															?>
																<div class="col-md-12 no-padding alert-file">
																	<?php
																	if(!empty($fl['file'])){
																		?>
																		<a href="<?=base_url().$fl['file']?>" target="_blank">Download Last File</a>
																		<?php
																	}
																	?>
																</div>

														</div>
																<?php
															}
														}
														else{
															?>
															<div class="form-group no-padding">
																<div class="col-md-5 no-padding">
																	<input type="text" class="form-control nama-file" name="anak_nama_file_<?=$key?>[]">
																</div>
																<div class="col-md-5 no-padding">
																	<input type="hidden" class="file-old" name="anak_old_0[]" value="">
														    		<input type="file" class="form-control file" name="anak_file_<?=$key?>_0">
																</div>
																<div class="col-md-2 no-padding">
																	<button type="button" class="btn btn-primary" onclick="addFileAnak($(this))"><i class="fa fa-plus"></i></button>
																</div>
																<div class="col-md-12 no-padding alert-file">
																</div>
															</div>
															<?php
														}
														?>
													</td>
													<td>
														<?php if (($key+1)==1){ ?>
															<button type="button" class="btn btn-success" onclick="addAnak()"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-danger" onclick="deleteAnak('<?= $key+1 ?>')"><i class="fa fa-minus"></i></button>
														<?php } ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div role="tabpanel" class="tab-pane" id="8">
										<textarea class="form-control" name="dt[cv_catatan]"><?=(!empty($data['cv_catatan']))?$data['cv_catatan']:CATATAN_CV?></textarea>
									</div>
								</div>
							</div>

						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?= base_url('digitalisasi_cv') ?>" class="btn btn-default"><< Kembali Ke List Surat</a>
							<div class="pull-right">
								<!-- <button type="submit" name="dt[cv_status]" value="draft" type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Draft</button> -->
								<input type="hidden" name="tab_index">
								<button type="submit" name="dt[cv_status]" value="simpan" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Simpan</button>
							</div>
						</div>
						<!-- /.box-footer -->
					</div>
				</form>
				<!-- /. box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<form action="<?= base_url('digitalisasi_cv/aksiEditAkses') ?>" method="POST">
<div class="modal fade" id="modal-akses">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Akses</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" value="<?= $data['cv_id'] ?>">
				<div class="form-group">
					<label>CV ini dapat diubah oleh :</label>
					<select name="akses[]" class="form-control select2" multiple style="width: 100%;">
						<?php 
						$this->db->select('cva_id_user');
						$cvakses = $this->mymodel->selectWhere('cv_akses',array('cva_id_cv'=>$data['cv_id']));
						$idselect = [];
						foreach ($cvakses as $key => $value) {
							$idselect[] = $value['cva_id_user'];
						}
						$this->db->where_in('jabatan_id', ['4','5']);
						$muser = $this->mymodel->selectWhere('user',[]);
						foreach ($muser as $key => $value): ?>
							<option value="<?= $value['id'] ?>" <?= (in_array($value['id'], $idselect))?'selected':''; ?>><?= $value['role_name'] ?> - <?= $value['name'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
			</div>
		</div>
	</div>
</div>
</form>

<div class="modal fade" id="modal-qrcode">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">QR Code</h4>
			</div>
			<div class="modal-body">
				<?php 
					$link = base_url('digitalisasi_cv/detail/'.$this->template->sonEncode($data['cv_id']).'?source=qrcode');
					$logo = 'http://digitalcorsec.id/assets/logo_bri.png';
				?>
				<img src="<?= 'http://dev.alfahuma.tech/generate_qrcode.php?qr_content='.$link.'&qr_logo='.$logo ?>" alt="" style="width: 100%;">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function(){
		  var output = document.getElementById('img-cv');
		  output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
	};

	function addFilePasangan(eleid){
		var htmls= '<div class="form-group">'+
						'<div class="col-md-5 no-padding">'+
							'<input type="text" class="form-control nama-file" name="pasangan_nama_file_0[]">'+
						'</div>'+
						'<div class="col-md-5 no-padding">'+
							'<input type="hidden" class="file-old" name="pasangan_old_0[]" value="">'+
				    		'<input type="file" class="form-control file" name="pasangan_file_0[]">'+
						'</div>'+
						'<div class="col-md-2 no-padding">'+
							'<button type="button" class="btn btn-danger" onclick="removeFilePasangan($(this))"><i class="fa fa-remove"></i></button>'+
						'</div>'+
						'<div class="col-md-12 no-padding alert-file">'+
						'</div>'+
					'</div>';
		eleid.closest('.row-file-pasangan').append(htmls);
		incrementFilePasangan();
	}
	function incrementFilePasangan(){
		var j = 0;
		$('.row-file-pasangan').each(function(){
			$(this).find('.file-old').attr('name','pasangan_old_'+j+'[]');
			$(this).find('.nama-file').attr('name','pasangan_nama_file_'+j+'[]');
			var h = 0;
			$(this).find('.file').each(function(){
				$(this).attr('name','pasangan_file_'+j+'_'+h);
				h++;
			});
			j++;
		});
	}

	function removeFilePasangan(eleid){
		eleid.closest('.form-group').remove();
		incrementFilePasangan();
	}
	function removeFileAnak(eleid){
		eleid.closest('.form-group').remove();
		incrementFileAnak();
	}
	function addFileAnak(eleid){
		var htmls= '<div class="form-group">'+
						'<div class="col-md-5 no-padding">'+
							'<input type="text" class="form-control nama-file" name="anak_nama_file_0[]">'+
						'</div>'+
						'<div class="col-md-5 no-padding">'+
							'<input type="hidden" class="file-old" name="anak_old_0[]" value="">'+
				    		'<input type="file" class="form-control file" name="anak_file_0[]">'+
						'</div>'+
						'<div class="col-md-2 no-padding">'+
							'<button type="button" class="btn btn-danger" onclick="removeFileAnak($(this))"><i class="fa fa-remove"></i></button>'+
						'</div>'+
						'<div class="col-md-12 no-padding alert-file">'+
						'</div>'+
					'</div>';
		eleid.closest('.row-file-anak').append(htmls);
		incrementFileAnak();
	}
	function incrementFileAnak(){
		var j = 0;
		$('.row-file-anak').each(function(){
			$(this).find('.file-old').attr('name','anak_old_'+j+'[]');
			$(this).find('.nama-file').attr('name','anak_nama_file_'+j+'[]');
			var h = 0;
			$(this).find('.file').each(function(){
				$(this).attr('name','anak_file_'+j+'_'+h);
				h++;
			});
			j++;
		});
	}
	var numakademik = Number(<?= count($akademik)+1 ?>);
	function addAkademik() {
		var html =  '<tr id="tr-akademik-'+numakademik+'">'+
					'	<td style="vertical-align: middle;">Srata '+numakademik+'</td>'+
					'	<td><input type="text" class="form-control" name="akademik[]"></td>'+
					'	<td style="width: 1px;">'+
					'		<button type="button" class="btn btn-danger" onclick="deleteAkademik('+numakademik+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-akademik').append(html);
		numakademik++;
	}

	function deleteAkademik(no) {
		$('#tr-akademik-'+no).remove();
	}

	var numriwayat_jabatan = Number(<?= count($riwayat_jabatan)+1 ?>);
	function addRiwayat_jabatan() {
		var html =  '<tr id="tr-riwayat_jabatan-'+numriwayat_jabatan+'">'+
					'	<td>'+numriwayat_jabatan+'.</td>'+
					'	<td><input type="text" class="form-control" name="riwayat_jabatan_nama[]"></td>'+
					'	<td><input type="text" class="form-control" name="riwayat_jabatan_uraian[]"></td>'+
					'	<td><input type="text" class="form-control" name="riwayat_jabatan_rentang[]"></td>'+
					'	<td><input type="text" class="form-control" name="riwayat_jabatan_achievement[]"></td>'+
					'	<td><input type="file" class="form-control" name="riwayat_jabatan_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteRiwayat_jabatan('+numriwayat_jabatan+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-riwayat_jabatan').append(html);
		numriwayat_jabatan++;
	}

	function deleteRiwayat_jabatan(no) {
		$('#tr-riwayat_jabatan-'+no).remove();
	}

	var numpenugasan = Number(<?= count($penugasan)+1 ?>);
	function addPenugasan() {
		var html =  '<tr id="tr-penugasan-'+numpenugasan+'">'+
					'	<td>'+numpenugasan+'.</td>'+
					'	<td><input type="text" class="form-control" name="penugasan_penugasan[]"></td>'+
					'	<td><input type="text" class="form-control" name="penugasan_uraian[]"></td>'+
					'	<td><input type="text" class="form-control" name="penugasan_rentang[]"></td>'+
					'	<td><input type="text" class="form-control" name="penugasan_instansi[]"></td>'+
					'	<td><input type="file" class="form-control" name="penugasan_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deletePenugasan('+numpenugasan+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-penugasan').append(html);
		numpenugasan++;
	}

	function deletePenugasan(no) {
		$('#tr-penugasan-'+no).remove();
	}

	var numorganisasi_pekerjaan = Number(<?= count($organisasi_pekerjaan)+1 ?>);
	function addOrganisasi_pekerjaan() {
		var html =  '<tr id="tr-organisasi_pekerjaan-'+numorganisasi_pekerjaan+'">'+
					'	<td>'+numorganisasi_pekerjaan+'.</td>'+
					'	<td><input type="text" class="form-control" name="organisasi_pekerjaan_nama[]"></td>'+
					'	<td><input type="text" class="form-control" name="organisasi_pekerjaan_jabatan[]"></td>'+
					'	<td><input type="text" class="form-control" name="organisasi_pekerjaan_rentang[]"></td>'+
					'	<td><input type="text" class="form-control" name="organisasi_pekerjaan_uraian[]"></td>'+
					'	<td><input type="file" class="form-control" name="organisasi_pekerjaan_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteOrganisasi_pekerjaan('+numorganisasi_pekerjaan+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-organisasi_pekerjaan').append(html);
		numorganisasi_pekerjaan++;
	}

	function deleteOrganisasi_pekerjaan(no) {
		$('#tr-organisasi_pekerjaan-'+no).remove();
	}

	var numorganisasi_nonformal = Number(<?= count($organisasi_nonformal)+1 ?>);
	function addOrganisasi_nonformal() {
		var html =  '<tr id="tr-organisasi_nonformal-'+numorganisasi_nonformal+'">'+
					'	<td>'+numorganisasi_nonformal+'.</td>'+
					'	<td><input type="text" class="form-control" name="organisasi_nonformal_nama[]"></td>'+
					'	<td><input type="text" class="form-control" name="organisasi_nonformal_jabatan[]"></td>'+
					'	<td><input type="text" class="form-control" name="organisasi_nonformal_rentang[]"></td>'+
					'	<td><input type="text" class="form-control" name="organisasi_nonformal_uraian[]"></td>'+
					'	<td><input type="file" class="form-control" name="organisasi_nonformal_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteOrganisasi_nonformal('+numorganisasi_nonformal+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-organisasi_nonformal').append(html);
		numorganisasi_nonformal++;
	}

	function deleteOrganisasi_nonformal(no) {
		$('#tr-organisasi_nonformal-'+no).remove();
	}

	var numpenghargaan = Number(<?= count($penghargaan)+1 ?>);
	function addPenghargaan() {
		var html =  '<tr id="tr-penghargaan-'+numpenghargaan+'">'+
					'	<td>'+numpenghargaan+'.</td>'+
					'	<td><input type="text" class="form-control" name="penghargaan_jenis[]"></td>'+
					'	<td><input type="text" class="form-control" name="penghargaan_tingkat[]"></td>'+
					'	<td><input type="text" class="form-control" name="penghargaan_diberikan_oleh[]"></td>'+
					'	<td><input type="text" class="form-control" name="penghargaan_tahun[]"></td>'+
					'	<td><input type="file" class="form-control" name="penghargaan_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deletePenghargaan('+numpenghargaan+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-penghargaan').append(html);
		numpenghargaan++;
	}

	function deletePenghargaan(no) {
		$('#tr-penghargaan-'+no).remove();
	}

	var numpendidikan_formal = Number(<?= count($pendidikan_formal)+1 ?>);
	function addPendidikan_formal() {
		var html =  '<tr id="tr-pendidikan_formal-'+numpendidikan_formal+'">'+
					'	<td>'+numpendidikan_formal+'.</td>'+
					'	<td><input type="text" class="form-control" name="pendidikan_formal_jenjang[]"></td>'+
					'	<td><input type="text" class="form-control" name="pendidikan_formal_perguruan_tinggi[]"></td>'+
					'	<td><input type="text" class="form-control" name="pendidikan_formal_tahun_lulus[]"></td>'+
					'	<td><input type="text" class="form-control" name="pendidikan_formal_kota[]"></td>'+
					'	<td><input type="text" class="form-control" name="pendidikan_formal_penghargaan[]"></td>'+
					'	<td><input type="file" class="form-control" name="pendidikan_formal_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deletePendidikan_formal('+numpendidikan_formal+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-pendidikan_formal').append(html);
		numpendidikan_formal++;
	}

	function deletePendidikan_formal(no) {
		$('#tr-pendidikan_formal-'+no).remove();
	}

	var numdiklat_jabatan = Number(<?= count($diklat_jabatan)+1 ?>);
	function addDiklat_jabatan() {
		var html =  '<tr id="tr-diklat_jabatan-'+numdiklat_jabatan+'">'+
					'	<td>'+numdiklat_jabatan+'.</td>'+
					'	<td><input type="text" class="form-control" name="diklat_jabatan_nama[]"></td>'+
					'	<td colspan="2"><input type="text" class="form-control" name="diklat_jabatan_penyelenggara[]"></td>'+
					'	<td><input type="text" class="form-control" name="diklat_jabatan_durasi[]"></td>'+
					'	<td><input type="text" class="form-control" name="diklat_jabatan_nomor[]"></td>'+
					'	<td><input type="file" class="form-control" name="diklat_jabatan_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteDiklat_jabatan('+numdiklat_jabatan+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-diklat_jabatan').append(html);
		numdiklat_jabatan++;
	}

	function deleteDiklat_jabatan(no) {
		$('#tr-diklat_jabatan-'+no).remove();
	}

	var numdiklat_fungsional = Number(<?= count($diklat_fungsional)+1 ?>);
	function addDiklat_fungsional() {
		var html =  '<tr id="tr-diklat_fungsional-'+numdiklat_fungsional+'">'+
					'	<td>'+numdiklat_fungsional+'.</td>'+
					'	<td><input type="text" class="form-control" name="diklat_fungsional_nama[]"></td>'+
					'	<td colspan="2"><input type="text" class="form-control" name="diklat_fungsional_penyelenggara[]"></td>'+
					'	<td><input type="text" class="form-control" name="diklat_fungsional_durasi[]"></td>'+
					'	<td><input type="text" class="form-control" name="diklat_fungsional_nomor[]"></td>'+
					'	<td><input type="file" class="form-control" name="diklat_fungsional_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteDiklat_fungsional('+numdiklat_fungsional+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-diklat_fungsional').append(html);
		numdiklat_fungsional++;
	}

	function deleteDiklat_fungsional(no) {
		$('#tr-diklat_fungsional-'+no).remove();
	}

	var numkarya_tulis = Number(<?= count($karya_tulis)+1 ?>);
	function addKarya_tulis() {
		var html =  '<tr id="tr-karya_tulis-'+numkarya_tulis+'">'+
					'	<td>'+numkarya_tulis+'.</td>'+
					'	<td><input type="text" class="form-control" name="karya_tulis_judul[]"></td>'+
					'	<td><input type="text" class="form-control" name="karya_tulis_tahun[]"></td>'+
					'	<td><input type="file" class="form-control" name="karya_tulis_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteKarya_tulis('+numkarya_tulis+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-karya_tulis').append(html);
		numkarya_tulis++;
	}

	function deleteKarya_tulis(no) {
		$('#tr-karya_tulis-'+no).remove();
	}

	var numpengalaman_pembicara = Number(<?= count($pengalaman_pembicara)+1 ?>);
	function addPengalaman_pembicara() {
		var html =  '<tr id="tr-pengalaman_pembicara-'+numpengalaman_pembicara+'">'+
					'	<td>'+numpengalaman_pembicara+'.</td>'+
					'	<td><input type="text" class="form-control" name="pengalaman_pembicara_acara[]"></td>'+
					'	<td><input type="text" class="form-control" name="pengalaman_pembicara_penyelenggara[]"></td>'+
					'	<td><input type="text" class="form-control" name="pengalaman_pembicara_periode[]"></td>'+
					'	<td><input type="text" class="form-control" name="pengalaman_pembicara_lokasi[]"></td>'+
					'	<td><input type="file" class="form-control" name="pengalaman_pembicara_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deletePengalaman_pembicara('+numpengalaman_pembicara+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-pengalaman_pembicara').append(html);
		numpengalaman_pembicara++;
	}

	function deletePengalaman_pembicara(no) {
		$('#tr-pengalaman_pembicara-'+no).remove();
	}

	var numreferensi = Number(<?= count($referensi)+1 ?>);
	function addReferensi() {
		var html =  '<tr id="tr-referensi-'+numreferensi+'">'+
					'	<td>'+numreferensi+'.</td>'+
					'	<td><input type="text" class="form-control" name="referensi_nama[]"></td>'+
					'	<td><input type="text" class="form-control" name="referensi_perusahaan[]"></td>'+
					'	<td><input type="text" class="form-control" name="referensi_jabatan[]"></td>'+
					'	<td><input type="text" class="form-control" name="referensi_no_telp[]"></td>'+
					'	<td><input type="file" class="form-control" name="referensi_file[]"></td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteReferensi('+numreferensi+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-referensi').append(html);
		numreferensi++;
	}

	function deleteReferensi(no) {
		$('#tr-referensi-'+no).remove();
	}

	var numpasangan = Number(<?= count($pasangan)+1 ?>);
	function addPasangan() {
		var html =  '<tr id="tr-pasangan-'+numpasangan+'">'+
					'	<td>'+numpasangan+'.</td>'+
					'	<td><input type="text" class="form-control" name="pasangan_nama[]"></td>'+
					'	<td><input type="text" class="form-control" name="pasangan_tempat_lahir[]"></td>'+
					'	<td><input type="text" class="form-control tgl" name="pasangan_tanggal_lahir[]"></td>'+
					'	<td><input type="text" class="form-control tgl" name="pasangan_tanggal_menikah[]"></td>'+
					'	<td><input type="text" class="form-control" name="pasangan_tanggal_pekerjaan[]"></td>'+
					'	<td><input type="text" class="form-control" name="pasangan_tanggal_keterangan[]"></td>'+
					'	<td class="row-file-pasangan">'+
					'<div class="form-group">'+
						'<div class="col-md-5 no-padding">'+
							'<input type="text" class="form-control nama-file" name="pasangan_nama_file_0[]">'+
						'</div>'+
						'<div class="col-md-5 no-padding">'+
							'<input type="hidden" class="file-old" name="pasangan_old_0[]" value="">'+
				    		'<input type="file" class="form-control file" name="pasangan_file_0[]">'+
						'</div>'+
						'<div class="col-md-2 no-padding">'+
							'<button type="button" class="btn btn-primary" onclick="addFilePasangan($(this))"><i class="fa fa-plus"></i></button>'+
						'</div>'+
						'<div class="col-md-12 no-padding alert-file">'+
						'</div>'+
					'</div>'+
					'</td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deletePasangan('+numpasangan+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-pasangan').append(html);
		numpasangan++;
		incrementFilePasangan();

		$('.tgl').datepicker({
	      autoclose: true,
	      format:'yyyy-mm-dd'
	    });
	}

	function deletePasangan(no) {
		$('#tr-pasangan-'+no).remove();
		incrementFilePasangan();
	}

	var numanak = Number(<?= count($anak)+1 ?>);
	function addAnak() {
		var html =  '<tr id="tr-anak-'+numanak+'">'+
					'	<td>'+numanak+'.</td>'+
					'	<td><input type="text" class="form-control" name="anak_nama[]"></td>'+
					'	<td><input type="text" class="form-control" name="anak_tempat_lahir[]"></td>'+
					'	<td><input type="text" class="form-control tgl" name="anak_tanggal_lahir[]"></td>'+
					'	<td>'+
					'		<select name="anak_jenis_kelamin[]" class="form-control">'+
					'			<option value="">--Jenis Kelamin--</option>'+
					'			<option>Laki-laki</option>'+
					'			<option>Perempuan</option>'+
					'		</select>'+
					'	</td>'+
					'	<td><input type="text" class="form-control" name="anak_tanggal_pekerjaan[]"></td>'+
					'	<td><input type="text" class="form-control" name="anak_tanggal_keterangan[]"></td>'+
					'	<td class="row-file-anak">'+
						'<div class="form-group">'+
						'<div class="col-md-5 no-padding">'+
							'<input type="text" class="form-control nama-file" name="anak_nama_file_0[]">'+
						'</div>'+
						'<div class="col-md-5 no-padding">'+
							'<input type="hidden" class="file-old" name="anak_old_0[]" value="">'+
				    		'<input type="file" class="form-control file" name="anak_file_0[]">'+
						'</div>'+
						'<div class="col-md-2 no-padding">'+
							'<button type="button" class="btn btn-primary" onclick="addFileAnak($(this))"><i class="fa fa-plus"></i></button>'+
						'</div>'+
						'<div class="col-md-12 no-padding alert-file">'+
						'</div>'+
					'</div>'+
					'</td>'+
					'	<td>'+
					'		<button type="button" class="btn btn-danger" onclick="deleteAnak('+numanak+')"><i class="fa fa-minus"></i></button>'+
					'	</td>'+
					'</tr>';
		$('#ktk-anak').append(html);
		numanak++;

		$('.tgl').datepicker({
	      autoclose: true,
	      format:'yyyy-mm-dd'
	    });
	}

	function deleteAnak(no) {
		$('#tr-anak-'+no).remove();
		incrementFileAnak();
	}

	function cetakDetail()
	{
		let tanggal_print = $("#tanggal_print").val()
		let lokasi = $("#lokasi").val()
		let url = '<?= base_url('digitalisasi_cv/detail_print/'.$this->template->sonEncode($data['cv_id'])) ?>?tanggal_print='+tanggal_print+'&lokasi='+lokasi
		window.open(url,"_blank")
	}
	$(function() {
            $(".tab_content").hide(); //Hide all content
            //On Click Event (left standart)
            $("ul.tabs li").click(function() {

                $("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(".tab_content").hide(); //Hide all tab content
                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
            });


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