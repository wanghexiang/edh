
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
		$(this).text("�����");
	});
	$(".ajax_forbid").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("�ѽ�ֹ");
	});
	
	$(".ajax_del").bind("click",function(){
	 
		if(confirm('ɾ���󲻿ɻָ���ȷ��ɾ����')){
			$.get($(this).attr("url"));
			$(this).parents("tr").remove();
		}
	})
	//��֤�û��Ƿ��Ѵ���
	$("#ajax_username").bind("keyup",function()
	{
		if($("#ajax_username").val().length<1){
			$("#ajax_username_res").html("�û�������Ϊ��");
			return false;
		}
		$.get(
		"index.php?m=ajax&a=ckuser&username="+$("#ajax_username").val(),function(data)
		{
			
			if(data==1)
			{
				$("#ajax_username_res").html("�ܱ�Ǹ�����û��Ѵ��ڣ�");
			}else
			{
				$("#ajax_username_res").html("��ϲ�����û�������ע�ᣡ");
			}
		}
		)
	
	});
	//��֤�ǳ��Ƿ��Ѿ�����
	$("#ajax_nickname").bind("keyup",function()
	{
		$.get(
		"index.php?m=ajax&a=cknickname&nickname="+$("#ajax_nickname").val(),function(data)
		{
			
			if(data==1)
			{
				$("#ajax_nickname_res").html("�ܱ�Ǹ�����ǳ��Ѵ��ڣ�");
			}else
			{
				$("#ajax_nickname_res").html("��ϲ�����ǳƿ���ʹ�ã�");
			}
		}
	)
	
	});
	
	//��֤�����Ƿ�Ϸ�
	$("#ajax_ckemail").bind("keyup",function()
	{
	$.get(
	"index.php?m=ajax&a=ckemail&email="+$("#ajax_ckemail").val(),function(data)
	{
		
		if(data==1)
		{
			$("#ajax_ckemail_res").html("��ϲ�������ʽ��ȷ��");
		}else
		{
			$("#ajax_ckemail_res").html("�ܱ�Ǹ�������ʽ����ȷ��");
		}
	}
	)
	
	});
	
	//��֤��֤���Ƿ�Ϸ�
	$("#ajax_ckyzm").bind("keyup",function()
	{
		$.get("index.php?m=ajax&a=ckyzm&yzm="+$("#ajax_ckyzm").val(),function(data)
		{
			if(data==1)
		{
			$("#ajax_ckyzm_res").html("��֤����ȷ��");
		}else
		{
			$("#ajax_ckyzm_res").html("��֤�����");
		}
			
		});
		
	});
	//��֤�����Ƿ���ȷ
	$("#ajax_pwd1,#ajax_pwd2").bind("keyup",function()
	{
		p1=$("#ajax_pwd1").val();
		
		if(p1.length<4)
		{
			$("#ajax_pwd1_res").html('���볤��Ҫ>=4');
		}else
		{
			$("#ajax_pwd1_res").html('�������Ҫ��');
		}
		if(p1!=$("#ajax_pwd2").val())
		{
			$("#ajax_pwd2_res").html('�����������벻һ��');
		}else
		{
			$("#ajax_pwd2_res").html('�������Ҫ��');
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
		$("#showBox_content").html('<div class="breadcrumb">��ַ��<input type="text" class="h30" id="addresscontent"> <input type="button" id="addresscontent_submit" class="btn btn-success" value="���" /> <input type="button" id="addresscontent_clear" class="btn btn-delete" value="ȡ��" /></div>');
		$("#showBox").center();
		
	})
	
	$(".ajax_follow_add").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("�ѹ�ע");
	});
	
	$(".ajax_follow_del").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("��ȡ��");
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
	
	//���빺�ﳵ
	$(".addCart").live("click",function()
	{
		//�ж��Ƿ��Ѿ�����
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
	//�ӹ�������
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
	//��ͼ�ر�
	$("#mapinfo_close").live("click",function()
	{
		$("#mapinfo").css('display','none');
		$("#mapinfo_content").html('');
	})
	//�ղع���
	$(".addshopfav").live("click",function()
	{
		$.get('index.php?m=fav&a=shopadd&shopid='+$(this).attr('shopid'));
		
		$(this).text('�Ѽӵ���ҳ');
	})
	
	$(".delshopfav").live("click",function()
	{
		$.get('index.php?m=fav&a=shopdel&shopid='+$(this).attr('shopid'));
		$(this).text('���Ƴ�');
		
	})
	
	$(".addcaifav").live("click",function()
	{
		$.get('index.php?m=fav&a=caiadd&caiid='+$(this).attr('caiid'));
		
		$(this).text('���ղ�');
	})
	
	$(".delcaifav").live("click",function()
	{
		$.get('index.php?m=fav&a=caidel&caiid='+$(this).attr('caiid'));
		$(this).text('��ȡ��');
		
	})
	
	
	
	
	/*--------------------------���ֵ�����ʾ------------------------------*/
	$("#showBox").live("mouseleave",function()
	{
		$(this).css("display","none");
	});
	$("#showBox_close").live("click",function()
	{
		$("#showBox").css("display","none");
	});
	/*˽��*/
	$(".sendpm").live("click",function()
	{
		$t=$(this);
		$("#showBox_content").html("<table class='tb1' style='width:100%;'><tr ><td align='right' width='40px'>���ݣ�<input type='hidden' id='pmsend_nickname' value='"+$t.attr('nickname')+"'></td><td><textarea id='pmsend_content' style='width:90%;height:60px;'></textarea></td></tr><tr><td></td><td><input type='button' class='btn' id='pmsend_submit' value='����'></td></tr></table>");
		$("#showBox_title").html("::��"+$t.attr('nickname')+"����˽��");
		$("#showBox").css({display:"block",width:"400px",minHeight:"140px",height:"140px"});
		$("#showBox").center();
	});
	/*����˽��*/
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
	
	//����վ��
	$("#setsites").bind("mouseleave",function()
	{
		$(this).hide();
	});
	setTimeout("getmsg()",3000);
});
//��ȡ���ﳵ
function getshopcar(){
	if($("#shopcar_shopid")){
			shopid = $("#shopcar_shopid").val();//���ﳵ��id
		}else{
			shopid=0;
		}
	$.get('index.php?m=shopcar&a=index&ajax=1&shopid='+shopid,function(data)
		{
			$("#shopcarinfo").html(data);
		});
}
//��ȡ��Ϣ
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
//��ȡ���ﳵ�ܼ۸�
function changeprice()
{
	$.get("index.php?m=shopcar&a=totalmoney",function(data)
	{
		$("#totalmoney").html(data);
	});
}
//����ʱ
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
		return '�Ź������';
	}
	//����
	day=time/86400;
	day=day>=1?parseInt(day):0;
	//Сʱ
	hour=(time-86400*day)/3600;
	hour=hour>=1?parseInt(hour):0;
	//��
	minute=(time-86400*day-3600*hour)/60;
	minute=minute>=1?parseInt(minute):0;
	//��
	second=(time-86400*day-3600*hour-minute*60);
	second=second>0?second:0;
	var str='����'+day+'��'+hour+'Сʱ'+minute+'��'+second+'��';
	return str;	
}

function setCookie(name,value)//����������һ����cookie�����ӣ�һ����ֵ
{
var Days = 30; //�� cookie �������� 30 ��
var exp = new Date(); //new Date("December 31, 9998");
exp.setTime(exp.getTime() + Days*24*60*60*1000);
document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//ȡcookies����
{
var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)//ɾ��cookie
{
var exp = new Date();
exp.setTime(exp.getTime() - 1);
var cval=getCookie(name);
if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
