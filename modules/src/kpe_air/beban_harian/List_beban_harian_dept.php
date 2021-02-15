<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

  $input = $params['input_option'];

	$this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_d = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA FROM KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW
                  WHERE RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_a = $this->MYSQL->data();

// -- >>

if($input['BULAN_FILTER']=="" && $input['TAHUN_FILTER']==""){
  $bulan=Date("m");
  $tahun=Date("Y");
  $bulan_lalu=Date("m")-1;
  $tahun_lalu=Date("Y");
}else{
  $bulan=$input['BULAN_FILTER'];
  $tahun=$input['TAHUN_FILTER'];
  $bulan_lalu=$input['BULAN_FILTER']-1;
  $tahun_lalu=$input['TAHUN_FILTER'];
}

$lastDates =date("t", strtotime($tahun.'-'.$bulan.'-01'));
$lastDatesBulanLalu =date("t", strtotime($tahun_lalu.'-'.$bulan_lalu.'-01'));
$no = $posisi + 1;

foreach($result_a as $r)
{
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_e = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN) AS TOTAL_BEBAN_DEPT, FORMAT(COALESCE(SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN),0)/".$lastDates.",2) AS AVG FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN
            WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL>='".$tahun."-".$bulan."-01' 
            AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL<='".$tahun."-".$bulan."-31' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_FLOW_ID='".$r['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID']."' AND RECORD_STATUS='A'";

  $this->MYSQL = new MYSQL();
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = $sql_e;
  $result_e = $this->MYSQL->data()[0];

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_f = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN) AS TOTAL_BEBAN_DEPT_BULAN_LALU, FORMAT(COALESCE(SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN),0)/".$lastDatesBulanLalu.",2) AS AVG_LALU FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN
            WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL>='".$tahun_lalu."-".$bulan_lalu."-01' 
            AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL<='".$tahun_lalu."-".$bulan_lalu."-31' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_FLOW_ID='".$r['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID']."' AND RECORD_STATUS='A'";

  $this->MYSQL = new MYSQL();
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->queri = $sql_f;
  $result_f = $this->MYSQL->data()[0];

  $r['C_DEPT'] = $result_e;
  $r['C_DEPT_BULAN_LALU'] = $result_f;
  $r['NO'] = $no;
  $result[] = $r;

  $no++;
}

$tanggalAwals=$tahun."-".$bulan."-01";

$tanggalterakhir =date("Y-m-t", strtotime($tahun.'-'.$bulan));
$tanggalAkhirs=Date('Y-m-d',strtotime($tanggalterakhir));
$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

$begin = new DateTime($tanggalAwals);
$end   = new DateTime($tanggalAkhirs);
$no=1 + $posisi;
for($iy = $begin; $iy <= $end; $iy->modify('+1 day'))
{
  $tglLaporan=$iy->format("Y-m-j");

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_b = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN) AS TOTAL_BEBAN
                        FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN
                        WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$tglLaporan."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_b;
  $result_BEBAN=$this->MYSQL->data()[0]; 
    
  $result_beban[]=$result_BEBAN['TOTAL_BEBAN'];
  $no++;
}
$BEBAN_HARIAN = array_sum($result_beban);
$AVG_BEBAN = array_sum($result_beban)/$lastDates;

$tanggalLalu=$tahun_lalu."-".$bulan_lalu."-01";

$tanggalterakhirLalu =date("Y-m-t", strtotime($tahun_lalu.'-'.$bulan_lalu));
$tanggalAkhirsLalu=Date('Y-m-d',strtotime($tanggalterakhirLalu));

$begin_bulan_lalu = new DateTime($tanggalLalu);
$end_bulan_lalu   = new DateTime($tanggalAkhirsLalu);
for($iyl = $begin_bulan_lalu; $iyl <= $end_bulan_lalu; $iyl->modify('+1 day'))
{
  $tglLaporanl=$iyl->format("Y-m-j");

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_bl = "SELECT SUM(KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN) AS TOTAL_BEBAN_BULAN_LALU
              FROM KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN
              WHERE KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$tglLaporanl."' AND RECORD_STATUS='A' ORDER BY KPE_AIR_FLOWMETER_NAMA";
  $this->MYSQL->queri = $sql_bl;
  $result_BEBAN_BULAN_LALU=$this->MYSQL->data()[0]; 
    
  $result_beban_BULAN_LALU[]=$result_BEBAN_BULAN_LALU['TOTAL_BEBAN_BULAN_LALU'];
  $no++;
}
$BEBAN_HARIAN_BULAN_LALU = array_sum($result_beban_BULAN_LALU);
$AVG_BEBAN_BULAN_LALU = array_sum($result_beban_BULAN_LALU)/$lastDatesBulanLalu;

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
    $this->callback['AVG_BEBAN_BULAN_LALU'] = $AVG_BEBAN_BULAN_LALU;
    $this->callback['BEBAN_HARIAN_BULAN_LALU'] = $BEBAN_HARIAN_BULAN_LALU;
    $this->callback['AVG_BEBAN'] = $AVG_BEBAN;
    $this->callback['BEBAN_HARIAN'] = $BEBAN_HARIAN;
    // $this->callback['tes'] = $sql_d;

    }

?>