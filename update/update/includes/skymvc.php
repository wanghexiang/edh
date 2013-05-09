<?php
if(!defined("ROOT_PATH")){
	define('ROOT_PATH',  str_replace('\\', '/', dirname(__FILE__))."/");
}
class skymvc{
	public $db;
	public $smarty;
	public $cache_dir; 
	public $compile_dir;
	public $template_dir;
	function __construct(){
		$this->cache_dir=ROOT_PATH . 'temp/caches';
		$this->compile_dir = ROOT_PATH.'temp/compiled'; 
		$this->template_dir= ROOT_PATH . "themes/default";	
	}
	
	public function init(){
		$this->db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
		$this->smarty=new Smarty();
		$this->smarty->caching=true;
		$this->smarty->cache_lifetime = 3600;
		$this->smarty->cache_dir      = $this->cache_dir;
		$this->smarty->compile_dir    = $this->compile_dir;		
		$this->smarty->template_dir   = $this->template_dir;
	}
	
	
}

?>