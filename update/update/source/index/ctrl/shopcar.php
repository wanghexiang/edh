<?php
if(!defined("CT"))
{
	die("IS WRONG");
}


/*-------------------���ﳵ---------------------------*/

function ontotalmoney()
{
	global $cksiteid,$ss_id;
	$userid=intval($_SESSION['ssuser']['userid']); 
	$wu=$userid?"(s.userid=".$userid." OR s.ssid='{$ss_id}')" : "   s.ssid='{$ss_id}'";
	echo $GLOBALS['db']->getOne("select sum(s.cainum*s.price) from ".table('shopcar')."   s   where $wu  AND s.siteid='$cksiteid' ");
}
	
function onIndex()
{
	global $web;
	$s=shopcarinfo(get_post('shopid','i'));
	
	$GLOBALS['smarty']->assign("totalmoney",$s['totalmoney']);
	$GLOBALS['smarty']->assign("where","<a href='{$web['weburl']}'>��ҳ</a> > ���ﳵ");
	
	if($_GET['ajax'])
	{
		header("Content-type:text/html;charset=gb2312");
		$GLOBALS['smarty']->assign("shopcart",$s['shoplist']);
		$GLOBALS['smarty']->display("ajax_shopcar.html");
		 
	}else
	{
		$GLOBALS['smarty']->assign("shopcarlist",$s['shoplist']);
		$GLOBALS['smarty']->display("shopcar.html");
	}
}


function onAdd_db()
{
	global $db,$cksiteid,$ss_id;
	/*��ӵ����ﳵ*/
	@header("Content-type:text/html;charset=gb2312");
	
	$caiid=intval($_GET['caiid']);
	$cainum=max(1,intval($_GET['cainum']));
	$cai=$db->getRow("SELECT * FROM ".table('cai')." WHERE id='$caiid' AND siteid='$cksiteid' ");
	
	if(!$caiid or !$cai)
	{
		if($_GET['ajax'])
		{
			
			echo "��������δ�ܳɹ���ӵ����ﳵ1";
			exit();
		}else
		{
			errback('��������δ�ܳɹ���ӵ����ﳵ');
		}
	}
	//ȱ��
	if($cai['oos']==1)
	{
		if($_GET['ajax'])
		{
			echo "�ܱ�Ǹ,����ʳ�Ѿ�������";
			exit();
		}else
		{
			errback('�ܱ�Ǹ������ʳ�Ѿ�������');
		}
	}
	
	//�̵�����
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$cai['shopid']." ");
	if($shopconfig['ordertype'])
	{
		if($_GET['ajax'])
		{
			echo "�ܱ�Ǹ,�õ���ֻ֧�ֵ绰Ԥ��";
			exit();
		}else
		{
			errback('�ܱ�Ǹ,�õ���ֻ֧�ֵ绰Ԥ��');
		}
	}
	//���������Ӫʱ�� �ж��Ƿ���Ӫҵʱ���
	$opentype="doing";
	if($shopconfig['opentime']==1)
	{
		$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
	}
	
	if($opentype!='doing' )
	{
		if($_GET['ajax'])
		{
			echo "��ǰ��ʱ�β���Ӫҵ��Χ�����ܶ���";
			exit();
		}else
		{
			errback("��ǰ��ʱ�β���Ӫҵ��Χ�����ܶ���");
		}
	}
	
	
	
	//�ж��Ƿ������ڼ�����
	$week=getweek();

	if($shopconfig['showweek'])
	{
		
		$weekon=$cai["week{$week}"];
		
		if(!$weekon)
		{
			if($_GET['ajax'])
			{
				echo "�ܱ�Ǹ������ʳ����û������";
				exit();
			}else
			{
				errback('�ܱ�Ǹ������ʳ����û������');
			}
		}
	}
	
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : " ssid='{$ss_id}' ";
	$ct=$GLOBALS['db']->getOne("select id from ".table('shopcar')." where  $wu  and caiid='$caiid' AND  shopid=".$cai['shopid']." ");


	if(!$ct)
	{
		$price=$cai['promote']?$cai['lowprice']:$cai['price'];
		$GLOBALS['db']->query("INSERT INTO ".table('shopcar')." SET userid='$userid',ssid='{$GLOBALS['ss_id']}',caiid='$caiid',cainum='$cainum',shopid=".$cai['shopid']." ,siteid='$cksiteid',title='".$cai['title']."',price='$price' ");
	}else
	{
		$GLOBALS['db']->query("UPDATE ".table('shopcar')." SET cainum=cainum+1 WHERE $wu AND caiid='$caiid' ");
	}
	
	if(!$_GET['ajax'])
	{
		errback("�ɹ����빺�ﳵ");
	}
}

