<?php

check_login();
if(file_exists("install.lock"))
{
	$smarty->assign("install","��ɾ��installĿ¼");
}
$daystart=strtotime(date("Y-m-d"));//һ��Ŀ�ʼ
$dayend=$daystart+86400;//һ��Ľ���
//����
$smarty->assign("money",floatval($db->getOne("select sum(money) from ".table('order')." where  sendtype=3 AND siteid='$siteid' ")));
$smarty->assign("daymoney",floatval($db->getOne("select sum(money) from ".table('order')." where sendtype=3 and dateline>'$daystart' and dateline<'$dayend'  AND siteid='$siteid' ")));

//������

$smarty->assign("ordernewnum",floatval($db->getOne("select count(*) from ".table('order')." where sendtype=0 AND isvalid=1   AND siteid='$siteid' ")));//�¶���
$smarty->assign("ordernum",intval($db->getOne("select count(*) from ".table('order')." where  sendtype=3  AND isvalid=1  AND siteid='$siteid' ")));//�����ɽ�����
$smarty->assign("orderdaynum",intval($db->getOne("select count(*) from ".table('order')." where sendtype=3 and dateline>'$daystart' and dateline<'$dayend' AND isvalid=1   AND siteid='$siteid' ")));//���ն����ɽ���
//������
$smarty->assign("guestnum",intval($db->getOne("select count(*) from ".table('guest')." where status=0  AND siteid='$siteid' ")));
//����ʳ����
$smarty->assign("caicommentnum",intval($db->getOne("select count(*) from ".table('cai_comment')." where status=0   AND siteid='$siteid'")));
//�³�ʦ����
$smarty->assign("cookcommentnum",intval($db->getOne("select count(*) from ".table('cook_comment')." where status=0  AND siteid='$siteid' ")));
//����������
$smarty->assign("artcommentnum",intval($db->getOne("select count(*) from ".table('art_comment')." where status=0  AND siteid='$siteid' ")));
//�û���
$smarty->assign("usernum",intval($db->getOne("select count(*) from ".table('user')." ")));
$smarty->assign("userdaynum",intval($db->getOne("select count(*) from ".table('user')." where dateline>'$daystart' and dateline<'$dayend' ")));


//�˵�����
$smarty->assign("cainum",$db->getOne("select count(*) from ".table('cai')." "));
require_once(ROOT_PATH."includes/cls_version.php");
$version= new ct_version();
$smarty->assign("ct_version",$version->version());
$smarty->display("main.html");

?>
