<?php
class seo_model extends model{
	public $db;
	function __construct(){
		parent::__construct();
			
	}
	
	public function get($siteid,$m,$a){
		return $this->db->getRow("SELECT title,keywords,description FROM ".table('seo')." WHERE m='$m' AND a='$a' AND siteid='$siteid' ");	
	}
	
	
}

?>