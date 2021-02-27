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
  $filter_a = "AND b.KPE_AIR_FLOWMETER_NAMA LIKE '%" . $input['keyword'] . "%'";
}
if (empty($input['keyword']) or $input['keyword'] == "")
{
  $filter_a1 = "";
} else
{
  $filter_a1 = "AND FS.KPE_AIR_FLOWMETER_SUB_NAMA LIKE '%" . $input['keyword'] . "%'";
}

if (empty($input['DATA_sDATE']) or $input['DATA_sDATE'] == "")
{
  $DATE = Date('Y/m/d');
  $filter_b = "AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$DATE."' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$DATE."'";
} else
{
  if(empty($input['DATA_eDATE']) or $input['DATA_eDATE'] == "")
  {
    $tanggalAkhir=$input['DATA_sDATE'];
  } else
  {
    $tanggalAkhir=$input['DATA_eDATE'];
  }
    $TanggalMulai=$input['DATA_sDATE'];
    $filter_b = "AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$TanggalMulai."' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$tanggalAkhir."'";
}

if (empty($input['BULAN_FILTER']) or $input['BULAN_FILTER'] == "" )
{
  $filter_c = "";
}
else
{
  $filter_b = "";
  $filter_c = "AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$input['TAHUN_FILTER2']."-".$input['BULAN_FILTER']."-01' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$input['TAHUN_FILTER2']."-".$input['BULAN_FILTER']."-31'";
  $filter_d = "";
}

if (empty($input['TAHUN_FILTER']) or $input['TAHUN_FILTER'] == "")
{
  $filter_d = "";
}
else
{
  $filter_b = "";
  $filter_c = "";
  $filter_d = "AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$input['TAHUN_FILTER']."-01-01' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$input['TAHUN_FILTER']."-12-31'";
}

$sql_a = "SELECT FS.KPE_AIR_FLOWMETER_SUB_ID,FS.KPE_AIR_FLOWMETER_SUB_NAMA
          FROM KPE_AIR_FLOWMETER_SUB AS FS  where
          FS.RECORD_STATUS='A'
          ORDER BY FS.KPE_AIR_FLOWMETER_SUB_ID ASC";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_a. " LIMIT " . $posisi . "," . $batas;
$result_a = $this->MYSQL->data();

$no = $posisi + 1;

foreach($result_a as $r)
    {
      $this->MYSQL=new MYSQL();
      $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
     
      $this->MYSQL->queri = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL,a.KPE_AIR_FLOWMETER_CATATAN_ID,
      a.KPE_AIR_FLOWMETER_CATATAN_ANGKA,a.ENTRI_WAKTU,
      b.KPE_AIR_FLOWMETER_NAMA,b.KPE_AIR_FLOWMETER_DISTRIBUSI,b.KPE_AIR_FLOWMETER_LOKASI,b.KPE_AIR_FLOWMETER_ID        
      FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID  
      WHERE b.KPE_AIR_FLOWMETER_SUB_ID='".$r['KPE_AIR_FLOWMETER_SUB_ID']."'  
      AND b.RECORD_STATUS='A' AND  a.RECORD_STATUS='A' ".$filter_a." ".$filter_b." ".$filter_c." ".$filter_d."";

      $result_FLOWMETER=$this->MYSQL->data();  

      if(count($result_FLOWMETER)>=1)
      {
        $r['FLOWMETER'] = $result_FLOWMETER;
      }else
      {
        $r['FLOWMETER']=array();
      } 

      //$r['FLOWMETER'] = $result_FLOWMETER;
      $r['NO'] = $no;
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
    $this->callback['respon']['text_msg'] = "Data Ada ".print_r($result_FLOWMETER,true);
    $this->callback['respon']['boaboa'] = "Data ada:<br><pre>".json_encode($result, JSON_PRETTY_PRINT)."</pre>";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
      'sql' => $sql_a,
      'batas' => $batas
    ))->jmlhalaman;
    }

?>
