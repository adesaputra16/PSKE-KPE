<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}


		$input = $params['input_option'];
		
		/*===================== Looping insert ke database jika flowmeter digunakan beberapa departemen ===================*/
      for($i=0; $i < $input['TOTAL_LOOP']; $i++) {
				$data_master = array(
					'KPE_AIR_FLOWMETER_CATATAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_AIR_FLOWMETER_CATATAN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'][$i],
					'KPE_AIR_FLOWMETER_NAMA' => $input['KPE_AIR_FLOWMETER_NAMA'][$i],
					'KPE_AIR_FLOWMETER_CATATAN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'][$i],
					'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'][$i],
					'KPE_AIR_FLOWMETER_CATATAN_PAKAI' => $input['KPE_AIR_FLOWMETER_CATATAN_BEBAN'][$i],
					'KPE_AIR_FLOWMETER_CATATAN_BEBAN' => $input['KPE_AIR_FLOWMETER_CATATAN_BEBAN'][$i],
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
						$this->callback['respon']['text_msg']="Berhasil Simpan";
						$this->callback['result']=$result;
					}
					else
					{
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Gagal Simpan";
					}
      }

?>
