<?php
//get headerbar LTE
require_once(PLATFORM_ROOT.'asset/plugins/AdminLTE-2.4.3/class/adminLTE.php');
$adminLTE=new adminLTE();
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.css">
<?php	
$adminLTE->header_asset($params);
?>
<body class="skin-blue sidebar-mini adminLTE pace-done sidebar-collapse" style="height: auto; min-height: 100%;">
<div class="wrapper">
<?php	
$adminLTE->headerbar(
	array(
		'user_login'=>$cf['user_login'],
	)
);
//echo "<pre>".print_r($cf['user_login'],true)."</pre>";
?>
