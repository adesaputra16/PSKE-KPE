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

if (empty($input['keyword']) or $input['keyword'] == "")
{
  $filter_a = "";
} else
{
  $filter_a = "AND AF.KPE_AIR_FLOWMETER_NAMA LIKE '%" . $input['keyword'] . "%' OR KPE_AIR_FLOWMETER_LOKASI LIKE '%" . $input['keyword'] . "%'";
}

if (empty($input['idFlowmeter']) or $input['idFlowmeter'] == "" )
{
  $filter_b = "";
}
else
{
  $filter_b = "AND AF.KPE_AIR_FLOWMETER_ID='".$input['idFlowmeter']."'";
}

if (empty($input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE']) or $input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE'] == "" )
{
  $filter_c = "";
}
else
{
  $filter_c = "AND AF.KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='".$input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE']."'";
}

if (empty($input['subFlowmeter']) or $input['subFlowmeter'] == "" )
{
  $filter_d = "";
}
else
{
  $filter_d = "AND AF.KPE_AIR_FLOWMETER_SUB_ID='".$input['subFlowmeter']."'";
}

$sql_a = "SELECT * FROM KPE_AIR_FLOWMETER AS AF LEFT JOIN KPE_AIR_FLOWMETER_SUB AS S ON AF.KPE_AIR_FLOWMETER_SUB_ID=S.KPE_AIR_FLOWMETER_SUB_ID WHERE AF.RECORD_STATUS='A' AND S.RECORD_STATUS='A' ".$filter_a." ".$filter_b." ".$filter_c." ".$filter_d." ORDER BY KPE_AIR_FLOWMETER_NAMA ASC";



$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a . " LIMIT " . $posisi . "," . $batas;
$result_a = $this->MYSQL->data();

$no = $posisi + 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
    //$r['TANGGAL'] =tanggal_format(Date("Y-m-d",strtotime($r['KPE_AIR_TANGGAL'])));
    $result[] = $r;

    $no++;
    }

if (empty($result_a))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "OK..";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
