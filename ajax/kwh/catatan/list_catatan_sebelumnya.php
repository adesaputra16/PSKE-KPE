<?php
$input_option = array();

foreach($_POST as $key => $val)
	{
		if ($key == "ref")
			{
			}
		else
			{
			$input_option["$key"] = str_replace("'", "`", $val);
			}
	}

$params = array(
	'case' => "nonlogin_list_catatan_sebelumnya",
	'batas' => $_POST['batas'],
	'halaman' => $_POST['halaman'],
	'data_http' => $_COOKIE['data_http'],
	'token_http' => $_COOKIE['token_http'],
	'input_option' => $input_option,
);

$respon = $KPE->kpe_kwh($params)->load->module;
print json_encode($respon);

exit();
?>
