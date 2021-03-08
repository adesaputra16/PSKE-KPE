<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$mpdf=new mPDF('c','A4','','',12,12,9,10,5,5); 

//==============================================================

$mpdf->pagenumPrefix = 'Halaman ';
$mpdf->pagenumSuffix = '';
$mpdf->nbpgPrefix = ' dari ';
$mpdf->nbpgSuffix = '.';
$header = array(
	'L' => array(
	),
	'C' => array(
	),
	'R' => array(
		'content' => '{PAGENO}{nbpg}',
		'font-family' => 'sans',
		'font-style' => '',
		'font-size' => '12',	/* gives default */
	),
	'line' => 1,
);

$css='<style>
		
		.table2-header{
			border:1px solid #000 !important;
			border-collapse: collapse;
			margin-top:-1px;
			width:100%;
		}
		.table2-header td{
			font-weight:bold;
			padding:3px;
			border:1px solid #000 !important;	
			font-size:14px;
		}
		.table2-header td{
			padding:0px;
		}
		
		.table2{
			border:1px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
		}
		.table2 td,.table2 th{
			padding:1px;
			border:1px solid #000 !important;	
			font-size:11px;
			color:#150000;
		}
		
		.table2 th{
		 text-align:center;	
		 font-weight:bold !important;
		}
		
		.table2 td h3{
			font-size:12px;
			font-weight:bold;
			line-height:0px;
		}
		
		
		.table2-unbordered{
			border:0px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
			width:100%;
		}
		.table2-unbordered td,.table2-unbordered th{
			padding:3px;
			border:0px solid #000 !important;	
			font-size:9px;
		}
		
		.table-app{
      margin-top:100px;
      padding-top:-10px;
      padding-left:-40px;
      padding-right:-18px;
		}

		.table3{
			border-collapse: collapse;
			margin-top:-1px;
		}

		.table3 td,.table3 th{
			padding:1px;
			font-size:11px;
			color:#150000;
		}
		
		.table3 th{
		 text-align:center;	
		 font-weight:bold !important;
		}
		
		.table3 td h3{
			font-size:12px;
			font-weight:bold;
			line-height:0px;
		}
		
		
		.table3-unbordered{
			border:0px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
			width:100%;
		}
		.table3-unbordered td,.table3-unbordered th{
			padding:3px;
			border:0px solid #000 !important;	
			font-size:9px;
		}
		
		
		
		.table4{
			border:1px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
		}
		.table4 td,.table4 th{
			padding:1px;
			border:1px solid #000 !important;	
			border-top:0px solid #000 !important;	
			font-size:11px;
			color:#150000;
		}
		
		.table4 th{
		 text-align:center;	
		 font-weight:bold !important;
		}
		
		.table4 td h3{
			font-size:12px;
			font-weight:bold;
			line-height:0px;
		}
		
		
		.text-center{
			text-align:center;
		}
		.text-left{
			text-align:left;
		}
		
		.text-right{
			text-align:right !important;
		}
		
		.text-danger{
			color:#DF0C0F;
		}
		.text-warning{
			color:#DFB70C;
		}
		
		strong.unit-name{
			font-size:17px;
		}
		
		hr.header{
			color:#2F2B27;
		}
		
		h3{
			text-align:center;
		}
		
		.unit-name-33{
			color:#B83F21;
		}
		.unit-name-34{
			color:#21648E;
		}
		ol li{
			font-size:11px;
		}
		
		.box1{
			border:1px solid #000 !important;
			margin-top:-1.5px;
			width:100%;
			margin:0px;
			padding:30px;
			padding-top:10px;
		}

    div.break {
      -webkit-box-decoration-break: clone;
      -o-box-decoration-break: clone;
      box-decoration-break: clone;
    }
		
		.table2-content{
			
		}
		
		.table2-content td{
			height:11px;
		}
		.sub-title{
			padding-left:20px;
			font-weight:bold;
			padding-top:2px;
			text-transform: uppercase;
			font-size:13px;
			color:#0D0303;
		}
		
		.sub-title i{
			color:#3A3939;
			text-transform: lowercase;
		}
		
		.td-kuning{
			background:#EFCD12;
		}
		
		
		.table-comments{
			width:100%;
		}
		.table-comments td,.table-comments th{
			width:210px;
			border-bottom:1px dotted #827D7D !important;
			text-align:left;
			font-size:8px;
		}
		.table-comments th.title{
			color:#424242;
		}
		
		.darurat{
			background:#EFCD12;
		}
		.td-hrd{
		  background-color:#BFBFBF;
		}
		.judul_wo{
			font-size:20px;

		}
		.tdjudul_list{
			font-weight:bold;
			border-bottom:1px solid #000;
			border-top:1px solid #000;
		}
		.noborder{
			border:none;
		}
		.wo_red{background-color:#FF2D00;}
		.wo_yellow{background-color:#FFF100;}
		.wo_green{background-color:#008000;}

		.tdtanggal{
			width:60px;

		}.row {
      margin-left:-5px;
      margin-right:-5px;
    }
      
    .column-left {
      float: left;
      width: 59%;
      padding: 1px;
    }

    .column-right {
      float: left;
      width: 40%;
      padding: 1px;
    }
    
    /* Clearfix (clear floats) */
    .row::after {
      content: "";
      clear: both;
      display: table;
    }
    
    table.tcolumn{
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
    }
    
    th, td {
      text-align: left;
      padding: 16px;
    }

    .table-margin {
      margin-bottom:12px;
    }

    hr {
      margin-top: 3px;
      color:black;
    }

    p.keterangan {
      margin-top :-5px;
      padding-top:-5px;
    }
		
	</style>';

$input_option=array(
  'KPE_AIR_FLOWMETER_CATATAN_TANGGAL' => $d3
);
$params=array(
	'case'=>"nonlogin_list_dly_report_ro",
	'batas'=>30,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);

$respon = $KPE->kpe_modules($params)->load->module;

$input_option_kimia=array(
  'TANGGAL_FILTER' => $d3
);
$params_kimia=array(
	'case'=>"nonlogin_list_kimia_ro",
	'batas'=>30,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option_kimia,
);

$respon_kimia = $KPE->kpe_modules($params_kimia)->load->module;
$list_kimia = $respon_kimia['result'][0];
// echo "<pre>".print_r($respon_kimia['result'],true)."</pre>";
// exit;

$input_option_opn=array(
  'TANGGAL_FILTER' => $d3
);
$params_opn=array(
	'case'=>"nonlogin_list_operasional_ro",
	'batas'=>30,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option_opn,
);

$respon_opn = $KPE->kpe_modules($params_opn)->load->module;
$list_opn = $respon_opn['result'][0];
$total_accept = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_HASIL_1'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_HASIL_2'];
$total_accumulatif = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_AKUMULASI_1'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_AKUMULASI_2'];
$total_opn_hour = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2_RUMUS'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4_RUMUS'];
$total_opn_acc = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6']/'2';
// echo "<pre>".print_r($respon['result'],true)."</pre>";
// exit;
// print_r( json_encode($respon['result']));

