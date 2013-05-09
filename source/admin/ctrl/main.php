<?php

check_login();
if(file_exists("install.lock"))
{
	$smarty->assign("install","请删除install目录");
}
$daystart=strtotime(date("Y-m-d"));//一天的开始
$dayend=$daystart+86400;//一天的结束
//收入
$smarty->assign("money",floatval($db->getOne("select sum(money) from ".table('order')." where  sendtype=3 AND siteid='$siteid' ")));
$smarty->assign("daymoney",floatval($db->getOne("select sum(money) from ".table('order')." where sendtype=3 and dateline>'$daystart' and dateline<'$dayend'  AND siteid='$siteid' ")));

//订餐数

$smarty->assign("ordernewnum",floatval($db->getOne("select count(*) from ".table('order')." where sendtype=0 AND isvalid=1   AND siteid='$siteid' ")));//新订单
$smarty->assign("ordernum",intval($db->getOne("select count(*) from ".table('order')." where  sendtype=3  AND isvalid=1  AND siteid='$siteid' ")));//订单成交总数
$smarty->assign("orderdaynum",intval($db->getOne("select count(*) from ".table('order')." where sendtype=3 and dateline>'$daystart' and dateline<'$dayend' AND isvalid=1   AND siteid='$siteid' ")));//今日订单成交数
//新留言
$smarty->assign("guestnum",intval($db->getOne("select count(*) from ".table('guest')." where status=0  AND siteid='$siteid' ")));
//新美食评论
$smarty->assign("caicommentnum",intval($db->getOne("select count(*) from ".table('cai_comment')." where status=0   AND siteid='$siteid'")));
//新厨师评论
$smarty->assign("cookcommentnum",intval($db->getOne("select count(*) from ".table('cook_comment')." where status=0  AND siteid='$siteid' ")));
//新文章评论
$smarty->assign("artcommentnum",intval($db->getOne("select count(*) from ".table('art_comment')." where status=0  AND siteid='$siteid' ")));
//用户数
$smarty->assign("usernum",intval($db->getOne("select count(*) from ".table('user')." ")));
$smarty->assign("userdaynum",intval($db->getOne("select count(*) from ".table('user')." where dateline>'$daystart' and dateline<'$dayend' ")));


//菜的数量
$smarty->assign("cainum",$db->getOne("select count(*) from ".table('cai')." "));
require_once(ROOT_PATH."includes/cls_version.php");
$version= new ct_version();
$smarty->assign("ct_version",$version->version());
$smarty->display("main.html");

?>
