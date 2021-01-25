<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
		}
    
    $halaman = $params['halaman'];
    $batas = $params['batas'];
    $posisi = $this->PAGING->cariPosisi($batas, $halaman);
    $input = $params['input_option'];
    
    $sql_a = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA,F.KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA
              FROM KPE_AIR_FLOWMETER AS F 
              WHERE F.RECORD_STATUS='A' ORDER BY F.KPE_AIR_FLOWMETER_NAMA";
    // $sql_a = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA,FD.KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER AS F 
    //           INNER JOIN KPE_AIR_FLOWMETER_DEPARTEMEN AS FD ON F.KPE_AIR_FLOWMETER_ID=FD.KPE_AIR_FLOWMETER_ID
    //           WHERE F.RECORD_STATUS='A' AND FD.RECORD_STATUS='A' ORDER BY F.KPE_AIR_FLOWMETER_NAMA";
    
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql_a. " LIMIT " . $posisi . "," . $batas;
    $result_ab = $this->MYSQL->data();

$no = $posisi + 1;

if($input['TAHUN_FILTER']==""){
  $periodeTahunSekarang=Date("Y");
}else{
  $periodeTahunSekarang=$input['TAHUN_FILTER'];
}
if($input['BULAN_FILTER']==""){
  $periodeBulanSekarang=Date("m");
}else{
  $periodeBulanSekarang=$input['BULAN_FILTER'];
}

foreach ($result_ab as $r) {
	// $sql_b = "SELECT F.KPE_AIR_FLOWMETER_ID,F.KPE_AIR_FLOWMETER_NAMA,FC.KPE_AIR_FLOWMETER_CATATAN_ID,
	// 				FC.KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS,FC.KPE_AIR_FLOWMETER_CATATAN_BEBAN_RUMUS,FC.KPE_AIR_FLOWMETER_CATATAN_ANGKA,FC.KPE_AIR_FLOWMETER_CATATAN_TANGGAL
	// 				FROM KPE_AIR_FLOWMETER AS F INNER JOIN KPE_AIR_FLOWMETER_CATATAN AS FC ON F.KPE_AIR_FLOWMETER_ID=FC.KPE_AIR_FLOWMETER_ID
	// 				WHERE FC.KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND F.RECORD_STATUS='A' AND FC.RECORD_STATUS='A'";

	// $this->MYSQL = new MYSQL();
	// $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	// $this->MYSQL->queri = $sql_b. " LIMIT " . $posisi . "," . $batas;
	// $result_c = $this->MYSQL->data();

	// if(count($result_c)>=1)
	// {
	// 	$r['PERDEPT'] = $result_c;
	// }else
	// {
	// 	$r['PERDEPT']=array();
	// } 

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
