<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>������̨</title>
<link type="text/css" rel="stylesheet" href="<?php echo $this->_var['skins']; ?>css.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript">
$(document).ready(function()
{
	$(".mtitle").click(function()
	{
		if($(this).next(".menu").css("display")=="block")
		{
			$(".menu").css("display","none")
		 
		}else
		{
			$(".menu").css("display","none")
			$(this).next(".menu").css({display:"block"});
		}
	});
	parent['main-frame'].location.href=$("a:eq(0)").attr("href");
	$("ul li a:eq(0)").addClass('on'); 
	$('ul li a').click(function(){
		$('ul li a').removeClass('on');
		$(this).addClass('on');
	});
});
</script>
</head>

<body id="menu-body">
<?php if ($_GET['a'] == 'shop'): ?>
<div class="mtitle">���̹���</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=shop" target="main-frame">���̹���</a></li>
<li><a href="admin.php?m=shop&a=add" target="main-frame">��������</a></li>
<li><a href="admin.php?m=shop&a=cat" target="main-frame">���̷���</a></li>
<li><a href="admin.php?m=shop&a=sendmoney" target="main-frame">���ͽ��</a></li>
<li><a href="admin.php?m=shop&a=avgmoney" target="main-frame">�˾�����</a></li>
<li><a href="admin.php?m=shop&a=apply" target="main-frame">�������</a></li>
<li><a href="admin.php?m=hotarea" target="main-frame">�ȵ���Ȧ</a></li>
<li><a href="admin.php?m=shop&a=check" target="main-frame">��������</a></li>
<li><a href="admin.php?m=province" target="main-frame">һ������</a></li>
<li><a href="admin.php?m=city" target="main-frame">��������</a></li>
<li><a href="admin.php?m=town" target="main-frame">��������</a></li>
</ul>
</div>
<?php endif; ?>


<?php if ($_GET['a'] == 'config'): ?>
<div class="mtitle">��վ����</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=web" target="main-frame">��վ��Ϣ</a></li>
<li><a href="admin.php?m=seo" target="main-frame">seo�Ż�</a></li>
<li><a href="admin.php?m=rank" target="main-frame">���ֵȼ�</a></li>
<li><a href="admin.php?m=config&a=spread" target="main-frame">�ƹ�����</a></li>
<li><a href="admin.php?m=config&a=thumb" target="main-frame">����ͼ����</a></li>
<li><a href="admin.php?m=config&a=phone" target="main-frame">��������</a></li>
<li><a href="admin.php?m=config&a=email" target="main-frame">��������</a></li>
<li><a href="admin.php?m=config&a=water" target="main-frame">ˮӡ����</a></li>
<li><a href="admin.php?m=config&a=rewrite" target="main-frame">α��̬����</a></li>

<li><a href="admin.php?m=config&a=pay" target="main-frame">֧������</a></li>


</ul>
</div>
<?php endif; ?>

<?php if ($_GET['a'] == 'yewu'): ?>
<div class="mtitle">ҵ�����</div>
<div class="menu" style="display:block;">
<ul>

<li><a href="admin.php?m=order" target="main-frame">��������</a></li>
<li><a href="admin.php?m=goods_order" target="main-frame">���ֶһ�</a></li>
<li><a href="admin.php?m=paylog" target="main-frame">��ֵ���Ѽ�¼</a></li>
<li><a href="admin.php?m=grade_log" target="main-frame">���ֶһ���¼</a></li>
<li><a href="admin.php?m=tixian" target="main-frame">���ֹ���</a></li>
<li><a href="admin.php?m=ad" target="main-frame">������</a></li>
</ul>
</div>
<?php endif; ?>

<?php if ($_GET['a'] == 'con' || ! $_GET['a']): ?>
<div class="mtitle">��վ����</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=blog" target="main-frame">˵˵����</a></li>
<li><a href="admin.php?m=comment" target="main-frame">��������</a></li>
<li><a href="admin.php?m=guest" target="main-frame">���Թ���</a></li>
<li><a href="admin.php?m=flash" target="main-frame">���Թ���</a></li>
<li><a href="admin.php?m=web_nav" target="main-frame">��������</a></li>

<li><a href="admin.php?m=html" target="main-frame">��ҳ����</a></li>
<li><a href="admin.php?m=link" target="main-frame">���ӹ���</a></li>

</ul>
</div>

<div class="mtitle">����ģ��</div>
<div class="menu" >
<ul>

