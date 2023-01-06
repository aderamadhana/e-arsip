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
			<!-- /.col -->			
			<div class="col-md-12">
				<!-- <a href="<?= base_url('arsip_dokumen/surat_keluar') ?>" class="btn btn-default btn-block margin-bottom"><< Kembali Ke List Surat</a> -->
				<?= $view_menu ?>
			</div>
			<div class="col-md-12">
				<div class="box box-primary">
					<!-- /.box-header -->
					<form action="<?= base_url('arsip_dokumen/saveArsipSuratKeluar') ?>" method="post" id="upload-create">
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									    <button onclick="ubah()" class="btn btn-xs btn-primary pull-right" type="button"><i class="fa fa-edit"></i> Edit</button> 
										<label for="">Nomor surat</label>
										<?php 
											$this->db->select('ad_id');
											$this->db->order_by('ad_id', 'desc');
											$lastid = $this->mymodel->selectDataone('arsip_dokumen',[]);


											if ($arsip['ad_id']) {
												$nomorsurat = $arsip['ad_nomorsurat'];
												$lastid['ad_id'] = $arsip['ad_id']-1;
											}

											$txtnomorsurat = sprintf('%04d', $lastid['ad_id']+1);

											if ($arsip['ad_id']=='') {
												$nomorsurat = '';
											}
										?>

										<input class="form-control" placeholder="Nomor surat" name="dt[ad_nomorsurat]" value="<?= $nomorsurat ?>" readonly id="txt-nomorsurat">
										<input type="hidden" value="<?=$id_arsip ?>" name="id">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Surat Keluar</label> <small class="text-red">*Wajib diisi</small>
										<select required class="form-control select2" onchange="ubahNosurat();updateKategoriSurat();showUploadLampiran(this.value);" name="dt[ad_tsk_id]" id="surat_keluar" style="width: 100%;">
											<option value="">--Pilih Surat Keluar--</option>
											<?php 
											foreach($tipe_surat_keluar as $tipe):
											?>
												<option <?= ($tipe['id'] == $arsip['ad_tsk_id']) ? 'selected' : '' ?> data-singkatan="<?= $tipe['kode'] ?>" value="<?= $tipe['id'] ?>"><?= $tipe['nama'] ?></option>
											<?php 
											endforeach;
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tanggal surat</label> <small class="text-red">*Wajib diisi</small>
										<input required class="form-control tgl txt-surat" autocomplete="off" readonly placeholder="Tanggal surat" name="dt[ad_tanggalsurat]" value="<?= $arsip['ad_tanggalsurat'] ?>" id="txt-tanggalsurat">
									</div>
								</div>
								<!-- <div class="col-md-6">
									<div class="form-group">
										<label for="">Tanggal Surat Diterima</label>
										<input class="form-control tgl txt-surat" readonly autocomplete="off" placeholder="Tanggal surat" name="dt[ad_tanggalsuratditerima]" value="<?= $arsip['ad_tanggalsurat'] ?>">
									</div>
								</div> -->
								<input type="hidden" name="dt[ad_tipesurat]" value="Surat Keluar">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Instansi Penerima</label> <small class="text-red">*Wajib diisi</small>
										<input required type="text" class="form-control txt-surat" name="dt[ad_instansipengirim]" value="<?= $arsip['ad_instansipengirim'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Sifat Surat</label> <small class="text-red">*Wajib diisi</small>
										<select required class="form-control txt-surat" name="dt[ad_sifatsurat]" id="txt-sifatsurat">
											<option value="">-- Pilih --</option>
											<option value="biasa" <?= ($arsip['ad_sifatsurat']=='biasa')?'selected':''; ?>>Biasa</option>
											<option value="rahasia" <?= ($arsip['ad_sifatsurat']=='rahasia')?'selected':''; ?>>Rahasia</option>
											<option value="sangat_rahasia" <?= ($arsip['ad_sifatsurat']=='sangat_rahasia')?'selected':''; ?>>Sangat Rahasia</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Bentuk Dokumen</label> <small class="text-red">*Wajib diisi</small>
										<select required class="form-control txt-surat" name="dt[ad_bentukdokumen]">
											<option value="">-- Pilih --</option>
											<option value="surat" <?= ($arsip['ad_bentukdokumen']=='surat')?'selected':''; ?>>Surat</option>
											<option value="surat_dan_proposal" <?= ($arsip['ad_bentukdokumen']=='surat_dan_proposal')?'selected':''; ?>>Surat dan Proposal</option>
											<option value="surat_dan_dokumen_pendukung_lainnya" <?= ($arsip['ad_bentukdokumen']=='surat_dan_dokumen_pendukung_lainnya')?'selected':''; ?>>Surat dan Pendukung Lainnya</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Departemen</label> <small class="text-red">*Wajib diisi</small>
										<select required class="form-control txt-surat" name="dt[ad_departemen]" id="txt-departemen" onchange="getTeamLeader(this.value)">
											<option data-singkatan="" value="">-- Pilih --</option>

											<?php 
											$data_user = $this->db->get_where('user',['id'=>$this->session->userdata('id')])->row_array();
											if($this->session->userdata('role_slug')!='super_admin' AND $this->session->userdata('role_slug') != 'sekretaris_divisi'){
												$this->db->where('id',$data_user['departemen']);
											}
											$departemen = $this->mymodel->selectWhere('m_departemen',array('status'=>'ENABLE'));
											foreach ($departemen as $key => $value): ?>
												<option value="<?= $value['id'] ?>" data-singkatan="<?= $value['code'] ?>" <?= ($arsip['ad_departemen']==$value['id'])?'selected':''; ?>><?= $value['nama'] ?></option> 
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="col-md-6 div_teamleader <?= ($this->session->userdata('role_slug')=='team_leader') ? 'hide' : '' ?>">
									<div class="form-group">
										<label for="">Team Leader</label> <small class="text-red">*Wajib diisi</small>
										<select name="dt[ad_id_teamleader]" class="form-control txt-surat" id="txt-teamleader">
											<option value="">-- Pilih --</option>
											<?php 
												if($this->session->userdata('role_slug')=='team_leader'):
													$data_user = $this->mymodel->selectDataone('user',['id'=>$this->session->userdata('id')]);
											?>
													<option selected value="<?= $data_user['id'] ?>"><?= $data_user['name'] ?></option>
											<?php 	
												endif;
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6 div_divisi hide">
									<div class="form-group">
										<label for="">Divisi</label> <small class="text-red">*Wajib diisi</small>
										<input type="text" class="form-control" name="dt[ad_divisi]" id="txt-divisi" onkeyup="ubahNosurat()" value="<?= $arsip['ad_divisi'] ?>">
									</div>
								</div>
								<div class="col-md-6 kategori_surat">
									<div class="form-group">
										<label for="">Kategori Surat</label> <small class="text-red">*Wajib diisi</small>
										<select required class="form-control txt-surat" name="dt[ad_kategorisurat_id]" id="txt-kategorisurat">
											<option value="">-- Pilih --</option>
											<?php 
												if($id_arsip !=''):
													$list_kategori_surat = $this->mymodel->selectWhere('m_kategori_surat',['status'=>'ENABLE','tsk_id'=>$arsip['ad_tsk_id']]);
													foreach($list_kategori_surat as $kategori_surat):
											?>
													<option <?= ($kategori_surat['id']==$arsip['ad_kategorisurat_id']) ?'selected' : '' ?> value="<?= $kategori_surat['id'] ?>"><?= $kategori_surat['mkt_kategori'] ?></option>
											<?php 
													endforeach;
												endif;
											?>
										</select>
									</div>
								</div>
								<!-- <div class="col-md-6">
									<div class="form-group">
										<label for="">Signer</label>
										<input type="text" class="form-control" name="dt[ad_signer]" value="<?= $arsip['ad_signer'] ?>">
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Penanggung Jawab</label>
										<input type="text" class="form-control" name="dt[ad_pic]" value="<?= $arsip['ad_pic'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">No Telp</label>
										<input type="text" class="form-control" name="dt[ad_notelp]" value="<?= $arsip['ad_notelp'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tanda Tangan</label>
										<input type="text" class="form-control" name="dt[ad_tandatangan]" value="<?= $arsip['ad_tandatangan'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Dikirim Kepada</label>
										<input type="text" class="form-control" name="dt[ad_dikirim]" value="<?= $arsip['ad_dikirim'] ?>">
									</div>
								</div>
								<div class="col-md-12">
									
									<div class="form-group">
										<label for="">Perihal</label>
										<textarea class="form-control" name="dt[ad_perihal]"><?= $arsip['ad_perihal'] ?></textarea>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="btn btn-default btn-file">
											<i class="fa fa-paperclip"></i> Attachment
											<input type="file" accept=".pdf" id="input-upload-cloud" class=>
										</div>
										<p class="help-block" style="color: red">File yang diinputkan harus .pdf dan Max 20MB</p>
										<input type="hidden" name="dt[ad_lampiran]" id="link-file" value="<?= $arsip['ad_lampiran'] ?>">
									</div>
									<a href="<?= $arsip['ad_lampiran'] ?>" id="btn-download-file" style="display: <?= ($arsip['ad_lampiran']=='') ? 'none' : '' ?>;"><button type="button" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-download"></i> <span id="text-btn-download"> Download</span></button></a>

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
							<div class="pull-right">
								<!-- <a href="<?= base_url('arsip_dokumen') ?>" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</a> -->
								<input type="hidden" name="dt[ad_lampiran_password]" id="lampiran_password">
								<button class="btn btn-primary btn-booking" onclick="simpanDraft(1)" type="button"><i class=" fa fa-book"></i> Booking Slot</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Simpan</button>
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
<div class="modal fade" id="modal-ubah-nomor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Nomor Surat</h4>
            </div>
            <div class="modal-body">
                <label>Ubah Nomor</label> <br>
                <span id="span-no-awal"></span>
                <input style="width:50px;" id="edit-tipe" type="text">
                <span id="span-tipe"></span>
                <input style="width:100px;" id="edit-no" type="text">
                <span id="span-no-tengah"></span>
                <input id="edit-team-leader" type="text">
                <span id="span-no-akhir"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" onclick="saveNomorBaru()" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
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
$('#input-upload-cloud').change(function(event) {
	
	let sifatsurat = $("#txt-sifatsurat").val()
	if(sifatsurat ==''){

		Swal.fire({
            title: "Oppss!",
            text: "Lengkapi data terlebih dahulu!",
            icon: "error"
        });

	}else{
		var url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode'); ?>'
		if(sifatsurat!='biasa'){
			url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode/no/yes'); ?>'
		} 
		var form_data = new FormData();  
		form_data.append("file", $(this).prop("files")[0]);  
		$.ajax({
			// url: '<?= base_url('upload-cloud/ajaxUploadCloud'); ?>',
			url: url,
			type: 'POST',
			processData: false, // important
			contentType: false, // important
			dataType : 'json',
			data: form_data,
			beforeSend: function(xhr, textStatus){
				Swal.fire({
					title: "<i class='fa fa-refresh fa-spin'></i>",
					text: "Mohon Tunggu Sebentar",
					showConfirmButton: false,
				});
			},
			success: function(response){  
				if (response.success==true) {
					Swal.fire({
						title: "<i class='fa fa-check'></i>",
						text: "File Berhasil Diupload",
					});
					$('#btn-download-file').attr({
						href: '<?= base_url('upload-cloud/getFile/')?>'+response.id,
						target: '_blank'
						// download: '<?= base_url('upload-cloud/getFile/')?>'+response.id
					}).show();
					$('#link-file').val('<?= base_url('upload-cloud/getFile/')?>'+response.id);
					$('#lampiran_password').val(response.password).change();
					$("#txt-sifatsurat").attr("style", "pointer-events: none;")

					var fullPath = document.getElementById('input-upload-cloud').value;
					if (fullPath) {
					    var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
					    var filename = fullPath.substring(startIndex);
					    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
					        filename = filename.substring(1);
					    }
					    $("#text-btn-download").html('').text('Download '+filename)
					}
					// simpanDraft();
				} else {
					Swal.fire({
						title: "<i class='fa fa-times'></i>",
						text: "File Gagal Diupload, Silahkan Coba Lagi",
					});
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				alert("Error");
			}
		});

	}
});
$("#upload-create").submit(function(e){
	e.preventDefault()
	let link_file = $('#link-file').val().trim()
	Swal.fire({
	  title: 'Perhatian',
	  text: "Apakah anda yakin akan menyimpan data ini ?",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes'
	}).then((result) => {
	  if (result.isConfirmed) {
	    var form = $(this);
		var mydata = new FormData(this);
		$.ajax({
			  type: "POST",
			url: form.attr("action"),
			data: mydata,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend : function(){
				  $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
				form.find(".show_error").slideUp().html("");
			},
			success: function(response, textStatus, xhr) {
			  
				  // alert(mydata);
			   var str = response;
				if (str.indexOf("success") != -1){
					  Swal.fire({
						  title: "It works!",
						  text: "Successfully added data",
						  icon: "success"
					  });
					  let json_parse = JSON.parse(str)
					  let id = json_parse.id
					  // form.find(".show_error").hide().html(response).slideDown("fast");
					setTimeout(function(){ 
						 window.location.href = "<?= base_url('arsip_dokumen/toDetailArsip/') ?>"+id;
					}, 1000);
					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
				}else{
					Swal.fire({
					  title: "Oppss!",
					  html: str,
					  icon: "error"
					});
					  // form.find(".show_error").hide().html(response).slideDown("fast");
					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

				}
			},
			error: function(xhr, textStatus, errorThrown) {
				console.log(xhr);
				Swal.fire({
					title: "Oppss!",
					text: xhr,
					icon: "error"
				});
				$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
				// form.find(".show_error").hide().html(xhr).slideDown("fast");
			}
		});
		return false;
	  }
	})

});
$(".txt-surat").change(function(){
	ubahNosurat();
	// simpanDraft();
});

