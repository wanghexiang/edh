<?php

//---------------------------------------------------------
//�Ƹ�ͨ��ʱ����֧��Ӧ�𣨴���ص���ʾ�����̻����մ��ĵ����п�������
//---------------------------------------------------------
if(!defined("CT"))
{
	die('is wrong');
}

require_once ("api/tenpay/classes/PayResponseHandler.class.php");
require_once("api/tenpay/tenpay_config.php");


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
		if($db->getOne("SELECT logid FROM ".table('user_paylog')." WHERE ftype='tenpay' AND orderno='$transaction_id' "))
		{
			errback('�벻Ҫ�ظ��ύ��','index.php');
		}
		$content=$_SESSION['ssuser']['username']."������".date("Y-m-d H:i:s")."�òƸ�ͨ�ɹ���ֵ{$total_fee}Ԫ���Ƹ�ͨ���׺ţ�{$transaction_id}";
		
		$db->query("UPDATE ".table('user')." SET balance=balance+'$total_fee' WHERE userid='$uid' ");
		
		$db->query("INSERT INTO ".table('user_paylog')." SET userid='$uid',money='$total_fee',dateline=".time().",content='$content',ftype='tenpay',orderno='$transaction_id' ");
		
		errback($content,"index.php?m=bonus&a=log");
		
	
	} else {
		//�������ɹ�����
		errback("��ֵʧ������ϵ��վ����Ա","http://".DOMAIN);
	}
	
} else {
	errback("�Ƹ�ͨ��֤ʧ������ϵ��վ����Ա","http://".DOMAIN);
}

//echo $resHandler->getDebugInfo();

?>