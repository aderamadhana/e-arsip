<style>
    .text-white {
        color: #fff;
    }

    .round {
        border-radius: 20px;
        box-shadow: 0 0 40px 0 rgba(0, 0, 0, .1);
        background: #fff;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #e3e3e3;
        border-radius: 20px;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
    }

    .grid-margin {
        margin-bottom: 2.5rem;
    }

    .stretch-card {
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: stretch;
        align-items: stretch;
        -webkit-justify-content: stretch;
        justify-content: stretch;
    }

    .stretch-card>.card {
        width: 100%;
        min-width: 100%;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .card-title {
        margin-bottom: 0.75rem;
    }

    .card .card-title {
        color: #010101;
        margin-bottom: 1.2rem;
        text-transform: capitalize;
        font-size: 2.125rem;
        font-weight: 600;
    }

    .mb-3,
    .template-demo .circle-progress-block,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .mb-md-0,
    .my-md-0 {
        margin-bottom: 0 !important;
    }

    .mt-3,
    .template-demo>.btn,
    .fc .template-demo>button,
    .ajax-upload-dragdrop .template-demo>.ajax-file-upload,
    .swal2-modal .swal2-buttonswrapper .template-demo>.swal2-styled,
    .wizard>.actions .template-demo>a,
    .template-demo>.btn-toolbar,
    .my-3 {
        margin-top: 1rem !important;
    }

    .table-borderless th,
    .table-borderless td,
    .table-borderless thead th,
    .table-borderless tbody+tbody {
        border: 0;
    }

    .text-muted,
    .preview-list .preview-item .preview-item-content p .content-category,
    .email-wrapper .mail-sidebar .menu-bar .profile-list-item a .user .u-designation,
    .email-wrapper .mail-list-container .mail-list .content .message_text,
    .email-wrapper .mail-list-container .mail-list .details .date {
        color: #737F8B !important;
    }

    .w-100 {
        width: 50% !important;
    }

    .pr-0,
    .px-0 {
        padding-right: 0 !important;
    }

    .pl-0,
    .px-0 {
        padding-left: 0 !important;
    }

    .progress {
        display: flex;
        height: 1rem;
        overflow: hidden;
        line-height: 0;
        font-size: 0.75rem;
        background-color: #e9ecef;
        border-radius: 0.25rem;
    }

    .progress {
        border-radius: 7px;
        height: 8px;
    }

    .progress .progress-bar {
        border-radius: 7px;
    }

    .progress.progress-sm {
        height: 0.375rem;
    }

    .progress.progress-md {
        height: 11px;
    }

    .progress.progress-lg {
        height: 15px;
    }

    .progress.progress-xl {
        height: 18px;
    }

    .mx-4 {
        margin-right: 1.5rem !important;
    }

    .ml-4,
    .mx-4 {
        margin-left: 1.5rem !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #F5F7FF;
    }

    .table-dark.table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-borderless th,
    .table-borderless td,
    .table-borderless thead th,
    .table-borderless tbody+tbody {
        border: 0;
    }

    #KategoriDanJumlahVendor,
    #penilaianVendor td {
        padding-bottom: 25px;
    }

    #KategoriDanJumlahVendorCancel td {
        padding-bottom: 30px;
    }
</style>
<script src="<?= base_url('assets/dist/js/chartjs-plugin-colorschemes.min.js') ?>"></script>

