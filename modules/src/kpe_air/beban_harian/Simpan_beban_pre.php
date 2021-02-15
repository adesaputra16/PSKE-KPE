<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}


			$input = $params['input_option'];

      $sql_ca = "SELECT KPE_AIR_FLOWMETER_BEBAN_ID FROM KPE_AIR_FLOWMETER_BEBAN_BULANAN WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_BEBAN_PERIODE='".$input['KPE_AIR_FLOWMETER_BEBAN_PERIODE']."' AND RECORD_STATUS='A'";

      $this->MYSQL = new MYSQL();
      $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
      $this->MYSQL->queri = $sql_ca;
      $result_ca = $this->MYSQL->data();

      $KPE_AIR_FLOWMETER_BEBAN_PROSES_B = $input['KPE_AIR_FLOWMETER_BEBAN_PROSES_A'] * $input['BEBAN_AVRG'] / 100;
      $KPE_AIR_FLOWMETER_BEBAN_PRODUK_B = $input['KPE_AIR_FLOWMETER_BEBAN_PRODUK_A'] * $input['BEBAN_AVRG'] / 100;
      $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A = 100 - $input['KPE_AIR_FLOWMETER_BEBAN_PROSES_A'] - $input['KPE_AIR_FLOWMETER_BEBAN_PRODUK_A'];
      $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B = $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A * $input['BEBAN_AVRG'] / 100;
        
			if($result_ca == 0)
			{
        $data_master = array(
          'KPE_AIR_FLOWMETER_BEBAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_AIR_FLOWMETER_BEBAN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
          'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
          'KPE_AIR_FLOWMETER_NAMA' => $input['KPE_AIR_FLOWMETER_NAMA'],
          'KPE_AIR_FLOWMETER_BEBAN_PERIODE' => $input['KPE_AIR_FLOWMETER_BEBAN_PERIODE'],
          'KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A' => $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A,
          'KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B' => $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B,
          'KPE_AIR_FLOWMETER_BEBAN_PRODUK_A' => $input['KPE_AIR_FLOWMETER_BEBAN_PRODUK_A'],
          'KPE_AIR_FLOWMETER_BEBAN_PRODUK_B' => $KPE_AIR_FLOWMETER_BEBAN_PRODUK_B,
          'KPE_AIR_FLOWMETER_BEBAN_PROSES_A' => $input['KPE_AIR_FLOWMETER_BEBAN_PROSES_A'],
          'KPE_AIR_FLOWMETER_BEBAN_PROSES_B' => $KPE_AIR_FLOWMETER_BEBAN_PROSES_B,
          'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
          'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
          'RECORD_STATUS' => "A"
        );
  
        $this->MYSQL =new MYSQL;
        $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
        $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_BEBAN_BULANAN";
        $this->MYSQL->record = $data_master;
  
        if ($this->MYSQL->simpan() == true)
        {        
          $this->callback['respon']['pesan']="sukses";
          $this->callback['respon']['text_msg']="Data Berhasil Disimpan";
          $this->callback['result']=$result;
        }
        else
        {
          $this->callback['respon']['pesan'] = "gagal";
          $this->callback['respon']['text_msg'] = "Data Gagal Disimpan";
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
				$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_BEBAN_BULANAN";
				$this->MYSQL->record = $data_master_edit;
				$this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_BEBAN_PERIODE='".$input['KPE_AIR_FLOWMETER_BEBAN_PERIODE']."' AND RECORD_STATUS='A'";
	
				if ($this->MYSQL->ubah() == true)
				{
					$data_edit_master = array(
						'KPE_AIR_FLOWMETER_BEBAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_AIR_FLOWMETER_BEBAN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
            'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
            'KPE_AIR_FLOWMETER_NAMA' => $input['KPE_AIR_FLOWMETER_NAMA'],
            'KPE_AIR_FLOWMETER_BEBAN_PERIODE' => $input['KPE_AIR_FLOWMETER_BEBAN_PERIODE'],
            'KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A' => $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A,
            'KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B' => $KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B,
            'KPE_AIR_FLOWMETER_BEBAN_PRODUK_A' => $input['KPE_AIR_FLOWMETER_BEBAN_PRODUK_A'],
            'KPE_AIR_FLOWMETER_BEBAN_PRODUK_B' => $KPE_AIR_FLOWMETER_BEBAN_PRODUK_B,
            'KPE_AIR_FLOWMETER_BEBAN_PROSES_A' => $input['KPE_AIR_FLOWMETER_BEBAN_PROSES_A'],
            'KPE_AIR_FLOWMETER_BEBAN_PROSES_B' => $KPE_AIR_FLOWMETER_BEBAN_PROSES_B,
            'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
            'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
            'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_BEBAN_BULANAN";
					$this->MYSQL->record = $data_edit_master;
		
					if ($this->MYSQL->simpan() == true)
						{
							
								$this->callback['respon']['pesan']="sukses";
								$this->callback['respon']['text_msg']="Data Berhasil Diubah";
								$this->callback['result']=$result;
						}
						else
						{
						$this->callback['respon']['pesan'] = "gagal";
						$this->callback['respon']['text_msg'] = "Data Gagal Diubah";
						}
				}else {
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Data Gagal Diubah";
				}
			}
		
		


?>
