<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>用户注册</title>
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
<div class="kuan clear col">1. 选择美食 →2. 填写核对订单信息 →3. 成功提交订单</div>
<div class="kuan bg_whitle mt15 pt25 pb25">
  <h1 class="n_zhuc ml30 pl40 f18 fz fb">快速注册</h1>
  <div class="left ml60">
 <form id="form1" name="form1" action="index.php?m=user&a=regdb" method="post" class="signInForm ml40 mt20">
 <fieldset class="bbd pb10 mb15">
 <legend>您的昵称：</legend>

 <input id="username" name="username" maxlength="10" type="text" />
 <div id="usernameTip"></div>
 </fieldset>
  <fieldset class="pb10 mb15"> 
 <legend>登录密码：</legend>
<label for="pw">
 <input name="pwd1" id="pwd1"    type="password" /></label><span id="s-psw-info" class="f12 ml10 colorRed"></span>
  <div id="pwd1tip"></div>
 <label for="re-pw">
 <input name="pwd2"  id="pwd2" maxlength="20" class=" w300 pw" type="password" /></label>
 <div id="pwd2tip"></div>
 </fieldset>
<fieldset class="bbd pb10 mb15">
 <legend>电子邮箱：</legend>
<label for="email">
 <input name="email" id="email" maxlength="50"  type="text" /></label>
    <div id="emailtip"></div>
 </fieldset>
 <fieldset class="bbd pb10 mb15">
 <legend>真实姓名：</legend>
<label for="truename">
 <input name="truename" id="truename"  value="" type="text" /></label>
    <div id="truenametip"></div>
 </fieldset>
 <fieldset class="bbd pb10 mb15">
 <legend>您的电话：</legend>
<label for="phone">
 <input name="phone" id="phone"  value="" type="text" /></label>
    <div id="phonetip"></div>
 </fieldset>
 <!--
  <fieldset class="bbd pb10 mb15">
 <legend>验证码：</legend>
<label for="code">
 <input id="code" type="text" class=" w160 code" maxlength="4" /></label>
	<span id="s-code-info" class="f12 ml10 colorRed"></span>
	<p class="f12 mt5 color666 p5 mb10">请输入下面的验证码，不区分大小写</p>
	<div class="clearfix mb10">
 <img src="image/yan.jpg" width="64" height="30" class="fl" />
 <p class="f12 pt10 fl ml10">看不清，<a href="#" class="color06c">点击换一张。</a></p>
 </div>
 </fieldset>
