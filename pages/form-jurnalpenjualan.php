<?php
	$id       = $_GET['id'] ?? '';
    $jenis    = '';

    $query = mysqli_query($koneksi, "SELECT * FROM jurnal_penjualan WHERE id = '$id'") or die(mysqli_error());

    while ($data = mysqli_fetch_array($query)){
        $id            = $data["id"];
        $tgl_penjualan = $data["tgl_penjualan"];
        $no_akun       = $data["no_akun"];
        $nama_akun     = $data["nama_akun"];
        $jenis         = $data["jenis"];
        $pelanggan     = $data["pelanggan"];
        $no_faktur     = $data["no_faktur"];
        $saldo         = "Rp " . number_format($data["saldo"],2,',','.');
    };

    if(isset($_POST['submit'])){
        $id         = $_POST['id'];
        $temp       = "KAS";
		$jPenjualan = "Penjualan";
		$tgl        = $_POST['tanggal'];
        $akun       = explode('-',$_POST['akun']);
		$nomorAkun  = $akun[0];
		$name       = $akun[1];
        $akun2       = explode('-',$_POST['akun2']);
		$nomorAkun2  = $akun2[0];
		$name2       = $akun2[1];
		$jenis      = $_POST['jenis_debt'];
        $pelanggan  = $_POST['pelanggan'];
        $barang     = $_POST['barang'];
        $no_faktur  = $_POST['no_faktur'];
        //rubah format rupiah ke sql
        $harga      = str_replace("Rp", "", $_POST['saldo']);
        $saldo      = str_replace(".", "", $harga);
        $saldo      = str_replace(",00", "", $saldo);

        if($_POST['akun'] == $_POST['akun2']){
            echo "<script>alert('akun tidak boleh sama!!');</script>";
        }else{

            if($id){
                $sql = mysqli_query($koneksi, "UPDATE jurnal_penjualan SET tgl_penjualan = '$tgl', no_akun = '$nomorAkun', nama_akun = '$name', no_akun2 = '$nomorAkun2', nama_akun2 = '$name2', pelanggan = '$pelanggan', barang = '$barang', saldo = '$saldo', jenis = '$jenis', no_faktur = '$no_faktur' WHERE id = '$id'");

                // if ($jenis == "Debit"){

                //     $sql_umum = mysqli_query($koneksi, "UPDATE jurnalumum SET tgl_pembelian = '$tgl', jurnal = '$jPenjualan', no_akun = '$nomorAkun', akun_debit = '$name', total_debit = '$saldo', akun_kredit = '$temp', total_kredit = '$saldo' WHERE id = '$id'");

                // }elseif($jenis == "Kredit"){
                    
                //     $sql_jurnal = mysqli_query($koneksi, "UPDATE jurnalumum SET tgl_pembelian = '$tgl', jurnal = '$jPenjualan', no_akun = '$nomorAkun', akun_debit = '$name', total_debit = '$saldo', akun_kredit = '$temp', total_kredit = '$saldo' WHERE id = '$id'");

                // }
            }else{
                $sql = mysqli_query($koneksi, "INSERT INTO jurnal_penjualan(tgl_penjualan, no_akun, nama_akun, no_akun2, nama_akun2, pelanggan, barang, saldo, jenis, no_faktur) 
                VALUES ('$tgl','$nomorAkun','$name','$nomorAkun2','$name2','$pelanggan','$barang','$saldo','$jenis','$no_faktur')");

                // if ($jenis == "Debit") {
        
                //     $sql_umum = mysqli_query($koneksi,"INSERT INTO jurnalumum(tgl_pembelian, jurnal, no_akun, akun_debit, total_debit, akun_kredit, total_kredit) 
                //                 VALUES ('$tgl','$jPenjualan','$nomorAkun','$name','$saldo','$temp','$saldo')");
                    
                // }elseif($jenis == "Kredit"){
            
                //     $sql_jurnal = mysqli_query($koneksi, "INSERT INTO jurnalumum(tgl_pembelian, jurnal, no_akun, akun_debit, total_debit, akun_kredit, total_kredit)
                //                     VALUES ('$tgl','$jPenjualan','$nomorAkun','$temp','$saldo','$name','$saldo')");
                // }
            }

            if($sql==true){
                echo "<script type=\"text/javascript\">window.location.href = '?menu=jurnalpenjualan';</script>";
            }else{
                echo "<script>alert('proses gagal!!');</script>";
            }
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
                        <h4 class="card-title">Form Jurnal Penjualan</h4>
                        <form class="forms-sample" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label for="exampleInputName1">Tanggal Penjualan</label>
                                <input type="date" name="tanggal" class="form-control" id="exampleInputName1" value="<?php echo $tgl_penjualan ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_debt">Pelanggan</label>
                                <select name="pelanggan" class="form-control" id="select2" required>
                                <option></option>
                                <?php 
                                $query = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY nama ASC") or die(mysqli_error()); 
                                while ($data = mysqli_fetch_array($query)){
                                    if($data['id'] == $pelanggan){
                                        echo "<option value='$data[id]' selected='true'>$data[nama]</option>";
                                    }else{
                                        echo "<option value='$data[id]'>$data[nama]</option>";
                                    }
                                };
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_debt">Akun Debit</label>
                                <select name="akun" class="form-control" id="select2" required>
                                <option></option>
                                <?php 
                                $query = mysqli_query($koneksi, "SELECT * FROM akun ORDER BY no_akun ASC") or die(mysqli_error()); 
                                while ($data = mysqli_fetch_array($query)){
                                    if($data['no_akun'] == $no_akun){
                                        echo "<option value='$data[no_akun]-$data[nama]' selected='true'>$data[no_akun] - $data[nama]</option>";
                                    }else{
                                        echo "<option value='$data[no_akun]-$data[nama]'>$data[no_akun] - $data[nama]</option>";
                                    }
                                };
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_debt">Akun Kredit</label>
                                <select name="akun2" class="form-control" id="select2" required>
                                <option></option>
                                <?php 
                                $query = mysqli_query($koneksi, "SELECT * FROM akun ORDER BY no_akun ASC") or die(mysqli_error()); 
                                while ($data = mysqli_fetch_array($query)){
                                    if($data['no_akun'] == $no_akun){
                                        echo "<option value='$data[no_akun]-$data[nama]' selected='true'>$data[no_akun] - $data[nama]</option>";
                                    }else{
                                        echo "<option value='$data[no_akun]-$data[nama]'>$data[no_akun] - $data[nama]</option>";
                                    }
                                };
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_debt">Barang/Jasa</label>
                                <select name="barang" class="form-control" id="select2" required>
                                <option></option>
                                <?php 
                                $query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC") or die(mysqli_error()); 
                                while ($data = mysqli_fetch_array($query)){
                                    if($data['barang'] == $barang){
                                        echo "<option value='$data[id]' selected='true'>$data[nama]</option>";
                                    }else{
                                        echo "<option value='$data[id]'>$data[nama]</option>";
                                    }
                                };
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Saldo</label>
                                <input type="text" name="saldo" class="form-control" id="rupiah" placeholder="Saldo" value="<?php echo $saldo ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">No Faktur</label>
                                <input type="text" name="no_faktur" class="form-control" id="no_faktur" placeholder="Nomor Faktur" value="<?php echo $no_faktur ?? '' ?>" required>
                            </div>
                            <!-- <div class="form-group">
                                <label for="jenis_debt">Jenis </label>
                                    <select name="jenis_debt" class="form-control" id="sel1">
                                    <option></option>
                                    <option value="Debit" <?php if($jenis=='Debit'){ echo 'selected="selected"';} ?>>Debit</option>
                                    <option value="Kredit" <?php if($jenis=='Kredit'){ echo 'selected="selected"';} ?>>Kredit</option>
                                </select>
                            </div> -->
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="hidden" name="jenis_debt" value="Debit">
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light" onClick="document.location.href='index.php?menu=jurnalpenjualan';">Cancel</button>
                        </form>    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<script>
var rupiah = document.getElementById("rupiah");
var rupiahx = document.getElementById("rupiahx");
rupiah.addEventListener("keyup", function(e) {
  // tambahkan 'Rp.' pada saat form di ketik
  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
  rupiah.value = formatRupiah(this.value);
  rupiahx.value = rupiah.value;
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ?  + rupiah : "";
};
</script>