function simpanDraft(is_booking=0) {

	var tipe_surat_keluar = $("#surat_keluar").val()
	var tanggal_surat = $("input[name='dt[ad_tanggalsurat]']").val()
	var tanggal_surat_diterima  = $("input[name='dt[ad_tanggalsuratditerima]']").val()
	var instansi_pengirim = $("input[name='dt[ad_instansipengirim]']").val()
	var sifat_surat = $("select[name='dt[ad_sifatsurat]']").val()
	var bentuk_dokumen = $("select[name='dt[ad_bentukdokumen]']").val()
	var team_leader = $("select[name='dt[ad_id_teamleader]']").val()
	var divisi = $("#txt-divisi").val()
	// var kategori_surat =$("select[name='dt[ad_kategorisurat_id]']").val()

	var nomor_surat = $("#txt-nomorsurat").val().split('/')
	var departemen = $('#txt-departemen option:selected').attr('data-singkatan');
	var array_check = [tipe_surat_keluar,tanggal_surat,tanggal_surat_diterima,instansi_pengirim,sifat_surat,bentuk_dokumen,departemen,team_leader]
	if(tipe_surat_keluar == 2){
		array_check = [tipe_surat_keluar,tanggal_surat,tanggal_surat_diterima,instansi_pengirim,sifat_surat,bentuk_dokumen,departemen,divisi]
	}
	

	if(array_check.includes('')){
		Swal.fire({
            title: "Oppss!",
            text: "Lengkapi data terlebih dahulu!",
            icon: "error"
        });
	}else{
		Swal.fire({
		  title: 'Perhatian',
		  text: "Apakah anda yakin akan menyimpan data ini ?",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes'
		}).then((result) => {
		  if (result.isConfirmed) {
		  	var mydata = $('#upload-create').serialize();
			jQuery.ajax({
				url: '<?=base_url("arsip-dokumen/saveDraft")?>',
					type: 'POST',
				data: mydata,
				beforeSend: function(){
					if(is_booking == 1){
				  		$('.btn-booking').html('<i class="fa fa-spin fa-spinner"></i> Proses');
					}
				},
				success: function(response, textStatus, xhr) {

					var str = response;
					if (str.indexOf("success") != -1){
						  Swal.fire({
							  title: "It works!",
							  text: "Successfully added data",
							  icon: "success"
						  });
						  let json_parse = JSON.parse(str)
						  let id = json_parse.id
						  Swal.fire(
						      'Perhatian!',
						      'Data berhasil disimpan.',
						      'success'
						   )

						  // form.find(".show_error").hide().html(response).slideDown("fast");
						setTimeout(function(){ 
							 if(is_booking == 1){
								window.location="<?=base_url()?>arsip-dokumen/surat_keluar";
							}
						}, 1000);
						$(".btn-booking").removeClass("disabled").html('<i class="fa fa-book"></i> Booking Slot').attr('disabled',false);
					}else{
						Swal.fire({
						  title: "Oppss!",
						  html: str,
						  icon: "error"
						});
						  // form.find(".show_error").hide().html(response).slideDown("fast");
						$(".btn-booking").removeClass("disabled").html('<i class="fa fa-book"></i> Booking Slot').attr('disabled',false);

					}
					
				},
			});
		  }
		})
		
	}
}

