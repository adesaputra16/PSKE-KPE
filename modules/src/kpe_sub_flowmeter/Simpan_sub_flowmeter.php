<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}

  $input = $params['input_option'];
  if($input['KPE_AIR_FLOWMETER_SUB_ID']=="")
  {
    $data_master = array(
      'KPE_AIR_FLOWMETER_SUB_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
      'KPE_AIR_FLOWMETER_SUB_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
      'KPE_AIR_FLOWMETER_SUB_NAMA' => $input['KPE_AIR_FLOWMETER_SUB_NAMA'],
      'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
      'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
      'RECORD_STATUS' => "A"
    );

    $this->MYSQL =new MYSQL;
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_SUB";
    $this->MYSQL->record = $data_master;

    if ($this->MYSQL->simpan() == true)
      {
        
          $this->callback['respon']['pesan']="sukses";
          $this->callback['respon']['text_msg']="Berhasil Simpan";
          $this->callback['result']=$result;
      }
      else
      {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Gagal Simpan";
      }
  }else 
  {
    $data_master_edit = array(
      
      'EDIT_WAKTU' => date("Y-m-d H:i:s"),
      'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
      'RECORD_STATUS' => "E"
    );

    $this->MYSQL =new MYSQL;
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_SUB";
    $this->MYSQL->record = $data_master_edit;
    $this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_SUB_ID='".$input['KPE_AIR_FLOWMETER_SUB_ID']."' AND (RECORD_STATUS='A')";

    if ($this->MYSQL->ubah() == true)
    {
      $data_master = array(
        'KPE_AIR_FLOWMETER_SUB_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
        'KPE_AIR_FLOWMETER_SUB_ID' => $input['KPE_AIR_FLOWMETER_SUB_ID'],
        'KPE_AIR_FLOWMETER_SUB_NAMA' => $input['KPE_AIR_FLOWMETER_SUB_NAMA'],
        'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
        'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
        'RECORD_STATUS' => "A"
      );

      $this->MYSQL =new MYSQL;
      $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_SUB";
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
