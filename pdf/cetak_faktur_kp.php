<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");

$tanggalsekarang=date('d F Y');
$mpdf=new mPDF('c','A4','','',10,10,30,40,5,5);

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
$material =base64_decode($d5);
$rp_kg =base64_decode($d4);
$printed =base64_decode($d6);

$input_option=array(
	'NO_FAKTUR'=>$d3,
	'MATERIAL'=>$material
);


$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_cetak_faktur_kp",
	'batas'=>1000,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);
$respon=$RMP->rmp_modules($params)->load->module;
$no=1;
$bruto =$respon['respon']['total_kg'];
$total_potongan = $bruto * ($potongan / 100);
$netto = $respon['netto'];


$kelapa = $respon['rp_kelapa'];
$today = date("Y-m-d");
$tanggal = tanggal_format(Date("Y-m-d",strtotime($respon['tanggal_faktur'])));


$adm =$respon['respon']['adm'];
$admnama =$respon['respon']['admnama'];

$operator =$respon['respon']['operator'];
$operatornama =$respon['respon']['operatornama'];


$purchaser =$respon['respon']['purchaser'];
//$purchasernama =$respon['respon']['purchasernama'];
if($respon['respon']['purchasernama']=="MEIKO ELI SUHESTI LUBIS")
{
	$purchasernama = "MEIKO";
}
else {
	$purchasernama =$respon['respon']['purchasernama'];
}

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
$kotoran =$respon['kotoran'];
$langsung_proses =$respon['langsung_proses'];
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
$goni =$respon['goni'];
$goni_total =$respon['goni_total'];
$cadangan =$respon['cadangan'];
$cek_tambang =$respon['cek_tambang'];
$cek_biaya =$respon['cek_biaya'];
$cek_rp_kg =$respon['cek_rp_kg'];
$cek_goni =$respon['cek_goni'];
$cek_cadangan =$respon['cek_cadangan'];
$kualitet =$respon['kualitet'];
$kualitet_faktur =$respon['kualitet_faktur'];

$rp_kg =$respon['rp_kg'];




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

if($kotoran == 'Y')
{
	$check_kotoran = 'checked.png';
}
else
{
	$check_kotoran = 'check.png';
}

if($langsung_proses == 'Y')
{
	$check_langsung_proses = 'checked.png';
}
else
{
	$check_langsung_proses = 'check.png';
}

if ($printed == "admin")
{
	$rp_kg_cetak = "@Rp ".number_format(round($rp_kg),0,",",".")."";
	$cetak_catatan_purchaser = $catatan_purchaser;
	$kelapa_title = "Kelapa";
	$kelapa_rp = " : Rp.";
	$kelapa_total = number_format($kelapa,0,",",".");

	$tambang_title = "Tambang";
	$tambang_rp = " : Rp.";
	$tambang_total = number_format($tambang,0,",",".");

	$cadangan_title = "Cadangan";
	$cadangan_rp = " : Rp.";
	$cadangan_total = number_format($cadangan,0,",",".");

	$goni_title = "Goni";
	$goni_rp = " : Rp.";
	$goni_total_rp = number_format($goni_total,0,",",".");
	$goni_total = $goni_total;

	$kualitet_title = "KUALITET";
	$kualitet_total = ": ".$kualitet." %";

	$hr = "<hr>";
	$total_jumlah = $kelapa+$tambang+$cadangan+$goni_total;
	$total_jumlah_title = "Jumlah";
	$total_jumlah_rp = " : Rp.";
	$total_jumlah_total = number_format($total_jumlah,0,",",".");
	$terbilang=terbilang($total_jumlah)." Rupiah";

	if ($kualitet <= 75)
	{
		$kualitet_cnf = $kualitet - 2;
	}
	else
	{
		$kualitet_cnf = $kualitet;
	}
	$cnf_title = "CNF";
	$cnf = round($rp_kg/($kualitet_cnf/100));

}

