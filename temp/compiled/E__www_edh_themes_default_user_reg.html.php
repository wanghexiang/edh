<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>�û�ע��</title>
<link rel="stylesheet" type="text/css" href="image/gong.css"/>
<link rel="stylesheet" type="text/css" href="image/nei.css"/>

<style type="text/css" media="all">
body,div{font-size:12px;}
tr{height:32px;}
</style>
</head>
<body>
<?php echo $this->fetch('lib/header.html'); ?>
<script src="formvalidator/formValidator-4.1.1.js" type="text/javascript" ></script>
<script src="formvalidator/formValidatorRegex.js" type="text/javascript" ></script>
<div class="kuan clear col">1. ѡ����ʳ ��2. ��д�˶Զ�����Ϣ ��3. �ɹ��ύ����</div>
<div class="kuan bg_whitle mt15 pt25 pb25">
  <h1 class="n_zhuc ml30 pl40 f18 fz fb">����ע��</h1>
  <div class="left ml60">
 <form id="form1" name="form1" action="index.php?m=user&a=regdb" method="post" class="signInForm ml40 mt20">
 <fieldset class="bbd pb10 mb15">
 <legend>�����ǳƣ�</legend>

 <input id="username" name="username" maxlength="10" type="text" />
 <div id="usernameTip"></div>
 </fieldset>
  <fieldset class="pb10 mb15"> 
 <legend>��¼���룺</legend>
<label for="pw">
 <input name="pwd1" id="pwd1"    type="password" /></label><span id="s-psw-info" class="f12 ml10 colorRed"></span>
  <div id="pwd1tip"></div>
 <label for="re-pw">
 <input name="pwd2"  id="pwd2" maxlength="20" class=" w300 pw" type="password" /></label>
 <div id="pwd2tip"></div>
 </fieldset>
<fieldset class="bbd pb10 mb15">
 <legend>�������䣺</legend>
<label for="email">
 <input name="email" id="email" maxlength="50"  type="text" /></label>
    <div id="emailtip"></div>
 </fieldset>
 <fieldset class="bbd pb10 mb15">
 <legend>��ʵ������</legend>
<label for="truename">
 <input name="truename" id="truename"  value="" type="text" /></label>
    <div id="truenametip"></div>
 </fieldset>
 <fieldset class="bbd pb10 mb15">
 <legend>���ĵ绰��</legend>
<label for="phone">
 <input name="phone" id="phone"  value="" type="text" /></label>
    <div id="phonetip"></div>
 </fieldset>
 <!--
  <fieldset class="bbd pb10 mb15">
 <legend>��֤�룺</legend>
<label for="code">
 <input id="code" type="text" class=" w160 code" maxlength="4" /></label>
	<span id="s-code-info" class="f12 ml10 colorRed"></span>
	<p class="f12 mt5 color666 p5 mb10">�������������֤�룬�����ִ�Сд</p>
	<div class="clearfix mb10">
 <img src="image/yan.jpg" width="64" height="30" class="fl" />
 <p class="f12 pt10 fl ml10">�����壬<a href="#" class="color06c">�����һ�š�</a></p>
 </div>
 </fieldset>
-->
    <input style="background: url(/image/signInSprite.png) no-repeat 0 -298px; width:140px;height:55px;"  type="submit" value=""/>
     
 </form>
 </div>
 <div class="signInbox p10 left ml30">

     <p class="f12 pb10 bbd mb10 tc color06c lh30">�Ѿ�ע����ˣ�<a href="index.php?m=user&a=login"  class="loginBtn ml10">���¼</a></p>
 </div>
 <div class="clear"></div>
</div>

<?php echo $this->fetch('lib/footer.html'); ?>
</body>
</html>

