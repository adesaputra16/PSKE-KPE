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

if ($input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE'] == '') {
  $distribusi_type = '';
} else {
  $distribusi_type = "AND b.KPE_AIR_FLOWMETER_DISTRIBUSI LIKE '%".$input['KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE']."%'";
}

if ($input['BULAN_FILTER'] != "")
{

  $tanggalterakhir = date("Y-m-t", strtotime($input['TAHUN_FILTER2'].'-'.$input['BULAN_FILTER']));
  $tanggalterakhirnya = date("d",strtotime($tanggalterakhir));
  $bulan=$input['BULAN_FILTER'];
  $tahun=$input['TAHUN_FILTER2'];
  for ($j=1; $j <= $tanggalterakhirnya; $j++) { 
    $tanggal = sprintf("%02d", $j);
    $filter_bln .= ",MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tahun."-".$bulan."-".$tanggal."' 
    THEN s.KPE_AIR_FLOWMETER_CATATAN_ANGKA ELSE ('-') END )AS `day".$j."`";
  }
}

if ($input['TAHUN_FILTER'] != "")
{
  $tahun=$input['TAHUN_FILTER'];
  for ($k=1; $k <= 12; $k++) { 
    $bulan = sprintf("%02d", $k);
    $filter_thn .= ",SUM(case when DATE_FORMAT(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m')= '".$tahun."-".$bulan."' then s.KPE_AIR_FLOWMETER_CATATAN_ANGKA else ('-') END )AS `bulan".$k."`";

  }
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
      if ($input['DATA_sDATE'] == "")
      {
        $sql_flow = "";
      } else {
        $DATE = Date('Y/m/d');
        $DATE = $input['DATA_sDATE'];
        $filter_b = "AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL>='".$DATE."' AND a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL<='".$DATE."'";
        $sql_flow = "SELECT a.KPE_AIR_FLOWMETER_CATATAN_TANGGAL,a.KPE_AIR_FLOWMETER_CATATAN_ID,a.KPE_AIR_FLOWMETER_CATATAN_BEBAN,
                    a.KPE_AIR_FLOWMETER_CATATAN_ANGKA,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL,a.ENTRI_WAKTU,
                    a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH,a.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN,
                    a.KPE_AIR_FLOWMETER_NAMA,b.KPE_AIR_FLOWMETER_DISTRIBUSI,b.KPE_AIR_FLOWMETER_LOKASI,b.KPE_AIR_FLOWMETER_ID,a.KPE_AIR_FLOWMETER_CATATAN_NOTE     
                    FROM KPE_AIR_FLOWMETER AS b LEFT JOIN KPE_AIR_FLOWMETER_CATATAN AS a ON a.KPE_AIR_FLOWMETER_ID=b.KPE_AIR_FLOWMETER_ID  
                    WHERE b.KPE_AIR_FLOWMETER_SUB_ID='".$r['KPE_AIR_FLOWMETER_SUB_ID']."'  
                    AND b.RECORD_STATUS='A' AND  a.RECORD_STATUS='A' ".$filter_a." ".$filter_b." ".$distribusi_type." GROUP BY b.KPE_AIR_FLOWMETER_NAMA";
      }
      if ($input['DATA_eDATE'] != "")
      {

        $begin = new DateTime( $input['DATA_sDATE'] );
        $end   = new DateTime( $input['DATA_eDATE'] );

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $tanggal[] = $i->format("Y-m-d");
        }
        $filter_minggu = "MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[0]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day1`,
                          MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[1]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day2`,
                          MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[2]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day3`,
                          MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[3]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day4`,
                          MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[4]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day5`,
                          MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[5]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day6`,
                          MAX(CASE WHEN Date_format(s.KPE_AIR_FLOWMETER_CATATAN_TANGGAL, '%Y-%m-%d')= '".$tanggal[6]."' THEN s.KPE_AIR_FLOWMETER_CATATAN_BEBAN ELSE ('-') END )AS `day7`
                          ";
        $sql_flow = "SELECT
        r.KPE_AIR_FLOWMETER_NAMA,
        ".$filter_minggu.",
        r.KPE_AIR_FLOWMETER_LOKASI,r.KPE_AIR_FLOWMETER_DISTRIBUSI
        FROM KPE_AIR_FLOWMETER r
        INNER JOIN KPE_AIR_FLOWMETER_CATATAN s
        ON r.KPE_AIR_FLOWMETER_ID = s.KPE_AIR_FLOWMETER_ID
        WHERE r.RECORD_STATUS='A' AND s.RECORD_STATUS='A' AND r.KPE_AIR_FLOWMETER_SUB_ID='".$r['KPE_AIR_FLOWMETER_SUB_ID']."'
        GROUP BY r.KPE_AIR_FLOWMETER_NAMA";

      }
      if ($input['BULAN_FILTER'] != "")
      {
        $sql_flow = "SELECT
                    r.KPE_AIR_FLOWMETER_NAMA
                    ".$filter_bln.",r.KPE_AIR_FLOWMETER_LOKASI,
                    r.KPE_AIR_FLOWMETER_DISTRIBUSI
                    FROM KPE_AIR_FLOWMETER r
                    INNER JOIN KPE_AIR_FLOWMETER_CATATAN s
                    ON r.KPE_AIR_FLOWMETER_ID = s.KPE_AIR_FLOWMETER_ID
                    WHERE r.RECORD_STATUS='A' AND s.RECORD_STATUS='A' AND r.KPE_AIR_FLOWMETER_SUB_ID='".$r['KPE_AIR_FLOWMETER_SUB_ID']."'
                    GROUP BY r.KPE_AIR_FLOWMETER_NAMA";
      }

      if ($input['TAHUN_FILTER'] != "")
      {
        $sql_flow = "SELECT
                    r.KPE_AIR_FLOWMETER_NAMA
                    ".$filter_thn.",r.KPE_AIR_FLOWMETER_LOKASI,
                    r.KPE_AIR_FLOWMETER_DISTRIBUSI
                    FROM KPE_AIR_FLOWMETER r
                    INNER JOIN KPE_AIR_FLOWMETER_CATATAN s
                    ON r.KPE_AIR_FLOWMETER_ID = s.KPE_AIR_FLOWMETER_ID
                    WHERE r.RECORD_STATUS='A' AND s.RECORD_STATUS='A' AND r.KPE_AIR_FLOWMETER_SUB_ID='".$r['KPE_AIR_FLOWMETER_SUB_ID']."'
                    GROUP BY r.KPE_AIR_FLOWMETER_NAMA";
      }
      
      $this->MYSQL->queri = $sql_flow;
      $result_FLOWMETER=$this->MYSQL->data();
      if(count($result_FLOWMETER)>=1)
      {
        $r['FLOWMETER'] = $result_FLOWMETER;
      }else
      {
        $r['FLOWMETER']=array();
      } 

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