/*���ﳵɾ�� ��ʳ*/
function onDel()
{
	global $ss_id;
	$userid=$_SESSION['ssuser']['userid'];
	$caiid=intval($_GET['caiid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : "  ssid='{$ss_id}'";
	$GLOBALS['db']->query("delete from ".table('shopcar')." where caiid='$caiid' AND $wu  ");
	
	gourl();
	
}
/*ɾ������*/
function onDelOrder()
{
	global $db;
	check_login();
	$id=intval($_GET['id']);
	$userid=intval($_SESSION['ssuser']['userid']);
	$db->query("DELETE FROM ".table('order')." WHERE id='$id' AND userid='$userid' AND sendtype=0 ");
	if($_GET['url'])
	{
		switch($_GET['url'])
		{
			case 'orderphone':
							gourl("index.php?m=shopcar&a=orderphone");
							break;
						
		}
	}else
	{
		gourl('index.php');
	}
}

/*������ﳵ*/
function onClearcar()
{
	global $ss_id;
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : "   ssid='{$ss_id}'";
	$GLOBALS['db']->query("delete from ".table('shopcar')." where $wu  ");	
	
	if(!$_GET['ajax'])
	{
		gourl();
	}
}

function onedinum()
{
	global $ss_id;
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : "   ssid='{$ss_id}'";
	/*-------------�༭���ﳵ����-----------*/
	if($_POST['ids'])
	{
		$ids=$_POST['ids'];
		$cainum=$_POST['cainum'];
		foreach($ids as $k=>$id)
		{
			$GLOBALS['db']->query("update ".table('shopcar')." set cainum=".intval($cainum[$k])." where id='$id'  and $wu ");
		}
		errback("���ĳɹ�");
	}else
	{
		$caiid=intval($_GET['caiid']);
		$cainum=intval($_GET['cainum']);
		$GLOBALS['db']->query("update ".table('shopcar')." set cainum=".$cainum." where caiid='$caiid'  and $wu ");
	}

	
	
}

/*------------------������ʳ---------------------------*/
function onbuy()
{
	global $db,$cksiteid;
	check_login();
	
	$userid=intval($_SESSION['ssuser']['userid']);
	$dateline=time();
	$shopid=get_post('shopid');
	
	//ѡ���̵�id
	if(!$shopid){
		if($userid)
		{
			$shops=$db->getCols("SELECT DISTINCT shopid FROM ".table('shopcar')." WHERE userid='$userid' OR ssid='{$GLOBALS['ss_id']}' ");
		}else
		{
			$shops=$db->getCols("SELECT DISTINCT shopid FROM ".table('shopcar')." WHERE   ssid='{$GLOBALS['ss_id']}' ");
		}
	}else{
		$shops=array($shopid);
	}
	
	if(empty($shops))
	{
		if($_GET['ajax'])
			{
				echo "���ﳵû����Ʒ";
				exit();
			}else
			{
				errback("���ﳵû����Ʒ�������");
			}
	}
	$week=getweek();
	$carts=array();
	
	foreach($shops as $shopid)
	{
		$shop=$db->getRow("SELECT shopname FROM ".table('shop')." WHERE shopid='$shopid' ");
		$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid='$shopid' ");
		if($shopconfig['ordertype'])
		{
			if($_GET['ajax'])
			{
				echo "�ܱ�Ǹ,".$shop['shopname']."ֻ֧�ֵ绰Ԥ��,���򲻳ɹ�";
				exit();
			}else
			{
				errback("�ܱ�Ǹ,".$shop['shopname']."ֻ֧�ֵ绰Ԥ��,���򲻳ɹ�");
			}
		}
		//�ж��Ƿ���Ӫҵ
		$opentype="doing";
		if($shopconfig['opentime']==1)
		{
			$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
		}
		
		if($opentype!='doing' )
		{
			if($_GET['ajax'])
			{
				echo "�̵�".$shop['shopname']."��ǰ��ʱ�β���Ӫҵ��Χ�����ܶ���";
				exit();
			}else
			{
				errback("�̵�".$shop['shopname']."��ǰ��ʱ�β���Ӫҵ��Χ�����ܶ���");
			}
		}
		//�ж��Ƿ�С����С���ͽ��
		
		$money=$db->getOne("select sum(s.cainum*s.price) from ".table('shopcar')." as s   where (s.userid='$userid' OR s.ssid='{$GLOBALS['ss_id']}') AND s.shopid='$shopid' ");
		
		//���빺�ﳵ
		$carts[$shopid]['money']=$money+$shopconfig['sendprice'];
		if($money<$shopconfig['minprice'])
		{
			errback('�������С�ڲ���['.$shop['shopname'].']�涨��С�����Ͳ��ɹ�');
		}
		
		//ѡ����ǰ�̵����ʳ
		if($userid)
		{
			$res=$db->query("SELECT s.cainum,s.price,s.caiid,c.title,c.lowprice,c.promote,c.week1,c.week2,c.week3,c.week4,c.week5,c.week6,c.week6,c.week7,c.oos FROM ".table('shopcar')." s LEFT JOIN ".table('cai')." c ON s.caiid=c.id  WHERE s.shopid='$shopid' AND (s.ssid='{$GLOBALS['ss_id']}' OR s.userid='$userid')");
		}else
		{
			$res=$db->query("SELECT s.cainum,s.caiid,s.price ,c.title,c.promote,c.week1,c.week2,c.week3,c.week4,c.week5,c.week6,c.week6,c.week7,c.oos FROM ".table('shopcar')." s LEFT JOIN ".table('cai')." c ON s.caiid=c.id  WHERE s.shopid='$shopid' s.ssid='{$GLOBALS['ss_id']}' ");
			
		}
		

		while($cai=$db->fetch_array($res))
		{
				//�ж��Ƿ�ȱ��
				if($cai['oos']==1)
				{
					if($_GET['ajax'])
					{
						echo "�ܱ�Ǹ,��ʳ[".$cai['title']."]�Ѿ�������,��ӹ��ﳵɾ��";
						exit();
					}else
					{
						errback("'�ܱ�Ǹ����ʳ[".$cai['title']."]�Ѿ�������,��ӹ��ﳵɾ��");
					}
				}
				
				//�жϵ����Ƿ�����
	

				if($shopconfig['showweek'])
				{
					
					$weekon=$cai["week{$week}"];
					
					if(!$weekon)
					{
						if($_GET['ajax'])
						{
							echo "�ܱ�Ǹ����ʳ[".$cai['title']."]����û������,��ӹ��ﳵɾ��";
							exit();
						}else
						{
							errback("�ܱ�Ǹ����ʳ[".$cai['title']."]����û������,��ӹ��ﳵɾ��");
						}
					}
				}
				$carts[$shopid]['cailist'][]=$cai;
		}
	}
	
//��ʼ������
$ids=array();
$address=$db->getOne("SELECT address FROM ".table('user_address')." WHERE userid='$userid' ORDER BY id DESC ");
$phone=$db->getOne("SELECT phone FROM ".table('user')." WHERE userid='$userid' ");

foreach($shops as $shopid)
{	
	
	$shopname=$db->getOne("SELECT shopname FROM ".table('shop')." WHERE shopid='$shopid' ");
	$db->query("INSERT INTO ".table('order')."  SET userid='$userid',money=".$carts[$shopid]['money'].",dateline='$dateline',shopid='$shopid',orderaddress='$address',orderphone='$phone',orderuser='".$_SESSION['ssuser']['username']."',siteid='$cksiteid' ");
		
	$orderid=$GLOBALS['db']->insert_id();
	$ids[]=$orderid;
	$orderno=date("Ym").$orderid;
	$GLOBALS['db']->query("update ".table('order')." set orderno='$orderno' where id='$orderid' ");
	//�����
	$sharecontent=" @<a href='index.php?m=member&userid=$userid'>{$_SESSION['ssuser']['nickname']}</a> ��<a href='index.php?m=shop&shopid={$shopid}' target='_blank'>{$shopname}</a>����";
	foreach($carts[$shopid]['cailist'] as $t)
	{
		$sharecontent.=" <a href='index.php?m=cai&id={$t['caiid']}'>{$t['title']}</a> {$t['cainum']} ��&nbsp;&nbsp; ";
		$db->query("INSERT INTO ".table('order_cai')." SET orderid='$orderid',caiid=".$t['caiid'].",cainum=".$t['cainum'].",shopid='$shopid',price=".$t['price'].",title='".$t['title']."' ");
	}
	//���붩�ͷ���
	$db->query("INSERT INTO ".table('ordershare')." SET siteid='$cksiteid',shopid='$shopid',userid='$userid',dateline=".time().",content='".addslashes($sharecontent)."'  ");
	
	//ɾ�����ﳵ
	$db->query("delete from ".table('shopcar')." where userid='$userid' AND shopid='$shopid' ");
	
}
	header("Location: index.php?m=shopcar&a=orderphone&ids=".implode("-",$ids));
	
}
/*---------------�鿴����-------------------*/
function onView()
{	
	$userid=intval($_SESSION['ssuser']['userid']);
	$id=intval($_GET['id']);
	$rs=$GLOBALS['db']->getRow("select o.*,u.username,s.shopname from ".table('order')." as o left join ".table('user')." as u on o.userid=u.userid LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid  where o.id='$id' ");
	$rs['dateline']=date("Y-m-d H:i:s");
	if($rs['username']=='')
	{
		$rs['username']='�ο�';
	}
	$GLOBALS['smarty']->assign("order",$rs);
	$sql="select oc.*,c.title,c.price from ".table('order_cai')." as oc left join ".table('cai')." as c on oc.caiid=c.id where oc.orderid='$id'  ";
	$rs=$GLOBALS['db']->getAll($sql);
	$GLOBALS['smarty']->assign("cailist",$rs);
	
		//��ȡ�����¼
	if($userid)
	{
		$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where userid='$userid' AND siteid='$cksiteid' order by id desc limit 10 ");
	}else
	{
		$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where ssid='{$GLOBALS['ss_id']}' AND siteid='$cksiteid' order by id desc limit 10 ");
		
	}
	$GLOBALS['smarty']->assign("orderlist",$orderlist);
	$GLOBALS['smarty']->assign("where","<a href='{$web['weburl']}'>��ҳ</a> > ��������");	
	$GLOBALS['smarty']->display("order_view.html");
}
/*---------------------�����¼------------------------------*/
function onHistory()
{
	global $cksiteid;
	check_login();
	$userid=intval($_SESSION['ssuser']['userid']);
	$sql="select o.*,s.shopname from ".table('order')." o LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid  WHERE o.siteid='$cksiteid'  " ;
	if($userid)
	{
		$sql.=" AND o.userid='$userid' ";
	}
	$sql.=" order by o.id desc ";
	$rscount=$GLOBALS['db']->getOne("select count(*) from ".table('order')."  where userid='$userid' AND siteid='$cksiteid' ");
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql.=" limit $start,$pagesize";
	$GLOBALS['smarty']->assign("pagelist",multipage($rscount,$pagesize,$_GET['page'],"index.php?m=shopcar&a=history"));
	$res=$GLOBALS['db']->query($sql);
	$orderlist=array();
	while($rs=$GLOBALS['db']->fetch_array($res))
	{
		$orderlist[$rs['id']]=$rs;
	}
	$GLOBALS['smarty']->assign("orderlist",$orderlist);
	$GLOBALS['smarty']->assign("where","<a href='{$web['web_url']}'>��ҳ</a> >�����¼");
	$GLOBALS['smarty']->display("order_history.html");	
}
/*--------------��ϵ��ʽ------------------*/
function onorderphone()
{
	global $db,$smarty,$cksiteid;
	check_login();
	$userid=intval($_SESSION['ssuser']['userid']);
	//ѡ��δ��Ч�Ķ���
	if($_GET['ids'])
	{
		$ids=explode("-",$_GET['ids']);
	}else
	{
		$ids=$db->getCols("SELECT id FROM ".table('order')." WHERE userid='$userid' and isvalid=0 AND siteid='$cksiteid' ");
	}
	$orderlist=array();
	//�˻����
	$balance=$db->getOne("SELECT balance FROM ".table('user')." WHERE userid='$userid' ");
	$smarty->assign("balance",$balance);
	foreach($ids as $id)
	{
		$id=intval($id);
		if($id)
		{	
			//��ȡ������Ϣ
			$order=$db->getRow("SELECT o.*,s.shopname,s.phone FROM ".table('order')." o LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid  WHERE o.id='$id' AND o.userid='$userid' ");
			$order['cailist']=$db->getAll("SELECT o.* FROM ".table('order_cai')." o  WHERE o.orderid=".$order['id']."  ");
			$order['config']=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$order['shopid']." ");
			$order['comment']=$db->getRow("SELECT * FROM ".table('shop_comment')." WHERE orderid='$id' ");
		}
		$orderlist[]=$order;
	}
	$addresslist=$db->getAll("SELECT address,id FROM ".table('user_address')." WHERE userid='$userid' ORDER BY id desc ");
	$smarty->assign('addresslist',$addresslist);
	$smarty->assign('orderlist',$orderlist);
	$smarty->display("order_phone.html");
}
/*-----------------��д��ϵ��ʽ----------------------*/
function onOrderPhone_db()
{
	global $db;
	//��֤��
	$userid=intval($_SESSION['ssuser']['userid']);
	check_login();
	$orderid=intval($_POST['orderid']);
	$orderphone=strip_tags(trim($_POST['orderphone']));
	ckempty($orderphone,'��ϵ�绰����Ϊ�գ�');
	$orderaddress=strip_tags(trim($_POST['orderaddress']));
	ckempty($orderaddress,'��ϵ��ַ����Ϊ��');
	//��ȡ�˻����
	$balance=$db->getOne("SELECT balance FROM ".table('user')." WHERE userid='$userid' ");
	$orderinfo=htmlspecialchars(trim($_POST['orderinfo']));
	$ispay=intval($_POST['ispay']);	
	
	$order=$db->getRow("SELECT * FROM ".table('order')." WHERE id='$orderid' ");
	$orderno=$order['orderno'];
	//�������֧�� �������֧��
	if($ispay && !$order['ispay'])
	{
		if($order['money']>$balance)
		{
			errback('�������㣬֧�����ɹ�');
		}else
		{
			$db->query("UPDATE ".table('user')." SET balance=balance-".$order['money']." WHERE userid=".intval($_SESSION['ssuser']['userid'])." ");
			//�û����ʹ�ü�¼
			$content="�������Ϊ{$order['orderno']}����ɹ�,�ܶ�{$order['money']}Ԫ,ʹ�����֧����������{$order['money']}";
			$db->query("INSERT INTO ".table('user_paylog')." SET userid=".intval($_SESSION['ssuser']['userid']).",content='".addslashes($content)."',money='-{$order['money']}',dateline=".time()." ");
			
		}
	}
	$GLOBALS['db']->query("update ".table('order')." set ispay='$ispay',orderphone='$orderphone',isvalid=1,orderaddress='$orderaddress',orderinfo='$orderinfo' where id='$orderid' and userid='$userid' ");
	
	
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$order['shopid']." ");
	
	if($_GET['edi'])
	{
		errback("�޸���ϵ��ʽ�ɹ�","index.php?m=shopcar&a=view&id={$id}");
		
	}else
	{	
	
		//������������ʼ� ���߶���֪ͨ 
		if((PHONE_ON==1) or $shopconfig['isemail'])
		{
			//�ж��Ƿ�Ϊ�Ͽͻ�
			$isold=0;
			//�����û�id�ж��Ƿ�Ϊ���û� 
			
			$c2=$GLOBALS['db']->getOne("select id from ".table('order')." where userid=".intval($_SESSION['ssuser']['userid'])." LIMIT 1 ");
			$isold=$c2>1?1:0;
			
			$content=(($isold?"��":"��")."�û�").$_SESSION['ssuser']['username']."���ˣ�";			
			
			$oc=$GLOBALS['db']->getAll(" select oc.caiid,oc.cainum,c.title from ".table('order_cai')." as oc left join ".table('cai')." as c on  oc.caiid=c.id where oc.orderid='$orderid'  ");
			$content2="�𾴵Ŀͻ������Ķ�����ţ�$orderno ,�˵���";
			foreach($oc as $v)
			{
				$content.=$v['title'].$v['cainum']."��/";
				$content2.=$v['title'].$v['cainum']."��/";
			}
			$content2.=",�ܼ�".$order['money']."Ԫ".",����Ҫȥ��".$order['orderinfo']."��";
			$content.="��ϵ�绰��{$orderphone},���͵�ַ��{$orderaddress}���ܼ�".$order['money']."Ԫ".",����Ҫ��".$order['orderinfo']."��";
			
			if(PHONE_ON)
			{		
				require_once(ROOT_PATH."includes/sendSMS.php");
				//���͸��̼�
				if($shopconfig['telephone']){
					$res = sendSMS(PHONE_USER,PHONE_PWD,$shopconfig['telephone'],$content);
				}		
				//���͸��û�			
				$r2 = sendSMS(PHONE_USER,PHONE_PWD,$orderphone,$content2);
			}
			
			if($shopconfig['isemail'])
			{
				global $smptArr;
				 
				 send_mail($smptArr,$shopconfig['email'],'�����¶���',$content);
												
			}
			
			
		}
		
		if($db->getOne("SELECT count(1) FROM ".table('order')." WHERE userid='$userid' AND isvalid=0 "))
		{
			gourl("index.php?m=shopcar&a=orderphone");
		}
		errback("������ɣ���ӭ���´����� ������{$orderno}",'index.php?m=shopcar&a=history');
	}
}
/*---------------------��������-------------------------*/
function onOrderComment()
{
	global $cksiteid;
	$orderid=intval($_POST['orderid']);
	$userid=intval($_SESSION['ssuser']['userid']);
	$order=$GLOBALS['db']->getRow("SELECT * FROM ".table('order')." WHERE id='$orderid' AND userid='$userid' ");
	if(empty($order)) errback('����������');
	extract($order);
	$ctype=intval($_POST['ctype']);
	$content=htmlspecialchars(trim($_POST['content']));
	$jf_fuwu=intval($_POST['jf_fuwu']);
	$jf_kouwei=intval($_POST['jf_kouwei']);
	$jf_shijian=intval($_POST['jf_shijian']);
	$jf_jiage=intval($_POST['jf_jiage']);
	$jf_all=intval($_POST['jf_all']);
	 
	if($order['iscomment'])
	{
		$GLOBALS['db']->query("UPDATE ".table('shop_comment')." SET   jf_fuwu='$jf_fuwu',jf_kouwei='$jf_kouwei',jf_shijian='$jf_shijian',jf_jiage='$jf_jiage',jf_all='$jf_all',content='$content'   WHERE orderid='$orderid' AND userid=".intval($_SESSION['ssuser']['userid'])." ");

	}else
	{
		$GLOBALS['db']->query("INSERT INTO ".table('shop_comment')." SET siteid='$cksiteid',shopid='$shopid',ctype='$ctype',userid=".intval($_SESSION['ssuser']['userid']).",nickname='".$_SESSION['ssuser']['nickname']."',orderid='$orderid',orderno='$orderno',jf_fuwu='$jf_fuwu',jf_kouwei='$jf_kouwei',jf_shijian='$jf_shijian',jf_jiage='$jf_jiage',jf_all='$jf_all',content='$content',dateline=".time()."  ");
	}
	$avg=$GLOBALS['db']->getRow("SELECT AVG(jf_fuwu) AS fuwu,AVG(jf_kouwei) AS kouwei,AVG(jf_shijian) AS shijian,AVG(jf_jiage) AS jiage ,AVG(jf_all) AS all FROM ".table('shop_comment')." WHERE shopid='$shopid'  ");
	$grade=0;
	if(!$order['iscomment'])
	{
		if($jf_all>3)
		{
			$grade=1;
		}elseif($jf_all<3)
		{
			$grade=-1;
		} 
	}
	
	$GLOBALS['db']->query("UPDATE ".table('shop')." SET jf_fuwu=".intval($avg['fuwu']).",jf_kouwei=".intval($avg['kouwei']).",jf_shijian=".intval($avg['shijian']).",jf_jiage=".intval($avg['jiage']).",jf_all=".intval($avg['all']).",grade=grade+".$grade."  WHERE shopid='$shopid' ");
	
	
	$GLOBALS['db']->query("UPDATE ".table('order')." SET iscomment=1 WHERE id='$orderid' AND userid=".intval($_SESSION['ssuser']['userid'])." ");

	
	errback('��л���Զ�������');
}
/*--------------------��������----------------------*/
function onOrdersearch()
{
	
	if($_POST)
	{
		$orderno=htmlspecialchars(trim($_POST['orderno']));
		if($id=$GLOBALS['db']->getOne("select id from ".table('order')." where orderno='$orderno' "))
		{
			header("Location: index.php?m=shopcar&a=view&id={$id}");
		}else
		{
			errback("�ܱ�Ǹ����Ҫ���ҵĶ��������ڣ�","index.php?m=shopcar&a=ordersearch");
		}
	}else
	{
		//��ȡ�����¼
		if($userid)
		{
			$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where userid='$userid' order by id desc limit 10 ");
		}else
		{
			$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where ssid='{$GLOBALS['ss_id']}' order by id desc limit 10 ");
			
		}
		$GLOBALS['smarty']->assign("orderlist",$orderlist);
		$GLOBALS['smarty']->display("order_search.html");
	}
}

