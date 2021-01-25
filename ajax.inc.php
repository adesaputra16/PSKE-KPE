<?php
//---AJAX ---//
$ref=anti_injection($_POST['ref']);
switch($ref){
			// Case Catatan
			case 'simpan_catatan':
				require_once("ajax/air/catatan/simpan_catatan.php");
			break;
			case 'tampil_catatan':
				require_once("ajax/air/catatan/tampil_catatan.php");
			break;
			case 'cetak_catatan':
				require_once("ajax/air/catatan/cetak_catatan.php");
			break;
			case 'hapus_catatan':
				require_once("ajax/air/catatan/hapus_catatan.php");
			break;
			case 'list_catatan_departemen':
				require_once("ajax/air/catatan/list_catatan_departemen.php");
			break;
			case 'simpan_flow_dept':
				require_once("ajax/air/catatan/simpan_flow_dept.php");
			break;
			case 'pemakaian_air_dept':
				require_once("ajax/air/catatan/list_pemakaian_air.php");
			break;

			// Case Beban Harian
			case 'list_beban_harian':
				require_once("ajax/air/beban_harian/list_beban_harian.php");
			break;

			// Case Per Dept
			case 'list_per_dept':
				require_once("ajax/air/per_dept/list_per_dept.php");
			break;
			case 'list_rumus_per_dept':
				require_once("ajax/air/per_dept/list_rumus_per_dept.php");
			break;
			case 'simpan_rumus_per_dept':
				require_once("ajax/air/per_dept/simpan_rumus_per_dept.php");
			break;
			case 'tampil_angka_pakai_rumus_per_dept':
				require_once("ajax/air/per_dept/tampil_angka_pakai_rumus_per_dept.php");
			break;
			case 'simpan_angka_flowmeter_kalibrasi':
				require_once("ajax/air/per_dept/simpan_angka_flowmeter_kalibrasi.php");
			break;
			case 'list_angka_flowmeter_kalibrasi':
				require_once("ajax/air/per_dept/list_angka_flowmeter_kalibrasi.php");
			break;
			case 'hapus_angka_flowmeter_kalibrasi':
				require_once("ajax/air/per_dept/hapus_angka_flowmeter_kalibrasi.php");
			break;

			// Case Flowmeter
			case 'simpan_flowmeter':
				require_once("ajax/flowmeter/simpan_flowmeter.php");
			break;
			case 'tampil_flowmeter':
				require_once("ajax/flowmeter/tampil_flowmeter.php");
			break;
			case 'hapus_flowmeter':
				require_once("ajax/flowmeter/hapus_flowmeter.php");
			break;
			case 'ambil_daftar_flowmeter':
				require_once("ajax/flowmeter/ambil_daftar_flowmeter.php");
			break;
			case 'simpan_flowmeter_departemen':
				require_once("ajax/flowmeter/simpan_flowmeter_departemen.php");
			break;
			case 'list_flowmeter_departemen':
				require_once("ajax/flowmeter/list_flowmeter_departemen.php");
			break;
			case 'hapus_flowmeter_departemen':
				require_once("ajax/flowmeter/hapus_flowmeter_departemen.php");
			break;

			//Case Sub Flowmeter
			case 'simpan_sub_flowmeter':
				require_once("ajax/sub_flowmeter/simpan_sub_flowmeter.php");
			break;
			case 'tampil_sub_flowmeter':
				require_once("ajax/sub_flowmeter/tampil_sub_flowmeter.php");
			break;
			case 'hapus_sub_flowmeter':
				require_once("ajax/sub_flowmeter/hapus_sub_flowmeter.php");
			break;
			case 'ambil_sub_flowmeter':
				require_once("ajax/sub_flowmeter/ambil_sub_flowmeter.php");
			break;

			//KWH SOLAH BATUBARA
			case 'ksb_list':
				require_once("ajax/dailyreport/ksb_list.php");
			break;
			

}
?>