function ubahNosurat() {
	var txt_sifatsurat = $('#txt-sifatsurat').val();
	var txt_tanggalsurat = $('#txt-tanggalsurat').val().split('-');
	var txt_tipesuratkeluar = $("#surat_keluar").val()

	var sifatsurat = '';
	var departemen = $('#txt-departemen option:selected').attr('data-singkatan');
	var departemen_id = $("#txt-departemen").val()

	var nosurat = '';
	var id_arsip = '<?= $id_arsip ?>'

	var id_team_leader = $("#txt-teamleader").val()
	var nama_team_leader = $("#txt-teamleader option:selected").text()
	if(id_team_leader=='') nama_team_leader = ''
	if (txt_sifatsurat=='biasa') {
		sifatsurat = 'B';
	} else if(txt_sifatsurat=='rahasia'){
		sifatsurat = 'R';
	} else if(txt_sifatsurat=='sangat_rahasia'){
		sifatsurat = 'SR';
	}

	var bulan = txt_tanggalsurat[1];
	var tahun = txt_tanggalsurat[0];

	var tipe_surat_keluar = $('#surat_keluar option:selected').attr('data-singkatan');

	if(txt_tipesuratkeluar=='2'){ //tipe surat divisi,tidak menggunakan team leader
		var divisi = $("#txt-divisi").val()
		if(departemen_id!=''){
			let param_url = `?departement_id=${departemen_id}&id_team_leader=&sifat_surat=${txt_sifatsurat}&tipe_surat_keluar=${tipe_surat_keluar}&kodesifatsurat=${sifatsurat}`
			$.get('<?= base_url("Arsip_dokumen/generateNoSuratByDepartment") ?>'+param_url,function(result){
				let parsed_json_result = JSON.parse(result)
				let id_arsip = '<?= $id_arsip ?>'
				let data_departement = '<?= $arsip['ad_departemen'] ?>'
				if(id_arsip !='' && departemen_id == data_departement ){
					nosurat = '<?= $current_no ?>'
				}else{
					nosurat = parsed_json_result.nomor;
				}
				
				var gen_nosurat = sifatsurat+'.'+nosurat+'-'+tipe_surat_keluar+'/'+divisi+'/'+bulan+'/'+tahun;
				$('#txt-nomorsurat').val(gen_nosurat);
			})
		}
	}else{
		var gen_nosurat = sifatsurat+'.'+nosurat+'-'+tipe_surat_keluar+'/'+departemen+'/'+bulan+'/'+tahun;
		$('#txt-nomorsurat').val(gen_nosurat);
		if(departemen_id!='' && id_team_leader!=''){
			let param_url = `?departement_id=${departemen_id}&id_team_leader=${id_team_leader}&sifat_surat=${txt_sifatsurat}&tipe_surat_keluar=${tipe_surat_keluar}&kodesifatsurat=${sifatsurat}`
			$.get('<?= base_url("Arsip_dokumen/generateNoSuratByDepartment") ?>'+param_url,function(result){
				let parsed_json_result = JSON.parse(result)
				let id_arsip = '<?= $id_arsip ?>'
				let data_departement = '<?= $arsip['ad_departemen'] ?>'
				if(id_arsip !='' && departemen_id == data_departement ){
					nosurat = '<?= $current_no ?>'
				}else{
					nosurat = parsed_json_result.nomor;
				}
				
				var gen_nosurat = sifatsurat+'.'+nosurat+'-'+tipe_surat_keluar+'/'+departemen+'/'+nama_team_leader+'/'+bulan+'/'+tahun;
				$('#txt-nomorsurat').val(gen_nosurat);
			})
		}
	}
	
	
}

