<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$mpdf=new mPDF('c','A4-L','','',10,10,9,10,5,5); 

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

$css="<style>
		
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
			text-align:right;
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
			margin: auto;
			padding:30px;
			padding-bottom:0;
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
		}
		.noborder{
			border:none;
		}
		.wo_red{background-color:#FF2D00;}
		.wo_yellow{background-color:#FFF100;}
		.wo_green{background-color:#008000;}

		.tdtanggal{
			width:60px;
		}
		
	</style>";

$input_option=array(
    'DATA_sDATE'=>$d3,
    'DATA_eDATE'=>$d4,
    'BULAN_FILTER'=>$d5,
    'TAHUN_FILTER2'=>$d6,
    'TAHUN_FILTER'=>$d7,
);
$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_tampil_catatan",
	'batas'=>30,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);

function reformatDate($date, $from_format = 'Y-m-d', $to_format = 'j-M-y') {
	$date_aux = date_create_from_format($from_format, $date);
	return date_format($date_aux,$to_format);
}

function formatNumber($num) {
	return number_format($num,3,".",",");
}

$tanggalterakhir = date("Y-m-t", strtotime($d6.'-'.$d5));
$tanggalterakhirnya = date("d",strtotime($tanggalterakhir));

//$respon=$WO_MASTER->wo($params)->load->module;
$respon = $KPE->kpe_modules($params)->load->module;
//print json_encode($respon);
$no=1;

foreach($respon['result'] as $r){

	foreach ($r['FLOWMETER'] as $rf) {
		//======== Looping list =============//
		if ($d3 != "" && $d4 == "") {
			$hari = '<td valign="top" >'.formatNumber($rf['KPE_AIR_FLOWMETER_CATATAN_ANGKA']).'</td>';
		} elseif ($d4 != "") {
			$hari =  '<td valign="top" >'.formatNumber($rf['day1']).'</td>
								<td valign="top" >'.formatNumber($rf['day2']).'</td>
								<td valign="top" >'.formatNumber($rf['day3']).'</td>
								<td valign="top" >'.formatNumber($rf['day4']).'</td>
								<td valign="top" >'.formatNumber($rf['day5']).'</td>
								<td valign="top" >'.formatNumber($rf['day6']).'</td>
								<td valign="top" >'.formatNumber($rf['day7']).'</td>';
		} elseif ($d5 != "") {
			$hari =  '<td valign="top" >'.formatNumber($rf['day1']).'</td>
									<td valign="top" >'.formatNumber($rf['day2']).'</td>
									<td valign="top" >'.formatNumber($rf['day3']).'</td>
									<td valign="top" >'.formatNumber($rf['day4']).'</td>
									<td valign="top" >'.formatNumber($rf['day5']).'</td>
									<td valign="top" >'.formatNumber($rf['day6']).'</td>
									<td valign="top" >'.formatNumber($rf['day7']).'</td>
									<td valign="top" >'.formatNumber($rf['day8']).'</td>
									<td valign="top" >'.formatNumber($rf['day9']).'</td>
									<td valign="top" >'.formatNumber($rf['day10']).'</td>
									<td valign="top" >'.formatNumber($rf['day11']).'</td>
									<td valign="top" >'.formatNumber($rf['day12']).'</td>
									<td valign="top" >'.formatNumber($rf['day13']).'</td>
									<td valign="top" >'.formatNumber($rf['day14']).'</td>
									<td valign="top" >'.formatNumber($rf['day15']).'</td>
									<td valign="top" >'.formatNumber($rf['day16']).'</td>
									<td valign="top" >'.formatNumber($rf['day17']).'</td>
									<td valign="top" >'.formatNumber($rf['day18']).'</td>
									<td valign="top" >'.formatNumber($rf['day19']).'</td>
									<td valign="top" >'.formatNumber($rf['day20']).'</td>
									<td valign="top" >'.formatNumber($rf['day21']).'</td>
									<td valign="top" >'.formatNumber($rf['day22']).'</td>
									<td valign="top" >'.formatNumber($rf['day23']).'</td>
									<td valign="top" >'.formatNumber($rf['day24']).'</td>
									<td valign="top" >'.formatNumber($rf['day25']).'</td>
									<td valign="top" >'.formatNumber($rf['day26']).'</td>
									<td valign="top" >'.formatNumber($rf['day27']).'</td>
									<td valign="top" >'.formatNumber($rf['day28']).'</td>';
			if ($tanggalterakhirnya == "29" ) {
				$hari .= '<td valign="top" >'.formatNumber($rf['day29']).'</td>';
			} else if ($tanggalterakhirnya == "30") {
				$hari .= '<td valign="top" >'.formatNumber($rf['day29']).'</td>
									<td valign="top" >'.formatNumber($rf['day30']).'</td>';
			} else if ($tanggalterakhirnya == "31") {
				$hari .= '<td valign="top" >'.formatNumber($rf['day29']).'</td>
									<td valign="top" >'.formatNumber($rf['day30']).'</td>
									<td valign="top" >'.formatNumber($rf['day31']).'</td>';
			} 
		} else {
			$hari =  '<td valign="top" >'.formatNumber($rf['bulan1']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan2']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan3']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan4']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan5']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan6']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan7']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan8']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan9']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan10']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan11']).'</td>
								<td valign="top" >'.formatNumber($rf['bulan12']).'</td>';
		}
		//========== End Looping ============//
		
		$detail_records .='<tr height="'.$height.'">
											<td valign="top" align="right"  height="'.$height.'">'.$no.'.</td>
											<td valign="top" >'.$r['KPE_AIR_FLOWMETER_SUB_NAMA'].'</td>
											<td valign="top" >'.$rf['KPE_AIR_FLOWMETER_NAMA'].'</td>
											'.$hari.'
											<td valign="top" >'.$rf['KPE_AIR_FLOWMETER_LOKASI'].'</td>
											<td valign="top" >'.$rf['KPE_AIR_FLOWMETER_DISTRIBUSI'].'</td>
											</tr>';
											$no++;
	}
	
}
// $detail_records = '';
// for ($i=1; $i < 2; $i++) { 
// 	if ($respon['result'][$i]['FLOWMETER'] == "") {
// 		$JFLOWMETER = 1;
// 	} else {
// 		$JFLOWMETER = count($respon['result'][$i]['FLOWMETER']);
// 	}
// 	$rowspan = 1;
// 	$rowspan += $JFLOWMETER;

