<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

    if ($input['BULAN_FILTER'] == "")
    {

      $tanggalterakhir = date("Y-m-t", strtotime(2021-01));
      $tanggalterakhirnya = date("d",strtotime($tanggalterakhir));
      $bulan='01';
      $tahun='2021';
      for ($j=1; $j <= $tanggalterakhirnya; $j++) { 
        $tanggal = sprintf("%02d", $j);
        $filter_bln .= ",MAX(CASE WHEN Date_format(KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tahun."-".$bulan."-".$tanggal."' 
        THEN KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day".$j."`";
      }
      $filter_bln = substr($filter_bln,1);
    }

$halaman = $params['halaman'];
$batas = $params['batas'];
$posisi = $this->PAGING->cariPosisi($batas, $halaman);
$input = $params['input_option'];

$sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA FROM KPE_AIR_FLOWMETER
          WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_DISTRIBUSI LIKE '%Pre%' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a. " LIMIT " . $posisi . "," . $batas;
$result_ab = $this->MYSQL->data();

$no = $posisi + 1;

// if($input['TAHUN_FILTER']==""){
//   $periodeTahunSekarang=Date("Y");
// }else{
//   $periodeTahunSekarang=$input['TAHUN_FILTER'];
// }
if($input['BULAN_FILTER']=="" && $input['TAHUN_FILTER']==""){
  $bulan=Date("m");
  $tahun=Date("Y");
  $bulan_lalu=Date("m")-1;
  $tahun_lalu=Date("Y");
}else{
  $bulan=$input['BULAN_FILTER'];
  $tahun=$input['TAHUN_FILTER'];
  $bulan_lalu=$input['BULAN_FILTER']-1;
  $tahun_lalu=$input['TAHUN_FILTER'];
}

$lastDates =date("t", strtotime($tahun.'-'.$bulan.'-01'));
$lastDatesBulanLalu =date("t", strtotime($tahun_lalu.'-'.$bulan_lalu.'-01'));

foreach ($result_ab as $r ) {
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_flow = "SELECT ".$filter_bln."
                        FROM KPE_AIR_FLOWMETER_CATATAN
                        WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."'";
  $this->MYSQL->queri = $sql_flow;
  $result_BEBAN=$this->MYSQL->data()[0]; 

  if(count($result_BEBAN)>=1)
  {
    $r['BEBAN']=$result_BEBAN;
  } else {
    $r['BEBAN']=array();
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_c = "SELECT FORMAT(COALESCE(SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN),0),2) AS TOTAL_BEBAN,FORMAT(COALESCE(SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN),0)/".$lastDates.",2) AS AVG
            FROM KPE_AIR_FLOWMETER_CATATAN 
            WHERE KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tahun."-".$bulan."-01' 
            AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tahun."-".$bulan."-31' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->queri = $sql_c;
  $result_TOTAL=$this->MYSQL->data()[0]; 

  if(count($result_TOTAL)>=1)
  {
    $r['TOTAL']=$result_TOTAL;
  } else {
    $r['TOTAL']=array();
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_cs = "SELECT FORMAT(COALESCE(SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN),0),2) AS TOTAL_BEBAN_BULAN_LALU,COALESCE(SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN),0)/".$lastDatesBulanLalu." AS AVG_BULAN_LALU
            FROM KPE_AIR_FLOWMETER_CATATAN 
            WHERE KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tahun_lalu."-".$bulan_lalu."-01' 
            AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tahun_lalu."-".$bulan_lalu."-31' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->queri = $sql_cs;
  $result_TOTAL_BULAN_LALU=$this->MYSQL->data()[0]; 

  if(count($result_TOTAL_BULAN_LALU)>=1)
  {
    $r['TOTAL_BULAN_LALU']=$result_TOTAL_BULAN_LALU;
  } else {
    $r['TOTAL_BULAN_LALU']=array();
  }
  $r['NO'] = $no;
  $result[]=$r;
  $no++;
}

$tanggalAwals=$tahun."-".$bulan."-01";

$tanggalterakhir =date("Y-m-t", strtotime($tahun.'-'.$bulan));
$tanggalAkhirs=Date('Y-m-d',strtotime($tanggalterakhir));
$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

$begin = new DateTime($tanggalAwals);
$end   = new DateTime($tanggalAkhirs);
$no=1 + $posisi;
for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
{
  $tglLaporan=$iy->format("Y-m-j");

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_b = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_BEBAN,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_ID
                        FROM KPE_AIR_FLOWMETER_CATATAN
                        WHERE KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporan."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_b;
  $result_BEBAN=$this->MYSQL->data()[0]; 
    
  $result_beban[]=$result_BEBAN['TOTAL_BEBAN'];
  $no++;
}
$BEBAN_HARIAN = array_sum($result_beban);
$AVG_BEBAN = array_sum($result_beban)/$lastDates;

$tanggalLalu=$tahun_lalu."-".$bulan_lalu."-01";

$tanggalterakhirLalu =date("Y-m-t", strtotime($tahun_lalu.'-'.$bulan_lalu));
$tanggalAkhirsLalu=Date('Y-m-d',strtotime($tanggalterakhirLalu));

$begin_bulan_lalu = new DateTime($tanggalLalu);
$end_bulan_lalu   = new DateTime($tanggalAkhirsLalu);
for($iyl = $begin_bulan_lalu; $iyl <= $end_bulan_lalu; $iyl->modify('+1 day'))
{
  $tglLaporanl=$iyl->format("Y-m-j");

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_bl = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_BEBAN_BULAN_LALU
                        FROM KPE_AIR_FLOWMETER_CATATAN
                        WHERE KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporanl."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_bl;
  $result_BEBAN_BULAN_LALU=$this->MYSQL->data()[0]; 
    
  $result_beban_BULAN_LALU[]=$result_BEBAN_BULAN_LALU['TOTAL_BEBAN_BULAN_LALU'];
  $no++;
}
$BEBAN_HARIAN_BULAN_LALU = array_sum($result_beban_BULAN_LALU);
$AVG_BEBAN_BULAN_LALU = array_sum($result_beban_BULAN_LALU)/$lastDatesBulanLalu;


if (empty($result))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result_beban;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Data Ada ".print_r($result_beban,true);
    $this->callback['filter'] = $params;
    $this->callback['SUM_TOTAL_BEBAN_HARIAN'] = $result_beban;
    $this->callback['TOTAL_BEBAN'] = $BEBAN_HARIAN;
    $this->callback['AVG_BEBAN'] = $AVG_BEBAN;
    $this->callback['SUM_TOTAL_BEBAN_HARIAN_BULAN_LALU'] = $result_beban_BULAN_LALU;
    $this->callback['TOTAL_BEBAN_BULAN_LALU'] = $BEBAN_HARIAN_BULAN_LALU;
    $this->callback['AVG_BEBAN_BULAN_LALU'] = $AVG_BEBAN_BULAN_LALU;
    $this->callback['result'] =$result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
