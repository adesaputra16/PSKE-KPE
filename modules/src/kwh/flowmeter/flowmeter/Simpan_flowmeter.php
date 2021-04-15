<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}

			if($input['KPE_KWH_FLOWMETER_ID']=="")
			{
				$sql_ca = "SELECT KPE_KWH_FLOWMETER_ID FROM KPE_KWH_FLOWMETER WHERE KPE_KWH_FLOWMETER_NAMA='".$input['KPE_KWH_FLOWMETER_NAMA']."' AND RECORD_STATUS='A'";

				$this->MYSQL = new MYSQL();
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri = $sql_ca;
				$result_ca = $this->MYSQL->data();
				if ($result_ca >= 1) {
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Flowmeter sudah pernah di input";
				} else {
					$data_master = array(
						'KPE_KWH_FLOWMETER_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_KWH_FLOWMETER_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_KWH_FLOWMETER_NAMA' => $input['KPE_KWH_FLOWMETER_NAMA'],
						'KPE_KWH_SUB_FLOWMETER_ID' => $input['KPE_KWH_SUB_FLOWMETER_ID'],
						'KPE_KWH_SUB_FLOWMETER_NAMA' => base64_decode($input['KPE_KWH_SUB_FLOWMETER_NAMA']),
						'KPE_KWH_FLOWMETER_LOKASI' => $input['KPE_KWH_FLOWMETER_LOKASI'],
						'KPE_KWH_FLOWMETER_READING' => $input['KPE_KWH_FLOWMETER_READING'],
						'KPE_KWH_FLOWMETER_DISTRIBUSI' => $input['KPE_KWH_FLOWMETER_DISTRIBUSI'],
						'KPE_KWH_FLOWMETER_TYPE' => $input['KPE_KWH_FLOWMETER_TYPE'],
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_KWH_FLOWMETER";
					$this->MYSQL->record = $data_master;
		
					if ($this->MYSQL->simpan() == true)
					{
						
							$this->callback['respon']['pesan']="sukses";
							$this->callback['respon']['text_msg']="Data berhasil disimpan";
							$this->callback['result']=$result;
					}
					else
					{
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Data gagal disimpan";
					}
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
				$this->MYSQL->tabel ="KPE_KWH_FLOWMETER";
				$this->MYSQL->record = $data_master_edit;
				$this->MYSQL->dimana = "WHERE KPE_KWH_FLOWMETER_ID='".$input['KPE_KWH_FLOWMETER_ID']."' AND (RECORD_STATUS='A')";
	
				if ($this->MYSQL->ubah() == true)
				{
					$data_master = array(
						'KPE_KWH_FLOWMETER_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_KWH_FLOWMETER_ID' => $input['KPE_KWH_FLOWMETER_ID'],
						'KPE_KWH_FLOWMETER_NAMA' => $input['KPE_KWH_FLOWMETER_NAMA'],
						'KPE_KWH_SUB_FLOWMETER_ID' => $input['KPE_KWH_SUB_FLOWMETER_ID'],
						'KPE_KWH_SUB_FLOWMETER_NAMA' => base64_decode($input['KPE_KWH_SUB_FLOWMETER_NAMA']),
						'KPE_KWH_FLOWMETER_LOKASI' => $input['KPE_KWH_FLOWMETER_LOKASI'],
						'KPE_KWH_FLOWMETER_READING' => $input['KPE_KWH_FLOWMETER_READING'],
						'KPE_KWH_FLOWMETER_DISTRIBUSI' => $input['KPE_KWH_FLOWMETER_DISTRIBUSI'],
						'KPE_KWH_FLOWMETER_TYPE' => $input['KPE_KWH_FLOWMETER_TYPE'],
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_KWH_FLOWMETER";
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