function ubah()
{
	var tipe_surat_keluar = $("#surat_keluar").val()
	var tanggal_surat = $("input[name='dt[ad_tanggalsurat]']").val()
	var tanggal_surat_diterima  = $("input[name='dt[ad_tanggalsuratditerima]']").val()
	var instansi_pengirim = $("input[name='dt[ad_instansipengirim]']").val()
	var sifat_surat = $("select[name='dt[ad_sifatsurat]']").val()
	var bentuk_dokumen = $("select[name='dt[ad_bentukdokumen]']").val()
	// var kategori_surat =$("select[name='dt[ad_kategorisurat_id]']").val()

	var nomor_surat = $("#txt-nomorsurat").val().split('/')
	var departemen = $('#txt-departemen option:selected').attr('data-singkatan');
	var array_check = [tipe_surat_keluar,tanggal_surat,tanggal_surat_diterima,instansi_pengirim,sifat_surat,bentuk_dokumen,departemen]

	if(array_check.includes('')){
		Swal.fire({
            title: "Oppss!",
            text: "Lengkapi data terlebih dahulu!",
            icon: "error"
        });
	}else{

		if(tipe_surat_keluar=='2'){
			let huruf = nomor_surat[0].split('.')
			let tipe_surat_keluar = huruf[1].split('-')
			$("#span-no-awal").html(`
				<input style="width:50px;" type="text" id="edit-huruf" value="${huruf[0]}">.${tipe_surat_keluar[0]}-
				`)
			$("#edit-tipe").val(tipe_surat_keluar[1]).change()			
			$("#span-no-akhir").html(nomor_surat[2]+'/'+nomor_surat[3])	
			$("#edit-team-leader").val('').change().hide()
		}else{
			let tipe_surat_keluar = nomor_surat[0].split('-')
			$("#span-no-awal").html(tipe_surat_keluar[0]+'-')	
			$("#edit-tipe").val(tipe_surat_keluar[1]).change()
			$("#span-no-akhir").html('/'+nomor_surat[3]+'/'+nomor_surat[4])	
			$("#edit-team-leader").val(nomor_surat[2]).change().show()
			
		}
		$("#edit-no").val(nomor_surat[1]).change()
	    $("#span-tipe").html('/')
	    $("#span-no-tengah").html('/')
	    $("#modal-ubah-nomor").modal()	
	}

	
}

