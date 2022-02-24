<?php
	$id       = $_GET['id'] ?? '';

    $query = mysqli_query($koneksi, "SELECT * FROM akun WHERE id = '$id'") or die(mysqli_error());

    while ($data = mysqli_fetch_array($query)){
        $id            = $data["id"];
        $no_akun       = $data["no_akun"];
        $nama_akun     = $data["nama"];
    };

    if(isset($_POST['submit'])){
		$nomorAkun  = $_POST['nomor'];
		$name       = $_POST['akun_user'];

        if($id){
            $sql = mysqli_query($koneksi, "UPDATE akun SET no_akun = '$nomorAkun', nama = '$name' WHERE id = '$id' ");
        }else{
            $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM akun WHERE no_akun = '$nomorAkun'"));

            if($cek > 0){
                echo "<script>alert('no akun telah ada!!');</script>";
                echo "<script type=\"text/javascript\">window.location.href = '?menu=form-akun';</script>";
            }else{
                $sql = mysqli_query($koneksi, "INSERT INTO akun (no_akun, nama) VALUES ('$nomorAkun','$name')");
            }
        }

        if($sql==true){
            echo "<script type=\"text/javascript\">window.location.href = '?menu=akun';</script>";
        }else{
            echo "<script>alert('proses gagal!!');</script>";
        }
    }

?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Jurnal Akun</h4>
                        <form class="forms-sample" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail3">No Akun</label>
                                <input type="number" name="nomor" class="form-control" id="exampleInputEmail3" placeholder="No Akun" value="<?php echo $no_akun ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Nama Akun</label>
                                <input type="text" name="akun_user" class="form-control" id="exampleInputCity1" placeholder="Nama Akun" value="<?php echo $nama_akun ?? '' ?>" required>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light" onClick="document.location.href='index.php?menu=akun';">Cancel</button>
                        </form>    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            