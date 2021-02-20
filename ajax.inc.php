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
			case 'pemakaian_air_dept':
				require_once("ajax/air/catatan/list_pemakaian_air.php");
			break;
			case 'list_catatan_sebelumnya':
				require_once("ajax/air/catatan/list_catatan_sebelumnya.php");
			break;

			// Case Beban Harian
			case 'list_beban_harian':
				require_once("ajax/air/beban_harian/list_beban_harian.php");
			break;
			case 'list_beban_harian_dept':
				require_once("ajax/air/beban_harian/list_beban_harian_dept.php");
			break;
			case 'simpan_beban_pre':
				require_once("ajax/air/beban_harian/simpan_beban_pre.php");
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

			//Case Konfigurasi
			case 'list_catatan_departemen':
				require_once("ajax/konfigurasi/list_catatan_departemen.php");
			break;
			case 'simpan_flow_dept':
				require_once("ajax/konfigurasi/simpan_flow_dept.php");
			break;
			case 'simpan_flowmeter_departemen':
				require_once("ajax/konfigurasi/simpan_flowmeter_departemen.php");
			break;
			case 'list_flowmeter_departemen':
				require_once("ajax/konfigurasi/list_flowmeter_departemen.php");
			break;
			case 'hapus_flowmeter_departemen':
				require_once("ajax/konfigurasi/hapus_flowmeter_departemen.php");
			break;
			case 'list_personil_departemen':
				require_once("ajax/konfigurasi/list_personil_departemen.php");
			break;
			case 'list_departemen':
				require_once("ajax/konfigurasi/list_departemen.php");
			break;
			case 'simpan_angka_flowmeter_kalibrasi':
				require_once("ajax/konfigurasi/simpan_angka_flowmeter_kalibrasi.php");
			break;
			case 'list_angka_flowmeter_kalibrasi':
				require_once("ajax/konfigurasi/list_angka_flowmeter_kalibrasi.php");
			break;
			case 'hapus_angka_flowmeter_kalibrasi':
				require_once("ajax/konfigurasi/hapus_angka_flowmeter_kalibrasi.php");
			break;

			// Operasional PRE
			case 'simpan_operasional_pre':
				require_once("ajax/operasional_pre/simpan_operasional_pre.php");
			break;
			case 'list_operasional_pre':
				require_once("ajax/operasional_pre/list_operasional_pre.php");
			break;
			case 'hapus_operasional_pre':
				require_once("ajax/operasional_pre/hapus_operasional_pre.php");
			break;

			// Rekap Used PRE
			case 'simpan_rekap_used_pre':
				require_once("ajax/rekap_used_pre/simpan_rekap_used_pre.php");
			break;
			case 'list_rekap_used_pre':
				require_once("ajax/rekap_used_pre/list_rekap_used_pre.php");
			break;

			// Rekap Used RO
			case 'simpan_rekap_used_ro':
				require_once("ajax/rekap_used_ro/simpan_rekap_used_ro.php");
			break;
			case 'hapus_rekap_used_ro':
				require_once("ajax/rekap_used_ro/hapus_rekap_used_ro.php");
			break;

			//KWH SOLAR BATUBARA
			case 'ksb_list':
				require_once("ajax/dailyreport/ksb_list.php");
			break;
			case 'list_dly_report_pre':
				require_once("ajax/dailyreport/list_dly_report_pre.php");
			break;
			

}
?>