function saveNomorBaru()
{
	var updated_code = $("#edit-no").val()
	var nomor_surat = $("#txt-nomorsurat").val().split('/')
	var tipe_surat_keluar = $("#surat_keluar").val()
	var updated_code_tipe_surat = $("#edit-tipe").val()
	var updated_team_leader = $("#edit-team-leader").val()
	if(tipe_surat_keluar=='2'){
		var huruf = $("#edit-huruf").val()
		var nomor_lanjutan = nomor_surat[0].split('.')
		var tipe = nomor_lanjutan[1].split('-')
		var nomor_baru = huruf+'.'+tipe[0]+'-'+updated_code_tipe_surat+'/'+updated_code+'/'+nomor_surat[2]+'/'+nomor_surat[3]
	}else{
		var tipe = nomor_surat[0].split('-')
		var nomor_baru = tipe[0]+'-'+updated_code_tipe_surat+'/'+updated_code+'/'+updated_team_leader+'/'+nomor_surat[3]+'/'+nomor_surat[4]	
	}
	
	$("#txt-nomorsurat").val(nomor_baru).change()
	$("#modal-ubah-nomor").modal('hide')
}

function updateKategoriSurat()
{	
	$("#txt-kategorisurat option[value!='']").remove()
	let tipe_surat_keluar = $("#surat_keluar").val()
	if(tipe_surat_keluar == '2'){
		$("select[name='dt[ad_bentukdokumen]']").val('surat').change()
		$("select[name='dt[ad_bentukdokumen]'] option[value!='surat']").hide()
		$(".kategori_surat").show()
		$("#txt-kategorisurat").attr('required',true)
		$(".div_teamleader").addClass('hide')
		$(".div_divisi").removeClass('hide')

		// otomatis set departemen ke otb2
		$("#txt-departemen").val(4).change().attr('readonly',true)
	}else{
		$("select[name='dt[ad_bentukdokumen]'] option[value!='surat']").show()
		$("#txt-kategorisurat").val('').change()
		$(".kategori_surat").hide()
		$("#txt-kategorisurat").attr('required',false)
		$(".div_teamleader").removeClass('hide')
		$(".div_divisi").addClass('hide')
		$("#txt-departemen").attr('readonly',false)
	}
	if(tipe_surat_keluar!=''){
		$.post('<?= base_url("Arsip_dokumen/getKategoriSurat") ?>',{tsk_id:tipe_surat_keluar},function(result){
			let parsed_json = JSON.parse(result)
			$.each(parsed_json,function(key,value){
				$("#txt-kategorisurat").append($('<option>',{
					text : value.mkt_kategori,
					value: value.id
				}))
			}) 
		})
	}
}
function getTeamLeader(departemen_id)
{
	let role_user = '<?= $this->session->userdata('role_slug') ?>'
	if(role_user!='team_leader'){
		$("#txt-teamleader option[value!='']").remove()
		if(departemen_id!=''){
			$.post('<?= base_url("Arsip_dokumen/getTeamLeader") ?>',{departement_id:departemen_id},function(result){
				let parsed_json = JSON.parse(result)
				$.each(parsed_json,function(key,value){
					$("#txt-teamleader").append($('<option>',{
						text : value.name,
						value: value.id
					}))
				}) 

				let departement_id = '<?= $arsip['ad_departemen'] ?>'
				if(departemen_id!=''){
					$("#txt-teamleader").val('<?= $arsip['ad_id_teamleader'] ?>').change()
				}
			})
		}	
	}
	
}

