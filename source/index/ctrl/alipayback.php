<?php
/* * 
 * ���ܣ�֧����ҳ����תͬ��֪ͨҳ��
 * �汾��3.2
 * ���ڣ�2011-03-25
 * ˵����
 * ���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 * �ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���

 *************************ҳ�湦��˵��*************************
 * ��ҳ����ڱ������Բ���
 * �ɷ���HTML������ҳ��Ĵ��롢�̻�ҵ���߼��������
 * ��ҳ�����ʹ��PHP�������ߵ��ԣ�Ҳ����ʹ��д�ı�����logResult���ú����ѱ�Ĭ�Ϲرգ���alipay_notify_class.php�еĺ���verifyReturn
 
 * TRADE_FINISHED(��ʾ�����Ѿ��ɹ�������Ϊ��ͨ��ʱ���ʵĽ���״̬�ɹ���ʶ);
 * TRADE_SUCCESS(��ʾ�����Ѿ��ɹ�������Ϊ�߼���ʱ���ʵĽ���״̬�ɹ���ʶ);
 */
 if(!defined("CT"))
{
	die('is wrong');
}
require_once("api/alipay/alipay.config.php");
require_once("api/alipay/lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
//����ó�֪ͨ��֤���
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//��֤�ɹ�
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//������������̻���ҵ���߼��������
	
	//�������������ҵ���߼�����д�������´�������ο�������
    //��ȡ֧������֪ͨ���ز������ɲο������ĵ���ҳ����תͬ��֪ͨ�����б�
    $out_trade_no	= $_GET['out_trade_no'];	//��ȡ������
    $trade_no		= $_GET['trade_no'];		//��ȡ֧�������׺�
    $total_fee		= $_GET['total_fee'];		//��ȡ�ܼ۸�	
	$uid = $_SESSION['ssuser']['userid'];
	if($db->getOne("SELECT logid FROM ".table('user_paylog')." WHERE ftype='alipay' AND orderno='$trade_no' "))
	{
		errback('�벻Ҫ�ظ��ύ��','index.php');
	}
	//��ֵ���˻�
	$db->query("UPDATE ".table('user')." SET balance=balance+'$total_fee' WHERE userid='$uid' ");
	
	$content=$_SESSION['ssuser']['nickname']."������".date("Y-m-d H:i:s")."��֧�����ɹ���ֵ{$total_fee}Ԫ�������ţ�{$out_trade_no}��֧�������׺ţ�{$trade_no}";
	$db->query("INSERT INTO ".table('user_paylog')." SET userid='$uid',money='$total_fee',dateline=".time().",ftype='alipay',orderno='$trade_no',content='$content' ");
	
	errback($content,"index.php?m=bonus&a=log");
	
	//�������������ҵ���߼�����д�������ϴ�������ο�������
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //��֤ʧ��
    //��Ҫ���ԣ��뿴alipay_notify.phpҳ���verifyReturn�������ȶ�sign��mysign��ֵ�Ƿ���ȣ����߼��$responseTxt��û�з���true
    errback( "��֤ʧ�ܣ����ײ��ɹ�","index.php");
}
?>
        <title>֧������ʱ���ʽӿ�</title>
	</head>
    <body>
    </body>
</html>