<li><a href="admin.php?m=art" target="main-frame">���¹���</a></li>
<li><a href="admin.php?m=art&a=add" target="main-frame">��������</a></li>
<li><a href="admin.php?m=art_cat" target="main-frame">���·���</a></li>
<li><a href="admin.php?m=art_comment" target="main-frame">��������</a></li>

</ul>
</div>

 

<div class="mtitle">��ʳģ��</div>
<div class="menu" >
<ul>
<li><a href="admin.php?m=cai" target="main-frame">��ʳ����</a></li>
<li><a href="admin.php?m=cai_comment" target="main-frame">��ʳ����</a></li>
<li><a href="admin.php?m=cai_cat" target="main-frame">��ʳ����</a></li>
<li><a href="admin.php?m=cai_do" target="main-frame">���շ���</a></li>
<li><a href="admin.php?m=cai_wei" target="main-frame">��ζ����</a></li>
</ul>
</div>

<div class="mtitle">�Ź�����</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=groupbuy" target="main-frame">�Ź�����</a></li>
<li><a href="admin.php?m=groupbuy&a=category" target="main-frame">�Ź�����</a></li>
<li><a href="admin.php?m=groupbuy&a=order" target="main-frame">�Ź�����</a></li>
</ul>
</div>

<div class="mtitle">�����</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=activity" target="main-frame">�����</a></li>
<li><a href="admin.php?m=activity&a=add" target="main-frame">���ӻ</a></li>
<li><a href="admin.php?m=activity&a=topic" target="main-frame">�������</a></li>
<li><a href="admin.php?m=activity&a=user" target="main-frame">�û�����</a></li>
</ul>
</div>


<div class="mtitle">������Ʒ</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=goods" target="main-frame">��Ʒ����</a></li>
<li><a href="admin.php?m=goods&a=cat" target="main-frame">��Ʒ����</a></li>
<li><a href="admin.php?m=goods&a=add" target="main-frame">��Ʒ����</a></li>
<li><a href="admin.php?m=goods_comment" target="main-frame">��Ʒ����</a></li>
<li><a href="admin.php?m=goods_order" target="main-frame">�һ�����</a></li>
</ul>
</div>

<div class="mtitle">ʳ�׽̳�</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=caipu&a=cat" target="main-frame">ʳ�׷���</a></li>
<li><a href="admin.php?m=caipu&a=cat_add" target="main-frame">��������</a></li>
<li><a href="admin.php?m=caipu" target="main-frame">ʳ��</a></li>
<li><a href="admin.php?m=caipu&a=add" target="main-frame">��������</a>  </li>
<li><a href="admin.php?m=caipu&a=tags" target="main-frame">���ױ�ǩ</a></li>
</ul>
</div>

<div class="mtitle">�罻ģ��</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=weibo&a=config" target="main-frame">΢������</a></li>
<li><a href="admin.php?m=weibo&a=userlist"  target="main-frame">΢���û�</a></li>
<li><a href="admin.php?m=weibo&a=adduser"  target="main-frame">����΢���û�</a></li>
</ul>
</div>

<div class="mtitle">ͶƱģ��</div>
<div class="menu" >
<ul>
<li><a href="admin.php?m=vote&" target="main-frame">ͶƱ����</a></li>
<li><a href="admin.php?m=vote&a=tt" target="main-frame">ͶƱѡ��</a></li>
<li><a href="admin.php?m=vote&a=ttcat" target="main-frame">ѡ�����</a></li>
</ul>

</div>
<?php endif; ?>
<?php if ($_GET['a'] == 'user'): ?>
<div class="mtitle">�û�ģ��</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=user" target="main-frame">��Ա����</a></li>
<li><a href="admin.php?m=user&a=add" target="main-frame">��Ա����</a></li>
<li><a href="admin.php?m=admin" target="main-frame">����Ա����</a></li>
<li><a href="admin.php?m=admin&a=add" target="main-frame">����Ա����</a></li>
<li><a href="admin.php?m=admin&a=zu" target="main-frame">������</a></li>
</ul>
</div>
<?php endif; ?>
<?php if ($_GET['a'] == 'data'): ?>
<div class="mtitle">����ģ�����</div>
<div class="menu" style="display:block;" >
<ul>
<li><a href="admin.php?m=caches" target="main-frame">�������</a></li>
<li><a href="admin.php?m=skins" target="main-frame">ģ�����</a></li>
<li><a href="admin.php?m=skins_edi" target="main-frame">���߱༭</a></li>
<li><a href="admin.php?m=backup" target="main-frame">���ݻ�ԭ</a></li>
</ul>
</div>
<?php endif; ?>



</body>
</html>