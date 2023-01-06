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
				<div class="box box-primary">
					<!-- /.box-header -->
					<form action="<?= base_url('arsip_dokumen/saveArsip') ?>" method="post" id="upload-create">
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Nomor surat</label>

										<input class="form-control" placeholder="Nomor surat" name="dt[ad_nomorsurat]" value="<?= $arsip['ad_nomorsurat'] ?>" id="txt-nomorsurat">
										<input type="hidden" value="<?= $id_arsip ?>" name="id">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tanggal surat</label>
										<input readonly class="form-control tgl txt-surat" placeholder="Tanggal surat" name="dt[ad_tanggalsurat]" value="<?= $arsip['ad_tanggalsurat'] ?>" id="txt-tanggalsurat">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tanggal Surat Diterima</label>
										<input readonly class="form-control tgl txt-surat" placeholder="Tanggal surat" name="dt[ad_tanggalsuratditerima]" value="<?= $arsip['ad_tanggalsurat'] ?>">
									</div>
								</div>
								<input type="hidden" name="dt[ad_tipesurat]" value="Surat Masuk">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Instansi Pengirim</label>
										<input type="text" class="form-control txt-surat" name="dt[ad_instansipengirim]" value="<?= $arsip['ad_tanggalsurat'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Sifat Surat</label>
										<select class="form-control txt-surat" name="dt[ad_sifatsurat]" id="txt-sifatsurat">
											<option value="">-- Pilih --</option>
											<option value="biasa" <?= ($arsip['ad_sifatsurat'] == 'biasa') ? 'selected' : ''; ?>>Biasa</option>
											<option value="rahasia" <?= ($arsip['ad_sifatsurat'] == 'rahasia') ? 'selected' : ''; ?>>Rahasia</option>
											<option value="sangat_rahasia" <?= ($arsip['ad_sifatsurat'] == 'sangat_rahasia') ? 'selected' : ''; ?>>Sangat Rahasia</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Bentuk Dokumen</label>
										<select class="form-control txt-surat" name="dt[ad_bentukdokumen]" onchange="showUploadLampiran(this.value)">
											<option value="">-- Pilih --</option>
											<option value="surat" <?= ($arsip['ad_bentukdokumen'] == 'surat') ? 'selected' : ''; ?>>Surat</option>
											<option value="surat_dan_proposal" <?= ($arsip['ad_bentukdokumen'] == 'surat_dan_proposal') ? 'selected' : ''; ?>>Surat dan Proposal</option>
											<option value="surat_dan_dokumen_pendukung_lainnya" <?= ($arsip['ad_bentukdokumen'] == 'surat_dan_dokumen_pendukung_lainnya') ? 'selected' : ''; ?>>Surat dan Pendukung Lainnya</option>
										</select>
									</div>
								</div>
								<?php
								$jabatan_user = $this->session->userdata('jabatan');
								$departement_user = $this->session->userdata('departement');
								$role_user = $this->session->userdata('role_slug');
								if ($role_user != 'sekretaris_divisi' and ($jabatan_user != 'Admin Department Head' or $departement_user != '4')) :
								?>
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Kategori Surat</label>
											<select <?= ($role_user != 'sekretaris_divisi' and ($jabatan_user == 'Admin Department Head' or $departement_user == '4')) ? 'required' : '' ?> class="form-control txt-surat" name="dt[ad_kategorisurat_id]" id="txt-kategorisurat">
												<option value="">-- Pilih --</option>

												<?php
												$data_user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

												if ($this->session->userdata('role_slug') != 'super_admin' and $this->session->userdata('role_slug') != 'sekretaris_divisi') {
													$this->db->where('id', $data_user['departemen']);
												}
												$departemen = $this->mymodel->selectWhere('m_departemen', array('status' => 'ENABLE'));
												foreach ($departemen as $key => $value) : ?>
													<option value="<?= $value['id'] ?>" data-singkatan="<?= $value['code'] ?>" <?= ($arsip['ad_kategorisurat_id'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
								<?php
								endif;
								?>
								<div class="col-md-6">
									<div class="form-group">
										<label for=""><i>Due Date</i></label>
										<input readonly type="text" class="form-control tgl txt-surat" name="dt[ad_duedate]" value="<?= $arsip['ad_duedate'] ?>">
									</div>
								</div>
								<div class="col-md-12">

									<div class="form-group">
										<label for="">Perihal</label>
										<textarea class="form-control txt-surat" name="dt[ad_perihal]"><?= $arsip['ad_perihal'] ?></textarea>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="btn-toolbar">
											<?php
											if ($arsip['ad_lampiran'] != '') :
											?>
												<a href="<?= $arsip['ad_lampiran'] ?>" target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Lampiran</a>
											<?php
											endif;
											?>

											<div class="btn btn-default btn-file">
												<i class="fa fa-paperclip"></i> Attachment
												<input type="file" accept=".pdf" id="input-upload-cloud" class="txt-surat">
											</div>
										</div>

										<p class="help-block" style="color: red">File yang diinputkan harus .pdf dan Max 30MB</p>
										<input type="hidden" name="dt[ad_lampiran]" id="link-file" value="<?= $arsip['ad_lampiran'] ?>">
									</div>
									<a href="#" id="btn-download-file" style="display: none;"><button type="button" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-download"></i> Download</button></a>
								</div>
								<div class="lampiran hide">
									<div class="col-md-12">
										<div class="panel panel-primary">
											<div class="panel-heading">
												<button type="button" onclick="showModalLampiran()" class="btn btn-xs btn-success pull-right">
													<i class="fa fa-plus"></i> Tambah Lampiran
												</button>
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

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<div class="col-md-3">
								<a href="<?= base_url('arsip_dokumen') ?>" class="btn btn-default btn-block margin-bottom">
									<< Kembali Ke List Surat</a>
							</div>
							<div class="col-md-9">
								<div class="pull-right">
									<!-- <a href="<?= base_url('arsip_dokumen') ?>" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</a> -->
									<input type="hidden" name="dt[ad_lampiran_password]" id="lampiran_password">
									<input type="hidden" name="draft" value="n" id="is_draft">
									<div class="btn-toolbar">
										<button onclick='$("#is_draft").val("y").change()' type="submit" name="draft" value="y" class="btn btn-info"><i class="fa fa-file-text-o"></i> Draft</button>
										<button onclick='$("#is_draft").val("n").change()' type="submit" class="btn btn-primary btn-kirim <?= ($arsip['ad_lampiran'] != '') ? '' : 'hide' ?>"><i class="fa fa-envelope-o"></i> Kirim</button>
									</div>
								</div>
							</div>
						</div>
					</form>
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
<div class="modal fade" id="modal-upload-lampiran">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Upload Lampiran</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Lampiran</label>
					<input type="file" accept=".pdf" name="lampiran" class="form-control" id="input-lampiran">
					<p class="help-block" style="color: red">File yang diinputkan harus .pdf dan Max 30MB</p>
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<input type="text" name="keterangan" class="form-control" id="input-keterangan">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
				<button type="button" onclick="uploadLampiran()" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#input-upload-cloud').click(function(event) {
		var txt_sifatsurat = $('#txt-sifatsurat').val();
		if (txt_sifatsurat == '') {
			event.preventDefault()
			Swal.fire({
				title: "Oppss!",
				text: "Pilih sifat surat terlebih dahulu",
				icon: "error"
			});
		}
	})
	$('#input-upload-cloud').change(function(event) {
		var txt_sifatsurat = $('#txt-sifatsurat').val();
		var url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode'); ?>'
		if (txt_sifatsurat == 'rahasia' || txt_sifatsurat == 'sangat_rahasia') {
			url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode/yes/yes'); ?>'
		}

		var form_data = new FormData();
		form_data.append("file", $(this).prop("files")[0]);
		$.ajax({
			// url: '<?= base_url('upload-cloud/ajaxUploadCloud'); ?>',
			url: url,
			type: 'POST',
			processData: false, // important
			contentType: false, // important
			dataType: 'json',
			data: form_data,
			beforeSend: function(xhr, textStatus) {
				Swal.fire({
					title: "<i class='fa fa-refresh fa-spin'></i>",
					text: "Mohon Tunggu Sebentar",
					showConfirmButton: false,
				});
			},
			success: function(response) {
				if (response.success == true) {
					$(".btn-kirim").removeClass('hide')
					Swal.fire({
						title: "<i class='fa fa-check'></i>",
						text: "File Berhasil Diupload",
					});
					$('#btn-download-file').attr({
						href: '<?= base_url('upload-cloud/getFile/') ?>' + response.id,
						target: '_blank'
						// download: '<?= base_url('upload-cloud/getFile/') ?>'+response.id
					}).show();
					$('#link-file').val('<?= base_url('upload-cloud/getFile/') ?>' + response.id);
					$('#lampiran_password').val(response.password).change();
					$("#txt-sifatsurat").attr("style", "pointer-events: none;")
					// simpanDraft();
				} else {
					Swal.fire({
						title: "<i class='fa fa-times'></i>",
						text: "File Gagal Diupload, Silahkan Coba Lagi",
					});
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				alert("File anda berukuran lebih dari 30 Mb");
			}
		});
	});
	$("#upload-create").submit(function() {
		var form = $(this);
		var mydata = new FormData(this);
		$.ajax({
			type: "POST",
			url: form.attr("action"),
			data: mydata,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled', true);
				form.find(".show_error").slideUp().html("");
			},
			success: function(response, textStatus, xhr) {

				// alert(mydata);
				var str = response;
				var role_user = '<?= $this->session->userdata('role_slug') ?>'
				var jabatan_user = '<?= $this->session->userdata('jabatan') ?>'
				var departement_user = '<?= $this->session->userdata('departement') ?>'
				if (str.indexOf("success") != -1) {
					Swal.fire({
						title: "It works!",
						text: "Successfully added data",
						icon: "success"
					});
					let json_parse = JSON.parse(str)
					let id = json_parse.id
					// form.find(".show_error").hide().html(response).slideDown("fast");
					setTimeout(function() {
						if (role_user == 'sekretaris_divisi' || (jabatan_user == 'Admin Department Head' && departement_user == '4')) {
							window.location.href = "<?= base_url('arsip_dokumen/disposisiSekretarisDivisi/') ?>" + id;
						} else {
							window.location.href = "<?= base_url('arsip_dokumen/toDetailArsip/') ?>" + id;
						}


					}, 1000);
					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
				} else {
					Swal.fire({
						title: "Oppss!",
						html: str,
						icon: "error"
					});
					// form.find(".show_error").hide().html(response).slideDown("fast");
					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);

				}
			},
			error: function(xhr, textStatus, errorThrown) {
				console.log(xhr);
				Swal.fire({
					title: "Oppss!",
					text: xhr,
					icon: "error"
				});
				$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
				// form.find(".show_error").hide().html(xhr).slideDown("fast");
			}
		});
		return false;

	});
	$(".txt-surat").change(function() {
		// ubahNosurat();
		// simpanDraft();
	});

	function simpanDraft() {
		var mydata = $('#upload-create').serialize();
		jQuery.ajax({
			url: '<?= base_url("arsip-dokumen/saveDraft") ?>',
			type: 'POST',
			data: mydata,
			beforeSend: function() {

			},
			success: function(result) {

			},
		});
	}

	function showUploadLampiran(value) {
		if (value != '' && value != 'surat') {
			$(".lampiran").removeClass('hide')
		} else {
			$(".lampiran").addClass('hide')
		}
	}

	function showModalLampiran() {
		var txt_sifatsurat = $('#txt-sifatsurat').val();
		if (txt_sifatsurat == '') {
			Swal.fire({
				title: "Oppss!",
				text: "Pilih sifat surat terlebih dahulu",
				icon: "error"
			});
		} else {
			$("#modal-upload-lampiran").modal()
		}

	}

	function uploadLampiran() {
		let uploaded_file = $("#input-lampiran").prop("files")[0]
		if (uploaded_file == null) {
			Swal.fire({
				title: "Oppss!",
				text: "Pilih file terlebih dahulu",
				icon: "error"
			});
		} else {
			var txt_sifatsurat = $('#txt-sifatsurat').val();
			var url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode'); ?>'
			if (txt_sifatsurat == 'rahasia' || txt_sifatsurat == 'sangat_rahasia') {
				url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode/yes/yes'); ?>'
			}
			var form_data = new FormData();
			form_data.append("file", uploaded_file);
			$.ajax({
				url: url,
				type: 'POST',
				processData: false, // important
				contentType: false, // important
				dataType: 'json',
				data: form_data,
				beforeSend: function(xhr, textStatus) {
					$(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled', true);
					Swal.fire({
						title: "<i class='fa fa-refresh fa-spin'></i>",
						text: "Mohon Tunggu Sebentar",
						showConfirmButton: false,
					});
				},
				success: function(response) {
					if (response.success == true) {
						$(".btn-send").removeClass("disabled").html("<i class='fa fa-save'></i>  Save").attr('disabled', false);
						Swal.fire({
							title: "<i class='fa fa-check'></i>",
							text: "File Berhasil Diupload",
						});
						let keterangan = $("#input-keterangan").val()

						$("#table-lampiran tbody").append(`
							<tr>
								<td>
									${keterangan}
									<input type="hidden" name="keterangan[]" value="${keterangan}">
								</td>
								<td>
									<div class="btn-toolbar">
										<input type="hidden" name="path[]" value="<?= base_url('upload-cloud/getFile/') ?>${response.id}">
										<input type="hidden" name="password[]" value="${response.password}">
										<a style="width:100%" href="<?= base_url('upload-cloud/getFile/') ?>${response.id}" target="_blank" class="btn btn-xs btn-primary">
											<i class="fa fa-file-pdf-o"></i> Download
										</a>
										<button style="width:100%" class="btn btn-xs btn-danger delete-row">
											<i class="fa fa-trash"></i> Delete
										</button>
									</div>
								</td>
							</tr>
						`)
						$("#modal-upload-lampiran").modal('hide')
						$("#input-keterangan").val('').change()
						$("#input-lampiran").val('').change()
					} else {
						Swal.fire({
							title: "<i class='fa fa-times'></i>",
							text: "File Gagal Diupload, Silahkan Coba Lagi",
						});
						$(".btn-send").removeClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled', false);
					}
				},
				error: function(xhr, textStatus, errorThrown) {
					alert("Error");
					$(".btn-send").removeClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled', false);
				}
			});

		}
	}

	$('#table-lampiran').on('click', '.delete-row', function(e) {
		$(this).closest('tr').remove()
	})
</script>