<?php
$setting = get_setting();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FAVICON -->
    <link rel="icon" href="<?= asset('assets/favicon/favicon.ico') ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= asset('assets/favicon/apple-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= asset('assets/favicon/apple-icon-60x60.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= asset('assets/favicon/apple-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= asset('assets/favicon/apple-icon-76x76.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= asset('assets/favicon/apple-icon-114x114.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= asset('assets/favicon/apple-icon-120x120.png') ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= asset('assets/favicon/apple-icon-144x144.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= asset('assets/favicon/apple-icon-152x152.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/favicon/apple-icon-180x180.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= asset('assets/favicon/android-icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('assets/favicon/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= asset('assets/favicon/favicon-96x96.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('assets/favicon/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset('assets/favicon/manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="theme-color" content="#0F84CA">
    <meta name="msapplication-TileImage" content="<?= asset('assets/favicon/icon-144x144.png') ?>">

    <title><?= $title ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #333;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: .5cm;
            margin: 0.5cm auto;
            background-color: #fff;
            /* border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); */
        }

        .subpage {
            /* padding: 1cm; */
            /* border: 5px red solid; */
            height: 286mm;
            /* outline: 0.5cm #FFEAEA solid; */
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        .b-left {
            border-left: 2px solid #000;
        }

        .b-right {
            border-right: 2px solid #000;
        }

        .b-top {
            border-top: 2px solid #000;
        }

        .b-bottom {
            border-bottom: 2px solid #000;
        }

        .my-table,
        th,
        td {
            padding: 8px 4px;
        }
    </style>
    <script src="<?= asset('assets/template/admin/js/jquery.min.js') ?>"></script>
</head>

<body>
    <div class="book">
        <div class="page">
            <div class="subpage">
                <div style="display: flex;">
                    <img src="<?= asset($setting['logo_white']) ?>" altSrc="<?= asset('assets/template/admin/logo-grid.png') ?>" onerror="this.src = $(this).attr('altSrc')" alt="" style="height: 25mm;">
                    <div>
                        <h4 style="margin-bottom: 4px;"><?= $setting['nama'] ?></h4>
                        <p><?= $setting['slogan'] ?></p>
                    </div>
                </div>
                <h4 style="text-align: center; text-transform: capitalize;">REKAM MEDIS PASIEN <?= is_null(get('poli')) ? '' : strtoupper(get('poli')) ?></h4>
                <p style="margin-bottom: 10px;"><?= $mr['tanggal'] ?></p>
                <table style="width: 100%; border-collapse:collapse" class="my-table">
                    <tr style="font-weight: bold;">
                        <td style="width: 24px;" class="b-left b-top b-bottom">I.</td>
                        <td class="b-top b-bottom  b-right">ANAMNESIS :</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td style="padding-bottom: 0; width: 24px;" class="b-left b-top">II.</td>
                        <td style="padding-bottom: 0;" class="b-top b-right">IDENTITAS PASIEN :</td>
                    </tr>
                    <tr>
                        <td style="padding: 0;" class="b-left"></td>
                        <td style="padding: 0;" class="b-right">
                            <table style="padding: 0;" class="table-identitas">
                                <?php foreach ([
                                    ['title' => 'NO RM', 'value' => $mr['pasien_mr']],
                                    ['title' => 'NAMA', 'value' => $mr['nama']],
                                    ['title' => 'UMUR', 'value' => (is_null($mr['umur']) ? '' : ($mr['umur'] . ' Tahun'))],
                                    ['title' => 'JENIS KELAMIN', 'value' => $mr['jenis_kelamin']],
                                    ['title' => 'ALAMAT', 'value' => $mr['alamat']],
                                ] as $v) : ?>
                                    <tr>
                                        <td style="padding:4px 2px; vertical-align: top;"><?= $v['title'] ?></td>
                                        <td style="padding:4px 2px">:</td>
                                        <td style="padding:4px 2px"><?= $v['value'] ?></td>
                                    </tr>

                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                    <tr style="font-weight: bold; height:85mm; vertical-align: top;">
                        <td style="width: 24px;" class="b-left b-top b-bottom">III.</td>
                        <td class="b-top b-bottom  b-right">DIAGNOSA :</td>
                    </tr>
                    <tr style="font-weight: bold; height:85mm; vertical-align: top;">
                        <td style="width: 24px;" class="b-left b-top b-bottom">IV.</td>
                        <td class="b-top b-bottom  b-right">OBAT :</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>