<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}


			$input = $params['input_option'];
			if($input['KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA'] == ""){
				$KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA="";
			}else{
				$KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA=json_encode($input['KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA']);	
			}

			if($input['KPE_AIR_FLOWMETER_ID']=="")
			{
				// $data_master_dept = array(
				// 	'KPE_AIR_FLOWMETER_DEPARTEMEN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
				// 	'KPE_AIR_FLOWMETER_DEPARTEMEN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
				// 	'KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE' => $input['KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE'],
				// 	'KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA' => $KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,
				// 	'KPE_AIR_FLOWMETER_NAMA' => $input['KPE_AIR_FLOWMETER_NAMA'],
				// 	'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
				// 	'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
				// 	'RECORD_STATUS' => "A"
				// );
	
				// $this->MYSQL =new MYSQL;
				// $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				// $this->MYSQL->tabel ="KPE_AIR_FLOWMETER_DEPARTEMEN";
				// $this->MYSQL->record = $data_master_dept;
				// $this->MYSQL->simpan();
				$sql_ca = "SELECT KPE_AIR_FLOWMETER_ID FROM KPE_AIR_FLOWMETER WHERE KPE_AIR_FLOWMETER_NAMA='".$input['KPE_AIR_FLOWMETER_NAMA']."' AND RECORD_STATUS='A'";

				$this->MYSQL = new MYSQL();
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri = $sql_ca;
				$result_ca = $this->MYSQL->data();
				if ($result_ca >= 1) {
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Flowmeter sudah pernah di input";
				} else {
					$data_master = array(
						'KPE_AIR_FLOWMETER_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_NAMA' => $input['KPE_AIR_FLOWMETER_NAMA'],
						'KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA' => $KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,
						'KPE_AIR_FLOWMETER_DLY' => $input['KPE_AIR_FLOWMETER_DLY'],
						'KPE_AIR_FLOWMETER_PERIODE' => $input['KPE_AIR_FLOWMETER_PERIODE'],
						'KPE_AIR_FLOWMETER_SUB_ID' => $input['KPE_AIR_FLOWMETER_SUB_ID'],
						'KPE_AIR_FLOWMETER_SUB_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_SUB_NAMA']),
						'KPE_AIR_FLOWMETER_LOKASI' => $input['KPE_AIR_FLOWMETER_LOKASI'],
						'KPE_AIR_FLOWMETER_DISTRIBUSI' => $input['KPE_AIR_FLOWMETER_DISTRIBUSI'],
						'KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE' => $input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE'],
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_AIR_FLOWMETER";
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
				$data_master_edit = array(
					
					'EDIT_WAKTU' => date("Y-m-d H:i:s"),
					'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
					'RECORD_STATUS' => "E"
				);
	
				$this->MYSQL =new MYSQL;
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel ="KPE_AIR_FLOWMETER";
				$this->MYSQL->record = $data_master_edit;
				$this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND (RECORD_STATUS='A')";
	
				if ($this->MYSQL->ubah() == true)
				{
					$data_master = array(
						'KPE_AIR_FLOWMETER_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
						'KPE_AIR_FLOWMETER_SUB_ID' => $input['KPE_AIR_FLOWMETER_SUB_ID'],
						'KPE_AIR_FLOWMETER_SUB_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_SUB_NAMA']),
						'KPE_AIR_FLOWMETER_NAMA' => $input['KPE_AIR_FLOWMETER_NAMA'],
						'KPE_AIR_FLOWMETER_DLY' => $input['KPE_AIR_FLOWMETER_DLY'],
						'KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA' => $KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,
						'KPE_AIR_FLOWMETER_LOKASI' => $input['KPE_AIR_FLOWMETER_LOKASI'],
						'KPE_AIR_FLOWMETER_DISTRIBUSI' => $input['KPE_AIR_FLOWMETER_DISTRIBUSI'],
						'KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE' => $input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE'],
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_AIR_FLOWMETER";
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
