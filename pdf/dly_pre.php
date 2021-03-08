<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$mpdf=new mPDF('c','A4','','',12,12,12,10,5,5); 

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
      margin-top:2px;
      padding-top:-15px;
      padding-left:-40px;
      padding-right:-10px;
      padding-botttom:-15px;
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
      -webkit-page-break-before: always;
      -o-page-break-before: always;
      page-break-before: always;
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
      margin-bottom :5px;
    }

    tr.bleft{
      border:none;
      // border-top:1px solid black;
      // border-bottom:1px solid black;
    }
		
	</style>';

$input_option=array(
  'KPE_AIR_FLOWMETER_CATATAN_TANGGAL' => $d3
);
$params=array(
	'case'=>"nonlogin_list_dly_report_pre",
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
	'case'=>"nonlogin_list_kimia_pre",
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
	'case'=>"nonlogin_list_operasional_pre",
	'batas'=>30,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option_opn,
);

$respon_opn = $KPE->kpe_modules($params_opn)->load->module;
$list_opn = $respon_opn['result'][0];
$total_m3 = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_RW'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_1_2_REAL']/'4' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_1_2_REAL']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_3_4_REAL']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_3_4_REAL']/'2';
$total_accumulatif = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_PROSES_RW'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_1_2_LAPORAN']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_1_2_LAPORAN']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_3_4_LAPORAN']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_3_4_LAPORAN']/'2';
$total_opn_hour = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2_RUMUS'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4'] + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4_RUMUS'];
$total_opn_acc = $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6']/'2' + $list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6']/'2';
// echo "<pre>".print_r($respon_kimia['result'],true)."</pre>";
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
    $beban_dept .='<tr class="bleft">
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
      $beban_dept .= '<tr class="bleft">
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

