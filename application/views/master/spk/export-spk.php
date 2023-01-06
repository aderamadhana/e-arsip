<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data SPK.xls");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Export data vendor</title>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor SPK</th>
				<th>Tanggal SPK</th>
				<th>Nama Perusahaan</th>
				<th>Jenis Pekerjaan</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=1; foreach ($spk as $key => &$valspk) {?>
				<tr><?= $no;?></tr>
				<tr><?= $valspk['nomor_spk'] ?></tr>
				<tr><?= $valspk['tanggal_spk'] ?></tr>
				<tr><?= $valspk['nama_perusahaan'] ?></tr>
				<tr><?= $valspk['jenis_pekerjaan'] ?></tr>
			<?php $no++; } ?>
		</tbody>
	</table>
</body>
</html>