<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
<div class="span7">
<ul class="nav nav-tabs">
<li <?php if ($_GET['a'] == 'follow'): ?> class="active"<?php endif; ?>><a href="index.php?m=friend&a=follow" >我的关注</a></li>
<li <?php if ($_GET['a'] == 'followed'): ?> class="active"<?php endif; ?>><a href="index.php?m=friend&a=followed"  >我的粉丝</a></li>
<li><a href="index.php?m=search&type=people">找人</a></li>
</ul>
<?php if ($this->_var['user']): ?>
<table class="table table-bordered">
<tr>
	<td><a href="index.php?m=photos&userid=<?php echo $this->_var['user']['userid']; ?>" target="_blank" title="<?php echo $this->_var['user']['nickname']; ?>"><img src="<?php echo $this->_var['user']['logo']; ?>" class="usercard" wb_screen_name="hardbye" alt="<?php echo $this->_var['user']['nickname']; ?>"></a></td>
    <td><a href="index.php?m=photos&userid=<?php echo $this->_var['user']['userid']; ?>" target="_blank" class="usercard" wb_screen_name="hardbye"><?php echo $this->_var['user']['nickname']; ?></a> <a href='index.php?m=friend&a=follow&userid=<?php echo $this->_var['user']['userid']; ?>'>粉丝[<?php echo $this->_var['user']['followeds']; ?>]</a> <a href="index.php?m=friend&a=followed&userid=<?php echo $this->_var['user']['userid']; ?>">关注[<?php echo $this->_var['user']['follows']; ?>]</a></td>
</tr>
<tr>
	<td colspan="2"><?php if ($this->_var['user']['follow']): ?><a href="javascript:void(0);" class="btn_followed"><img src="http://img.app.wcdn.cn/ops/photo/style/images_v4/transparent.gif" class="mt_icon icon_follow"><?php if ($this->_var['user']['followed']): ?>好友<?php else: ?>已关注<?php endif; ?></a>&nbsp;&nbsp;<a href="index.php?m=friend&a=follow_del&touserid=<?php echo $this->_var['user']['userid']; ?>">取消</a><?php else: ?><a href="index.php?m=friend&a=follow_add&touserid=<?php echo $this->_var['user']['userid']; ?>">加关注</a><?php endif; ?></td>
</tr>

</table>
<?php endif; ?>

<?php $_from = $this->_var['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>		
<table class="table table-bordered">
<tr>
<td width="100" rowspan="2"><a href="index.php?m=blog&userid=<?php echo $this->_var['user']['userid']; ?>"  ><img src="<?php if ($this->_var['user']['logo']): ?><?php echo $this->_var['user']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>" style=" width:100px; background:url() center center no-repeat"></a></td>
<td width="896">
	<a href="index.php?m=blog&userid=<?php echo $this->_var['user']['userid']; ?>"><?php echo $this->_var['user']['nickname']; ?></a>  <?php echo $this->_var['user']['followers']; ?> 关注 <?php echo $this->_var['user']['followeds']; ?> 粉丝 &nbsp;<a class="btn btn-succcess btn-mini sendpm" href="javascript:;" nickname=<?php echo $this->_var['user']['nickname']; ?>><i class="icon-envelope"></i>私信</a>
    <?php if ($_GET['a'] == 'follow'): ?>
      
    <?php if ($this->_var['user']['status'] == 1): ?>已关注<?php elseif ($this->_var['user']['status'] == 2): ?>好友<?php endif; ?><em>｜</em>
    <a href="javascript:;" url="index.php?m=friend&a=follow_del&touserid=<?php echo $this->_var['user']['userid']; ?>" class="ajax_follow_del"  >取消关注</a>
     
    <?php else: ?>
     
    <?php if ($this->_var['user']['status'] == 2): ?>好友<em>｜</em>
    <a href="javascript:;" url="index.php?m=friend&a=follow_del&touserid=<?php echo $this->_var['user']['userid']; ?>" class="ajax_follow_del"  >取消关注</a>
    <?php else: ?>
    <a href="javascript:;" class="ajax_follow_add" url="index.php?m=friend&a=follow_add&ajax=1&touserid=<?php echo $this->_var['user']['userid']; ?>">加关注</a>
    <?php endif; ?>
      
    
    <?php endif; ?>

</td>
</tr>
<tr>
  <td><?php echo $this->_var['user']['info']; ?></td>
</tr>

</table>													
				
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>				
			
			 
<div><?php echo $this->_var['pagelist']; ?></div>


</div>
<div class="span3">
<h2>我的好友</h2>
<p>关注你的好友，关注他的美食，他的分享</p>
</div>
</div>



<?php echo $this->fetch('lib/footer.html'); ?>