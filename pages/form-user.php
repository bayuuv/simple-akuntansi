<?php
	$id       = $_GET['id'] ?? '';
    $level    = '';
    $pass     = '';

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'") or die(mysqli_error());

    while ($data = mysqli_fetch_array($query)){
        $id            = $data["id"];
        $username      = $data["username"];
        $pass          = $data["pass"];
        $level         = $data["level"];
    };

    if(isset($_POST['submit'])){
        $uname      = $_POST['username'];
        $password   = $_POST['pass'];
        $lvl        = $_POST['level'];
        $id         = $_POST['id'];

        if($id){
            if($password != ''){
                $sql = mysqli_query($koneksi, "UPDATE user SET username = '$uname', pass = '$password', level = '$lvl' WHERE id = '$id'");
            }else{
                $sql = mysqli_query($koneksi, "UPDATE user SET username = '$uname', level = '$lvl' WHERE id = '$id'");
            }
        }else{
            $sql = mysqli_query($koneksi, "INSERT INTO user (username, pass, level) VALUES ('$uname','$password','$lvl')");
        }

        if($sql==true){
            echo "<script type=\"text/javascript\">window.location.href = '?menu=user';</script>";
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
                        <h4 class="card-title">Form Jurnal User</h4>
                        <form class="forms-sample" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Username</label>
                                <input type="text" name="username" class="form-control" id="exampleInput" placeholder="Username" value="<?php echo $username ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">Password</label>
                                <?php if($pass != ''){?>
                                    <input type="password" name="pass" class="form-control" id="exampleInputPass" placeholder="Isi Jika Ingin Merubah Password" value="">
                                <?php }else{ ?>
                                    <input type="password" name="pass" class="form-control" id="exampleInputPass" placeholder="Password" value="">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="level">Level </label>
                                    <select name="level" class="form-control" id="sel1" required>
                                    <option></option>
                                    <option value="admin" <?php if($level=='admin'){ echo 'selected="selected"';} ?>>Admin</option>
                                    <option value="manager" <?php if($level=='manager'){ echo 'selected="selected"';} ?>>Manager</option>
                                    <option value="accounting" <?php if($level=='accounting'){ echo 'selected="selected"';} ?>>Accounting</option>
                                </select>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light" onClick="document.location.href='index.php?menu=akun';">Cancel</button>
                        </form>    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            