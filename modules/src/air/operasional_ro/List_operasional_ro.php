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
  if ($input['BULAN_FILTER'] == "") {
    $bulan = Date('m');
  } else {
    $bulan = $input['BULAN_FILTER'];
  }
  if ($input['TAHUN_FILTER'] == "") {
    $tahun = Date('Y');
  } else {
    $tahun = $input['TAHUN_FILTER'];
  }
  
  $tanggalAwals=$tahun."-".$bulan."-01";
  $tanggalbulankemaren = Date('Y-m-d',strtotime($tanggalAwals.'-1 day'));
  
  $sql_a = "SELECT * FROM KPE_AIR_FLOWMETER_OPERASIONAL_RO WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL>='".$tanggalbulankemaren."' AND KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL<='".$tahun."-".$bulan."-31' ORDER BY KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL ASC ";
} else {
  $sql_a = "SELECT * FROM KPE_AIR_FLOWMETER_OPERASIONAL_RO WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL='".$input['TANGGAL_FILTER']."'";
  $sql_b = "SELECT * FROM KPE_AIR_FLOWMETER_REKAP_USED_RO WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL='".$input['TANGGAL_FILTER']."'";
}



$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a;
$result_a = $this->MYSQL->data();

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_b;
$result_b = $this->MYSQL->data()[0];

$no = $posisi + 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
    $r['REKAP_USED'] = $result_b;
    //$r['TANGGAL'] =tanggal_format(Date("Y-m-d",strtotime($r['KPE_AIR_TANGGAL'])));
    $result[] = $r;

    $no++;
    }

if (empty($result_a))
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
