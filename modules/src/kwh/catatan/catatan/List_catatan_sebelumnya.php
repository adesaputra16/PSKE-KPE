<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

  $input = $params['input_option'];

  $sql_d = "SELECT KPE_KWH_FLOWMETER_NAMA,KPE_KWH_FLOWMETER_ID
        FROM KPE_KWH_FLOWMETER
        WHERE RECORD_STATUS='A' AND KPE_KWH_FLOWMETER_ID='".$input['KPE_KWH_FLOWMETER_ID']."'";

$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql_d;
$result_a = $this->MYSQL->data();


$no = $posisi + 1;

foreach($result_a as $r)
{
  /*=============== Query list catatan berdasarkan tgl terakhir yg diinput ==============*/
  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_c = "SELECT KPE_KWH_CATATAN_ID,KPE_KWH_CATATAN_ANGKA,KPE_KWH_CATATAN_BEBAN
                    FROM KPE_KWH_CATATAN
                    WHERE RECORD_STATUS='A' AND KPE_KWH_FLOWMETER_ID='".$r['KPE_KWH_FLOWMETER_ID']."' AND KPE_KWH_CATATAN_TANGGAL='".$input['KPE_KWH_CATATAN_TANGGAL']."'";
  $this->MYSQL->queri = $sql_c;                      
  $result_c=$this->MYSQL->data()[0]; 

  $this->MYSQL=new MYSQL();
  $this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
  $sql_d = "SELECT KPE_KWH_CATATAN_TANGGAL
            FROM KPE_KWH_CATATAN
            WHERE RECORD_STATUS='A' AND KPE_KWH_FLOWMETER_ID='".$r['KPE_KWH_FLOWMETER_ID']."' ORDER BY KPE_KWH_CATATAN_TANGGAL DESC LIMIT 1";
  $this->MYSQL->queri = $sql_d;                      
  $result_d=$this->MYSQL->data()[0]; 

  $r['CATATAN'] = $result_c;
  $r['CATATAN_TERAKHIR'] = $result_d;
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
    $this->callback['tes'] = $sql_c;

    }

?>