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

$sql_a = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA FROM KPE_AIR_FLOWMETER AS F
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

$tanggalterakhir =date("Y-m-t", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
$tanggalAkhirs=Date('Y-m-d',strtotime($tanggalterakhir));
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
      $this->MYSQL->queri = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_ID,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,a.KPE_AIR_FLOWMETER_NAMA,a.KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN_RUMUS,
                            a.KPE_AIR_FLOWMETER_CATATAN_ANGKA, a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL,a.ENTRI_WAKTU
                            FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID 
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

      // $this->MYSQL=new MYSQL();
      // $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      // $this->MYSQL->queri = "SELECT KPE_AIR_FLOWMETER_KALIBRASI_ID,KPE_AIR_FLOWMETER_KALIBRASI_PERSEN,KPE_AIR_FLOWMETER_KALIBRASI_REAL,
      //                       KPE_AIR_FLOWMETER_KALIBRASI_SELISIH,KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL,KPE_AIR_FLOWMETER_NAMA
      //                       FROM KPE_AIR_FLOWMETER_KALIBRASI WHERE KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."'
      //                       AND RECORD_STATUS='A'";
      // $result_KALIBRASI=$this->MYSQL->data()[0]; 

      // if(count($result_KALIBRASI)>=1)
      // {
      //  $row_flow['KALIBRASI']=$result_KALIBRASI;
      // } else {
      //   $row_flow['KALIBRASI']=array();
      // }

      $this->MYSQL=new MYSQL();
      $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->queri = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_ANGKA) AS TOTAL_CATATAN, KPE_AIR_FLOWMETER_NAMA
                              FROM KPE_AIR_FLOWMETER_CATATAN
                              WHERE KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."' 
                              AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$periodeTahunSekarang."-".$periodeBulanSekarang."-01' 
                              AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$periodeTahunSekarang."-".$periodeBulanSekarang."-31'
                              AND RECORD_STATUS='A' GROUP BY KPE_AIR_FLOWMETER_ID ORDER BY KPE_AIR_FLOWMETER_NAMA";
      $result_TOTAL["'".$no."'"]=$this->MYSQL->data()[0]; 

      if(count($result_TOTAL["'".$no."'"])>=1)
      {
        $row_flow['TOTAL']=$result_TOTAL["'".$no."'"];
      }else
      {
        $row_flow['TOTAL']=array();
      }
    $xy["'".$no."'"][]=$row_flow;
    $iys['FLOW'] = $xy["'".$no."'"];
			
    }

  $result_FLOWMETER[]=$iys;
  $no++;
}

for ($k=0; $k < count($result_FLOWMETER); $k++) {
  
  for ($i=0; $i < count($result_FLOWMETER[$k]['FLOW']); $i++) {
    
    $this->MYSQL=new MYSQL();
    $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER 
                            WHERE KPE_AIR_FLOWMETER_ID='".$result_FLOWMETER[$k]['FLOW'][$i]['KPE_AIR_FLOWMETER_ID']."'AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_PERIODE>='".$periodeTahunSekarang."-".$periodeBulanSekarang."'";
    $result_DEPARTEMEN[$i]=$this->MYSQL->data(); 
    // $result_DEPARTEMEN[$i]=$result_FLOWMETER[$k]['FLOW'][$i]['KPE_AIR_FLOWMETER_NAMA']; 

    for ($j=0; $j <= $tanggalterakhirnya; $j++) {
      $x = $j - 1;
      // $y = $j + 1; 
      if($j == 0){
        $pakaibeban[$j] = 0;
      }
      else{
      $pakaibeban[$j] = round($result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_ANGKA']-$result_FLOWMETER[$x]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],2);
      }
      
      if (empty($result_FLOWMETER[$j]['FLOW'][$i]['ANGKA'])) {
        $pakai[$j] = 0-0;
      } else {
        $pakai[$j] = $pakaibeban[$j] + $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS'];
      }
      // $pakai[$j] = $pakaibeban[$j] + $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS'] + $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_BEBAN_RUMUS'];
      $beban[$j] = $pakaibeban[$j] + $result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_BEBAN_RUMUS'];
      $rumus[$j] = json_decode($result_FLOWMETER[$j]['FLOW'][$i]['ANGKA']['KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS']);
      $rrumus[$j] = array_sum($rumus[$j]) + $pakai[$j];
    }
    $hasil_pakai[$i] = $rrumus;
    $hasil_beban[$i] = $beban;
    $sum_pakai_belum_format[$i] = array_sum($hasil_pakai[$i]);
    $sum_pakai[$i] = number_format(array_sum($hasil_pakai[$i]),2);
    $sum_beban[$i] = number_format(array_sum($hasil_beban[$i]),2);
    $avrg[$i] = number_format(array_sum($hasil_pakai[$i])/(count($result_FLOWMETER)-1),2);
    $drum[$i] = number_format($avrg[$i]*1000/200,2);
    $liter_belum_format[$i] = $sum_pakai_belum_format[$i]*1000;
    $liter[$i] = number_format($sum_pakai_belum_format[$i]*1000,0);
    $drum2[$i] = number_format($liter_belum_format[$i]/200,0);
  }
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
    $this->callback['HASIL_PAKAI'] = $hasil_pakai;
    $this->callback['HASIL_BEBAN'] = $hasil_beban;
    $this->callback['SUM_PAKAI'] = $sum_pakai;
    $this->callback['AVERAGE'] = $avrg;
    $this->callback['DRUM'] = $drum;
    $this->callback['LITER'] = $liter;
    $this->callback['DRUM2'] = $drum2;
    $this->callback['DEPT'] = $result_DEPARTEMEN;
    $this->callback['tes'] = $tanggalbulankemaren;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