$tgl = explode("-",$d3);
$tanggal = join("",$tgl);
$tgl_app =  date_create($d3);
$no=1;
$arr_persen_usage = [];
$arr_total_acc = [];
$arr_persen_acc = [];

// echo print_r($res,true);
// exit;

for ($i=0; $i < count($respon['result']); $i++) { 
  if (count($respon['result'][$i]['BEBAN_HARIAN_PDF']) == 1 || count($respon['result'][$i]['BEBAN_HARIAN_PDF']) == 0) {
    $beban_dept .='<tr>
                    <td>&nbsp;'.$respon['result'][$i]['KPE_AIR_FLOWMETER_NAMA'].'</td>
                    <td class="text-right">'.$respon['result'][$i]['BEBAN_HARIAN']['KPE_AIR_FLOWMETER_CATATAN_BEBAN'].'&nbsp;</td>
                    <td class="text-right">'.round($respon['result'][$i]['BEBAN_HARIAN']['KPE_AIR_FLOWMETER_CATATAN_BEBAN']/$respon['TOTAL_USAGE']*'100',2).'&nbsp;</td>
                    <td class="text-right">'.round($respon['result'][$i]['ACCUMULATIF']['ACCUMULATIF'],2).'&nbsp;</td>
                    <td class="text-right">'.round($respon['result'][$i]['ACCUMULATIF']['ACCUMULATIF']/$respon['ACCUMULATIF_TOTAL']*'100',2).'&nbsp;</td>
                  </tr>';
    array_push($arr_persen_usage,$respon['result'][$i]['BEBAN_HARIAN']['KPE_AIR_FLOWMETER_CATATAN_BEBAN']/$respon['TOTAL_USAGE']*'100');
    array_push($arr_total_acc,$respon['result'][$i]['ACCUMULATIF']['ACCUMULATIF']);
    array_push($arr_persen_acc,$respon['result'][$i]['ACCUMULATIF']['ACCUMULATIF']/$respon['ACCUMULATIF_TOTAL']*'100');
    
  } else {
    for ($j=0; $j < count($respon['result'][$i]['BEBAN_HARIAN_PDF']); $j++) { 
      $beban_dept .= '<tr>
                        <td>&nbsp;'.$respon['result'][$i]['BEBAN_HARIAN_PDF'][$j]['KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA'].'</td>
                        <td class="text-right">'.round($respon['result'][$i]['BEBAN_HARIAN_PDF'][$j]['KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN'],2).'&nbsp;</td>
                        <td class="text-right">'.round($respon['result'][$i]['BEBAN_HARIAN_PDF'][$j]['KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN']/$respon['TOTAL_USAGE']*'100',2).'&nbsp;</td>
                        <td class="text-right">'.round($respon['result'][$i]['ACCUMULATIF'][$j]['ACCUMULATIF'],2).'&nbsp;</td>
                        <td class="text-right">'.round($respon['result'][$i]['ACCUMULATIF'][$j]['ACCUMULATIF']/$respon['ACCUMULATIF_TOTAL']*'100',2).'&nbsp;</td>
                      </tr>';

      array_push($arr_persen_usage,$respon['result'][$i]['BEBAN_HARIAN_PDF'][$j]['KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN']/$respon['TOTAL_USAGE']*'100');
      array_push($arr_persen_acc,$respon['result'][$i]['ACCUMULATIF'][$j]['ACCUMULATIF']/$respon['ACCUMULATIF_TOTAL']*'100');
    }
  }
}

  $xtml = <<<"EOT"
     <div class="card">
        <img src="$img" alt="">
        <h2>$title</h2>
        <p>$desc</p>
     </div>
