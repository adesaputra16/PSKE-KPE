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

if ($input['TANGGAL_FILTER'] == "") {
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
  
  if ($input['dateRangeS'] == "NaN-NaN-NaN" || $input['dateRangeSE'] == "NaN-NaN-NaN") {
    $begin = new DateTime($tanggalbulankemaren);
    $end   = new DateTime($tanggalAkhirs);
  } 
  else {
    $begin = new DateTime($input['dateRangeS']);
    $end   = new DateTime($input['dateRangeSE']);
  }
  // $begin = new DateTime($tanggalAwals);
  // $end   = new DateTime($tanggalAkhirs);
  
  for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
  {
  
  
    $tglLaporan=$iy->format("Y-m-j");
    $tglLaporans=explode('-',$tglLaporan);
    $iys['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime($tglLaporan)));
    $iys['NO']=$tglLaporans[2];
  
    $this->MYSQL=new MYSQL();
    $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
    $sql_a = "SELECT * FROM KPE_AIR_FLOWMETER_KIMIA_RO WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL='".$tglLaporan."' ORDER BY KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL ASC";
    
    $this->MYSQL->queri = $sql_a;
    $result_KIMIA=$this->MYSQL->data()[0]; 
  
    if(count($result_KIMIA)>=1)
    {
      $iys['KIMIA']=$result_KIMIA;
  
    } else {
      $iys['KIMIA']="";
    }
  
    $result[]=$iys;
    $no++;
  }
} else {
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_a = "SELECT * FROM KPE_AIR_FLOWMETER_KIMIA_RO WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL='".$input['TANGGAL_FILTER']."' ORDER BY KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL ASC";
  
  $this->MYSQL->queri = $sql_a;
  $result=$this->MYSQL->data(); 
  
}


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
