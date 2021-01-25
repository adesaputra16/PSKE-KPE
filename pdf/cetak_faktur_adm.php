<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$tanggalsekarang=date('d F Y');
$mpdf=new mPDF('c','A4','','',10,10,30,10,5,5);

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
$material =substr(base64_decode($d5),0,-2);
$rp_kg =base64_decode($d4);
$printed =base64_decode($d6);

$input_option=array(
	'NO_FAKTUR'=>$d3
);


$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_cetak_faktur_adm",
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
$netto = $bruto - round($total_potongan);
$kelapa = round($netto)*round($rp_kg);
$today = date("Y-m-d");
$tanggal = tanggal_format(Date("Y-m-d",strtotime($respon['tanggal_faktur'])));

$adm =$respon['respon']['adm'];
$admnama =$respon['respon']['admnama'];

$operator =$respon['respon']['operator'];
$operatornama =$respon['respon']['operatornama'];

$purchaser =$respon['respon']['purchaser'];
$purchasernama =$respon['respon']['purchasernama'];

$qc =$respon['respon']['qc'];
$qcnama =$respon['respon']['qcnama'];

$jenis =$respon['respon']['jenis'];
$relasi =$respon['respon']['relasi'];
$catatan_supplier =$respon['respon']['catatan_supplier'];
$catatan_purchaser =$respon['respon']['catatan_purchaser'];

$alamat =$respon['respon']['alamat'];
$lokasi =$respon['respon']['lokasi'];


$diterima =$respon['diterima'];
$inspeksi =$respon['inspeksi'];
$dipisah =$respon['dipisah'];
$supplier =$respon['supplier'];
$supplier_sub =$respon['supplier_sub'];
if($supplier_sub == "")
{
	$nama_supplier = $supplier;
}
else {
	$nama_supplier = $supplier.' / '.$supplier_sub;
}
$rekening =$respon['rekening'];
$tambang =$respon['tambang'];
$biaya =$respon['biaya'];
$cek_tambang =$respon['cek_tambang'];
$cek_biaya =$respon['cek_biaya'];

$total_jumlah = $kelapa+$tambang+$biaya;
if($diterima == 'Y')
{
	$check_diterima = 'checked.png';
}
else
{
	$check_diterima = 'check.png';
}

if($inspeksi == 'Y')
{
	$check_inspeksi = 'checked.png';
}
else
{
	$check_inspeksi = 'check.png';
}

if($dipisah == 'Y')
{
	$check_dipisah = 'checked.png';
}
else
{
	$check_dipisah = 'check.png';
}
foreach($respon['result'] as $r){
	$detail_timbang .='
	<tr>
	<td>
	'.$no++.'
	</td>
	<td>
	'.$r['RMP_FAKTUR_DETAIL_TANGGAL'].'
	</td>
	<td>
	'.$r['RMP_FAKTUR_DETAIL_ID_TIMBANG'].'
	</td>
	<td>
	'.$r['RMP_FAKTUR_DETAIL_REF'].'
	</td>
	<td>
	'.$r['RMP_FAKTUR_DETAIL_BRUTO'].' Kg
	</td>
	<td>
	'.$r['RMP_FAKTUR_DETAIL_TARA'].' Kg
	</td>
	<td>
	'.number_format($r['RMP_FAKTUR_DETAIL_BRUTO'],0,",",".").' Kg
	</td>

	</tr>
	';
}

$headerHTML = '<table>
	<tr>
		<td>
			<table>
				<tr>
					<td>
						<img src="/asset/images/logo_label.png" height="52">
					</td>
					<td>
						<b>PT PULAU SAMBU (KUALA ENOK)</b><br>
						FAKTUR TIMBANG KELAPA BULAT <br>
						KELAPA '.$material.'
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 90px;">
		<table>
		<tr>
		<td colspan="3">
		</td>
		</tr>
			<tr>
				<td>
					Faktur No.
				</td>
				<td>
					:
				</td>
				<td>
					'.$respon['result'][0]['RMP_FAKTUR_NO_FAKTUR'].'
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

		<title>Cetak Faktur</title>
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
text-align: center;
}

	.table2{
width: 90%;
margin-left:5%;
text-align:center;
font-size :13px;
}

	.table2 td{
padding-left:7px;
padding-right:7px;

}

tr {


}
</style>
	<body>


	<table>
		<tr>
			<td>
			Nama
			</td>
			<td>
			:
			</td>
			<td>
			'.$nama_supplier.'
			</td>

				<td style="padding-left: 300;">
			Via Kapal
			</td>
			<td>
			:
			</td>
			<td>
			'.$respon['result'][0]['RMP_FAKTUR_KAPAL'].'
			</td>
		</tr>
		<tr>
			<td>
			Alamat
			</td>
			<td>
			:
			</td>
			<td>
			'.$lokasi.'
			</td>
				<td style="padding-left: 300;">
			No Rekening
			</td>
			<td>
			:
			</td>
			<td>
			'.$rekening.'
			</td>
		</tr>
	</table>
	<br>

	<table class="table">
		<tr>
			<td>
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
			<td>
			Tara
			</td>
			<td>
			Bruto
			</td>
		</tr>
		'.$detail_timbang.'
		<tr>
			<td colspan="6">
			</td>

			<td>
			'.number_format($bruto,0,",",".").' Kg
			</td>

		</tr>


	</table >
	<br>
	<table>
		<tr>
		<td>Berat Bruto</td>
		<td>: </td>
		<td style="text-align:right">'.number_format($bruto,0,",",".").' </td>
		<td>Kg</td>
		</tr>
		<tr>
		<td>Potongan ('.$potongan.' %)</td>
		<td>: </td>
		<td style="text-align:right">'.number_format($total_potongan,0,",",".").' </td>
		<td>Kg</td>
		</tr>
		<tr>
		<td>Berat Netto</td>
		<td>: </td>
		<td style="text-align:right">'.number_format(round($netto),0,",",".").' </td>
		<td>Kg</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_diterima.'" width="10" /> Bisa Diterima</td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_inspeksi.'" width="10" /> 100 % Inspeksi</td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_dipisah.'" width="10" /> Dipisah</td>
		</tr>
		<tr>
		<td><br></td>
		</tr>
		<tr>
		<td>Catatan : </td>
		<td colspan="3">'.$catatan_supplier.'</td>
		</tr>
		<tr>
		<td></td>
		<td colspan="3">'.$catatan_purchaser.'</td>
		</tr>
	</table>
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
			<td><img width="50" height="54" src="asset/platform/files/ttd/'.$operator.'.png"><br><br>'.$operatornama.'<hr>Opr Timbang </td>
			<td><img width="50" height="54" src="asset/platform/files/ttd/'.$qc.'.png"><br><br>'.$qcnama.'<hr>Inspektur Mutu</td>
			<td><img width="50" height="54" src="asset/platform/files/ttd/'.$adm.'.png"><br><br>'.$admnama.'<hr>ADM RMPr-KB</td>

			<td><br><br><br><br>&nbsp;<hr>Purchaser</td>
			<td><br><br><br><br>&nbsp;<hr>Dept. Head PCH</td>
		</tr>
	</table>
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
//$mpdf->SetHeader($header,'O');
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
