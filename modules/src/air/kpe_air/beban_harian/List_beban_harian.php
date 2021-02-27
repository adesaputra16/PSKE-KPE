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

//? =============================================================== ?//
//? =============QUERY FLOWMETER DISTRIBUSI PRE==================== ?//
//? =============================================================== ?//
$sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER
          WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";

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
  // $this->MYSQL=new MYSQL();
  // $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  // $sql_flow = "SELECT ".$filter_bln."
  //                       FROM KPE_AIR_FLOWMETER_CATATAN
  //                       WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."'";
  // $this->MYSQL->queri = $sql_flow;
  // $result_BEBAN=$this->MYSQL->data()[0]; 

  // if(count($result_BEBAN)>=1)
  // {
  //   $r['BEBAN']=$result_BEBAN;
  // } else {
  //   $r['BEBAN']=array();
  // }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_c = "SELECT KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A,KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B,KPE_AIR_FLOWMETER_BEBAN_PRODUK_A,KPE_AIR_FLOWMETER_BEBAN_PRODUK_B,
            KPE_AIR_FLOWMETER_BEBAN_PROSES_A,KPE_AIR_FLOWMETER_BEBAN_PROSES_B
            FROM KPE_AIR_FLOWMETER_BEBAN_BULANAN
            WHERE KPE_AIR_FLOWMETER_BEBAN_PERIODE<='".$tahun."-".$bulan."' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->queri = $sql_c;
  $result_BEBAN_BULANAN=$this->MYSQL->data()[0]; 

  if(count($result_BEBAN_BULANAN)>=1)
  {
    $r['BEBAN_BULANAN']=$result_BEBAN_BULANAN;
  } else {
    $r['BEBAN_BULANAN']=array("KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A" => "-","KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B" => "-","KPE_AIR_FLOWMETER_BEBAN_PRODUK_A" => "-","KPE_AIR_FLOWMETER_BEBAN_PRODUK_B" => "-","KPE_AIR_FLOWMETER_BEBAN_PROSES_A" => "-","KPE_AIR_FLOWMETER_BEBAN_PROSES_B" => "-");
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_c = "SELECT COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0) AS TOTAL_BEBAN,FORMAT(COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0)/".$lastDates.",2) AS AVG
            FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
            WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tahun."-".$bulan."-01' 
            AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tahun."-".$bulan."-31' AND C.KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE'";
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
  $sql_cs = "SELECT FORMAT(COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0),2) AS TOTAL_BEBAN_BULAN_LALU,COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0)/".$lastDatesBulanLalu." AS AVG_BULAN_LALU
            FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
            WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tahun_lalu."-".$bulan_lalu."-01' 
            AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tahun_lalu."-".$bulan_lalu."-31' AND C.KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE'";
  $this->MYSQL->queri = $sql_cs;
  $result_TOTAL_BULAN_LALU=$this->MYSQL->data()[0]; 

  if(count($result_TOTAL_BULAN_LALU)>=1)
  {
    $r['TOTAL_BULAN_LALU']=$result_TOTAL_BULAN_LALU;
  } else {
    $r['TOTAL_BULAN_LALU']=array();
  }
  $r['NO'] = $no;
  $result_pre[]=$r;
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
  $sql_b = "SELECT SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_BEBAN
                        FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
                        WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporan."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' ORDER BY C.KPE_AIR_FLOWMETER_NAMA";
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
  $sql_bl = "SELECT SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_BEBAN_BULAN_LALU
              FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
              WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporanl."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' ORDER BY C.KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_bl;
  $result_BEBAN_BULAN_LALU=$this->MYSQL->data()[0]; 
    
  $result_beban_BULAN_LALU[]=$result_BEBAN_BULAN_LALU['TOTAL_BEBAN_BULAN_LALU'];
  $no++;
}
$BEBAN_HARIAN_BULAN_LALU = array_sum($result_beban_BULAN_LALU);
$AVG_BEBAN_BULAN_LALU = array_sum($result_beban_BULAN_LALU)/$lastDatesBulanLalu;

