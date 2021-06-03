
<?php

//crontrol
if (empty($params['case'])) {
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$input = $params['input_option'];
$old_result = 100;

$sql_a = "SELECT * FROM KPE_KWH_RUMUS WHERE KPE_KWH_FLOWMETER_ID='20210406141910268316' AND 
			RECORD_STATUS='A' GROUP BY KPE_KWH_RUMUS_ID ORDER BY KPE_KWH_RUMUS_INDEX ASC";
$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a;
$data = $this->MYSQL->data();

$len = count($data);
$running_sum = [];
$sum = array();
$current_running_sum = $old_result;

for ($i = 0; $i < $len; $i++) {
	$sql_b = "SELECT * FROM KPE_KWH_RUMUS WHERE KPE_KWH_RUMUS_ID='" . $data[$i]['KPE_KWH_RUMUS_ID'] . "' AND 
			RECORD_STATUS='A' ORDER BY KPE_KWH_RUMUS_INDEX ASC";
	$this->MYSQL = new MYSQL();
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri = $sql_b;
	$data_b = $this->MYSQL->data();

	for ($j = 0; $j < count($data_b); $j++) {
		if ($data_b[$j]['KPE_KWH_RUMUS_TYPE'] == "FIELD") {
			if ($data_b[$j]['KPE_KWH_RUMUS_FIELD'] == "PUTARAN") {
				$filed = "KPE_KWH_CATATAN_BEBAN";
			} else {
				$filed = "KPE_KWH_CATATAN_BEBAN_X_READING";
			}
			$sql_F = "SELECT " . $filed . " AS VALUE FROM KPE_KWH_CATATAN
					WHERE KPE_KWH_FLOWMETER_ID='" . $data_b[$j]['KPE_KWH_FLOWMETER_ID_TARGET'] . "'AND KPE_KWH_CATATAN_TANGGAL='2021-04-01' 
					AND RECORD_STATUS='A'";
			$this->MYSQL = new MYSQL();
			$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri = $sql_F;
			$value = $this->MYSQL->data()[0]['VALUE'];
		} else {
			$value = (float)$data_b[$j]['KPE_KWH_RUMUS_VALUE'];
		}

		if ($data_b[$j]['KPE_KWH_RUMUS_OPERATOR'] == "+") {
			$current_running_sum += $value;
		} else if ($data_b[$j]['KPE_KWH_RUMUS_OPERATOR'] == "-") {
			$current_running_sum -= $value;
		} else if ($data_b[$j]['KPE_KWH_RUMUS_OPERATOR'] == "*") {
			$current_running_sum *= $value;
		} else if ($data_b[$j]['KPE_KWH_RUMUS_OPERATOR'] == "(") {
			$current_running_sum = (float)$data_b[$j + 1]['KPE_KWH_RUMUS_VALUE'];
		} else if ($data_b[$j]['KPE_KWH_RUMUS_OPERATOR'] == ")") {
			// $current_running_sum = (float)$data_b[$j - 1]['KPE_KWH_RUMUS_VALUE'];
		}
		array_push($sum, $value);
	}
	// if ($data[$i]['KPE_KWH_RUMUS_TYPE'] == "FIELD") {
	// 	if ($data[$i]['KPE_KWH_RUMUS_FIELD'] == "PUTARAN") {
	// 		$filed = "KPE_KWH_CATATAN_BEBAN";
	// 	} else {
	// 		$filed = "KPE_KWH_CATATAN_BEBAN_X_READING";
	// 	}
	// 	$sql_F = "SELECT " . $filed . " AS VALUE FROM KPE_KWH_CATATAN
	// 			WHERE KPE_KWH_FLOWMETER_ID='" . $data[$i]['KPE_KWH_FLOWMETER_ID_TARGET'] . "'AND KPE_KWH_CATATAN_TANGGAL='2021-04-01' 
	// 			AND RECORD_STATUS='A'";
	// 	$this->MYSQL = new MYSQL();
	// 	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	// 	$this->MYSQL->queri = $sql_F;
	// 	$value = $this->MYSQL->data()[0]['VALUE'];
	// } else {
	// 	$value = (float)$data[$i]['KPE_KWH_RUMUS_VALUE'];
	// }

	// if ($data[$i]['KPE_KWH_RUMUS_OPERATOR'] == "+") {
	// 	$current_running_sum += $value;
	// } else if ($data[$i]['KPE_KWH_RUMUS_OPERATOR'] == "-") {
	// 	$current_running_sum -= $value;
	// } else if ($data[$i]['KPE_KWH_RUMUS_OPERATOR'] == "*") {
	// 	$current_running_sum *= $value;
	// }
	// array_push($sum, $value);
}
array_push($running_sum, $current_running_sum);
$overal_result = array_sum($running_sum);

if (empty($data)) {
	$this->callback['respon']['pesan'] = "gagal";
	$this->callback['respon']['text_msg'] = "Data tidak ada.";
	$this->callback['result'] = $data;
} else {
	$this->callback['respon']['pesan'] = "sukses";
	$this->callback['respon']['text_msg'] = "Berhasil " . $overal_result;
	$this->callback['result'] = $data;
	$this->callback['result2'] = $sum;
}

?>