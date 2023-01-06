<div class="content-wrapper" style="background-color: #F5F7FF;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?= $page_name ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url('arsip_dokumen') ?>"><i class="fa fa-dashboard"></i> List Surat</a></li>
			<li class="active"><?= $page_name ?></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">				
				<?= $view_menu ?>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-12">
				<div class="alert alert-info">
					Arsip Surat <?= $data->status ?>
				</div>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Detail Surat</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-8">
								<table class="table-condensed">
									<tbody>
										<tr>
											<td style="max-width: 250px">Nomor Surat</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_nomorsurat ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Tanggal Surat</td>
											<td style="width: 15px;"> : </td>
											<td>
												<?= $this->template->datebahasaindo($data->ad_tanggalsurat) ?>
												<?php 
												$role_user = $this->session->userdata('role_slug');
												$jabatan_user = $this->session->userdata('jabatan');
												$departement_user = $this->session->userdata('departement');
												if(
													$data->ad_tipesurat == 'Surat Keluar' AND
													$data->ad_tsk_id == 1 AND
													(
														$role_user == 'super_admin' OR
														(
															$role_user == 'kepala_departemen' AND
															$jabatan_user == 'Admin Department Head'
														)
													)

												):
												?>
													<button type="button" class="btn btn-xs btn-primary" onclick="showModalEditTanggalSurat(<?= $data->ad_id ?>)">
														<i class="fa fa-edit"></i> Ubah Tanggal Surat
													</button>
												<?php 
												endif;
												?>
											</td>
										</tr>
										<?php 
											if($data->ad_tipesurat =='Surat Masuk'):
										?>
										<tr>
											<td style="max-width: 150px">Tanggal Surat Diterima</td>
											<td style="width: 15px;"> : </td>
											<td><?= $this->template->datebahasaindo($data->ad_tanggalsuratditerima) ?></td>
										</tr>
										<?php 
											endif;
										?>
										<tr>
											<td style="max-width: 150px">Tipe Surat</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_tipesurat ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Instansi Pengirim</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_instansipengirim ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Sifat Surat</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_sifatsurat ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Bentuk Dokumen</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_bentukdokumen ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Kategori Surat</td>
											<td style="width: 15px;"> : </td>
											<td>
												<?php 
												$this->db->select('GROUP_CONCAT(add_nama_departement) as departement');
												$this->db->where('add_id_arsip_dokumen',$data->ad_id);
												$nama_departement = $this->db->get('arsip_dokumen_departement')->row()->departement;
												if($data->ad_tipesurat =='Surat Masuk'){
													$role_user = $this->session->userdata('role_slug');
													if($nama_departement=='' AND $role_user == 'kepala_divisi' ){
														// echo '<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-kategori"><i class="fa fa-edit"></i> Input Kategori</button>';
														echo $nama_departement;
													}else{
														
														echo $nama_departement;
													}
													

												}else{
													echo $nama_departement;
												}
												

												?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Perihal</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_perihal ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">File Surat</td>
											<td style="width: 15px;"> : </td>
											<td>
												<a href="<?= $data->ad_lampiran ?>" class="btn btn-xs btn-info"><i class="fa fa-download"></i> Lampiran</a>
												<?php 
												if($role_user == 'super_admin' AND $data->ad_tipesurat == 'Surat Keluar' AND $data->ad_lampiran ==''):    
												?>
												    <a href="<?= base_url("arsip_dokumen/addSuratKeluar/".$data->ad_id) ?>" class="btn btn-xs btn-info"><i class="fa fa-upload"></i> Upload Ulang Lampiran</a>    
												<?php 
												endif;
												?>
											</td>
										</tr>
										<?php 
										if($data->ad_lampiran_password !=''):
										?>
										<tr>
											<td style="max-width: 150px">Password</td>
											<td style="width: 15px;"> : </td>
											<td>
												<span id="password_surat">**********</span>
												<button onclick='$("#modal-lihat-password").modal()' type="button" class="btn btn-xs btn-danger btn-lihat-password">
													<i class="fa fa-eye"></i> Lihat Password
												</button>
												<button onclick='copyPassword()' type="button" class="btn btn-xs btn-success btn-copy-password hide">
													<i class="fa fa-clipboard"></i> Salin Password
												</button>
											</td>
										</tr>
										<?php 
										endif;
										?>
										<!-- <?php
										if($data->status == 'ditindaklanjuti'){
										?>
										<tr>
											<td style="max-width: 150px">Catatan Tindak Lanjut</td>
											<td style="width: 15px;"> : </td>
											<td><?= $data->ad_tindaklanjut ?></td>
										</tr>
										<tr>
											<td style="max-width: 150px">Dokumen Tindak Lanjut</td>
											<td style="width: 15px;"> : </td>
											<td>
												<?php
												if(!empty($data->ad_file_tindaklanjut)){
												?>
												<a href="<?= base_url().$data->ad_file_tindaklanjut ?>" target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Lampiran</a>
												<?php
												}
												else{
													?>
													<label class="label label-danger">File Tidak Ada</label>
													<?php
												}
												?>
											</td>
										</tr>
										<?php
									}
										?> -->
									</tbody>
								</table>
								
							</div>
							<div class="col-md-4">
								<?php 
								$txtbtn = 'Disposisi';
								if ($this->session->userdata('role_slug')=='super_admin' || $this->session->userdata('role_slug')=='sekretaris_divisi') {
									$txtbtn = 'Teruskan';
								}

								$link = base_url('arsip_dokumen/detail/'.$this->template->sonEncode($data->ad_id).'?source=qrcode');
								$logo = 'http://digitalcorsec.id/assets/logo_bri.png';
								if($data->ad_tipesurat == 'Surat Masuk'){
								?>
								<img src="<?= 'http://dev.alfahuma.tech/generate_qrcode.php?qr_content='.$link.'&qr_logo='.$logo ?>" alt="" style="width: 100px;">
								<?php 
								}
								$showdisposisi = 'no';
								// if (($this->session->userdata('role_slug')=='super_admin' || $this->session->userdata('role_slug')=='sekretaris_divisi') && $data->status=='diajukan') {
								if ((in_array($this->session->userdata('role_slug'), ['super_admin','kepala_departemen','team_leader'])) && $data->status!='ditindaklanjuti') {
									$showdisposisi = 'yes';
								} else {
									$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "'.$this->session->userdata('id').'"');
									$log = $this->mymodel->selectDataone('arsip_dokumen_log',array('adl_isaktif'=>1,'adl_id_arsip_dokumen'=>$data->ad_id));
									if (count($log)>0) {
										$showdisposisi = 'yes';
									}
								}

								if ($this->session->userdata('role_slug')=='officer' AND (!in_array($this->session->userdata('jabatan'), ['Sekretaris' ,'Sekretaris Direksi']))) {
									$showdisposisi = 'no';
								}
								?>
								<div style="margin-bottom: 10px;margin-top: 10px;">
									Status : <span class="badge badge-red"><?= ucfirst($data->status) ?></span> <br>
									Message : <span class="badge badge-red"><?= $data->status_message ?></span>
								</div>
								<?php 
								if($data->ad_tipesurat == 'Surat Masuk'){
								if ($showdisposisi=='yes' AND $data->status !='draft'){ 
									if($txtbtn == 'Disposisi' AND $data->status == 'didisposisikan'){
										$txtbtn = 'Tambah Disposisi';
									}
									?>
								<div class="btn btn-primary" data-toggle="modal" data-target="#<?= ($nama_departement=='' AND $role_user == 'kepala_divisi' ) ? 'modal-disposisi-kepala-divisi' : 'modal-disposisi'  ?>"><i class="fa fa-share"></i> <?= $txtbtn ?></div>
								<?php } 
								else if($this->session->userdata('role_slug')=='officer' && (!in_array($this->session->userdata('jabatan'), ['Sekretaris' ,'Sekretaris Direksi']))  && $data->status != 'ditindaklanjuti'){
										$this->db->select('arsip_dokumen_log_detail.* , user.name as nama_penerima , user_pengirim.name as nama_pengirim');
										$this->db->join('user', 'user.id = arsip_dokumen_log_detail.adld_id_penerima', 'left');
										$this->db->join('user user_pengirim', 'user_pengirim.id = arsip_dokumen_log_detail.adld_id_pengirim', 'left');
										$tindak_lanjut = $this->mymodel->selectDataone('arsip_dokumen_log_detail',array('adld_id_arsip_dokumen_log'=>$list_tindak_lanjut['adl_id'],'adld_id_penerima'=>$this->session->userdata('id')));
										if($tindak_lanjut['adld_is_tindaklanjut']==0):
									?>
									<div class="btn btn-primary" data-toggle="modal" data-target="#modal-tindaklanjut"><i class="fa fa-share"></i> Tindak Lanjuti</div>
									<?php
										endif; 
									?>
									<?php
								}
							}
								?>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<!-- /.box-footer -->
				</div>
				<?php 
				if(count($list_lampiran)>0){
				?>

				<div class="panel panel-primary">
					<div class="panel-heading">
						<?php 
						if(
							$this->session->userdata('role_slug')=='super_admin' OR 
							$this->session->userdata('role_slug')=='kepala_departemen' OR
							$this->session->userdata('role_slug')=='sekretaris_divisi' OR
							in_array($this->session->userdata('jabatan'), ['Sekretaris','Sekretaris Direksi'])
						):
						?>
							<div class="pull-right">
								<button type="button" class="btn btn-success btn-xs" onclick="showModalTambahLampiran(<?= $data->ad_id  ?>)">
									<i class="fa fa-plus"></i> Tambah Lampiran
								</button>
							</div>
						<?php 
						endif;
						?>
						Lampiran
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table-lampiran">
								<thead>
									<tr>
										<th>Dokumen</th>
										<th width="100">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($list_lampiran as $lampiran):
									?>
										<tr>
											<td><?= $lampiran['keterangan'] ?></td>
											<td>
												<div style="margin-bottom: 10px;">
												<a style="width: 100%;" target="_blank" href="<?= $lampiran['path'] ?>" class="btn btn-xs btn-primary">
													<i class="fa fa-file-pdf-o"></i> Unduh Lampiran
												</a>
												<?php 
												if(
													$this->session->userdata('role_slug')=='super_admin' OR
													$this->session->userdata('role_slug')=='sekretaris_divisi' OR
													in_array($this->session->userdata('jabatan'), ['Sekretaris','Sekretaris Direksi'])
												):
												?>
													<button style="width: 100%;"  class="btn btn-xs btn-info" onclick="showModalEditLampiran(<?= $lampiran['id'] ?>,'<?= $lampiran['keterangan'] ?>')">
														<i class="fa fa-file-pdf-o"></i> Ubah Lampiran
													</button>
												<?php 
												endif;	
												?>
												<?php 
												if($lampiran['password']!=''):
												?>
													<span class="hide" id="password_lampiran"></span>	
													<button onclick='$("#modal-lihat-password-lampiran").modal();$("#id_lampiran").val(<?= $lampiran['id'] ?>).change();' style="width: 100%;" type="button" class="btn btn-xs btn-danger">
														<i class="fa fa-clipboard"></i> Salin Password
													</button>
												<?php 
												endif;
												?>
												</div>
											</td>
										</tr>
									<?php 
										endforeach;
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php 
					}
				?>
				<?php
				if($data->ad_tipesurat == 'Surat Masuk'){
				?>
				<?php 
				if(($data->status == 'didisposisikan' OR $data->status == 'ditindaklanjuti') AND count($list_tindak_lanjut) >0 ):
					$this->db->select('arsip_dokumen_log_detail.* , user.id as id_penerima ,user.name as nama_penerima , user_pengirim.name as nama_pengirim,user.role_slug as role_penerima');
					$this->db->join('user', 'user.id = arsip_dokumen_log_detail.adld_id_penerima', 'left');
					$this->db->join('user user_pengirim', 'user_pengirim.id = arsip_dokumen_log_detail.adld_id_pengirim', 'left');
					$this->db->where_in('user.role_slug',['officer','team_leader']);
					$this->db->group_by('adld_id_penerima');
					$this->db->order_by('adld_id','DESC');
					$data_detail_tindak_lanjut = $this->mymodel->selectWhere('arsip_dokumen_log_detail',array(
						'adld_id_arsip_dokumen'=>$list_tindak_lanjut['adl_id_arsip_dokumen'],
						// 'adld_id_arsip_dokumen_log'=>$list_tindak_lanjut['adl_id']
					));

					// $this->db->order_by('adld_id','DESC');
					// dump_variable($list_tindak_lanjut);
					$check_penerima = $this->db->get_where('user',['name'=>$data_detail_tindak_lanjut[0]['nama_penerima']])->row()->role_slug;
					if($check_penerima=='officer' || $check_penerima == 'team_leader'):
					
				?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<?php 
							if(in_array($this->session->userdata('role_slug'), ['super_admin','kepala_departemen','sekretaris_divisi','team_leader'])):
						?>
						<div class="pull-right">	
								<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-tindaklanjut"><i class="fa fa-plus"></i>Tambah Tindak Lanjut</button>
						</div>
						<?php 
							endif;
						?>
						Tindak Lanjut Officer
					</div>

					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table-lampiran-tindaklanjut">
								<thead>
									<tr>
										<th>Nama Pegawai</th>
										<th>Status Tindak Lanjut</th>
										<th>Catatan </th>
										<th>File</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($data_detail_tindak_lanjut as $detail_tindak_lanjut):
										if(in_array($detail_tindak_lanjut['role_penerima'], ['officer','super_admin','kepala_departemen','sekretaris_divisi','team_leader'])):
											$lampiran_tindaklanjut = $this->db->get_where('lampiran_tindaklanjut',['adld_id'=>$detail_tindak_lanjut['adld_id']])->result_array();
									?>
										<tr>
											<td><?= $detail_tindak_lanjut['nama_penerima'] ?></td>
											<td>
												<?= 
													($detail_tindak_lanjut['adld_is_tindaklanjut']>0) ?
													'<label class="label label-success">Sudah</label>' : 
													'<label class="label label-danger">Belum</label>'
												?>
											</td>
											<td>
												<?php 
												if(count($lampiran_tindaklanjut)>0):
												?>
													<table border="0">
														<?php 
														foreach($lampiran_tindaklanjut as $tindak):
														?>
															<tr>
																<td><?= $tindak['catatan_tindaklanjut'] ?></td>
															</tr>
														<?php 
														endforeach;
														?>
													</table>
												<?php 
												endif;
												?>
											</td>
											<td>

												<?php 
												if(count($lampiran_tindaklanjut)>0):
												?>
													<table border="0">
														<?php 
														foreach($lampiran_tindaklanjut as $tindak):
														?>
															<tr>
																<td>
																	<?php
																	if($tindak['file_tindaklanjut']!=''):
																		// $array_nama_file = explode('/', $tindak['file_tindaklanjut']);
																		// $nama_file =  $array_nama_file[2];
																		$nama_file = $data->ad_nomorsurat.'_lampiran_'.$tindak['catatan_tindaklanjut'].'.pdf';
																	?>
																		<a download="<?= $nama_file ?>" href="<?= base_url().$tindak['file_tindaklanjut'] ?>" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-download"></i> Unduh Lampiran</a>

																		<?php 
																		if($tindak['password_file']!=''):
																		?>	
																			<span id="password_tindaklanjut" class="hide"></span>
																			<button onclick='$("#modal-lihat-password-tindaklanjut").modal();$("#id_tindaklanjut").val(<?= $tindak['id'] ?>).change();' type="button" class="btn btn-danger btn-xs"><i class="fa fa-clipboard"></i> Salin Password</button>		
																		<?php 
																		endif;
																		?>
																	<?php 
																	else:
																	?>
																		<button style="width:100%" type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tidak Ada Lampiran</button>
																	<?php 
																	endif;
																	?>
																		
																</td>
															</tr>
														<?php 
														endforeach;
														?>
													</table>
												<?php 
												else:
												?>
													<table border="0">
															<tr>
																<td>
																	<button style="width:100%" type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tidak Ada Lampiran</button>
																</td>
															</tr>
													</table>
												<?php 
												endif;
												?>
												
											</td>
											<td>
												<?php 
													if($detail_tindak_lanjut['id_penerima'] == $this->session->userdata('id')):
												?>
													<button type="button" onclick="showModalEditTindakLanjut(<?= $detail_tindak_lanjut['adld_id'] ?>)" class="btn btn-info btn-xs" style="vertical-align: center;"> 
														<i class="fa fa-edit"></i> Edit
													</button>
												<?php 
													endif;
												?>
											</td>
										</tr>						
									<?php 
										endif;
									endforeach;
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php 
					endif;
				endif;
				?>
				<div class="box box-primary">
					<div class="box-header">
						<h4><b>Timeline</b></h4>
					</div>
					<div class="box-body">
						<!-- <div id="my_tree"></div> -->
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>Waktu</th>
									<th>Status</th>
									<th>Pengirim</th>
									<th>Penerima</th>
									<th>Isi Disposisi</th>
									<th>Departemen</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$timeline = $this->mymodel->selectWhere('arsip_dokumen_log',array('adl_id_arsip_dokumen'=>$data->ad_id));
								foreach ($timeline as $key => $value) {
									$this->db->select('arsip_dokumen_log_detail.* , user.name as nama_penerima , user_pengirim.name as nama_pengirim');
									$this->db->join('user', 'user.id = arsip_dokumen_log_detail.adld_id_penerima', 'left');
									$this->db->join('user user_pengirim', 'user_pengirim.id = arsip_dokumen_log_detail.adld_id_pengirim', 'left');
									$timeline_detail = $this->mymodel->selectWhere('arsip_dokumen_log_detail',array('adld_id_arsip_dokumen_log'=>$value['adl_id']));

									$status_surat = '';
									switch ($value['adl_status']) {
										case 'diajukan':
											$status_surat = 'Menunggu Disposisi';
											break;
										
										case 'didisposisikan':
											$status_surat = 'Telah Disposisi';
											break;
										case 'ditindaklanjuti':
											$status_surat = 'Telah Ditindaklanjuti';
											break;

										default:
											$status_surat = $value['adl_status'];
											break;
									}
								?>
								<tr>
									<td><?= $value['adl_waktu'] ?></td>
									<td><?= ucfirst($status_surat) ?></td>
									<td><?= $timeline_detail[0]['nama_pengirim'] ?></td>
									<td>
										<?php foreach ($timeline_detail as $keyd => $valued) { 
											$this->db->select('m_departemen.nama');
											$this->db->join('m_departemen','user.departemen = m_departemen.id');
											$this->db->where('user.name',$valued['nama_penerima']);
											$data_departemen= $this->db->get('user')->row_array();

											$eyecolor = '#ff4040';
											$icon = 'fa-envelope';
											if ($valued['adld_isread']==1) {
												$eyecolor = '#00c300';
												$icon = 'fa-envelope-open';
											}
											?>
											<span style="white-space: nowrap;">
												<i class="fa <?=$icon?>" style="color: <?= $eyecolor ?>"></i> <?= $valued['nama_penerima'] ?>
											</span>
											<br>
										<?php } ?>
									</td>
									<td><?= strip_tags($value['adl_isi_disposisi']) ?></td>
									<td>
										<?= $data_departemen['nama'] ?>
									</td>	
								</tr>	
								<?php } ?>
							</tbody>		
						</table>	
					</div>
				</div>
				<!-- /. box -->
				<?php
			}
				?>
			</div>
			<!-- /.col -->
			<div class="col-md-9"></div>
			<div class="col-md-3"><a href="<?= ($data->ad_tipesurat == 'Surat Keluar') ? base_url('arsip_dokumen/surat_keluar') : base_url('arsip_dokumen/surat_masuk') ?>" class="btn btn-default btn-block margin-bottom"><< Kembali Ke List Surat</a></div>
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<form action="<?=base_url()?>arsip_dokumen/aksiTindakLanjut_new" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menindaklanjuti Dokumen Ini')" enctype="multipart/form-data">
	<div class="modal fade" id="modal-tindaklanjut">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Tindak Lanjut</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" value="<?= $data->ad_id ?>">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed" id="table-tindak-lanjut">
							<thead>
								<tr>
									<th>Catatan</th>
									<th style="width:10px;">File</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td >
										<textarea required class="form-control" name="adld_catatan_tindaklanjut[]"></textarea>
									</td>
									<td>
										<input accept=".pdf" type="file" name="adld_file_tindaklanjut[]">
									</td>
									<td>
										<button type="button" onclick="addRow('table-tindak-lanjut')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
									</td>
								</tr>
							</tbody>
							
						</table>
					</div>
					<!-- <div class="form-group">
						<label>Catatan</label>
						<textarea class="form-control" name="adld_catatan_tindaklanjut"></textarea>
					</div>
					<div class="form-group">
						<label>Lampiran Tindak Lanjut</label>
						<input type="file" name="adld_file_tindaklanjut">
						<label class="text-red">*Opsional</label>
					</div> -->
				</div>
				<div class="modal-footer">
					<input type="hidden" name="adld_is_tindaklanjut" value="1">
					<input type="hidden" name="adld_id_arsip_dokumen_log" value="<?= $list_tindak_lanjut['adl_id'] ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Tindak Lanjuti</button>
				</div>
			</div>
		</div>
	</div>
