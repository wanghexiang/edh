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
    <td><?php echo $this->_var['u']['followers']; ?><br /><a href="index.php?m=friend&a=follow&userid=<?php echo $this->_var['u']['userid']; ?>">��ע</a></td>
    <td><?php echo $this->_var['u']['followeds']; ?><br /><a href="index.php?m=friend&a=followed&userid=<?php echo $this->_var['u']['userid']; ?>">��˿</a></td>
    <td><?php echo $this->_var['u']['blogs']; ?><br /><a href="index.php?m=blog&a=my&userid=<?php echo $this->_var['u']['userid']; ?>">˵˵</a></td>
    </tr>
    <?php if ($_SESSION['ssuser']['userid'] != $_GET['userid']): ?>
    <tr>
    <td align="center" colspan="3">
    <?php if ($this->_var['ssuser']): ?><?php if ($this->_var['u']['followed']): ?> 
      <a href="javascript:;" url='index.php?m=friend&a=follow_del&touserid=<?php echo $this->_var['u']['userid']; ?>' class="ajax_follow_del btn btn-warning" shopid="<?php echo $this->_var['shop']['shopid']; ?>">ȡ����ע</a>
      <?php else: ?>
      <a href="javascript:;" url='index.php?m=friend&a=follow_add&touserid=<?php echo $this->_var['u']['userid']; ?>' class="ajax_follow_add btn btn-success" shopid="<?php echo $this->_var['shop']['shopid']; ?>">�ӹ�ע</a><?php endif; ?>
      <?php endif; ?>
    </td>
    </tr>
    <?php endif; ?>
    </tbody>
    </table>
    </div>
    
    
    <ul class="nav nav-tabs nav-stacked">
    	 
		<li <?php if ($_GET['m'] == 'blog'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=blog&a=my&userid=<?php echo $_GET['userid']; ?>">�ҵ�˵˵</a>
        </li>
        <li <?php if ($_GET['m'] == 'ordershare'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=ordershare&a=my&userid=<?php echo $_GET['userid']; ?>">�ҵĳԳ�</a>
        </li>
         <li <?php if ($_GET['m'] == 'friend'): ?>class="active"<?php endif; ?>>
         	<a href="index.php?m=friend">�ҵĺ���</a>
         </li>
        
        <li <?php if ($_GET['a'] == 'history'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=shopcar&a=history">������ʷ</a>
		</li>
        
        <li <?php if ($_GET['m'] == 'groupbuy' && $_GET['a'] == 'my'): ?> class="active"<?php endif; ?>>
        	<a href="index.php?m=groupbuy&a=my">�ҵ��Ź�</a>
        </li>
        
        <li <?php if ($_GET['m'] == 'grade_log'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=grade_log">�һ���¼</a>
        </li>
        
        <li <?php if ($_GET['m'] == 'room' & $_GET['a'] == 'my'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=room&a=my">����Ԥ��</a>
        </li>
	
        <li <?php if ($_GET['m'] == 'fav'): ?>class="active"<?php endif; ?>><a href="index.php?m=fav">�ҵ��ղ�</a></li>
        <li <?php if ($_GET['m'] == 'message'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=message">��Ϣ</a>
        </li>
        <li <?php if ($_GET['a'] == 'mycomment'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=shop&a=mycomment">���۹���</a>
        </li>
        
        <li <?php if ($_GET['m'] == 'pm'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=pm">˽��</a>
        </li>

		<li <?php if ($_GET['a'] == 'my' && $_GET['m'] == 'guest'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=guest&a=my">�ҵĴ���</a>
		</li>
		<li <?php if ($_GET['a'] == 'edi'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=edi">�˻���Ϣ</a>
		</li>
  
        <li <?php if ($_GET['m'] == 'recharge'): ?> class="active"<?php endif; ?> >
        	<a href="index.php?m=recharge">���߳�ֵ</a>
        </li>
        
	 
	</ul>