<style>
	.text-white{
		color: #fff;
	}
	.round {
    border-radius: 20px;
    box-shadow: 0 0 40px 0 rgba(0, 0, 0, .1);
    background: #fff;
}
.card-body {
    padding: 15px;
    margin: 10px 0px;
}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<center>
									<img src="<?=LOGO ?>" class="img-responsive" style="max-width: 100px;">
								</center>
							</div>
							<div class="col-md-12">
								<div class="text-center">
                                    <h3><b>Platform Kerjamu, Digimon! <br> (Digital Arsip & Monitoring Corporate Secretary Division)<br/><br/>Layanan Pengelolaan Data Secara Online</b></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
                <?php 
                    $this->db->select('COUNT(*) as total');
                    if ($this->session->userdata('role_slug')!='super_admin' && $this->session->userdata('role_slug')!='kepala_divisi' && $this->session->userdata('role_slug')!='sekretaris_divisi') {
                        $this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
                        $this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "'.$this->session->userdata('id').'"');
                    }
                    if ($this->session->userdata('role_slug')!='super_admin' && $this->session->userdata('role_slug')!='kepala_divisi' && $this->session->userdata('role_slug')!='sekretaris_divisi' ) {
                        $this->db->where('status', 'diajukan');
                    } else {
                        $this->db->where('status','diajukan');

                    }
                    $this->db->where('ad_tipesurat', 'Surat Masuk');
                    $suratmasuk = $this->mymodel->selectDataone('arsip_dokumen',[]);
                ?>
				<div class="row">
					<div class="col-md-6">
						<div class="card mb-4 box-shadow round">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<h4>
										Surat Masuk
										</h4>
										<h1 class="card-title pricing-card-title">
										<?= $suratmasuk['total'] ?>									
                                        <img src="https://disdik.jambiprov.go.id/images/mail.png" style="width: 70px;float: right;    margin-top: -35px;">
										</h1>
									</div>
								</div>
								<a href="<?= base_url('arsip_dokumen') ?>">Lihat Data Selengkapnya</a>
							</div>
						</div>
					</div>
                    <?php 

                        $departemen = $this->mymodel->selectDataone('user',['id'=>$this->session->userdata('id')])['departemen'];

                        $this->db->select('COUNT(*) as total');
                        if ($this->session->userdata('role_slug')!='super_admin' && $this->session->userdata('role_slug')!='kepala_departemen' && $this->session->userdata('role_slug')!='sekretaris_divisi') {
                            $this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
                            $this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_pengirim = "'.$this->session->userdata('id').'"');
                            
                        }
                        if($this->session->userdata('role_slug')=='kepala_departemen'){
                            $this->db->join('arsip_dokumen_departement','add_id_arsip_dokumen = ad_id');
                            $this->db->where('add_id_departement',$departemen);
                        }
                        $this->db->where('status', 'didisposisikan');
                        $this->db->where('ad_tipesurat', 'Surat Masuk');
                        $telahdisposisi = $this->mymodel->selectDataone('arsip_dokumen',[]);
                    ?>
					<div class="col-md-6">
						<div class="card mb-4 box-shadow round">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<h4>
                                        <?= ($this->session->userdata('role_slug')=='officer') ? 'Tindak Lanjut' : 'Telah Disposisi' ?>   
										</h4>
										<h1 class="card-title pricing-card-title">
										<?= $telahdisposisi['total'] ?>
                                        <img src="https://cdn2.iconfinder.com/data/icons/flat-sports/1020/Flat_Icon_Designs-03-512.png" style="width: 35px;float: right;    margin-top: -35px;">
										</h1>
									</div>
								</div>
								<a href="<?= base_url('arsip_dokumen?status=didisposisikan') ?>">Lihat Data Selengkapnya</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if (in_array($this->session->userdata('role_slug'),['super_admin','kepala_divisi','kepala_departemen','sekretaris_divisi'])){ ?>
    		<div class="row">
    			<div class="col-lg-12 col-xs-12">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Jumlah Surat Masuk </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="chart-masuk-disposisi"></div>
    					</div>
    				</div>
    			</div>
    		</div>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header">
                            <h4><b>Jumlah Surat Keluar </b></h4>
                        </div>
                        <div class="box-body">
                            <div id="chart-surat-keluar"></div>
                        </div>
                    </div>
                </div>
            </div>
    		<div class="row">
    			<div class="col-md-6">
    				<div class="box">
    					<div class="box-header">
    						<h4><b>Jumlah Surat Berdasarkan Sifat kerahasiaan</b></h4>
    					</div>
    					<div class="box-body">
    						<div id="chart-sifat"></div>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-6">
    				<div class="box">
    					<div class="box-header">
    						<h4><b>Jumlah Surat Berdasarkan Bentuk Dokumen</b></h4>
    					</div>
    					<div class="box-body">
    						<div id="chart-bentuk"></div>
    					</div>
    				</div>
    			</div>
    			<!--<div class="col-md-4">-->
    			<!--	<div class="box">-->
    			<!--		<div class="box-header">-->
    			<!--			<h4><b>Jumlah Surat Berdasarkan Kategori Surat</b></h4>-->
    			<!--		</div>-->
    			<!--		<div class="box-body">-->
    			<!--			<div id="chart-kategori"></div>-->
    			<!--		</div>-->
    			<!--	</div>-->
    			<!--</div>-->
    		</div>
        <?php } ?>
	</section>