<section class="content" style="background-color: #F5F7FF;">

    <?php if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_divisi', 'kepala_departemen', 'sekretaris_divisi'])) { ?>
        <div class="row row-flex">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah konsultan</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="KategoriDanJumlahKonsultan"></table>
                        </div>
                        <div style="display: table;">
                            <div style="display: table-cell;">
                                <div class="mr-3 bg-primary" style="background-color: #7cb5ec;width:10px; height:10px; border-radius: 50%;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah Konsultan diberikan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah Vendor</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="KategoriDanJumlahVendor"></table>
                        </div>
                        <div style="display: table;bottom: 0;position: absolute;margin-bottom: 15px;">
                            <div style="display: table-cell;">
                                <div class="mr-3 bg-primary" style="background-color: #7cb5ec;width:10px; height:10px; border-radius: 50%;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah vendor diberikan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-flex">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah Konsultan <br> Acc / Cancel</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="KategoriDanJumlahKonsultanCancel"></table>
                        </div>
                        <div style="display: table;">
                            <div style="display: table-cell;">
                                <div class="mr-3 bg-primary" style="background-color: #7cb5ec;width:10px; height:10px; border-radius: 50%;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah konsultan
                            </div>
                            &emsp;&emsp;&emsp;
                            <div style="display: table-cell;">
                                <div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: black;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah cancel
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah Vendor <br> Acc / Cancel</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="KategoriDanJumlahVendorCancel"></table>
                        </div>
                        <div style="display: table;bottom: 0;position: absolute;margin-bottom: 15px;">
                            <div style="display: table-cell;">
                                <div class="mr-3 bg-primary" style="background-color: #7cb5ec;width:10px; height:10px; border-radius: 50%;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah vendor
                            </div>
                            &emsp;&emsp;&emsp;
                            <div style="display: table-cell;">
                                <div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: black;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah cancel
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-flex">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Penilaian Konsultan</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="penilaianKonsultan"></table>
                        </div>
                        <div id="penilaianKonsultan-legend"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Penilaian Vendor</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="penilaianVendor"></table>
                        </div>
                        <div id="penilaianVendor-legend" style="bottom: 0;position: absolute;margin-bottom: 15px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-flex">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Nominal konsultan</p>
                        </div>
                        <canvas id="KategoriDanNominalKonsultan"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Nominal Vendor</p>
                        </div>
                        <canvas id="KategoriDanNominalVendor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">PIC Konsultan dan Vendor</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="picKonsultandanVendor"></table>
                        </div>
                        <div id="picKonsultandanVendor-legend"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Total PIC Sesuai Nama User</p>
                            <select name="" class="form-control select-user" required="required"> </select>
                        </div>
                        <div style="width: 700px;padding: 0;margin: auto;display: block;"><canvas id="pie-picKonsultandanVendorbyUser"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Jumlah Vendor / Konsultan per PIC</p>
                        </div>
                        <div style="width: 600px;"><canvas id="picKonsultandanVendorbyUserTotal"></canvas></div>
                        <div id="picKonsultandanVendorbyUserTotal-legend"></div>
                        <div class="table-responsive" style="margin-top: 20px;">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr id="table-head">
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>

