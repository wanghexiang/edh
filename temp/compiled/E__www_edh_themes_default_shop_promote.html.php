<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">

<div class="span8">


<p><h2>
 <a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>" target="_blank"><?php echo $this->_var['shop']['shopname']; ?></a>
 <small><?php if ($this->_var['shop']['opentype'] == 'doing'): ?>营业中<?php elseif ($this->_var['shop']['opentype'] == 'will'): ?>即将营业<?php else: ?>已打烊<?php endif; ?> <?php if ($this->_var['shopconfig']['ordertype']): ?>本店只支持电话订餐<?php endif; ?>  <?php echo $this->_var['shop']['phone']; ?>
 
 <?php if ($this->_var['shop']['isfav']): ?>
                        <a rel="nofollow" href="javascript:;" shopid="<?php echo $this->_var['shop']['shopid']; ?>"  class="btn btn-warning delshopfav">移出首页</a>
                        <?php elseif ($this->_var['ssuser']['userid']): ?>
						<a rel="nofollow" href="javascript:;" shopid="<?php echo $this->_var['shop']['shopid']; ?>"  class="btn btn_success fav-add addshopfav">加到首页</a>
                        <?php else: ?>
                        <a rel="nofollow" href="index.php?m=user&a=login"  class="btn" >登录收藏</a>
                        <?php endif; ?></small></h2>
 </p>
 <p>该餐厅订餐成功率颇高/最低消费
	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_var['shop']['qq']; ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $this->_var['shop']['qq']; ?>:41 &r=0.0803054568823427" alt="点击联系我<?php echo $this->_var['shop']['qq']; ?>" title="点击联系我<?php echo $this->_var['shop']['qq']; ?>"></a></p>
                           

 <table class="table table-bordered  table-condensed">
 
 <tbody>
 <?php $_from = $this->_var['cailist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai');if (count($_from)):
    foreach ($_from AS $this->_var['cai']):
?>
 <tr id="dish<?php echo $this->_var['cai']['id']; ?>" class=" dish ">
 
 <td class="span1"><span class="cart_count"><?php if ($this->_var['shopconfig']['ordertype'] == 0): ?><a href="javascript:;" class="addCart btn " caiid="<?php echo $this->_var['cai']['id']; ?>"  shopid='<?php echo $this->_var['cai']['shopid']; ?>' name="<?php echo $this->_var['cai']['title']; ?>" price="<?php echo $this->_var['cai']['price']; ?>" cart_count='0' >买</a><?php else: ?><a href="javascript:;" title="电话预定" class="btn btn-warning">+</a><?php endif; ?></span></td>
 <td class="span9"><span class="title"><?php echo $this->_var['cai']['title']; ?> </span></td>
 <td class="span2"><span class="price"><?php echo $this->_var['cai']['lowprice']; ?>元 <span style="text-decoration:line-through;"><?php echo $this->_var['cai']['price']; ?>元</span></span></td>
 </tr>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </tbody>
 
 </table>
 
</div>
<!--左边结束-->
<div class="span4">
 <?php echo $this->fetch('lib/shopcar.html'); ?>
 <?php echo $this->fetch('shop_right.html'); ?>
 </div>
 <!--右侧结束-->
</div>
<?php echo $this->fetch('lib/footer.html'); ?>