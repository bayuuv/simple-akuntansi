<?php
$akun = $_POST['akun'] ?? '';
$tgl1 = $_POST['tanggal1'] ?? '';
$tgl2 = $_POST['tanggal2'] ?? '';
include "config/koneksi.php";
include "config/fungsi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Laporan Buku Besar</title>
  <style type="text/css">
    /* Kode CSS Untuk PAGE ini dibuat oleh http://jsfiddle.net/2wk6Q/1/ */
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    
    @page {
        size: landscape;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
    .tb {
        width: 100%;
        height: 100%;
    }
    </style>
</head>

<body>
<!-- partial -->
<div class="page">
    <h4 class="card-title"><center>Buku Besar</center></h4>
        <table border="1" style="width:200px">
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
        <table class="center" style="width: 50%; height: 100%;">
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
</body>
<script>
window.print();
</script>   
</html>           