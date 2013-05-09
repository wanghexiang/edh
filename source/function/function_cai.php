<?php
/**
美食列表函数
*/
/*某个商店美食列表*/
function shopcailist($shopid,$w='',$ord='')
{
	global $db,$shopcarinfo; 
	if($shopcarinfo['caiids'])
	{
		$caiids=$shopcarinfo['caiids'];
	}
	
	//商店配置
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid='$shopid' ");
	$opentype="doing";
	if($shopconfig['opentime']==1)
	{
		$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
	}
	//获取星期几
	$week=getweek();
	
	$arr=array();
	$sql=" select * from ".table('cai')."  where shopid='$shopid' AND visible=1 $w ";
	$sql.=$ord?" {$ord} ":" order by id desc ";
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		
		//判断是否在购物车
		$rs['in_cart']=$caiids[$rs['id']]?1:0;
		//可购买参数
		$rs['shopping']=1;
		//缺货
		if($rs['oos']==1)
		{
			$rs['shopping']=0;
		}
		
		
		if($shopconfig['showweek'])
		{
			if(!$cai["week{$week}"])
			{
				$rs['shopping']=0;
			}
			
		}
		if($opentype!='doing')
		{
			$rs['shopping']=0;
		}
		
		$arr[]=$rs;	
		
	}
	
	return $arr;
}


/*获取指定多个分类下的美食*/
function catcailist($catid=array(),$limit=10)
{
	global $db,$smarty;
	$arr=array();
	$file="catcailist_".$_SESSION['ssshopid'].".sql";
	$cachetime=60;
	if(is_sqlcache($file,$cachetime))
	{
		$arr=getsqlcache($file);
	}else
	{
		$sql="select catid,cname from ".table('cai_cat')." WHERE 1=1  ";
		$sql.=count($catid)>0?" AND  catid in("._implode($arr).")":"";
		$sql.=" order by orderid asc";
		$res=$db->query($sql);
		while($rs=$db->fetch_array($res))
		{
			$rs['cai']=cailist(" and catid =".$rs['catid'],"",0,$limit);
			
			$smarty->assign("catcailist_".$rs['catid'],$rs['cai']);
			$arr[]=$rs;
		}
		setsqlcache($file,$arr);
	}
	return $arr;
}


/*美食 点评相关*/

function pingcai($caiid,$ctype)
{
	global $db;
	$userid=intval($_SESSION['ssuser']['userid']);
	$ip=$_SERVER['REMOTE_ADDR'];
	if($userid)
	{
	$ct=$db->getOne("select count(*) from ".table('cai_ping')." where caiid='$caiid' and ctype='$ctype' and userid='$userid'  ");
	}else
	{
	$ct=$db->getOne("select count(*) from ".table('cai_ping')." where caiid='$caiid' and ctype='$ctype' and   ip='$ip' ");	
	}
	if($ct) return false;
	$db->query("insert into ".table('cai_ping')." set caiid='$caiid',ctype='$ctype',userid='$userid',ip='$ip' ");
	return true;	
	
}


function weekcailist($week,$shopid)
{
	global $smarty,$db;
	switch($week)
	{
		case 1:
				$w=" week1=1 ";
				break;
		case 2:
				$w=" week2=1 ";
				break;
		case 3:
				$w=" week3=1 ";
				break;
		case 4:
				$w=" week4=1 ";
				break;
		case 5: 
				$w=" week5=1 ";
				break;
		case 6: 
				$w="week6=1 ";
				break;
		case 7 :
				$w="week7=1";
				break;				
	}
	$arr=array();
	$res=$db->query("select * from ".table('cai')." where visible=1  and shopid=".$shopid." and $w ");
	while($rs=$db->fetch_array($res))
	{
		if($week==getweek())
		{
			$rs['shopping']=1;
		}
		if($rs['oos']==1)
		{
			$rs['shopping']=0;
		}
		$arr[]=$rs;
	}
	return $arr;
}
//所有的美食 按星期分类
function allweekcailist($shopid)
{
	global $db,$smarty;
	$week=getweek();//当前星期几
	$arr=$w1=$w2=$w3=$w4=$w5=$w6=$w7=array();
	$res=$db->query("select * from ".table('cai')." where visible=1   and shopid=".$shopid." ");
	while($rs=$db->fetch_array($res))
	{
		if($rs['week1'])
		{
			if($week==1)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w1[]=$rs;
			
		}
		if($rs['week2'])
		{
			if($week==2)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w2[]=$rs;
		}
		if($rs['week3'])
		{
			if($week==3)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w3[]=$rs;
		}
		if($rs['week4'])
		{
			if($week==4)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w4[]=$rs;
		}
		if($rs['week5'])
		{
			if($week==5)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w5[]=$rs;
		}
		if($rs['week6'])
		{
			if($week==6)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w6[]=$rs;
		}
		if($rs['week7'])
		{
			if($week==7)
			{
				$rs['shopping']=1;
			}else
			{
				$rs['shopping']=0;
			}
			if($rs['oos']==1)
			{
				$rs['shopping']=0;
			}
			$w7[]=$rs;
		}
	}
	return array(
					"week1"=>$w1,
					"week2"=>$w2,
					"week3"=>$w3,
					"week4"=>$w4,
					"week5"=>$w5,
					"week6"=>$w6,
					"week7"=>$w7
					);
}