function onAjaxGetshopcar()
{
/*ajax��ȡ���ﳵ*/	
	header("Content-type:text/html; charset=gb2312");
	$userid=intval($_SESSION['ssuser']['userid']);
	if($userid)
	{
		$shopcailist=$GLOBALS['db']->getAll("select s.*,c.title,c.price from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.userid='$userid' AND  s.shopid=".$_SESSION['ssshopid']."");	
		$shopmoney=$GLOBALS['db']->getOne("select sum(s.cainum*c.price) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.userid='$userid' AND  s.shopid=".$_SESSION['ssshopid']." ");
		$shopcainum=$GLOBALS['db']->getOne("select sum(s.cainum) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.userid='$userid' AND  s.shopid=".$_SESSION['ssshopid']." ");
	}else
	{
		$shopcailist=$GLOBALS['db']->getAll("select s.*,c.title,c.price from  ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.ssid='{$GLOBALS['ss_id']}' AND  s.shopid=".$_SESSION['ssshopid']." ");	
		$shopmoney=$GLOBALS['db']->getOne("select sum(s.cainum*c.price) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.ssid='{$GLOBALS['ss_id']}' AND  s.shopid=".$_SESSION['ssshopid']."  ");
		$shopcainum=$GLOBALS['db']->getOne("select sum(s.cainum) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.ssid='{$GLOBALS['ss_id']}' AND  s.shopid=".$_SESSION['ssshopid']." ");
	}
	$GLOBALS['smarty']->assign("shopcainum",$shopcainum);
	$GLOBALS['smarty']->assign("shopmoney",$shopmoney);
	$GLOBALS['smarty']->assign("shopcailist",$shopcailist);
	$GLOBALS['smarty']->display("lib/ajaxshopcar.lbi");
}
function onAjaxSendArea()
{
	header("Content-type:text/html;charset=gb2312");
	$pid=intval($_GET['pid']);
	$rs=$GLOBALS['db']->getRow("SELECT catid,cname FROM ".table('sendarea')." WHERE pid=".$pid." AND  shopid=".$_SESSION['ssshopid']." ");
	if($rs)
	{
	$op='<option value="0">��ѡ��</option>';
	foreach($rs as $r);
	{
		$op.="<option value='".$r['catid']."'>".$r['cname']."</option>";
	}
	echo $op;
	}
	
}

function onReceived()
{
	global $db;
	$userid=$_SESSION['ssuser']['userid'];
	$id=intval($_GET['id']);
	$db->query("UPDATE ".table('order')." SET received=1 WHERE userid='$userid' AND id='$id' " );
}

?>