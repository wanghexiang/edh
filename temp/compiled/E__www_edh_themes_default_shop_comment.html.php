<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<script language="javascript" src="plugin/raty/js/jquery.raty.min.js" ></script>
<div class="row">

<div class="span8">

<?php if ($this->_var['list']): ?>

<script>



function pingfen(objstar,jf)
{
	$(objstar).raty(
	{
		 width :'100px',
		 hints : [1,2,3,4,5],
		 readOnly:true,
		 score : jf,
		 number : 5 ,
		 path	:'plugin/raty/img/'
	}
	);
}


</script> 
<pre>店铺评论是基于购买用户对于该店的评论，每个订单只能评价一次，店铺无权删除！</pre>
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>

<table class="table table-bordered">
<tr>
<td  >点评者：<?php if ($this->_var['g']['nickname']): ?><?php echo $this->_var['g']['nickname']; ?><?php else: ?>游客<?php endif; ?></td>
<td> 点评时间:<?php echo date("Y-m-d",$this->_var['g']['dateline']); ?></td>
</tr>
<tr>
<td>服务：<span id="star_fuwu_<?php echo $this->_var['g']['id']; ?>"></span></td>
<td>口味：<span id="star_kouwei_<?php echo $this->_var['g']['id']; ?>"></span></td>
</tr>
<tr>
<td>价格：<span id="star_jiage_<?php echo $this->_var['g']['id']; ?>"></span></td>
<td>配送时间：<span id="star_shijian_<?php echo $this->_var['g']['id']; ?>"></span></td>
</tr>
<tr><td colspan="2">总体评价：<span id="start_all_<?php echo $this->_var['g']['id']; ?>"></span></td></tr>

<tr>
<td colspan="2">内容：<?php echo $this->_var['g']['content']; ?></td>
</tr>

<?php if ($this->_var['g']['reply']): ?>
<tr>
<td colspan="2">
回复：<?php echo $this->_var['g']['reply']; ?>
</td>
</tr>
<?php endif; ?>
</table>
<script>
pingfen("#star_fuwu_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_fuwu']; ?>);
pingfen("#star_kouwei_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_kouwei']; ?>);
pingfen("#star_jiage_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_jiage']; ?>);
pingfen("#star_shijian_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_shijian']; ?>);
pingfen("#star_all_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_all']; ?>);
</script>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php if ($this->_var['pagelist']): ?><?php echo $this->_var['pagelist']; ?><?php endif; ?>
<?php else: ?>
<h2>暂无评论</h2>
<?php endif; ?>


</div>
<!--左边结束-->
<div class="span4">
<?php echo $this->fetch('shop_right.html'); ?>

 </div>
 <!--右侧结束-->
</div>
<?php echo $this->fetch('lib/footer.html'); ?>