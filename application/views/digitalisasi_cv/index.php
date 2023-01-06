<div class="content-wrapper" style="background-color: #F5F7FF;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		<?= $page_name ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body ">
					    <div class="row">
					        <div class="col-md-3">
					            <!-- <select class="form-control">
									<option value="">--Jabatan--</option>
									<option value="Direksi">Direksi</option>
									<option value="Dekom">Dekom</option>
								</select> -->
					        </div>
					        <div class="col-md-3">
					            <!-- <button class="btn btn-primary">Filter</button> -->
					        </div>
					        <div class="col-md-6">
					        	<?php if ($this->session->userdata('role_slug')=='super_admin' || $this->session->userdata('role_slug')=='kepala_departemen' OR $this->session->userdata('role_slug')=='sekretaris_divisi' || ($this->session->userdata('role_slug')=='officer' AND in_array($this->session->userdata('jabatan'), ['Sekretaris','Sekretaris Direksi'])) ): ?>
					        	<div class="text-right">
					        		<a href="#modal-tambah" data-toggle="modal" class="btn btn-success margin-bottom"><i class="fa fa-plus"></i> Tambah Digitalisasi CV</a>
					        	</div>
					        	<?php endif ?>
					        </div>
					    </div>
						<!-- <br> -->
						<div class="table-responsive">
							<table class="table table-hover table-responsive table-condensed table-bordered table-striped listSurat" style="width: 100%">
								<thead class="bg-navy">
									<tr>
										<th style="width: 15px;">No</th>
										<th>PN</th>
										<th>Nama</th>
										<th>Jabatan</th>
										<th style="width: 115px;text-align: center;">#</th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$this->db->select('cv.*');
									if ($this->session->userdata('role_slug')!='super_admin' AND $this->session->userdata('role_slug')!='sekretaris_divisi' ) {
										$this->db->join('cv_akses', 'cv_akses.cva_id_cv = cv.cv_id AND cva_id_user = "'.$this->session->userdata('id').'"');
									}
									$cv = $this->mymodel->selectData('cv');
									foreach ($cv as $key => $value) { ?>
										<tr>
											<td><?= $key+1 ?></td>
											<td><?= $value['cv_pn'] ?></td>
											<td><?= $value['cv_nama'] ?></td>
											<td><?= $value['cv_jabatan_terakhir'] ?></td>
											<td>
												<div class="btn-toolbar">
													<a style="font-size:14px" href="<?= base_url('digitalisasi_cv/detail/'.$this->template->sonEncode($value['cv_id'])).'#1' ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Detail</a>
													<?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
														<a style="font-size:14px" href="<?= base_url('digitalisasi_cv/detail/'.$this->template->sonEncode($value['cv_id'])).'#1' ?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</a>	
													<?php endif ?>
												</div>
												
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<!-- /.table -->
						</div>
						<!-- /.mail-box-messages -->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /. box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<form action="<?= base_url('digitalisasi_cv/tambahBaru') ?>" method="POST">
	<div class="modal fade" id="modal-tambah">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Tambah Digitalisasi CV</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>PN</label>
						<input type="text" name="dt[cv_pn]" class="form-control">
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="dt[cv_nama]" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	$('.listSurat').DataTable({
		
	});
</script>