// 	$detail_records .= /*html*/'<tr class="trData">
// 																<td rowspan="'.$rowspan.'">'.$respon['result'][$i]['NO'].'</td>
// 																<td rowspan="'.$rowspan.'">'.$respon['result'][$i]['KPE_AIR_FLOWMETER_SUB_NAMA'].'</td>
// 															</tr>';
// 		$listData = '';
// 		for ($j=0; $j < 2; $j++) {
			
// 			if ($d3 != "") {
// 				$listData .=  /*html*/'<td>'. $respon['result'][$i]['FLOWMETER'][$j]['KPE_AIR_FLOWMETER_NAMA'].' </td>
// 															<td class="">'.formatNumber($respon['result'][$i]['FLOWMETER'][$j]['KPE_AIR_FLOWMETER_CATATAN_ANGKA']).' </td>
// 															<td class="">'. $respon['result'][$i]['FLOWMETER'][$j]['KPE_AIR_FLOWMETER_LOKASI'].' </td>
// 															<td class="">'. $respon['result'][$i]['FLOWMETER'][$j]['KPE_AIR_FLOWMETER_DISTRIBUSI'].' </td>' ;
// 			} else {

// 			}
// 		}
// 		$detail_records .= htmlspecialchars('<tr class="trData">'.$listData.'</tr>');
// }

// $detail_records = '<tr class="trData">
// 										<td rowspan="3">2</td>
// 										<td rowspan="3">MESS KARYAWAN</td>
// 										</tr>';

