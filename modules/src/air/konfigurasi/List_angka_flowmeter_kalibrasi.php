<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
		}
		
$input = $params['input_option'];
if ($input['KPE_AIR_FLOWMETER_ID'] == "0")
{
  $sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_KALIBRASI_ID,KPE_AIR_FLOWMETER_KALIBRASI_PERSEN,
                 KPE_AIR_FLOWMETER_KALIBRASI_REAL,KPE_AIR_FLOWMETER_KALIBRASI_SELISIH,KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL,
                 KPE_AIR_FLOWMETER_NAMA
          FROM KPE_AIR_FLOWMETER_KALIBRASI WHERE RECORD_STATUS='A'";
} else
{
  // $filter_flow = "AND KPE_AIR_FLOWMETER_ID='" . $input['KPE_AIR_FLOWMETER_ID'] . "'";
  $sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_KALIBRASI_ID,KPE_AIR_FLOWMETER_KALIBRASI_PERSEN,
                 KPE_AIR_FLOWMETER_KALIBRASI_REAL,KPE_AIR_FLOWMETER_KALIBRASI_SELISIH,KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL,KPE_AIR_FLOWMETER_NAMA
          FROM KPE_AIR_FLOWMETER_KALIBRASI 
          WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA LIMIT 1";
}





$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a;
$result_ab = $this->MYSQL->data();

$no = $posisi + 1;


foreach ($result_ab as $r) {
  $r['NO'] = $no;
  $r['TANGGAL'] = tanggal_format(Date("Y-m-d", strtotime($r['KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL'])));
	$result[] = $r;
	$no++;
}

if (empty($result_ab))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result_FLOWMETER;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Data Ada ".print_r($result_FLOWMETER,true);
    $this->callback['respon']['rumus'] = "asdw:<br><pre>".json_encode($sql_b, JSON_PRETTY_PRINT)."</pre>";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
