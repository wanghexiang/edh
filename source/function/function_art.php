<?php
/**
文章列表函数
*/
function artlist($w='',$ord='',$start='',$limit='')
{
	
	global $db;
	$arr=array();
	$res=$db->query("select catid,cname from ".table('art_cat')."    ");
	while($r=$db->fetch_array($res))
	{
		$cats[$r['catid']]=$r['cname'];
	}
	$sql="select * from ".table('art')." where siteid=".$GLOBALS['cksiteid']." ";
	$sql.=$w?" {$w} ":" ";
	$ord=$ord?$ord:" order by   id desc ";
	$sql.=$ord;
	$sql.=$limit?" limit {$start},{$limit}":" ";
	
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{

		$rs['cname']=$cats[$rs['catid']];
		$arr[$rs['id']]=$rs;
	}
	
	return $arr;
}

/*
获取文章分类
$pid 文章分类
*/
function art_cat($catid=0)
{
	global $db;
	$catid=intval($catid);
	$arr=array();
	$sql="select catid,pid,cname from ".table('art_cat')." where  1=1 ";
	$sql.=$catid?" and catid='$catid' ":" and pid=0 ";
	$res=$db->query($sql);
	while(@$rs=$db->fetch_array($res))
	{
		$rs['child']=@$db->getAll("select catid,cname,pid from ".table('art_cat')." where pid=".$rs['catid']."  ");
		
		
		
		$arr[$rs['catid']]=$rs;
		if(empty($rs['child']) && $catid)
		{
			
			$a=@$db->getAll("select catid,cname,pid from ".table('art_cat')." where pid=".$rs['pid']." and catid<>'$catid'  ");
			$arr=array_merge($arr,$a);
		}
	
	
	
	
	
	}
	return $arr;
}
/*获取文章分类 子类*/
function getchildid($catid)
{
	global $db;
	$catids=$db->getCols("select catid from ".table('art_cat')." where pid=".intval($catid)." ");
	return array_merge($catids,array($catid));
}

/*获取文章分类 子类*/
function getartchildid($catid)
{
	global $db;
	$catids=$db->getCols("select catid from ".table('art_cat')." where pid=".intval($catid)." ");
	return array_merge($catids,array($catid));
}
/*获取文章*/
function getarts($v='',$catid=0,$w='',$ord='ORDER BY ID DESC',$limit=10)
{
	global $smarty,$db;
	$catids=$db->getCols("SELECT catid FROM ".table('art_cat')." WHERE pid=".intval($catid)." ");
	if($catid)
	{
	$catids[]=$catid;
	}
	$sql="SELECT title,id,dateline,click FROM ".table('art')." WHERE status>=0 ";
	$sql.=$catid?" AND catid in("._implode($catids).") ":"";
	$sql.=$w?" $w ":"";
	$sql.=$ord?" $ord ":" ORDER BY ID DESC ";
	$sql.=$limit?"LIMIT $limit":" LIMIT 10 ";
	$arr=$db->getAll($sql);
	
	$smarty->assign($v,$arr);
		
}

