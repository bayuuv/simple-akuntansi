<?php
	$id       = $_GET['id'] ?? '';

    $query = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id = '$id'") or die(mysqli_error());

    while ($data = mysqli_fetch_array($query)){
        $id            = $data["id"];
        $nama          = $data["nama"];
        $nohp          = $data["nohp"];
        $email         = $data["email"];
        $alamat        = $data["alamat"];
    };

    if(isset($_POST['submit'])){
		$nama       = $_POST['nama'];
        $nohp       = $_POST['nohp'];
        $email      = $_POST['email'];
        $alamat     = $_POST['alamat'];

        if($id){
            $sql = mysqli_query($koneksi, "UPDATE supplier SET nama = '$nama', nohp = '$nohp', email = '$email', alamat = '$alamat' WHERE id = '$id' ");
        }else{
            $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM supplier WHERE nama = '$nama'"));

            if($cek > 0){
                echo "<script>alert('supplier telah ada!!');</script>";
                echo "<script type=\"text/javascript\">window.location.href = '?menu=form-supplier';</script>";
            }else{
                $sql = mysqli_query($koneksi, "INSERT INTO supplier (nama,nohp,email,alamat) VALUES ('$nama','$nohp','$email','$alamat')");
            }
        }

        if($sql==true){
            echo "<script type=\"text/javascript\">window.location.href = '?menu=supplier';</script>";
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
                        <h4 class="card-title">Form Supplier</h4>
                        <form class="forms-sample" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label for="exampleInputCity1">Nama</label>
                                <input type="text" name="nama" class="form-control" id="exampleInputCity1" placeholder="Nama" value="<?php echo $nama ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">No HP</label>
                                <input type="number" name="nohp" class="form-control" id="exampleInputCity1" placeholder="No Handphone" value="<?php echo $nohp ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Email</label>
                                <input type="email" name="email" class="form-control" id="exampleInputCity1" placeholder="Email" value="<?php echo $email ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Alamat</label>
                                <textarea name="alamat" class="form-control"><?php echo $alamat ?? '' ?></textarea>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light" onClick="document.location.href='index.php?menu=supplier';">Cancel</button>
                        </form>    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            