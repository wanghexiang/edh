
// JavaScript Document
$(document).ready(function()
{
		
	$(".ajax_yes").live("click",function()
	{
		
		$.get($(this).attr("url"));
		$(this).attr("src","images/yes.gif");
		url=$(this).attr("url");
		$(this).attr("url",$(this).attr("rurl"));
		$(this).attr("rurl",url);
		$(this).removeClass("ajax_yes").addClass("ajax_no");
	});
	
	$(".ajax_no").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).attr("src","images/no.gif");
		url=$(this).attr("url");
		$(this).attr("url",$(this).attr("rurl"));
		$(this).attr("rurl",url);
		$(this).removeClass("ajax_no").addClass("ajax_yes");
	});
	
	$(".ajax_pass").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("已审核");
	});
	$(".ajax_forbid").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("已禁止");
	});
	
	$(".ajax_del").bind("click",function(){
	 
		if(confirm('删除后不可恢复，确认删除吗？')){
			$.get($(this).attr("url"));
			$(this).parents("tr").remove();
		}
	})
	//验证用户是否已存在
	$("#ajax_username").bind("keyup",function()
	{
		if($("#ajax_username").val().length<1){
			$("#ajax_username_res").html("用户名不能为空");
			return false;
		}
		$.get(
		"index.php?m=ajax&a=ckuser&username="+$("#ajax_username").val(),function(data)
		{
			
			if(data==1)
			{
				$("#ajax_username_res").html("很抱歉，该用户已存在！");
			}else
			{
				$("#ajax_username_res").html("恭喜！该用户名可以注册！");
			}
		}
		)
	
	});
	//验证昵称是否已经存在
	$("#ajax_nickname").bind("keyup",function()
	{
		$.get(
		"index.php?m=ajax&a=cknickname&nickname="+$("#ajax_nickname").val(),function(data)
		{
			
			if(data==1)
			{
				$("#ajax_nickname_res").html("很抱歉，该昵称已存在！");
			}else
			{
				$("#ajax_nickname_res").html("恭喜！该昵称可以使用！");
			}
		}
	)
	
	});
	
	//验证邮箱是否合法
	$("#ajax_ckemail").bind("keyup",function()
	{
	$.get(
	"index.php?m=ajax&a=ckemail&email="+$("#ajax_ckemail").val(),function(data)
	{
		
		if(data==1)
		{
			$("#ajax_ckemail_res").html("恭喜！邮箱格式正确！");
		}else
		{
			$("#ajax_ckemail_res").html("很抱歉，邮箱格式不正确！");
		}
	}
	)
	
	});
	
	//验证验证码是否合法
	$("#ajax_ckyzm").bind("keyup",function()
	{
		$.get("index.php?m=ajax&a=ckyzm&yzm="+$("#ajax_ckyzm").val(),function(data)
		{
			if(data==1)
		{
			$("#ajax_ckyzm_res").html("验证码正确！");
		}else
		{
			$("#ajax_ckyzm_res").html("验证码错误");
		}
			
		});
		
	});
	//验证密码是否正确
	$("#ajax_pwd1,#ajax_pwd2").bind("keyup",function()
	{
		p1=$("#ajax_pwd1").val();
		
		if(p1.length<4)
		{
			$("#ajax_pwd1_res").html('密码长度要>=4');
		}else
		{
			$("#ajax_pwd1_res").html('密码符合要求');
		}
		if(p1!=$("#ajax_pwd2").val())
		{
			$("#ajax_pwd2_res").html('两次输入密码不一致');
		}else
		{
			$("#ajax_pwd2_res").html('密码符合要求');
		}
		
	});
	
	$("#myaccount").click(function()
	{
		if($("#myaccountlist").css("display")=='block')
		{
			$("#myaccountlist").css("display","none");
		}else
		{
		$("#myaccountlist").css("display","block");
		}
	});
	
	$(".ajax_addaddress").live("click",function()
	{
		$("#showBox").show();
		$("#showBox_content").html('<div class="breadcrumb">地址：<input type="text" class="h30" id="addresscontent"> <input type="button" id="addresscontent_submit" class="btn btn-success" value="添加" /> <input type="button" id="addresscontent_clear" class="btn btn-delete" value="取消" /></div>');
		$("#showBox").center();
		
	})
	
	$(".ajax_follow_add").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("已关注");
	});
	
	$(".ajax_follow_del").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("已取消");
	});
	
	
	$("#addresscontent_submit").live("click",function()
	{
		$.post("index.php?m=user&a=myaddress&op=post&ajax=1",{
			address : $("#addresscontent").val()
			},function(data)
			{				
				window.location.reload()
			});
	});
	
	$("#addresscontent_clear").live("click",function()
	{
		$("#addresscontent").val("");
		$("#showBox").hide();
	})
	
	//加入购物车
	$(".addCart").live("click",function()
	{
		//判断是否已经存在
		$t=$(this);		
		caiid = $t.attr('caiid');
		 
		x=window.event.clientX;
		y=window.event.clientY;
		$("#cart_outer").css('display',"block");
		$.get('index.php?m=shopcar&a=Add_db&ajax=1&caiid='+$(this).attr('caiid'),function(data)
		{
			if(data)
			{
				alert(data);
			}else
			{
				$("#go").css({left:x,top:y,opacity:100}).show();
				  
				getshopcar();
				$("#go").animate({
   left: 1000,top:$("#totalmoney").position().top, opacity: '0'
 }, 500) 
			}
		});
		
	});
	//加购物数量
	$(".cart_l").live("click",function()
	{
		 
		caiid=$(this).attr('caiid');
		cart_count=parseInt($("#cart_count"+caiid).html());
		if(cart_count>1)
		{
			$.get("index.php?m=shopcar&a=edinum&caiid="+caiid+"&cainum="+(cart_count-1),function(data){
					getshopcar();
			});

		}else{
			$.get('index.php?m=shopcar&a=del&caiid='+caiid,function(data){
				getshopcar()
			});
			 
		}
	})
	
	
	$(".cart_r").live("click",function()
	{
		caiid=$(this).attr('caiid');
		cart_count=parseInt($("#cart_count"+caiid).html());
		$.get("index.php?m=shopcar&a=edinum&caiid="+caiid+"&cainum="+(cart_count+1),function(data){
			getshopcar();
		})
		
	})
	
	$(".cart_delete").live("click",function()
	{
		caiid=$(this).attr('caiid');
		$.get('index.php?m=shopcar&a=del&caiid='+caiid,function(data){
			getshopcar();
		});
		
		
	})
	$(".mapinfo_show").live("click",function()
	{
		$.get('index.php?m=shop&ajax=1&shopid='+$(this).attr('shopid'),function(data)
		{
			$("#mapinfo").css('display','block');
			$('#mapinfo_content').html(data);
			
		});
	})
	//地图关闭
	$("#mapinfo_close").live("click",function()
	{
		$("#mapinfo").css('display','none');
		$("#mapinfo_content").html('');
	})
	//收藏管理
	$(".addshopfav").live("click",function()
	{
		$.get('index.php?m=fav&a=shopadd&shopid='+$(this).attr('shopid'));
		
		$(this).text('已加到首页');
	})
	
	$(".delshopfav").live("click",function()
	{
		$.get('index.php?m=fav&a=shopdel&shopid='+$(this).attr('shopid'));
		$(this).text('已移除');
		
	})
	
	$(".addcaifav").live("click",function()
	{
		$.get('index.php?m=fav&a=caiadd&caiid='+$(this).attr('caiid'));
		
		$(this).text('已收藏');
	})
	
	$(".delcaifav").live("click",function()
	{
		$.get('index.php?m=fav&a=caidel&caiid='+$(this).attr('caiid'));
		$(this).text('已取消');
		
	})
	
	
	
	
	/*--------------------------各种弹框显示------------------------------*/
	$("#showBox").live("mouseleave",function()
	{
		$(this).css("display","none");
	});
	$("#showBox_close").live("click",function()
	{
		$("#showBox").css("display","none");
	});
	/*私信*/
	$(".sendpm").live("click",function()
	{
		$t=$(this);
		$("#showBox_content").html("<table class='tb1' style='width:100%;'><tr ><td align='right' width='40px'>内容：<input type='hidden' id='pmsend_nickname' value='"+$t.attr('nickname')+"'></td><td><textarea id='pmsend_content' style='width:90%;height:60px;'></textarea></td></tr><tr><td></td><td><input type='button' class='btn' id='pmsend_submit' value='发送'></td></tr></table>");
		$("#showBox_title").html("::给"+$t.attr('nickname')+"发送私信");
		$("#showBox").css({display:"block",width:"400px",minHeight:"140px",height:"140px"});
		$("#showBox").center();
	});
	/*发送私信*/
	$('#pmsend_submit').live("click",function()
	{
		$.post("index.php?m=pm&a=send&op=post&ajax=1",{
				nicknames : $('#pmsend_nickname').val(),
				content  : $("#pmsend_content").val()
			},function(data)
		{
			alert(data);
			$("#showBox").css("display","none");
			
		})
	});
	
	//设置站点
	$("#setsites").bind("mouseleave",function()
	{
		$(this).hide();
	});
	setTimeout("getmsg()",3000);
});
//获取购物车
function getshopcar(){
	if($("#shopcar_shopid")){
			shopid = $("#shopcar_shopid").val();//购物车的id
		}else{
			shopid=0;
		}
	$.get('index.php?m=shopcar&a=index&ajax=1&shopid='+shopid,function(data)
		{
			$("#shopcarinfo").html(data);
		});
}
//获取消息
function getmsg()
{
	$.get("index.php?m=ajax&a=getmsg",function(data)
	{
		if(data)
		{
			$("#getmsg").html("("+data+")"); 
			
		}else
		{
			$("#getmsg").html("");
			
		}
	})
}
//获取购物车总价格
function changeprice()
{
	$.get("index.php?m=shopcar&a=totalmoney",function(data)
	{
		$("#totalmoney").html(data);
	});
}
//倒计时
function changelefttime()
{
	$(".lefttime").each( function()
	{
		$(this).html(lefttime(parseInt($(this).attr("endtime"))- parseInt(new Date().getTime()/1000)))
	});
}

function lefttime(time)
{
	if(time<=0)
	{
		return '团购活动结束';
	}
	//天数
	day=time/86400;
	day=day>=1?parseInt(day):0;
	//小时
	hour=(time-86400*day)/3600;
	hour=hour>=1?parseInt(hour):0;
	//分
	minute=(time-86400*day-3600*hour)/60;
	minute=minute>=1?parseInt(minute):0;
	//秒
	second=(time-86400*day-3600*hour-minute*60);
	second=second>0?second:0;
	var str='还有'+day+'天'+hour+'小时'+minute+'分'+second+'秒';
	return str;	
}

function setCookie(name,value)//两个参数，一个是cookie的名子，一个是值
{
var Days = 30; //此 cookie 将被保存 30 天
var exp = new Date(); //new Date("December 31, 9998");
exp.setTime(exp.getTime() + Days*24*60*60*1000);
document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//取cookies函数
{
var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)//删除cookie
{
var exp = new Date();
exp.setTime(exp.getTime() - 1);
var cval=getCookie(name);
if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
