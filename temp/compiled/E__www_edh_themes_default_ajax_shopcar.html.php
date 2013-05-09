<!--购物车列表-->
<?php $_from = $this->_var['shopcart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 's');if (count($_from)):
    foreach ($_from AS $this->_var['s']):
?>
<div class="restaurant " id="cart_restaurant<?php echo $this->_var['s']['shopid']; ?>">
<div style="height:30px; line-height:30px;" ><a href="index.php?m=shop&shopid=<?php echo $this->_var['s']['shopid']; ?>" target="_blank"><?php echo $this->_var['s']['shopname']; ?></a> <small><?php if ($this->_var['s']['phone']): ?>(电话：<?php echo $this->_var['s']['phone']; ?> )<?php endif; ?></small></div>

<table class="table table-bordered">
<?php $_from = $this->_var['s']['cailist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai');if (count($_from)):
    foreach ($_from AS $this->_var['cai']):
?>   
<tr>
<td class="span4"><?php echo $this->_var['cai']['title']; ?></td>
<td class="span3"><?php echo $this->_var['cai']['price']; ?></td>

<td class="span3"><a href="javascript:;" class=" cart_l" caiid='<?php echo $this->_var['cai']['caiid']; ?>'>-</a>
<span class="cart_count" id="cart_count<?php echo $this->_var['cai']['caiid']; ?>"><?php echo $this->_var['cai']['cainum']; ?></span>
<a href="javascript:;" class="  cart_r" caiid='<?php echo $this->_var['cai']['caiid']; ?>'>+</a>
</td>

<td class="span2  cart_delete   "  caiid='<?php echo $this->_var['cai']['caiid']; ?>'><span class="pointer icon-remove"> </span></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<p>总价：<span id="totalmoney"><?php echo $this->_var['totalmoney']; ?></span>元</p>
<!--购物车结束-->
<script language="javascript">

	 
	$('tr').addClass('odd'); 
	$('tr:even').addClass('even'); //奇偶变色，添加样式 
</script>