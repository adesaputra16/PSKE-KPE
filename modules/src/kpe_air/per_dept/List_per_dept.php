<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$halaman = $params['halaman'];
$batas = $params['batas'];
$posisi = $this->PAGING->cariPosisi($batas, $halaman);
$input = $params['input_option'];

$sql_a = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA,F.KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER AS F
          WHERE F.RECORD_STATUS='A' ORDER BY F.KPE_AIR_FLOWMETER_NAMA";
// $sql_a = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA,FD.KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER AS F 
//           INNER JOIN KPE_AIR_FLOWMETER_DEPARTEMEN AS FD ON F.KPE_AIR_FLOWMETER_ID=FD.KPE_AIR_FLOWMETER_ID
//           WHERE F.RECORD_STATUS='A' AND FD.RECORD_STATUS='A' ORDER BY F.KPE_AIR_FLOWMETER_NAMA";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a. " LIMIT " . $posisi . "," . $batas;
$result_ab = $this->MYSQL->data();

$no = $posisi + 1;

if($input['TAHUN_FILTER']==""){
  $periodeTahunSekarang=Date("Y");
}else{
  $periodeTahunSekarang=$input['TAHUN_FILTER'];
}
if($input['BULAN_FILTER']==""){
  $periodeBulanSekarang=Date("m");
}else{
  $periodeBulanSekarang=$input['BULAN_FILTER'];
}

$tanggalAwals=$periodeTahunSekarang."-".$periodeBulanSekarang."-01";
$tanggalbulankemaren = Date('Y-m-d',strtotime($tanggalAwals.'-1 day'));

