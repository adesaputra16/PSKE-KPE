<?php

CLASS RMP_CONFIG extends CONFIG
{
	public function __construct()
	{
		$this->CONFIG = new CONFIG();
		$this->MYSQL=new MYSQL();
		$this->SISTEM=new SISTEM();
	}
	public function user(){
		$this->jenis_kontak=array(
				'Handphone'=>"Handphone",
				'Telp/Fax'=>"Telp/Fax",
				'Email'=>"Email",
		);
		$this->status_keluarga=array(
				'AYAH'=>"AYAH",
				'IBU'=>"IBU",
				'ANAK'=>"ANAK",
				'SUAMI'=>"SUAMI",
				'ISTRI'=>"ISTRI",
		);
		$this->jenis_dokumen=array(
				'KTP'=>"KTP",
				'NPWP'=>"NPWP",
				'KARTU KELUARGA'=>"KARTU KELUARGA",
				'SIM'=>"SIM",
		);
		$this->status_berlaku=array(
				'AKTIF'=>"AKTIF",
				'TIDAK AKTIF'=>"TIDAK AKTIF",
		);
		$this->jenis_supplier=array(
				'PETANI'=>"PETANI",
				'PENGEPUL'=>"PENGEPUL",
		);

		return $this;
	}//end sistem
	public function sel_ps_cabang(){
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from RMP_MASTER_PERSONAL WHERE RMP_MASTER_PERSONAL_NAMA LIKE '%PS%' AND RECORD_STATUS='A'";
		$hasil=$this->MYSQL->data();
		foreach($hasil as $r){

		}
		$callback['rasult']=array(
			$hasil,

		);
	return $callback;
	}

	public function provinsi(){
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from INDONESIA_PROVINSI";
		$hasil=$this->MYSQL->data();
		foreach($hasil as $r){

		}
		$callback['rasult']=array(
			$hasil,

		);
	return $callback;
	}

	public function kabupaten($params){
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri="select * from INDONESIA_KABUPATEN where INDONESIA_PROVINSI_ID=".$params." ";
			$hasil=$this->MYSQL->data();
			foreach($hasil as $r){

			}
			$callback['rasult']=array(
				$hasil,

			);
		return $callback;
		}

		public function kecamatan($params){
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select * from INDONESIA_KECAMATAN where INDONESIA_KABUPATEN_ID=".$params." ";
				$hasil=$this->MYSQL->data();
				foreach($hasil as $r){

				}
				$callback['rasult']=array(
					$hasil,

				);
			return $callback;
			}
		public function desa($params){
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select * from INDONESIA_DESA where INDONESIA_KECAMATAN_ID=".$params." ";
				$hasil=$this->MYSQL->data();
				foreach($hasil as $r){

				}
				$callback['rasult']=array(
					$hasil,

				);
			return $callback;
			}

		public function relasi_master($params){
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="SELECT * FROM RMP_RELASI_CABANG WHERE RMP_MASTER_PERSONAL_ID='".$params."' AND RECORD_STATUS='A' ";
				$hasil=$this->MYSQL->data();
				foreach($hasil as $r){

				}
				$callback['rasult']=array(
					$hasil,

				);
			return $callback;
			}
		public function wilayah($params){
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select * from RMP_MASTER_WILAYAH WHERE RECORD_STATUS='A' AND RMP_MASTER_WILAYAH_PREV_LINK=''";
				$hasil=$this->MYSQL->data();
				foreach($hasil as $r){

				}
				$callback['rasult']=array(
					$hasil,

				);
			return $callback;
			}
		public function sub_wilayah_filter(){
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select * from RMP_MASTER_WILAYAH WHERE RECORD_STATUS='A' AND NOT RMP_MASTER_WILAYAH_PREV_LINK=''";
				$hasil=$this->MYSQL->data();
				foreach($hasil as $r){

				}
				$callback['rasult']=array(
					$hasil,

				);
			return $callback;
			}

			public function sub_wilayah_id($params){
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select * from RMP_MASTER_WILAYAH where RMP_MASTER_WILAYAH_PREV_LINK=".$params." ";
					$hasil=$this->MYSQL->data();
					foreach($hasil as $r){

					}
					$callback['rasult']=array(
						$hasil,

					);
				return $callback;
				}



	public function bank(){
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="SELECT * FROM MASTER_BANK ORDER BY MASTER_BANK_ORDER DESC";
		$hasil=$this->MYSQL->data();
		foreach($hasil as $r){

		}
		$callback['rasult']=array(
			$hasil,

		);
	return $callback;
	}
	public function material(){
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from RMP_MASTER_MATERIAL";
		$hasil=$this->MYSQL->data();
		foreach($hasil as $r){

		}
		$callback['rasult']=array(
			$hasil,

		);
	return $callback;
	}

	public function supplier_id($kolom="RMP_MASTER_PERSONAL_ID",$panjang=5)
		{
		$cf=$GLOBALS['cf'];
		$db=new db();
		$db->database=$cf['db_nama'];
		$db->kolom="LPAD((RIGHT(MAX(".$kolom."),".$panjang.")+1),".$panjang.",'0') as last_id";
		$db->tabel="RMP_MASTER_PERSONAL";

		$refs=$db->data();
		$last_idX=$refs[0]['last_id'];
		if(empty($refs[0]['last_id'])){
			 $last_id=str_pad(1, $panjang, '0', STR_PAD_LEFT);
		}else{
			$last_id=$last_idX;
		}
		return $last_id;
		}

		public function no_rekening_id($kolom="RMP_REKENING_RELASI_SUPPLIER_ID",$panjang=4)
			{
			$cf=$GLOBALS['cf'];
			$db=new db();
			$db->database=$cf['db_nama'];
			$db->kolom="LPAD((RIGHT(MAX(".$kolom."),".$panjang.")+1),".$panjang.",'0') as last_id";
			$db->tabel="RMP_REKENING_RELASI";

			$refs=$db->data();
			$last_idX=$refs[0]['last_id'];
			if(empty($refs[0]['last_id'])){
				 $last_id=str_pad(1, $panjang, '0', STR_PAD_LEFT);
			}else{
				$last_id=$last_idX;
			}
			return $last_id;
			}

			private function auto_increatement_number($params){
	 	 	$n=new auto_nomor();
	 	 	$n->no_aktif=$params['aktif'];
	 	 	$n->panjang=4;
	 	 	$no=$n->nomor_urut();
	 	 	return $no;
	 	 }

			public function buat_nomor_faktur($jenis_kelapa,$ponton,$tanggalnota){
				if($ponton == 'KP-1')
				{
					$ptn = "A";
				}
				elseif($ponton == 'KP-2')
				{
					$ptn = "B";
				}
				else
				{
					$ptn = "";
				}

				if($jenis_kelapa == "GELONDONG-A")
				{
					$kelapa = "GLA";
				}
				elseif($jenis_kelapa == "GELONDONG-B")
				{
					$kelapa = "GLB";
				}
				elseif($jenis_kelapa == "GELONDONG-C")
				{
					$kelapa = "GLC";
				}
				elseif($jenis_kelapa == "LICIN-A")
				{
					$kelapa = "KBA";
				}
				elseif($jenis_kelapa == "LICIN-B")
				{
					$kelapa = "KBB";
				}
				elseif($jenis_kelapa == "LICIN-C")
				{
					$kelapa = "KBC";
				}
				elseif($jenis_kelapa == "JAMBUL-A")
				{
					$kelapa = "JBA";
				}
				elseif($jenis_kelapa == "JAMBUL-B")
				{
					$kelapa = "JBB";
				}
				elseif($jenis_kelapa == "JAMBUL-C")
				{
					$kelapa = "JBC";
				}
				else
				{
					$kelapa = "";
				}
				$ptn_kelapa =$kelapa;
				$tanggal_bulan = substr($tanggalnota,0,2);
				$tanggal_tahun = substr($tanggalnota,2,4);
				$tanggal=$tanggal_bulan.'/'.$tanggal_tahun;
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select RMP_FAKTUR_NO_FAKTUR from RMP_FAKTUR where (RMP_FAKTUR_NO_FAKTUR like'%".$tanggal."%' and RMP_FAKTUR_NO_FAKTUR like'%".$kelapa."%') and RECORD_STATUS='A' order by RMP_FAKTUR_NO_FAKTUR desc";
					$cek_nomor=$this->MYSQL->data();
					if(empty($cek_nomor))
					{
						$nomor='0001/'.$ptn_kelapa.'/'.$tanggal;
					}
					else
					{
						//CEK NOMOR TERAKHIR DI TAHUN YANG SAMA
						$this->MYSQL=new MYSQL();
						$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
						$this->MYSQL->queri="select RMP_FAKTUR_NO_FAKTUR from RMP_FAKTUR where (RMP_FAKTUR_NO_FAKTUR like'%".$tanggal."%' and RMP_FAKTUR_NO_FAKTUR like'%".$kelapa."%') and RECORD_STATUS='A' order by RMP_FAKTUR_NO_FAKTUR desc LIMIT 1";
						$cek_nomor2=$this->MYSQL->data();
						$nomorBaru=explode("/",$cek_nomor2[0]['RMP_FAKTUR_NO_FAKTUR']);
						$nomorBaruNya=($nomorBaru[0])+1;
						$nomor=$this->auto_increatement_number(array('aktif'=>$nomorBaruNya)).'/'.$ptn_kelapa.'/'.$tanggal;
					}
				/*
				}
				*/
				$this->callback['nomor']=$nomor;
				return $this;
			}//end presensi_proposal_nomor_create()

			public function buat_nomor_faktur_kopra($tanggalnota,$ponton){

				if($ponton == "KP-1")
				{
					$ptn = "A";
				}
				else {
					$ptn = "B";
				}
				$kelapa = "KP";
				$ptn_kelapa =$kelapa;
				$tanggal_bulan = substr($tanggalnota,0,2);
				$tanggal_tahun = substr($tanggalnota,2,4);
				$tanggal=$tanggal_bulan.'/'.$tanggal_tahun;
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select RMP_FAKTUR_NO_FAKTUR from RMP_FAKTUR where (RMP_FAKTUR_NO_FAKTUR like'%".$tanggal."%' and RMP_FAKTUR_NO_FAKTUR like'%".$kelapa."%') and (RECORD_STATUS='A' or RECORD_STATUS='N') order by RMP_FAKTUR_NO_FAKTUR desc";
					$cek_nomor=$this->MYSQL->data();
					if(empty($cek_nomor))
					{
						$nomor='0001/'.$ptn.'-'.$ptn_kelapa.'/'.$tanggal;
					}
					else
					{
						//CEK NOMOR TERAKHIR DI TAHUN YANG SAMA
						$this->MYSQL=new MYSQL();
						$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
						$this->MYSQL->queri="select RMP_FAKTUR_NO_FAKTUR from RMP_FAKTUR where (RMP_FAKTUR_NO_FAKTUR like'%".$tanggal."%' and RMP_FAKTUR_NO_FAKTUR like'%".$kelapa."%') and (RECORD_STATUS='A' or RECORD_STATUS='N') order by RMP_FAKTUR_NO_FAKTUR desc LIMIT 1";
						$cek_nomor2=$this->MYSQL->data();
						$nomorBaru=explode("/",$cek_nomor2[0]['RMP_FAKTUR_NO_FAKTUR']);
						$nomorBaruNya=($nomorBaru[0])+1;
						$nomor=$this->auto_increatement_number(array('aktif'=>$nomorBaruNya)).'/'.$ptn.'-'.$ptn_kelapa.'/'.$tanggal;
					}
				/*
				}
				*/
				$this->callback['nomor']=$nomor;
				return $this;
			}//end presensi_proposal_nomor_create()

			public function pembulatan($bilangan){

				if (strpos($bilangan, ".") == true)
			  {
			    $r = explode(".",$bilangan);
			    $x = substr($r[1],0,1);
			    if ($x <= 5)
			    {
			    $bulat = floor($bilangan);
			    }
			    else
			    {
			    $bulat = ceil($bilangan);
			    }
			    $this->callback['nomor']=$bulat;
					return $this;
			  }
			  else
			  {
					$this->callback['nomor']=$bilangan;
					return $this;
			  }


			}


}

?>
