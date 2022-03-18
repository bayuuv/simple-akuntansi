<?php
$akun = $_POST['akun'] ?? '';
$tgl1 = $_POST['tanggal1'] ?? '';
$tgl2 = $_POST['tanggal2'] ?? '';
?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><center>Buku Besar</center></h4>
                        <form class="form-inline" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <select name="akun" class="form-control mb-2 mr-sm-2" id="select2">
                                <option></option>
                                <?php 
                                $ex = explode('-',$akun);
                                $no_akun = $ex[0];
                                $query = mysqli_query($koneksi, "SELECT * FROM akun") or die(mysqli_error()); 
                                while ($data = mysqli_fetch_array($query)){
                                    if($data['no_akun'] == $no_akun){
                                        echo "<option value='$data[no_akun]-$data[nama]' selected='true'>$data[no_akun] - $data[nama]</option>";
                                    }else{
                                        echo "<option value='$data[no_akun]-$data[nama]'>$data[no_akun] - $data[nama]</option>";
                                    }
                                };
                                ?>
                                </select>
                                &nbsp;&nbsp;&nbsp;
                                <input type="date" name="tanggal1" class="form-control mb-2 mr-sm-2" id="exampleInputName1" value="<?php echo $tgl1 ?? '' ?>">
                                &nbsp;S/D&nbsp;
                                <input type="date" name="tanggal2" class="form-control mb-2 mr-sm-2" id="exampleInputName1" value="<?php echo $tgl2 ?? '' ?>">
                       
                                <button type="submit" name="submit" class="btn btn-primary mb-2 mr-sm-2">Submit</button> 
                        </form>
                        <br>
                        <?php if($akun){ ?>
                        <a href="cetak-bukubesar.phpakun=<?php $akun ?>&tgl=<?php $tgl1 ?>&$tgl2<?php $tgl2 ?>" target="_blank">Cetak</a>
                        <?php }else{ ?>
                        <a href="cetak-bukubesar.php" target="_blank">Cetak</a>
                        <?php } ?>
                        <br><br>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jurnal</th>
                                        <th>Nama Akun</th>
                                        <th>Debit</th>
                                    </tr>
                                    <?php
                                    if($akun){
                                        $pecah = explode('-',$akun);
                                        //$akuns = "AND akun_debit = '$pecah[1]'";
                                        $akuns = "WHERE akun_debit = '$pecah[1]'";

                                        if($tgl1){
                                            $tanggal1 = "AND tgl_pembelian >= '$tgl1' ";
                                        }else{
                                            $tanggal1 = "";
                                        }
    
                                        if($tgl2){
                                            $tanggal2 = "AND tgl_pembelian <= '$tgl2'";
                                        }else{
                                            $tanggal2 = "";
                                        }
                                    }else{
                                        $akuns = "";

                                        if($tgl1){
                                            $tanggal1 = "WHERE tgl_pembelian >= '$tgl1' ";
                                        }else{
                                            $tanggal1 = "";
                                        }
    
                                        if($tgl2){
                                            $tanggal2 = "AND tgl_pembelian <= '$tgl2'";
                                        }else{
                                            $tanggal2 = "";
                                        }
                                    }

                                    $filter = $akuns.$tanggal1.$tanggal2;
                                
                                    //$sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum WHERE akun_kredit = 'KAS' or akun_kredit = 'Hutang Usaha' ".$filter." ORDER BY tgl_pembelian DESC") or die(mysqli_error());
                                    $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum ".$filter." ORDER BY tgl_pembelian DESC") or die(mysqli_error());
                                
                                    while ($data = mysqli_fetch_array($sql)){
                                        $total_debit = "Rp " . number_format($data["total_debit"],2,',','.');
                                        echo"
                                            <tr>
                                                <td>".tgl_indo($data['tgl_pembelian'])."</td>
                                                <td>$data[jurnal]</td>
                                                <td>$data[akun_debit]</td>
                                                <td>$total_debit</td>
                                        </tr>";
                                    };
                                    ?>
                                </table>  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jurnal</th>
                                        <th>Nama Akun</th>
                                        <th>Kredit</th>
                                    </tr>
                                    <?php
                                    if($akun){
                                        $pecah = explode('-',$akun);
                                        //$akunz = "AND akun_kredit = '$pecah[1]'";
                                        $akunz = "WHERE akun_kredit = '$pecah[1]'";

                                        if($tgl1){
                                            $tanggal1a = " AND tgl_pembelian >= '$tgl1' ";
                                        }else{
                                            $tanggal1a = "";
                                        }
    
                                        if($tgl2){
                                            $tanggal2a = "AND tgl_pembelian <= '$tgl2'";
                                        }else{
                                            $tanggal2a = "";
                                        }
                                    }else{
                                        $akunz = "";

                                        if($tgl1){
                                            $tanggal1a = "WHERE tgl_pembelian >= '$tgl1' ";
                                        }else{
                                            $tanggal1a = "";
                                        }
    
                                        if($tgl2){
                                            $tanggal2a = "AND tgl_pembelian <= '$tgl2'";
                                        }else{
                                            $tanggal2a = "";
                                        }
                                    }

                                    $filter2 = $akunz.$tanggal1a.$tanggal2a;
                                    
                                    //$sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum WHERE akun_debit = 'KAS' or akun_debit = 'Hutang Usaha' ".$filter2." ORDER BY tgl_pembelian DESC") or die(mysqli_error());
                                    $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum ".$filter2." ORDER BY tgl_pembelian DESC") or die(mysqli_error());
                                
                                    while ($data = mysqli_fetch_array($sql)){
                                        $total_kredit = "Rp " . number_format($data["total_kredit"],2,',','.');
                                        echo"
                                            <tr>
                                                <td>".tgl_indo($data['tgl_pembelian'])."</td>
                                                <td>$data[jurnal]</td>
                                                <td>$data[akun_kredit]</td>
                                                <td>$total_kredit</td>
                                        </tr>";
                                    };
                                    ?>
                                </table>  
                            </div>
                        </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            