<?php	
$adminLTE->footer(
	array(
		'aplikasi_user_aktif'=>$aplikasi_user_aktif,
	)
);
$adminLTE->footer_asset($params);
?>
<script src="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/js/scripts.js"></script>
</body>
</html>
