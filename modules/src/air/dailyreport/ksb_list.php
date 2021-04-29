<?php

//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$JENIS_LAPORAN=$input['JENIS_LAPORAN'];
$JENIS_ENERGI=$input['JENIS_ENERGI'];
###START MODULE
//--pagging start top--/
$halaman=$params['halaman'];
$batas = $params['batas'];
$posisi = $this->PAGING->cariPosisi($batas,$halaman);
//-- >>
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select COMPANY_UNIT_ID from PERSONAL  where PERSONAL_NIK='".$user_login['PERSONAL_NIK']."' 
AND RECORD_STATUS='A'";
//$COMPANY_UNIT_ID=$this->MYSQL->data()[0]['COMPANY_UNIT_ID'];
$COMPANY_UNIT_ID=$input['COMPANY_UNIT_ID'];
	//$this->callback['respon']['pesan']="gagal";
	//$this->callback['respon']['text_msg']="Data tidak ada, silahkan pilih tanggal".print_r($input,true);
	//return;
//filter
if($JENIS_LAPORAN=="Harian")
	{
		$tanggalAwal=$input['DATA_sDATE'];
		$tanggalAwals=Date('Y-m-d',strtotime($tanggalAwal));

		if($JENIS_ENERGI=="Solar")
		{
			$queri="SELECT *,
					round(reading) as nreading,
					round(kwh) as nkwh,
					round(acckwh) as nacckwh,
					round(solar) as nsolar,
					round(accsolar) as naccsolar FROM kwhpakai where substring(tgl,1,10)='".$tanggalAwals."' order by dept asc";
		}else
		{
			$queri="SELECT  *,
			round(reading) as nreading,
			round(kwh) as nkwh,
			round(acckwh) as nacckwh,
			round(solar) as nsolar,
			round(accsolar) as naccsolar FROM kwhbbpakai where substring(tgl,1,10)='".$tanggalAwals."'";
		}
			
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama_proses_isea;
		$this->MYSQL->queri=$queri;
		$result_KSB=$this->MYSQL->data();
		$no=0;

		foreach($result_KSB as $r )
		{
			if($JENIS_ENERGI=="Solar")
			{
				$tqueri="SELECT  
				sum(kwh) as totalkwh,sum(acckwh) as totalacckwh FROM kwhpakai where substring(tgl,1,10)='".$tanggalAwals."'";
			}else{
				$tqueri="SELECT  
				sum(kwh) as totalkwh,sum(acckwh) as totalacckwh FROM kwhbbpakai where substring(tgl,1,10)='".$tanggalAwals."'";
			}				
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama_proses_isea;
			$this->MYSQL->queri=$tqueri;
			$result_tKSB=$this->MYSQL->data()[0];


			$Totalkwh +=$r['kwh'];
			$Totalacckwh +=$r['acckwh'];
			$Totalsolar +=$r['solar'];
			$Totalaccsolar +=$r['accsolar'];
			$r['persenkwh']=((100*$r['kwh'])/$result_tKSB['totalkwh']);
			$r['persenacckwh']=((100*$r['acckwh'])/$result_tKSB['totalacckwh']);
			$Totalpersenkwh +=$r['persenkwh'];
			$Totalpersenacckwh +=$r['persenacckwh'];
			//$r['persenkwh']=(round((100*$r['kwh'])/$result_tKSB['totalkwh']),2);
			$result[]=$r;
			$no++;
		}

		if($JENIS_ENERGI=="Solar")
		{
			$lqueri="SELECT  
			solar FROM kwhsolar where substring(tgl,1,10)='".$tanggalAwals."'";
		}else{
			$lqueri="SELECT  
			solar FROM kwhbb where substring(tgl,1,10)='".$tanggalAwals."'";
		}				
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama_proses_isea;
		$this->MYSQL->queri=$lqueri;
		$result_lKSB=$this->MYSQL->data()[0];
		$kWhKg=round(($Totalkwh/$result_lKSB['solar']),4);
		$KgkWh="";
		$ACCkWhKg=$Totalacckwh/$Totalaccsolar;
		$ACCKgkWh="";


		$total=array('Totalkwh'=>$Totalkwh,
					'Totalacckwh'=>$Totalacckwh,
					'Totalsolar'=>$result_lKSB['solar'],
					'Totalaccsolar'=>$Totalaccsolar,
					'Totalpersenkwh'=>$Totalpersenkwh,
					'Totalpersenacckwh'=>$Totalpersenacckwh,
					'kWhKg'=>$kWhKg,
					'KgkWh'=>$KgkWh,
					'ACCkWhKg'=>$ACCkWhKg,
					'ACCKgkWh'=>$ACCKgkWh,
				);


		if(empty($result)){
			$this->callback['respon']['pesan']="gagal";
			$this->callback['respon']['text_msg']="Data tidak ada";
			$this->callback['filter']=$params;
			$this->callback['result']=$result;
			$this->callback['total']=$total;
			//$this->callback['log']=$log;
		}else{
			$this->callback['respon']['pesan']="sukses";
			$this->callback['respon']['text_msg']="OK..";
			$this->callback['filter']=$params;
			$this->callback['result']=$result;
			$this->callback['total']=$total;
			//$this->callback['log']=$log;
			$this->callback['result_option']['jml_halaman']=$this->pagging(array('sql'=>$sql,'batas'=>$params['batas'],'tabel'=>$tabel,'dimana_default'=>$dimana_default))->jmlhalaman;
		}

	}else if($JENIS_LAPORAN=="Mingguan")
	{
		
		$tanggalAwal=$input['DATA_sDATE'];
			$tanggalAwals=Date('Y-m-d',strtotime($tanggalAwal));
		$tanggalAkhir=$input['DATA_eDATE'];
			$tanggalAkhirs=Date('Y-m-d',strtotime($tanggalAkhir));
	
		$periodeBulanAwal = date("m",strtotime($tanggalAwal));
		$periodeTahunAwal = date("Y",strtotime($tanggalAwal));
		$tanggalTerakhirAwal =date("Y-m-t", strtotime($periodeTahunAwal.'-'.$periodeBulanAwal));
		
		$periodeBulanAkhir = date("m",strtotime($tanggalAkhir));
		$periodeTahunAkhir = date("Y",strtotime($tanggalAkhir));
		$tanggalAwalTerakhir = $periodeTahunAkhir."-".$periodeBulanAkhir."-01";
	
		$queriPeriodeAwal=$periodeBulanAwal.$periodeTahunAwal;
		$queriPeriodeAkhir=$periodeBulanAkhir.$periodeTahunAkhir;

		if($input['PERSONAL_NIK']=="0" or $input['PERSONAL_NIK']=="")
		{
			if($input['LAPORAN_KERJA_UNIT_ID']=="0" or $input['LAPORAN_KERJA_UNIT_ID']=="")
			{
				$queri="select a.PERSONAL_NIK,a.PERSONAL_NAME from LAPORAN_KERJA_UNIT_DETAIL a
				left join  LAPORAN_KERJA_UNIT b on a.LAPORAN_KERJA_UNIT_ID=b.LAPORAN_KERJA_UNIT_ID
				where 
				b.COMPANY_UNIT_ID='".$COMPANY_UNIT_ID."' and 
				b.RECORD_STATUS='A' and 
				a.RECORD_STATUS='A'";
			}else
			{
				$queri="select a.PERSONAL_NIK,a.PERSONAL_NAME from LAPORAN_KERJA_UNIT_DETAIL a
						where 
						a.LAPORAN_KERJA_UNIT_ID='".$input['LAPORAN_KERJA_UNIT_ID']."' and 
						a.RECORD_STATUS='A'";
			}
		}else
		{
			$queri="select a.PERSONAL_NIK,a.PERSONAL_NAME from LAPORAN_KERJA_UNIT_DETAIL a
						where 
						a.PERSONAL_NIK='".$input['PERSONAL_NIK']."' and 
						a.RECORD_STATUS='A'";
		}
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri=$queri;
		$result_PERSONEL=$this->MYSQL->data();
		$no=0;

		foreach($result_PERSONEL as $r )
		{
			$begin = new DateTime($tanggalAwals);
			$end   = new DateTime($tanggalAkhir);
			/*
			for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
			{
				$xy["'".$no."'"][]=$iy->format("Y-m-d");
				$r['TTT'] = $xy["'".$no."'"];
			}
			*/
			for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
			{
				$tglLaporan=$iy->format("Y-m-d");
				$tglLaporans=explode('-',$tglLaporan);
				$iys['TANGGAL']=$tglLaporans[2]."-".$tglLaporans[1]."-".$tglLaporans[0];

				//AMBIL LAPORAN
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select * from LAPORAN_KERJA  where LAPORAN_KERJA_TANGGAL='".$tglLaporan."' AND 
									ENTRI_OPERATOR='".$r['PERSONAL_NIK']."' AND RECORD_STATUS='A'";
				$result_DETAIL["'".$no."'"]=$this->MYSQL->data();
				if(count($result_DETAIL["'".$no."'"])>=1)
				{
					$iys['LAPORAN']=$result_DETAIL["'".$no."'"];
				}else
				{
					$iys['LAPORAN']=array();
				}
				//END LAPORAN
				$xy["'".$no."'"][]=$iys;
				$r['DETAIL'] = $xy["'".$no."'"];
			}
			$result[]=$r;
			$no++;
		}


		if(empty($result)){
			$this->callback['respon']['pesan']="gagal";
			$this->callback['respon']['text_msg']="Data tidak ada".$posisi.$batas;
			$this->callback['filter']=$params;
			$this->callback['result']=$result;
			//$this->callback['log']=$log;
		}else{
			$this->callback['respon']['pesan']="sukses";
			$this->callback['respon']['text_msg']="OK..";
			$this->callback['filter']=$params;
			$this->callback['result']=$result;
			//$this->callback['log']=$log;
			$this->callback['result_option']['jml_halaman']=$this->pagging(array('sql'=>$sql,'batas'=>$params['batas'],'tabel'=>$tabel,'dimana_default'=>$dimana_default))->jmlhalaman;
		}

	}else if($JENIS_LAPORAN=="Bulanan")
	{
		$periodeTahunSekarang=$input['TAHUN_FILTER'];
		$periodeBulanSekarang=$input['BULAN_FILTER'];
		$tanggalAwals=$periodeTahunSekarang."-".$periodeBulanSekarang."-01";
		//$input['TAHUN_FILTER'];//MENAMPILKAN TANGGAL TERAKHIR DARI BULAN BERJALAN
		
		$tanggalterakhir =date("Y-m-t", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
		$tanggalAkhirs=Date('Y-m-d',strtotime($tanggalterakhir));
		$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

		if($input['PERSONAL_NIK']=="0" or $input['PERSONAL_NIK']=="")
		{
			if($input['LAPORAN_KERJA_UNIT_ID']=="0" or $input['LAPORAN_KERJA_UNIT_ID']=="")
			{
				$queri="select a.PERSONAL_NIK,a.PERSONAL_NAME from LAPORAN_KERJA_UNIT_DETAIL a
				left join  LAPORAN_KERJA_UNIT b on a.LAPORAN_KERJA_UNIT_ID=b.LAPORAN_KERJA_UNIT_ID
				where 
				b.COMPANY_UNIT_ID='".$COMPANY_UNIT_ID."' and 
				b.RECORD_STATUS='A' and 
				a.RECORD_STATUS='A'";
			}else
			{
				$queri="select a.PERSONAL_NIK,a.PERSONAL_NAME from LAPORAN_KERJA_UNIT_DETAIL a
						where 
						a.LAPORAN_KERJA_UNIT_ID='".$input['LAPORAN_KERJA_UNIT_ID']."' and 
						a.RECORD_STATUS='A'";
			}
		}else
		{
			$queri="select a.PERSONAL_NIK,a.PERSONAL_NAME from LAPORAN_KERJA_UNIT_DETAIL a
						where 
						a.PERSONAL_NIK='".$input['PERSONAL_NIK']."' and 
						a.RECORD_STATUS='A'";
		}
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri=$queri;
		$result_PERSONEL=$this->MYSQL->data();
		$no=0;

		foreach($result_PERSONEL as $r )
		{
			$begin = new DateTime($tanggalAwals);
			$end   = new DateTime($tanggalAkhirs);
			/*
			for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
			{
				$xy["'".$no."'"][]=$iy->format("Y-m-d");
				$r['TTT'] = $xy["'".$no."'"];
			}
			*/
			for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
			{
				$tglLaporan=$iy->format("Y-m-d");
				$tglLaporans=explode('-',$tglLaporan);
				if(substr($tglLaporans[2],0,1)==0)
				{
					$iys['TANGGAL']=substr($tglLaporans[2],1,1);
				}else{
					$iys['TANGGAL']=$tglLaporans[2];
				}

				//AMBIL LAPORAN
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select * from LAPORAN_KERJA  where LAPORAN_KERJA_TANGGAL='".$tglLaporan."' AND 
									ENTRI_OPERATOR='".$r['PERSONAL_NIK']."' AND RECORD_STATUS='A'";
				$result_DETAIL["'".$no."'"]=$this->MYSQL->data();
				if(count($result_DETAIL["'".$no."'"])>=1)
				{
					$iys['LAPORAN']=$result_DETAIL["'".$no."'"];
				}else
				{
					$iys['LAPORAN']=array();
				}
				//END LAPORAN
				$xy["'".$no."'"][]=$iys;
				$r['DETAIL'] = $xy["'".$no."'"];
			}
			$result[]=$r;
			$no++;
		}


		if(empty($result)){
			$this->callback['respon']['pesan']="gagal";
			$this->callback['respon']['text_msg']="Data tidak ada".$posisi.$batas;
			$this->callback['filter']=$params;
			$this->callback['result']=$result;
			//$this->callback['log']=$log;
		}else{
			$this->callback['respon']['pesan']="sukses";
			$this->callback['respon']['text_msg']="OK..";
			$this->callback['filter']=$params;
			$this->callback['result']=$result;
			//$this->callback['log']=$log;
			$this->callback['result_option']['jml_halaman']=$this->pagging(array('sql'=>$sql,'batas'=>$params['batas'],'tabel'=>$tabel,'dimana_default'=>$dimana_default))->jmlhalaman;
		}
	}else if($JENIS_LAPORAN=="TAHUNAN")
	{

	}else
	{}
?>
