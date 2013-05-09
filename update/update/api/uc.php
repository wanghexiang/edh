<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: uc.php 29302 2012-04-01 02:59:58Z zhangguosheng $
 */

//error_reporting(0);

define('UC_CLIENT_VERSION', '1.6.0');
define('UC_CLIENT_RELEASE', '20110501');

define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_ADDFEED', 1);
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '1');
define("APP_ROOT",dirname(basename(__FILE__)));
define("ROOT_PATH",dirname(basename(__FILE__)));
define('IN_API', true);
define('CURSCRIPT', 'api');



if(!defined('IN_UC')) {
require  './ucconfig/ucenter.config.php';
require '../config/config.inc.php';
require '../includes/lib_base.php';
require '../includes/lib_safe.php';
require '../includes/cls_db.php';
@ini_set("session.cookie_domain", DOMAIN);
session_start();


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('0d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
	$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
	$j = ($j + $box[$i] + $rndkey[$i]) % 256;
	$tmp = $box[$i];
	$box[$i] = $box[$j];
	$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
	$a = ($a + 1) % 256;
	$j = ($j + $box[$a]) % 256;
	$tmp = $box[$a];
	$box[$a] = $box[$j];
	$box[$j] = $tmp;
	$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
	if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
	return substr($result, 26);
	} else {
	return '';
	}
	} else {
	return $keyc.str_replace('=', '', base64_encode($result));
	}
}
function uc_serialize($arr, $htmlon = 0) {
	include_once APP_ROOT.'./lib/xml.class.php';
	return xml_serialize($arr, $htmlon);
}
function uc_unserialize($s) {
	include_once APP_ROOT.'./lib/xml.class.php';
	return xml_unserialize($s);
}
$get = $post = array();

$code = @$_GET['code'];
$get=$_GET;

parse_str(authcode($code, 'DECODE', UC_KEY), $get);

if(time() - $get['time'] > 3600) {
	exit('Authracation has expiried');
}
if(empty($get)) {
	exit('Invalid Request');
}

include_once APP_ROOT.'./uc_client/lib/xml.class.php';
$post = xml_unserialize(file_get_contents('php://input'));

if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings', 'addfeed'))) {
	$uc_note = new uc_note();
	echo $uc_note->$get['action']($get, $post);
	exit();
} else {
	exit(API_RETURN_FAILED);
}
} else {
	exit;
}

class uc_note {

	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';
	
	function __construct()
	{
		$this->db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
	}
	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once APP_ROOT.'./uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	function uc_note() {

	}

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}
	//删除用户
	function deleteuser($get, $post) {
		global $_G;
		if(!API_DELETEUSER) {
			return API_RETURN_FORBIDDEN;
		}

		$uids = str_replace("'", '', stripslashes($get['ids']));
		$this->db->query("DELETE FROM ".TABLE_PRE."user WHERE userid in($uids) ");
		return API_RETURN_SUCCEED;
		
	}
	//待定

	function renameuser($get, $post) {
		global $_G;

		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		/*
		array('id' => 'uid', 'name' => 'username')
		*/
		
		return API_RETURN_SUCCEED;
	}

	function gettag($get, $post) {
		global $_G;
		if(!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		}
		return $this->_serialize(array($get['id'], array()), 1);
	}
	//用户登陆 及注册
	function synlogin($get, $post) {
		global $_G;
	
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

		$cookietime = 31536000;
		$uid = intval($get['uid']);
		$user=$this->db->getRow("SELECT * FROM ".TABLE_PRE."user WHERE userid='$uid' ");
		
		if($user)
		{
			$_SESSION['ssuser']=$user;
		}else
		{
			$this->db->query("REPLACE INTO ".TABLE_PRE."user SET userid='$uid',username='uc_user_".$uid."',password='".umd5(1234567)."' ");
		}
	}

	//系统登出
	function synlogout($get, $post) {
		global $_G;

		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}

		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

		$_SESSION['ssuser']='';
	}
	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile ='../uc_client/data/cache/hosts.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		$UC_API = $post['UC_API'];

		//note 写 app 缓存文件
		$cachefile = '../uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		//note 写配置文件
		if(is_writeable('ucconfig/ucenter.config.php')) {
			$configfile = trim(file_get_contents('ucconfig/ucenter.config.php'));
			$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
			$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
			if($fp = @fopen('ucconfig/ucenter.config.php', 'w')) {
				@fwrite($fp, trim($configfile));
				@fclose($fp);
			}
		}
	
		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = '../uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		$credits = array();
		return $this->_serialize($credits);
	}

	function updatecreditsettings($get, $post) {
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}
	
}