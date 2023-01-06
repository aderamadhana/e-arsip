<div class="box box-solid">
	<div class="box-body no-padding">
		<ul class="nav nav-pills nav-justified">
			<li class="<?= ( $this->uri->segment(2) == 'surat_keluar' ) ? 'active bg-green' :'' ?>">
				<a style="<?= ( $this->uri->segment(2) == 'surat_keluar' ) ? 'color: white;' :'' ?>" href="<?= base_url('Arsip_dokumen/surat_keluar') ?>"><i class="fa fa-envelope-o"></i> Surat Keluar
				</a>
			</li>
			<li class="<?= ( $this->uri->segment(2) == 'booking' ) ? 'active bg-green' :'' ?>">
				<a style="<?= ( $this->uri->segment(2) == 'booking' ) ? 'color: white;' :'' ?>" href="<?= base_url('Arsip_dokumen/booking') ?>"><i class="fa fa-align-justify"></i> Booking Slot
				</a>
			</li>
		</ul>
	</div>
	<!-- /.box-body -->
</div>
