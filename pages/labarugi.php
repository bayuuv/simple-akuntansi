<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Laba Rugi</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <?php
                                $arr40[] = 0;
                                $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_kredit, 2) = 40 or LEFT(no_kredit, 2) = 70 GROUP BY no_kredit order by no_kredit ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $total_kredit = "Rp " . number_format($data["total_kredit"],2,',','.');
                                    $arr40[] = $data["total_kredit"];

                                    echo"
                                        <tr>
                                            <td>$data[akun_kredit]</td>
                                            <td>$total_kredit</td>
                                    </tr>";
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

                                    echo"
                                        <tr>
                                            <td>$data[akun_debit]</td>
                                            <td>$total_debit</td>
                                    </tr>";
                                };
                                if($arr50 > 0){
                                    $t50 = array_sum($arr50);
                                }else{
                                    $t50 = 0;
                                }
                                ?>
                                <tr>
                                    <th>Laba Bersih</th>
                                    <?php 
                                        $semua = $t40 - $t50;
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
            