<?php

if (empty($params['case']))
{
  $result['respon']['pesan'] == "gagal";
  $result['respon']['pesan'] == "Module tidak dapat di muat";
  echo json_encode($result);
  exit();
}

$input = $params['input_option'];

//? Ambil total kwh
$sql_a = "SELECT SUM(A.KPE_KWH_CATATAN_BEBAN_X_READING) AS DISTRIBUSI 
          FROM KPE_KWH_CATATAN AS A 
          LEFT JOIN KPE_KWH_FLOWMETER AS B 
          ON A.KPE_KWH_FLOWMETER_ID=B.KPE_KWH_FLOWMETER_ID 
          WHERE B.KPE_KWH_FLOWMETER_DISTRIBUSI='YA' AND A.RECORD_STATUS='A' 
          AND B.RECORD_STATUS='A'
          AND A.KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a;
$result_a = $this->MYSQL->data();
if ($result_a[0]['DISTRIBUSI'] == null || $result_a[0]['DISTRIBUSI'] == "")
{
  $this->callback['respon']['pesan'] = "gagal";
  $this->callback['respon']['text_msg'] = "Catatan tanggal ".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']." belum diinput.";
  return false;
}
//? end

$KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI = $result_a[0]['DISTRIBUSI'];
$KPE_KWH_DISTRIBUSI_ENERGI_SELISIH = $input['KPE_KWH_DISTRIBUSI_ENERGI_TURBIN'] - $KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI;

//? Ambil total kwh turbin
$sql_b = "SELECT SUM(A.KPE_KWH_CATATAN_BEBAN_X_READING) AS KWH_TURBIN 
          FROM KPE_KWH_CATATAN AS A 
          LEFT JOIN KPE_KWH_FLOWMETER AS B 
          ON A.KPE_KWH_FLOWMETER_ID=B.KPE_KWH_FLOWMETER_ID 
          WHERE B.KPE_KWH_FLOWMETER_TYPE='TURBIN' AND A.RECORD_STATUS='A' 
          AND B.RECORD_STATUS='A'
          AND A.KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_b;
$result_b = $this->MYSQL->data()[0];
//? end

//? Ambil catatan kwh turbin berdasarkan tgl
$sql_c = "SELECT A.KPE_KWH_CATATAN_BEBAN_X_READING
          FROM KPE_KWH_CATATAN AS A 
          LEFT JOIN KPE_KWH_FLOWMETER AS B 
          ON A.KPE_KWH_FLOWMETER_ID=B.KPE_KWH_FLOWMETER_ID 
          WHERE B.KPE_KWH_FLOWMETER_TYPE='TURBIN' AND A.RECORD_STATUS='A' 
          AND B.RECORD_STATUS='A'
          AND A.KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_c;
$result_c = $this->MYSQL->data();

