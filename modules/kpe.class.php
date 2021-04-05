<?php

CLASS KPE
{
	public function __construct()
		{
		$this->CONFIG = new CONFIG();
		// $this->KPE_CONFIG = new KPE_CONFIG();
		$this->KPE_MODULES = new KPE_MODULES();
		$this->KPE_KWH = new KPE_KWH();
		}

	public function kpe_modules($params)
		{
		$this->load->module = $this->KPE_MODULES->load($params);
		return $this;
		}

	public function kpe_kwh($params)
		{
		$this->load->module = $this->KPE_KWH->load($params);
		return $this;
		}

	public function help()
		{
		$result = get_class_methods($this);
		return $result;
		}
} 
$KPE = new KPE();

?>
