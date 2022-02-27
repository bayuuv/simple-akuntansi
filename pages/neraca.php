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
                                $sql = mysqli_query($koneksi, "SELECT *, SUM(total_debit) as total FROM jurnalumum where LEFT(no_akun, 2) = 10 or LEFT(no_akun, 2) = 11 GROUP BY no_akun order by no_akun ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $total_debit = "Rp " . number_format($data["total"],2,',','.');
                                    $arr10[] = $data["total"];
                                    echo"
                                        <tr>
                                            <td>$data[akun_debit]</td>
                                            <td>$total_debit</td>
                                    </tr>";
                                };
                                if($arr10 > 0){
                                    $t10 = array_sum($arr10);
                                }else{
                                    $t10 = 0;
                                }
                                ?>
                                <?php
                                // $arr100[] = 0;
                                // $sql1 = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_akun, 2) = 10 order by no_akun ASC") or die(mysqli_error());
                            
                                // while ($data1 = mysqli_fetch_array($sql1)){
                                //     $total_kredit = "Rp " . number_format($data1["total_kredit"],2,',','.');
                                //     $arr100[] = $data1["total_kredit"];

                                //     echo"
                                //         <tr>
                                //             <td>$data1[akun_kredit]</td>
                                //             <td>$total_kredit</td>
                                //     </tr>";
                                // };
                                // if($arr100 > 0){
                                //     $t100 = array_sum($arr100);
                                // }else{
                                //     $t100 = 0;
                                // }
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
                                //$sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_kredit, 2) = 20 or LEFT(no_kredit, 2) = 30 order by no_akun ASC") or die(mysqli_error());
                                $sql = mysqli_query($koneksi, "SELECT *, SUM(total_kredit) as total FROM jurnalumum where LEFT(no_kredit, 2) = 20 or LEFT(no_kredit, 2) = 30 GROUP BY no_kredit order by no_kredit ASC") or die(mysqli_error());
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $total_kredit = "Rp " . number_format($data["total"],2,',','.');
                                    $arr20[] = $data["total"];

                                    echo"
                                        <tr>
                                            <td>$data[akun_kredit]</td>
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
                                // $arr30[] = 0;
                                // $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_akun, 2) = 20 or LEFT(no_akun, 2) = 30 order by no_akun ASC") or die(mysqli_error());
                            
                                // while ($data = mysqli_fetch_array($sql)){
                                //     $total_kredit = "Rp " . number_format($data["total_kredit"],2,',','.');
                                //     $arr30[] = $data["total_kredit"];

                                //     echo"
                                //         <tr>
                                //             <td>$data[akun_kredit]</td>
                                //             <td>$total_kredit</td>
                                //     </tr>";
                                // };
                                // if($arr30 > 0){
                                //     $t30 = array_sum($arr30);
                                // }else{
                                //     $t30 = 0;
                                // }
                                ?>
                                <!-- laba tahun berjalan -->
                                <!-- <tr>
                                    <td>Laba Tahun Berjalan</td> -->
                                    <?php
                                    // $arr40[] = 0;
                                    // $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_akun, 2) = 40 order by no_akun ASC") or die(mysqli_error());
                                
                                    // while ($data = mysqli_fetch_array($sql)){
                                    //     $total_debit = "Rp " . number_format($data["total_debit"],2,',','.');
                                    //     $arr40[] = $data["total_debit"];
                                    // };
                                    // if($arr40 > 0){
                                    //     $t40 = array_sum($arr40);
                                    // }else{
                                    //     $t40 = 0;
                                    // }

                                    // $arr50[] = 0;
                                    // $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum where LEFT(no_akun, 2) = 50 or LEFT(no_akun, 2) = 60 or LEFT(no_akun, 2) = 70 or LEFT(no_akun, 2) = 80 order by no_akun ASC") or die(mysqli_error());
                                
                                    // while ($data = mysqli_fetch_array($sql)){
                                    //     $total_kredit = "Rp " . number_format($data["total_kredit"],2,',','.');
                                    //     $arr50[] = $data["total_kredit"];
                                    // };
                                    // if($arr50 > 0){
                                    //     $t50 = array_sum($arr50);
                                    // }else{
                                    //     $t50 = 0;
                                    // }
                                    ?>
                                    <?php 
                                        // $laba = $t40 + $t50;
                                        // $tot1 = "Rp " . number_format($laba,2,',','.');

                                        // echo "<td>$tot1</td>";
                                    ?>
                                <!-- </tr> -->
                                <tr>
                                    <th>Jumlah</th>
                                    <?php 
                                        $semua = $t20;
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
            