for ($i=0; $i < count($result_c); $i++) { 
  $catatan[] = $result_c[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / $result_b['KWH_TURBIN'] * $KPE_KWH_DISTRIBUSI_ENERGI_SELISIH;
  $total_catatan[] = $result_c[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] + $catatan[$i];
}

$operasional_turbin = array_sum($total_catatan);
//? end

//? Ambil total keseluruhan kwh dept
$sql_d = "SELECT SUM(A.KPE_KWH_CATATAN_BEBAN_X_READING) AS BEBAN_DEPT
          FROM KPE_KWH_CATATAN AS A 
          LEFT JOIN KPE_KWH_FLOWMETER AS B 
          ON A.KPE_KWH_FLOWMETER_ID=B.KPE_KWH_FLOWMETER_ID 
          WHERE B.KPE_KWH_FLOWMETER_TYPE='DEPT' AND A.RECORD_STATUS='A' 
          AND B.RECORD_STATUS='A'
          AND A.KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_d = $this->MYSQL->data()[0];

$KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN = $operasional_turbin + $result_d['BEBAN_DEPT'];
//? end

$sql_e = "SELECT A.KPE_KWH_CATATAN_BEBAN,A.KPE_KWH_CATATAN_ANGKA,A.KPE_KWH_CATATAN_ANGKA_ESTIMASI,
A.KPE_KWH_CATATAN_BEBAN_X_READING,B.KPE_KWH_FLOWMETER_READING,B.KPE_KWH_FLOWMETER_NAMA,B.KPE_KWH_FLOWMETER_READING
FROM KPE_KWH_CATATAN AS A 
LEFT JOIN KPE_KWH_FLOWMETER AS B 
ON A.KPE_KWH_FLOWMETER_ID=B.KPE_KWH_FLOWMETER_ID 
WHERE B.KPE_KWH_FLOWMETER_TYPE='DEPT' AND A.RECORD_STATUS='A' 
AND B.RECORD_STATUS='A'
AND A.KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."' ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_e;
$result_e = $this->MYSQL->data();

$sql_f = "SELECT KPE_KWH_FLOWMETER_NAMA
FROM KPE_KWH_FLOWMETER WHERE RECORD_STATUS='A' AND KPE_KWH_FLOWMETER_TYPE='DEPT' ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_f;
$result_f = $this->MYSQL->data();

$dateyesterday = Date("Y/m/d",strtotime($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'].'-1 day'));
$sql_g = "SELECT KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,KPE_KWH_HARIAN_ENERGI_SOLAR_ACC,KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC
FROM KPE_KWH_HARIAN_ENERGI WHERE RECORD_STATUS='A' AND KPE_KWH_HARIAN_ENERGI_TANGGAL='".$dateyesterday."' ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_g;
$result_g = $this->MYSQL->data();

$sql_h = "SELECT KPE_KWH_HARIAN_ENERGI_KWH_ACC,KPE_KWH_HARIAN_ENERGI_SOLAR_ACC,KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC
FROM KPE_KWH_HARIAN_ENERGI WHERE RECORD_STATUS='A' AND KPE_KWH_HARIAN_ENERGI_TANGGAL='".$dateyesterday."' 
AND KPE_KWH_FLOWMETER_NAMA='OPERASIONAL TURBIN'
ORDER BY KPE_KWH_FLOWMETER_NAMA ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_h;
$result_h = $this->MYSQL->data()[0];

if (count($result_e) !== (count($result_f))) {
  $this->callback['respon']['pesan'] = "gagal";
  $this->callback['respon']['text_msg'] = "Catatan tanggal ".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']." belum terinput semua, silahkan input semua catatan terlebih dahulu!";
  return false;
}

$bulan = date('m',strtotime($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']));
$tahun = date('Y',strtotime($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']));

if($input['KPE_KWH_DISTRIBUSI_ENERGI_ID']=="")
  {
    $sql_ca = "SELECT KPE_KWH_DISTRIBUSI_ENERGI_ID FROM KPE_KWH_DISTRIBUSI_ENERGI WHERE KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."' AND RECORD_STATUS='A'";

    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_ca;
    $result_ca = $this->MYSQL->data();
    if ($result_ca >= 1) {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Data sudah pernah di input";
    } else {
      for ($i=0; $i < count($result_e); $i++) {
        if ($input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] == '') {
          $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI = 0;
        } else {
          $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI = round($result_e[$i]['KPE_KWH_CATATAN_BEBAN'] * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2);
        }
        if ($input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] == '') {
          $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI = 0;
        } else {
          $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI = round($result_e[$i]['KPE_KWH_CATATAN_BEBAN'] * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2);
        }

        if ($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'] === $tahun.'/'.$bulan.'/01') {

          $data_master_harian = array(
            'KPE_KWH_HARIAN_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
            'KPE_KWH_FLOWMETER_NAMA' => $result_e[$i]['KPE_KWH_FLOWMETER_NAMA'],
            'KPE_KWH_CATATAN_ANGKA' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA'],
            'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA_ESTIMASI'],
            'KPE_KWH_CATATAN_BEBAN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN'],
            'KPE_KWH_CATATAN_BEBAN_X_READING' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'],
            'KPE_KWH_FLOWMETER_READING' => $result_e[$i]['KPE_KWH_FLOWMETER_READING'],
            'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'],
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / ($result_d['BEBAN_DEPT'] + $operasional_turbin) * 100,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,
            'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
            'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
            'RECORD_STATUS' => "A"
          );
    
          $this->MYSQL =new MYSQL;
          $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
          $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
          $this->MYSQL->record = $data_master_harian;
          $this->MYSQL->simpan();
        } else {

          $total_acc_kwh[] += (($result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_KWH_ACC']) + ($operasional_turbin + $result_h['KPE_KWH_HARIAN_ENERGI_KWH_ACC']));
          $sum_acc_kwh = array_sum($total_acc_kwh);

          $data_master_harian = array(
            'KPE_KWH_HARIAN_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
            'KPE_KWH_CATATAN_ANGKA' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA'],
            'KPE_KWH_FLOWMETER_NAMA' => $result_e[$i]['KPE_KWH_FLOWMETER_NAMA'],
            'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA_ESTIMASI'],
            'KPE_KWH_CATATAN_BEBAN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN'],
            'KPE_KWH_CATATAN_BEBAN_X_READING' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'],
            'KPE_KWH_FLOWMETER_READING' => $result_e[$i]['KPE_KWH_FLOWMETER_READING'],
            'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_KWH_ACC'],
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => ($result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_KWH_ACC']) / ($sum_acc_kwh) * 100,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_SOLAR_ACC'],
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC'],
            'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
            'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
            'RECORD_STATUS' => "A"
          );
    
          $this->MYSQL =new MYSQL;
          $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
          $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
          $this->MYSQL->record = $data_master_harian;
          $this->MYSQL->simpan();
        }
      }
      
      if ($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'] === $tahun.'/'.$bulan.'/01') {
        $data_master_harian_opn = array(
          'KPE_KWH_HARIAN_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
          'KPE_KWH_CATATAN_ANGKA' => "",
          'KPE_KWH_FLOWMETER_NAMA' => "OPERASIONAL TURBIN",
          'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => "",
          'KPE_KWH_CATATAN_BEBAN' => "",
          'KPE_KWH_FLOWMETER_READING' => "",
          'KPE_KWH_CATATAN_BEBAN_X_READING' => $operasional_turbin,
          'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $operasional_turbin,
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => $operasional_turbin / ($result_d['BEBAN_DEPT'] + $operasional_turbin) * 100,
          'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
          'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
          'RECORD_STATUS' => "A"
        );
  
        $this->MYSQL =new MYSQL;
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
        $this->MYSQL->record = $data_master_harian_opn;
        $this->MYSQL->simpan();
      } else {
        $data_master_harian_opn = array(
          'KPE_KWH_HARIAN_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
          'KPE_KWH_CATATAN_ANGKA' => "",
          'KPE_KWH_FLOWMETER_NAMA' => "OPERASIONAL TURBIN",
          'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => "",
          'KPE_KWH_CATATAN_BEBAN' => "",
          'KPE_KWH_FLOWMETER_READING' => "",
          'KPE_KWH_CATATAN_BEBAN_X_READING' => $operasional_turbin,
          'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $operasional_turbin + $result_h['KPE_KWH_HARIAN_ENERGI_KWH_ACC'],
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => ($operasional_turbin + $result_h['KPE_KWH_HARIAN_ENERGI_KWH_ACC']) / ($sum_acc_kwh) * 100,
          'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => round((($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100) + $result_h['KPE_KWH_HARIAN_ENERGI_SOLAR_ACC'],2),
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => round((($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100) + $result_h['KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC'],2),
          'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
          'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
          'RECORD_STATUS' => "A"
        );
  
        $this->MYSQL =new MYSQL;
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
        $this->MYSQL->record = $data_master_harian_opn;
        $this->MYSQL->simpan();
      }
      
      $data_master = array(
        'KPE_KWH_DISTRIBUSI_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
        'KPE_KWH_DISTRIBUSI_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
        'KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
        'KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN' => $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN,
        'KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI' => $KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI,
        'KPE_KWH_DISTRIBUSI_ENERGI_TURBIN' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TURBIN'],
        'KPE_KWH_DISTRIBUSI_ENERGI_POWERHOUSE' => $input['KPE_KWH_DISTRIBUSI_ENERGI_POWERHOUSE'],
        'KPE_KWH_DISTRIBUSI_ENERGI_SELISIH' => $KPE_KWH_DISTRIBUSI_ENERGI_SELISIH,
        'KPE_KWH_DISTRIBUSI_ENERGI_SOLAR' => $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'],
        'KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA' => $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'],
        'KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN' => $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
        'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
        'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
        'RECORD_STATUS' => "A"
      );

      $this->MYSQL =new MYSQL;
      $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->tabel ="KPE_KWH_DISTRIBUSI_ENERGI";
      $this->MYSQL->record = $data_master;

      if ($this->MYSQL->simpan() == true)
      {
        
          $this->callback['respon']['pesan']="sukses";
          $this->callback['respon']['text_msg']="Data berhasil disimpan";
          $this->callback['result']=array("opn" => $operasional_turbin,"totalpersen" => $persen_kwh,"total" => ($persen_kwh + $operasional_turbin), "acc" => $data_master_harian);
      }
      else
      {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Data gagal disimpan";
      }
    }
  }else 
  {
    $data_master_edit_harian = array(
      
      'EDIT_WAKTU' => date("Y-m-d H:i:s"),
      'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
      'RECORD_STATUS' => "E"
    );

    $this->MYSQL =new MYSQL;
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
    $this->MYSQL->record = $data_master_edit_harian;
    $this->MYSQL->dimana = "WHERE KPE_KWH_HARIAN_ENERGI_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL']."' AND (RECORD_STATUS='A')";

    if ($this->MYSQL->ubah() == true) {
      
      for ($i=0; $i < count($result_e); $i++) {
        if ($input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] == '') {
          $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI = 0;
        } else {
          $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI = round($input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] * $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / 100,2);
        }

        if ($input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] == '') {
          $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI = 0;
        } else {
          $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI = round($result_e[$i]['KPE_KWH_CATATAN_BEBAN'] * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2);
        }
  
        if ($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'] === $tahun.'/'.$bulan.'/01') {
          $data_master_harian = array(
            'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
            'KPE_KWH_CATATAN_ANGKA' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA'],
            'KPE_KWH_FLOWMETER_NAMA' => $result_e[$i]['KPE_KWH_FLOWMETER_NAMA'],
            'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA_ESTIMASI'],
            'KPE_KWH_CATATAN_BEBAN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN'],
            'KPE_KWH_CATATAN_BEBAN_X_READING' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'],
            'KPE_KWH_FLOWMETER_READING' => $result_e[$i]['KPE_KWH_FLOWMETER_READING'],
            'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'],
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / ($result_d['BEBAN_DEPT'] + $operasional_turbin) * 100,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,
            'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
            'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
            'RECORD_STATUS' => "A"
          );
    
          $this->MYSQL =new MYSQL;
          $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
          $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
          $this->MYSQL->record = $data_master_harian;
          $this->MYSQL->simpan();
        } else {
          $data_master_harian = array(
            'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
            'KPE_KWH_CATATAN_ANGKA' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA'],
            'KPE_KWH_FLOWMETER_NAMA' => $result_e[$i]['KPE_KWH_FLOWMETER_NAMA'],
            'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => $result_e[$i]['KPE_KWH_CATATAN_ANGKA_ESTIMASI'],
            'KPE_KWH_CATATAN_BEBAN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN'],
            'KPE_KWH_CATATAN_BEBAN_X_READING' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'],
            'KPE_KWH_FLOWMETER_READING' => $result_e[$i]['KPE_KWH_FLOWMETER_READING'],
            'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_KWH_ACC'],
            'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => ($result_e[$i]['KPE_KWH_CATATAN_BEBAN_X_READING'] + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_KWH_ACC']) / ($sum_acc_kwh) * 100,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => $KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_SOLAR_ACC'],
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI,
            'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => $KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI + $result_g[$i]['KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC'],
            'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
            'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
            'RECORD_STATUS' => "A"
          );
    
          $this->MYSQL =new MYSQL;
          $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
          $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
          $this->MYSQL->record = $data_master_harian;
          $this->MYSQL->simpan();
        }
      }

      if ($input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'] === $tahun.'/'.$bulan.'/01') {
        $data_master_harian_opn = array(
          'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
          'KPE_KWH_CATATAN_ANGKA' => "",
          'KPE_KWH_FLOWMETER_NAMA' => "OPERASIONAL TURBIN",
          'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => "",
          'KPE_KWH_CATATAN_BEBAN' => "",
          'KPE_KWH_FLOWMETER_READING' => "",
          'KPE_KWH_CATATAN_BEBAN_X_READING' => $operasional_turbin,
          'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $operasional_turbin,
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => $operasional_turbin / ($result_d['BEBAN_DEPT'] + $operasional_turbin) * 100,
          'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
          'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
          'RECORD_STATUS' => "A"
        );
  
        $this->MYSQL =new MYSQL;
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
        $this->MYSQL->record = $data_master_harian_opn;
        $this->MYSQL->simpan();
      } else {
        $data_master_harian_opn = array(
          'KPE_KWH_HARIAN_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_KWH_HARIAN_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
          'KPE_KWH_CATATAN_ANGKA' => "",
          'KPE_KWH_FLOWMETER_NAMA' => "OPERASIONAL TURBIN",
          'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => "",
          'KPE_KWH_CATATAN_BEBAN' => "",
          'KPE_KWH_FLOWMETER_READING' => "",
          'KPE_KWH_CATATAN_BEBAN_X_READING' => $operasional_turbin,
          'KPE_KWH_HARIAN_ENERGI_KWH_PERSEN' => $operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100,
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC' => $operasional_turbin + $result_h['KPE_KWH_HARIAN_ENERGI_KWH_ACC'],
          'KPE_KWH_HARIAN_ENERGI_KWH_ACC_PERSEN' => ($operasional_turbin + $result_h['KPE_KWH_HARIAN_ENERGI_KWH_ACC']) / ($sum_acc_kwh) * 100,
          'KPE_KWH_HARIAN_ENERGI_SOLAR_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_SOLAR_ACC' => round((($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'] / 100) + $result_h['KPE_KWH_HARIAN_ENERGI_SOLAR_ACC'],2),
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_PAKAI' => round(($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100,2) + $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
          'KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC' => round((($operasional_turbin / $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN * 100) * $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'] / 100) + $result_h['KPE_KWH_HARIAN_ENERGI_BATU_BARA_ACC'],2),
          'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
          'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
          'RECORD_STATUS' => "A"
        );
  
        $this->MYSQL =new MYSQL;
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->tabel ="KPE_KWH_HARIAN_ENERGI";
        $this->MYSQL->record = $data_master_harian_opn;
        $this->MYSQL->simpan();
      }
    }

    $data_master_edit = array(
      
      'EDIT_WAKTU' => date("Y-m-d H:i:s"),
      'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
      'RECORD_STATUS' => "E"
    );

    $this->MYSQL =new MYSQL;
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->tabel ="KPE_KWH_DISTRIBUSI_ENERGI";
    $this->MYSQL->record = $data_master_edit;
    $this->MYSQL->dimana = "WHERE KPE_KWH_DISTRIBUSI_ENERGI_ID='".$input['KPE_KWH_DISTRIBUSI_ENERGI_ID']."' AND (RECORD_STATUS='A')";

    if ($this->MYSQL->ubah() == true)
    {
      $data_master = array(
        'KPE_KWH_DISTRIBUSI_ENERGI_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
        'KPE_KWH_DISTRIBUSI_ENERGI_ID' => $input['KPE_KWH_DISTRIBUSI_ENERGI_ID'],
        'KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TANGGAL'],
        'KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN' => $KPE_KWH_DISTRIBUSI_ENERGI_PEMBEBANAN,
        'KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI' => $KPE_KWH_DISTRIBUSI_ENERGI_DISTRIBUSI,
        'KPE_KWH_DISTRIBUSI_ENERGI_TURBIN' => $input['KPE_KWH_DISTRIBUSI_ENERGI_TURBIN'],
        'KPE_KWH_DISTRIBUSI_ENERGI_POWERHOUSE' => $input['KPE_KWH_DISTRIBUSI_ENERGI_POWERHOUSE'],
        'KPE_KWH_DISTRIBUSI_ENERGI_SELISIH' => $KPE_KWH_DISTRIBUSI_ENERGI_SELISIH,
        'KPE_KWH_DISTRIBUSI_ENERGI_SOLAR' => $input['KPE_KWH_DISTRIBUSI_ENERGI_SOLAR'],
        'KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA' => $input['KPE_KWH_DISTRIBUSI_ENERGI_BATU_BARA'],
        'KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN' => $input['KPE_KWH_DISTRIBUSI_ENERGI_OPERASIONAL_TURBIN_PENGKONDISIAN'],
        'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
        'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
        'RECORD_STATUS' => "A"
      );

      $this->MYSQL =new MYSQL;
      $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->tabel ="KPE_KWH_DISTRIBUSI_ENERGI";
      $this->MYSQL->record = $data_master;

      if ($this->MYSQL->simpan() == true)
        {
          
            $this->callback['respon']['pesan']="sukses";
            $this->callback['respon']['text_msg']="Berhasil Mengubah";
            $this->callback['result']=$result;
        }
        else
        {
        $this->callback['respon']['pesan'] = "gagal";
        $this->callback['respon']['text_msg'] = "Gagal Mengubah";
        }
    }else {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Gagal Mengubah";
    }
  }
		
		


?>
