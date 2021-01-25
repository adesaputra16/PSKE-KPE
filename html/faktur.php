<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$tanggalsekarang=date('d F Y');
// $mpdf=new mPDF('c','A4','','',10,10,9,10,5,5);

//==============================================================

// $mpdf->pagenumPrefix = 'Halaman ';
// $mpdf->pagenumSuffix = '';
// $mpdf->nbpgPrefix = ' dari ';
// $mpdf->nbpgSuffix = '.';
// $header = array(
// 	'L' => array(
// 	),
// 	'C' => array(
// 	),
// 	'R' => array(
// 		'content' => '{PAGENO}{nbpg}',
// 		'font-family' => 'sans',
// 		'font-style' => '',
// 		'font-size' => '9',	/* gives default */
// 	),
// 	'line' => 1,
// );

$input_option=array(
	'NO_FAKTUR'=>$d3,
);
$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_cetak_faktur",
	'batas'=>1000,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);
$respon=$RMP->rmp_modules($params)->load->module;
$no=1;
$bruto =$respon['respon']['total_kg'];
$potongan =$respon['respon']['potongan'];
$total_potongan = $bruto * ($potongan / 100);
$netto = $bruto - $total_potongan;
$today = date("Y-m-d");
$adm = $respon['respon']['adm'];
$operator =$respon['respon']['operator'];
$qc =$respon['respon']['qc'];
$jenis =$respon['respon']['jenis'];
$relasi= $respon['respon']['relasi'];
$alamat =$respon['respon']['alamat'];
foreach($respon['result'] as $r){
	$datawo[]=$r;
}

foreach ($datawo as $rr ){

$detail_timbang .='
<tr>
<td>
'.$no++.'
</td>
<td>
'.$rr['tgl'].'
</td>
<td>
'.$rr['id_timbang'].'
</td>
<td>
Referensi
</td>
<td>
'.$rr['gross'].' Kg
</td>

</tr>
';
}


$html = '
	<html>
	<head>

		<title>Cetak Faktur</title>
	</head>
<style>
	body {
    font-family:"Arial Black", Gadget, sans-serif;
}
	table {
    border-collapse: collapse;
}

    .table1{
width: 90%;
margin-left:5%;
}

    .table2{
width: 90%;
margin-left:5%;
text-align:center;
}

    .table2 td{
padding-left:7px;
padding-right:7px;
}

	.table1 td {
border-collapse: collapse;
border-spacing: 0;
width: 10%;
border: 1px solid #ddd;
text-align: center;
margin:3%;
}

