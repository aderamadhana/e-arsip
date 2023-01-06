<?php
$is_mobile_device = isMobileDevice();
$list_akses_surat_keluar = $this->db->get('surat_keluar_akses')->result_array();
foreach ($list_akses_surat_keluar as $list) {
	$arr_list[] = $list['user_id'];
}
if ($this->session->userdata('session_sop') == "") {
	$urllogin = '';
	if (@$_GET['source'] == 'qrcode') {
		$urllogin = '?url=' . base_url(uri_string());
	}
	redirect('login' . $urllogin);
}
if (ONE_TIME_LOGIN == 0) {
	$otl = $this->session->userdata('session_otl');
	$ip = $this->session->userdata('ip_address');
	$id = $this->session->userdata('id');

	$user = $this->mymodel->selectDataone('user', ['id' => $id]);
	$log = $this->mymodel->selectDataone('session_login', ['date' => $this->template->sonDecode($user['session_id']), 'user_id' => $id]);
	if ($log['ip_address'] != $ip) {

		redirect('login/logout', 'refresh');
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= TITLE_APPLICATION  ?></title>
	<link rel="icon" href="<?= base_url('webfile/') ?>logo-bri2.ico">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Select 2 -->

	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/select2/dist/css/select2.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/Ionicons/css/ionicons.min.css">
	<!-- Material Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>fonts/material-icons/css/materialdesignicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/skins/_all-skins.min.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/morris.js/morris.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


	<link rel="stylesheet" href="<?= base_url('assets/') ?>dist/jquery.toast.min.css">


	<!-- <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css"> -->

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

	<style>
		* {
			font-family: 'Poppins', sans-serif;
		}

		.navbar-inverse .navbar-toggle:focus,
		.navbar-inverse .navbar-toggle:hover {
			background-color: #00529c;
		}
	</style>

	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet"> -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/main.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>treemaker/lib/tree_maker-min.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>custom.css">

	<!-- jQuery 3 -->
	<script src="<?= base_url('assets/') ?>bower_components/jquery/dist/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<!-- <script src="<?= base_url('assets/') ?>bower_components/jquery-ui/jquery-ui.min.js"></script> -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- DataTables -->
	<script src="<?= base_url('assets/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url('assets/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	<script src="<?= base_url('assets/') ?>dist/js/simple.money.format.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="<?= base_url('assets/dist/jquery.toast.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/') ?>treemaker/lib/tree_maker-min.js"></script>
	<!-- <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script> -->

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		function idleLogout() {
			var t;
			window.onload = resetTimer;
			window.onmousemove = resetTimer;
			window.onmousedown = resetTimer; // catches touchscreen presses
			window.onclick = resetTimer; // catches touchpad clicks
			window.onscroll = resetTimer; // catches scrolling with arrow keys
			window.onkeypress = resetTimer;

			function logout() {
				window.location.href = '<?= base_url('login/lockscreen?user=' . $this->session->userdata('username')) ?>';
			}

			function resetTimer() {
				clearTimeout(t);
				t = setTimeout(logout, 900000); // time is in milliseconds //60000 = 1 minutes
			}
		}

		idleLogout();
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<style>
		.ui-autocomplete {
			z-index: 2147483647;
		}

		.sidebar-menu>li {
			padding-top: 1em;
			padding-bottom: 0px;
			padding-left: 0px;
			padding-right: 0px;
		}

		.sidebar-menu>li>a {
			font-size: 14px;
		}

		.dataTables_filter input {
			width: 20em !important;
		}

		.sidebar-menu li a:hover {
			background-color: #00529c !important;
			color: white !important;
		}

		.treeview li a:hover {
			background-color: #00529c;
			color: white !important;
		}
	</style>
</head>

<body class="hold-transition <?= SKIN  ?> sidebar-mini fixed" onload="startTime()">
	<?php //print_r($this->session->all_userdata())
	?>

	<div class="wrapper">

		<?php
		if ($is_mobile_device) :
		?>
			<header class="main-header">
				<nav class="navbar navbar-inverse" style="background: #00529c;">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<b><a class="navbar-brand" href="#"><?= APPLICATION ?></a></b>
						</div>
						<div class="collapse navbar-collapse js-navbar-collapse" id="myNavbar">
							<?php
							$role = $this->mymodel->selectDataone('role', ['id' => $this->session->userdata('role_id')]);
							$jsonmenu = json_decode($role['menu']);
							$this->db->order_by('urutan asc');
							$this->db->where_in('id', $jsonmenu);
							$menu = $this->mymodel->selectWhere('menu_master', ['parent' => 0, 'status' => 'ENABLE']);
							?>
							<ul class="nav navbar-nav">
								<li class="dropdown dropdown-large">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bars"></i> Main Menu <b class="caret"></b></a>
									<ul class="dropdown-menu dropdown-menu-large row" style="background-color: white;">
										<?php

										$i = 0;
										foreach ($menu as $m) {
											if ($m['large_dropdown'] != 'ya') {
												continue;
											}
											if ($m['type'] == 'menu') {
												$this->db->where_in('id', $jsonmenu);
												$this->db->order_by('urutan asc');
												$parent =
													$this->mymodel->selectWhere('menu_master', ['parent' => $m['id'], 'status' => 'ENABLE']);
												if (count($parent) != 0) {
													$i++; ?>
													<?php if ($i % 2 == 1) { ?>
														<li class="col-sm-4">
															<ul>
															<?php } ?>
															<li class="dropdown-header">
																<?= $m['name'] ?>

															</li>



															<?php foreach ($parent as $p) {
																if ($p['type'] == 'menu') {
																	$role_slug  = $this->session->userdata('role_slug');
																	$user_id = $this->session->userdata('id'); ?>
																	<li>
																		<a href="<?= base_url($p['link']) ?>"><?= $p['name'] ?></a>
																	</li>
																<?php } ?>
															<?php } ?>


															<?php if ($i % 2 == 0 || $i == count($menu) - 1) { ?>
															</ul>
														</li>

													<?php } ?>

												<?php } ?>
											<?php } ?>
										<?php } ?>
									</ul>
								</li>
								<?php
								foreach ($menu as $m) {
									if ($m['large_dropdown'] != 'tidak') {
										continue;
									}
									if ($m['type'] == 'menu') {

										$this->db->where_in('id', $jsonmenu);
										$this->db->order_by('urutan asc');
										$parent = $this->mymodel->selectWhere('menu_master', ['parent' => $m['id'], 'status' => 'ENABLE']);
										if (count($parent) == 0) {
								?>
											<li class="<?php if ($page_name == $m['name']) echo "active"; ?>">
												<a href="<?= base_url($m['link']) ?>">
													<i class="<?= $m['icon'] ?>"></i> <span><?= $m['name'] ?></span>
													<?php
													$getNotif =  $this->mmodel->selectWhere('notification', ['slug' => $m['notif'], 'user_id' => $this->session->userdata('id')])->row();
													if (@$getNotif->counting) {
														$count_notif = $getNotif->counting;
													} else {
														$getNotif =  $this->mmodel->selectWhere('notification', ['slug' => $m['notif'], 'role_id' => $this->session->userdata('role_id')])->row();
														if (@$getNotif->counting) {
															$count_notif = $getNotif->counting;
														} else {
															$count_notif = 0;
														}
													}
													?>
													<?php if (@$count_notif) { ?>
														<span class="pull-right-container">
															<small class="label pull-right label-danger" id="<?= $m['notif'] ?>"><?= $count_notif ?></small>
														</span>
													<?php } ?>
												</a>
											</li>
										<?php } else { ?>

											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="<?= $m['icon'] ?>"></i> <?= $m['name'] ?> <span class="caret"></span></a>
												<ul class="dropdown-menu" role="menu">
													<?php foreach ($parent as $p) {
														if ($p['type'] == 'menu') {
															$role_slug  = $this->session->userdata('role_slug');
															$user_id = $this->session->userdata('id');
													?>
															<li class="<?= ($p['name'] == 'Surat Keluar' and !in_array($role_slug, ['super_admin', 'kepala_departemen', 'kepala_divisi', 'sekretaris_divisi']) and !in_array($user_id, $arr_list)) ? 'hide'  : ''  ?>">
																<a href="<?= base_url($p['link']) ?>"><i class="<?= $p['icon'] ?>"></i>
																	<?= $p['name'] ?>
																	<?php
																	// $getNotif =  $this->mmodel->selectWhere('notification',['slug'=>$p['notif'],'user_id'=>$this->session->userdata('id')])->row(); 
																	// if (@$getNotif->counting) {
																	//   $count_notif = $getNotif->counting;
																	// } else {
																	//   $getNotif =  $this->mmodel->selectWhere('notification',['slug'=>$p['notif'],'role_id'=>$this->session->userdata('role_id')])->row(); 
																	//   if (@$getNotif->counting) {
																	//     $count_notif = $getNotif->counting;
																	//   }
																	// }
																	?>
																	<?php if ($p['name'] == 'User' and in_array($role_slug, ['kepala_departemen'])) {
																		$data_user = $this->mymodel->selectDataone('user', ['id' => $user_id]);
																		$jumlah_user_nonaktif = $this->db->get_where('user', [
																			'departemen' => $data_user['departemen'],
																			'is_login' => 0
																		])->num_rows();
																	?>
																		<span class="pull-right-container">
																			<small class="label pull-right label-danger" id=""><?= $jumlah_user_nonaktif ?></small>
																		</span>
																	<?php } ?>
																</a>
															</li>
														<?php } ?>
													<?php } ?>

												</ul>
											</li>
										<?php } ?>
									<?php } ?>
								<?php }
								?>
							</ul>
						</div>
					</div>
				</nav>
			</header>


		<?php
		else :
		?>
			<header class="main-header">
				<!-- Logo -->
				<a href="<?= base_url() ?>" class="logo" style="    background: #00529c;">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini" style="font-weight: bold;"><?= APPLICATION_SMALL  ?> </span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg" style="font-weight: bold;"><?= APPLICATION  ?> </span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" style="background: #00529c;">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>

					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav" style="float: right;">
							<?php
							if (!$is_mobile_device) :
							?>
								<li>
									<a>
										<i id="date"></i>&nbsp;
										<!-- <i id="clock"></i> -->
									</a>
								</li>

							<?php
							endif;
							?>
							<!-- Notifications: style can be found in dropdown.less -->
							<?php
							if (($this->session->userdata('role_id') == '25') || ($this->session->userdata('role_id') == '26') || ($this->session->userdata('role_id') == '27')) {
								$style_setting = "style='display:none;'";
							} else {
								$style_setting = "";
							}
							?>
							<?php if ($this->session->userdata('role_slug') == 'super_admin') : ?>
								<li class="dropdown setting-menu" <?= $style_setting; ?>>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-cogs"></i>
									</a>
									<ul class="dropdown-menu" role="menu">
										<?php
										$this->db->order_by('urutan', 'asc');
										$parentsetting = $this->mymodel->selectWhere('menu_master', ['parent' => 40, 'status' => "ENABLE"]);
										foreach ($parentsetting as $p) {
											if ($p['type'] == 'menu') {
												$role_slug  = $this->session->userdata('role_slug');
												$user_id = $this->session->userdata('id');
										?>
												<li class="<?= ($p['name'] == 'Surat Keluar' and !in_array($role_slug, ['super_admin', 'kepala_departemen', 'kepala_divisi', 'sekretaris_divisi']) and !in_array($user_id, $arr_list)) ? 'hide'  : ''  ?>">
													<a href="<?= base_url($p['link']) ?>"><i class="<?= $p['icon'] ?>"></i>
														<?= $p['name'] ?>
														<?php if ($p['name'] == 'User' and in_array($role_slug, ['kepala_departemen'])) {
															$data_user = $this->mymodel->selectDataone('user', ['id' => $user_id]);
															$jumlah_user_nonaktif = $this->db->get_where('user', [
																'departemen' => $data_user['departemen'],
																'is_login' => 0
															])->num_rows();
														?>
															<span class="pull-right-container">
																<small class="label pull-right label-danger" id=""><?= $jumlah_user_nonaktif ?></small>
															</span>
														<?php } ?>
													</a>
												</li>
											<?php } ?>
										<?php } ?>
									</ul>
								</li>
							<?php endif ?>
							<li class="dropdown messages-menu">
								<?php

								if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'sekertaris') {
									$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
									$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_isread = "0"');
									$inbox_nav = $this->mymodel->selectWhere('arsip_dokumen', []);
								} else {
									$inbox_nav = array();
								}

								?>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-envelope-o"></i>
									<span class="label label-success"><?= count($inbox_nav) ?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">You have <?= count($inbox_nav) ?> messages</li>
									<li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
											<?php foreach ($inbox_nav as $key => $value) : ?>
												<li>
													<a href="<?= base_url('arsip_dokumen/detail/' . $this->template->sonEncode($value['ad_id'])) ?>">
														<h4 style="margin-left: 0px; font-size: 12px;">
															<?= $value['ad_nomorsurat'] ?>
															<small>
																<!-- <i class="fa fa-clock-o"></i> <?= $value['kirim_date'] ?> -->
																<?= $value['ad_perihal'] ?>
															</small>
														</h4>
														<p style="margin-left: 0px;"><?= $value['ad_kategorisurat'] ?></p>
													</a>
												</li>
											<?php endforeach ?>
										</ul>
									</li>
								</ul>
							</li>
							<li class="dropdown messages-menu">
								<?php

								if ($this->session->userdata('role_slug') == 'super_admin') {
									$this->db->join('notulensi_radisi', 'notulensi_radisi.nr_id = timeline_notula_radisi.tnr_nr_id');
									$inbox_timelinenotula = $this->mymodel->selectWhere('timeline_notula_radisi', ['tnr_is_late' => 1, 'tnr_readnotif' => 1]);
								} else {
									$inbox_timelinenotula = array();
								}

								?>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-bell-o"></i>
									<span class="label label-success"><?= count($inbox_timelinenotula) ?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">You have <?= count($inbox_timelinenotula) ?> messages</li>
									<li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
											<?php foreach ($inbox_timelinenotula as $key => $value) : ?>
												<li>
													<h4 style="margin-left: 0px; font-size: 12px;">
														<?= $value['nr_absensi_rapat_tanggal'] ?>
														<small>
															sudah idle <?= $value['tnr_countlate']; ?> pada <?= $value['tnr_posisi_jabatan']; ?>
														</small>
													</h4>
													<p style="margin-left: 0px;"></p>
												</li>
											<?php endforeach ?>
										</ul>
									</li>
								</ul>
							</li>
							<!-- User Account: style can be found in dropdown.less -->
							<?php
							$file = $this->mymodel->selectDataone('file', array('table_id' => $this->session->userdata('id'), 'table' => 'user'));
							?>
							<li class="dropdown user user-menu">

								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<!-- </object> -->
									<span class="hidden-xs"><?= $this->session->userdata('name'); ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header" style="background: #00529c !important">
										<!-- </object> -->

										<p style="font-size: 10pt;">
											<?= $this->session->userdata('name'); ?> - <?= $this->session->userdata('jabatan') ?>
										</p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">
										<!-- <div class="pull-left"> -->
										<a href="<?= base_url('master/user/editUser/') . $this->template->sonEncode($this->session->userdata('id')); ?>" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Profile</a>
										<a href="<?= base_url('login/lockscreen?user=') . $this->session->userdata('username'); ?>" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Lockscreen</a>
										<!-- </div> -->
										<!-- <div class="pull-right"> -->
										<a href="<?= base_url('login/logout') ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
									</li>
								</ul>
							</li>
							<!-- Control Sidebar Toggle Button -->
							<!-- <li>
						<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
					</li> -->
						</ul>

					</div>
				</nav>
			</header>
		<?php
		endif;
		?>
		<!-- Left side column. contains the logo and sidebar -->

		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu" data-widget="tree">
					<?php
					$role = $this->mymodel->selectDataone('role', ['id' => $this->session->userdata('role_id')]);
					$jsonmenu = json_decode($role['menu']);

					$departement = $this->mymodel->selectDataone('m_departemen', ['id' => $this->session->userdata('departement')]);
					$departmentmenu = json_decode($departement['menu']);

					$this->db->order_by('urutan asc');
					$this->db->group_start();
					$this->db->where_in('id', $jsonmenu);
					$this->db->or_where_in('id', $departmentmenu);
					$this->db->group_end();
					$menu = $this->mymodel->selectWhere('menu_master', ['parent' => 0, 'status' => 'ENABLE']);
					foreach ($menu as $m) {
						if ($m['type'] == 'menu' && $m['name'] != 'DASHBOARD') {

							$this->db->where_in('id', $jsonmenu);
							$parent = $this->mymodel->selectWhere('menu_master', ['parent' => $m['id'], 'status' => 'ENABLE']);
							if (count($parent) == 0) {
					?>
								<li class="<?php if ($page_name == $m['name']) echo "active"; ?>">
									<a href="<?= base_url($m['link']) ?>">
										<?php
										if ($m['type_icon'] == 'image') {
										?>
											<img src="<?= base_url('assets/images'); ?>/<?= $m['icon']; ?>" width="<?= $m['size_icon_image']; ?>" />
										<?php
										} else {
										?>
											<i class="<?= $m['icon'] ?>"></i>
										<?php
										}
										?>
										<span><?= $m['name'] ?></span>
										<?php
										$getNotif =  $this->mmodel->selectWhere('notification', ['slug' => $m['notif'], 'user_id' => $this->session->userdata('id')])->row();
										if (@$getNotif->counting) {
											$count_notif = $getNotif->counting;
										} else {
											$getNotif =  $this->mmodel->selectWhere('notification', ['slug' => $m['notif'], 'role_id' => $this->session->userdata('role_id')])->row();
											if (@$getNotif->counting) {
												$count_notif = $getNotif->counting;
											} else {
												$count_notif = 0;
											}
										}
										?>
										<?php if (@$count_notif) { ?>
											<span class="pull-right-container">
												<small class="label pull-right label-danger" id="<?= $m['notif'] ?>"><?= $count_notif ?></small>
											</span>
										<?php } ?>
									</a>
								</li>
							<?php } else { ?>

								<li class="treeview <?php if ($page_name == $m['name']) echo "active"; ?>">
									<a href="#">
										<?php
										if ($m['type_icon'] == 'image') {
										?>
											<img src="<?= base_url('assets/images'); ?>/<?= $m['icon']; ?>" width="<?= $m['size_icon_image']; ?>" />
										<?php
										} else {
										?>
											<i class="<?= $m['icon'] ?>"></i>
										<?php
										}
										?> <span><?= $m['name'] ?></span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<?php foreach ($parent as $p) {
											if ($p['type'] == 'menu') {
										?>
												<li class="<?php if ($page_name == $p['name']) echo "active"; ?>">
													<a href="<?= base_url($p['link']) ?>">

														<div style="display: flex;align-items: center;">
															<div>
																<?php
																if ($p['type_icon'] == 'image') {
																?>
																	<img src="<?= base_url('assets/images'); ?>/<?= $p['icon']; ?>" width="<?= $p['size_icon_image']; ?>" />
																<?php
																} else {
																?>
																	<i class="<?= $p['icon'] ?>"></i>
																<?php
																}
																?>
															</div>
															<div style="padding-left: 5px;">
																<?= $p['name'] ?>
																<?php
																$getNotif =  $this->mmodel->selectWhere('notification', ['slug' => $p['notif'], 'user_id' => $this->session->userdata('id')])->row();
																if (@$getNotif->counting) {
																	$count_notif = $getNotif->counting;
																} else {
																	$getNotif =  $this->mmodel->selectWhere('notification', ['slug' => $p['notif'], 'role_id' => $this->session->userdata('role_id')])->row();
																	if (@$getNotif->counting) {
																		$count_notif = $getNotif->counting;
																	}
																}
																?>
																<?php if (@$count_notif) { ?>
																	<span class="pull-right-container">
																		<small class="label pull-right label-danger" id="<?= $p['notif'] ?>"><?= $count_notif ?></small>
																	</span>
																<?php } ?>
															</div>
														</div>
													</a>
												</li>
											<?php } ?>
										<?php } ?>
									</ul>
								</li>
							<?php } ?>
						<?php } elseif ($m['type'] == 'label') { ?>
							<li class="header"><?= ($m['icon']) ? '<i class="' . $m['icon'] . '"></i> ' : '' ?><?= $m['name'] ?></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</section>
		</aside>

		<?= $contents ?>

		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> <?= VERSION ?>
			</div>
			<strong>Copyright <?= COPYRIGHT ?>
		</footer>

		<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Canvas JS -->
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?= base_url('assets/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Morris.js charts -->
	<script src="<?= base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
	<script src="<?= base_url('assets/') ?>bower_components/raphael/raphael.min.js"></script>
	<script src="<?= base_url('assets/') ?>bower_components/morris.js/morris.min.js"></script>
	<!-- Sparkline -->
	<script src="<?= base_url('assets/') ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

	<!-- jQuery Knob Chart -->
	<script src="<?= base_url('assets/') ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
	<!-- daterangepicker -->
	<script src="<?= base_url('assets/') ?>bower_components/moment/min/moment.min.js"></script>
	<script src="<?= base_url('assets/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- datepicker -->
	<script src="<?= base_url('assets/') ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<!-- Bootstrap time Picker -->
	<script src="<?= base_url('assets/') ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?= base_url('assets/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- Slimscroll -->
	<script src="<?= base_url('assets/') ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="<?= base_url('assets/') ?>bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!-- <script src="<?= base_url('assets/') ?>dist/js/pages/dashboard.js"></script> -->
	<!-- AdminLTE for demo purposes -->
	<script src="<?= base_url('assets/') ?>dist/js/demo.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#user-data-autocomplete').autocomplete({
				source: "<?php echo site_url('home/get_autocomplete'); ?>",

				select: function(event, ui) {
					// $('[name="title"]').val(ui.item.label); 
					// $('[name="description"]').val(ui.item.description); 
					window.location.href = "<?= base_url('master/user/editUser_redirect/') ?>" + ui.item.id;
				}
			});
		});

		var url = window.location;
		// for sidebar menu but not for treeview submenu
		$('ul.sidebar-menu a').filter(function() {
			return this.href == url;
		}).parent().siblings().removeClass('active').end().addClass('active');
		// for treeview which is like a submenu
		$('ul.treeview-menu a').filter(function() {
			return this.href == url;
		}).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
	</script>

	<script type="text/javascript">
		tinymce.init({
			selector: '#disposisi'
		});
		$('.restricted').remove();
		$('.select2').select2();

		$('.tgl').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		});

		$(function() {
			$('.datatable').DataTable()
			$('#example2').DataTable({
				'paging': true,
				'lengthChange': false,
				'searching': false,
				'ordering': true,
				'info': true,
				'autoWidth': false
			})
		});

		function startTime() {
			var today = new Date();
			var hr = today.getHours();
			var min = today.getMinutes();
			var sec = today.getSeconds();
			ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
			hr = (hr == 0) ? 12 : hr;
			hr = (hr > 12) ? hr - 12 : hr;
			//Add a zero in front of numbers<10
			hr = checkTime(hr);
			min = checkTime(min);
			sec = checkTime(sec);
			// document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

			var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
			var curWeekDay = days[today.getDay()];
			var curDay = today.getDate();
			var curMonth = months[today.getMonth()];
			var curYear = today.getFullYear();
			// var date = curWeekDay+", "+curDay+" "+curMonth+" "+curYear+" /";
			var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
			document.getElementById("date").innerHTML = date;

			var time = setTimeout(function() {
				startTime()
			}, 500);
		}

		function checkTime(i) {
			if (i < 10) {
				i = "0" + i;
			}
			return i;
		}

		/* Fungsi formatRupiah */
		$('.money').simpleMoneyFormat();

		function maskMoney(angka) {
			var bilangan = angka;

			var reverse = bilangan.toString().split('').reverse().join(''),
				ribuan = reverse.match(/\d{1,3}/g);
			ribuan = ribuan.join(',').split('').reverse().join('');

			// Cetak hasil  
			return ribuan;
		} // Cetak hasil  

		function encodeId(id) {
			var jqXHR = $.ajax({
				url: '<?= base_url("home/encodeId") ?>?id=' + id,
				type: "POST",
				async: false

			});
			return jqXHR.responseText;
		}

		function detectMob() {
			const toMatch = [
				/Android/i,
				/webOS/i,
				/iPhone/i,
				/iPad/i,
				/iPod/i,
				/BlackBerry/i,
				/Windows Phone/i
			];

			return toMatch.some((toMatchItem) => {
				return navigator.userAgent.match(toMatchItem);
			});
		}
		console.log(detectMob())

		function fungsiRupiah() {
			$(".rupiah").keyup(function() {
				$(this).val(formatRupiah(this.value, ''));
			});

			function formatRupiah(angka, prefix) {
				var number_string = angka.replace(/[^,\d]/g, '').toString(),
					split = number_string.split('.'),
					sisa = split[0].length % 3,
					rupiah = split[0].substr(0, sisa),
					ribuan = split[0].substr(sisa).match(/\d{3}/gi);

				// tambahkan titik jika yang di input sudah menjadi angka ribuan
				if (ribuan) {
					separator = sisa ? ',' : '';
					rupiah += separator + ribuan.join(',');
				}

				rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
				return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
			}
		}

		fungsiRupiah();

		// function maskRupiah(angka) {
		//   var   bilangan = angka;

		//   var reverse = bilangan.toString().split('').reverse().join(''),
		//     ribuan  = reverse.match(/\d{1,3}/g);
		//     ribuan  = ribuan.join('.').split('').reverse().join('');

		//   return ribuan;
		// }

		// Time Picker
		$(".timepicker").timepicker({
			showInputs: false,
			showMeridian: false
		});
	</script>

</body>

</html>