</form>
<form action="<?=base_url()?>arsip_dokumen/editTindakLanjut" method="POST" enctype="multipart/form-data">
	<div class="modal fade" id="modal-edittindaklanjut">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Tindak Lanjut</h4>
				</div>
				<div class="modal-body">
					<div id="content-edit-tindaklanjut"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Tindak Lanjuti</button>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="modal fade" id="modal-lihat-password">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Lihat Password Lampiran</h4>
			</div>
			<div class="modal-body">
				<div id="content-response"></div>
				<label for="">Password Akun</label>
				<input type="password" id="check_password" class="form-control" placeholder="Masukkan password akun anda.">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" onclick="checkPassword()" class="btn btn-primary btn-check-password" >Check</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-lihat-password-lampiran">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Lihat Password Lampiran</h4>
			</div>
			<div class="modal-body">
				<div id="content-response-lampiran"></div>
				<label for="">Password Akun</label>
				<input type="password" id="check_password_lampiran" class="form-control" placeholder="Masukkan password akun anda.">
				<input type="hidden" id="id_lampiran">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" onclick="checkPasswordLampiran()" class="btn btn-primary btn-check-password" >Check</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-lihat-password-tindaklanjut">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Lihat Password Lampiran</h4>
			</div>
			<div class="modal-body">
				<div id="content-response-tindaklanjut"></div>
				<label for="">Password Akun</label>
				<input type="password" id="check_password_tindaklanjut" class="form-control" placeholder="Masukkan password akun anda.">
				<input type="hidden" id="id_tindaklanjut">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" onclick="checkPasswordTindakLanjut()" class="btn btn-primary btn-check-password" >Check</button>
			</div>
		</div>
	</div>
