<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <center><h3>Neraca</h3></center>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Activa</th>
                                    <th></th>
                                </tr>
                                <?php
                                $arr10[] = 0;
                                $sql = mysqli_query($koneksi, "SELECT * FROM neraca where jenis_akun = 0 order by no_akun ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_object($sql)){
                                    $total_debit = "Rp " . number_format($data->saldo,2,',','.');
                                    $arr10[] = $data->saldo;
                                    echo"
                                        <tr>
                                            <td>$data->akun</td>
                                            <td>$total_debit</td>
                                    </tr>";
                                };
                                if($arr10 > 0){
                                    $t10 = array_sum($arr10);
                                }else{
                                    $t10 = 0;
                                }
                                ?>
                                <tr>
                                    <th>Jumlah</th>
                                    <?php 
                                        $semua = $t10;
                                        $tot = "Rp " . number_format($semua,2,',','.');

                                        echo "<th>$tot</th>";
                                    ?>
                                </tr>
                                <tr>
                                    <th>Pasiva</th>
                                    <th></th>
                                </tr>
                                <?php
                                $arr20[] = 0;
                                $sql = mysqli_query($koneksi, "SELECT * FROM neraca where jenis_akun = 1 order by no_akun ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_object($sql)){
                                    $total_kredit = "Rp " . number_format($data->saldo,2,',','.');
                                    $arr20[] = $data->saldo;

                                    echo"
                                        <tr>
                                            <td>$data->akun</td>
                                            <td>$total_kredit</td>
                                    </tr>";
                                };
                                if($arr20 > 0){
                                    $t20 = array_sum($arr20);
                                }else{
                                    $t20 = 0;
                                }
                                ?>
                                <?php
                                $arr40[] = 0;
                                $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_kredit, 2) = 40 or LEFT(no_kredit, 2) = 70 GROUP BY no_kredit order by no_kredit ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $total_kredit = "Rp " . number_format($data["total_kredit"],2,',','.');
                                    $arr40[] = $data["total_kredit"];
                                };
                                if($arr40 > 0){
                                    $t40 = array_sum($arr40);
                                }else{
                                    $t40 = 0;
                                }
                                ?>
                                <?php
                                $arr50[] = 0;
                                $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_akun, 2) = 50 or LEFT(no_akun, 2) = 60 or LEFT(no_akun, 2) = 80 GROUP BY no_akun order by no_akun ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $total_debit = "Rp " . number_format($data["total_debit"],2,',','.');
                                    $arr50[] = $data["total_debit"];
                                };
                                if($arr50 > 0){
                                    $t50 = array_sum($arr50);
                                }else{
                                    $t50 = 0;
                                }

                                $labarugi = $t40 - $t50;
                                $totlaba = "Rp " . number_format($labarugi,2,',','.');
                                echo"
                                        <tr>
                                            <td>Laba Rugi</td>
                                            <td>$totlaba</td>
                                    </tr>";
                                ?>
                                <tr>
                                    <th>Jumlah</th>
                                    <?php 
                                        $semua = $t20 + $labarugi;
                                        $tot = "Rp " . number_format($semua,2,',','.');

                                        echo "<th>$tot</th>";
                                    ?>
                                </tr>
                            </table>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            