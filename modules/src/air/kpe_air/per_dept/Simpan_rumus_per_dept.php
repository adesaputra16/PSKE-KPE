<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}


$input = $params['input_option'];
$sql_b = "SELECT * FROM KPE_AIR_FLOWMETER_CATATAN WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['TANGGAL_RUMUS']."' AND RECORD_STATUS='A'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_b;
$result_c = $this->MYSQL->data();

				$data_master_edit = array(
					'EDIT_WAKTU' => date("Y-m-d H:i:s"),
					'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
					'RECORD_STATUS' => "E"
				);
	
				$this->MYSQL =new MYSQL;
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN";
				$this->MYSQL->record = $data_master_edit;
				$this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['TANGGAL_RUMUS']."' AND RECORD_STATUS='A'";
						
				if ($this->MYSQL->ubah() == true)
				{
					if(empty($input['KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS'])){
						$KPE_AIR_FLOWMETER_CATATAN_PAKAI="0.00";
					}else{
						$pakai = json_encode($input['KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS']);
						$arr_pakai = json_decode($pakai);
						$KPE_AIR_FLOWMETER_CATATAN_PAKAI = number_format(array_sum($arr_pakai) + $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_PAKAI'],2);
						if($result_c[0]['KPE_AIR_FLOWMETER_CATATAN_KALIBRASI'] == 'off'){
							$KPE_AIR_FLOWMETER_CATATAN_BEBAN = $KPE_AIR_FLOWMETER_CATATAN_PAKAI;
						}else{
							$KPE_AIR_FLOWMETER_CATATAN_BEBAN = number_format($KPE_AIR_FLOWMETER_CATATAN_PAKAI-($KPE_AIR_FLOWMETER_CATATAN_PAKAI*$result_c[0]['KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN']/100),2);
						}
					}
					

					$data_master = array(
						'KPE_AIR_FLOWMETER_CATATAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_CATATAN_ID' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_ID'],
						'KPE_AIR_FLOWMETER_ID' => $result_c[0]['KPE_AIR_FLOWMETER_ID'],
						'KPE_AIR_FLOWMETER_NAMA' => $result_c[0]['KPE_AIR_FLOWMETER_NAMA'],
						'KPE_AIR_FLOWMETER_CATATAN_TANGGAL' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
						'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
						'KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS' => json_encode($input['KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS']),
						'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL'],
						'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH'],
						'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN'],
						'KPE_AIR_FLOWMETER_CATATAN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
						'KPE_AIR_FLOWMETER_CATATAN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
						'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI' => $result_c[0]['KPE_AIR_FLOWMETER_CATATAN_KALIBRASI'],
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN";
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
			
		
		


?>
