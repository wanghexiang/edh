<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
<div class="span7">
<?php echo $this->fetch('membernav.html'); ?>

<script language="javascript">
$(document).ready(function()
{
	$("#content").val(getCookie("content"));
	$("#leftnum").html("你还可以输入"+(140-$("#content").val().length)+"字");
	$("#content").keyup(function()
	{
		setCookie("content",$("#content").val());
		$("#leftnum").html("你还可以输入"+(140-$("#content").val().length)+"字");
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
<p style=" padding-right:20px; text-align:right;" id="leftnum">你还可以输入140字</p>
<textarea name="content" id="content" style="width:100%; height:100px;"></textarea>
<input type="submit" value="发布" class="btn btn-success  " />
</form>
<div class="breadcrumb">说说列表</div>
<?php if ($this->_var['list']): ?>
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'b');if (count($_from)):
    foreach ($_from AS $this->_var['b']):
?>
<table class="table table-bordered">
<tr>
<td style="width:100px;"><img src='<?php echo getuserlogo($this->_var['b']["userid"],0,'middle');;?>' onerror="this.src='images/nologo.gif'" width="100" /></td>
<td><a href="index.php?m=member&userid=<?php echo $this->_var['b']['userid']; ?>"><?php echo $this->_var['b']['nickname']; ?></a>：<?php echo $this->_var['b']['content']; ?></td>
</tr>
<tr>
<td><a href="index.php?m=member&userid=<?php echo $this->_var['b']['userid']; ?>"><?php echo $this->_var['b']['nickname']; ?></a></td>
<td><p><?php echo timeago($this->_var['b']['dateline']);;?> 来自网页 <span style="float:right;"> <a href="javascript:;" style="display:none">转发</a> <a href="javascript:;" class="ajax_comment_btn" blogid="<?php echo $this->_var['b']['id']; ?>">评论</a>(<a href="index.php?m=blog&a=show&blogid=<?php echo $this->_var['b']['id']; ?>"><span id="comments_<?php echo $this->_var['b']['id']; ?>"><?php echo $this->_var['b']['comments']; ?></span></a>)</span></p>
	
    <div id="commentlist_<?php echo $this->_var['b']['id']; ?>" style="display:none;"></div>
   
</td>
</tr>
</table>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<p><?php echo $this->_var['pagelist']; ?></p>
</div>
<div class="span3">
<h2>说说</h2>
<p>可以说说心情，说说身边的事，分享喜欢的美食</p>
</div>

</div>
<?php echo $this->fetch('lib/footer.html'); ?>