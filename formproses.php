<?php
include "koneksi.php";
$nobps                  = "";
$npermintaankelengkapan = "";
$penelitian             = "";
$skppkp                 = "";
$sukses                 = "";
$error                  = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from formproses where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id                     = $_GET['id'];
    $sql1                   = "select * from formproses where id = '$id'";
    $q1                     = mysqli_query($koneksi, $sql1);
    $r1                     = mysqli_fetch_array($q1);
    $nobps                  = $r1['no_bps'];
    $permintaankelengkapan  = $r1['permintaan_kelengkapan'];
    $penelitian             = $r1['penelitian'];
    $skppkp                 = $r1['skppkp'];

    if ($nobps == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nobps                  = $_POST['no_bps'];
    $permintaankelengkapan  = $_POST['permintaan_kelengkapan'];
    $penelitian             = $_POST['penelitian'];
    $skppkp                 = $_POST['skppkp'];

    if ($nobps && $permintaankelengkapan && $penelitian && $skppkp) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update formproses set no_bps = '$nobps',permintaan_kelengkapan='$permintaankelengkapan',penelitian = '$penelitian',skppkp='$skppkp' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into formproses(no_bps,permintaan_kelengkapan,penelitian,skppkp) values ('$nobps','$permintaankelengkapan','$penelitian','$skppkp')";
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
    <title>Proses</title>
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
                    header("refresh:2;url=formproses.php");//2 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:2;url=formproses.php");
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
                        <label for="permintaan_kelengkapan" class="col-sm-2 col-form-label">Permintaan Kelengkapan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="permintaan_kelengkapan" name="permintaan_kelengkapan" value="<?php echo $permintaankelengkapan ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penelitian" class="col-sm-2 col-form-label">Penelitian</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="penelitian" name="penelitian" value="<?php echo $penelitian ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="skppkp" class="col-sm-2 col-form-label">SKPPKP</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="skppkp" name="skppkp" value="<?php echo $skppkp ?>">
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
                Proses
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">No. BPS</th>
                            <th scope="col">Permintaan Kelengkapan</th>
                            <th scope="col">Penelitian</th>
                            <th scope="col">SKPPKP</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select id,no_bps,DATE_FORMAT(permintaan_kelengkapan,'%d/%m/%y') as permintaan_kelengkapan,DATE_FORMAT(penelitian,'%d/%m/%y') as penelitian,DATE_FORMAT(skppkp,'%d/%m/%y') as skppkp from formproses order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id                     = $r2['id'];
                            $nobps                  = $r2['no_bps'];
                            $permintaankelengkapan  = $r2['permintaan_kelengkapan'];
                            $penelitian             = $r2['penelitian'];
                            $skppkp                 = $r2['skppkp'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nobps ?></td>
                                <td scope="row"><?php echo $permintaankelengkapan ?></td>
                                <td scope="row"><?php echo $penelitian ?></td>
                                <td scope="row"><?php echo $skppkp ?></td>
                                <td scope="row">
                                    <a href="formproses.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="formproses.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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