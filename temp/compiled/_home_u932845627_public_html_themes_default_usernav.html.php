	<ul class="nav nav-tabs">
    	
        <li <?php if ($_GET['m'] == 'paylog'): ?> class="active"<?php endif; ?>>
        	<a href="index.php?m=paylog">�˻����</a>
        </li>
		<li <?php if ($_GET['a'] == 'chpwd'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=chpwd">�ʺ�����</a>
		</li>
		<li <?php if ($_GET['a'] == 'edi'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=edi">�˻���Ϣ</a>
		</li>
		<li <?php if ($_GET['a'] == 'myaddress'): ?>class="active"<?php endif; ?>>
			<a href="index.php?m=user&a=myaddress">���õ�ַ</a>
		</li>
		 <li <?php if ($_GET['m'] == 'gps'): ?> class="active"<?php endif; ?>>
        	<a href="index.php?m=user&a=gps">gpsλ��</a>
        </li>
        <li <?php if ($_GET['m'] == 'user' && $_GET['a'] == 'logo'): ?>class="active"<?php endif; ?>>
        	<a href="index.php?m=user&a=logo">ͷ�����</a>
        </li>
        
         
        <li <?php if ($_GET['a'] == 'spread'): ?>class="active"<?php endif; ?>><a href="index.php?m=user&a=spread">��Ҫ�ƹ�</a></li>
	</ul>