</div>
<form id="form-disposisi" action="<?= base_url('arsip_dokumen/aksiDisposisi') ?>" method="POST" >
<div id="modal-disposisi" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Form <?= $txtbtn ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="id" value="<?= $data->ad_id ?>">
						<table class="table table-bordered table-condensed table-hover table-striped" id="table-disposisi">
							<thead>
								<tr>
									<th>
										<?php 
										$text_title = 'Diteruskan';
										if($this->session->userdata('role_slug')=='kepala_divisi') $text_title = 'Didisposisikan';
										?>
										<b><?= $text_title ?> Kepada Yth.</b>
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$this->db->select('user.* , m_departemen.code');
								if ($this->session->userdata('role_slug')=='super_admin' || $this->session->userdata('role_slug')=='sekretaris_divisi' || $this->session->userdata('role_slug')=='kepala_departemen') {
									// $this->db->where_in('role_slug', ['kepala_divisi']);
								} elseif ($this->session->userdata('role_slug')=='kepala_divisi') {
									$this->db->where('role_slug', 'kepala_departemen');
									$this->db->where('jabatan','Department Head');
								} elseif ($this->session->userdata('role_slug')=='officer') {
									$this->db->where_in('role_slug', ['team_leader']);
								} elseif ($this->session->userdata('role_slug')=='team_leader') {
									$this->db->where_in('role_slug', ['officer']);
									// $this->db->where("user.id NOT IN (
									// 	SELECT adld_id_penerima from user
									// 	LEFT JOIN arsip_dokumen_log_detail ON arsip_dokumen_log_detail.adld_id_penerima = user.id
									// 	WHERE adld_id_arsip_dokumen = {$data->ad_id}
									// 	AND role_slug = 'officer'
									// ) ");
								} 
								$this->db->join('m_departemen', 'm_departemen.id = user.departemen', 'left');
								$disposisi = $this->mmodel->selectWhere('user',[])->result();
								foreach ($disposisi as $key => $value): ?>
									
									<tr>
										<td><?= $value->name ?> <?= ($value->role_slug=='kepala_departemen' || $value->role_slug=='team_leader' || $value->role_slug=='officer')?' - '.$value->code:''; ?> (<?= $value->jabatan ?>)</td>
										<td style="width: 15px;">
											<input type="checkbox" class="check-to" value="<?= $value->id ?>" name="to[]" required>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<br>
						<label for="">Isi Disposisi</label>
						<textarea name="isi_disposisi" id="disposisi" class="form-control" required></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-send-disposisi">Kirim</button>
			</div>
		</div>
	</div>
