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
		$rs['dateline']=date("Y��m��d��",$rs['dateline']);
		$varr[$rs['vid']]=$rs;	
	}
	$smarty->assign("votelist",$varr);
	//ͶƱ�Ƽ�
	$smarty->assign("where",'<a href="index.php">��ҳ</a>>>ͶƱ');
	$smarty->assign("topvote",$db->getAll("select * from ".table('vote')." where isding=1 AND  shopid=".$_SESSION['ssshopid']."  limit 10  "));
	//seoѡ��
	$smarty->assign("title",$web['webtitle']);
	$smarty->assign("keywords",$web['webkey']);
	$smarty->assign("description",$web['webdesc']);
	//seoѡ�����
	$smarty->display("vote_cat.html");
	
}elseif($a=='index')
{
	if(empty($_GET['vid']))
	{
		errback('��������');	
	}
	$vid=intval($_GET['vid']);
	$vote=$db->getRow("select * from ".table('vote')." where vid='$vid' AND shopid=".$_SESSION['ssshopid']." ");
	$smarty->assign("vote",$vote);
	//ͳ��ѡƱ���
	$sql="select s.*,t.* from ".table('vote_sele')." as  s  "
		." left join ".table('vote_tt')." as t on s.tid=t.tid where s.vid='$vid' AND s.shopid=".$_SESSION['ssshopid']." ";
	$vcount=$db->getOne("select sum(vcount) from ".table('vote_sele')." where vid='$vid' AND  shopid=".$_SESSION['ssshopid']." ");
	$userid=$_SESSION['ss_userid'];
	$ip=$_SERVER['REMOTE_ADDR'];
	//�Լ���ѡ��
	$mysid=$db->getCols("select sid from ".table('vote_user')." where vid='$vid' and (userid='$userid' or ip='$ip')  and shopid=".$_SESSION['ssshopid']."");
	//�Ƿ��Ѿ�ѡ����
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

	$where='<a href="index.php">��ҳ</a>>><a href="index.php?m=vote&a=cat">ͶƱ</a>>>'.$vote['title'];
	$smarty->assign("where",$where);
	$smarty->assign("vselelist",$arr);
	$smarty->assign("topvote",$db->getAll("select * from ".table('vote')." where isding=1 AND  shopid=".$_SESSION['ssshopid']." limit 10  "));
	
		//seoѡ��
	$smarty->assign("title",$vote['title'].'-'.$web['webtitle']);
	$smarty->assign("keywords",$vote['title'].','.$web['webkey']);
	$smarty->assign("description",$vote['detail']);
	//seoѡ�����	
	$smarty->display("vote.html");
}elseif($a=='sele')
{
	$userid=intval($_SESSION['ssuser']['userid']);
	$vid=intval($_POST['vid']);
	$mustjoin=$db->getOne("select mustjoin from  ".table('vote')." where vid='$vid' AND  shopid=".$_SESSION['ssshopid']." ");
	if(empty($userid) && $mustjoin )
	{
		errback('��¼����ܲ���ͶƱ');	
	}
	
	$sidarr=$_POST['sid'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$dateline=strtotime(date("Y-m-d H:i:s"));
	if($db->getOne("select count(*) from ".table('vote_user')." where vid='$vid' and userid='$userid' AND  shopid=".$_SESSION['ssshopid']." ")) errback('���Ѿ�Ͷ���ˣ������ظ���');
	if(is_array($sid))
	{
		foreach($sidarr as $val)
		{
			$db->query("insert into ".table('vote_user')." set vid='$vid',userid='$userid',ip='$ip',dateline='$dateline',sid='$val',shopid=".$_SESSION['ssshopid']." ");
			
		}
		$db->query("update ".table('vote_sele')." set vcount=vcount+1 where sid in("._implode($sidarr).")  ");
		errback("��л����֧��");
	}else
	{
		errback('��ѡ��ͶƱѡ��');	
	}
	
}



?>