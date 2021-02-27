<?php

if (empty($params['case']))
{
  $result['respon']['pesan'] == "gagal";
  $result['respon']['pesan'] == "Module tidak dapat di muat";
  echo json_encode($result);
  exit();
}

$input = $params['input_option'];

$sql_d = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE 
          FROM KPE_AIR_FLOWMETER WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_DLY = 'Y' ORDER BY KPE_AIR_FLOWMETER_NAMA";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_a = $this->MYSQL->data();

// -- >>

$no = $posisi + 1;

$tanggalAwal = substr($input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],0,7);

foreach($result_a as $r)
{
  $sql_c = "SELECT KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA,KPE_AIR_FLOWMETER_ID FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL = new MYSQL();
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = $sql_c;
  $result_c = $this->MYSQL->data();

  $sql_h = "SELECT SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS ACCUMULATIF_TOTAL
            FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
            WHERE C.RECORD_STATUS='A' AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tanggalAwal."-01' AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' AND F.KPE_AIR_FLOWMETER_DLY='Y'";

  $this->MYSQL = new MYSQL();
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = $sql_h;
  $ACCUMULATIF_TOTAL = $this->MYSQL->data()[0] ? : array();

  $sql_f = "SELECT SUM(C.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS TOTAL_USAGE
            FROM KPE_AIR_FLOWMETER_CATATAN AS C LEFT JOIN KPE_AIR_FLOWMETER AS F ON C.KPE_AIR_FLOWMETER_ID=F.KPE_AIR_FLOWMETER_ID
            WHERE C.RECORD_STATUS='A' AND C.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND C.RECORD_STATUS='A' AND F.RECORD_STATUS='A' AND F.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' AND F.KPE_AIR_FLOWMETER_DLY='Y'";

  $this->MYSQL = new MYSQL();
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = $sql_f;
  $TOTAL_USAGE = $this->MYSQL->data()[0];

  if(count($result_c) >= 1) {
    $sql_g = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN) AS ACCUMULATIF
              FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN
              WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' 
              AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL>='".$tanggalAwal."-01' 
              AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL<='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' 
              AND RECORD_STATUS='A'GROUP BY KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA ORDER BY KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA ASC";

    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_g;
    $ACCUMULATIF = $this->MYSQL->data() ? : array();

    $sql_e = "SELECT KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA,KPE_AIR_FLOWMETER_ID FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA ASC";
  
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_e;
    $result_e = $this->MYSQL->data() ? : array();
  } else {

    $sql_g = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS ACCUMULATIF
              FROM KPE_AIR_FLOWMETER_CATATAN 
              WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$tanggalAwal."-01' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND RECORD_STATUS='A'";

    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_g;
    $ACCUMULATIF = $this->MYSQL->data()[0] ? : array();

    $sql_e = "SELECT KPE_AIR_FLOWMETER_CATATAN_BEBAN,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_CATATAN_TANGGAL 
              FROM KPE_AIR_FLOWMETER_CATATAN 
              WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND RECORD_STATUS='A'";
  
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_e;
    $result_e = $this->MYSQL->data()[0] ? : array();
  }

  $r['NO'] = $no;
  $r['BEBAN_HARIAN'] = $result_e;
  $r['ACCUMULATIF'] = $ACCUMULATIF;
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
$this->callback['TOTAL_USAGE'] = $TOTAL_USAGE['TOTAL_USAGE'];
$this->callback['ACCUMULATIF_TOTAL'] = $ACCUMULATIF_TOTAL['ACCUMULATIF_TOTAL'];
}

?>