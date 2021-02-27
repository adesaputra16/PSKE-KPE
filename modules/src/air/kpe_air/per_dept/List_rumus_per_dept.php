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

    if (empty($input['MULTI_FILTER'])) {
      $sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER
              WHERE RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";
    } else {
      $search_array = explode(",", $input['MULTI_FILTER']);
      $search_text = "'" . implode("', '", $search_array) . "'";
      $sql_a = "SELECT KPE_AIR_FLOWMETER_ID,KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA FROM KPE_AIR_FLOWMETER
              WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID IN (".$search_text.") ORDER BY KPE_AIR_FLOWMETER_NAMA";
    }
    
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

if ($input['dateRangeS'] == "NaN-NaN-NaN" || $input['dateRangeSE'] == "NaN-NaN-NaN") {
  $tanggalAwals=$periodeTahunSekarang."-".$periodeBulanSekarang."-01";
  $tanggalterakhir = Date('Y-m-d',strtotime($tanggalAwals.'-1 day'));

  // $tanggalterakhir = date("Y-m-d", strtotime($periodeTahunSekarang.'-'.$periodeBulanSekarang));
  // $tanggalAkhirs= Date('Y-m-d',strtotime($tanggalterakhir));
} 
else {
  $tanggalterakhir = $input['dateRangeS'];
}

foreach ($result_ab as $r) {
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL
                        FROM KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW WHERE KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA";
  $result_DEPARTEMEN_FLOW=$this->MYSQL->data(); 

  if(count($result_DEPARTEMEN_FLOW)>=1)
  {
    $r['DEPT_FLOW']=$result_DEPARTEMEN_FLOW;

  } else {
    $r['DEPT_FLOW']="";
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = "SELECT *
                          FROM KPE_AIR_FLOWMETER_KALIBRASI
                          WHERE KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL DESC LIMIT 1";
  $result_TOTAL=$this->MYSQL->data()[0]; 

  if(count($result_TOTAL)>=1)
  {
    $r['KAL']=$result_TOTAL;
  }else
  {
    $r['KAL']=array();
  }

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_ID,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN,c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,
                        c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL,c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI,
                        c.KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN,a.KPE_AIR_FLOWMETER_NAMA,
                        a.KPE_AIR_FLOWMETER_CATATAN_ANGKA,a.KPE_AIR_FLOWMETER_CATATAN_PAKAI,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN,a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL,a.ENTRI_WAKTU
                        FROM KPE_AIR_FLOWMETER AS b 
                        LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID 
                        LEFT JOIN KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN AS c ON a.KPE_AIR_FLOWMETER_ID=c.KPE_AIR_FLOWMETER_ID
                        WHERE b.KPE_AIR_FLOWMETER_ID='".$r['KPE_AIR_FLOWMETER_ID']."' AND  
                        a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$tanggalterakhir."'
                        AND b.RECORD_STATUS='A' AND  a.RECORD_STATUS='A' ORDER BY a.KPE_AIR_FLOWMETER_NAMA";
  $result_ANGKA=$this->MYSQL->data()[0]; 

  if(count($result_ANGKA)>=1)
  {
    $r['ANGKA']=$result_ANGKA;
  } else {
    $r['ANGKA']="";
  }

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
