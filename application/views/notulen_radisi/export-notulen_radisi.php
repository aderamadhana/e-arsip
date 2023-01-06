<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export Data Notulen Rapat Direksi.xls");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Export Data Notulen Rapat Direksi</title>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th>No</th>
				<th>Notulen Tanggal</th>
				<th>Agenda</th>
				<th>PIC Notulen</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$no = 1;
				foreach ($data as $key => $value) {
			?>
				<tr>
					<td style="text-align: center; vertical-align: middle;"><?= $no;?></td>
					<td style="text-align: center; vertical-align: middle; "><?= $value['nr_tanggal_awal_sirkuler'] ?></td>
					<td style="text-align: center; vertical-align: middle;">
                        <?php
                        $sepAgenda = explode(';', $value['agenda_rapat']);
                        foreach ($sepAgenda as $key => $agenda) {
                            echo ($key + 1).". ".$agenda."<br>";
                        }
                        ?>
                    </td>
					<td style="text-align: center; vertical-align: middle;"><?= $value['nr_pic'] ?></td>
				</tr>
			<?php $no++; }?>
		</tbody>
	</table>
</body>
</html>