<?php 
	
	session_start();
	include "config/koneksi.php";

	$user = $_POST['username'];
	$pass = $_POST['password'];
	$login = $_POST['login'];
	
	if (isset($login)) {

			$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$user' AND pass = '$pass'") or die(mysqli_error());
			$data = mysqli_fetch_array($sql);
			$cek = mysqli_num_rows($sql);
		
			if ($cek > 0) {
				if ($data['level'] == "admin") {

						$_SESSION['admin'] 		= $data['level'];
				
						header("location:index.php");

					} else if ($data['level'] == "manager") {
						
						$_SESSION['admin'] 		= $data['level'];

						header("location:index.php?menu=jurnalumum");
					}
					else if ($data['level'] == "accounting") {
						
						$_SESSION['accounting'] = $data['level'];

						header("location:index.php");
					}					
				
			} 
			else{
				?> <script type="text/javascript">alert("Usename / password salah ");window.location.href='index.php';</script> <?php
			}
		

	}

?>