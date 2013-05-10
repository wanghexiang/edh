<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">
<div class="span9">
<table class="table table-bordered">
<tr>
<td>名称</td>
<td>容量人数</td>
<td>今日预定</td>
<td>明日预定</td>
<td>预定</td>
</tr>
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
<td><?php echo $this->_var['c']['room_name']; ?></td>
<td><?php echo $this->_var['c']['room_men']; ?></td>
<td>今日预定</td>
<td>明日预定</td>
<td><a href="index.php?m=room&a=show&shopid=<?php echo $this->_var['c']['shopid']; ?>&id=<?php echo $this->_var['c']['id']; ?>">我要预定</a></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>

</div>
<div class="span3">
<h2>最新排队</h2>
<table class="table table-bordered">
<?php $_from = $this->_var['neworder']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
	<td><?php echo date("Y-m-d H:i",$this->_var['c']['order_time']); ?> <?php echo $this->_var['c']['room_name']; ?></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>


<h3>餐厅基本信息</h3>
 <table  class="table table-bordered table-striped table-condensed"  >
					<tr  >
					<td  width="100">外卖时间</td>
					<td class="span8"><?php echo $this->_var['shopconfig']['starthour']; ?>:<?php if (! $this->_var['shopcaonfig']['startminute']): ?>00<?php else: ?><?php echo $this->_var['shopconfig']['startminute']; ?><?php endif; ?>-<?php echo $this->_var['shopconfig']['endhour']; ?>:<?php if (! $this->_var['shopconfig']['endminute']): ?>00<?php else: ?><?php echo $this->_var['shopconfig']['endminute']; ?><?php endif; ?></td>
				</tr>
				<tr  >
					<td>送餐费用</td>
					<td><?php echo $this->_var['shopconfig']['sendprice']; ?>元</td>
				</tr>
				<tr >
					<td>起送金额</td>
					<td><?php echo $this->_var['shopconfig']['minprice']; ?>元</td>
				</tr>
                
                <tr  >
					<td>餐厅地址</td>
					<td><?php echo $this->_var['shop']['address']; ?></td>
				</tr>
                
                <tr  >
					<td>餐厅电话</td>
					<td><?php echo $this->_var['shop']['phone']; ?></td>
				</tr>
                
				<tr class="restaurant_info_item">
					<td>送餐范围</td>
					<td><?php echo $this->_var['shop']['sendarea']; ?></td>
				</tr>
					<tr  >
					<td>还有……</td>
					<td>
						<?php echo $this->_var['shop']['info']; ?>
					</td>
				</tr>
								
								
			</table>   
</div>
</div>


<?php echo $this->fetch('lib/footer.html'); ?>