$tanggalterakhir = date("Y-m-t", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
$tanggalAkhirs= Date('Y-m-d',strtotime($tanggalterakhir));
$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

$begin = new DateTime($tanggalbulankemaren);
$end   = new DateTime($tanggalAkhirs);
$no=0;
for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
{


  $tglLaporan=$iy->format("Y-m-j");
  $tglLaporans=explode('-',$tglLaporan);
  $iys['TANGGAL']=$tglLaporans[2];

  $this->MYSQL = new MYSQL();
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = $sql_a. " LIMIT " . $posisi . "," . $batas;
  $result_a["'".$no."'"] = $this->MYSQL->data();
  foreach($result_a["'".$no."'"] as $row_flow)
  {
      $this->MYSQL=new MYSQL();
      $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->queri = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_ID,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN,c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,
                            c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL,c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI,
                            c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN,a.KPE_AIR_FLOWMETER_NAMA,
                            a.KPE_AIR_FLOWMETER_CATATAN_ANGKA,a.KPE_AIR_FLOWMETER_CATATAN_PAKAI,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN,a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL,a.ENTRI_WAKTU
                            FROM KPE_AIR_FLOWMETER AS b 
                            LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID 
                            LEFT JOIN KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN AS c ON a.KPE_AIR_FLOWMETER_ID=c.KPE_AIR_FLOWMETER_ID
                            WHERE b.KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."' AND  
                            a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporan."'
                            AND b.RECORD_STATUS='A' AND  a.RECORD_STATUS='A' ORDER BY a.KPE_AIR_FLOWMETER_NAMA";
      $result_ANGKA["'".$no."'"]=$this->MYSQL->data()[0]; 

      if(count($result_ANGKA["'".$no."'"])>=1)
      {
       $row_flow['ANGKA']=$result_ANGKA["'".$no."'"];
      } else {
        $row_flow['ANGKA']=array();
      }

      $this->MYSQL=new MYSQL();
      $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->queri = "SELECT KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI,
                            KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL
                            FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN WHERE KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."'
                            AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$tglLaporan."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA";
      $result_DEPARTEMEN=$this->MYSQL->data(); 

      if(count($result_DEPARTEMEN)>=1)
      {
       $row_flow['DEPARTEMEN']=$result_DEPARTEMEN;

      } else {
        $row_flow['DEPARTEMEN']="";
      }

      $this->MYSQL=new MYSQL();
      $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->queri = "SELECT *
                              FROM KPE_AIR_FLOWMETER_KALIBRASI
                              WHERE KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL DESC LIMIT 1";
      $result_TOTAL["'".$no."'"]=$this->MYSQL->data()[0]; 

      if(count($result_TOTAL["'".$no."'"])>=1)
      {
        $row_flow['KAL']=$result_TOTAL["'".$no."'"];
      }else
      {
        $row_flow['KAL']=array();
      }
    $xy["'".$no."'"][]=$row_flow;
    $iys['FLOW'] = $xy["'".$no."'"];
			
    }
  $result_FLOWMETER[]=$iys;
  $no++;
}


// for ($k=0; $k < count($result_FLOWMETER); $k++) {
  
  for ($i=0; $i < count($result_FLOWMETER[0]['FLOW']); $i++) {

    for ($j=0; $j <= $tanggalterakhirnya; $j++) {
      
      $this->MYSQL=new MYSQL();
      $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      $tdept = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN) AS TOTAL,(SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN)/".count($result_FLOWMETER).") AS AVRG,
      (SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN)/".count($result_FLOWMETER)."*1000/200) AS DRUM,(SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN)*1000) AS LITER,
      (SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN)/200) AS DRUM2
      FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN WHERE KPE_AIR_FLOWMETER_ID='".$result_FLOWMETER[$j]['FLOW'][$i]['KPE_AIR_FLOWMETER_ID']."'
      AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL>='".$periodeTahunSekarang."-".$periodeBulanSekarang."-01' AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL<='".$periodeTahunSekarang."-".$periodeBulanSekarang."-31' AND RECORD_STATUS='A' GROUP BY KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA ORDER BY KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA";
      $this->MYSQL->queri = $tdept;
      $result_TOTAL_DEPT=$this->MYSQL->data();

      if(count($result_TOTAL_DEPT)>=1)
      {
        $TOTAL_DEPT=$result_TOTAL_DEPT;
      }else
      {
        $TOTAL_DEPT=array();
      }
      

      if ($j==0) {
        $pakai[$j] = 0;
        $beban[$j] = 0;
        $angka[$j] = 0;
      } else {
        $pakai[$j] = $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_PAKAI'];
        $beban[$j] = $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_BEBAN'];
        $angka[$j] = $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_ANGKA'];
      }
    }

    $SUM_CATATAN[$i] = array_sum($angka);
    $SUM_PAKAI[$i] = array_sum($pakai);
    $SUM_BEBAN[$i] = array_sum($beban);
    $AVRG[$i] = number_format(array_sum($pakai)/(count($result_FLOWMETER)-1),2);
    $DRUM[$i] = number_format($AVRG[$i]*1000/200,2);
    $liter_belum_format[$i] = $SUM_PAKAI[$i]*1000;
    $LITER[$i] = number_format($SUM_PAKAI[$i]*1000,0);
    $DRUM2[$i] = number_format($liter_belum_format[$i]/200,0);
    $T_DEPT[$i] = $TOTAL_DEPT;
  }

if (empty($result_FLOWMETER))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result_FLOWMETER;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Data Ada ".print_r($result_FLOWMETER,true);
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result_FLOWMETER;
    // $this->callback['HASIL_PAKAI'] = $hasil_pakai;
    // $this->callback['TOTAL'] = $TOTAL;
    $this->callback['CATATAN'] = $SUM_CATATAN;
    $this->callback['AVERAGE'] = $AVRG;
    $this->callback['DRUM'] = $DRUM;
    $this->callback['LITER'] = $LITER;
    $this->callback['DRUM2'] = $DRUM2;
    $this->callback['PAKAI'] = $SUM_PAKAI;
    $this->callback['BEBAN'] = $SUM_BEBAN;
    $this->callback['TOTAL_DEPT'] = $T_DEPT;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
