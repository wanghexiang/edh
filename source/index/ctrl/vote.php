<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$a=$_REQUEST['a'];
if(empty($a))
{
$a='index';	
}
if($a=='cat')
{
	$sql="select * from ".table('vote')." where    shopid=".$_SESSION['ssshopid']." order by vid desc ";
	$pagesize=10;
	$page=max(1,intval($_GET['page']));
	$rscount=$db->getOne("select count(*) from ".table('vote')." WHERE  shopid=".$_SESSION['ssshopid']." ");
	$start=($page-1)*$pagesize;
	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=vote&"));
	$sql.=" limit $start,$pagesize ";
	$res=$db->query($sql);
	$varr=array();
	while($rs=$db->fetch_array($res))
	{
		$rs['dateline']=date("Y年m月d日",$rs['dateline']);
		$varr[$rs['vid']]=$rs;	
	}
	$smarty->assign("votelist",$varr);
	//投票推荐
	$smarty->assign("where",'<a href="index.php">首页</a>>>投票');
	$smarty->assign("topvote",$db->getAll("select * from ".table('vote')." where isding=1 AND  shopid=".$_SESSION['ssshopid']."  limit 10  "));
	//seo选项
	$smarty->assign("title",$web['webtitle']);
	$smarty->assign("keywords",$web['webkey']);
	$smarty->assign("description",$web['webdesc']);
	//seo选项结束
	$smarty->display("vote_cat.html");
	
}elseif($a=='index')
{
	if(empty($_GET['vid']))
	{
		errback('参数出错');	
	}
	$vid=intval($_GET['vid']);
	$vote=$db->getRow("select * from ".table('vote')." where vid='$vid' AND shopid=".$_SESSION['ssshopid']." ");
	$smarty->assign("vote",$vote);
	//统计选票情况
	$sql="select s.*,t.* from ".table('vote_sele')." as  s  "
		." left join ".table('vote_tt')." as t on s.tid=t.tid where s.vid='$vid' AND s.shopid=".$_SESSION['ssshopid']." ";
	$vcount=$db->getOne("select sum(vcount) from ".table('vote_sele')." where vid='$vid' AND  shopid=".$_SESSION['ssshopid']." ");
	$userid=$_SESSION['ss_userid'];
	$ip=$_SERVER['REMOTE_ADDR'];
	//自己所选的
	$mysid=$db->getCols("select sid from ".table('vote_user')." where vid='$vid' and (userid='$userid' or ip='$ip')  and shopid=".$_SESSION['ssshopid']."");
	//是否已经选择了
	$smarty->assign("ischoiced",$db->getOne("select count(id) from ".table('vote_user')." where (userid='$userid' or ip='$ip') and vid='$vid' AND  shopid=".$_SESSION['ssshopid']." "));
	

	$arr=array();
	$res=$db->query($sql);

	while($rs=$db->fetch_array($res))
	{
		$rs['vbi']=@ceil($rs['vcount']*100/$vcount);
		if(is_array($mysid))
		{
			if(in_array($rs['sid'],$mysid))
			{
				$rs['mychoice']=1;
			}
		}
		$arr[$rs['sid']]=$rs;
	}

	$where='<a href="index.php">首页</a>>><a href="index.php?m=vote&a=cat">投票</a>>>'.$vote['title'];
	$smarty->assign("where",$where);
	$smarty->assign("vselelist",$arr);
	$smarty->assign("topvote",$db->getAll("select * from ".table('vote')." where isding=1 AND  shopid=".$_SESSION['ssshopid']." limit 10  "));
	
		//seo选项
	$smarty->assign("title",$vote['title'].'-'.$web['webtitle']);
	$smarty->assign("keywords",$vote['title'].','.$web['webkey']);
	$smarty->assign("description",$vote['detail']);
	//seo选项结束	
	$smarty->display("vote.html");
}elseif($a=='sele')
{
	$userid=intval($_SESSION['ssuser']['userid']);
	$vid=intval($_POST['vid']);
	$mustjoin=$db->getOne("select mustjoin from  ".table('vote')." where vid='$vid' AND  shopid=".$_SESSION['ssshopid']." ");
	if(empty($userid) && $mustjoin )
	{
		errback('登录后才能参与投票');	
	}
	
	$sidarr=$_POST['sid'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$dateline=strtotime(date("Y-m-d H:i:s"));
	if($db->getOne("select count(*) from ".table('vote_user')." where vid='$vid' and userid='$userid' AND  shopid=".$_SESSION['ssshopid']." ")) errback('你已经投过了，不能重复！');
	if(is_array($sid))
	{
		foreach($sidarr as $val)
		{
			$db->query("insert into ".table('vote_user')." set vid='$vid',userid='$userid',ip='$ip',dateline='$dateline',sid='$val',shopid=".$_SESSION['ssshopid']." ");
			
		}
		$db->query("update ".table('vote_sele')." set vcount=vcount+1 where sid in("._implode($sidarr).")  ");
		errback("感谢您的支持");
	}else
	{
		errback('请选择投票选项');	
	}
	
}



?>