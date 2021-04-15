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

$sql_a = "SELECT KPE_KWH_FLOWMETER_NAMA,KPE_KWH_CATATAN_ANGKA,KPE_KWH_CATATAN_ANGKA_ESTIMASI,KPE_KWH_CATATAN_BEBAN,
KPE_KWH_CATATAN_BEBAN_X_READING,KPE_KWH_HARIAN_SOLAR_KWH_PERSEN,KPE_KWH_HARIAN_SOLAR_KWH_ACC,KPE_KWH_HARIAN_SOLAR_KWH_ACC_PERSEN,
KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_PAKAI,KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_ACC,KPE_KWH_FLOWMETER_READING
FROM KPE_KWH_HARIAN_SOLAR_KWH WHERE RECORD_STATUS='A' AND KPE_KWH_HARIAN_SOLAR_KWH_TANGGAL='".$input['DATE']."'  
AND KPE_KWH_FLOWMETER_NAMA!='OPERASIONAL TURBIN'
ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a;
$result_a = $this->MYSQL->data();

$no = $posisi + 1;

$datetomorrow = Date("Y/m/d",strtotime($input['DATE'].'+1 day'));

foreach($result_a as $r)
{
  // $r['NO'] = $no;
  //$r['TANGGAL'] =tanggal_format(Date("Y-m-d",strtotime($r['KPE_AIR_TANGGAL'])));

  // $sql_b = "SELECT KPE_KWH_CATATAN_ID,KPE_KWH_CATATAN_ANGKA,KPE_KWH_CATATAN_ANGKA_ESTIMASI,KPE_KWH_CATATAN_PAKAI,KPE_KWH_CATATAN_TANGGAL,
  // KPE_KWH_CATATAN_BEBAN,KPE_KWH_CATATAN_BEBAN_X_READING,KPE_KWH_FLOWMETER_READING,KPE_KWH_CATATAN_NOTE,KPE_KWH_FLOWMETER_NAMA
  // FROM KPE_KWH_CATATAN WHERE RECORD_STATUS='A' AND KPE_KWH_FLOWMETER_ID='".$r['KPE_KWH_FLOWMETER_ID']."' AND KPE_KWH_CATATAN_TANGGAL='".$input['DATE']."'
  // ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

  // $this->MYSQL = new MYSQL();
  // $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  // $this->MYSQL->queri = $sql_b;
  // $result_b = $this->MYSQL->data();

  // if ($result_b > 0) {
  //   $r['CATATAN'] = $result_b;
  // } else {
  //   $r['CATATAN'] = array();
  // }

  $result[] = $r;

  $no++;
}

$sql_d = "SELECT KPE_KWH_FLOWMETER_NAMA,
KPE_KWH_CATATAN_BEBAN_X_READING,KPE_KWH_HARIAN_SOLAR_KWH_PERSEN,KPE_KWH_HARIAN_SOLAR_KWH_ACC,KPE_KWH_HARIAN_SOLAR_KWH_ACC_PERSEN,
KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_PAKAI,KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_ACC
FROM KPE_KWH_HARIAN_SOLAR_KWH WHERE RECORD_STATUS='A' AND KPE_KWH_HARIAN_SOLAR_KWH_TANGGAL='".$input['DATE']."'  
AND KPE_KWH_FLOWMETER_NAMA='OPERASIONAL TURBIN'
ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_d = $this->MYSQL->data()[0];

if ($result_d > 0) {
  $opn_turbin = $result_d;
} else {
  $opn_turbin = array();
}

$sql_c = "SELECT KPE_KWH_DISTRIBUSI_SOLAR_KWH_PEMBEBANAN,KPE_KWH_DISTRIBUSI_SOLAR_KWH_DISTRIBUSI,KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN,
KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE,KPE_KWH_DISTRIBUSI_SOLAR_KWH_SELISIH,KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR
FROM KPE_KWH_DISTRIBUSI_SOLAR_KWH WHERE RECORD_STATUS='A' AND KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL='".$input['DATE']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_c;
$result_c = $this->MYSQL->data()[0];

if ($result_c > 0) {
  $DISTRIBUSI = $result_c;
} else {
  $DISTRIBUSI = array();
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
    $this->callback['DISTRIBUSI'] = $DISTRIBUSI;
    $this->callback['OPN_TURBIN'] = $opn_turbin;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