</div>
</form>

<form  action="<?= base_url('arsip_dokumen/editKategoriSurat') ?>" method="POST" onsubmit="return confirm('Apakah anda yakin akan menyimpan kategori surat ini?')" >
<div id="modal-kategori" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Input Kategori Surat</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="id" value="<?= $data->ad_id ?>">
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Kategori</label>
							<select class="form-control" name="ad_kategorisurat_id">
								<option value="">-- Pilih --</option>

								<?php 
								$departemen = $this->mymodel->selectWhere('m_departemen',array('status'=>'ENABLE'));
								foreach ($departemen as $key => $value): ?>
									<option value="<?= $value['id'] ?>" data-singkatan="<?= $value['code'] ?>" <?= ($arsip['ad_kategorisurat_id']==$value['id'])?'selected':''; ?>><?= $value['nama'] ?></option> 
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Input</button>
			</div>
		</div>
	</div>
</div>
</form>

<form id="form-disposisi-kepala-divisi" action="<?= base_url('arsip_dokumen/aksiDisposisiKepalaDivisi') ?>" method="POST" >
<div id="modal-disposisi-kepala-divisi" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Form <?= $txtbtn ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="id" value="<?= $data->ad_id ?>">
						<table class="table table-bordered table-condensed table-hover table-striped" id="table-disposisi-kepala-divisi">
							<thead>
								<tr>
									<th>
										<?php 
										$text_title = 'Diteruskan';
										if($this->session->userdata('role_slug')=='kepala_divisi') $text_title = 'Didisposisikan';
										?>
										<b><?= $text_title ?> Kepada Yth.</b>
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$list_departemen = $this->db->get_where('m_departemen',['status'=>'ENABLE'])->result_array();
								foreach ($list_departemen as $key => $departemen): ?>
									
									<tr>
										<td><?= $departemen['nama'] ?>  (<?= $departemen['code'] ?>)</td>
										<td style="width: 15px;">
											<input type="checkbox" class="check-to" value="<?= $departemen['id'] ?>" name="to[]" required>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<br>
						<label for="">Isi Disposisi</label>
						<textarea name="isi_disposisi" id="disposisi-kepala-divisi" class="form-control" required></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-send-disposisi-kepala-divisi">Kirim</button>
			</div>
		</div>
	</div>
