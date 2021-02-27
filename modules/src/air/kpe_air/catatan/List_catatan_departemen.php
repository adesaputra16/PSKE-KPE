<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

  $input = $params['input_option'];

	$periode = substr($input['KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE'],0,7);
  $KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA = base64_decode($input['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA']);

	$this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_d = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL,
                  KPE_AIR_FLOWMETER_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL,KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN,
                  KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE,KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL
                  FROM KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW
                  WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA='".$KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA."' AND KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE='".$periode."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_a = $this->MYSQL->data();

// -- >>

$no = $posisi + 1;

foreach($result_a as $r)
{
  $r['NO'] = $no;
  $result[] = $r;

  $no++;
}

if (empty($result_a))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "OK..";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    // $this->callback['tes'] = $sql_d;

    }

?>