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

$sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA FROM KPE_AIR_FLOWMETER
          WHERE RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";

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
  $r['NO'] = $no;
  $result_flow[]=$r;
  $no++;
}

$tanggalAwals=$periodeTahunSekarang."-".$periodeBulanSekarang."-01";
$tanggalbulankemaren = Date('Y-m-d',strtotime($tanggalAwals.'-1 day'));

$tanggalterakhir =date("Y-m-t", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
$tanggalAkhirs=Date('Y-m-d',strtotime($tanggalterakhir));
$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

$begin = new DateTime($tanggalAwals);
$end   = new DateTime($tanggalAkhirs);
$no=1 + $posisi;
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
      // $this->MYSQL=new MYSQL();
      // $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
      // $this->MYSQL->queri = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_ID, a.KPE_AIR_FLOWMETER_NAMA,a.KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN_RUMUS,
      //                       a.KPE_AIR_FLOWMETER_CATATAN_ANGKA, a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL,a.ENTRI_WAKTU
      //                       FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID  
      //                       WHERE b.KPE_AIR_FLOWMETER_ID='".$row_flow['KPE_AIR_FLOWMETER_ID']."' AND  
      //                       a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tglLaporan."'
      //                       AND b.RECORD_STATUS='A' AND  a.RECORD_STATUS='A' ORDER BY a.KPE_AIR_FLOWMETER_NAMA";
      // $result_ANGKA["'".$no."'"]=$this->MYSQL->data()[0]; 

      // if(count($result_ANGKA["'".$no."'"])>=1)
      // {
      //  $row_flow['ANGKA']=$result_ANGKA["'".$no."'"];
      // } else {
      //   $row_flow['ANGKA']=array();
      // }
    $xy["'".$no."'"][]=$row_flow;
    $iys['FLOW'] = $xy["'".$no."'"];
			
    }

  $result_FLOWMETER[]=$iys;
  $no++;
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
    $this->callback['result_flow'] = $result_flow;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
