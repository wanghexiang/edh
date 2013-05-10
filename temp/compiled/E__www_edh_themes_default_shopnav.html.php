<input type="hidden" id="shopcar_shopid" value="<?php echo $_GET['shopid']; ?>" />
<ul class="nav nav-tabs">
<li <?php if ($_GET['a'] == 'index'): ?> class="active"<?php endif; ?>><a href="index.php?m=shop&shopid=<?php echo $_GET['shopid']; ?>">店铺首页</a></li>
<li <?php if ($_GET['a'] == 'promote'): ?> class="active"<?php endif; ?>><a href="index.php?m=shop&a=promote&shopid=<?php echo $_GET['shopid']; ?>">促销</a></li>
<li <?php if ($_GET['m'] == 'groupbuy'): ?> class="active"<?php endif; ?>><a href="index.php?m=groupbuy&a=shop&shopid=<?php echo $_GET['shopid']; ?>">团购</a></li>
<li <?php if ($_GET['m'] == 'room'): ?> class="active"<?php endif; ?> ><a href="index.php?m=room&shopid=<?php echo $_GET['shopid']; ?>">包间</a></li>
<li <?php if ($_GET['a'] == 'detail'): ?> class="active"<?php endif; ?>><a href="index.php?m=shop&a=detail&shopid=<?php echo $_GET['shopid']; ?>">详情</a></li>
<li <?php if ($_GET['a'] == 'comment'): ?> class="active"<?php endif; ?>><a href="index.php?m=shop&a=comment&shopid=<?php echo $_GET['shopid']; ?>">评论</a></li>
<li <?php if ($_GET['a'] == 'guest'): ?>class="active"<?php endif; ?>><a href="index.php?m=shop&a=guest&shopid=<?php echo $_GET['shopid']; ?>">留言</a></li>
<li <?php if ($_GET['a'] == 'neworder'): ?>class="active"<?php endif; ?>><a href="index.php?m=shop&a=neworder&shopid=<?php echo $_GET['shopid']; ?>">订单</a></li>
</ul>