</div>
</form>

<form action="<?= base_url('arsip-dokumen/tambahLampiran') ?>" method="POST" id="form-tambah-lampiran" enctype="multipart/form-data">
<div class="modal fade" id="modal-tambah-lampiran">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Tambah Lampiran</h4>
            </div>
            <div class="modal-body">
            	<div class="form-group">
            		<label>Lampiran</label> 
                	<input type="file" accept=".pdf" name="file" class="form-control" id="input-lampiran">
                	<p class="help-block" style="color: red">File yang diinputkan harus .pdf dan Max 30MB</p>
            	</div>
            	<div class="form-group">
	                <label>Keterangan</label> 
	                <input type="text" name="keterangan" class="form-control" id="input-keterangan">
	            </div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" name="id_arsip" id="id_arsip">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" onclick="uploadLampiran()" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
</form>
<form action="<?= base_url('arsip-dokumen/ubahLampiran') ?>" method="POST" id="form-tambah-lampiran" enctype="multipart/form-data">
<div class="modal fade" id="modal-ubah-lampiran">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ubah Lampiran</h4>
            </div>
            <div class="modal-body">
            	<div class="form-group">
            		<label>Lampiran</label> 
                	<input type="file" accept=".pdf" name="file" class="form-control" id="input-edit-lampiran">
                	<p class="help-block" style="color: red">File yang diinputkan harus .pdf dan Max 20MB</p>
            	</div>
            	<div class="form-group">
	                <label>Keterangan</label> 
	                <input type="text" name="keterangan" class="form-control" id="input-edit-keterangan">
	            </div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" name="id_lampiran" id="id_lampiran_edit">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
