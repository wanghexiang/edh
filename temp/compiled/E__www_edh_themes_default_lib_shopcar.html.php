<div  style="width:320px; display:block;position:fixed;bottom:3px;right:0px; max-height:500px; overflow-x:hidden; overflow-y:scroll; " >
	<div id="cart_min" class="cart_min"   onclick="$('#cart_outer').toggle(600);" ><a  >::我的外卖盒</a></div>
    
    
	<div id="cart_outer"   style=" width:300px;padding:6px; display:none; background-color:#E0F0FF;  z-index:10000; ">
			 
			
		 <div id="shopcarinfo"  >
            <!--购物车列表-->
            <?php echo $this->fetch('ajax_shopcar.html'); ?>
          </div> 
			<p>
				(点击左侧的餐品，然后这里下单，再不用打电话啦，友情提示不同店铺将分别产生订单)
			</p>
			<div id="order_controls">
				<a id="cart_clear"  class="btn  btn-danger " href="index.php?m=shopcar&a=clearCar" rel="nofollow"> 清空 </a>
				<a id="cart_submit" class="btn btn-primary" href="index.php?m=shopcar&a=buy&shopid=<?php echo $_GET['shopid']; ?>" rel="nofollow"> 创建订单 </a>
               <!--
			   <?php if ($this->_var['ssuser']): ?>
				<a id="cart_view" class="btn btn-warning" href="index.php?m=order&a=history" rel="nofollow">查看订单</a>
                <?php endif; ?>
				-->
			</div>
		
			</div>
	
</div>
 