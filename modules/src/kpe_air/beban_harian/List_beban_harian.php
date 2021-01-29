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
          WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_DISTRIBUSI LIKE '%Pre%' ORDER BY KPE_AIR_FLOWMETER_NAMA";

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
  $r['NO'] = $no;
  $result_flow[]=$r;
  $no++;
}

// $tanggalAwals=$periodeTahunSekarang."-".$periodeBulanSekarang."-01";
// $tanggalbulankemaren = Date('Y-m-d',strtotime($tanggalAwals.'-1 day'));

// $tanggalterakhir =date("Y-m-t", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
// $tanggalAkhirs=Date('Y-m-d',strtotime($tanggalterakhir));
// $tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

// $begin = new DateTime($tanggalAwals);
// $end   = new DateTime($tanggalAkhirs);
// $no=1 + $posisi;
// for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
// {

//   $tglLaporan=$iy->format("Y-m-j");
//   $tglLaporans=explode('-',$tglLaporan);
//   $iys['TANGGAL']=$tglLaporans[2];

//   $this->MYSQL = new MYSQL();
//   $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
//   $this->MYSQL->queri = $sql_a. " LIMIT " . $posisi . "," . $batas;
//   $result_a["'".$no."'"] = $this->MYSQL->data();
//   foreach($result_a["'".$no."'"] as $row_flow)
//   {
//     $this->MYSQL=new MYSQL();
//     $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
//     $this->MYSQL->queri = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_ID,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN,a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL
//                           FROM KPE_AIR_FLOWMETER_CATATAN AS a  
//                           WHERE a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporan."' AND a.RECORD_STATUS='A' ORDER BY a.KPE_AIR_FLOWMETER_NAMA";
//     $result_BEBAN["'".$no."'"]=$this->MYSQL->data(); 

//     if(count($result_BEBAN["'".$no."'"])>=1)
//     {
//      $row_flow['BEBAN']=$result_BEBAN["'".$no."'"];
//     } else {
//       $row_flow['BEBAN']=array();
//     }
//     $xy["'".$no."'"][]=$row_flow;
//     $iys['FLOW'] = $xy["'".$no."'"];
			
//     }

//   $result_beban[]=$iys;
//   $no++;
// }



if (empty($result_flow))
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
    $this->callback['result_data'] = $result_beban;
    $this->callback['result'] =$result_flow;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