EOT;


$headerHTML='<br>
<table class="table2 table-bordered" align="center" width="100%">
								<tr>
									<td rowspan="3" width="80" class="text-center tdjudul" style="border:1px solid #000 !important">
                  <img src="/asset/images/logo_label.png" height="52">
									</td>
									<td rowspan="3" class="text-center">
										<font style="font-size:12px;">PT PULAU SAMBU (KUALA ENOK)</font><br>
										<font style="font-size:14px;"><strong>WATER TREATMENT DAILY REPORT</strong></font><br>
										<font style="font-size:10px;">No.: OPN\WT\IMS\DLY(WT) -&nbsp;&nbsp;&nbsp;&nbsp;'.$tanggal.'&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;'.$d4.'</font>
									</td>
									<td width="38" style="border-right:none !important;">Section</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" class="noborder" style="border-left:none !important;">WT</td>
								</tr>
								<tr>
									<td width="38" style="border-right:none !important;">Revision</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" style="border-left:none !important;">00</td>
								</tr>
								<tr>
									<td width="38" style="border-right:none !important;">Page</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" style="border-left:none !important;">1 of 2</td>
								</tr>
						</table>
';

$html = '
	<html>
	<head>
		<title>Daily Report RO</title>
		'.$css.'
	</head>
	<body style="background:url(aplikasi/general/pdf/meeting/bg.png) ;">'.$headerHTML.'
        
        <div class="box1a" style="margin-left:5px; margin-top:15px">
          <p style="margin-bottom:4px; font-size:12px;"><b>RO Water Usage (m³)</b></p>
          <div class="row">
            <div class="column-left">
              <table class="tcolumn table4 table-bordered" width="100%">
                <thead>
                  <tr>
                    <td class="text-center tdjudul_list">DEPT. USAGE</td>
                    <td class="text-center tdjudul_list">USAGE</td>
                    <td class="text-center tdjudul_list">%</td>
                    <td class="text-center tdjudul_list">ACCUMULATIF</td>
                    <td class="text-center tdjudul_list">%</td>
                  </tr>
                </thead>
                <tbody>
                '.$beban_dept.'
                </tbody>
                <tfoot>
                  <tr>
                    <th >Total</th>
                    <th style="text-align:right;">'.number_format(round($respon['TOTAL_USAGE'],2),2,",",".").'</th>
                    <th style="text-align:right;">'.round(array_sum($arr_persen_usage),2).'</th>
                    <th style="text-align:right;">'.number_format(round(array_sum($arr_total_acc),2),2,",",".").'</th>
                    <th style="text-align:right;">'.round(array_sum($arr_persen_acc),2).'</th>
                  </tr>
                </tfoot>
              </table>
              <br>
              <span style="font-size:12px;">&nbsp; Chemical Consumption</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">Described</td> 
                  <td class="text-center tdjudul_list">Usage</td>
                  <td class="text-center tdjudul_list">Accumulatif</td>
                  <td class="text-center tdjudul_list">Stock</td>
                </tr>
                <tr>
                  <td>&nbsp;Hydro 590 (lt)</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_STOK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Hydro 277 (lt)</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_STOK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Hydro 566 (lt)</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_STOK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Hydro 259 (lt)</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_STOK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Hydro 575 (lt)</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_STOK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;NaCl (kg)</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_STOK'],2,",",".").'&nbsp;</td>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp;</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list">Accumulatif</td>
                  <td class="text-center tdjudul_list">Usage</td>
                </tr>
                <tr>
                  <td>'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_SUSUT'].'</td>
                  <td>'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_AKUMULASI_SUSUT'].'</td>
                  <td>'.$list_opn['REKAP_USED']['KPE_AIR_FLOWMETER_REKAP_USED_RO_RATA_RATA'].'</td>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp;Efficiency  RO</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">RO 1</td>
                  <td>'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_EFFESIENSI_PROSES_1'].'</td>
                  </tr>
                  <tr>
                  <td class="text-center tdjudul_list">RO 2</td>
                  <td>'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_EFFESIENSI_PROSES_2'].'</td>
                </tr>
              </table>

              <span class="text-right" style="font-size:12px; text-align:right;">Note: &nbsp; </span>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>

              <p class="text-left keterangan" style="font-size:10px; text-align:left;">&nbsp;&nbsp;CF  :  Carbon Filter </p>
              <p class="text-left keterangan" style="font-size:10px; text-align:left;">&nbsp;&nbsp;RO  :  Reverse Osmosis </p>
              <p class="text-left keterangan" style="font-size:10px; text-align:left;">&nbsp;&nbsp;lt  :  Litre </p>
              <p class="text-left keterangan" style="font-size:10px; text-align:left;">&nbsp;&nbsp;m3  :  Meter Cubic </p>
              <p class="text-left keterangan" style="font-size:10px; text-align:left;">&nbsp;&nbsp;Kg  :  Kilogram </p>
            </div>
            <div class="column-right">
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr><td colspan="2" class="text-center tdjudul_list">Stock</td></tr>
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list">(m3) Water</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Soft Water 1</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_SOFT_WATER_1'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Soft Water 2</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_SOFT_WATER_2'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; RO WT</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; RO Boiler I</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_I'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; RO Boiler II</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_II'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; RO Boiler III</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_III'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; RO Boiler IV</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_IV'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; RO Boiler V/Sekat</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_V_SEKAT'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; <b>Total</b></td>
                  <td class="text-center"><b>'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_TOTAL'].'&nbsp;</b></td>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp;</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list"></td>
                  <td class="text-center tdjudul_list">Accumulatif</td>
                </tr>
                <tr>
                    <td>Proses CF/Pre RO (m3)</td> 
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Product Softener /Pre Ro(m3)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_TOTAL'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_AKUMULASI'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Backwash CF (m3)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_BACKWASH_PRODUK'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_BACKWASH_AKUMULASI'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td><b>Regenerasi Softener (m3)</b></td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_TOTAL'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_AKUMULASI'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Process RO 1 (m3)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_HASIL_1'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_AKUMULASI_1'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Product RO 1 (m3)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_HASIL_1'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_AKUMULASI_1'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td><b>Reject RO 1 (m3)</b></td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_1'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_AKUMULASI_1'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Flow Product RO 1 (m3/hour)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1'].'&nbsp;&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Time Operation RO 1 (hour)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_1'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_AKUMULASI_1'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Process RO 2 (m3)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_HASIL_2'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_AKUMULASI_2'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Product RO 2 (m3)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_HASIL_2'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_AKUMULASI_2'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td><b>Reject RO 2 (m3)</b></td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_2'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_AKUMULASI_2'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Flow Product RO 2 (m3/hour)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_1'].'&nbsp;&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Time Operation RO 2 (hour)</td> 
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_2'].'&nbsp;&nbsp;</td>
                    <td class="text-right">&nbsp;&nbsp;'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_AKUMULASI_2'].'&nbsp;&nbsp;</td>
                </tr>
                <tr>
                  <th>Total</th>
                  <th>Accept</th>
                  <th>Accumulatif</th>
                </tr>
                <tr>
                  <th class="text-right">'.$list_opn['REKAP_USED']['KPE_AIR_FLOWMETER_REKAP_USED_RO_RATA_RATA'].'</th>
                  <th>'.$total_accept.'</th>
                  <th>'.$total_accumulatif.'</th>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp; Operation</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list">Hour</td>
                  <td class="text-center tdjudul_list">m3/hour</td>
                  <td class="text-center tdjudul_list">Accumulatif (hour)</td>
                </tr>
                <tr>
                  <td>&nbsp;Clarifier 1</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2'].'&nbsp;</td>
                  <td class="text-right">30 &nbsp;</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Clarifier 2</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2_RUMUS'].'&nbsp;</td>
                  <td class="text-right">30 &nbsp;</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Clarifier 3</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4'].'&nbsp;</td>
                  <td class="text-right">30 &nbsp;</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Clarifier 4</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4_RUMUS'].'&nbsp;</td>
                  <td class="text-right">30 &nbsp;</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Total</td>
                  <td class="text-right">'.$total_opn_hour.'&nbsp;</td>
                  <td class="text-right">120 &nbsp;</td>
                  <td class="text-right">'.$total_opn_acc.'&nbsp;</td>
                </tr>
              </table>

              </table>

              <table class="table-app" width="100%">
                <tbody>
                  <tr>
                    <td class="text-left" valign="bottom" style="border:none;" width="10%"></td>
                    <td>
                      <table class="table2 table-bordered table2-content">
                        <tbody>
                          <tr>
                            <td width="50%" align="center">Prepared and Checked by:</td>
                            <td width="50%" align="center">Confirmed by:</td>
                          </tr>
                          <tr><td class="text-center"><h1>&nbsp;</h1><br><br><br></td><td class="text-center"><h1>&nbsp;</h1><br></td></tr>
                          <tr>
                            <td width="100%">
                              <table class="table2 table2-unbordered">
                                <tbody>
                                  <tr><td>Name</td><td>: ISAKNA</td></tr>
                                  <tr><td>Post/Dept</td><td>: Adm</td></tr>
                                  <tr><td>Date</td><td>: '.date_format($tgl_app,"d/m/Y").'</td></tr>
                                </tbody>
                              </table>
                            </td>
                            <td>
                              <table class="table2 table2-unbordered">
                                <tbody><tr><td>Name</td><td>: HERI FIKRI</td></tr>
                                  <tr><td>Post/Dept</td><td>: Dept Head WT</td></tr>
                                  <tr><td>Date</td><td>: '.date_format($tgl_app,"d/m/Y").'</td></tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody> 
              </table>
            </div>
          </div>
        </div>
			<br/>
		</div>
		
	</body>
	</html>
	

';

$footer = '
<table width="100%" style="vertical-align: top; font-size: 10px;"><tr>
<td width="50%" align="left"></td><td class="text-right"> {PAGENO}{nbpg} </td>
</tr></table>
';

$mpdf->SetDisplayMode('fullpage');
// $mpdf->SetHTMLHeader($headerHTML);
// $mpdf->SetFooter('{PAGENO} / {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output(); 
exit;



?>