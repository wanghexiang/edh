<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a='index';
}
checkpermission("order",$a);
if($a=='index')
{
	$w="";
	$sql="select  id  from ".table('order')." where isvalid=1 AND siteid='$siteid'  ";
	$sql2="select count(1) from ".table('order')."  where isvalid=1  AND siteid='$siteid' ";
	$sql3=" select SUM(money) as summoney, AVG(money) as avgmoney from ".table('order')." where isvalid=1 AND siteid='$siteid' ";
	$orderno=$_GET['orderno'];
	$uid=intval($_GET['uid']);
	$url="admin.php?m=order&";

	if(isset($_GET['t']))
	{	
		$t=intval($_GET['t']);
		$daystart=strtotime(date("Y-m-d"));//һ��Ŀ�ʼ
		$dayend=$daystart+86400;//һ��Ľ���
		if($t==1)
		{//����
			$w.=" and dateline>'$daystart' ";
			
		}elseif($t==2)
		{//����
			$dateline=$daystart-86400;
			$w.=" and dateline<'$daystart' and dateline>'$dateline' ";
			
			
		}elseif($t==3)
		{//7��
			$dateline=$daystart-86400*7;			
			$w.="  and  dateline>'$dateline' ";			
		}elseif($t==4)
		{//����
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline>'$dateline' ";
					
		}elseif($t==5)
		{//����
			$lm=mktime(0,0,0,date("m")-1,1,date("Y"));
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline<'$dateline' and dateline>'$lm' ";
			
		}
		$url.="&t={$t}";
	}
	if($uid)
	{
	$w.= " and  userid='$uid' " ;
	$url.="&uid={$uid}";
	}
	if(isset($_GET['sendtype']) && $_GET['sendtype']>-1)
	{
		$w.=" and sendtype=".intval($_GET['sendtype'])." ";
		$url.="&sendtype=".intval($_GET['sendtype']);
		$smarty->assign("sendtype",intval($_GET['sendtype']));
	}else
	{
		$smarty->assign("sendtype",-1);
	}
	
	if($orderno)
	{
		$w.=" and  orderno='$orderno' ";
		$smarty->assign("orderno",$orderno);
		$url.="&orderno={$orderno}";
	}
	$username=trim($_GET['username']);
	if($username)
	{
		$w.=" and orderuser='$username' ";
		$smarty->assign("username",$username);
		$url.="&username={$username}";
	}
	$starttime=$_GET['starttime']=htmlspecialchars($_GET['starttime']);
	$endtime=$_GET['endtime']=htmlspecialchars($_GET['endtime']);
	if($starttime && $endtime)
	{
		$url.="&starttime=$starttime&endtime=$endtime";
		$starttime=strtotime($starttime);
		$endtime=strtotime($endtime);
		$w.=" AND dateline>'$starttime' AND dateline<'$endtime' ";
		
	}
	
	$sql.=$w;
	$sql2.=$w;
	$sql3.=$w;
	$sql.=" order by  id desc ";
	//��ʼ��ҳ
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);	
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//��ҳ����
	$ids=$db->getCols($sql);
	if($ids)
	{
		$res=$db->query("SELECT o.*,s.shopname FROM ".table('order')." o LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid WHERE o.id in("._implode($ids).") ORDER BY o.id DESC ");
		$orderlist=array();
		while($rs=@$db->fetch_array($res))
		{
			
			$rs['dateline']=date("H:i:s",$rs['dateline']);
			switch($rs['sendtype'])
			{
				case 0;
					$rs['sendtype']="δȷ��";
					break;
				case 1:
					$rs['sendtype']="��ȷ��";
					break;
				case 2:
					$rs['sendtype']="��������";
					break;
				
				case 3:
					$rs['sendtype']="�������";
					break;	
			}
			if($rs['userid']==0)
			{
				$rs['orderuser']="�ο�";
			}
			
			$orderlist[$rs['id']]=$rs;
		}
	}
	$smarty->assign("money",$db->getRow($sql3));//ͳ���˵�
	$smarty->assign("rscount",$rscount);//ͳ�ƶ�������
	$smarty->assign("orderlist",$orderlist);
	$smarty->display("order.html");
}elseif($a=='view')
{
	$id=intval($_GET['id']);
	$rs=$db->getRow("select o.*,u.username,u.phone,u.address from ".table('order')." as o left join ".table('user')." as u on o.userid=u.userid  where o.id='$id' ");
	$rs['dateline']=date("y-m-d H:i:s",$rs['dateline']);
	if($rs['username']=='')
	{
		$rs['username']='�ο�';
	}
	if(!$rs['phone'])
	{
		$rs['phone']=$rs['orderphone'];
	}
	if(!$rs['address'])
	{
		$rs['address']=$rs['orderaddress'];	
	}
	$rs['comment']=nl2br($rs['comment']);
	$rs['orderinfo']=nl2br($rs['orderinfo']);
	$smarty->assign("order",$rs);
	$sql="select oc.*,c.title,c.price from ".table('order_cai')." as oc left join ".table('cai')." as c on oc.caiid=c.id where oc.orderid='$id'  ";
	$rs=$db->getAll($sql);
	$smarty->assign("rs",$rs);
	$smarty->display("order_view.html");
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('order')." where id='$id' AND siteid='$siteid' ");
	//ɾ����������
	$db->query("delete from ".table('order_cai')." where orderid='$id' ");
	gourl();
}elseif($a=='sendtype')
{
	$sendtype= $_GET['sendtype'];
	if(is_array($_POST['id']))
	{
		$id=$_POST['id'];
		if($sendtype==3)
		{
			$rs=$db->getAll("select id,userid,shopid,money,orderuser,orderno,ispay from ".table('order')." where sendtype<3 and id in("._implode($id).") AND shopid='$shopid' ");
		
			foreach($rs as $key=>$val)
			{
				// ��ȡ�û�����
				$grade=$db->getOne("select grade from ".table('user')." where userid=".$val['userid']." ")	;	
				//���ۿ۸��û�
				$discount=$db->getOne("select discount from ".table('user_rank')." where min_grade<='$grade' and max_grade>='$grade' LIMIT 1 ");
				//ʵ��֧���ķ���
				$money=(GRADE_ON==1 && $discount)?$val['money']*$discount/100:$val['money'];
				if($val['ispay']==1)
				{
					
					//�������ʹ�ü�¼
					$content="�û�".$val['orderuser']."���Ϊ".$val['orderno']."�Ķ����������,���".$money."Ԫ ";
					$db->query("INSERT INTO ".table('shop_paylog')." SET shopid=".$val['shopid'].",dateline=".time().",content='".addslashes($content)."',money='+{$money}' ");
					$db->query("UPDATE ".table('shop')." SET balance=balance+".$money." WHERE shopid=".$val['shopid']." ");
					
				}
				//�����Ż��ۿ۷���
				$bonus=$val['money']-$money;
				if($bonus)
				{
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".intval($val['userid'])." ");
					//�û����ʹ�ü�¼
					$content="�������Ϊ{$val['orderno']}����ɹ�,�ܶ�{$val['money']}Ԫ,ʹ�����֧������÷���{$bonus}Ԫ";
					$db->query("INSERT INTO ".table('user_paylog')." SET userid=".$val['userid'].",content='".addslashes($content)."',money='$bonus',dateline=".time()." ");
				}
					
				
				//�ƹ㽱����ʼ
				//��ȡ������
				$fuserid=$db->getOne("select fuserid from ".table('user')." where userid='{$val['userid']}' ") ;
				if($fuserid && (SPREAD_ON==1))
				{
					$bonus=SPREAD_DISCOUNT*$val['money']/100;//����
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".$fuserid." ");
					
					//д���Ż���־
					$content="���Ƽ����˹����˶������Ϊ{$val['orderno']}�Ĳ�Ʒ,�ܶ�{$val['money']}Ԫ������ý��Ϊ{$bonus}Ԫ���Ż�";
					$db->query("insert into ".table('user_paylog')." set content='$content',userid=".$fuserid.",bonus='$bonus',dateline=".time()." ");
					//����֪ͨ
					sendMessage($fuserid,$content);
						
				}
					
				//�ƹ㽱������
				//��ӵȼ�����		
				$db->query("update ".table('user')." set grade=grade+".$val['money'].",usegrade=usegrade+".$val['money']." where userid=".$val['userid']." ");
				//��ӿɶһ�����
				$content="����".$val['orderno']."��ɣ������".$val['money']."���û��֡�";
				$db->query("INSERT ".table('grade_log')." SET userid=".$val['userid'].",content='$content',dateline=".time().",grade=".$val['money']." ");
				//�ɶһ����ֽ���
				$db->query("update ".table('order')." set sendtype='$sendtype' where  sendtype<3 and id='{$val['id']}'   ");
				//����֪ͨ
				$content="�������Ϊ{$val['orderno']}���ͻ�,<a href='index.php?m=shopcar&a=history'>��ȷ���ջ�</a>";
				sendMessage($val['userid'],$content);
				//���µ�����������
				$db->query("UPDATE ".table('shop')." SET orders=orders+1 WHERE shopid=".intval($val['shopid'])." ");
				//������ʳ��������
				$db->query("UPDATE ".table('cai')." SET orders=orders+1 WHERE id in(SELECT caiid FROM ".table('order_cai')." WHERE orderid=".$val['id']."  ) ");
			}//foreach����
		}//sendtype=3����
		$db->query("update ".table('order')." set sendtype='$sendtype' where  sendtype<3 and id in("._implode($id).")  ");
		
		
	}
	if($_GET['orderid'])
	{
		$orderid=intval($_GET['orderid']);
		if($sendtype==3)
		{
			$rs=$db->getRow("select id,userid,shopid,money,orderuser,orderno,ispay from ".table('order')." where  sendtype<3 and id ='$orderid' AND shopid='$shopid' ");
			if($rs)
			{
				//��ȡ����
				$grade=$db->getOne("select grade from ".table('user')." where userid=".$rs['userid']." ")	;	
				
				//���ۿ۸��û�
				$discount=$db->getOne("select discount from ".table('user_rank')." where min_grade<'$grade' and max_grade>'$grade' ");
				//ʵ��֧���ķ���
				$money=(GRADE_ON==1 && $discount)?$rs['money']*$discount/100:$rs['money'];
				if($rs['ispay']==1)
				{
					
					//�������ʹ�ü�¼
					$content="�û�".$rs['orderuser']."���Ϊ".$rs['orderno']."�Ķ����������,���".$money."Ԫ ";
					$db->query("INSERT INTO ".table('shop_paylog')." SET shopid=".$rs['shopid'].",dateline=".time().",content='".addslashes($content)."',money='+{$money}' ");
					$db->query("UPDATE ".table('shop')." SET balance=balance+".$money." WHERE shopid=".$rs['shopid']." ");
					
				}
				//�����Ż��ۿ۷���
				$bonus=$rs['money']-$money;
				if($bonus)
				{
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".intval($rs['userid'])." ");
					//�û����ʹ�ü�¼
					$content="�������Ϊ{$rs['orderno']}����ɹ�,�ܶ�{$rs['money']}Ԫ,ʹ�����֧������÷���{$bonus}Ԫ";
					$db->query("INSERT INTO ".table('user_paylog')." SET userid=".$rs['userid'].",content='".addslashes($content)."',money='$bonus',dateline=".time()." ");
				}
				
				//��ӵȼ�����		
				$db->query("update ".table('user')." set grade=grade+".$rs['money'].",usegrade=usegrade+".$rs['money']." where userid=".$rs['userid']." ");
				$content="����".$rs['orderno']."��ɣ������".$rs['money']."���û��֡�";
				$db->query("INSERT ".table('grade_log')." SET userid=".$rs['userid'].",content='$content',dateline=".time().",grade=".$rs['money']." ");
				$content="�������Ϊ{$rs['orderno']}���ͻ�,<a href='index.php?m=shopcar&a=history'>��ȷ���ջ�</a>";
				sendMessage($rs['userid'],$content);
				//���µ�������
				$db->query("UPDATE ".table('shop')." SET orders=orders+1 WHERE shopid=".intval($rs['shopid'])." ");
				//������ʳ��������
				$db->query("UPDATE ".table('cai')." SET orders=orders+1 WHERE id in(SELECT caiid FROM ".table('order_cai')." WHERE orderid=".$rs['id']."  ) ");

				//�ɶһ����ֽ���				
				//�ƹ㽱����ʼ
				//��ȡ������
				$fuserid=$db->getOne("select fuserid from ".table('user')." where userid='{$rs['userid']}' ") ;
				if($fuserid && (SPREAD_ON==1))
				{
					$bonus=SPREAD_DISCOUNT*$rs['money']/100;//����
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".$fuserid." ");
					
					//д���Ż���־
					$content="���Ƽ����˹����˶������Ϊ{$rs['orderno']}�Ĳ�Ʒ,�ܶ�{$rs['money']}Ԫ������ý��Ϊ{$bonus}Ԫ���Ż�";
					$db->query("insert into ".table('user_paylog')." set content='$content',userid=".$fuserid.",bonus='$bonus',dateline=".time()." ");
					//����֪ͨ
					sendMessage($fuserid,$content);
						
				}
				
				//�ƹ㽱������
			}//$rs����
				
		}
		
		$db->query("update ".table('order')." set sendtype='$sendtype' where sendtype<3 and id='$orderid' ");
	}	
	gourl();	
	
}elseif($a=='senddes')
{
	$id=intval($_POST['id']);
	$senddes=trim($_POST['senddes']);
	$db->query("update ".table('order')." set senddes='$senddes' where id='$id' AND siteid='$siteid' ");	
	gourl();
}elseif($a=='tocsv')
{
	$w="";
	//ת��Ϊmysql2excel
	if(isset($_GET['t']))
	{	
		$t=intval($_GET['t']);
		$daystart=strtotime(date("Y-m-d"));//һ��Ŀ�ʼ
		$dayend=$daystart+86400;//һ��Ľ���
		if($t==1)
		{//����
			$w.=" and dateline>'$daystart' ";
			
		}elseif($t==2)
		{//����
			$dateline=$daystart-86400;
			$w.=" and dateline<'$daystart' and dateline>'$dateline' ";
			
			
		}elseif($t==3)
		{//7��
			$dateline=$daystart-86400*7;			
			$w.="  and  dateline>'$dateline' ";			
		}elseif($t==4)
		{//����
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline>'$dateline' ";
					
		}elseif($t==5)
		{//����
			$lm=mktime(0,0,0,date("m")-1,1,date("Y"));
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline<'$dateline' and dateline>'$lm' ";
			
		}
		
	}
	header("Content-type:application/xls");
	header("Content-Disposition: attachment; filename=".time().".csv"); 
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');  
    header('Expires:0');   
    header('Pragma:public');
	$sql="select id,orderno,money,orderuser ,orderphone,orderaddress,dateline from ".table('order')." where isvalid=1  AND siteid='$siteid' $w  ORDER BY id DESC LIMIT 100 ";
	echo "������� ,�۸� ,��ϵ�� ,��ϵ�绰  ,��ϵ��ַ  ,ʱ��,�����  \r";
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		$rs['orderno']="no:".$rs['orderno'];
		$rs['dateline']=date("Y-m-d H:i:s");
		$cid=$db->getCols("select caiid from ".table('order_cai')." where orderid=".$rs['id']." ");
		
		$caiids=$db->getAll("select title,cainum from ".table('cai')." where id in("._implode($cid).") ");
		
		echo "{$rs['orderno']},{$rs['money']},{$rs['orderuser']},{$rs['orderphone']},{$rs['orderaddress']},{$rs['dateline']},{$rs['cai']} \r"; 
	}

	
	/*require_once(ROOT_PATH."includes/cls_csv.php");
	$f=time().".csv";
	arr2csv("backup/csv/".$f,$arr);
	echo "�����ɹ� <a href='admin.php?m=order&a=downcsv&f={$f}'>����</a>";*/
	
}elseif($a=='downcsv')
{
	$f=$_GET['f'];
	header("Content-type:application/xls");
	header("Content-Disposition: attachment; filename={$f}"); 
	 header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
	 header('Content-Length:' . filesize("backup/csv/".$f));  
     header('Expires:0');   
     header('Pragma:public'); 
	 echo file_get_contents("backup/csv/".$f);
}
?>