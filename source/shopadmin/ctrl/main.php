<?php

check_login();
$shopid=intval($_SESSION['adminshop']['shopid']);
$daystart=strtotime(date("Y-m-d"));//一天的开始
$dayend=$daystart+86400;//一天的结束
//收入
$smarty->assign("money",floatval($db->getOne("select sum(money) from ".table('order')." where  sendtype=3 AND shopid='$shopid' ")));
$smarty->assign("daymoney",floatval($db->getOne("select sum(money) from ".table('order')." where sendtype=3 and dateline>'$daystart' and dateline<'$dayend' AND shopid='$shopid' ")));

//订餐数

$smarty->assign("ordernewnum",floatval($db->getOne("select count(*) from ".table('order')." where sendtype=0 AND isvalid=1 AND shopid='$shopid' ")));//新订单
$smarty->assign("ordernum",intval($db->getOne("select count(*) from ".table('order')." where  sendtype=3 AND isvalid=1   AND shopid='$shopid' ")));//订单成交总数
$smarty->assign("orderdaynum",intval($db->getOne("select count(*) from ".table('order')." where sendtype=3 AND isvalid=1  and dateline>'$daystart' and dateline<'$dayend' AND shopid='$shopid' ")));//今日订单成交数
//新留言
$smarty->assign("guestnum",intval($db->getOne("select count(*) from ".table('guest')." where status=0 AND shopid='$shopid'")));
//新美食评论
$smarty->assign("caicommentnum",intval($db->getOne("select count(*) from ".table('cai_comment')." where status=0 AND shopid='$shopid'")));
//新厨师评论
$smarty->assign("cookcommentnum",intval($db->getOne("select count(*) from ".table('cook_comment')." where status=0 AND shopid='$shopid' ")));
//新文章评论
$smarty->assign("artcommentnum",intval($db->getOne("select count(*) from ".table('art_comment')." where status=0 AND shopid='$shopid' ")));
//用户数
$smarty->assign("usernum",intval($db->getOne("select count(*) from ".table('user')."  AND shopid='$shopid' ")));
$smarty->assign("userdaynum",intval($db->getOne("select count(*) from ".table('user')." where dateline>'$daystart' and dateline<'$dayend' AND shopid='$shopid' ")));


//菜的数量
$smarty->assign("cainum",$db->getOne("select count(*) from ".table('cai')." AND shopid='$shopid' "));


$smarty->display("main.html");

?>
