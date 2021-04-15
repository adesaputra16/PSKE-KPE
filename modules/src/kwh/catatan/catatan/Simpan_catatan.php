<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}


		$input = $params['input_option'];

    if ($input['KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN'] == "") {
      $KPE_KWH_CATATAN_BEBAN = $input['KPE_KWH_CATATAN_PAKAI'];
    } else {
      $KPE_KWH_CATATAN_BEBAN = $input['KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN'];
    }

		$sql_rd = "SELECT KPE_KWH_FLOWMETER_READING FROM KPE_KWH_FLOWMETER WHERE KPE_KWH_FLOWMETER_ID='".$input['KPE_KWH_FLOWMETER_ID']."' AND RECORD_STATUS='A'";

		$this->MYSQL = new MYSQL();
		$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri = $sql_rd;
		$result_rd = $this->MYSQL->data()[0];

		$KPE_KWH_CATATAN_BEBAN_X_READING = $KPE_KWH_CATATAN_BEBAN * $result_rd['KPE_KWH_FLOWMETER_READING'];

		$KPE_KWH_CATATAN_ANGKA_ESTIMASI = $input['KPE_KWH_CATATAN_ANGKA'] + $KPE_KWH_CATATAN_BEBAN;
	
		if($input['KPE_KWH_CATATAN_ID']=="")
		{
			$sql_ca = "SELECT KPE_KWH_CATATAN_TANGGAL FROM KPE_KWH_CATATAN WHERE KPE_KWH_FLOWMETER_ID='".$input['KPE_KWH_FLOWMETER_ID']."' AND RECORD_STATUS='A' AND KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_CATATAN_TANGGAL']."'";

			$this->MYSQL = new MYSQL();
			$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri = $sql_ca;
			$result_ca = $this->MYSQL->data();
			if ($result_ca >= 1) {
				$this->callback['respon']['pesan'] = "gagal";
				$this->callback['respon']['text_msg'] = "Catatan ditanggal ini sudah pernah di input";
			} else {
				$data_master = array(
					'KPE_KWH_CATATAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_KWH_CATATAN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_KWH_FLOWMETER_ID' => $input['KPE_KWH_FLOWMETER_ID'],
					'KPE_KWH_FLOWMETER_READING' => $input['KPE_KWH_FLOWMETER_READING'],
					'KPE_KWH_FLOWMETER_NAMA' => base64_decode($input['KPE_KWH_FLOWMETER_NAMA']),
					'KPE_KWH_CATATAN_TANGGAL' => $input['KPE_KWH_CATATAN_TANGGAL'],
					'KPE_KWH_CATATAN_ANGKA' => $input['KPE_KWH_CATATAN_ANGKA'],
					'KPE_KWH_CATATAN_ANGKA_ESTIMASI' => $KPE_KWH_CATATAN_ANGKA_ESTIMASI,
					'KPE_KWH_CATATAN_PAKAI' => $input['KPE_KWH_CATATAN_PAKAI'],
					'KPE_KWH_CATATAN_BEBAN' => $KPE_KWH_CATATAN_BEBAN,
					'KPE_KWH_CATATAN_BEBAN_X_READING' => $KPE_KWH_CATATAN_BEBAN_X_READING,
					'KPE_KWH_CATATAN_PENGKONDISIAN' => $input['KPE_KWH_CATATAN_PENGKONDISIAN'],
					'KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN' => $input['KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN'],
					'KPE_KWH_CATATAN_ANGKA' => $input['KPE_KWH_CATATAN_ANGKA'],
					'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
					'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
					'RECORD_STATUS' => "A"
				);
	
				$this->MYSQL =new MYSQL;
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel ="KPE_KWH_CATATAN";
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
			}
		}else 
		{
			/*===== Edit catatan flowmeter =====*/
			$data_master_edit = array(
				
				'EDIT_WAKTU' => date("Y-m-d H:i:s"),
				'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
				'RECORD_STATUS' => "E"
			);

			$this->MYSQL =new MYSQL;
			$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN";
			$this->MYSQL->record = $data_master_edit;
			$this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_CATATAN_ID='".$input['KPE_AIR_FLOWMETER_CATATAN_ID']."' AND RECORD_STATUS='A'";

			if ($this->MYSQL->ubah() == true)
			{
				$data_master_ubah = array(
					'KPE_KWH_CATATAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_KWH_CATATAN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_KWH_FLOWMETER_ID' => $input['KPE_KWH_FLOWMETER_ID'],
					'KPE_KWH_FLOWMETER_READING' => $input['KPE_KWH_FLOWMETER_READING'],
					'KPE_KWH_FLOWMETER_NAMA' => base64_decode($input['KPE_KWH_FLOWMETER_NAMA']),
					'KPE_KWH_CATATAN_TANGGAL' => $input['KPE_KWH_CATATAN_TANGGAL'],
					'KPE_KWH_CATATAN_ANGKA' => $input['KPE_KWH_CATATAN_ANGKA'],
					'KPE_KWH_CATATAN_PAKAI' => $input['KPE_KWH_CATATAN_PAKAI'],
					'KPE_KWH_CATATAN_BEBAN' => $KPE_KWH_CATATAN_BEBAN,
					'KPE_KWH_CATATAN_BEBAN_X_READING' => $KPE_KWH_CATATAN_BEBAN_X_READING,
					'KPE_KWH_CATATAN_PENGKONDISIAN' => $input['KPE_KWH_CATATAN_PENGKONDISIAN'],
					'KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN' => $input['KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN'],
					'KPE_KWH_CATATAN_ANGKA' => $input['KPE_KWH_CATATAN_ANGKA'],
					'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
					'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
					'RECORD_STATUS' => "A"
				);
	
				$this->MYSQL =new MYSQL;
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel ="KPE_KWH_CATATAN";
				$this->MYSQL->record = $data_master_ubah;
	
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
		/*===== End edit catatan flowmeter =====*/
		
		


?>