</form>

<form action="<?= base_url('arsip-dokumen/ubahTanggalSurat') ?>" method="POST" id="form-ubah-tanggal" enctype="multipart/form-data">
<div class="modal fade" id="modal-ubah-tanggal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ubah Tanggal Surat</h4>
            </div>
            <div class="modal-body">
            	<div class="form-group">
            		<label>Tanggal Surat</label> 
                	<input readonly class="form-control tgl" placeholder="Tanggal surat" name="tanggal_surat" value="<?= $data->ad_tanggalsurat ?>">
            	</div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" name="id_lampiran">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
</form>

<?php 
$timeline = $this->mymodel->selectWhere('arsip_dokumen_log',array('adl_id_arsip_dokumen'=>$data->ad_id));
$listtimeline = [];
$hirarkitimeline = [];
$numlist = 1;
$numhirarki = 1;
foreach ($timeline as $key => $value) {
	$this->db->join('user', 'user.id = arsip_dokumen_log_detail.adld_id_penerima', 'left');
	$timeline_detail = $this->mymodel->selectWhere('arsip_dokumen_log_detail',array('adld_id_arsip_dokumen_log'=>$value['adl_id']));
	foreach ($timeline_detail as $keyd => $valued) {
		$listtimeline[$numlist] = $valued['name'];
		$numlist++;
	}
	// $hirarkitimeline = 
}
?>
<script type="text/javascript">
	function checkForm()
	{
		let text_disposisi = $("#disposisi").val()
		if(trim(text_disposisi)==''){
			alert('Isi disposisi tidak boleh kosong');
			return false;
		}
	}
	$('.check-to:checkbox').click(function() {
		var jum = 0;
		$('.check-to:checkbox:checked').each(function () {
		   jum++;
		});
		if (jum>0) {
			$('.check-to:checkbox').removeAttr('required');
		} else {
			$('.check-to:checkbox').attr('required',true);
		}
	 });

	let table_disposisi = $("#table-disposisi").dataTable();
	
	$(".btn-send-disposisi").on('click', function(e){

       var $form = $("#form-disposisi")
    
       // Iterate over all checkboxes in the table
       table_disposisi.$('input[type="checkbox"]').each(function(){
          // If checkbox doesn't exist in DOM
          if(!$.contains(document, this)){
             // If checkbox is checked
             if(this.checked){
                // Create a hidden element 
                $form.append(
                   $('<input>')
                      .attr('type', 'hidden')
                      .attr('name', this.name)
                      .val(this.value)
                );
             }
          } 
       });
       let conf = confirm('Apakah anda yakin ingin mendisposisikan Dokumen ini ?')
       if(conf){
       		tinyMCE.triggerSave();
     		let text_disposisi = $("#disposisi").val()
			if(text_disposisi.trim()==''){
				alert('Isi disposisi tidak boleh kosong');
				return false;
			}else{
				let check_kategori = '<?= $nama_departement ?>'
				if(check_kategori=='0'){
					alert('Silahkan input kategori surat terlebih dahulu');
					return false;
				}else{
					$("#form-disposisi").submit()	
				}
				
			}
       }          
    });

    let table_disposisi_kepala_divisi = $("#table-disposisi-kepala-divisi").dataTable();
    $(".btn-send-disposisi-kepala-divisi").on('click', function(e){

       var $form = $("#form-disposisi-kepala-divisi")
    
       // Iterate over all checkboxes in the table
       table_disposisi_kepala_divisi.$('input[type="checkbox"]').each(function(){
          // If checkbox doesn't exist in DOM
          if(!$.contains(document, this)){
             // If checkbox is checked
             if(this.checked){
                // Create a hidden element 
                $form.append(
                   $('<input>')
                      .attr('type', 'hidden')
                      .attr('name', this.name)
                      .val(this.value)
                );
             }
          } 
       });
       let conf = confirm('Apakah anda yakin ingin mendisposisikan Dokumen ini ?')
       if(conf){
     		let text_disposisi = $("#disposisi-kepala-divisi").val()
			if(text_disposisi.trim()==''){
				alert('Isi disposisi tidak boleh kosong');
				return false;
			}else{
				$("#form-disposisi-kepala-divisi").submit()					
			}
       }          
    });
