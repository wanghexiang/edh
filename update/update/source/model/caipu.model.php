<?php
class caipu_Model extends model{
	function __construct(){
		parent::__construct();
	}
	
	function catlist($pid=0,$key=0){
		$data=$this->db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid=".intval("pid")." ");
		if($data && $key){
			foreach($data as $k=>$v){
				$catlist[$v['catid']]=$v['cname'];
			}
			return $catlist;
		}
		return $data;
	}
	
	function all_cat(){
		$data=$this->db->getAll("SELECT * FROM ".table('caipu_cat')."   ");
		if($data ){
			foreach($data as $k=>$v){
				$catlist[$v['catid']]=$v['cname'];
			}
			return $catlist;
		}
	}
	
	
}
?>