tr {


}
</style>
	<body>
	<table>
		<tr>
			<td style="width:70%;">
				<table style="width:100%;">
					<tr>
						<td style="padding-left:15%;">
							<img src="/asset/images/logo_label.png" height="52">
						</td>
						<td style="padding-left:15%;">
							<b>PT PULAU SAMBU (KUALA ENOK)</b><br>
							FAKTUR TIMBANG KELAPA BULAT '.$jenis.'<br>
							COCONUT WEIGHT INVOICE
						</td>
					</tr>
				</table>
			</td>
			<td style="padding-left: 57%;">
			<table >
				<tr>
					<td>
						Faktur No.
					</td>
					<td>
						:
					</td>
					<td>
						'.$datawo[0]['RMP_FAKTUR_NO_FAKTUR'].'
					</td>
				</tr>
				<tr>
					<td>
						Tanggal
					</td>
					<td>
						:
					</td>
					<td>
						'.$today.'
					</td>
				</tr>
				<tr>
					<td>
						Halaman
					</td>
					<td>
						:
					</td>
					<td>

					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	<br>
	<table style="width:100%;">
		<tr>
			<td style="padding-left:5%;">
			Nama
			</td>
			<td>
			:
			</td>
			<td>
			'.$relasi.'
			</td>

				<td style="padding-left: 20%;">
			Via Kapal
			</td>
			<td>
			:
			</td>
			<td>
			'.$datawo[0]['RMP_FAKTUR_KAPAL'].'
			</td>
		</tr>
		<tr>
			<td style="padding-left:5%;">
			Alamat
			</td>
			<td>
			:
			</td>
			<td>
			'.$alamat.'
			</td>

				<td style="padding-left: 20%;">
			No Rekening
			</td>
			<td>
			:
			</td>
			<td>
			-
			</td>
		</tr>
	</table>
	<br>
	<table class="table1">
		<tr>
			<td class="td1">
			No.
			</td>
			<td>
			Tanggal / Jam
			</td>
			<td>
			Timbangan
			</td>
			<td>
			Referensi
			</td>
			<td>
			Gross
			</td>
		</tr>
		'.$detail_timbang.'
		<tr>
			<td colspan="4">
			<center>Berat Bruto</center>
			</td>

			<td>
			'.$bruto.' Kg
			</td>

		</tr>
		<tr>
			<td colspan="4">
			<center>Potongan</center>
			</td>

			<td>
			'.$potongan.' %
			</td>

		</tr>
		<tr>
			<td colspan="4">
			<center>Berat Netto</center>
			</td>

			<td><b>
			'.round($netto).' Kg
			</b></td>

		</tr>
    </table>
    <br>
    <br>
    <br>
    <table class="table2">
        <tr>
            <td>Ditimbang Oleh</td>
            <td>Diinspeksi Oleh</td>
            <td>Dibuat Oleh</td>
            <td>Dikalkulasi Oleh</td>
            <td>Disetujui Oleh</td>
        </tr>
		<tr>
			<td><select class="form-control operator list_requestid" name="operator" id="operator" onchange="onchange_data_list()">
				<option value="">--Operator Timbang--</option>
			</select><hr>Opr Timbang 
				<input type="hidden" class="operator_nik form-control" name="operator_nik" id="operator_nik"></td>
			<td><select class="form-control qc list_requestid" name="qc" id="qc" onchange="onchange_data_list()">
				<option value="">--Inspektur Mutu--</option>
			</select><hr>Inspektur Mutu
				<input type="hidden" class="qc_nik form-control" name="qc_nik" id="qc_nik"></td>
			<td><img width="50" height="50" src="asset/platform/files/ttd/'.$adm.'.png"><hr>ADM RMPr-KB</td>
			<td><img width="50" height="50" src="asset/platform/files/ttd/5327.png"><hr>Purchaser</td>
			<td><br><br><br><hr>Dept. Head PCH</td>
		</tr>
    </table>

    <script>function filter(){ window.location="";} function search(){ window.location="";}</script>

    <script type="text/javascript" src="asset/platform/js/approve.modal.js"></script>
    <script type="text/javascript" src="asset/platform/js/last_activity.js"><script>
    <script src="asset/js_80/bootstrap.js"></script>
    <script src="asset/js_80/bootstrap.min.js"></script>
	<script src="aplikasi/'.$_SESSION["aplikasi"].'/asset/js/pdfobject.js"></script>
	<script>
		PDFObject.embed("cloud/pkb/"+"'.$respon['result']['spl']['items'][0]['TOOL_FILES_NAME'].'", "#example1", {height: ""+"'.$respon['result']['spl']['items'][0]['TOOL_FILES_HEIGHT'].'"+"px"});
		
		
		function setLastActivity(){
			var params="SISTEM_LAST_ACTIVITY_NOREF='.$respon['result']['spl']['items'][0]['recruitment_pkb_draft_ID'].'&SISTEM_LAST_ACTIVITY_INDEXREF='.$respon['result']['spl']['items'][0]['recruitment_pkb_draft_INDEX'].'&SISTEM_LAST_ACTIVITY_TABEL=recruitment_pkb_draft";
				lastActivity_Act(params);
		}
		$(function(){
			setLastActivity();
		});
		setInterval(function () {
			setLastActivity();
		},8000);
	</script>		

	</body>
	</html>
';


$footer = '
<br>
<table width="100%" style="vertical-align: top; font-size: 10px;"><tr>
<td width="50%" align="left"></td><td class="text-right"> {PAGENO}{nbpg} </td>
</tr></table>
';

// echo $html;
// exit;
//$mpdf->SetHeader($header,'O');
//$mpdf->SetHTMLFooter($footer);
//==============================================================
// $mpdf->SetDisplayMode('fullpage');
// $mpdf->WriteHTML($html);
// $mpdf->Output();

echo $headerHTML;
echo $html;
echo $footer;

exit;

//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>