</div>
<?php 
$user = $this->mymodel->selectDataone('user',array('id'=>$this->session->userdata('id')));
if($user['role_name'] != 'Super Admin' AND $user['role_name']!='Kepala Divisi' AND $user['role_name']!='Sekretaris Divisi'){
    $this->db->where('id',$user['departemen']);
}
$departemen = $this->mymodel->selectWhere('m_departemen',array('status'=>'ENABLE'));
// print_r($departemen);
$namadepartemen = [];
$jumlahdepartemen = [];
$id_departemen = [];
foreach ($departemen as $key => $value) {
    $namadepartemen[] = $value['nama'];
    $id_departemen[] = $value['id'];
    for ($i=1; $i <= 12 ; $i++) { 
        $this->db->select('COUNT(ad_id) as total');
        $this->db->join('arsip_dokumen_departement','add_id_arsip_dokumen = ad_id');
        $this->db->where('status !=', 'void');
        $this->db->where('status !=', 'dihapus');
        $this->db->where('ad_tipesurat','Surat Masuk');
        $getarsip = $this->mymodel->selectDataone('arsip_dokumen',array('MONTH(ad_tanggalsurat)'=>$i,'YEAR(ad_tanggalsurat)'=>date('Y'),'add_id_departement'=>$value['id']));
        $jumlahdepartemen[$value['nama']][$i] = (int)$getarsip['total'];

        $this->db->select('COUNT(ad_id) as total');
        // $this->db->where('status !=', 'void');
        $this->db->where('ad_tipesurat','Surat Keluar');
        $getarsip_keluar = $this->mymodel->selectDataone('arsip_dokumen',array('MONTH(ad_tanggalsurat)'=>$i,'YEAR(ad_tanggalsurat)'=>date('Y'),'ad_departemen'=>$value['id']));
        $jumlahdepartemen_keluar[$value['nama']][$i] = (int)$getarsip_keluar['total'];
    }
}


$sifat = array('biasa'=>'Biasa' ,'rahasia'=>'Rahasia' ,'sangat_rahasia'=>'Sangat Rahasia');
$jumlahsifat = [];
foreach ($sifat as $key => $value) {
    $this->db->select('COUNT(ad_id) as total');
    $this->db->where('status !=', 'void');
    $this->db->where('status !=', 'dihapus');
    $this->db->where('MONTH(ad_tanggalsurat)', date('m'));
    $this->db->where('YEAR(ad_tanggalsurat)', date('Y'));
    if($user['role_name'] != 'Super Admin' AND $user['role_name']!='Kepala Divisi' AND $user['role_name']!='Sekretaris Divisi'){
        $this->db->join('arsip_dokumen_departement','add_id_arsip_dokumen = ad_id');
        $this->db->where_in('add_id_departement', $id_departemen);
    }
    $getarsip = $this->mymodel->selectDataone('arsip_dokumen',array('ad_sifatsurat'=>$key));
    $jumlahsifat[$key] = $getarsip['total'];
}

$bentuk = array('surat'=>'Surat' ,'surat_dan_proposal'=>'Surat Dan Proposal' ,'surat_dan_dokumen_pendukung_lainnya'=>'Surat Dan Dokumen Pendukung');
$jumlahbentuk = [];
foreach ($bentuk as $key => $value) {
    $this->db->select('COUNT(ad_id) as total');
    $this->db->join('arsip_dokumen_departement','add_id_arsip_dokumen = ad_id');
    $this->db->where('status !=', 'void');
    $this->db->where('MONTH(ad_tanggalsurat)', date('m'));
    $this->db->where('YEAR(ad_tanggalsurat)', date('Y'));
    if($user['role_name'] != 'Super Admin' AND $user['role_name']!='Kepala Divisi' AND $user['role_name']!='Sekretaris Divisi'){
        $this->db->where_in('add_id_departement', $id_departemen);
    }
    $getarsip = $this->mymodel->selectDataone('arsip_dokumen',array('ad_bentukdokumen'=>$key));
    $jumlahbentuk[$key] = $getarsip['total'];
}

?>
<script>    
Highcharts.chart('chart-masuk-disposisi', {
	colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        tickInterval: 1,
        title: {
            text: 'Jumlah Surat'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Surat</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: 
        [
            <?php foreach ($namadepartemen as $key => $value): ?>
                    {
                        name: '<?= $value ?>',
                        data: [
                            <?php foreach ($jumlahdepartemen[$value] as $key => $value) { ?>
                                <?= ($key>1)?',':''; ?> <?= $value ?>
                            <?php } ?>
                        ]
                    },
            <?php endforeach ?>
        ]
    
});

Highcharts.chart('chart-surat-keluar', {
    colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        tickInterval: 1,
        title: {
            text: 'Jumlah Surat'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Surat</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: 
        [
            <?php foreach ($namadepartemen as $key => $value): ?>
                    {
                        name: '<?= $value ?>',
                        data: [
                            <?php foreach ($jumlahdepartemen_keluar[$value] as $key => $value) { ?>
                                <?= ($key>1)?',':''; ?> <?= $value ?>
                            <?php } ?>
                        ]
                    },
            <?php endforeach ?>
        ]
    
});

</script>
<script type="text/javascript">
	// Build the chart
Highcharts.chart('chart-sifat', {
	colors: ["#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    legend: {
        labelFormatter: function () {
            return this.name + ' ('+this.y+')';
        }
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: [
            <?php foreach ($sifat as $key => $value){ ?>
                {
                    name : '<?= $value ?>',
                    y: <?= $jumlahsifat[$key] ?>
                },
            <?php } ?>
        ]
    }]
});
// Build the chart
Highcharts.chart('chart-bentuk', {
	colors: ["#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    legend: {
        labelFormatter: function () {
            return this.name + ' ('+this.y+')';
        }
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: [
            <?php foreach ($bentuk as $key => $value){ ?>
                {
                    name : '<?= $value ?>',
                    y: <?= $jumlahbentuk[$key] ?>
                },
            <?php } ?>
        ]
    }]
});
</script>