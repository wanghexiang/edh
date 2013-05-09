<?php
class ct_version{

	public $version="1.8.1";
	public $ctname="口福科技餐饮系统v";
	function __construct()
	{
		
	}
	function version()
	{
		return "当前版本为：".$this->ctname.$this->version;
	}
}


?>