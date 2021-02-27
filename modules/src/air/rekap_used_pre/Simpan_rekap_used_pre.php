<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}

  $input = $params['input_option'];

    $sql_a = "SELECT a.KPE_AIR_FLOWMETER_ID,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN,a.KPE_AIR_FLOWMETER_NAMA FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID WHERE b.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL']."' AND a.RECORD_STATUS='A' AND b.RECORD_STATUS='A'";
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_a;
    $result_a = $this->MYSQL->data();

    $sql_c = "SELECT SUM(a.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS KPE_AIR_FLOWMETER_CATATAN_BEBAN FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID WHERE b.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='PRE' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL']."' AND a.RECORD_STATUS='A' AND b.RECORD_STATUS='A'";
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_c;
    $result_c = $this->MYSQL->data();

    $sql_ca = "SELECT KPE_AIR_FLOWMETER_REKAP_USED_PRE_ID FROM KPE_AIR_FLOWMETER_REKAP_USED_PRE WHERE KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL']."' AND RECORD_STATUS='A'";

    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_ca;
    $result_ca = $this->MYSQL->data();
    if ($result_ca >= 1) {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Data ditanggal ini sudah di rekap";
    } else {
      foreach ($result_a as $r) {
        $data_master = array(
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL' => $input['KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL'],
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING' => $input['KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING'],
          'KPE_AIR_FLOWMETER_ID' => $r['KPE_AIR_FLOWMETER_ID'],
          'KPE_AIR_FLOWMETER_NAMA' => $r['KPE_AIR_FLOWMETER_NAMA'],
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_BEBAN' => $r['KPE_AIR_FLOWMETER_CATATAN_BEBAN'],
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_TOTAL' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_BEBAN'],
          'KPE_AIR_FLOWMETER_REKAP_USED_PRE_RATA_RATA' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_BEBAN']/count($result_a),
          'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
          'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
          'RECORD_STATUS' => "A"
        );
        $this->MYSQL =new MYSQL;
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_REKAP_USED_PRE";
        $this->MYSQL->record = $data_master;
        // $this->MYSQL->simpan();
        if ($this->MYSQL->simpan() == true)
        {
          
          $this->callback['respon']['pesan']="sukses";
          $this->callback['respon']['text_msg']="Berhasil di rekap";
          $this->callback['result']=$result;
        }
        else
        {
          $this->callback['respon']['pesan'] = "gagal";
          $this->callback['respon']['text_msg'] = "Gagal di rekap";
        }
      }
      
    }
  
		
?>
