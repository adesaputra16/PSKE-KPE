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
  $filter_a = "AND KPE_AIR_FLOWMETER_SUB_NAMA LIKE '%" . $input['keyword'] . "%'";
}

$sql_a = "SELECT * FROM KPE_AIR_FLOWMETER_SUB WHERE RECORD_STATUS='A' ".$filter_a." ORDER BY KPE_AIR_FLOWMETER_SUB_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a . " LIMIT " . $posisi . "," . $batas;
$result_a = $this->MYSQL->data();

// $this->MYSQL = new MYSQL();
// $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
// $this->MYSQL->tabel = 'KPE_AIR_FLOWMETER';
// $this->MYSQL->kolom = '*'; 
// $this->MYSQL->dimana = "WHERE (KPE_AIR_FLOWMETER_NAMA LIKE '%".$input['keyword']. "%' OR KPE_AIR_FLOWMETER_LOKASI LIKE '%".$input['keyword']."%') AND (RECORD_STATUS='A' or RECORD_STATUS='N') ";
// $result_a = $this->MYSQL->data();

// -- >>

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
    $this->callback['respon']['text_msg'] = "Data tidak ada";
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
