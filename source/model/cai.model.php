<?php
class cai_model extends model{
	public $db;
	function __construct(){
		parent::__construct();
	}
	
	public function getByWeek($shopid,$showday=1){
		$arr=array();
		$week=getweek();
		 $j=$showday;
		for($i=0;$i<$j;$i++){
			if($week>7){
				$week=$week-7;
			}
			 
			$arr[$week]['catid']=$week;
			$arr[$week]['cname']=$this->getweekname($week);
			$arr[$week]["cailist"]=$this->cailist(" AND shopid='$shopid' AND week{$week}=1 ");
			$week++;
		}
		 
		return $arr;
		
	}
	
	public function cailist($w="",$order="",$start=0,$limit=0){
		$order=$order?$order:" id DESC ";
		$limit=$limit?" LIMIT $start,$limit ":"";
		return $this->db->getAll("SELECT * FROM ".table('cai')." WHERE 1 $w ORDER BY $order $limit ");
	}
	
	public function getweekname($week){
		switch($week){
			case 1: 
				return "����һ";
				break;
			case 2:
				return "���ڶ�";
			case 3:
				return "������";
			case 4:
				return "������";
			case 5:
				return "������";
			case 6:
				return "������";
			case 7:
				return "������";
		}
	}
	
}
?>