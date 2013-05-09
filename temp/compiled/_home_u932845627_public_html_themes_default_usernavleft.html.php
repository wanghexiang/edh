	<div  >
    <?php mod_userinfo("u");?>
    <table class="table table-bordered">
    <thead>
    <tr>
    <td colspan="3"><a href="index.php?m=blog&userid=<?php echo $this->_var['u']['userid']; ?>"><img src="<?php if ($this->_var['u']['logo']): ?><?php echo $this->_var['u']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>" style="width:100px; height:100px;" /></a></td>
    
    </tr>
    <tr><td colspan="3" align="center"> <a href="index.php?m=blog&userid=<?php echo $this->_var['u']['userid']; ?>"><?php echo $this->_var['u']['nickname']; ?></a>  </td></tr>
    </thead>
    <tbody>
    <tr>
    <td><?php echo $this->_var['u']['followers']; ?><br /><a href="index.php?m=friend&a=follow&userid=<?php echo $this->_var['u']['userid']; ?>">关注</a></td>
    <td><?php echo $this->_var['u']['followeds']; ?><br /><a href="index.php?m=friend&a=followed&userid=<?php echo $this->_var['u']['userid']; ?>">粉丝</a></td>
    <td><?php echo $this->_var['u']['blogs']; ?><br /><a href="index.php?m=blog&a=my&userid=<?php echo $this->_var['u']['userid']; ?>">说说</a></td>
    </tr>
    <?php if ($_SESSION['ssuser']['userid'] != $_GET['userid']): ?>
    <tr>
    <td align="center" colspan="3">
    <?php if ($this->_var['ssuser']): ?><?php if ($this->_var['u']['followed']): ?> 
      <a href="javascript:;" url='index.php?m=friend&a=follow_del&touserid=<?php echo $this->_var['u']['userid']; ?>' class="ajax_follow_del btn btn-warning" shopid="<?php echo $this->_var['shop']['shopid']; ?>">取消关注</a>
      <?php else: ?>
      <a href="javascript:;" url='index.php?m=friend&a=follow_add&touserid=<?php echo $this->_var['u']['userid']; ?>' class="ajax_follow_add btn btn-success" shopid="<?php echo $this->_var['shop']['shopid']; ?>">加关注</a><?php endif; ?>
      <?php endif; ?>
    </td>
    </tr>
    <?php endif; ?>
    </tbody>
    </table>
    </div>
    
    
    <ul class="nav nav-tabs nav-stacked">
    	 
		<li <?php if ($_GET['m'] == 'blog'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=blog&a=my&userid=<?php echo $_GET['userid']; ?>">我的说说</a>
        </li>
        <li <?php if ($_GET['m'] == 'ordershare'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=ordershare&a=my&userid=<?php echo $_GET['userid']; ?>">我的吃吃</a>
        </li>
         <li <?php if ($_GET['m'] == 'friend'): ?>class="active"<?php endif; ?>>
         	<a href="index.php?m=friend">我的好友</a>
         </li>
        
        <li <?php if ($_GET['a'] == 'history'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=shopcar&a=history">订单历史</a>
		</li>
        
        <li <?php if ($_GET['m'] == 'groupbuy' && $_GET['a'] == 'my'): ?> class="active"<?php endif; ?>>
        	<a href="index.php?m=groupbuy&a=my">我的团购</a>
        </li>
        
        <li <?php if ($_GET['m'] == 'grade_log'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=grade_log">兑换记录</a>
        </li>
        
        <li <?php if ($_GET['m'] == 'room' & $_GET['a'] == 'my'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=room&a=my">包间预订</a>
        </li>
	
        <li <?php if ($_GET['m'] == 'fav'): ?>class="active"<?php endif; ?>><a href="index.php?m=fav">我的收藏</a></li>
        <li <?php if ($_GET['m'] == 'message'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=message">消息</a>
        </li>
        <li <?php if ($_GET['a'] == 'mycomment'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=shop&a=mycomment">评论管理</a>
        </li>
        
        <li <?php if ($_GET['m'] == 'pm'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=pm">私信</a>
        </li>

		<li <?php if ($_GET['a'] == 'my' && $_GET['m'] == 'guest'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=guest&a=my">我的答疑</a>
		</li>
		<li <?php if ($_GET['a'] == 'edi'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=edi">账户信息</a>
		</li>
  
        <li <?php if ($_GET['m'] == 'recharge'): ?> class="active"<?php endif; ?> >
        	<a href="index.php?m=recharge">在线充值</a>
        </li>
        
	 
	</ul>