<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .full-width-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .full-width-table td,
        .full-width-table th {
            padding: 0;
        }

        .full-width-table th {
            border: 1 solid #000;
            font-weight: bold;
            background-color: #e1e1e1;
        }

        .full-width-table td {
            border: 1 solid #000;
        }

        .header th {
            text-align: left;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f8f8f8;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: black;
        }

        .signature {
            float: right;
            margin-top: 20px;
            width: 200px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid black;
            margin-top: 10px;
        }
    </style>

</head>

<body>

    <h2>Monitoring Report</h2>
    <table style="font-size:12px;">
        <?php foreach ($information as $data) : ?>
            <thead class="header">
                <tr>
                    <th>Device Name</th>
                    <th>:</th>
                    <td><?= $data['name']; ?></td>
                </tr>
                <tr>
                    <th>Brand</th>
                    <th>:</th>
                    <td><?= $data['brand']; ?></td>
                </tr>
                <tr>
                    <th>Ip Addres</th>
                    <th>:</th>
                    <td><?= $data['ip_address']; ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>

                </tr>
                <tr>

                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>
    <table class="full-width-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ampere</th>
                <th>Volt</th>
                <th>Watt</th>
                <th>kWh</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($device as $d) : ?>
                <tr class="text-center">
                    <td scope="row"><?= $i++; ?></td>
                    <td><?= $d['ampere']; ?></td>
                    <td><?= $d['volt']; ?></td>
                    <td><?= $d['watt']; ?></td>
                    <td><?= $d['kwh']; ?></td>
                    <td><?= date('H:i:s', strtotime($d['created_at'])); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="signature">
        <p>Jakarta, <?= tanggal(); ?></p>
        <p>Teknisi Server</p>
        <br>
        <br>
        <div class="signature-line"></div>
    </div>
    <div class="footer">
        <table style="width: 100%; font-size:12px;">
            <tr>
                <td><?= date('d M Y', strtotime($tglAwal)); ?> s/d <?= date('d M Y', strtotime($tglAkhir)); ?></td>
            </tr>
        </table>
    </div>
</body>

</html>