<?php

check_login();
$shopid=intval($_SESSION['adminshop']['shopid']);
$daystart=strtotime(date("Y-m-d"));//һ��Ŀ�ʼ
$dayend=$daystart+86400;//һ��Ľ���
//����
$smarty->assign("money",floatval($db->getOne("select sum(money) from ".table('order')." where  sendtype=3 AND shopid='$shopid' ")));
$smarty->assign("daymoney",floatval($db->getOne("select sum(money) from ".table('order')." where sendtype=3 and dateline>'$daystart' and dateline<'$dayend' AND shopid='$shopid' ")));

//������

$smarty->assign("ordernewnum",floatval($db->getOne("select count(*) from ".table('order')." where sendtype=0 AND isvalid=1 AND shopid='$shopid' ")));//�¶���
$smarty->assign("ordernum",intval($db->getOne("select count(*) from ".table('order')." where  sendtype=3 AND isvalid=1   AND shopid='$shopid' ")));//�����ɽ�����
$smarty->assign("orderdaynum",intval($db->getOne("select count(*) from ".table('order')." where sendtype=3 AND isvalid=1  and dateline>'$daystart' and dateline<'$dayend' AND shopid='$shopid' ")));//���ն����ɽ���
//������
$smarty->assign("guestnum",intval($db->getOne("select count(*) from ".table('guest')." where status=0 AND shopid='$shopid'")));
//����ʳ����
$smarty->assign("caicommentnum",intval($db->getOne("select count(*) from ".table('cai_comment')." where status=0 AND shopid='$shopid'")));
//�³�ʦ����
$smarty->assign("cookcommentnum",intval($db->getOne("select count(*) from ".table('cook_comment')." where status=0 AND shopid='$shopid' ")));
//����������
$smarty->assign("artcommentnum",intval($db->getOne("select count(*) from ".table('art_comment')." where status=0 AND shopid='$shopid' ")));
//�û���
$smarty->assign("usernum",intval($db->getOne("select count(*) from ".table('user')."  AND shopid='$shopid' ")));
$smarty->assign("userdaynum",intval($db->getOne("select count(*) from ".table('user')." where dateline>'$daystart' and dateline<'$dayend' AND shopid='$shopid' ")));


//�˵�����
$smarty->assign("cainum",$db->getOne("select count(*) from ".table('cai')." AND shopid='$shopid' "));


$smarty->display("main.html");

?>
