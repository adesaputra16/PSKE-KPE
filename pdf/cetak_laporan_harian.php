<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$tanggalsekarang=date('d F Y');
$mpdf=new mPDF('c','A4-L','','',10,10,30,40,5,5);

//==============================================================

$mpdf->pagenumPrefix = '';
$mpdf->pagenumSuffix = '';
$mpdf->nbpgPrefix = ' dari ';
$mpdf->nbpgSuffix = '';
$header = array(
	'L' => array(
	),
	'C' => array(
	),
	'R' => array(
		'content' => '{PAGENO}{nbpg}',
		'font-family' => 'sans',
		'font-style' => '',
		'font-size' => '9',	/* gives default */
	),
	'line' => 1,
);

// $ttd='asset/platform/files/ttd/'.$nik.'.png';
$material =base64_decode($d3);
$tanggal =base64_decode($d4);

$input_option=array(
	'material'=>$material,
	'tanggal'=>$tanggal
);


$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_cetak_laporan_harian_02",
	'batas'=>1000,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);
$respon=$RMP->rmp_modules($params)->load->module;

$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_cetak_laporan_harian_03",
	'batas'=>1000,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);
$respon=$RMP->rmp_modules($params)->load->module;

$no_02=1;
$no_03=1;
foreach($respon['result_02'] as $r){
	$laporan_02 .='
	<tr>
	<td>'.$no_02++.'</td>
	<td>'.$r['RMP_MASTER_PERSONAL_NAMA'].'</td>
	<td>'.$r['RMP_FAKTUR_KAPAL'].'</td>
	<td>'.$r['RMP_FAKTUR_PURCHASER_NO_REKENING'].'</td>
	<td>'.$r['RMP_FAKTUR_NO_FAKTUR'].'</td>
	<td>'.$r['BRUTO_A'].'</td>
	<td>'.$r['PERSEN_A'].'</td>
	<td>'.$r['NETTO_A'].'</td>
	<td>'.$r['RP_KG_A'].'</td>
	<td>'.$r['RP_A'].'</td>
	<td>'.$r['BRUTO_B'].'</td>
	<td>'.$r['PERSEN_B'].'</td>
	<td>'.$r['NETTO_B'].'</td>
	<td>'.$r['RP_KG_B'].'</td>
	<td>'.$r['RP_B'].'</td>
	</tr>
	';
}

foreach($respon['result_03'] as $r){
	$laporan_03 .='
	<tr>
	<td>'.$no_03++.'</td>
	<td>'.$r['RMP_MASTER_PERSONAL_NAMA'].'</td>
	<td>'.$r['RMP_FAKTUR_KAPAL'].'</td>
	<td>'.$r['RMP_FAKTUR_PURCHASER_NO_REKENING'].'</td>
	<td>'.$r['RMP_FAKTUR_NO_FAKTUR'].'</td>
	<td>'.$r['BRUTO_A'].'</td>
	<td>'.$r['PERSEN_A'].'</td>
	<td>'.$r['NETTO_A'].'</td>
	<td>'.$r['RP_KG_A'].'</td>
	<td>'.$r['RP_A'].'</td>
	<td>'.$r['BRUTO_B'].'</td>
	<td>'.$r['PERSEN_B'].'</td>
	<td>'.$r['NETTO_B'].'</td>
	<td>'.$r['RP_KG_B'].'</td>
	<td>'.$r['RP_B'].'</td>
	</tr>
	';
}

$headerHTML = '<table table-unbordered>
	<tr>
		<td>
			<table>
				<tr>
					<td>
						<img src="/asset/images/logo_label.png" height="52">
					</td>
					<td>
						<b>PT PULAU SAMBU (KUALA ENOK)</b><br>
						LAPORAN HARIAN KELAPA BULAT<br>
						KELAPA '.$material.'
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 550px;">
		<table>
			<tr>
				<td>
					Tanggal
				</td>
				<td>
					:
				</td>
				<td>
					'.$tanggal.'
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
				 {PAGENO}{nbpg}
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>';

$html = '
	<html>
	<head>

		<title>Cetak Laporan Harian</title>
	</head>
<style>

	body {
    font-family:"Arial Black", Gadget, sans-serif;
}
	table {
    border-collapse: collapse;

}
	.table td {
border-collapse: collapse;
border-spacing: 0;
width: 100%;
border: 1px solid #ddd;
padding: 5px 5px;
}


	.table2 {
font-size: 10px;


}

tr {


}
</style>
	<body>

	<table class="table table2">
		<tr>
			<td rowspan="2">No.</td>
			<td rowspan="2">Nama</td>
			<td rowspan="2">Alamat</td>
			<td rowspan="2">Rekening</td>
			<td rowspan="2">Nomor Faktur</td>
			<td colspan="5"><center>KB-A</center></td>
			<td colspan="5"><center>KB-B</center></td>
		</tr>
		<tr>
      <td><center>Kg BRUTO</center></td>
      <td><center>%</center></td>
      <td><center>Kg NETTO</center></td>
      <td id="td_rp_a">@Rp</td>
      <td><center>Rp</center></td>

      <td><center>Kg BRUTO</center></td>
      <td><center>%</center></td>
      <td><center>Kg NETTO</center></td>
      <td id="td_rp_b">@Rp</td>
      <td><center>Rp</center></td>
    </tr>
		'.$laporan_02.'
		<tr><td> </td></tr>
		'.$laporan_03.'



	</table >
	</body>
	</html>
';


$footer = '
<table width="100%" style="vertical-align: top; font-size: 10px;"><tr>
<td width="50%" align="left"></td><td class="text-right"> {PAGENO}{nbpg} </td>
</tr></table>
';

// echo $html;
// exit;
$mpdf->SetHTMLHeader($headerHTML);
//$mpdf->SetHTMLFooter($footer);
//==============================================================
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>