else if ($printed == "beacukai")
{
	$cetak_catatan_purchaser = $catatan_purchaser;
	$kelapa_title = "Kelapa";
	$kelapa_rp = " : Rp.";

	if ($kualitet <= 75)
	{
		$kualitet = $kualitet - 2;
	}
	else
	{
		$kualitet = $kualitet;
	}

	$kualitet_title = "KUALITET";
	$kualitet_total = ": ".$kualitet." %";

	$kelapa_total = number_format(($kelapa+$tambang+$cadangan+$goni_total),0,",",".");
	$terbilang=terbilang($kelapa+$tambang+$cadangan+$goni_total)." Rupiah";

	$rp_kgs = ($kelapa+$tambang+$cadangan+$goni_total) / $netto;
	$rp_kg_cetak = "@Rp ".number_format(round($rp_kgs),0,",",".")."";

	$tambang_title = " ";
	$tambang_rp = " ";
	$tambang_total = " ";

	$biaya_title = " ";
	$biaya_rp = " ";
	$biaya_total = " ";

	$hr = "";

	$total_jumlah_title = " ";
	$total_jumlah_rp = " ";
	$total_jumlah_total = " ";


}

else if ($printed == "relasi")
{
	if($cek_tambang == "Y")
	{
		$tambang_title = "Tambang";
		$tambang_rp = " : Rp.";
		$tambang_total = number_format($tambang,0,",",".");
		$tambang = $tambang;
	}
	else {
		$tambang_title = " ";
		$tambang_rp = " ";
		$tambang_total = " ";
		$tambang = "0";

		$cetak_catatan_purchaser = "";
	}

	if($cek_cadangan == "Y")
	{
		$cadangan_title = "Cadangan";
		$cadangan_rp = " : Rp.";
		$cadangan_total = number_format($cadangan,0,",",".");
		$cadangan = $cadangan;
	}
	else {
		$cadangan_title = " ";
		$cadangan_rp = " ";
		$cadangan_total = " ";
		$cadangan = "0";

		$cetak_catatan_purchaser = "";
	}

	if($cek_goni == "Y")
	{
		$goni_title = "Goni";
		$goni_rp = " : Rp.";
		$goni_total_rp = number_format($goni_total,0,",",".");
		$goni_total = $goni_total;
	}
	else {
		$goni_title = " ";
		$goni_rp = " ";
		$goni_total_rp = " ";
		$goni_total = "0";

		$cetak_catatan_purchaser = "";
	}

	if($kualitet_faktur == "" OR $kualitet_faktur == 0)
	{
		$kualitet_title = "";
		$kualitet_total = "";
	}
	else
	{
		$kualitet_title = "KUALITET";
		$kualitet_total = ": ".$kualitet_faktur." %";
	}

	$kelapa_title = "Kelapa";
	$kelapa_rp = " : Rp.";
	$kelapa_total = number_format($kelapa,0,",",".");

	$total_jumlah = $kelapa+$tambang+$goni_total+$cadangan;
	$terbilang=terbilang($total_jumlah)." Rupiah";
	$hr = "<hr>";

	$total_jumlah_title = "Jumlah";
	$total_jumlah_rp = " : Rp.";
	$total_jumlah_total = number_format($total_jumlah,0,",",".");

	if($cek_rp_kg == "Y")
	{
		$rp_kg_cetak = "@Rp ".number_format(round($rp_kg),0,",",".")."";
	}
	else {
		$rp_kg_cetak = "";

		$tambang_title = " ";
		$tambang_rp = " ";
		$tambang_total = " ";
		$tambang = "0";

		$goni_title = " ";
		$goni_rp = " ";
		$goni_total_rp = " ";
		$goni_total = "0";

		//$cetak_catatan_purchaser = " ";
		$kelapa_title = " ";
		$kelapa_rp = " ";
		$kelapa_total = " ";
		$total_jumlah = " ";
		$terbilang="-";
		$hr = " ";

		$total_jumlah_title = " ";
		$total_jumlah_rp = " ";
		$total_jumlah_total = " ";
	}


}

