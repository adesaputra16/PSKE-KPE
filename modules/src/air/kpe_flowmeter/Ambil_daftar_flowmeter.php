<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }


$input = $params['input_option'];

$sql_f = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA,F.KPE_AIR_FLOWMETER_LOKASI,F.KPE_AIR_FLOWMETER_DISTRIBUSI,
F.KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,FS.KPE_AIR_FLOWMETER_SUB_ID,FS.KPE_AIR_FLOWMETER_SUB_NAMA
FROM KPE_AIR_FLOWMETER AS F 
LEFT JOIN KPE_AIR_FLOWMETER_SUB AS FS 
ON F.KPE_AIR_FLOWMETER_SUB_ID=FS.KPE_AIR_FLOWMETER_SUB_ID
WHERE FS.RECORD_STATUS='A' AND F.RECORD_STATUS='A' ORDER BY F.KPE_AIR_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_f;
$result_a = $this->MYSQL->data();

// -- >>

$no = $posisi + 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
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

    }

?>