// $detail_records .= /*html*/'<tr class="trData">
// 															<td>MESS BTN</td>
// 															<td class=" text-right">137,013.440</td>
// 															<td class="">Lantai II tower WTD</td>
// 															<td class="">Air Pre-Treatment</td>
// 														</tr>
// 														<tr class="trData">
// 															<td>MESS DEPAN</td>
// 															<td class=" text-right">164,368.890 </td>
// 															<td class="">Lantai II tower WTD</td>
// 															<td class="">Air Pre-Treatment</td>
// 														</tr>';

// echo "<table>".$detail_records."</table>";
// echo "<pre>".print_r($respon['result'][1]['FLOWMETER'],true)."</pre>";
// exit();

// $header=array(
// 	'minggu'=>$respon['result'][0]['TANGGAL_URUT'],
// );

// ============ Looping td Tanggal =============== //
if ($d3 != "" && $d4 == "") {
	$tanggal .='<td class="text-center tdjudul_list tdtanggal" >'.reformatDate($d3).'</td>';
} elseif ($d4 != "") {
	// $result['header']=$header;
	$begin = new DateTime( "$d3" );
	$end   = new DateTime( "$d4" );
	for($i = $begin; $i <= $end; $i->modify('+1 day')){
		$tanggal .='<td class="text-center tdjudul_list tdtanggal" >'.$i->format("j-M-y").'</td>';
	}
	// foreach($result['header']['minggu'] as $key=>$val){
	// 	$tanggal .='<td class="text-center tdjudul_list tdtanggal" >'.reformatDate($val).'</td>';
	// }
} elseif ($d5 != "") {
	$begin = new DateTime( "$d6-$d5-01" );
	$end   = new DateTime( "$d6-$d5-$tanggalterakhirnya" );
	for($i = $begin; $i <= $end; $i->modify('+1 day')){
		$tanggal .='<td class="text-center tdjudul_list tdtanggal" >'.$i->format("j-M-y").'</td>';
	}
} else {
	$begin = new DateTime( "$d7-01" );
	$end   = new DateTime( "$d7-12" );
	for($i = $begin; $i <= $end; $i->modify('+1 month')){
		$tanggal .='<td class="text-center tdjudul_list tdtanggal" >'.$i->format("M-y").'</td>';
	}
}
// ============ End Looping ================= //	

$headerHTML='<br>
<table class="table2 table-bordered" align="center" width="100%">
								<tr>
									<td rowspan="3" width="80" class="text-center tdjudul" style="border:1px solid #000 !important">
										LOGO
									</td>
									<td rowspan="3" class="text-center">
										<font style="font-size:20px;"><strong><u>LAPORAN PEMAKAIAN AIR</u></strong></font><br>
										<font style="font-size:20px;"><strong>(KONSERVASI PEMAKIAN AIR)</strong></font>
									</td>
									<td width="38" style="border-right:none !important;">No</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" class="noborder" style="border-left:none !important;">-TEST-</td>
								</tr>
								<tr>
									<td width="38" style="border-right:none !important;">Date</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" style="border-left:none !important;">-TEST-</td>
								</tr>
								<tr>
									<td width="38" style="border-right:none !important;">Page</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" style="border-left:none !important;">-TEST-</td>
								</tr>
						</table>
';

$html = '
	<html>
	<head>
		<title>Laporan Pemakaian Air</title>
		'.$css.'
	</head>
	<body>'.$headerHTML.'
		<div class="box1">
			<table class="table4 table-bordered" width="100%">
				<tr>
					<td class="text-center tdjudul_list" width="35" style="border-bottom:1px solid #000;">No</td>
					<td class="text-center tdjudul_list" colspan="2">DEPARTEMENT</td>
					'.$tanggal.'
					<td class="text-center tdjudul_list">Lokasi</td>
					<td class="text-center tdjudul_list">Distribusi</td>
				</tr>
				'.$detail_records.'
			</table>
			
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

$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output(); 
exit;



?>