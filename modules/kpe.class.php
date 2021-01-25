<?php

CLASS KPE
{
	public function __construct()
		{
		$this->CONFIG = new CONFIG();
		//$this->RMP_CONFIG = new RMP_CONFIG();
		$this->KPE_MODULES = new KPE_MODULES();
		}

	public function kpe_modules($params)
		{
		$this->load->module = $this->KPE_MODULES->load($params);
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
