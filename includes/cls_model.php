<?php
class model{
	public $db;
	function __construct(){
		$this->db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
	}
	
}
