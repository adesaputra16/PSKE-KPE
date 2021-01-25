<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");


$mpdf=new mPDF('c','A4','','',10,10,9,10,5,5); 

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
		
	</style>";

$input_option=array(
    'idFlowmeter'=>$d3,
    'lokasiFlowmeter'=>$d4,
);
$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_tampil_flowmeter",
	'batas'=>30,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);
//$respon=$WO_MASTER->wo($params)->load->module;
$respon = $KPE->kpe_modules($params)->load->module;
//print json_encode($respon);
$no=1;
foreach($respon['result'] as $r){
	$detail_records .='<tr height="'.$height.'">
							<td valign="top" align="right"  height="'.$height.'">'.$no.'.</td>
							<td valign="top" >'.$r['KPE_AIR_FLOWMETER_NAMA'].'</td>
							<td valign="top" >'.$r['KPE_AIR_FLOWMETER_LOKASI'].'</td>
                        </tr>';
                        $no++;
}


#echo "<pre>".print_r($respon,true)."</pre>";
//exit();




$headerHTML='<br>
<table class="table2 table-bordered" align="center" width="100%">
								<tr>
									<td rowspan="3" width="80" class="text-center tdjudul" style="border:1px solid #000 !important">
										LOGO
									</td>
									<td rowspan="3" class="text-center">
										<font style="font-size:20px;"><strong><u>FLOWMETER</u></strong></font><br>
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
		<title>Flowmeter</title>
		'.$css.'
	</head>
	<body>'.$headerHTML.'
		<div class="box1">
			
		
			<table class="table4 table-bordered" width="100%">
				<tr>
					<td class="text-center tdjudul_list" width="35" style="border-bottom:1px solid #000;">No</td>
					<td class="text-center tdjudul_list">Nama Flowmeter</td>
					<td class="text-center tdjudul_list">Lokasi Flowmeter</td>
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