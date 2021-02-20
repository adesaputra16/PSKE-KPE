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
// $tanggalbulankemaren = Date('Y-m-d',strtotime($tanggalAwals.'-1 day'));

$tanggalterakhir = date("Y-m-t", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
$tanggalAkhirs= Date('Y-m-d',strtotime($tanggalterakhir));
$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

$begin = new DateTime($tanggalAwals);
$end   = new DateTime($tanggalAkhirs);

for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
{


  $tglLaporan=$iy->format("Y-m-j");
  $tglLaporans=explode('-',$tglLaporan);
  $iys['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime($tglLaporan)));
  $iys['NO']=$tglLaporans[2];

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = "SELECT KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL,KPE_AIR_FLOWMETER_REKAP_USED_PRE_BEBAN,KPE_AIR_FLOWMETER_NAMA,
                          KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING,KPE_AIR_FLOWMETER_REKAP_USED_PRE_RATA_RATA,KPE_AIR_FLOWMETER_REKAP_USED_PRE_TOTAL 
                          FROM KPE_AIR_FLOWMETER_REKAP_USED_PRE WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL='".$tglLaporan."'";
  $result_REKAP=$this->MYSQL->data(); 

  if(count($result_REKAP)>=1)
  {
    $iys['REKAP']=$result_REKAP;

  } else {
    $iys['REKAP']="";
  }

  $result[]=$iys;
  $no++;
}
// for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
// {


//   $tglLaporan=$iy->format("Y-m-j");
//   $tglLaporans=explode('-',$tglLaporan);
//   $iys['TANGGAL']=$tglLaporan;
//   $iys['NO']=$tglLaporans[2];

//   $this->MYSQL = new MYSQL();
//   $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
//   $this->MYSQL->queri = $sql_a;
//   $result_a["'".$no."'"] = $this->MYSQL->data();
//   foreach($result_a["'".$no."'"] as $row_flow)
//   {
//       $this->MYSQL=new MYSQL();
//       $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
//       $this->MYSQL->queri = "SELECT KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL,KPE_AIR_FLOWMETER_REKAP_USED_PRE_BEBAN,KPE_AIR_FLOWMETER_NAMA,
//                              KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING,KPE_AIR_FLOWMETER_REKAP_USED_PRE_RATA_RATA,KPE_AIR_FLOWMETER_REKAP_USED_PRE_TOTAL 
//                              FROM KPE_AIR_FLOWMETER_REKAP_USED_PRE WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL='".$tglLaporan."' AND KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."'";
//       $result_DEPARTEMEN=$this->MYSQL->data(); 

//       if(count($result_DEPARTEMEN)>=1)
//       {
//        $row_flow['DEPARTEMEN']=$result_DEPARTEMEN;

//       } else {
//         $row_flow['DEPARTEMEN']="";
//       }
//     $xy["'".$no."'"][]=$row_flow;
//     $iys['FLOW'] = $xy["'".$no."'"];
			
//     }
//   $result[]=$iys;
//   $no++;
// }

if (empty($result))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "OK..";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
