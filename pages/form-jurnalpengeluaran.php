<?php
	$id       = $_GET['id'] ?? '';
    $pem      = $_GET['pem'] ?? '';    
    $jenis    = '';
    if($pem != ''){
        $query = mysqli_query($koneksi, "SELECT * FROM jurnalpembelian WHERE id = '$pem'") or die(mysqli_error());

        while ($data = mysqli_fetch_array($query)){
            $no_akun = $data["no_akun2"];
            $saldo   = "Rp " . number_format($data["saldo"],2,',','.');
            $no_faktur = $data["no_faktur"];
        };
    }

    $query = mysqli_query($koneksi, "SELECT * FROM jurnal_pengeluaran_kas WHERE id = '$id'") or die(mysqli_error());

    while ($data = mysqli_fetch_array($query)){
        $id             = $data["id"];
        $tgl_pengeluaran = $data["tgl_pengeluaran"];
        $no_akun        = $data["no_akun"];
        $nama_akun      = $data["nama_akun"];
        $no_akun2        = $data["no_akun2"];
        $nama_akun2      = $data["nama_akun2"];
        $jenis          = $data["jenis"];
        $saldo          = "Rp " . number_format($data["saldo"],2,',','.');
    };

    if(isset($_POST['submit'])){
        $id             = $_POST['id'];
        if($pem != ''){
            $jenis = "Kredit";
            $keterangan = "Pembayaran No Faktur $no_faktur";
        }else{
            $jenis = "Debit";
            $temp  = "KAS";
        }

        $jPengeluaran   = "Pengeluaran Kas";
		$tgl            = $_POST['tanggal'];
        $akun           = explode('-',$_POST['akun']);
		$nomorAkun      = $akun[0];
		$name           = $akun[1];
        $akun2           = explode('-',$_POST['akun2']);
		$nomorAkun2      = $akun2[0];
		$name2           = $akun2[1];
		//$jenis          = $_POST['jenis_debt'];
        //rubah format rupiah ke sql
        $harga      = str_replace("Rp", "", $_POST['saldo']);
        $saldo      = str_replace(".", "", $harga);
        $saldo      = str_replace(",00", "", $saldo);

        if($_POST['akun'] == $_POST['akun2']){
            echo "<script>alert('akun tidak boleh sama!!');</script>";
        }else{

            if($id){
                $sql = mysqli_query($koneksi, "UPDATE jurnal_pengeluaran_kas SET tgl_pengeluaran = '$tgl', no_akun = '$nomorAkun', nama_akun = '$name', saldo = '$saldo', jenis = '$jenis' WHERE id = '$id'");
                $kode_jurnal = "KELUAR$id";
                if ($jenis == "Debit"){

                    $sql_umum = mysqli_query($koneksi, "UPDATE jurnalumum SET tgl_pembelian = '$tgl', jurnal = '$jPengeluaran', no_akun = '$nomorAkun', akun_debit = '$name', total_debit = '$saldo', no_kredit = '$nomorAkun2', akun_kredit = '$name2', total_kredit = '$saldo' WHERE kode_jurnal = '$kode_jurnal'");

                }elseif($jenis == "Kredit"){
                    
                    $sql_jurnal = mysqli_query($koneksi, "UPDATE jurnalumum SET tgl_pembelian = '$tgl', jurnal = '$jPengeluaran', no_akun = '$nomorAkun', akun_debit = '$name', total_debit = '$saldo', no_kredit = '$nomorAkun2', akun_kredit = '$name2', total_kredit = '$saldo' WHERE kode_jurnal = '$kode_jurnal'");

                    $sql_pembelian = mysqli_query($koneksi, "UPDATE jurnalpembelian SET status = '1' WHERE id = '$pem'");

                }
            }else{
                $sql = mysqli_query($koneksi, "INSERT INTO jurnal_pengeluaran_kas(tgl_pengeluaran, no_akun, nama_akun, no_akun2, nama_akun2, saldo, jenis) 
                VALUES ('$tgl','$nomorAkun','$name','$nomorAkun2','$name2','$saldo','$jenis')");

                $last_id = mysqli_insert_id($koneksi);
                $kode_jurnal = "KELUAR$last_id";

                if ($jenis == "Debit") {
                    
                    $sql_umum = mysqli_query($koneksi,"INSERT INTO jurnalumum(kode_jurnal,tgl_pembelian, jurnal, no_akun, akun_debit, total_debit, no_kredit, akun_kredit, total_kredit, keterangan) 
                                VALUES ('$kode_jurnal','$tgl','$jPengeluaran','$nomorAkun','$name','$saldo','$nomorAkun2','$name2','$saldo','$keterangan')");
                    
                }elseif($jenis == "Kredit"){
            
                    $sql_jurnal = mysqli_query($koneksi, "INSERT INTO jurnalumum(kode_jurnal,tgl_pembelian, jurnal, no_akun, akun_debit, total_debit, no_kredit, akun_kredit, total_kredit, keterangan)
                                    VALUES ('$kode_jurnal','$tgl','$jPengeluaran','$nomorAkun','$name','$saldo','$nomorAkun2','$name2','$saldo','$keterangan')");

                    $sql_pembelian = mysqli_query($koneksi, "UPDATE jurnalpembelian SET status = '1' WHERE id = '$pem'");
                }
            }

            //neraca activa
            if(substr($nomorAkun,0,-4) == 1){
                $sql_neraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = $nomorAkun");
                $cek_neraca = mysqli_num_rows($sql_neraca);
                if($cek_neraca > 0){
                    $row = mysqli_fetch_object($sql_neraca);
                    $saldo1 = $row->saldo + $saldo;

                    $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $nomorAkun");
                }else{
                    $insert = mysqli_query($koneksi, "INSERT INTO neraca(kode_jurnal, no_akun, akun, saldo, jenis_akun)
                                VALUES ('$kode_jurnal','$nomorAkun','$name','$saldo',0)");
                }
            }

            if(substr($nomorAkun2,0,-4) == 1){
                $sql_neraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = $nomorAkun2");
                $cek_neraca = mysqli_num_rows($sql_neraca);
                if($cek_neraca > 0){
                    $row = mysqli_fetch_object($sql_neraca);
                    $saldo1 = $row->saldo - $saldo;

                    $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $nomorAkun2");
                }else{
                    $insert = mysqli_query($koneksi, "INSERT INTO neraca(kode_jurnal, no_akun, akun, saldo, jenis_akun)
                                VALUES ('$kode_jurnal','$nomorAkun2','$name2','$saldo',0)");
                }
            }

            //neraca pasiva
            if(substr($nomorAkun,0,-4) == 2){
                $sql_neraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = $nomorAkun");
                $cek_neraca = mysqli_num_rows($sql_neraca);
                if($cek_neraca > 0){
                    $row = mysqli_fetch_object($sql_neraca);
                    $saldo1 = $row->saldo + $saldo;

                    $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $nomorAkun");
                }else{
                    $insert = mysqli_query($koneksi, "INSERT INTO neraca(kode_jurnal, no_akun, akun, saldo, jenis_akun)
                                VALUES ('$kode_jurnal','$nomorAkun','$name','$saldo',1)");
                }
            }

            if(substr($nomorAkun2,0,-4) == 2){
                $sql_neraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = $nomorAkun2");
                $cek_neraca = mysqli_num_rows($sql_neraca);
                if($cek_neraca > 0){
                    $row = mysqli_fetch_object($sql_neraca);
                    $saldo1 = $row->saldo - $saldo;

                    $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $nomorAkun2");
                }else{
                    $insert = mysqli_query($koneksi, "INSERT INTO neraca(kode_jurnal, no_akun, akun, saldo, jenis_akun)
                                VALUES ('$kode_jurnal','$nomorAkun2','$name2','$saldo',1)");
                }
            }

            if(substr($nomorAkun,0,-4) == 3){
                $sql_neraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = $nomorAkun");
                $cek_neraca = mysqli_num_rows($sql_neraca);
                if($cek_neraca > 0){
                    $row = mysqli_fetch_object($sql_neraca);
                    $saldo1 = $row->saldo + $saldo;

                    $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $nomorAkun");
                }else{
                    $insert = mysqli_query($koneksi, "INSERT INTO neraca(kode_jurnal, no_akun, akun, saldo, jenis_akun)
                                VALUES ('$kode_jurnal','$nomorAkun','$name','$saldo',1)");
                }
            }

            if(substr($nomorAkun2,0,-4) == 3){
                $sql_neraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = $nomorAkun2");
                $cek_neraca = mysqli_num_rows($sql_neraca);
                if($cek_neraca > 0){
                    $row = mysqli_fetch_object($sql_neraca);
                    $saldo1 = $row->saldo - $saldo;

                    $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $nomorAkun2");
                }else{
                    $insert = mysqli_query($koneksi, "INSERT INTO neraca(kode_jurnal, no_akun, akun, saldo, jenis_akun)
                                VALUES ('$kode_jurnal','$nomorAkun2','$name2','$saldo',1)");
                }
            }

            if($sql==true){
                echo "<script type=\"text/javascript\">window.location.href = '?menu=jurnalpengeluaran';</script>";
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
                        <h4 class="card-title">Form Jurnal Pengeluaran Kas</h4>
                        <form class="forms-sample" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label for="exampleInputName1">Tanggal Pengeluaran</label>
                                <input type="date" name="tanggal" class="form-control" id="exampleInputName1" value="<?php echo $tgl_pengeluaran ?? '' ?>" required>
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
                                    if($data['no_akun'] == $no_akun2){
                                        echo "<option value='$data[no_akun]-$data[nama]' selected='true'>$data[no_akun] - $data[nama]</option>";
                                    }else{
                                        echo "<option value='$data[no_akun]-$data[nama]'>$data[no_akun] - $data[nama]</option>";
                                    }
                                };
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Saldo</label>
                                <input type="text" name="saldo" class="form-control" id="rupiah" placeholder="Saldo" value="<?php echo $saldo ?? '' ?>" required>
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
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light" onClick="document.location.href='index.php?menu=jurnalpengeluaran';">Cancel</button>
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