function addRow(id_table){
	$(`#${id_table} > tbody`).append(`
			<tr>
				<td >
					<textarea required class="form-control" name="adld_catatan_tindaklanjut[]"></textarea>
				</td>
				<td>
					<input type="file" accept=".pdf" name="adld_file_tindaklanjut[]">
				</td>
				<td>
					<button type="button" onClick="$(this).closest('tr').remove();" class="btn btn-danger btn-xs btn-hapus-tindaklanjut"><i class="fa fa-minus"></i></button>
				</td>
			</tr>
		`)
}
function addRowEdit(id_table){
	$(`#${id_table} > tbody`).append(`
			<tr>
				<td >
					<input name="id[]" value="" type="hidden">
					<input type="hidden" name="is_delete[]" value="n">
					<textarea required class="form-control" name="adld_catatan_tindaklanjut[]"></textarea>
				</td>
				<td>
					<input type="file" accept=".pdf" name="adld_file_tindaklanjut[]">
				</td>
				<td>
					<button type="button" onClick="$(this).closest('tr').remove();" class="btn btn-danger btn-xs btn-hapus-tindaklanjut"><i class="fa fa-minus"></i></button>
				</td>
			</tr>
		`)
}
function showModalEditTindakLanjut(adld_id)
{
	$("#content-edit-tindaklanjut").html('<i class="fa fa-loading fa-spin fa-spinner"></i> Loading').load(`<?= base_url("arsip_dokumen/contentModalEditTindakLanjut/")  ?>${adld_id}`)
	$("#modal-edittindaklanjut").modal()
}
function checkPassword()
{
	$(".btn-check-password").html('<i class="fa fa-loading fa-spinner fa-spin"></i> Loading')
	let check_password = $("#check_password").val()
	$.post('<?= base_url("Arsip_dokumen/checkPassword") ?>',{check_password:check_password},function(result){
		$("#content-response").html(result)
		if(result.indexOf("success") != -1){
			let id_surat ='<?= $this->template->sonEncode($data->ad_id)?>'
			let password = check_password
			$.post('<?= base_url("Arsip_dokumen/getPasswordLampiran") ?>',{id_surat:id_surat,password:password},function(result){
				if(result!=''){
					$("#password_surat").html(result)
					$(".btn-lihat-password").hide()
					$(".btn-copy-password").removeClass('hide')
					$("#modal-lihat-password").modal('hide')
				}
			})
		}
		$(".btn-check-password").html('Check')
	})
}

function checkPasswordTindakLanjut()
{
	$(".btn-check-password").html('<i class="fa fa-loading fa-spinner fa-spin"></i> Loading')
	let check_password = $("#check_password_tindaklanjut").val()
	$.post('<?= base_url("Arsip_dokumen/checkPassword") ?>',{check_password:check_password},function(result){
		$("#content-response-tindaklanjut").html(result)
		if(result.indexOf("success") != -1){
			let id_surat =$("#id_tindaklanjut").val()
			let password = check_password
			let url_tipe = 'tindak_lanjut'	
			$.post(`<?= base_url("Arsip_dokumen/getPasswordLampiran/") ?>${url_tipe}`,{id_surat:id_surat,password:password},function(result){
				if(result!=''){
					$("#password_tindaklanjut").html(result)
					$("#modal-lihat-password-tindaklanjut").modal('hide')
					copyPassword('password_tindaklanjut')
				}
			})
		}
		$(".btn-check-password").html('Check')
	})
	$("#content-response-tindaklanjut").html('')
}

function checkPasswordLampiran(tindaklanjut='no')
{
	$(".btn-check-password").html('<i class="fa fa-loading fa-spinner fa-spin"></i> Loading')
	let check_password = $("#check_password_lampiran").val()
	$.post('<?= base_url("Arsip_dokumen/checkPassword") ?>',{check_password:check_password},function(result){
		$("#content-response-lampiran").html(result)
		if(result.indexOf("success") != -1){
			let id_surat =$("#id_lampiran").val()
			let password = check_password
			let url_tipe = 'lampiran'
			if(tindaklanjut =='yes'){
				url_tipe = 'tindak_lanjut'	
			}
			$.post(`<?= base_url("Arsip_dokumen/getPasswordLampiran/") ?>${url_tipe}`,{id_surat:id_surat,password:password},function(result){
				if(result!=''){
					$("#password_lampiran").html(result)
					$("#modal-lihat-password-lampiran").modal('hide')
					if(tindaklanjut=='no'){
						copyPassword('password_lampiran')
					}else{
						copyPassword('password_tindaklanjut')
					}
				}
			})
		}
		$(".btn-check-password").html('Check')
	})
	$("#content-response-lampiran").html('')

}

