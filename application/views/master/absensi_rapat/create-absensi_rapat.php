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
                        <form action="<?= base_url('master/Absensi_rapat/store_agenda') ?>" method="POST" id="upload-create" enctype="multipart/form-data">
                            <input type="hidden" name="dt[ar_tipe_rapat]" value="<?= $tipe_rapat; ?>" />

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
                                                            <option value="<?= $kom_rec['mk_id'] ?>" <?= ($this->session->userdata('komite_id') == $kom_rec['mk_id']) ? 'selected' : ''; ?>><?= $kom_rec['mk_nama'] ?></option>    
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
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="dt[sub_komite][]" id="sub_komite_0" placeholder="Masukkan Sub Komite..." /></td>
                                                        <td>
                                                            <center><button type="button" class="btn btn-success" id="tambah_sub"><i class="fa fa-plus"></i></center>
                                                        </td>
                                                    </tr>
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
                                                <input type="text" class="form-control tgl" value="<?= date("Y-m-d"); ?>" name="dt[ar_tanggal]">
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
                                                <option value="Ruang Integrity / Gedung Kantor Pusat BRI">Ruang Integrity / Gedung Kantor Pusat BRI</option>
                                                <option value="Work From Anywhere">Work From Anywhere</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="lokasi_lainnya" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top: 25px;">
                                            <label class="col-sm-2 control-label">Lokasi Rapat Lainnya</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="dt[ar_lokasi_lainnya]" placeholder="Masukkan Lokasi Lainnya..." />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: 25px;">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Jumlah Kuorum</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="dt[ar_jumlah]" id="jumlah_kuorum" onInput="cekJumlahKuorum(event);">
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
                                                    </td style="width: 100px;">
                                                    <td>
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
        </div>
    </section>
</div>
<script type="text/javascript">
    var counter = 0;
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

    var counter_sub = 0;
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
                        text: "Agenda Rapat Berhasil di Tambahkan.",
                        icon: "success"
                    });
                    setTimeout(function() {
                        location.href = '<?= base_url('master/Absensi-rapat?tipe_rapat=' . $tipe_rapat) ?>';
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