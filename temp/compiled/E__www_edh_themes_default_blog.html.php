<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
<div class="span7">
<?php echo $this->fetch('membernav.html'); ?>

<script language="javascript">
$(document).ready(function()
{
	$("#content").val(getCookie("content"));
	$("#leftnum").html("�㻹��������"+(140-$("#content").val().length)+"��");
	$("#content").keyup(function()
	{
		setCookie("content",$("#content").val());
		$("#leftnum").html("�㻹��������"+(140-$("#content").val().length)+"��");
	});
	$(".ajax_comment_btn").live("click",function()
	{
		blogid=$(this).attr("blogid");
		$.get("index.php?m=blog&a=ajaxcommentlist&blogid="+blogid,function(data){
			$("#commentlist_"+blogid).html(data).toggle();	
		})
	});
	
});
</script>
<form method="post" action="index.php?m=blog&a=post">
<p style=" padding-right:20px; text-align:right;" id="leftnum">�㻹��������140��</p>
<textarea name="content" id="content" style="width:100%; height:100px;"></textarea>
<input type="submit" value="����" class="btn btn-success  " />
</form>
<div class="breadcrumb">˵˵�б�</div>
<?php if ($this->_var['list']): ?>
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'b');if (count($_from)):
    foreach ($_from AS $this->_var['b']):
?>
<table class="table table-bordered">
<tr>
<td style="width:100px;"><img src='<?php echo getuserlogo($this->_var['b']["userid"],0,'middle');;?>' onerror="this.src='images/nologo.gif'" width="100" /></td>
<td><a href="index.php?m=member&userid=<?php echo $this->_var['b']['userid']; ?>"><?php echo $this->_var['b']['nickname']; ?></a>��<?php echo $this->_var['b']['content']; ?></td>
</tr>
<tr>
<td><a href="index.php?m=member&userid=<?php echo $this->_var['b']['userid']; ?>"><?php echo $this->_var['b']['nickname']; ?></a></td>
<td><p><?php echo timeago($this->_var['b']['dateline']);;?> ������ҳ <span style="float:right;"> <a href="javascript:;" style="display:none">ת��</a> <a href="javascript:;" class="ajax_comment_btn" blogid="<?php echo $this->_var['b']['id']; ?>">����</a>(<a href="index.php?m=blog&a=show&blogid=<?php echo $this->_var['b']['id']; ?>"><span id="comments_<?php echo $this->_var['b']['id']; ?>"><?php echo $this->_var['b']['comments']; ?></span></a>)</span></p>
	
    <div id="commentlist_<?php echo $this->_var['b']['id']; ?>" style="display:none;"></div>
   
</td>
</tr>
</table>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<p><?php echo $this->_var['pagelist']; ?></p>
</div>
<div class="span3">
<h2>˵˵</h2>
<p>����˵˵���飬˵˵��ߵ��£�����ϲ������ʳ</p>
</div>

</div>
<?php echo $this->fetch('lib/footer.html'); ?>