function showModalLampiran()
{
	var txt_sifatsurat = $('#txt-sifatsurat').val();
	if(txt_sifatsurat==''){
		Swal.fire({
            title: "Oppss!",
            text: "Pilih sifat surat terlebih dahulu",
            icon: "error"
        });
	}else{
		$("#modal-upload-lampiran").modal()	
	}
	
}

function showUploadLampiran(value)
{
	if(value!='' && value =='1'){
		$(".lampiran").removeClass('hide')
	}else{
		$(".lampiran").addClass('hide')
	}
}
function uploadLampiran()
{
	let uploaded_file = $("#input-lampiran").prop("files")[0]
	if(uploaded_file == null){
		Swal.fire({
			title: "Oppss!",
			text: "Pilih file terlebih dahulu",
			icon: "error"
		});
	}else{
		var txt_sifatsurat = $('#txt-sifatsurat').val();
		var url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode'); ?>'
		if(txt_sifatsurat=='rahasia' || txt_sifatsurat == 'sangat_rahasia'){
			url = '<?= base_url('arsip-dokumen/uploadPDFWithQRCode/yes/yes'); ?>'
		}
		var form_data = new FormData();
		form_data.append("file",uploaded_file);
		$.ajax({
			url: url,
			type: 'POST',
			processData: false, // important
			contentType: false, // important
			dataType : 'json',
			data: form_data,
			beforeSend: function(xhr, textStatus){
				$(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',true);
				Swal.fire({
					title: "<i class='fa fa-refresh fa-spin'></i>",
					text: "Mohon Tunggu Sebentar",
					showConfirmButton: false,
				});
			},
			success: function(response){  
				if (response.success==true) {
					$(".btn-send").removeClass("disabled").html("<i class='fa fa-save'></i>  Save").attr('disabled',false);
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
										<input type="hidden" name="path[]" value="<?= base_url('upload-cloud/getFile/')?>${response.id}">
										<input type="hidden" name="password[]" value="${response.password}">
										<a style="width:100%" href="<?= base_url('upload-cloud/getFile/')?>${response.id}" target="_blank" class="btn btn-xs btn-primary">
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
					$(".btn-send").removeClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',false);
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				alert("Error");
				$(".btn-send").removeClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',false);
			}
		});

	}
}

$(document).ready(function(){
	if($("#surat_keluar").val()=='2'){
		$(".div_divisi").removeClass('hide')
		$(".div_teamleader").addClass('hide')
	}else{
		$(".div_divisi").addClass('hide')
		$(".div_teamleader").removeClass('hide')
		let ad_id = '<?= $arsip['ad_id'] ?>'
		if(ad_id!=''){
			let departement_id = '<?= $arsip['ad_departemen'] ?>'
			getTeamLeader(departement_id)
		}	
	}
	
})

</script>