//? =============================================================== ?//
//? ============= QUERY FLOWMETER DISTRIBUSI RO =================== ?//
//? =============================================================== ?//
$sql_ro = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER
          WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_ro. " LIMIT " . $posisi . "," . $batas;
$result_fro = $this->MYSQL->data();

$no = $posisi + 1;
foreach ($result_fro as $r ) {
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_flow = "SELECT ".$filter_bln."
                        FROM KPE_AIR_FLOWMETER_CATATAN
                        WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."'";
  $this->MYSQL->queri = $sql_flow;
  $result_BEBAN_RO=$this->MYSQL->data()[0]; 

  if(count($result_BEBAN_RO)>=1)
  {
    $r['BEBAN_RO']=$result_BEBAN_RO;
  } else {
    $r['BEBAN_RO']=array();
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_cro = "SELECT KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A,KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B,KPE_AIR_FLOWMETER_BEBAN_PRODUK_A,KPE_AIR_FLOWMETER_BEBAN_PRODUK_B,
            KPE_AIR_FLOWMETER_BEBAN_PROSES_A,KPE_AIR_FLOWMETER_BEBAN_PROSES_B
            FROM KPE_AIR_FLOWMETER_BEBAN_BULANAN 
            WHERE KPE_AIR_FLOWMETER_BEBAN_PERIODE<='".$tahun."-".$bulan."' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->queri = $sql_cro;
  $result_BEBAN_BULANAN_RO=$this->MYSQL->data()[0]; 

  if(count($result_BEBAN_BULANAN_RO)>=1)
  {
    $r['BEBAN_BULANAN_RO']=$result_BEBAN_BULANAN_RO;
  } else {
    $r['BEBAN_BULANAN_RO']=array("KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A" => "-","KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B" => "-","KPE_AIR_FLOWMETER_BEBAN_PRODUK_A" => "-","KPE_AIR_FLOWMETER_BEBAN_PRODUK_B" => "-","KPE_AIR_FLOWMETER_BEBAN_PROSES_A" => "-","KPE_AIR_FLOWMETER_BEBAN_PROSES_B" => "-");
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_dro = "SELECT COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0) AS TOTAL_BEBAN,FORMAT(COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0)/".$lastDates.",2) AS AVG
            FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
            WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tahun."-".$bulan."-01' 
            AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tahun."-".$bulan."-31' AND C.KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO'";
  $this->MYSQL->queri = $sql_dro;
  $result_TOTAL_RO=$this->MYSQL->data()[0]; 

  if(count($result_TOTAL_RO)>=1)
  {
    $r['TOTAL_RO']=$result_TOTAL_RO;
  } else {
    $r['TOTAL_RO']=array();
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_csro = "SELECT FORMAT(COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0),2) AS TOTAL_BEBAN_BULAN_LALU,COALESCE(SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN),0)/".$lastDatesBulanLalu." AS AVG_BULAN_LALU
            FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
            WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tahun_lalu."-".$bulan_lalu."-01' 
            AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tahun_lalu."-".$bulan_lalu."-31' AND C.KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO'";
  $this->MYSQL->queri = $sql_csro;
  $result_TOTAL_BULAN_LALU_RO=$this->MYSQL->data()[0]; 

  if(count($result_TOTAL_BULAN_LALU_RO)>=1)
  {
    $r['TOTAL_BULAN_LALU_RO']=$result_TOTAL_BULAN_LALU_RO;
  } else {
    $r['TOTAL_BULAN_LALU_RO']=array();
  }
  $r['NO'] = $no;
  $result_ro[]=$r;
  $no++;
}

$tanggalAwalsro=$tahun."-".$bulan."-01";

$tanggalterakhirro =date("Y-m-t", strtotime($tahun.'-'.$bulan));
$tanggalAkhirsro=Date('Y-m-d',strtotime($tanggalterakhirro));
$tanggalterakhirnyaro = date("d",strtotime($tanggalterakhirro));

$beginro = new DateTime($tanggalAwalsro);
$endro   = new DateTime($tanggalAkhirsro);
$no=1 + $posisi;
for($iyro = $beginro; $iyro <= $endro; $iyro->modify('+1 day'))
{
  $tglLaporanro=$iyro->format("Y-m-j");

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_bro = "SELECT SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_BEBAN_RO
                        FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
                        WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporanro."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO' ORDER BY C.KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_bro;
  $result_BEBAN_RO=$this->MYSQL->data()[0]; 
    
  $result_beban_RO[]=$result_BEBAN_RO['TOTAL_BEBAN_RO'];
  $no++;
}
$BEBAN_HARIAN_RO = array_sum($result_beban_RO);
$AVG_BEBAN_RO = array_sum($result_beban_RO)/$lastDates;

$tanggalLaluRo=$tahun_lalu."-".$bulan_lalu."-01";

$tanggalterakhirLaluRo =date("Y-m-t", strtotime($tahun_lalu.'-'.$bulan_lalu));
$tanggalAkhirsLaluRo=Date('Y-m-d',strtotime($tanggalterakhirLaluRo));

$begin_bulan_laluRo = new DateTime($tanggalLaluRo);
$end_bulan_laluRo   = new DateTime($tanggalAkhirsLaluRo);
for($iylRo = $begin_bulan_laluRo; $iylRo <= $end_bulan_laluRo; $iylRo->modify('+1 day'))
{
  $tglLaporanlRo=$iylRo->format("Y-m-j");

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_blro = "SELECT SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_BEBAN_BULAN_LALU_RO
                        FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
                        WHERE C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporanlRo."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO' ORDER BY C.KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_blro;
  $result_BEBAN_BULAN_LALU_RO=$this->MYSQL->data()[0]; 
    
  $result_beban_BULAN_LALU_RO[]=$result_BEBAN_BULAN_LALU_RO['TOTAL_BEBAN_BULAN_LALU_RO'];
  $no++;
}
$BEBAN_HARIAN_BULAN_LALU_RO = array_sum($result_beban_BULAN_LALU_RO);
$AVG_BEBAN_BULAN_LALU_RO = array_sum($result_beban_BULAN_LALU_RO)/$lastDatesBulanLalu;


if (empty($result_pre))
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
    $this->callback['RESULT_PRE'] =$result_pre;
    $this->callback['SUM_TOTAL_BEBAN_HARIAN'] = $result_beban;
    $this->callback['TOTAL_BEBAN'] = $BEBAN_HARIAN;
    $this->callback['AVG_BEBAN'] = $AVG_BEBAN;
    $this->callback['SUM_TOTAL_BEBAN_HARIAN_BULAN_LALU'] = $result_beban_BULAN_LALU;
    $this->callback['TOTAL_BEBAN_BULAN_LALU'] = $BEBAN_HARIAN_BULAN_LALU;
    $this->callback['AVG_BEBAN_BULAN_LALU'] = $AVG_BEBAN_BULAN_LALU;
    $this->callback['SUM_TOTAL_BEBAN_HARIAN_RO'] = $result_beban_RO;
    $this->callback['TOTAL_BEBAN_RO'] = $BEBAN_HARIAN_RO;
    $this->callback['AVG_BEBAN_RO'] = $AVG_BEBAN_RO;
    $this->callback['SUM_TOTAL_BEBAN_HARIAN_BULAN_LALU_RO'] = $result_beban_BULAN_LALU_RO;
    $this->callback['TOTAL_BEBAN_BULAN_LALU_RO'] = $BEBAN_HARIAN_BULAN_LALU_RO;
    $this->callback['AVG_BEBAN_BULAN_LALU_RO'] = $AVG_BEBAN_BULAN_LALU_RO;
    $this->callback['RESULT_RO'] =$result_ro;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
