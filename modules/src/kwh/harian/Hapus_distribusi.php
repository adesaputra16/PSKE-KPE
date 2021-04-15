<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }


$input = $params['input_option'];

if($input['KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID']=="")
{
  $this->callback['respon']['pesan'] = "gagal";
  $this->callback['respon']['text_msg'] = "Data tidak di temukan";
} else 
{
  $data_master_edit = array(  
    'HAPUS_WAKTU' => date("Y-m-d H:i:s"),
    'HAPUS_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "D"
  );

  $this->MYSQL =new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel ="KPE_KWH_DISTRIBUSI_SOLAR_KWH";
  $this->MYSQL->record = $data_master_edit;
  $this->MYSQL->dimana = "WHERE KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID='".$input['KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->ubah();
  
  $data_master_harian = array(  
    'HAPUS_WAKTU' => date("Y-m-d H:i:s"),
    'HAPUS_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "D"
  );

  $this->MYSQL =new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel ="KPE_KWH_HARIAN_SOLAR_KWH";
  $this->MYSQL->record = $data_master_harian;
  $this->MYSQL->dimana = "WHERE KPE_KWH_HARIAN_SOLAR_KWH_TANGGAL='".$input['KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL']."' AND RECORD_STATUS='A'";

  if ($this->MYSQL->ubah() == true)
  {
    $this->callback['respon']['pesan']="sukses";
    $this->callback['respon']['text_msg']="Data berhasil dihapus";
    $this->callback['result']=$result;
  } else {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data gagal dihapus";
  }
}

?>
