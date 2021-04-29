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

if (empty($input['BULAN_FILTER']) || empty($input['TAHUN_FILTER'])) {
  $filter = "";
} else {
  $filter = " AND KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL>='".$input['TAHUN_FILTER']."-".$input['BULAN_FILTER']."-01' AND KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL>='".$input['TAHUN_FILTER']."-".$input['BULAN_FILTER']."-31'";
}

$sql_a = "SELECT KPE_KWH_DISTRIBUSI_ENERGI_ID,KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL,KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN,
KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI,KPE_KWH_DISTRIBUSI_ENERGI_TURBIN,KPE_KWH_DISTRIBUSI_ENERGI_POWERHOUSE,KPE_KWH_DISTRIBUSI_ENERGI_SELISIH,
KPE_KWH_DISTRIBUSI_ENERGI_SOLAR,KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA,KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN
FROM KPE_KWH_DISTRIBUSI_ENERGI WHERE RECORD_STATUS='A' ".$filter." ORDER BY KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a;
$result_a = $this->MYSQL->data();

$no = $posisi + 1;

$datetomorrow = Date("Y/m/d",strtotime($input['DATE'].'+1 day'));

foreach($result_a as $r)
{
  $result[] = $r;

  $no++;
}

if (empty($result_a))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
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
