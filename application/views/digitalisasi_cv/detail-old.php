<style>
	.mg-5{
		margin-left: -5px !important;
		margin-right: -5px !important;
	}
	.mg-5>.col-md-3 , .mg-5>.col-md-9{
		padding-left: 5px !important;
		padding-right: 5px !important;
	}
	.table-custom>tbody>tr>td , .table-custom>tbody>tr>th{
		border: 1px solid #7d7d7d;
		vertical-align: middle;
	}
	.table-custom>tbody+tbody{
		border:none;
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
				<div class="box box-primary">
					<div class="box-header with-border">
						<!-- <h3 class="box-title">Detail Digitalisasi CV</h3> -->
					</div>
					<!-- /.box-header -->
						<div class="box-body">
							<a href="<?= base_url('digitalisasi_cv/detail_print/'.$this->template->sonEncode($data['cv_id'])) ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
							<a href="#modal-akses" data-toggle="modal" class="btn btn-warning"><i class="fa fa-users"></i> Akses</a>

							<h4 class="text-center" style="text-decoration: underline;font-weight: bold">DAFTAR RIWAYAT HIDUP</h4>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="4"><b>I. KETERANGAN PERERORANGAN</b></td>
								</tr>
								<tr>
									<td style="width: 1px;">1.</td>
									<td style="width: 170px;">Nama Lengkap</td>
									<td><?= $data['cv_nama'] ?></td>
									<td rowspan="12" style="width: 1px;vertical-align: top;">
										<img src="<?= base_url($data['cv_gambar']) ?>" alt="" style="width: 204px;height: 322px;border:1px solid #7b7b7b;margin-bottom: 10px;object-fit: cover;" id="img-cv">
									</td>
								</tr>
								<tr>
									<td>2.</td>
									<td>Gelar Akademik</td>
									<td>
										<table class="table table-condensed" id="ktk-akademik" style="margin-bottom: 0px;">
											<?php 
											$akademik = json_decode($data['cv_gelar_akademik'],true);
											foreach ($akademik as $key => $value): ?>
											<tr>
												<td style="vertical-align: middle;width: 100px;">Srata <?= $key+1 ?></td>
												<td style="width: 1px;">:</td>
												<td><?= $value ?></td>
											</tr>
											<?php endforeach ?>
										</table>
									</td>
								</tr>
								<tr>
									<td>3.</td>
									<td style="width: 170px;">NIK</td>
									<td><?= $data['cv_nik'] ?></td>
								</tr>
								<tr>
									<td>4.</td>
									<td style="width: 170px;">Tempat, Tanggal Lahir</td>
									<td>
										<?= $data['cv_tempat_lahir'] ?>, 
										<?= $data['cv_tanggal_lahir'] ?>
									</td>
								</tr>
								<tr>
									<td>5.</td>
									<td style="width: 170px;">Jenis Kelamin</td>
									<td>
										<?= $data['cv_jenis_kelamin'] ?>
									</td>
								</tr>
								<tr>
									<td>6.</td>
									<td style="width: 170px;">Agama</td>
									<td>
										<?= $data['cv_agama'] ?>
									</td>
								</tr>
								<tr>
									<td>7.</td>
									<td style="width: 170px;">Jabatan Terakhir</td>
									<td><?= $data['cv_jabatan_terakhir'] ?></td>
								</tr>
								<tr>
									<td>8.</td>
									<td style="width: 170px;">Alamat Rumah</td>
									<td><?= $data['cv_alamat_rumah'] ?></td>
								</tr>
								<tr>
									<td>9.</td>
									<td style="width: 170px;">HP</td>
									<td><?= $data['cv_hp'] ?></td>
								</tr>
								<tr>
									<td>10.</td>
									<td style="width: 170px;">E-mail</td>
									<td><?= $data['cv_email'] ?></td>
								</tr>
								<tr>
									<td>11.</td>
									<td style="width: 170px;">NPWP</td>
									<td><?= $data['cv_npwp'] ?></td>
								</tr>
								<tr>
									<td>12.</td>
									<td style="width: 170px;">Alamat Social Media</td>
									<td><?= $data['cv_alamat_social_media'] ?></td>
								</tr>
							</table>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td>
										<b>II. SUMMARY</b> <br>
										<em>(Menggambarkan pernyataan misi pribadi & keahlian atau kompetensi yang dikuasai)</em>
									</td>
								</tr>
								<tr>
									<td>
										<?= $data['cv_summary'] ?>
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
										<?= $data['cv_interest'] ?>
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
												<?= $data['cv_permintaan_posisi_direktur_lain'] ?>
											</td>
										<?php } else { ?>
											<td><?= $value ?></td>
											<td style="text-align: center;width: 80px;">
												<?php if (in_array($value, $permintaan_posisi_direktur)): ?>
													<i class="fa fa-check"></i>
												<?php endif ?>
											</td>
										<?php } ?>
									<?php } ?>
								</tr>
								<?php } ?>
							</table>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="6">
										<b>V. RIWAYAT JABATAN</b>
									</td>
								</tr>
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody>
									<?php 
									$riwayat_jabatan = json_decode($data['cv_riwayat_jabatan'],true);
									foreach ($riwayat_jabatan as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['jabatan'] ?></td>
										<td><?= $value['uraian'] ?></td>
										<td><?= $value['rentang_waktu'] ?></td>
										<td><?= $value['achievement'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody id="ktk-penugasan">
									<?php 
									$penugasan = json_decode($data['cv_penugasan'],true);
									foreach ($penugasan as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['penugasan'] ?></td>
										<td><?= $value['tupoksi'] ?></td>
										<td><?= $value['rentang_waktu'] ?></td>
										<td><?= $value['instansi'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="6">
										<b>VI. KEANGGOTAAN ORGANISASI PROFESI/ KOMUNITAS YANG DIIKUTI</b>
									</td>
								</tr>
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody id="ktk-organisasi_pekerjaan">
									<?php 
									$organisasi_pekerjaan = json_decode($data['cv_organisasi_pekerjaan'],true);
									foreach ($organisasi_pekerjaan as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td><?= $value['jabatan'] ?></td>
										<td><?= $value['rentang_waktu'] ?></td>
										<td><?= $value['uraian'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody id="ktk-organisasi_nonformal">
									<?php 
									$organisasi_nonformal = json_decode($data['cv_organisasi_nonformal'],true);
									foreach ($organisasi_nonformal as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td><?= $value['jabatan'] ?></td>
										<td><?= $value['rentang_waktu'] ?></td>
										<td><?= $value['uraian'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody id="ktk-penghargaan">
									<?php 
									$penghargaan = json_decode($data['cv_penghargaan'],true);
									foreach ($penghargaan as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['jenis'] ?></td>
										<td><?= $value['tingkat'] ?></td>
										<td><?= $value['diberikan_oleh'] ?></td>
										<td><?= $value['tahun'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
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
										<b>VIII. RIWAYAT PENDIDIKAN DAN PELATIHAN</b>
									</td>
								</tr>
								<tr style="background: #ddd;">
									<td colspan="7">
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
								</tr>
								<tbody id="ktk-pendidikan_formal">
									<?php 
									$pendidikan_formal = json_decode($data['cv_pendidikan_formal'],true);
									foreach ($pendidikan_formal as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['jenjang'] ?></td>
										<td><?= $value['perguruan_tinggi'] ?></td>
										<td><?= $value['tahun_lulus'] ?></td>
										<td><?= $value['kota'] ?></td>
										<td><?= $value['penghargaan'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tr style="background: #ddd;">
									<td colspan="7">
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
								</tr>
								<tr>
									<td>A.</td>
									<td colspan="6" style="text-decoration: underline;"><b>DIKLAT JABATAN</b></td>
								</tr>
								<tbody id="ktk-diklat_jabatan">
									<?php 
									$diklat_jabatan = json_decode($data['cv_diklat_jabatan'],true);
									foreach ($diklat_jabatan as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td colspan="2"><?= $value['penyelenggara'] ?></td>
										<td><?= $value['durasi'] ?></td>
										<td><?= $value['nomor_sertifikat'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tr>
									<td>B.</td>
									<td colspan="6" style="text-decoration: underline;"><b>DIKLAT FUNGSIONAL</b></td>
								</tr>
								<tbody id="ktk-diklat_fungsional">
									<?php 
									$diklat_fungsional = json_decode($data['cv_diklat_fungsional'],true);
									foreach ($diklat_fungsional as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td colspan="2"><?= $value['penyelenggara'] ?></td>
										<td><?= $value['durasi'] ?></td>
										<td><?= $value['nomor_sertifikat'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<span><em>** Tingkat : Organisasi Kerja, Nasional, Internasional</em></span>
							<br>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="4">
										<b>IX. KARYA TULIS (dalam 5 tahun terakhir)</b> <br>
									</td>
								</tr>
								<tr style="background: #eee;">
									<th style="text-align: center;">No</th>
									<th style="text-align: center;">Judul dan Media Publikasi</th>
									<th style="text-align: center;">Tahun</th>
									<th style="text-align: center;width: 250px;">File</th>
								</tr>
								<tbody id="ktk-karya_tulis">
									<?php 
									$karya_tulis = json_decode($data['cv_karya_tulis'],true);
									foreach ($karya_tulis as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['judul'] ?></td>
										<td><?= $value['tahun'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody id="ktk-pengalaman_pembicara">
									<?php 
									$pengalaman_pembicara = json_decode($data['cv_pengalaman_pembicara'],true);
									foreach ($pengalaman_pembicara as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['acara'] ?></td>
										<td><?= $value['penyelenggara'] ?></td>
										<td><?= $value['periode'] ?></td>
										<td><?= $value['lokasi'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<br>
							<table class="table table-bordered table-condensed table-custom">
								<tr style="background: #ddd;">
									<td colspan="6">
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
								</tr>
								<tbody id="ktk-referensi">
									<?php 
									$referensi = json_decode($data['cv_referensi'],true);
									foreach ($referensi as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td><?= $value['perusahaan'] ?></td>
										<td><?= $value['jabatan'] ?></td>
										<td><?= $value['no_telp'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
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
										<b>XII. KETERANGAN KELUARGA*</b>
									</td>
								</tr>
								<tr style="background: #ddd;">
									<td colspan="8">
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
									<th style="text-align: center;width: 250px;">File</th>
								</tr>
								<tbody id="ktk-pasangan">
									<?php 
									$pasangan = json_decode($data['cv_pasangan'],true);
									foreach ($pasangan as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td><?= $value['tempat_lahir'] ?></td>
										<td><?= $value['tanggal_lahir'] ?></td>
										<td><?= $value['tanggal_menikah'] ?></td>
										<td><?= $value['pekerjaan'] ?></td>
										<td><?= $value['keterangan'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tr style="background: #ddd;">
									<td colspan="8">
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
								</tr>
								<tbody id="ktk-anak">
									<?php 
									$anak = json_decode($data['cv_anak'],true);
									foreach ($anak as $key => $value): ?>
									<tr>
										<td><?= $key+1 ?>.</td>
										<td><?= $value['nama'] ?></td>
										<td><?= $value['tempat_lahir'] ?></td>
										<td><?= $value['tanggal_lahir'] ?></td>
										<td><?= $value['jenis_kelamin'] ?></td>
										<td><?= $value['pekerjaan'] ?></td>
										<td><?= $value['keterangan'] ?></td>
										<td>
											<?php if ($value['file']){ ?>
												<a href="<?= base_url($value['file']) ?>"><i class="fa fa-download"></i> Download</a>
											<?php } else { ?>
												-
											<?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>

						</div>
					<!-- /.box-body -->
					<!-- /.box-footer -->
				</div>
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
					<label>CV ini dapat dilihat oleh :</label>
					<select name="akses[]" class="form-control select2" multiple style="width: 100%;">
						<?php 
						$this->db->select('cva_id_user');
						$cvakses = $this->mymodel->selectWhere('cv_akses',array('cva_id_cv'=>$data['cv_id']));
						$idselect = [];
						foreach ($cvakses as $key => $value) {
							$idselect[] = $value['cva_id_user'];
						}
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