function copyPassword(id='password_surat') {
    var copyText = document.getElementById(id);
    var textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
    alert('Password berhasil disalin.')
}
function showModalTambahLampiran(id_arsip)
{
	$("#id_arsip").val(id_arsip).change()
	$("#modal-tambah-lampiran").modal()
}
function uploadLampiran()
{
	let uploaded_file = $("#input-lampiran").prop("files")[0]
	let keterangan = $("#input-keterangan").val()
	let id_arsip = $("#id_arsip").val()
	if(uploaded_file == null){
		Swal.fire({
			title: "Oppss!",
			text: "Pilih file terlebih dahulu",
			icon: "error"
		});
	}else{
		$("#form-tambah-lampiran").submit()
		// var url = '<?= base_url('arsip-dokumen/tambahLampiran'); ?>'
		// var form_data = new FormData();
		// form_data.append("file",uploaded_file);
		// form_data.append("keterangan",keterangan);
		// form_data.append("id_arsip",id_arsip)
		// $.ajax({
		// 	url: url,
		// 	type: 'POST',
		// 	processData: false, // important
		// 	contentType: false, // important
		// 	dataType : 'json',
		// 	data: form_data,
		// 	beforeSend: function(xhr, textStatus){
		// 		$(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',true);
		// 		Swal.fire({
		// 			title: "<i class='fa fa-refresh fa-spin'></i>",
		// 			text: "Mohon Tunggu Sebentar",
		// 			showConfirmButton: false,
		// 		});
		// 	},
		// 	success: function(response){  
		// 		if (response.success==true) {
		// 			$(".btn-send").removeClass("disabled").html("<i class='fa fa-save'></i>  Save").attr('disabled',false);
		// 			Swal.fire({
		// 				title: "<i class='fa fa-check'></i>",
		// 				text: "File Berhasil Diupload",
		// 			});

		// 			let keterangan = $("#input-keterangan").val()

		// 			$("#table-lampiran tbody").append(`
		// 					<tr>
		// 						<td>
		// 							${keterangan}
		// 						</td>
		// 						<td>
		// 							<div style="margin-bottom: 10px;">
		// 								<a style="width:100%" href="<?= base_url('upload-cloud/getFile/')?>${response.id}" target="_blank" class="btn btn-xs btn-primary">
		// 									<i class="fa fa-file-pdf-o"></i> Unduh Lampiran
		// 								</a>
		// 							</div>
		// 						</td>
		// 					</tr>
		// 				`)
		// 			$("#modal-tambah-lampiran").modal('hide')
		// 			$("#input-keterangan").val('').change()
		// 			$("#input-lampiran").val('').change()
		// 		} else {
		// 			Swal.fire({
		// 				title: "<i class='fa fa-times'></i>",
		// 				text: "File Gagal Diupload, Silahkan Coba Lagi",
		// 			});
		// 			$(".btn-send").removeClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',false);
		// 		}
		// 	},
		// 	error: function(xhr, textStatus, errorThrown) {
		// 		alert("Error");
		// 		$(".btn-send").removeClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',false);
		// 	}
		// });

	}
}
function showModalEditLampiran(id_lampiran,keterangan)
{
	$("#id_lampiran_edit").val(id_lampiran).change()
	$("#input-edit-keterangan").val(keterangan).change()
	$("#modal-ubah-lampiran").modal()
}
function showModalEditTanggalSurat(id)
{
	$("#form-ubah-tanggal input[name='id_lampiran']").val(id).change()
	$("#modal-ubah-tanggal").modal()
}
</script>
<!-- <style type="text/css">
	.timeline:before{
		background: unset;
	}
	.timeline {
  list-style-type: none;
  display: flex;
  align-items: center;
  justify-content: center;
}
.li {
  transition: all 200ms ease-in;
  margin: 0px !important;
}
.timestamp {
  margin-bottom: 20px;
  padding: 0px 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  font-weight: 100;
}
.status {
  padding: 0px 40px;
  display: flex;
  justify-content: center;
  border-top: 2px solid #D6DCE0;
  position: relative;
  transition: all 200ms ease-in;
}
.status h4 {
  font-weight: 600;
}
.status:before {
  content: "";
  width: 25px;
  height: 25px;
  background-color: white;
  border-radius: 25px;
  border: 1px solid #ddd;
  position: absolute;
  top: -15px;
  left: 42%;
  transition: all 200ms ease-in;
}
.li.complete .status {
  border-top: 2px solid #66DC71;
}
.li.complete .status:before {
  background-color: #66DC71;
  border: none;
  transition: all 200ms ease-in;
}
.li.complete .status h4 {
  color: #66DC71;
}
@media (min-device-width: 320px) and (max-device-width: 700px) {
  .timeline {
    list-style-type: none;
    display: block;
  }
  .li {
    transition: all 200ms ease-in;
    display: flex;
    width: inherit;
  }
  .timestamp {
    width: 100px;
  }
  .status:before {
    left: -8%;
    top: 30%;
    transition: all 200ms ease-in;
  }
}
</style> -->