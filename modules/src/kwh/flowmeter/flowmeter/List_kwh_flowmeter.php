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

if (empty($input['keyword']) or $input['keyword'] == "")
{
  $filter_a = "";
} else
{
  $filter_a = "AND KPE_KWH_FLOWMETER_NAMA LIKE '%" . $input['keyword'] . "%'";
}

if (empty($input['KPE_KWH_FLOWMETER_NAMA']) or $input['KPE_KWH_FLOWMETER_NAMA'] == "")
{
  $filter_b = "";
} else
{
  $filter_b = "AND KPE_KWH_FLOWMETER_ID=".$input['KPE_KWH_FLOWMETER_NAMA']."";
}

// $sql_a = "SELECT * FROM KPE_KWH_FLOWMETER WHERE RECORD_STATUS='A' ".$filter_a." ".$filter_b." ".$filter_c." ".$filter_d." ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";
$sql_a = "SELECT KPE_KWH_FLOWMETER_ID,KPE_KWH_FLOWMETER_NAMA,KPE_KWH_FLOWMETER_LOKASI, 
          KPE_KWH_FLOWMETER_READING,KPE_KWH_FLOWMETER_DISTRIBUSI,KPE_KWH_FLOWMETER_TYPE
          FROM KPE_KWH_FLOWMETER WHERE RECORD_STATUS='A' ".$filter_a." ".$filter_b." ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";



$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a . " LIMIT " . $posisi . "," . $batas;
$result_a = $this->MYSQL->data();

$no = $posisi + 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
    //$r['TANGGAL'] =tanggal_format(Date("Y-m-d",strtotime($r['KPE_AIR_TANGGAL'])));
    $result[] = $r;

    $no++;
    }

if (empty($result_a))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $sql_a;
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
