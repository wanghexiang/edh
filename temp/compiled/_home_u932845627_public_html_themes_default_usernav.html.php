	<ul class="nav nav-tabs">
    	
        <li <?php if ($_GET['m'] == 'paylog'): ?> class="active"<?php endif; ?>>
        	<a href="index.php?m=paylog">账户余额</a>
        </li>
		<li <?php if ($_GET['a'] == 'chpwd'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=chpwd">帐号密码</a>
		</li>
		<li <?php if ($_GET['a'] == 'edi'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=edi">账户信息</a>
		</li>
		<li <?php if ($_GET['a'] == 'myaddress'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=myaddress">常用地址</a>
		</li>
		 <li <?php if ($_GET['m'] == 'gps'): ?> class="active"<?php endif; ?>>
        	<a href="index.php?m=user&a=gps">gps位置</a>
        </li>
        <li <?php if ($_GET['m'] == 'user' && $_GET['a'] == 'logo'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=user&a=logo">头像管理</a>
        </li>
        
         
        <li <?php if ($_GET['a'] == 'spread'): ?>class="active"<?php endif; ?>><a href="index.php?m=user&a=spread">我要推广</a></li>
	</ul>