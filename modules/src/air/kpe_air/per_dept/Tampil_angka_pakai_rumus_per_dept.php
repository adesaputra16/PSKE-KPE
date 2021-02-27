<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}




	$input = $params['input_option'];
	$sql_b = "SELECT * FROM KPE_AIR_FLOWMETER_CATATAN WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND RECORD_STATUS='A'";
	
	$this->MYSQL = new MYSQL();
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri = $sql_b;
	$result_c = $this->MYSQL->data();
	if (empty($result_c))
		{
		$this->callback['respon']['pesan'] = "gagal";
		$this->callback['respon']['text_msg'] = "Data tidak ada.";
		$this->callback['result'] = $result_c;
		}
	  else
		{
		$this->callback['respon']['pesan'] = "sukses";
		$this->callback['respon']['text_msg'] = "Data Ada ".print_r($result_c,true);
		$this->callback['result'] = $result_c;
		}	
	
			
		
		


?>
