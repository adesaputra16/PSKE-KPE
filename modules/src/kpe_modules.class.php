<?php
/**
 * Cara melakukan bypass privileges modul gunakan kata 'open' pada case modul
 * Misal : open_data_443
 *
 *
 */
CLASS KPE_MODULES extends USER_PRIVILEGES
	{
	public function __construct()
		{
		$this->CONFIG = new CONFIG();
		//$this->KPE_CONFIG = new KPE_CONFIG();
		$this->PAGING = new Paging();
		$this->MYSQL = new MYSQL();
		$this->SISTEM = new SISTEM();
		}

	// ######################################################
	// Model penulisan  code develop versi  Oktober 2016

	private	function control($params)
		{
		$result = $this->user_login($params['data_http']);
		if (empty($result['USER_NAME']) and (!in_array('nonlogin', explode('_', $params['case']))))
			{
			$this->text_msg = "Pengguna tidak dikenal";
			$this->pesan = "gagal";
			return $this;
			exit();
			}

		// --PRIVILEGES CEK---//

		$user_privileges = $this->user_privileges($params['data_http'], strtolower(get_class($this)) , $params['case']);
		if ($user_privileges['pesan'] == "gagal")
			{
			$this->text_msg = $user_privileges['text_msg'];
			$this->pesan = $user_privileges['pesan'];
			$this->queries = $user_privileges['queries'];
			$this->queries['modul'] = $user_privileges['queries']['modul'];
			}
		  else
			{
			$this->text_msg = "OK";
			$this->pesan = "sukses";
			}

		return $this;
		exit;

		// --END PRIVILEGES CEK---//

		}
		private function pagging($params){
			//--PAGGING BOTTON-->
			if(empty($params['sql']))
			{
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel=$params['tabel'];
				$this->MYSQL->kolom="count(RECORD_STATUS) as JUMLAH";
				$this->MYSQL->dimana=$params['dimana_default'];
				$result=$this->MYSQL->data()[0];
				$this->jmlhalaman = $this->PAGING->jumlahHalaman($result['JUMLAH'], $params['batas']);
			}else
			{
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri=$params['sql'];
				$result=$this->MYSQL->data();
				$this->jmlhalaman = $this->PAGING->jumlahHalaman(count($result), $params['batas']);
			}
			return $this;
		}//end pagging

		private function auto_increatement_number($params){
 	 	$n=new auto_nomor();
 	 	$n->no_aktif=$params['aktif'];
 	 	$n->panjang=4;
 	 	$no=$n->nomor_urut();
 	 	return $no;
 	 }

		private function buat_nomor_faktur($params){

			$jenis_barang=$params['ICD_BARANG_JENIS'];
			$tanggal=Date('mY');
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select _FAKTUR_NO_FAKTUR from RMP_FAKTUR where (RMP_FAKTUR_NO_FAKTUR like'%".$tahunWo."%' and RMP_FAKTUR_NO_FAKTUR like'%KB%') and RECORD_STATUS='A' order by RMP_FAKTUR_NO_FAKTUR desc";
				$cek_nomor=$this->MYSQL->data();
				if(empty($cek_nomor))
				{
					$nomor='0001/KB/'.$tanggal;
				}else
				{
					//CEK NOMOR TERAKHIR DI TAHUN YANG SAMA
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select RMP_FAKTUR_NO_FAKTUR from RMP_FAKTUR where (RMP_FAKTUR_NO_FAKTUR like'%".$tanggal."%' and RMP_FAKTUR_NO_FAKTUR like'%KB%') and RECORD_STATUS='A' order by RMP_FAKTUR_NO_FAKTUR desc LIMIT 1";
					$cek_nomor2=$this->MYSQL->data();
					$nomorBaru=explode("/",$cek_nomor2[0]['RMP_FAKTUR_NO_FAKTUR']);
					$nomorBaruNya=($nomorBaru[0])+1;
					$nomor=$this->auto_increatement_number(array('aktif'=>$nomorBaruNya)).'/KB/'.$tanggal;
				}
			/*
			}
			*/
			$this->callback['nomor']=$nomor;
			return $this;
		}//end presensi_proposal_nomor_create()

	// nomor urut pkp

	private	function module($params)
		{

		$user_login = $this->SISTEM->user(array(
			'data_http' => $params['data_http']
		))->login_info;
		$input = $params['input_option'];

		switch (strtolower($params['case']))
			{
				// Case Catatan
		case 'nonlogin_simpan_catatan':
			require_once ("kpe_air/catatan/Simpan_catatan.php");
		break;
		case 'nonlogin_tampil_catatan':
			require_once ("kpe_air/catatan/Tampil_catatan.php");
		break;
		case 'nonlogin_ubah_catatan':
			require_once ("kpe_air/catatan/Ubah_catatan.php");
		break;
		case 'nonlogin_hapus_catatan':
			require_once ("kpe_air/catatan/Hapus_catatan.php");
		break;
		case 'nonlogin_list_catatan_departemen':
			require_once ("kpe_air/catatan/List_catatan_departemen.php");
		break;
		case 'nonlogin_list_catatan_sebelumnya':
			require_once ("kpe_air/catatan/List_catatan_sebelumnya.php");
		break;
		case 'nonlogin_cetak_catatan':
			require_once ("kpe_air/catatan/Cetak_catatan.php");
		break;
		// Case Beban Harian
		case 'nonlogin_list_beban_harian':
			require_once ("kpe_air/beban_harian/List_beban_harian.php");
		break;
		// Case Per Dept
		case 'nonlogin_list_per_dept':
			require_once ("kpe_air/per_dept/List_per_dept.php");
		break;
		case 'nonlogin_list_rumus_per_dept':
			require_once ("kpe_air/per_dept/List_rumus_per_dept.php");
		break;
		case 'nonlogin_simpan_rumus_per_dept':
			require_once ("kpe_air/per_dept/Simpan_rumus_per_dept.php");
		break;
		case 'nonlogin_tampil_angka_pakai_rumus_per_dept':
			require_once ("kpe_air/per_dept/Tampil_angka_pakai_rumus_per_dept.php");
		break;
		// Case Flowmeter
		case 'nonlogin_simpan_flowmeter':
			require_once ("kpe_flowmeter/Simpan_flowmeter.php");
		break;
		case 'nonlogin_tampil_flowmeter':
			require_once ("kpe_flowmeter/Tampil_flowmeter.php");
		break;
		case 'nonlogin_ubah_flowmeter':
			require_once ("kpe_flowmeter/Ubah_flowmeter.php");
		break;
		case 'nonlogin_hapus_flowmeter':
			require_once ("kpe_flowmeter/Hapus_flowmeter.php");
		break;
		case 'nonlogin_ambil_daftar_flowmeter':
			require_once ("kpe_flowmeter/Ambil_daftar_flowmeter.php");
		break;
		case 'nonlogin_cari_air':
			require_once ("kpe_flowmeter/Cari_air.php");
		break;
		// Case Sub Flowmeter
		case 'nonlogin_simpan_sub_flowmeter':
			require_once ("kpe_sub_flowmeter/Simpan_sub_flowmeter.php");
		break;
		case 'nonlogin_tampil_sub_flowmeter':
			require_once ("kpe_sub_flowmeter/Tampil_sub_flowmeter.php");
		break;
		case 'nonlogin_hapus_sub_flowmeter':
			require_once ("kpe_sub_flowmeter/Hapus_sub_flowmeter.php");
		break;
		case 'nonlogin_ambil_sub_flowmeter':
			require_once ("kpe_sub_flowmeter/Ambil_sub_flowmeter.php");
		break;
		//Case Konfigurasi
		case 'nonlogin_simpan_flowmeter_departemen':
			require_once ("konfigurasi/Simpan_flowmeter_departemen.php");
		break;
		case 'nonlogin_list_flowmeter_departemen':
			require_once ("konfigurasi/List_flowmeter_departemen.php");
		break;
		case 'nonlogin_hapus_flowmeter_departemen':
			require_once ("konfigurasi/Hapus_flowmeter_departemen.php");
		break;
		case 'nonlogin_list_personil_departemen':
			require_once ("konfigurasi/List_personil_departemen.php");
		break;
		case 'nonlogin_list_departemen':
			require_once ("konfigurasi/List_departemen.php");
		break;
		case 'nonlogin_simpan_flow_dept':
			require_once ("konfigurasi/Simpan_flow_dept.php");
		break;
		case 'nonlogin_simpan_angka_flowmeter_kalibrasi':
			require_once ("konfigurasi/Simpan_angka_flowmeter_kalibrasi.php");
		break;
		case 'nonlogin_list_angka_flowmeter_kalibrasi':
			require_once ("konfigurasi/List_angka_flowmeter_kalibrasi.php");
		break;
		case 'nonlogin_hapus_angka_flowmeter_kalibrasi':
			require_once ("konfigurasi/Hapus_angka_flowmeter_kalibrasi.php");
		break;

		//DAILY REPORT 
		case 'nonlogin_ksb_list':
			require_once ("dailyreport/ksb_list.php");
		break;
				
			// ---------------------end case-----------------------------//

		default:
			$this->callback['respon']['pesan'] = "gagal";
			$this->callback['respon']['text_msg'] = "Case tidak ditemukan ";
			$this->callback['respon']['help'] = "Sistem tidak menemukan case " . $params['case'];
			break;
			}
		return $this;
		}
	public function load($params)
		{
		if ($this->control($params)->pesan == 'sukses')
			{

			$result = $this->module($params)->callback;
			}
		  else
			{

			$result['respon']['pesan'] = $this->control($params)->pesan;
			$result['respon']['text_msg'] = $this->control($params)->text_msg;
			}

		return $result;
		}

		public function show()
			{
				$cf=$GLOBALS['cf'];

				//--extraxt cr_data--//
				$cr_data=json_decode($this->post_cr_data,true);

				//--data opsional--//
				$case=$cr_data['case'];
				$batas=$cr_data['batas'];
				$halaman=$cr_data['halaman'];
				$data_array=$cr_data['data'];

				//--data kontroler untuk halaman--//
				if(empty($halaman) OR $halaman=="undefined"){ $halaman=1; }else{ $halaman=$halaman; }

				//--PRIVILEGES CEK---//
				$user_privileges=$this->user_privileges($cr_data['user_privileges_data'],strtolower(get_class($this)),$case);
				if($user_privileges['pesan']=="gagal")
				{
					$callback['text_msg']=$user_privileges['text_msg'];
					$callback['pesan']=$user_privileges['pesan'];
					$callback['queries']=$user_privileges['queries'];
					$callback['queries']['modul']=$user_privileges['queries']['modul'];
					return $callback;
					exit();
				}
				//--END PRIVILEGES CEK---//


				//info user login
				$user_login=$this->user_login($cr_data['user_privileges_data']);


				//--CASE MODUL--//
				switch($case){
					case 'nonlogin_data_443_detail' :

						//--setting--//
						$tabel="RMP_MASTER_PERSONAL";
						$dimana_default="WHERE RMP_MASTER_PERSONAL_ID='".$data_array['ID_SUPPLIER']."' AND RECORD_STATUS='A'";

						$db=new db();
						$db->database=$cf['db_nama'];
						$db->tabel=$tabel;
						$db->kolom="*";
						$db->dimana=$dimana_default;
						//$db->batas="LIMIT $posisi,$batas";
						//$db->urut="ORDER BY a.JUMLAH_SUARA_SAH DESC";
						$refs=$db->data();
						$no=$posisi+1;
						foreach($refs as $r){

						$r['NO']=$no;
						$refsee[]=$r;
						$no++;
						}//--end foreach


						if(empty($refs)){
							$pesan="gagal";
							$text_msg="Data Tidak ada";
						}else{
							$pesan="sukses";
							$text_msg="Load..";
						}

				break;
					case 'nonlogin_detail_faktur_cabang' :

						//--setting--//
						$tabel="RMP_REKAP_FC";
						$dimana_default="WHERE RMP_REKAP_FC_ID='".$data_array['ID_FAKTUR_CABANG']."' AND RECORD_STATUS='A'";

						$db=new db();
						$db->database=$cf['db_nama'];
						$db->tabel=$tabel;
						$db->kolom="*";
						$db->dimana=$dimana_default;
						//$db->batas="LIMIT $posisi,$batas";
						//$db->urut="ORDER BY a.JUMLAH_SUARA_SAH DESC";
						$refs=$db->data();
						$no=$posisi+1;
						foreach($refs as $r){

						$r['NO']=$no;
						$refsee[]=$r;
						$no++;
						}//--end foreach


						if(empty($refs)){
							$pesan="gagal";
							$text_msg="Data Tidak ada";
						}else{
							$pesan="sukses";
							$text_msg="Load..";
						}

				break;
				}
						//---JSON DATA----//
				$callback['text_msg']=$text_msg;
				$callback['pesan']=$pesan;
				$callback['header_location']=$header_location;
				$callback['queries']=$cr_data;
				$callback['refs']=$refsee;
				$callback['user_privileges']=$user_privileges;
				$callback['user_login']=$user_login;
				$callback['jml_halaman']=$jmlhalaman;

				return $callback; //--output
			}

	}

?>

