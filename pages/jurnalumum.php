<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Jurnal Umum</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Akun Debit</th>
                                    <th>Total</th>
                                    <th>Akun Kredit</th>
                                    <th>Total</th>
                                </tr>
                                <?php
                                $page = (isset($_GET['page']))? (int) $_GET['page'] : 1;

                                // Jumlah data per halaman
                                $limit = 10;

                                $limitStart = ($page - 1) * $limit;

                                $sql = mysqli_query($koneksi, "SELECT * FROM jurnalumum ORDER BY tgl_pembelian DESC LIMIT $limitStart, $limit") or die(mysqli_error());
                                $no = $limitStart + 1;
                            
                                while ($data = mysqli_fetch_array($sql)){
                                    $total_debit = "Rp " . number_format($data["total_debit"],2,',','.');
                                    $total_kredit = "Rp " . number_format($data["total_kredit"],2,',','.');

                                    echo"
                                        <tr>
                                            <td>".tgl_indo($data['tgl_pembelian'])."</td>
                                            <td>$data[keterangan]</td>
                                            <td>$data[akun_debit]</td>
                                            <td>$total_debit</td>
                                            <td>$data[akun_kredit]</td>
                                            <td>$total_kredit</td>
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
                                    <li class="page-item"><a class="page-link" href="index.php?menu=jurnalumum&page=<?php echo $LinkPrev; ?>">Previous</a></li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $SqlQuery = mysqli_query($koneksi, "SELECT * FROM jurnalumum");        
                                    
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
                                    <li <?php echo $linkActive; ?>><a class="page-link" href="index.php?menu=jurnalumum&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                                    <li class="page-item"><a class="page-link" href="index.php?menu=jurnalumum&page=<?php echo $linkNext; ?>">Next</a></li>
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
            