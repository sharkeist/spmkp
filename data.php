
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body bgcolor="lightblue">
    <h2 align="center">Monitoring SPMKP</h2>

    <table border="1" align="center" width="80%" bgcolor="lightgreen">
        <tr bgcolor="cyan">
            <th>No.</th>
            <th>No. BPS</th>
            <th>Tanggal BPS</th>
            <th>NPWP</th>
            <th>Jenis SPT</th>
            <th>Masa</th>
            <th>Tahun</th>
            <th>Nilai</th>
            <th>Jatuh Tempo</th>
        </tr>
        <tr>
            <?php
            include "koneksi.php";
                $tampil = mysqli_query($koneksi, "select * from tbbps");
                while ($data = mysqli_fetch_array($tampil)) {
            ?>
            <td><?php echo $data['No.']; ?></td>
            <td><?php echo $data['No. BPS']; ?></td>
            <td><?php echo $data['Tanggal BPS']; ?></td>
            <td><?php echo $data['NPWP']; ?></td>
            <td><?php echo $data['Jenis SPT']; ?></td>
            <td><?php echo $data['Masa']; ?></td>
            <td><?php echo $data['Tahun']; ?></td>
            <td><?php echo $data['Nilai']; ?></td>
            <td><?php echo $data['Jatuh Tempo']; ?></td>
        </tr>
    <?php
            }
    ?>
    </table>
</body>

</html>