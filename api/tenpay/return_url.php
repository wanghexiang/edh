<?php

//---------------------------------------------------------
//�Ƹ�ͨ��ʱ����֧��Ӧ�𣨴���ص���ʾ�����̻����մ��ĵ����п�������
//---------------------------------------------------------
if(!defined("CT"))
{
	die('is wrong');
}

require_once("$root/includes/init.php");
require_once ("./classes/PayResponseHandler.class.php");
require_once("tenpay_config.php");


/* ����֧��Ӧ����� */
$resHandler = new PayResponseHandler();
$resHandler->setKey($key);

//�ж�ǩ��
if($resHandler->isTenpaySign()) {
	
	//���׵���
	$transaction_id = $resHandler->getParameter("transaction_id");
	
	//���,�Է�Ϊ��λ
	$total_fee = $resHandler->getParameter("total_fee");
	
	//֧�����
	$pay_result = $resHandler->getParameter("pay_result");
	
	if( "0" == $pay_result ) {
	
		//------------------------------
		//����ҵ��ʼ
		//------------------------------
		
		//ע�⽻�׵���Ҫ�ظ�����
		//ע���жϷ��ؽ��
		
		//------------------------------
		//����ҵ�����
		//------------------------------	
		
		//����doShow, ��ӡmetaֵ��js����,���߲Ƹ�ͨ����ɹ�,�����û��������ʾ$showҳ��.
		$uid = $_SESSION['ssuser']['userid'];
		
		$content=$_SESSION['ssuser']['nickname']."������".date("Y-m-d H:i:s")."�òƸ�ͨ�ɹ���ֵ{$total_fee}Ԫ���Ƹ�ͨ���׺ţ�{$transaction_id}";
		if($db->getOne("SELECT id FROM ".table('user_bonus')." WHERE userid='$uid' "))
		{
			$db->query("UPDATE ".table('user_bonus')." SET bonus=bonus+'$total_fee' WHERE userid='$uid' ");
		}else
		{
			$db->query("INSERT INTO ".table('user_bonus')." SET userid='$uid',bonus='$total_fee' ");
		}
		$db->query("INSERT INTO ".table('user_bonus_log')." SET userid='$uid',bonus='$total_fee',dateline=".time().",content='$content' ");
		
		errback($content,"index.php?m=bonus&a=log");
		
		/*$show = "http://localhost/tenpay/show.php";
		$resHandler->doShow($show);
		*/
	
	} else {
		//�������ɹ�����
		errback("��ֵʧ������ϵ��վ����Ա","http://".DOMAIN);
	}
	
} else {
	errback("֧������֤ʧ������ϵ��վ����Ա","http://".DOMAIN);
}

//echo $resHandler->getDebugInfo();

?>