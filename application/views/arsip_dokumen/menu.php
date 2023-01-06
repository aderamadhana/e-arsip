<div class="box box-solid">
	<div class="box-body no-padding">
		<?php
		if (@$_GET['status'] == '') {
			if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' or $this->session->userdata('role_slug') == 'sekretaris_divisi') {
				@$_GET['status'] = '';
			} else {
				@$_GET['status'] = 'didisposisikan';
				@$_GET['tipe'] = 'inbox';
			}
		}
		?>
		<ul class="nav nav-pills nav-justified">
			<?php if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' or $this->session->userdata('role_slug') == 'kepala_departemen') { ?>
				<li class="<?= (@$_GET['status'] == 'diajukan') ? 'active bg-green' : ''; ?>">
					<a style="<?= (@$_GET['tipe'] == 'diajukan') ? 'color: white;' : ''; ?>" href="<?= base_url('arsip_dokumen?status=diajukan') ?>">
						<img width="16" height="16" src="<?= base_url('assets/images/new-icons/Menunggu Disposisi.png') ?>" /> Menunggu Disposisi
						<!-- <i class="fa fa-inbox"></i>  -->
					</a>
				</li>
			<?php } ?>
			<li class="<?= (@$_GET['tipe'] == 'inbox') ? 'active bg-green' : ''; ?>">
				<a style="<?= (@$_GET['tipe'] == 'inbox') ? 'color: white;' : ''; ?>" href="<?= base_url('arsip_dokumen?status=didisposisikan&tipe=inbox') ?>">
					<img width="16" height="16" src="<?= base_url('assets/images/new-icons/Inbox.png') ?>" /> Inbox
					<!-- <i class="fa fa-inbox"></i> -->
					<span class="label label-primary float-right"><?= $inbox['total'] ?></span>
				</a>
			</li>

			<li class="<?= (@$_GET['status'] == 'didisposisikan' && @$_GET['tipe'] == '') ? 'active bg-green' : ''; ?>">
				<a style="<?= (@$_GET['status'] == 'didisposisikan' && @$_GET['tipe'] == '') ? 'color: white;' : ''; ?>" href="<?= base_url('arsip-dokumen?status=didisposisikan') ?>">
					<img width="16" height="16" src="<?= base_url('assets/images/new-icons/Sudah Disposisi.png') ?>" /> Sudah Didisposisi
					<!-- <i class="fa fa-envelope-o"></i> -->
				</a>
			</li>
			<li class="<?= (@$_GET['status'] == 'ditindaklanjuti' && @$_GET['tipe'] == '') ? 'active bg-green' : ''; ?>">
				<a style="<?= (@$_GET['status'] == 'ditindaklanjuti' && @$_GET['tipe'] == '') ? 'color: white;' : ''; ?>" href="<?= base_url('arsip-dokumen?status=ditindaklanjuti') ?>">
					<img width="16" height="16" src="<?= base_url('assets/images/new-icons/Sudah Ditindaklanjuti.png') ?>" /> Sudah Ditindaklanjuti
					<!-- <i class="fa fa-check"></i> -->
				</a>
			</li>
			<?php
			if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_departemen', 'sekretaris_divisi'])) :
			?>
				<li class="<?= (@$_GET['status'] == 'draft') ? 'active bg-green' : ''; ?>">
					<a style="<?= (@$_GET['tipe'] == 'draft') ? 'color: white;' : ''; ?>" href="<?= base_url('arsip-dokumen?status=draft') ?>">
						<img width="16" height="16" src="<?= base_url('assets/images/new-icons/Draft.png') ?>" /> Draft
						<!-- <i class="fa fa-file-text-o"></i> -->
						<span class="label label-primary float-right"><?= $draft['total'] ?></span>
					</a>
				</li>
			<?php
			endif;
			?>

			<!-- <li class="<?= (@$_GET['status'] == 'void') ? 'active' : ''; ?>"><a href="<?= base_url('arsip-dokumen?status=void') ?>"><i class="fa fa-trash-o"></i> Void</a></li> -->
		</ul>
	</div>
</div>
<!-- <div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title">Labels</h3>
		<div class="box-tools">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body no-padding">
		<ul class="nav nav-pills nav-stacked">
			<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span class="badge bg-red">Sangat Rahasia</a></span></li>
			<li><a href="#"><i class="fa fa-circle-o text-yellow"></i><span class="badge bg-yellow"> Rahasia</span></a></li>
			<li><a href="#"><i class="fa fa-circle-o text-light-green"></i><span class="badge bg-green"> Biasa</span></a></li>
		</ul>
	</div>
</div> -->