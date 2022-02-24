<?php
	$id       = $_GET['id'] ?? '';
    $kode     = '';
    $jenis    = '';

    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = '$id'") or die(mysqli_error());

    while ($data = mysqli_fetch_array($query)){
        $id            = $data["id"];
        $nama          = $data["nama"];
        $kode          = $data["kode"];
        $jenis         = $data["jenis"];
    };

    if(isset($_POST['submit'])){
		$nama       = $_POST['nama'];
        $kode       = $_POST['kode'];
        $jenis      = $_POST['jenis'];

        if($id){
            $sql = mysqli_query($koneksi, "UPDATE barang SET nama = '$nama', kode = '$kode', jenis = '$jenis' WHERE id = '$id' ");
        }else{
            $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM barang WHERE nama = '$nama'"));

            if($cek > 0){
                echo "<script>alert('Barang/Jasa telah ada!!');</script>";
                echo "<script type=\"text/javascript\">window.location.href = '?menu=form-barang';</script>";
            }else{
                $sql = mysqli_query($koneksi, "INSERT INTO barang (nama,kode,jenis) VALUES ('$nama','$kode','$jenis')");
            }
        }

        if($sql==true){
            echo "<script type=\"text/javascript\">window.location.href = '?menu=barang';</script>";
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
                        <h4 class="card-title">Form Barang/Jasa</h4>
                        <form class="forms-sample" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label for="exampleInputCity1">Nama</label>
                                <input type="text" name="nama" class="form-control" id="exampleInputCity1" placeholder="Nama" value="<?php echo $nama ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Kode</label>
                                <select name="kode" class="form-control" id="sel1" required>
                                    <option value="Barang & Jasa" <?php if($kode=='Barang & Jasa'){ echo 'selected="selected"';} ?>>Barang & Jasa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Jenis</label>
                                <select name="jenis" class="form-control" id="sel1" required>
                                    <option value="Persediaan" <?php if($jenis=='Persediaan'){ echo 'selected="selected"';} ?>>Persediaan</option>
                                    <option value="Non Persediaan" <?php if($jenis=='Non Persediaan'){ echo 'selected="selected"';} ?>>Non Persediaan</option>
                                    <option value="Jasa" <?php if($jenis=='Jasa'){ echo 'selected="selected"';} ?>>Jasa</option>
                                </select>
                            </div>
                            
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light" onClick="document.location.href='index.php?menu=barang';">Cancel</button>
                        </form>    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            