<script>
    function httpGet(theUrl) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", theUrl, false); // false for synchronous request
        xmlHttp.send(null);
        return xmlHttp.responseText;
    }

    var colorArray = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
    ];

    var bagian1 = httpGet("<?= base_url('home/vendor_json?status=bagian-1') ?>");
    bagian1 = JSON.parse(bagian1)

    var KategoriDanJumlahKonsultan = bagian1.kategoriDanJumlahKonsultanVendor.consultant
    var key1 = Object.keys(KategoriDanJumlahKonsultan);
    var data1 = Object.values(KategoriDanJumlahKonsultan);
    var result1 = (data1).map(temp => parseInt(temp));

    var data_KategoriDanJumlahKonsultan = [];
    for (var i in key1) {
        var temp = {
            name: key1[i],
            y: result1[i]
        }
        data_KategoriDanJumlahKonsultan.push(temp);
    }

    var total_data_KategoriDanJumlahKonsultan = 0;
    for (var i = 0; i < data_KategoriDanJumlahKonsultan.length; i++) {
        total_data_KategoriDanJumlahKonsultan += data_KategoriDanJumlahKonsultan[i]['y'];
    }
    for (var i = 0; i < key1.length; i++) {
        var count = data_KategoriDanJumlahKonsultan[i]['y'] / total_data_KategoriDanJumlahKonsultan * 100
        $('#KategoriDanJumlahKonsultan').append(
            '<tr>' +
            '<td class="text-muted">' + key1[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="background-color: #7cb5ec;width: ' + count + '%">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            data_KategoriDanJumlahKonsultan[i]['y'] +
            '</td>' +
            '</tr>'
        );
    }

    var KategoriDanJumlahVendor = bagian1.kategoriDanJumlahKonsultanVendor.vendor
    var key2 = Object.keys(KategoriDanJumlahVendor);
    var data2 = Object.values(KategoriDanJumlahVendor);
    var result2 = (data2).map(temp => parseInt(temp));

    var data_KategoriDanJumlahVendor = [];
    for (var i in key2) {
        var temp = {
            name: key2[i],
            y: result2[i]
        }
        data_KategoriDanJumlahVendor.push(temp);
    }

    var total_data_KategoriDanJumlahVendor = 0;
    for (var i = 0; i < data_KategoriDanJumlahVendor.length; i++) {
        total_data_KategoriDanJumlahVendor += data_KategoriDanJumlahVendor[i]['y'];
    }

    for (var i = 0; i < key2.length; i++) {
        var count = data_KategoriDanJumlahVendor[i]['y'] / total_data_KategoriDanJumlahVendor * 100
        $('#KategoriDanJumlahVendor').append(
            '<tr>' +
            '<td class="text-muted">' + key2[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="background-color: #7cb5ec;width: ' + count + '%">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            data_KategoriDanJumlahVendor[i]['y'] +
            '</td>' +
            '</tr>'
        );
    }

    var KategoriDanJumlahKonsultanCancel = bagian1.kategoriDanJumlahKonsultanVendorCancel.consultant
    var key3 = Object.keys(KategoriDanJumlahKonsultanCancel);
    var data3 = Object.values(KategoriDanJumlahKonsultanCancel);
    var result3 = (data3).map(temp => parseInt(temp));

    var data_KategoriDanJumlahKonsultanCancel = [];
    for (var i in key3) {
        var temp = {
            name: key3[i],
            y: result3[i]
        }
        data_KategoriDanJumlahKonsultanCancel.push(temp);
    }

    for (var i = 0; i < key1.length; i++) {
        var countSuccess = data_KategoriDanJumlahKonsultan[i]['y'] / total_data_KategoriDanJumlahKonsultan * 100;
        var countCancel = data_KategoriDanJumlahKonsultanCancel[i]['y'] / total_data_KategoriDanJumlahKonsultan * 100;
        $('#KategoriDanJumlahKonsultanCancel').append(
            '<tr>' +
            '<td class="text-muted">' + key1[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="background-color: #7cb5ec;width: ' + countSuccess + '%">' +
            '</div>' +
            '</div>' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-dark" role="progressbar" style="width: ' + countCancel + '%;background-color:black">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            data_KategoriDanJumlahKonsultan[i]['y'] +
            '<br>' +
            data_KategoriDanJumlahKonsultanCancel[i]['y'] +
            '</td>' +
            '</tr>'
        );
    }

    var KategoriDanJumlahVendorCancel = bagian1.kategoriDanJumlahKonsultanVendorCancel.vendor
    var key4 = Object.keys(KategoriDanJumlahVendorCancel);
    var data4 = Object.values(KategoriDanJumlahVendorCancel);
    var result4 = (data4).map(temp => parseInt(temp));

    var data_KategoriDanJumlahVendorCancel = [];
    for (var i in key4) {
        var temp = {
            name: key4[i],
            y: result4[i]
        }
        data_KategoriDanJumlahVendorCancel.push(temp);
    }

    for (var i = 0; i < key4.length; i++) {
        var countSuccess = data_KategoriDanJumlahVendor[i]['y'] / total_data_KategoriDanJumlahVendor * 100;
        var countCancel = data_KategoriDanJumlahVendorCancel[i]['y'] / total_data_KategoriDanJumlahVendor * 100;
        $('#KategoriDanJumlahVendorCancel').append(
            '<tr>' +
            '<td class="text-muted">' + key1[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="background-color: #7cb5ec;width: ' + countSuccess + '%">' +
            '</div>' +
            '</div>' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-dark" role="progressbar" style="width: ' + countCancel + '%;background-color:black">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            data_KategoriDanJumlahVendor[i]['y'] +
            '<br>' +
            data_KategoriDanJumlahVendorCancel[i]['y'] +
            '</td>' +
            '</tr>'
        );
    }

    var penilaianKonsultan = bagian1.kategoriDanJumlahKonsultanVendorStatus.consultant
    var penilaianVendor = bagian1.kategoriDanJumlahKonsultanVendorStatus.vendor

    var key7 = Object.keys(penilaianKonsultan);

    var datapenilaianKonsultan = [];
    var iterasi = 0;
    var category = []
    for (var i of key7) {
        var cat = Object.keys(penilaianKonsultan[i]);
        var val = Object.values(penilaianKonsultan[i]);
        if (iterasi == 0) category = cat

        var valuesData = {
            name: i,
            data: (val).map(temp => parseInt(temp))
        }
        datapenilaianKonsultan.push(valuesData)
        iterasi++;
    }

    var penilaianColor = ['#7cb5ec', '#434348', '#90ed7d', '#f7a35c'];
    for (var i = 0; i < category.length; i++) {
        var progressBar = [];
        var progressTotal = [];
        for (var j = 0; j < datapenilaianKonsultan.length; j++) {
            var count = datapenilaianKonsultan[j]['data'][i] / datapenilaianKonsultan[j]['data'].reduce((a, b) => a + b, 0) * 100;
            progressBar.push('<div class="progress progress-md mx-4">');
            progressBar.push('<div class="progress-bar bg-dark" role="progressbar" style="width: ' + count + '%;background-color:' + penilaianColor[j] + '">');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('</div>');
            progressBar.push('</div>');

            progressTotal.push(datapenilaianKonsultan[j]['data'][i]);
            if (j != datapenilaianKonsultan.length - 1) {
                progressTotal.push('<br>');
            }
        }
        $('#penilaianKonsultan').append(
            '<tr>' +
            '<td class="text-muted">' + category[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            progressBar.join('') +
            '</td>' +
            '<td>' +
            progressTotal.join('') +
            '</td>' +
            '</tr>'
        );
    }
    var penilaianKonsultanLegend = [];
    penilaianKonsultanLegend.push('<div style="display: table;">');
    for (var i = 0; i < datapenilaianKonsultan.length; i++) {
        penilaianKonsultanLegend.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + penilaianColor[i] + '"></div></div>');
        penilaianKonsultanLegend.push('<div style="display: table-cell;">&emsp;' + datapenilaianKonsultan[i]['name'] + '</div>&emsp;&emsp;');
    }
    penilaianKonsultanLegend.push('</div>');
    document.getElementById('penilaianKonsultan-legend').innerHTML = penilaianKonsultanLegend.join("");

    var key8 = Object.keys(penilaianVendor);

    var datapenilaianVendor = [];
    var iterasi1 = 0;
    var category1 = []
    for (var i of key8) {
        var cat = Object.keys(penilaianVendor[i]);
        var val = Object.values(penilaianVendor[i]);
        if (iterasi1 == 0) category1 = cat

        var valuesData = {
            name: i,
            data: (val).map(temp => parseInt(temp))
        }
        datapenilaianVendor.push(valuesData)
        iterasi1++;
    }


    for (var i = 0; i < category1.length; i++) {
        var progressBar = [];
        var progressTotal = [];
        for (var j = 0; j < datapenilaianVendor.length; j++) {
            var count = datapenilaianVendor[j]['data'][i] / datapenilaianVendor[j]['data'].reduce((a, b) => a + b, 0) * 100;
            progressBar.push('<div class="progress progress-md mx-4">');
            progressBar.push('<div class="progress-bar bg-dark" role="progressbar" style="width: ' + count + '%;background-color:' + penilaianColor[j] + '">');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('</div>');
            progressBar.push('</div>');

            progressTotal.push(datapenilaianVendor[j]['data'][i]);
            if (j != datapenilaianVendor.length - 1) {
                progressTotal.push('<br>');
            }
        }
        $('#penilaianVendor').append(
            '<tr>' +
            '<td class="text-muted">' + category1[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            progressBar.join('') +
            '</td>' +
            '<td>' +
            progressTotal.join('') +
            '</td>' +
            '</tr>'
        );
    }
    var penilaianVendorLegend = [];
    penilaianVendorLegend.push('<div style="display: table;">');
    for (var i = 0; i < datapenilaianVendor.length; i++) {
        penilaianVendorLegend.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + penilaianColor[i] + '"></div></div>');
        penilaianVendorLegend.push('<div style="display: table-cell;">&emsp;' + datapenilaianKonsultan[i]['name'] + '</div>&emsp;&emsp;');
    }
    penilaianVendorLegend.push('</div>');
    document.getElementById('penilaianVendor-legend').innerHTML = penilaianVendorLegend.join("");


    var KategoriDanNominalKonsultan = bagian1.kategoriDanNominalKonsultanVendor.consultant
    var key9 = Object.keys(KategoriDanNominalKonsultan);
    var data9 = Object.values(KategoriDanNominalKonsultan);
    var result9 = (data9).map(temp => parseInt(temp));

    var data_KategoriDanNominalKonsultan = [];
    for (var i in key9) {
        var temp = {
            name: key9[i],
            y: result9[i]
        }
        data_KategoriDanNominalKonsultan.push(temp);
    }

    var totalsKategoriDanNominalKonsultan = [];
    var totals = 0;
    for (var i = 0; i < data_KategoriDanNominalKonsultan.length; i++) {
        totalsKategoriDanNominalKonsultan.push(data_KategoriDanNominalKonsultan[i]['y']);
        totals += data_KategoriDanNominalKonsultan[i]['y'];
    }

    var KategoriDanNominalKonsultanChartCanvas = $("#KategoriDanNominalKonsultan").get(0).getContext("2d");
    var KategoriDanNominalKonsultanChart = new Chart(KategoriDanNominalKonsultanChartCanvas, {
        type: 'horizontalBar',
        data: {
            labels: key9,
            datasets: [{
                label: 'Nominal Konsultan',
                data: totalsKategoriDanNominalKonsultan,
                backgroundColor: "#7cb5ec",
            }]
        },
        options: {
            cornerRadius: 5,
            responsive: true,
            maintainAspectRatio: true,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 0
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        color: "#F2F2F2"
                    },
                    ticks: {

                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: totals,
                        autoSkip: true,
                        fontColor: "#6C7383",
                        callback: function(value, index, ticks) {
                            return convertToInternationalCurrencySystem(value);
                        }
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1
                }]
            },
            legend: {
                display: true,
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });

    var KategoriDanNominalVendor = bagian1.kategoriDanNominalKonsultanVendor.vendor
    var key10 = Object.keys(KategoriDanNominalVendor);
    var data10 = Object.values(KategoriDanNominalVendor);
    var result10 = (data10).map(temp => parseInt(temp));

    var data_KategoriDanNominalVendor = [];
    for (var i in key10) {
        var temp = {
            name: key10[i],
            y: result10[i]
        }
        data_KategoriDanNominalVendor.push(temp);
    }

    var totalsKategoriDanNominalVendor = [];
    var totals = 0;
    for (var i = 0; i < data_KategoriDanNominalVendor.length; i++) {
        totalsKategoriDanNominalVendor.push(data_KategoriDanNominalVendor[i]['y']);
        totals += data_KategoriDanNominalVendor[i]['y'];
    }

    var KategoriDanNominalVendorChartCanvas = $("#KategoriDanNominalVendor").get(0).getContext("2d");
    var KategoriDanNominalVendorChart = new Chart(KategoriDanNominalVendorChartCanvas, {
        type: 'horizontalBar',
        data: {
            labels: key10,
            datasets: [{
                label: 'Nominal Vendor',
                data: totalsKategoriDanNominalVendor,
                backgroundColor: "#7cb5ec",
            }]
        },
        options: {
            cornerRadius: 5,
            responsive: true,
            maintainAspectRatio: true,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 0
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        color: "#F2F2F2"
                    },
                    ticks: {

                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: totals,
                        autoSkip: true,
                        fontColor: "#6C7383",
                        callback: function(value, index, ticks) {
                            return convertToInternationalCurrencySystem(value);
                        }
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1
                }]
            },
            legend: {
                display: true,
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });


    function PieChart(id, data) {
        var label = [];
        var jml = [];
        data.forEach(function(item) {
            label.push(item['name']);
            jml.push(item['y']);
        });

        var pieChartCanvas = $("#" + id).get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: {
                datasets: [{
                    data: jml,
                    backgroundColor: colorArray,
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: label
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    var picKonsultandanVendorbyUser = bagian1.picKonsultandanVendorbyUser;
    var categories_picKonsultandanVendorbyUser = Object.keys(picKonsultandanVendorbyUser);

    for (var user of categories_picKonsultandanVendorbyUser) {
        $(".select-user").append(new Option(user, user))
    }

    $(".select-user").on("change", function() {

        generateChart_picTotalSponsor(this.value)

    });

    generateChart_picTotalSponsor(categories_picKonsultandanVendorbyUser[0])

    function generateChart_picTotalSponsor(user) {
        var categories_picKonsultandanVendorbyUser = Object.keys(picKonsultandanVendorbyUser[user]);
        var data_picKonsultandanVendorbyUser = Object.values(picKonsultandanVendorbyUser[user]);
        var result_picKonsultandanVendorbyUser = (data_picKonsultandanVendorbyUser).map(temp => parseInt(temp));

        var datapicKonsultandanVendorbyUser = [];
        for (var i in categories_picKonsultandanVendorbyUser) {

            var temp = {
                name: categories_picKonsultandanVendorbyUser[i],
                y: result_picKonsultandanVendorbyUser[i]
            }
            datapicKonsultandanVendorbyUser.push(temp);

        }
        PieChart('pie-picKonsultandanVendorbyUser', datapicKonsultandanVendorbyUser)
    }

    for (var i = 0; i < Object.values(bagian1.user).length; i++) {
        var progressBar = [];
        var progressTotal = [];
        for (var j = 0; j < bagian1.JsonpicKonsultandanVendor.length; j++) {
            var count = bagian1.JsonpicKonsultandanVendor[j]['data'][i] / bagian1.JsonpicKonsultandanVendor[j]['data'].reduce((a, b) => a + b, 0) * 100;
            progressBar.push('<div class="progress progress-md mx-4">');
            progressBar.push('<div class="progress-bar bg-dark" role="progressbar" style="width: ' + count + '%;background-color:' + colorArray[j] + '">');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('');
            progressBar.push('</div>');
            progressBar.push('</div>');

            progressTotal.push(bagian1.JsonpicKonsultandanVendor[j]['data'][i]);
            if (j != bagian1.JsonpicKonsultandanVendor.length - 1) {
                progressTotal.push('<br>');
            }
        }
        $('#picKonsultandanVendor').append(
            '<tr>' +
            '<td class="text-muted">' + Object.values(bagian1.user)[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            progressBar.join('') +
            '</td>' +
            '<td>' +
            progressTotal.join('') +
            '</td>' +
            '</tr>'
        );
    }
    var picKonsultandanVendorLegend = [];
    picKonsultandanVendorLegend.push('<div style="display: table;">');
    for (var i = 0; i < bagian1.JsonpicKonsultandanVendor.length; i++) {
        picKonsultandanVendorLegend.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + colorArray[i] + '"></div></div>');
        picKonsultandanVendorLegend.push('<div style="display: table-cell;">&emsp;' + bagian1.JsonpicKonsultandanVendor[i]['name'] + '</div>&emsp;&emsp;');
    }
    picKonsultandanVendorLegend.push('</div>');
    document.getElementById('picKonsultandanVendor-legend').innerHTML = picKonsultandanVendorLegend.join("");

    var picKonsultandanVendorbyUserTotalName = [];
    var picKonsultandanVendorbyUserTotalDatasets = [];
    for (var x = 0; x < bagian1.JsonpicKonsultandanVendorbyUserTotal.length; x++) {
        picKonsultandanVendorbyUserTotalName.push(bagian1.JsonpicKonsultandanVendorbyUserTotal[x]['name']);
        picKonsultandanVendorbyUserTotalDatasets.push({
            data: bagian1.JsonpicKonsultandanVendorbyUserTotal[x]['data'],
            backgroundColor: colorArray[x]
        });
    }
    var picKonsultandanVendorbyUserTotalChartCanvas = $("#picKonsultandanVendorbyUserTotal").get(0).getContext("2d");
    var picKonsultandanVendorbyUserTotalChart = new Chart(picKonsultandanVendorbyUserTotalChartCanvas, {
        type: 'horizontalBar',
        data: {
            labels: Object.values(bagian1.kategori),
            datasets: picKonsultandanVendorbyUserTotalDatasets
        },
        options: {
            cornerRadius: 5,
            responsive: true,
            maintainAspectRatio: true,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 0
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        color: "#F2F2F2"
                    },
                    ticks: {
                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        autoSkip: true,
                        fontColor: "#6C7383",
                        callback: function(value, index, ticks) {
                            return convertToInternationalCurrencySystem(value);
                        }
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1,
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });

    var picKonsultandanVendorbyUserTotallegend = [];
    for (var i = 0; i < picKonsultandanVendorbyUserTotalName.length; i++) {
        picKonsultandanVendorbyUserTotallegend.push('<div style="display: table;margin: 10px auto">');
        picKonsultandanVendorbyUserTotallegend.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + colorArray[i] + '"></div></div>');
        picKonsultandanVendorbyUserTotallegend.push('<div style="display: table-cell;">&emsp;' + picKonsultandanVendorbyUserTotalName[i] + '</div>');
        picKonsultandanVendorbyUserTotallegend.push('</div>');
    }
    document.getElementById('picKonsultandanVendorbyUserTotal-legend').innerHTML = picKonsultandanVendorbyUserTotallegend.join("");

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    function installtable() {

        for (user of Object.values(bagian1.user)) {
            $("#table-head").append(`<th>${user}</th>`)
        }

        var i = 0;
        for (kategori of Object.values(bagian1.kategori)) {
            var html = `<tr>
                        <td>${kategori}</td>`;
            var j = 0;
            for (user of Object.values(bagian1.user)) {
                html += `<td>${convertToRupiah(bagian1.JsonpicKonsultandanVendorbyUserTotal[j].data[i])}</td>`
                j++
            }

            html += `</tr>`
            $("#table-body").append(html)
            i++

        }
    }
    installtable()

    function convertToInternationalCurrencySystem(num) {

        if (num > 999 && num < 1000000) {
            return (num / 1000).toFixed(0) + 'K'; // convert to K for number from > 1000 < 1 million 
        } else if (num > 1000000) {
            return (num / 1000000).toFixed(0) + 'M'; // convert to M for number from > 1 million 
        } else if (num < 900) {
            return num; // if value < 1000, nothing to do
        }

    }
</script>