else if ($printed == "accounting")
{
	$rp_kg_cetak = "@Rp ".number_format(round($rp_kg),0,",",".")."";
	$cetak_catatan_purchaser = $catatan_purchaser;
	$kelapa_title = "Kelapa";
	$kelapa_rp = " : Rp.";
	$kelapa_total = number_format($kelapa,0,",",".");

	$tambang_title = "Tambang";
	$tambang_rp = " : Rp.";
	$tambang_total = number_format($tambang,0,",",".");

	$cadangan_title = "Cadangan";
	$cadangan_rp = " : Rp.";
	$cadangan_total = number_format($cadangan,0,",",".");

	$goni_title = "Goni";
	$goni_rp = " : Rp.";
	$goni_total_rp = number_format($goni_total,0,",",".");
	$goni_total = $goni_total;

	$kualitet_title = "KUALITET";
	$kualitet_total = ": ".$kualitet." %";

	$hr = "<hr>";
	$total_jumlah = $kelapa+$tambang+$cadangan+$goni_total;
	$total_jumlah_title = "Jumlah";
	$total_jumlah_rp = " : Rp.";
	$total_jumlah_total = number_format($total_jumlah,0,",",".");
	$terbilang=terbilang($total_jumlah)." Rupiah";

	if ($kualitet <= 75)
	{
		$kualitet = $kualitet - 2;
	}
	else
	{
		$kualitet = $kualitet;
	}

	$kualitet_title = "KUALITET";
	$kualitet_total = ": ".$kualitet." %";

}
else
{
	$cetak_catatan_purchaser = "";
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
	'.$r['GROSS'].' Kg
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
						FAKTUR TIMBANG KELAPA BASAH / K.C <br>
						<i>COCONUT WET WEIGHT INVOICE</i>
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 90px;">
		<table>
		<tr>
		<td colspan="3">
		<p><font size="2"><i>Printed for '.$printed.'</i></font></p>
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

		<title>Cetak Faktur ('.$printed.')</title>
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
	<table>
		<tr>
		<td>Banyaknya</td>
		<td>: </td>
		<td style="text-align:right">'.number_format($goni,0,",",".").' </td>
		<td>Goni</td>
		<td></td>
		<td></td>
		<td></td>
		<td>'.$kualitet_title.'</td>
		<td>'.$kualitet_total.'</td>
		<td></td>
		</tr>
		<tr>
		<td>Berat Bruto</td>
		<td>: </td>
		<td style="text-align:right">'.number_format($bruto,0,",",".").' </td>
		<td>Kg</td>
		</tr>
		<tr>
		<td>Berat Goni</td>
		<td>: </td>
		<td style="text-align:right">0 </td>
		<td>Kg</td>
		</tr>
		<tr>
		<td>Berat Netto</td>
		<td>: </td>
		<td style="text-align:right">'.number_format(round($netto),0,",",".").' </td>
		<td>Kg</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rp_kg_cetak.'</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>'.$kelapa_title.'</td>
		<td>'.$kelapa_rp.'</td>
		<td align="right">'.$kelapa_total.'</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>'.$tambang_title.'</td>
		<td>'.$tambang_rp.'</td>
		<td align="right">'.$tambang_total.'</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><center><b>'.$cnf_title.'</b></center></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>'.$goni_title.'</td>
		<td>'.$goni_rp.'</td>
		<td align="right">'.$goni_total_rp.'</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><center><b>'.$cnf.'</b></center></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>'.$cadangan_title.'</td>
		<td>'.$cadangan_rp.'</td>
		<td align="right">'.$cadangan_total.'</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3">'.$hr.'</td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_diterima.'" width="10" /> Bisa Diterima</td>
		<td></td>
		<td></td>
		<td></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><b>'.$total_jumlah_title.'</b></td>
		<td><b>'.$total_jumlah_rp.'</b></td>
		<td align="right"><b>'.$total_jumlah_total.'</b></td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_kotoran.'" width="10" /> Kotoran KG/Goni</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_inspeksi.'" width="10" /> 100 % Inspeksi</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_langsung_proses.'" width="10" /> Langsung Proses</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td><img src="aplikasi/rmp/asset/'.$check_dipisah.'" width="10" /> Dipisah</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>

		<tr>
		<td>Catatan : </td>
		<td colspan="3">'.$catatan_supplier.'</td>
		</tr>
		<tr>
		<td></td>
		<td colspan="3">'.$cetak_catatan_purchaser.'</td>
		</tr>
	</table>
<p align="right"><i><b>Terbilang :</b> '.ucwords($terbilang).'</i></p>

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
			<td><img width="50" height="54" src="asset/platform/files/ttd/'.$purchaser.'.png"><br><br>'.$purchasernama.'<hr>Purchaser</td>
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
