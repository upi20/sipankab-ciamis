<?php
$setting = get_setting();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Antrian</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 0;
        }

        .container {
            width: 80mm;
            padding: 4px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <h3 class="text-center" style="margin-bottom: 4px;"><?= $setting['nama'] ?></h3>
        <small style="margin-top: 0px;"><?= $setting['slogan'] ?></small>
        <hr style="border: 1px solid; background-color: #000; margin-bottom: 0;">
        <h4 style="margin-bottom: 0; margin-top: 4px;">Nomor Antrian</h4>
        <h1 style="font-size: 100px; margin-top: 16px; margin-bottom: 16px;"><?= get('antrian', false) ?></h1>
        <hr style="border: 1px solid; background-color: #000; margin-bottom: 0;">
        <small style="margin-top: 0px;"><?= get('no_rm', false) ?> | <?= get('waktu', false) ?></small>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>