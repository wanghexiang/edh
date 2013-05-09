<?php
class shop_Model extends model{
	 
	public function __construct( ){
		parent::__construct( );
		
	}
	
	public function getOne(){
		echo $this->db->getOne("SELECT shopname FROM ".table('shop')." LIMIT 1 ");
	}
	
	public function addClick($shopid){
		$this->db->query("UPDATE ".table('shop')." SET clicks=clicks+1 WHERE shopid='$shopid' ");
	}
	
	
}

?>