$headerHTML='<br>
<table class="table2 table-bordered" align="center" width="100%" style="margin-top:-16px; margin-left:1px; margin-right:-1px">
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
		<title>Daily Report Pre-Treatment</title>
		'.$css.'
	</head>
	<body style="background:url(aplikasi/general/pdf/meeting/bg.png) ;">'.$headerHTML.'
        
        <div class="box1a" style="margin-left:5px;">
          <p style="margin-bottom:4px; font-size:12px;"><b>Pretreatment Water Usage (m³)</b></p>
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
                  <tr style="border:1px solid black;">
                    <th >Total</th>
                    <th style="text-align:right;">'.number_format(round($respon['TOTAL_USAGE'],2),2,",",".").'</th>
                    <th style="text-align:right;">'.round(array_sum($arr_persen_usage),2).'</th>
                    <th style="text-align:right;">'.number_format(round(array_sum($arr_total_acc),2),2,",",".").'</th>
                    <th style="text-align:right;">'.round(array_sum($arr_persen_acc),2).'</th>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="column-right">
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr><td colspan="2" class="text-center tdjudul_list">Stock</td></tr>
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list">(m3) Water</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Equalisasi</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Employe Mess Basin</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Tower</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Aerasi Basin</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Filtered Water Basin</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Bak BSF 1 & 2</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; Bak BSF 3 & 4</td>
                  <td class="text-center">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4'].'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center">&nbsp; <b>Total</b></td>
                  <td class="text-center"><b>'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_STOCK'].'&nbsp;</b></td>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp; Pretreatment Water (Process)</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list">(m3) Water</td>
                  <td class="text-center tdjudul_list">Accumulatif</td>
                </tr>
                <tr>
                    <td class="text-center">&nbsp; Raw Water</td> 
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_RW'].'&nbsp;</td>
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_PROSES_RW'].'&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center">&nbsp; Clarifier 1</td> 
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_1_2_REAL']/'4'.'&nbsp;</td>
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_1_2_LAPORAN']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center">&nbsp; Clarifier 2</td> 
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_1_2_REAL']/'2'.'&nbsp;</td>
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_1_2_LAPORAN']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center">&nbsp; Clarifier 3</td> 
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_3_4_REAL']/'2'.'&nbsp;</td>
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_3_4_LAPORAN']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center">&nbsp; Clarifier 4</td> 
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_3_4_REAL']/'2'.'&nbsp;</td>
                    <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_3_4_LAPORAN']/'2'.'&nbsp;</td>
                </tr>
                <tr>
                  <td class="text-center"><b>Total</b></td>
                  <td class="text-right">'.$total_m3.'</td>
                  <td class="text-right">'.$total_accumulatif.'</td>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp; Chemical Consumption (Kg)</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list">Described</td>
                  <td class="text-center tdjudul_list">Accept</td>
                  <td class="text-center tdjudul_list">Usage</td>
                  <td class="text-center tdjudul_list">Accumulatif</td>
                  <td class="text-center tdjudul_list">Stock</td>
                </tr>
                <tr>
                  <td>&nbsp;Tawas</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_STOCK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Caustic</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_STOCK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;TCCA</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_STOCK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Polimer</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_STOCK'],2,",",".").'&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Hydro 4041</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI'].'&nbsp;</td>
                  <td class="text-right">'.$list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_AKUMULASI'].'&nbsp;</td>
                  <td class="text-right">'.number_format($list_kimia['KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_STOCK'],2,",",".").'&nbsp;</td>
                </tr>
              </table>

              <span style="font-size:12px;">&nbsp;</span>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td class="text-center tdjudul_list" rowspan="2" width="50%">Efficiency Caustic Soda</td>
                  <td class="text-center tdjudul_list" rowspan="2">&nbsp;</td>
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

              <p class="text-right" style="font-size:12px; margin-bottom:1px;">Accumulatif &nbsp; </p>
              <table class="tcolumn table4 table-bordered table-margin" width="100%">
                <tr>
                  <td colspan="2">&nbsp; Accept</td> 
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_RW'].'</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_PROSES_RW'].'</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp; Usage</td> 
                  <td class="text-right">'.number_format(round($respon['TOTAL_USAGE'],2),2,",",".").'</td>
                  <td class="text-right">'.number_format(round(array_sum($arr_total_acc),2),2,",",".").'</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp; Stock</td> 
                  <td colspan="" class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_STOCK'].'</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp; Decrease</td> 
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_SUSUT_PRE_DISTRIBUSI'].'</td>
                  <td class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_SUSUT'].'</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp; Efficiency</td> 
                  <td colspan="" class="text-right">'.$list_opn['KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EFFESIENSI'].'</td>
                  <td></td>
                </tr>
              </table>

              <span class="text-right" style="font-size:12px; text-align:right;">Note: &nbsp; </span>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>
              <hr>

              <p class="text-left keterangan" style="font-size:12px; text-align:left;">&nbsp;&nbsp;CT  :  Cooling Tower </p>
              <p class="text-left keterangan" style="font-size:12px; text-align:left;">&nbsp;&nbsp;TCCA:  Tri Cloro isoCyanuric Acid </p>
              <p class="text-left keterangan" style="font-size:12px; text-align:left;">&nbsp;&nbsp;m3  :  Meter Cubic </p>
              <p class="text-left keterangan" style="font-size:12px; text-align:left;">&nbsp;&nbsp;Kg  :  Kilogram </p>

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
			
			<table class="table3 table-unbordered table3-content" style="border:none;" width="100%">
				<tr>
					<td align="right">FRM-QMS-051-01</td>
				</tr>
			</table>
		</div>
		<br><br>
		
	</body>
	</html>
	

';

$footer = '
<table width="100%" style="vertical-align: top; font-size: 10px;"><tr>
<td width="50%" align="left"></td><td class="text-right"> {PAGENO}{nbpg} </td>
</tr></table>
';

// $mpdf->SetHTMLHeader($headerHTML);
$mpdf->SetDisplayMode('fullpage');
// $mpdf->SetFooter('{PAGENO} / {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output(); 
exit;



?>