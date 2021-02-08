<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }


$input = $params['input_option'];
$sql_f = "SELECT * FROM KPE_AIR_FLOWMETER WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA DESC LIMIT 1";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_f;
$result_f = $this->MYSQL->data();

if($input['KPE_AIR_FLOWMETER_DEPARTEMEN_ID']=="")
{
  $this->callback['respon']['pesan'] = "gagal";
  $this->callback['respon']['text_msg'] = "Data tidak di temukan";
} else 
{
  $data_master_flow_edit = array(
    'EDIT_WAKTU' => date("Y-m-d H:i:s"),
    'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "E"
  );

  $this->MYSQL =new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel ="KPE_AIR_FLOWMETER";
  $this->MYSQL->record = $data_master_flow_edit;
  $this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
      
  if ($this->MYSQL->ubah() == true)
  {
    $data_master_flow = array(
      'KPE_AIR_FLOWMETER_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
      'KPE_AIR_FLOWMETER_ID' => $result_f[0]['KPE_AIR_FLOWMETER_ID'],
      'KPE_AIR_FLOWMETER_NAMA' => $result_f[0]['KPE_AIR_FLOWMETER_NAMA'],
      'KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA' => '',
      'KPE_AIR_FLOWMETER_PERIODE' => $result_f[0]['KPE_AIR_FLOWMETER_PERIODE'],
      'KPE_AIR_FLOWMETER_SUB_ID' => $result_f[0]['KPE_AIR_FLOWMETER_SUB_ID'],
      'KPE_AIR_FLOWMETER_SUB_NAMA' => $result_f[0]['KPE_AIR_FLOWMETER_SUB_NAMA'],
      'KPE_AIR_FLOWMETER_LOKASI' => $result_f[0]['KPE_AIR_FLOWMETER_LOKASI'],
      'KPE_AIR_FLOWMETER_DISTRIBUSI' => $result_f[0]['KPE_AIR_FLOWMETER_DISTRIBUSI'],
      'KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE' => $result_f[0]['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE'],
      'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
      'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
      'RECORD_STATUS' => "A"
    );

    $this->MYSQL =new MYSQL;
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->tabel ="KPE_AIR_FLOWMETER";
    $this->MYSQL->record = $data_master_flow;
    $this->MYSQL->simpan();

  }

  $data_master_edit_flow = array(  
    'HAPUS_WAKTU' => date("Y-m-d H:i:s"),
    'HAPUS_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "D"
  );

  $this->MYSQL =new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW";
  $this->MYSQL->record = $data_master_edit_flow;
  $this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."'AND RECORD_STATUS='A'";
  $this->MYSQL->ubah() == true;

  $data_master_edit = array(  
    'HAPUS_WAKTU' => date("Y-m-d H:i:s"),
    'HAPUS_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "D"
  );

  $this->MYSQL =new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_DEPARTEMEN";
  $this->MYSQL->record = $data_master_edit;
  $this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_DEPARTEMEN_ID='".$input['KPE_AIR_FLOWMETER_DEPARTEMEN_ID']."'AND RECORD_STATUS='A'";

  if ($this->MYSQL->ubah() == true)
  {
    $this->callback['respon']['pesan']="sukses";
    $this->callback['respon']['text_msg']="Berhasil Menghapus";
    $this->callback['result']=$result;
  } else {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Gagal Menghapus";
  }
}

?>