<script type="text/javascript"> 
$(document).ready(function(){
$.formValidator.initConfig({formID:"form1",theme:'ArrowSolidBox',mode:'AutoTip',onError:function(msg){alert(msg)},inIframe:true});
     var username=$("#username").val(); 
     var email=$("#email").val();
     
	$("#username").formValidator({tipID:"usernameTip",onShow:"�������û���,ֻ������\"maodong\"���ǶԵ�",onFocus:"�û�������6���ַ�,���30���ַ�",onCorrect:"���û�������ע��"}).inputValidator({min:6,max:30,onError:"��������û����Ƿ�,��ȷ��"}).regexValidator({regExp:"username",dataType:"enum",onError:"�û�����ʽ����ȷ"})
	    .ajaxValidator({
		dataType : "html",  
		async : true,
        
		url : "index.php?m=user&a=checkusername&username="+username,
		success : function(data){
		   if(data==1)
           {
                info="���û����Ѿ���ע��";
           }
           else 
           {
                info="��ϲ�����û�������ע��";
                return true;
           }
			return info;
		},
		buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("������û�з������ݣ����ܷ�����æ��������"+errorThrown);},
		onError : "���û��������ã�������û���",
		onWait : "���ڶ��û������кϷ���У�飬���Ժ�..."
	});
	$("#pwd1").formValidator({tipID:"pwd1tip",onShow:"����������",onFocus:"���벻��Ϊ��",onCorrect:"����Ϸ�"}).inputValidator({min:1,onError:"���벻��Ϊ��,��ȷ��"});
	$("#pwd2").formValidator({tipID:"pwd2tip",onShow:"�������ظ�����",onFocus:"�����������һ��Ŷ",onCorrect:"����һ��"}).inputValidator({min:1,onError:"�ظ����벻��Ϊ��,��ȷ��"}).compareValidator({desID:"pwd1",operateor:"=",onError:"2�����벻һ��,��ȷ��"});
	$("#truename").formValidator({tipID:"truenametip",onShow:"������������ʵ�����������Ͳ�Ա������ϵ",onFocus:"������������ʵ�����������Ͳ�Ա������ϵ",onCorrect:"������ȷ"}).inputValidator({min:1,onError:"��ʵ��������Ϊ��,��ȷ��"});
	$("#email").formValidator({tipID:"emailtip",onShow:"����������",onFocus:"��������6���ַ�,���100���ַ�",onCorrect:"��ϲ��,�������",defaultValue:""}).inputValidator({min:6,max:100,onError:"����������䳤�ȷǷ�,��ȷ��"}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"������������ʽ����ȷ"})
     .ajaxValidator({
		dataType : "html",  
		async : true,
        
		url : "index.php?m=user&a=checkemail&email="+email,
		success : function(data){  
		   if(data==1)
           {
                info="�������Ѿ���ע�ᣬ��ʹ���������䣡";
           }
           else 
           {
               
                return true;
           }
			return info;
		},
		buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("������û�з������ݣ����ܷ�����æ��������"+errorThrown);},
		onError : "�������Ѿ���ע�ᣬ��ʹ���������䣡",
		onWait : "���ڶ�������кϷ���У�飬���Ժ�..."
        });
	
	$("#phone").formValidator({tipID:"phonetip",empty:true,onShow:"����������ֻ����룬����Ϊ��Ŷ",onFocus:"�����������ֻ���",onCorrect:"лл��ĺ���",onEmpty:"����Ĳ������ֻ����밡��"}).inputValidator({min:11,max:11,onError:"�ֻ����������11λ��,��ȷ��"}).regexValidator({regExp:"mobile",dataType:"enum",onError:"��������ֻ������ʽ����ȷ"});
	$("#lxdh").formValidator({empty:true,onShow:"�����������ϵ�绰������Ϊ��Ŷ",onFocus:"��ʽ���磺0577-88888888",onCorrect:"лл��ĺ���",onEmpty:"����Ĳ�������ϵ�绰����"}).regexValidator({regExp:"^[[0-9]{3}-|\[0-9]{4}-]?([0-9]{8}|[0-9]{7})?$",onError:"���������ϵ�绰��ʽ����ȷ"});
	$("#sjdh").formValidator({empty:true,onShow:"����������ֻ���绰������Ϊ��Ŷ",onFocus:"��ʽ���磺0577-88888888��11λ�ֻ�����",onCorrect:"лл��ĺ���",onEmpty:"����Ĳ������ֻ���绰����"}).regexValidator({regExp:["tel","mobile"],dataType:"enum",onError:"��������ֻ���绰��ʽ����ȷ"});
	$("#selectmore").formValidator({tipCss :{"left":"68px"},onShow:"��סCTRL���Զ�ѡ",onFocus:"��סCTRL���Զ�ѡ,����ѡ��2��",onCorrect:"лл��ĺ���",defaultValue:["0","1","2"]}).inputValidator({min:2,onError:"����ѡ��2��"});
	$("#ms").formValidator({onShow:"�������������",onFocus:"��������Ҫ����10�����ֻ�20���ַ�",onCorrect:"��ϲ��,�������",defaultValue:"��һ������ʲô��û�����¡�"}).inputValidator({min:20,onError:"��������������Ȳ���ȷ,��ȷ��"});
	$.formValidator.reloadAutoTip();
});
function test(obj)
{
	if(obj.value=="��У�����֤")
	{
		$("#sfzh").attr("disabled",true).unFormValidator(true);
		obj.value = "У�����֤";
	}
	else
	{
		$("#sfzh").attr("disabled",false).unFormValidator(false);
		obj.value = "��У�����֤";
	}
}
function test1(obj)
{
	var initConfig = $.formValidator.getInitConfig("1");
	if(obj.value=="ȫ���ַ�����1������")
	{
		initConfig.wideword = false;
		obj.value = "ȫ���ַ�����2������";
	}
	else
	{
		initConfig.wideword = true;
		obj.value = "ȫ���ַ�����1������";
	}
	$('body').data(obj.validatorgroup,initConfig);
}
function reloadAutoTip()
{
	$.formValidator.reloadAutoTip();
}
</script>
