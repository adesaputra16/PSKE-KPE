<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}

  $input = $params['input_option'];

    $sql_a = "SELECT a.KPE_AIR_FLOWMETER_ID,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN,a.KPE_AIR_FLOWMETER_NAMA FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID WHERE b.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL']."' AND a.RECORD_STATUS='A' AND b.RECORD_STATUS='A'";
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_a;
    $result_a = $this->MYSQL->data();

    $sql_c = "SELECT SUM(a.KPE_AIR_FLOWMETER_CATATAN_BEBAN) AS KPE_AIR_FLOWMETER_CATATAN_BEBAN FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID WHERE b.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='RO' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL']."' AND a.RECORD_STATUS='A' AND b.RECORD_STATUS='A'";
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_c;
    $result_c = $this->MYSQL->data();

    $sql_ca = "SELECT KPE_AIR_FLOWMETER_REKAP_USED_RO_ID FROM KPE_AIR_FLOWMETER_REKAP_USED_RO WHERE KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL']."' AND RECORD_STATUS='A'";

    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_ca;
    $result_ca = $this->MYSQL->data();
    if ($result_ca >= 1) {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Data ditanggal ini sudah di rekap";
    } else {
      foreach ($result_a as $r) {
        $sql_b = "SELECT KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA,KPE_AIR_FLOWMETER_ID FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$input['KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL']."' AND KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";
        $this->MYSQL = new MYSQL();
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->queri = $sql_b;
        $result_b = $this->MYSQL->data();

        if(count($result_b) >= 1) {
          foreach ($result_b as $rb) {
            $data_master_dept = array(
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL' => $input['KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL'],
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_CODDING' => $input['KPE_AIR_FLOWMETER_REKAP_USED_RO_CODDING'],
              'KPE_AIR_FLOWMETER_ID' => $rb['KPE_AIR_FLOWMETER_ID'],
              'KPE_AIR_FLOWMETER_NAMA' => $rb['KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA'],
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_BEBAN' => $rb['KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN'],
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_TOTAL' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_BEBAN'],
              'KPE_AIR_FLOWMETER_REKAP_USED_RO_RATA_RATA' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_BEBAN']/count($result_a),
              'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
              'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
              'RECORD_STATUS' => "A"
            );
            $this->MYSQL =new MYSQL;
            $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
            $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_REKAP_USED_RO";
            $this->MYSQL->record = $data_master_dept;
            $this->MYSQL->simpan();
          }
        } else {
          $data_master = array(
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL' => $input['KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL'],
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_CODDING' => $input['KPE_AIR_FLOWMETER_REKAP_USED_RO_CODDING'],
            'KPE_AIR_FLOWMETER_ID' => $r['KPE_AIR_FLOWMETER_ID'],
            'KPE_AIR_FLOWMETER_NAMA' => $r['KPE_AIR_FLOWMETER_NAMA'],
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_BEBAN' => $r['KPE_AIR_FLOWMETER_CATATAN_BEBAN'],
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_TOTAL' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_BEBAN'],
            'KPE_AIR_FLOWMETER_REKAP_USED_RO_RATA_RATA' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_BEBAN']/count($result_a),
            'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
            'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
            'RECORD_STATUS' => "A"
          );
          $this->MYSQL =new MYSQL;
          $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
          $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_REKAP_USED_RO";
          $this->MYSQL->record = $data_master;
          // $this->MYSQL->simpan();
        
          if ($this->MYSQL->simpan() == true)
          {
            
            $this->callback['respon']['pesan']="sukses";
            $this->callback['respon']['text_msg']="Berhasil di rekap";
            $this->callback['result']=$sql_b;
          }
          else
          {
            $this->callback['respon']['pesan'] = "gagal";
            $this->callback['respon']['text_msg'] = "Gagal di rekap";
          }
        }
      }
      
    }
  
		
?>
