<?php
//---AJAX ---//
switch($d2){
	case 'cetak_pemakaian_air':
		require("pdf/cetak_pemakaian_air.php");
		break;
	case 'cetak_flowmeter':
		require("pdf/cetak_flowmeter.php");
		break;
	//--------------Handle Error Page-----------------------------------
	default:
		$callback['pesan']="gagal";
		$callback['text_msg']="Case ajax not found {$ref}";
		echo json_encode($callback);
		exit;
	break;
}//---end switch
?>
