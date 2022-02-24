<?php 
session_start();
include "config/koneksi.php";
include "config/fungsi.php";

if ($_SESSION['admin']) {
	include('partials/header.php');
} else {
    header("location:login.php");
}
?>

?>

<?php 
include('partials/menu.php');

if(isset($_GET['menu']) AND is_file('pages/'.$_GET['menu']. '.php')) 
	if ($_SESSION['admin'] == 'manager') {
		if($_GET['menu'] == 'bukubesar'){
			require_once 'pages/bukubesar.php'; 
		}else{
			require_once 'pages/jurnalumum.php'; 
		}
	}else{
		require_once 'pages/'. $_GET['menu'] . '.php'; 
	}
else require_once 'pages/konten.php'; 
	
?>

<?php
include('partials/footer.php');
?>