-->
    <input style="background: url(/image/signInSprite.png) no-repeat 0 -298px; width:140px;height:55px;"  type="submit" value=""/>
     
 </form>
 </div>
 <div class="signInbox p10 left ml30">

     <p class="f12 pb10 bbd mb10 tc color06c lh30">已经注册过了？<a href="index.php?m=user&a=login"  class="loginBtn ml10">请登录</a></p>
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
     
	$("#username").formValidator({tipID:"usernameTip",onShow:"请输入用户名,只有输入\"maodong\"才是对的",onFocus:"用户名至少6个字符,最多30个字符",onCorrect:"该用户名可以注册"}).inputValidator({min:6,max:30,onError:"你输入的用户名非法,请确认"}).regexValidator({regExp:"username",dataType:"enum",onError:"用户名格式不正确"})
	    .ajaxValidator({
		dataType : "html",  
		async : true,
        
		url : "index.php?m=user&a=checkusername&username="+username,
		success : function(data){
		   if(data==1)
           {
                info="该用户名已经被注册";
           }
           else 
           {
                info="恭喜，该用户名可以注册";
                return true;
           }
			return info;
		},
		buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "该用户名不可用，请更换用户名",
		onWait : "正在对用户名进行合法性校验，请稍候..."
	});
	$("#pwd1").formValidator({tipID:"pwd1tip",onShow:"请输入密码",onFocus:"密码不能为空",onCorrect:"密码合法"}).inputValidator({min:1,onError:"密码不能为空,请确认"});
	$("#pwd2").formValidator({tipID:"pwd2tip",onShow:"请输入重复密码",onFocus:"两次密码必须一致哦",onCorrect:"密码一致"}).inputValidator({min:1,onError:"重复密码不能为空,请确认"}).compareValidator({desID:"pwd1",operateor:"=",onError:"2次密码不一致,请确认"});
	$("#truename").formValidator({tipID:"truenametip",onShow:"请输入您的真实姓名，方便送餐员与您联系",onFocus:"请输入您的真实姓名，方便送餐员与您联系",onCorrect:"输入正确"}).inputValidator({min:1,onError:"真实姓名不能为空,请确认"});
	$("#email").formValidator({tipID:"emailtip",onShow:"请输入邮箱",onFocus:"邮箱至少6个字符,最多100个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:6,max:100,onError:"你输入的邮箱长度非法,请确认"}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"你输入的邮箱格式不正确"})
     .ajaxValidator({
		dataType : "html",  
		async : true,
        
		url : "index.php?m=user&a=checkemail&email="+email,
		success : function(data){  
		   if(data==1)
           {
                info="该邮箱已经被注册，请使用其它邮箱！";
           }
           else 
           {
               
                return true;
           }
			return info;
		},
		buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "该邮箱已经被注册，请使用其它邮箱！",
		onWait : "正在对邮箱进行合法性校验，请稍候..."
        });
	
	$("#phone").formValidator({tipID:"phonetip",empty:true,onShow:"请输入你的手机号码，可以为空哦",onFocus:"请输入您的手机号",onCorrect:"谢谢你的合作",onEmpty:"你真的不想留手机号码啊？"}).inputValidator({min:11,max:11,onError:"手机号码必须是11位的,请确认"}).regexValidator({regExp:"mobile",dataType:"enum",onError:"你输入的手机号码格式不正确"});
	$("#lxdh").formValidator({empty:true,onShow:"请输入你的联系电话，可以为空哦",onFocus:"格式例如：0577-88888888",onCorrect:"谢谢你的合作",onEmpty:"你真的不想留联系电话了吗？"}).regexValidator({regExp:"^[[0-9]{3}-|\[0-9]{4}-]?([0-9]{8}|[0-9]{7})?$",onError:"你输入的联系电话格式不正确"});
	$("#sjdh").formValidator({empty:true,onShow:"请输入你的手机或电话，可以为空哦",onFocus:"格式例如：0577-88888888或11位手机号码",onCorrect:"谢谢你的合作",onEmpty:"你真的不想留手机或电话了吗？"}).regexValidator({regExp:["tel","mobile"],dataType:"enum",onError:"你输入的手机或电话格式不正确"});
	$("#selectmore").formValidator({tipCss :{"left":"68px"},onShow:"按住CTRL可以多选",onFocus:"按住CTRL可以多选,至少选择2个",onCorrect:"谢谢你的合作",defaultValue:["0","1","2"]}).inputValidator({min:2,onError:"至少选择2个"});
	$("#ms").formValidator({onShow:"请输入你的描述",onFocus:"描述至少要输入10个汉字或20个字符",onCorrect:"恭喜你,你输对了",defaultValue:"这家伙很懒，什么都没有留下。"}).inputValidator({min:20,onError:"你输入的描述长度不正确,请确认"});
	$.formValidator.reloadAutoTip();
});
function test(obj)
{
	if(obj.value=="不校验身份证")
	{
		$("#sfzh").attr("disabled",true).unFormValidator(true);
		obj.value = "校验身份证";
	}
	else
	{
		$("#sfzh").attr("disabled",false).unFormValidator(false);
		obj.value = "不校验身份证";
	}
}
function test1(obj)
{
	var initConfig = $.formValidator.getInitConfig("1");
	if(obj.value=="全角字符当做1个长度")
	{
		initConfig.wideword = false;
		obj.value = "全角字符当做2个长度";
	}
	else
	{
		initConfig.wideword = true;
		obj.value = "全角字符当做1个长度";
	}
	$('body').data(obj.validatorgroup,initConfig);
}
function reloadAutoTip()
{
	$.formValidator.reloadAutoTip();
}
</script>
