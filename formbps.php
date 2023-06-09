<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "spmkp";

$koneksi    = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$nobps      = "";
$tglbps     = "";
$npwp       = "";
$jenisspt   = "";
$masa       = "";
$tahun      = "";
$nilai      = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql1       = "delete from formbps where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id             = $_GET['id'];
    $sql1           = "select * from formbps where id = '$id'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nobps          = $r1['no_bps'];
    $tglbps         = $r1['tgl_bps'];
    $npwp           = $r1['npwp'];
    $jenisspt       = $r1['jenis_spt'];
    $masa           = $r1['masa'];
    $tahun          = $r1['tahun'];
    $nilai          = $r1['nilai'];
    $jatuhtempo     = $r1['jatuh_tempo'];

    if ($nobps == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nobps        = $_POST['no_bps'];
    $tglbps       = $_POST['tgl_bps'];
    $npwp         = $_POST['npwp'];
    $jenisspt     = $_POST['jenis_spt'];
    $masa         = $_POST['masa'];
    $tahun        = $_POST['tahun'];
    $nilai        = $_POST['nilai'];
    $jatuhtempo   = $_POST['jatuh_tempo'];

    if ($nobps && $tglbps && $npwp && $jenisspt && $masa &&$tahun &&$nilai &&$jatuhtempo) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update formbps set no_bps = '$nobps', tgl_bps = '$tglbps', npwp='$npwp',jenis_spt = '$jenisspt',masa='$masa',tahun='$tahun',nilai='$nilai',jatuh_tempo='$jatuhtempo' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into formbps(no_bps,tgl_bps,npwp,jenis_spt,masa,tahun,nilai,jatuh_tempo) values ('$nobps','$tglbps','$npwp','$jenisspt','$masa','$tahun','$nilai','$jatuhtempo')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data BPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:2;url=formbps.php"); //2 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:2;url=formbps.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="no_bps" class="col-sm-2 col-form-label">No. BPS</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_bps" name="no_bps" value="<?php echo $nobps ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tgl_bps" class="col-sm-2 col-form-label">Tgl BPS</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tgl_bps" name="tgl_bps" value="<?php echo $tglbps ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="npwp" name="npwp" value="<?php echo $npwp ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_spt" class="col-sm-2 col-form-label">Jenis SPT</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis_spt" id="jenis_spt">
                                <option value="">- Pilih Jenis SPT -</option>
                                <option value="SPT Tahunan OP" <?php if ($jenisspt == "SPT Tahunan OP") echo "selected" ?>>SPT Tahunan OP</option>
                                <option value="SPT Tahunan Badan" <?php if ($jenisspt == "SPT Tahunan Badan") echo "selected" ?>>SPT Tahunan Badan</option>
                                <option value="SPT Masa PPN" <?php if ($jenisspt == "SPT Masa PPN") echo "selected" ?>>SPT Masa PPN</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="masa" class="col-sm-2 col-form-label">Masa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="masa" name="masa" value="<?php echo $masa ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tahun" name="tahun" value="<?php echo $tahun ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nilai" class="col-sm-2 col-form-label">Nilai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nilai" name="nilai" value="<?php echo $nilai ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jatuh_tempo" class="col-sm-2 col-form-label">Jatuh Tempo</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" value="<?php echo $jatuhtempo ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data BPS
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">No. BPS</th>
                            <th scope="col">Tgl BPS</th>
                            <th scope="col">NPWP</th>
                            <th scope="col">Jenis SPT</th>
                            <th scope="col">Masa</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Nilai</th>
                            <th scope="col">Jatuh Tempo</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select id,no_bps,DATE_FORMAT(tgl_bps,'%d/%m/%y') as tgl_bps,npwp,jenis_spt,masa,tahun,nilai,DATE_FORMAT(jatuh_tempo,'%d/%m/%y') as jatuh_tempo from formbps order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id           = $r2['id'];
                            $nobps        = $r2['no_bps'];
                            $tglbps        = $r2['tgl_bps'];
                            $npwp         = $r2['npwp'];
                            $jenisspt     = $r2['jenis_spt'];
                            $masa         = $r2['masa'];
                            $tahun        = $r2['tahun'];
                            $nilai        = $r2['nilai'];
                            $jatuhtempo   = $r2['jatuh_tempo'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nobps ?></td>
                                <td scope="row"><?php echo $tglbps ?></td>
                                <td scope="row"><?php echo $npwp ?></td>
                                <td scope="row"><?php echo $jenisspt ?></td>
                                <td scope="row"><?php echo $masa ?></td>
                                <td scope="row"><?php echo $tahun ?></td>
                                <td scope="row"><?php echo $nilai ?></td>
                                <td scope="row"><?php echo $jatuhtempo ?></td>
                                <td scope="row">
                                    <a href="formbps.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="formbps.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>