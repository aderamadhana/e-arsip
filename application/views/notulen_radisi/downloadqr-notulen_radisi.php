<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak QR Notulen Radisi</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="icon" href="<?= base_url('webfile/') ?>logo-bri2.ico">

    <style>
        @page {
            size: 55mm 55mm;
            size: landscape;
            margin: 0;
        }
        .label{
            text-align: center;
            /* margin: 5px 50px 50px 50px !important; */
        }
        .page-break  {
            clear: left;
            display:block;
            page-break-after:always;
        }

        @media print{
            @page {
                size: 55mm 55mm;
                size: landscape;
                margin: 0;
            }

            .label{
                text-align: center;
                /* margin: 5px 50px 50px 50px !important; */
            }
        }
  </style>
</head>

<body onload="window.print()">

    <img src="<?= base_url('webfile/qr_notula_radisi/qrcodenotulen-' . $id . '.jpg') ?>" style="width:80px;height:80px;">
        
</body>

</html>