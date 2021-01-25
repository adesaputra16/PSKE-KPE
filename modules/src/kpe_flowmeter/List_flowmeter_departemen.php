<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

  $input = $params['input_option'];

  if ($input['KPE_AIR_FLOWMETER_ID'] == "") {
    $sql_d = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE,
          KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_ID
          FROM KPE_AIR_FLOWMETER_DEPARTEMEN
          WHERE RECORD_STATUS='A'";
  } else {
    $sql_d = "SELECT KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA
          FROM KPE_AIR_FLOWMETER
          WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."'";
  }
  
// $sql_d = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE,
//           KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_ID
//           FROM KPE_AIR_FLOWMETER_DEPARTEMEN
//           WHERE RECORD_STATUS='A'";
// $sql_d = "SELECT KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA
//           FROM KPE_AIR_FLOWMETER
//           WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_a = $this->MYSQL->data();

// -- >>

$no = $posisi + 1;
$periode = substr($input['KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE'],0,7);

foreach($result_a as $r)
{
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_e = "SELECT KPE_AIR_FLOWMETER_CATATAN_ID,KPE_AIR_FLOWMETER_CATATAN_ANGKA,KPE_AIR_FLOWMETER_CATATAN_TANGGAL,KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS,
                        KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL,KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH,
                        KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN,KPE_AIR_FLOWMETER_CATATAN_KALIBRASI
                        FROM KPE_AIR_FLOWMETER_CATATAN
                        WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."'";
  $this->MYSQL->queri = $sql_e;                      
  $result_c=$this->MYSQL->data()[0]; 

  // $this->MYSQL=new MYSQL();
  // $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  // $sql_d = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL,
  //                 KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL,KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN,
  //                 KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE,KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL
  //                 FROM KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW
  //                 WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA='".$input['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA']."' AND KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE='".$periode."'";
  // $this->MYSQL->queri = $sql_d;                      
  // $result_d=$this->MYSQL->data()[0]; 

  // $r['DEPT'] = $result_d;
  $r['CATATAN'] = $result_c;
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
    // $this->callback['tes'] = $sql_d;

    }

?>
