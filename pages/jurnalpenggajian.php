<?php
  $idt = $_GET['idt'] ?? '';

  if($idt <> ''){
    //neraca
    $sql = mysqli_query($koneksi, "SELECT * FROM jurnal_penggajian WHERE id = '$idt'") or die(mysqli_error());
    $row = mysqli_fetch_object($sql);
    if(substr($row->no_akun,0,-4) == 1){
        $no_akun = $row->no_akun;

        $sqlneraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = '$no_akun'") or die(mysqli_error());
        $row1 = mysqli_fetch_object($sqlneraca);

        $saldo1 = $row1->saldo - $row->saldo;
        $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $no_akun");
    }else{
        $no_akun = $row->no_akun2;

        $sqlneraca = mysqli_query($koneksi, "SELECT * FROM neraca WHERE no_akun = '$no_akun'") or die(mysqli_error());
        $row1 = mysqli_fetch_object($sqlneraca);

        $saldo1 = $row1->saldo + $row->saldo;
        $update = mysqli_query($koneksi, "UPDATE neraca SET saldo = $saldo1 WHERE no_akun = $no_akun");
    }

    $hasil = mysqli_query($koneksi, "DELETE FROM jurnal_penggajian WHERE id = '$idt'") or die(mysqli_error());
    $kode_jurnal = "GAJI$idt";
    mysqli_query($koneksi, "DELETE FROM jurnalumum WHERE kode_jurnal = '$kode_jurnal'") or die(mysqli_error());

    if($hasil==true){
      echo "<script type=\"text/javascript\">window.location.href = '?menu=jurnalpenggajian';</script>";
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
                        <h4 class="card-title">Jurnal Penggajian</h4>
                        <a href="index.php?menu=form-jurnalpenggajian" class="btn btn-primary">Tambah <i class="typcn typcn-document btn-icon-prepend"></i></a>
                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Saldo</th>
                                    <th>Jenis</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                $page = (isset($_GET['page']))? (int) $_GET['page'] : 1;

                                // Jumlah data per halaman
                                $limit = 5;

                                $limitStart = ($page - 1) * $limit;

                                $sql = mysqli_query($koneksi, "SELECT * FROM jurnal_penggajian ORDER BY tgl_penggajian DESC LIMIT $limitStart, $limit") or die(mysqli_error());
                                $no = $limitStart + 1;
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $saldo = "Rp " . number_format($data["saldo"],2,',','.');
                                    echo"
                                        <tr>
                                            <td>".tgl_indo($data['tgl_penggajian'])."</td>
                                            <td>$data[no_akun]</td>
                                            <td>$data[nama_akun]</td>
                                            <td>$saldo</td>
                                            <td>$data[jenis]</td>
                                            <td>
                                            <div class='d-flex align-items-center'>
                                                <a href='index.php?menu=form-jurnalpenggajian&id=$data[id]' class='btn btn-success btn-sm btn-icon-text mr-3'>
                                                Edit
                                                <i class='typcn typcn-edit btn-icon-append'></i>                          
                                                </a>
                                                <a href=\"?menu=jurnalpenggajian&idt=".$data["id"]."\" onClick=\"if (confirm('Yakin akan Hapus ".$data["nama_akun"]."?') == true) return true; else return false;\" class='btn btn-danger btn-sm btn-icon-text'>
                                                Hapus
                                                <i class='typcn typcn-delete-outline btn-icon-append'></i>                          
                                                </a>
                                            </div>
                                            </td>
                                    </tr>";
                                };
                                ?>
                            </table>
                            <br>
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <?php
                                    // Jika page = 1, maka LinkPrev disable
                                    if($page == 1){ 
                                    ?>        
                                    <!-- link Previous Page disable --> 
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                    <?php
                                    }
                                    else{ 
                                    $LinkPrev = ($page > 1)? $page - 1 : 1;
                                    ?>
                                    <!-- link Previous Page --> 
                                    <li class="page-item"><a class="page-link" href="index.php?menu=jurnalpenggajian&page=<?php echo $LinkPrev; ?>">Previous</a></li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $SqlQuery = mysqli_query($koneksi, "SELECT * FROM jurnal_penggajian");        
                                    
                                    //Hitung semua jumlah data yang berada pada tabel
                                    $JumlahData = mysqli_num_rows($SqlQuery);
                                    
                                    // Hitung jumlah halaman yang tersedia
                                    $jumlahPage = ceil($JumlahData / $limit); 
                                    
                                    // Jumlah link number 
                                    $jumlahNumber = 1; 

                                    // Untuk awal link number
                                    $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; 
                                    
                                    // Untuk akhir link number
                                    $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; 
                                    
                                    for($i = $startNumber; $i <= $endNumber; $i++){
                                    $linkActive = ($page == $i)? ' class="page-item active"' : ' class="page-item"';
                                    ?>
                                    <li <?php echo $linkActive; ?>><a class="page-link" href="index.php?menu=jurnalpenggajian&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                    
                                    <!-- link Next Page -->
                                    <?php       
                                    if($page == $jumlahPage){ 
                                    ?>
                                    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                                    <?php
                                    }
                                    else{
                                    $linkNext = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
                                    ?>
                                    <li class="page-item"><a class="page-link" href="index.php?menu=jurnalpenggajian&page=<?php echo $linkNext; ?>">Next</a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            