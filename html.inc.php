<?php

switch($d2)
{
	case 'faktur':
		require("html/faktur.php");
	break;
	
	//--------------Handle Error Page-----------------------------------	
	default:
		$callback['pesan']="gagal";
		$callback['text_msg']="Case ajax not found {$ref}";
		echo json_encode($callback);
		exit;
	break;	
}

?>
