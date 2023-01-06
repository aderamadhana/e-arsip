<div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header text-right">
        <img src="<?= base_url('webfile/logo-bri2.ico') ?>" width="100px" />
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body text-center">
                        <h3><b><?= $page_name ?></b></h3>
                        <img src="<?= base_url('webfile/success-icon.png') ?>" width="100px" />
                        <br>
                        <br>
                        <p>Tanggal Rapat Direksi</p>
                        <p><?= $waktu_notulen; ?></p>
                        <p><?= $jabatan; ?></p>
                        <br>
                        <p>Berhasil Tersimpan!</p>
                        <br>
                        <p>Tanggal, <?= $tanggal; ?></p>
                        <p>Waktu <?= $waktu; ?> WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>