<?php
/**
 * Cara melakukan bypass privileges modul gunakan kata 'open' pada case modul
 * Misal : open_data_443
 *
 *
 */
CLASS KPE_KWH extends USER_PRIVILEGES
	{
	public function __construct()
		{
		$this->CONFIG = new CONFIG();
		// $this->KPE_CONFIG = new KPE_CONFIG();
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
				
		//! CASE FLOWMETER
		case 'nonlogin_simpan_flowmeter':
			require_once ("kwh/flowmeter/flowmeter/Simpan_flowmeter.php");
		break;
		case 'nonlogin_list_kwh_flowmeter':
			require_once ("kwh/flowmeter/flowmeter/List_kwh_flowmeter.php");
		break;
		case 'nonlogin_hapus_kwh_flowmeter':
			require_once ("kwh/flowmeter/flowmeter/Hapus_kwh_flowmeter.php");
		break;
		case 'nonlogin_ambil_kwh_flowmeter':
			require_once ("kwh/flowmeter/flowmeter/Ambil_kwh_flowmeter.php");
		break;

		//! CASE CATATAN
		case 'nonlogin_simpan_catatan':
			require_once ("kwh/catatan/catatan/Simpan_catatan.php");
		break;
		case 'nonlogin_list_catatan_sebelumnya':
			require_once ("kwh/catatan/catatan/List_catatan_sebelumnya.php");
		break;
		case 'nonlogin_list_catatan':
			require_once ("kwh/catatan/catatan/List_catatan.php");
		break;
		case 'nonlogin_hapus_catatan':
			require_once ("kwh/catatan/catatan/Hapus_catatan.php");
		break;

		//! CASE HARIAN
		case 'nonlogin_list_harian':
			require_once ("kwh/harian/List_harian.php");
		break;
		case 'nonlogin_simpan_harian':
			require_once ("kwh/harian/Simpan_harian.php");
		break;
		case 'nonlogin_list_distribusi':
			require_once ("kwh/harian/List_distribusi.php");
		break;
		case 'nonlogin_hapus_distribusi':
			require_once ("kwh/harian/Hapus_distribusi.php");
		break;
		case 'nonlogin_contoh':
			require_once ("kwh/harian/contoh.php");
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

