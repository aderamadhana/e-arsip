<!-- Import Library Signature Pad -->
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/signaturepad/assets/jquery.signaturepad.css">
<script src="<?= base_url('assets/') ?>plugins/signaturepad/jquery.signaturepad.js"></script>
<?php
function hari_ini($hari)
{
    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }
    return $hari_ini;

    $judulrapat['rapat_direksi'] = 'Rapat Direksi';
    $judulrapat['komite_komisaris'] = 'Rapat Komisaris';
    $judulrapat['komite_direksi'] = 'Rapat Komite Direksi';
    $judulrapat['rapat_gabungan'] = 'Rapat Gabungan';

}
?>
<div class="content-wrapper">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href="<?= base_url('master/Absensi-rapat?tipe_rapat=' . $tipe_rapat); ?>" role="button" class="btn btn-warning" role="button"><i class="fa fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#edit_rapat" data-toggle="tab">Edit Agenda Rapat</a></li>

                                         <?php if ($tipe_rapat == "komite_komisaris") { ?>
                                             <li><a href="#edit_komisaris" data-toggle="tab">Absensi Komisaris</a></li>
                                             <li><a href="#edit_non_komisaris" data-toggle="tab">Absensi Non Komisaris</a></li>
                                        <?php }elseif ($tipe_rapat == "rapat_gabungan") { ?>
                                             <li><a href="#edit_komisaris" data-toggle="tab">Absensi Komisaris</a></li>
                                             <li><a href="#edit_direksi" data-toggle="tab">Edit Absensi Direksi</a></li>
                                             <li><a href="#edit_sevp" data-toggle="tab">Edit Absensi SEVP</a></li>
                                        <?php } else{ ?>
                                            <li><a href="#edit_direksi" data-toggle="tab">Edit Absensi Direksi</a></li>
                                            <li><a href="#edit_sevp" data-toggle="tab">Edit Absensi SEVP</a></li>
                                        <?php } ?>

                                        <li><a href="#edit_pemateri" data-toggle="tab">Edit Absensi Pemateri</a></li>
                                        <li><a href="#edit_pendamping" data-toggle="tab">Edit Absensi Pendamping</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="edit_rapat">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="<?= base_url('master/Absensi_rapat/update_agenda') ?>" method="POST" id="upload-create" enctype="multipart/form-data">
                                                        <input type="hidden" name="dt[ar_id]" id="ar_id" value="<?= $absensi_rapat['ar_id']; ?>" />
                                                        <input type="hidden" name="tipe_rapat" id="tipe_rapat" value="<?= $tipe_rapat; ?>" />

                                                        <?php if ($tipe_rapat == "komite_direksi" || $tipe_rapat == "komite_komisaris") { ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="margin-top: 25px;">
                                                                        <label class="col-sm-2 control-label">Komite</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control" name="dt[ar_mk_id]">
                                                                                <option value="">-- Pilih --</option>
                                                                                <?php 

                                                                                    if ($tipe_rapat == 'komite_direksi') {
                                                                                        $this->db->where('mk_role_nama', 'Rapat Komite Direksi');
                                                                                    }elseif ($tipe_rapat == 'komite_komisaris') {
                                                                                        $this->db->where('mk_role_nama', 'Rapat Komite Komisaris');
                                                                                    }

                                                                                    if (@$this->session->userdata('komite_id')) {
                                                                                        $this->db->where_in('mk_id', $this->session->userdata('komite_id'));
                                                                                    }
                                                                                    $dataKomite = $this->mymodel->selectWhere('master_komite', ['status'=>'ENABLE']);
                                                                                    foreach ($dataKomite as $kom_rec) { ?>
                                                                                        <option value="<?= $kom_rec['mk_id'] ?>" <?= ($absensi_rapat['ar_mk_id'] == $kom_rec['mk_id']) ? 'selected' : ''; ?>><?= $kom_rec['mk_nama'] ?></option>    
                                                                                    <?php }
                                                                                 ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="row">
                                                            <?php if ($tipe_rapat == "komite_direksi") { ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="margin-top: 25px;">
                                                                        <label class="col-sm-2 control-label">Sub Komite</label>
                                                                        <div class="col-sm-3">
                                                                            <table class="table table-condensed table-hover table-bordered sub_komite" style="width: 100%;" id="sortable_sub">
                                                                                <?php $counter_sub = 0; ?>
                                                                                <?php $sub_komite = json_decode($absensi_rapat['ar_sub_komite']); ?>
                                                                                <?php if ($sub_komite) { ?>
                                                                                    <?php foreach ($sub_komite as $key_sub => $val_sub) { ?>
                                                                                        <tr>
                                                                                            <td><input type="text" class="form-control" name="dt[sub_komite][]" id="sub_komite_<?= $counter_sub; ?>" value="<?= $val_sub; ?>" placeholder="Masukkan Sub Komite..." /></td>
                                                                                            <td>
                                                                                                <?php if ($counter_sub == 0) { ?>
                                                                                                    <center><button type="button" class="btn btn-success" id="tambah_sub"><i class="fa fa-plus"></i></center>
                                                                                                <?php } else { ?>
                                                                                                    <center><button type="button" class="btn btn-danger button-delete-sub" value="<?= $counter_sub; ?>"><i class="fa fa-close"></i></button></center>
                                                                                                <?php } ?>

                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php $counter_sub++; ?>
                                                                                    <?php } ?>
                                                                                <?php } else { ?>
                                                                                    <tr>
                                                                                        <td><input type="text" class="form-control" name="dt[sub_komite][]" id="sub_komite_<?= $counter_sub; ?>" placeholder="Masukkan Sub Komite..." /></td>
                                                                                        <td>
                                                                                            <center><button type="button" class="btn btn-success" id="tambah_sub"><i class="fa fa-plus"></i></center>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-md-12">
                                                                <div class="form-group" style="margin-top: 25px;">
                                                                    <label class="col-sm-2 control-label">Tanggal Rapat</label>
                                                                    <div class="col-sm-3">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control tgl" name="dt[ar_tanggal]" value="<?= $absensi_rapat['ar_tanggal']; ?>">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group" style="margin-top: 25px;">
                                                                    <label class="col-sm-2 control-label">Lokasi Rapat</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control select2" name="dt[ar_lokasi]" id="lokasi_rapat" onchange="lokasi()">
                                                                            <option>--- Pilih Lokasi Rapat ---</option>
                                                                            <option value="Ruang Integrity / Gedung Kantor Pusat BRI" <?= ($absensi_rapat['ar_lokasi'] == "Ruang Integrity / Gedung Kantor Pusat BRI") ? "selected" : ""; ?>>Ruang Integrity / Gedung Kantor Pusat BRI</option>
                                                                            <option value="Work From Anywhere" <?= ($absensi_rapat['ar_lokasi'] == "Work From Anywhere") ? "selected" : ""; ?>>Work From Anywhere</option>
                                                                            <option value="Lainnya" <?= ($absensi_rapat['ar_lokasi'] == "Lainnya") ? "selected" : ""; ?>>Lainnya</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="lokasi_lainnya" <?= ($absensi_rapat['ar_lokasi'] != "Lainnya") ? "style='display: none;'" : ""; ?>>
                                                                <div class=" col-md-12">
                                                                    <div class="form-group" style="margin-top: 25px;">
                                                                        <label class="col-sm-2 control-label">Lokasi Rapat Lainnya</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control" name="dt[ar_lokasi_lainnya]" value="<?= $absensi_rapat['ar_lokasi_lainnya']; ?>" placeholder="Masukkan Lokasi Lainnya..." />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="margin-top: 25px;">
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label">Jumlah Kuorum</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="number" class="form-control" name="dt[ar_jumlah]" value="<?= $absensi_rapat['ar_jumlah']; ?>" id="jumlah_kuorum" onInput="cekJumlahKuorum(event);">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="margin-top: 25px;">
                                                                <div class="form-group">
                                                                    <label class="col-sm-12 control-label">
                                                                        Agenda Rapat
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="margin-top: 25px;">
                                                                <div class="table-responsive">
                                                                    <p style="color: red;"><i>Silahkan klik tombol + untuk menambahkan data</i></p>
                                                                    <table class="table table-condensed table-hover table-bordered agenda-rapat" style="width: 100%;" id="sortable">
                                                                        <thead>
                                                                            <tr class="bg-navy">
                                                                                <th style="width: 50px;">#</th>
                                                                                <th style="width: 400px;">Agenda Rapat</th>
                                                                                <th style="width: 100px;">Jam Mulai</th>
                                                                                <th style="width: 100px;">Jam Selesai</th>
                                                                                <th style="width: 400px;">Divisi Pemateri</th>
                                                                                <th style="width: 400px;">Divisi Pendamping</th>
                                                                                <th style="width: 40px;"><button type="button" class="btn btn-success" id="tambah_baris"><i class="fa fa-plus"></i></button></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $counter = 0; ?>
                                                                            <?php if ($absensi_rapat_agenda) { ?>
                                                                                <?php foreach ($absensi_rapat_agenda as $val_rapat) { ?>
                                                                                    <tr>
                                                                                        <td style="width: 50px;">
                                                                                            <center>
                                                                                                <i class="fa fa-bars"></i>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td style="width: 400px;">
                                                                                            <input type="text" class="form-control" name="dt[agenda][]" id="agenda_<?= $counter; ?>" placeholder="Masukkan Nama Agenda..." value="<?= $val_rapat['ara_nama']; ?>" />
                                                                                        </td>
                                                                                        <td style="width: 100px;">
                                                                                            <?php $jam_mulai = strtotime($val_rapat['ara_mulai']); ?>
                                                                                            <input type="text" class="form-control timepicker" name="dt[mulai][]" id="mulai_<?= $counter; ?>" value="<?= date("H:i", $jam_mulai); ?>" />
                                                                                        </td>
                                                                                        <td style="width: 100px;">
                                                                                            <?php $jam_selesai = strtotime($val_rapat['ara_selesai']); ?>
                                                                                            <input type="text" class="form-control timepicker" name="dt[selesai][]" id="selesai_<?= $counter; ?>" value="<?= date("H:i", $jam_selesai); ?>" />
                                                                                        </td>
                                                                                        <td style="width: 400px;">
                                                                                            <select class="form-control select2" multiple="multiple" id="pemateri_<?= $counter; ?>" style="width:100%" onchange="multiple_pemateri(<?= $counter; ?>)">
                                                                                                <option value="">--- Pilih Divisi Pemateri ---</option>
                                                                                                <?php
                                                                                                $pemateri = $this->mymodel->selectWhere('m_divisi', ['status' => 'ENABLE']);
                                                                                                foreach ($pemateri as $val_pemateri) { ?>
                                                                                                    <option value="<?= $val_pemateri['md_id'] ?>" <?= (in_array($val_pemateri['md_id'], json_decode($val_rapat['ara_id_divisi_materi']))) ? "selected" : ""; ?>><?= $val_pemateri['md_nama']; ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                            <?php
                                                                                            $value_pemateri = "";
                                                                                            $numbering = 1;
                                                                                            foreach (json_decode($val_rapat['ara_id_divisi_materi']) as $matt) {
                                                                                                if (($numbering % 2) == 0) {
                                                                                                    $value_pemateri .= "," . $matt;
                                                                                                } else {
                                                                                                    $value_pemateri .= $matt;
                                                                                                }
                                                                                                $numbering++;
                                                                                            }
                                                                                            ?>
                                                                                            <input type="hidden" name="dt[pemateri][]" id="value_pemateri_<?= $counter; ?>" value="<?= $value_pemateri; ?>" />
                                                                                        </td>
                                                                                        <td style="width: 400px;">
                                                                                            <select class="form-control select2" multiple="multiple" id="pendamping_<?= $counter; ?>" style="width:100%" onchange="multiple_pendamping(<?= $counter; ?>)">
                                                                                                <option value="">--- Pilih Divisi Pendamping ---</option>
                                                                                                <?php
                                                                                                $pendamping = $this->mymodel->selectWhere('m_divisi', ['status' => 'ENABLE']);
                                                                                                foreach ($pendamping as $val_pendamping) { ?>
                                                                                                    <option value="<?= $val_pendamping['md_id'] ?>" <?= (in_array($val_pendamping['md_id'], json_decode($val_rapat['ara_id_divisi_pendamping']))) ? "selected" : ""; ?>><?= $val_pendamping['md_nama']; ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                            <?php
                                                                                            $value_pendamping = "";
                                                                                            $numbering = 1;
                                                                                            foreach (json_decode($val_rapat['ara_id_divisi_pendamping']) as $pmdd) {
                                                                                                if (($numbering % 2) == 0) {
                                                                                                    $value_pendamping .= "," . $matt;
                                                                                                } else {
                                                                                                    $value_pendamping .= $matt;
                                                                                                }
                                                                                                $numbering++;
                                                                                            }
                                                                                            ?>
                                                                                            <input type="hidden" name="dt[pendamping][]" id="value_pendamping_<?= $counter; ?>" value="<?= $value_pendamping; ?>" />
                                                                                        </td>
                                                                                        <td style="width: 40px;">
                                                                                            <button type="button" class="btn btn-danger button-delete" value="0"><i class="fa fa-close"></i></button>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php $counter++; ?>
                                                                                <?php } ?>
                                                                            <?php } else { ?>
                                                                                <?php $counter++; ?>
                                                                                <tr>
                                                                                    <td style="width: 50px;">
                                                                                        <center>
                                                                                            <i class="fa fa-bars"></i>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td style="width: 400px;">
                                                                                        <input type="text" class="form-control" name="dt[agenda][]" id="agenda_0" placeholder="Masukkan Nama Agenda..." />
                                                                                    </td>
                                                                                    <td style="width: 100px;">
                                                                                        <input type="text" class="form-control timepicker" name="dt[mulai][]" id="mulai_0" />
                                                                                    </td>
                                                                                    <td style="width: 100px;">
                                                                                        <input type="text" class="form-control timepicker" name="dt[selesai][]" id="selesai_0" />
                                                                                    </td>
                                                                                    <td style="width: 400px;">
                                                                                        <select class="form-control select2" multiple="multiple" id="pemateri_0" style="width:100%" onchange="multiple_pemateri(0)">
                                                                                            <option value="">--- Pilih Divisi Pemateri ---</option>
                                                                                            <?php
                                                                                            $pemateri = $this->mymodel->selectWhere('m_divisi', ['status' => 'ENABLE']);
                                                                                            foreach ($pemateri as $val_pemateri) { ?>
                                                                                                <option value="<?= $val_pemateri['md_id'] ?>"><?= $val_pemateri['md_nama']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                        <input type="hidden" name="dt[pemateri][]" id="value_pemateri_0" />
                                                                                    </td>
                                                                                    <td style="width: 400px;">
                                                                                        <select class="form-control select2" multiple="multiple" id="pendamping_0" style="width:100%" onchange="multiple_pendamping(0)">
                                                                                            <option value="">--- Pilih Divisi Pendamping ---</option>
                                                                                            <?php
                                                                                            $pendamping = $this->mymodel->selectWhere('m_divisi', ['status' => 'ENABLE']);
                                                                                            foreach ($pendamping as $val_pendamping) { ?>
                                                                                                <option value="<?= $val_pendamping['md_id'] ?>"><?= $val_pendamping['md_nama']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                        <input type="hidden" name="dt[pendamping][]" id="value_pendamping_0" />
                                                                                    </td>
                                                                                    <td style="width: 40px;">
                                                                                        <button type="button" class="btn btn-danger button-delete" value="0"><i class="fa fa-close"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                    <div class="pull-left">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="pull-right">
                                                                        <button type="button" onclick="saveData()" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="edit_komisaris">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <h4>Absensi Kehadiran Rapat Komisaris</h4>
                                                    </center>
                                                </div>
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped" style="width:100%">
                                                        <tr>
                                                            <th style="width:200px">Hari, Tanggal</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                                $day = date('D', $timestamp);
                                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:200px">Waktu</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                                $jam_mulai = strtotime($waktu['mulai']);
                                                                $jam_selesai = strtotime($waktu['selesai']);
                                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    &nbsp;
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama</th>
                                                                    <th colspan="2">Tanda Tangan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $number = 1;

                                                                // hitung total jumlah komisaris yang hadir
                                                                $absensi_komisaris_all = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => "Komisaris"]);
                                                                $jumlah_komisaris = count($absensi_komisaris_all);

                                                                // Komisaris 
                                                                $this->db->order_by('mpj_id', 'ASC');
                                                                $komisaris = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '3', 'status' => 'ENABLE']);
                                                                foreach ($komisaris as $dir) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <center><?= $number . "."; ?></center>
                                                                        </td>
                                                                        <td><?= $dir['mpj_nama']; ?></td>
                                                                        <?php
                                                                        // Get Tanda tangan
                                                                        $absensi_komisaris = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Komisaris', 'are_mpj_id' => $dir['mpj_id']]);
                                                                        ?>
                                                                        <?php if (($number % 2) != 0) { ?>
                                                                            <td style="width: 250px;">
                                                                                <?= $number . "."; ?>
                                                                                &nbsp;
                                                                                <?php
                                                                                if ($absensi_komisaris) {
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td style="width: 250px;"></td>
                                                                        <?php } else { ?>
                                                                            <td style="width: 250px;"></td>
                                                                            <td style="width: 250px;">
                                                                                <?= $number . "."; ?>
                                                                                &nbsp;
                                                                                <?php
                                                                                if ($absensi_komisaris) {
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <td>
                                                                            <center>
                                                                                <?php
                                                                                if ($jumlah_komisaris == $absensi_rapat['ar_jumlah']) {
                                                                                    if ($absensi_komisaris['are_id'] != NULL) { ?>
                                                                                        <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $absensi_komisaris['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                    <?php } else { ?>
                                                                                        Kuorum Sudah Penuh.
                                                                                    <?php }
                                                                                } else {
                                                                                    if ($absensi_komisaris['are_id'] != NULL) { ?>
                                                                                        <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $absensi_komisaris['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                    <?php } else { ?>
                                                                                        <button type="button" class="btn btn-success" onclick="absensi_direksi(<?= $dir['mpj_id']; ?>,3)"><i class="fa fa-plus"></i> Tambahkan Absensi</button>
                                                                                <?php }
                                                                                }
                                                                                ?>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $number++; ?>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="edit_direksi">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <h4>Absensi Kehadiran <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                                    </center>
                                                </div>
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped" style="width:100%">
                                                        <tr>
                                                            <th style="width:200px">Hari, Tanggal</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                                $day = date('D', $timestamp);
                                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:200px">Waktu</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                                $jam_mulai = strtotime($waktu['mulai']);
                                                                $jam_selesai = strtotime($waktu['selesai']);
                                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    &nbsp;
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama</th>
                                                                    <th colspan="2">Tanda Tangan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $number = 1;

                                                                // hitung total jumlah direksi yang hadir
                                                                $absensi_direksi_all = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => "Direksi"]);
                                                                $jumlah_direksi = count($absensi_direksi_all);

                                                                // Direksi 
                                                                $this->db->order_by('mpj_id', 'ASC');
                                                                $direksi = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '1', 'status' => 'ENABLE']);
                                                                foreach ($direksi as $dir) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <center><?= $number . "."; ?></center>
                                                                        </td>
                                                                        <td><?= $dir['mpj_nama']; ?></td>
                                                                        <?php
                                                                        // Get Tanda tangan
                                                                        $absensi_direksi = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Direksi', 'are_mpj_id' => $dir['mpj_id']]);
                                                                        ?>
                                                                        <?php if (($number % 2) != 0) { ?>
                                                                            <td style="width: 250px;">
                                                                                <?= $number . "."; ?>
                                                                                &nbsp;
                                                                                <?php
                                                                                if ($absensi_direksi) {
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td style="width: 250px;"></td>
                                                                        <?php } else { ?>
                                                                            <td style="width: 250px;"></td>
                                                                            <td style="width: 250px;">
                                                                                <?= $number . "."; ?>
                                                                                &nbsp;
                                                                                <?php
                                                                                if ($absensi_direksi) {
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <td>
                                                                            <center>
                                                                                <?php
                                                                                if ($jumlah_direksi == $absensi_rapat['ar_jumlah']) {
                                                                                    if ($absensi_direksi['are_id'] != NULL) { ?>
                                                                                        <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $absensi_direksi['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                    <?php } else { ?>
                                                                                        Kuorum Sudah Penuh.
                                                                                    <?php }
                                                                                } else {
                                                                                    if ($absensi_direksi['are_id'] != NULL) { ?>
                                                                                        <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $absensi_direksi['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                    <?php } else { ?>
                                                                                        <button type="button" class="btn btn-success" onclick="absensi_direksi(<?= $dir['mpj_id']; ?>,1)"><i class="fa fa-plus"></i> Tambahkan Absensi</button>
                                                                                <?php }
                                                                                }
                                                                                ?>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $number++; ?>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="edit_sevp">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <h4>Absensi Kehadiran SEVP <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                                    </center>
                                                </div>
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped" style="width:100%">
                                                        <tr>
                                                            <th style="width:200px">Hari, Tanggal</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                                $day = date('D', $timestamp);
                                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:200px">Waktu</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                                $jam_mulai = strtotime($waktu['mulai']);
                                                                $jam_selesai = strtotime($waktu['selesai']);
                                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    &nbsp;
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama</th>
                                                                    <th colspan="2">Tanda Tangan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $number = 1;
                                                                // SEVP 
                                                                $this->db->order_by('mpj_id', 'ASC');
                                                                $sevp = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '2', 'status' => 'ENABLE']);
                                                                foreach ($sevp as $sev) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <center><?= $number . "."; ?></center>
                                                                        </td>
                                                                        <td><?= $sev['mpj_nama']; ?></td>
                                                                        <?php
                                                                        // Get Tanda tangan
                                                                        $absensi_direksi = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'SEVP', 'are_mpj_id' => $sev['mpj_id']]);
                                                                        ?>
                                                                        <?php if (($number % 2) != 0) { ?>
                                                                            <td style="width: 250px;">
                                                                                <?= $number . "."; ?>
                                                                                &nbsp;
                                                                                <?php
                                                                                if ($absensi_direksi) {
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td style="width: 250px;"></td>
                                                                        <?php } else { ?>
                                                                            <td style="width: 250px;"></td>
                                                                            <td style="width: 250px;">
                                                                                <?= $number . "."; ?>
                                                                                &nbsp;
                                                                                <?php
                                                                                if ($absensi_direksi) {
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <td>
                                                                            <center>
                                                                                <?php if ($absensi_direksi['are_id'] != NULL) { ?>
                                                                                    <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $absensi_direksi['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                <?php } else { ?>
                                                                                    <button type="button" class="btn btn-success" onclick="absensi_direksi(<?= $sev['mpj_id']; ?>,2)"><i class="fa fa-plus"></i> Tambahkan Absensi</button>
                                                                                <?php } ?>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $number++; ?>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="edit_non_komisaris">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <h4>Absensi Kehadiran Divisi Non Komisaris pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                                    </center>
                                                </div>
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped" style="width:100%">
                                                        <tr>
                                                            <th style="width:200px">Hari, Tanggal</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                                $day = date('D', $timestamp);
                                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:200px">Waktu</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                                $jam_mulai = strtotime($waktu['mulai']);
                                                                $jam_selesai = strtotime($waktu['selesai']);
                                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-success" onclick="absensi_divisi(3)"><i class="fa fa-plus"></i> Tambahkan Absensi</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama Pejabat</th>
                                                                    <th colspan="2">Tanda Tangan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $number = 1;
                                                                $this->db->order_by('are_id', 'ASC');
                                                                $non_komisaris = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Non Komisaris', 'are_status_kehadiran' => 'Hadir']);
                                                                if ($non_komisaris) {
                                                                    foreach ($non_komisaris as $div) {
                                                                ?>
                                                                        <tr>
                                                                            <td>
                                                                                <center><?= $number . "."; ?></center>
                                                                            </td>
                                                                            <td><?= $div['are_nama_pejabat_divisi']; ?></td>\
                                                                            <?php if (($number % 2) != 0) { ?>
                                                                                <td style="width: 250px;">
                                                                                    <?= $number . "."; ?>
                                                                                    &nbsp;
                                                                                    <?php
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td style="width: 250px;"></td>
                                                                            <?php } else { ?>
                                                                                <td style="width: 250px;"></td>
                                                                                <td style="width: 250px;">
                                                                                    <?= $number . "."; ?>
                                                                                    &nbsp;
                                                                                    <?php
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <td>
                                                                                <center>
                                                                                    <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $div['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                </center>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $number++; ?>
                                                                    <?php
                                                                    }
                                                                } else { ?>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <center>
                                                                                <b>
                                                                                    Belum ada Non Komisaris yang melakukan Absensi.
                                                                                </b>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="edit_pemateri">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <h4>Absensi Kehadiran Divisi Pemateri pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                                    </center>
                                                </div>
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped" style="width:100%">
                                                        <tr>
                                                            <th style="width:200px">Hari, Tanggal</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                                $day = date('D', $timestamp);
                                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:200px">Waktu</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                                $jam_mulai = strtotime($waktu['mulai']);
                                                                $jam_selesai = strtotime($waktu['selesai']);
                                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-success" onclick="absensi_divisi(1)"><i class="fa fa-plus"></i> Tambahkan Absensi</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama Pejabat</th>
                                                                    <th>Nama Divisi</th>
                                                                    <th colspan="2">Tanda Tangan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $number = 1;
                                                                $this->db->order_by('are_id', 'ASC');
                                                                $divisi = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Pemateri', 'are_status_kehadiran' => 'Hadir']);
                                                                if ($divisi) {
                                                                    foreach ($divisi as $div) {
                                                                ?>
                                                                        <tr>
                                                                            <td>
                                                                                <center><?= $number . "."; ?></center>
                                                                            </td>
                                                                            <td><?= $div['are_nama_pejabat_divisi']; ?></td>
                                                                            <td><?= $div['are_md_nama']; ?></td>
                                                                            <?php if (($number % 2) != 0) { ?>
                                                                                <td style="width: 250px;">
                                                                                    <?= $number . "."; ?>
                                                                                    &nbsp;
                                                                                    <?php
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td style="width: 250px;"></td>
                                                                            <?php } else { ?>
                                                                                <td style="width: 250px;"></td>
                                                                                <td style="width: 250px;">
                                                                                    <?= $number . "."; ?>
                                                                                    &nbsp;
                                                                                    <?php
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <td>
                                                                                <center>
                                                                                    <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $div['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                </center>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $number++; ?>
                                                                    <?php
                                                                    }
                                                                } else { ?>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <center>
                                                                                <b>
                                                                                    Belum ada Divisi Pemateri yang melakukan Absensi.
                                                                                </b>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="edit_pendamping">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <h4>Absensi Kehadiran Divisi Pendamping pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                                    </center>
                                                </div>
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped" style="width:100%">
                                                        <tr>
                                                            <th style="width:200px">Hari, Tanggal</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                                $day = date('D', $timestamp);
                                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:200px">Waktu</th>
                                                            <th style="width:1px"> : </th>
                                                            <td>
                                                                <?php
                                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                                $jam_mulai = strtotime($waktu['mulai']);
                                                                $jam_selesai = strtotime($waktu['selesai']);
                                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-success" onclick="absensi_divisi(2)"><i class="fa fa-plus"></i> Tambahkan Absensi</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama Pejabat</th>
                                                                    <th>Nama Divisi</th>
                                                                    <th colspan="2">Tanda Tangan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $number = 1;
                                                                $this->db->order_by('are_id', 'ASC');
                                                                $divisi = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Pendamping', 'are_status_kehadiran' => 'Hadir']);
                                                                if ($divisi) {
                                                                    foreach ($divisi as $div) {
                                                                ?>
                                                                        <tr>
                                                                            <td>
                                                                                <center><?= $number . "."; ?></center>
                                                                            </td>
                                                                            <td><?= $div['are_nama_pejabat_divisi']; ?></td>
                                                                            <td><?= $div['are_md_nama']; ?></td>
                                                                            <?php if (($number % 2) != 0) { ?>
                                                                                <td style="width: 250px;">
                                                                                    <?= $number . "."; ?>
                                                                                    &nbsp;
                                                                                    <?php
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td style="width: 250px;"></td>
                                                                            <?php } else { ?>
                                                                                <td style="width: 250px;"></td>
                                                                                <td style="width: 250px;">
                                                                                    <?= $number . "."; ?>
                                                                                    &nbsp;
                                                                                    <?php
                                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                                    if (file_exists($filename)) {
                                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <td>
                                                                                <center>
                                                                                    <button type="button" class="btn btn-danger" onclick="hapus_absensi(<?= $div['are_id'] ?>)"><i class="fa fa-trash"></i> Hapus Absensi</button>
                                                                                </center>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $number++; ?>
                                                                    <?php
                                                                    }
                                                                } else { ?>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <center>
                                                                                <b>
                                                                                    Belum ada Divisi Pendamping yang melakukan Absensi.
                                                                                </b>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Absensi -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" m_divisi="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
    <div class="modal-dialog modal-md" style="width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="title-form"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div id="load-form"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var counter = <?= $counter; ?>;

    $(document).ready(function() {
        $("#sortable tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    // Set helper cell sizes to match the original sizes
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            }
        }).disableSelection();

        $("#tambah_baris").on("click", function() {
            counter++;

            var newRow = $("<tr>");
            var cols = "";

            cols += '<td style="width: 50px;"><center><i class="fa fa-bars"></i></center></td>';
            cols += '<td style="width: 400px;"><input type="text" class="form-control" name="dt[agenda][]" id="agenda_' + counter + '" placeholder="Masukkan Nama Agenda..."></td>';
            cols += '<td style="width: 100px;"><input type="text" class="form-control timepicker2" name="dt[mulai][]" id="mulai_' + counter + '"></td>';
            cols += '<td style="width: 100px;"><input type="text" class="form-control timepicker2" name="dt[selesai][]" id="selesai_' + counter + '"></td>';


            var drop_pemateri = '<td style="width: 400px;"><select class="form-control select2" multiple="multiple" id="pemateri_' + counter + '" onchange="multiple_pemateri(' + counter + ')">' +
                '<option>--- Pilih Divisi Pemateri ---</option>' +
                <?php foreach ($pemateri as $val_pemateri) { ?> '<option value="<?= $val_pemateri['md_id'] ?>"><?= $val_pemateri['md_nama']; ?></option>' +
                <?php } ?> '</select>' +
                '<input type="hidden" name="dt[pemateri][]" id="value_pemateri_' + counter + '" />';
            cols += drop_pemateri;

            var drop_pembanding = '<td style="width: 400px;"><select class="form-control select2" multiple="multiple" id="pendamping_' + counter + '" onchange="multiple_pendamping(' + counter + ')">' +
                '<option>--- Pilih Divisi Pendamping --</option>' +
                <?php foreach ($pendamping as $val_pendamping) { ?> '<option value="<?= $val_pendamping['md_id'] ?>"><?= $val_pendamping['md_nama']; ?></option>' +
                <?php } ?> '</select>' +
                '<input type="hidden" name="dt[pendamping][]" id="value_pendamping_' + counter + '" />';
            cols += drop_pembanding;

            cols += '<td style="width: 40px;"><button type="button" class="btn btn-danger button-delete" value="' + counter + '"><i class="fa fa-close"></i></button></td>';

            newRow.append(cols);
            $("table.agenda-rapat").append(newRow);
            activatePluginTimePicker();
            $('.select2').select2();
        });

        $("table.agenda-rapat").on("click", ".button-delete", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });

    var counter_sub = <?= (@$counter_sub) ? $counter_sub : 0; ?>;
    $(document).ready(function() {

        $("#tambah_sub").on("click", function() {
            counter_sub++;
            var newRow = $("<tr>");
            var cols = "";
            cols += '<td><input type="text" class="form-control" name="dt[sub_komite][]" id="sub_komite_' + counter_sub + '" placeholder="Masukkan Sub Komite..."></td>';
            cols += '<td><center><button type="button" class="btn btn-danger button-delete-sub" value="' + counter_sub + '"><i class="fa fa-close"></i></button></center></td>';
            newRow.append(cols);
            $("table.sub_komite").append(newRow);
        });

        $("table.sub_komite").on("click", ".button-delete-sub", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });

    function activatePluginTimePicker() {
        $('.timepicker2').timepicker({
            showInputs: false,
            showMeridian: false
        });
    }

    function multiple_pemateri(number) {
        var target_dropdown = "#pemateri_" + number;
        var target_value = "#value_pemateri_" + number;
        var select2Value = $(target_dropdown).val();
        $(target_value).val(select2Value);
    }

    function multiple_pendamping(number) {
        var target_dropdown = "#pendamping_" + number;
        var target_value = "#value_pendamping_" + number;
        var select2Value = $(target_dropdown).val();
        $(target_value).val(select2Value);
    }

    function lokasi() {
        var value_lokasi = $("#lokasi_rapat").val();
        if (value_lokasi == "Lainnya") {
            $(".lokasi_lainnya").show(1000);
        } else {
            $(".lokasi_lainnya").hide(1000);
        }
    }

    function saveData() {
        $("#upload-create").submit();
    }

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
                $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);
            },
            success: function(response, textStatus, xhr) {
                // alert(mydata);
                var str = response;
                if (str.indexOf("success") != -1) {
                    Swal.fire({
                        title: "Sukses",
                        text: "Agenda Rapat Berhasil di Perbarui.",
                        icon: "success"
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                } else {
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    Swal.fire({
                        title: "Oppss!",
                        html: str,
                        icon: "error"
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                Swal.fire({
                    title: "Oppss!",
                    text: xhr,
                    icon: "error"
                });
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
            }
        });

        return false;
    });

    function hapus_absensi(are_id) {
        Swal.fire({
            title: 'Perhatian ?',
            text: "Anda yakin ingin menghapus data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data.'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('master/Absensi_rapat/delete_absensi') ?>',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        are_id: are_id
                    },
                    beforeSend: function() {},
                    success: function(response, textStatus, xhr) {
                        var str = response;
                        if (str.indexOf("success") != -1) {
                            Swal.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            );
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            Swal.fire({
                                title: "Oppss!",
                                html: str,
                                icon: "error"
                            });
                        }
                    }
                });
            }
        })
    }

    function absensi_direksi(mpj_id, tipe) {
        var ar_id = $("#ar_id").val();
        $("#load-form").html('loading...');
        $("#modal-form").modal();

        if (tipe == 1) {
            $("#title-form").html('Tambah Absensi Direksi');
        }else if(tipe == 3) {
            $("#title-form").html('Tambah Absensi Komisaris');
        }else {
            $("#title-form").html('Tambah Absensi SEVP');
        }

        $("#load-form").load("<?= base_url('master/Absensi_rapat/create_absensi_direksi/') ?>" + tipe + "/" + ar_id + "/" + mpj_id);
    }

    function absensi_divisi(tipe) {
        var ar_id = $("#ar_id").val();
        $("#load-form").html('loading...');
        $("#modal-form").modal();

        if (tipe == 1) {
            $("#title-form").html('Tambah Absensi Pemateri');
        }else if(tipe == 3){
            $("#title-form").html('Tambah Absensi Non Komisaris');
        }else {
            $("#title-form").html('Tambah Absensi Pendamping');
        }

        $("#load-form").load("<?= base_url('master/Absensi_rapat/create_absensi_divisi/') ?>" + tipe + "/" + ar_id);
    }

    function cekJumlahKuorum(e) {
        let value = e.target.value;
        if(value > 12) {
            Swal.fire({
                title: "Peringatan!",
                text: "Jumlah kuorum maksimal 12.",
                icon: "error"
            });

            document.getElementById('jumlah_kuorum').value = "";
        }
    }
</script>