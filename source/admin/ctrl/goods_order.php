<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):"index";
switch($_GET['a'])
{
	case 'index':
				$w="";
				$sql="select  id  from ".table('goods_order')." where isvalid=1  ";
				$sql2="select count(1) from ".table('goods_order')."  where isvalid=1 ";
				$orderno=$_GET['orderno'];
				$url="admin.php?m=goods_order";
			
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
					$url.="&order={$orderno}";
				}
				$nickname=trim($_GET['nickname']);
				if($nickname)
				{
					$w.=" and nickname LIKE '%".$nickname."%' ";
					$smarty->assign("nickname",$nickname);
					$url.="&nickname={$nickname}";
				}
				$sql.=$w;
				$sql2.=$w;
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
				$res=$db->query("SELECT * FROM ".table('goods_order')." WHERE id in("._implode($ids).") ORDER BY id DESC ");
				
				$orderlist=array();
				while($rs=$db->fetch_array($res))
				{
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
							$rs['sendtype']="������";
							break;
						case 4:
							$rs['sendtype']="�������";
							break;	
					}

					
					$orderlist[$rs['id']]=$rs;
				}
				}
				$smarty->assign("rscount",$rscount);//ͳ�ƶ�������
				$smarty->assign("orderlist",$orderlist);
	
				$smarty->display("goods_order.html");
		break;
	case 'sendtype':
			$sendtype= $_GET['sendtype'];
			$ids=$_POST['id'];
			if($ids)
			{
				$rs=$db->getAll("select o.*,g.title from ".table('goods_order')." o LEFT JOIN ".table('goods')." g ON o.goodsid=g.id  where o.sendtype<4 and o.id in("._implode($ids).") ");
				foreach($rs as $r)
				{
					if($sendtype==4)
					{
						$db->query("UPDATE ".table('user')." SET usegrade=usegrade-".$r['grade']." WHERE userid=".$r['userid']." ");
						//���ֶһ���¼
						$content="��ʹ�û��ֶһ�  <a href=\'index.php?m=goods&a=detail&id=".$r['goodsid']."\'>".$r['title']."</a>�����ּ���".$r['grade']."��";
						$db->query("INSERT ".table('grade_log')." SET userid=".$r['userid'].",content='$content',dateline=".time().",grade=-".$r['grade']." ");
					}
					$db->query("UPDATE ".table('goods_order')." SET sendtype='$sendtype' WHERE id=".$r['id']." ");
				}
			}
			gourl();

		break;
	case 'del':
			$id=intval($_GET['id']);
			$db->query("delete from ".table('goods_order')." where id='$id' ");
			gourl();
		break;
}

?>