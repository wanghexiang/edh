<?php echo $this->fetch('lib/top.lbi'); ?>
<script>
$(document).ready(function()
{
	$(".blogdel").click(function()
	{
		if(confirm('删除后不可恢复,确认删除？'))
		{
			$.get("admin.php?m=blog&a=del&id="+$(this).attr('blogid'));
			$(this).parents("tr").remove();
		}
		
	});
});
</script>
 
<div class="nav"><a href="admin.php?m=blog">说说</a></div>
<div class="nav_title">说说管理</div>
<div>
<?php if ($this->_var['list']): ?>
<table class="tb1"  style="width:90%">
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'b');if (count($_from)):
    foreach ($_from AS $this->_var['b']):
?>
<tr>
    <td width="30"><img src="<?php echo getuserlogo($this->_var['b']['userid'],0,'min');;?>" width=30></td>
    <td><a href="index.php?m=blog&a=my&userid=<?php echo $this->_var['b']['userid']; ?>" target="_blank"><?php echo $this->_var['b']['nickname']; ?></a>:<?php echo $this->_var['b']['content']; ?> <?php echo timeago($this->_var['b']['dateline']);?>
    <div style="color:red; float:right;"><a href="javascript:;"   class="blogdel" blogid=<?php echo $this->_var['b']['id']; ?>>删除</a></div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($this->_var['pagelist']): ?>
<tr>
<td colspan="2"><?php echo $this->_var['pagelist']; ?></td>
</tr>
<?php endif; ?>
</table>
<?php else: ?>
<h2>暂无说说</h2>
<?php endif; ?>

</div>


<?php echo $this->fetch('lib/foot.lbi'); ?>