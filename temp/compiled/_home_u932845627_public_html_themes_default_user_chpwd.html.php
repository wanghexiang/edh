<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
	<div class="span2">
    	<?php echo $this->fetch('usernavleft.html'); ?>
    </div>
	<div class="span10">
    <?php echo $this->fetch('usernav.html'); ?>
    <form class="account_form " action="index.php?m=user&a=chpwd_db" method="post">												 
 	<table class="table table-bordered">
    <tr><td colspan="2"><h2>�˺������޸�</h2></td></tr>
    <tr>
    	<td>Email</td>
        <td>
      		  <?php if ($this->_var['user']['email']): ?>
					<input disabled="disabled" type="text" class="h30" id="email" name="email" value="<?php echo $this->_var['user']['email']; ?>"><?php else: ?>
                    <input   type="text" class="text disabled" id="email" name="email" value=""> ��д�󲻿��޸�
                 <?php endif; ?>
        </td>
     </tr>
     
     <tr>
     	<td>�û���</td>
        <td><input type="text" disabled="disabled" class="h30" id="username" name="username" value="<?php echo $this->_var['user']['username']; ?>"></td>
     </tr>
     <tr>
     	<td>������</td>
        <td><input type="password" class="h30" id="ajax_pwd1" name="pwd1" value="" autocomplete="off"> <span id="ajax_pwd1_res"></span>
					<div class="hint">��������޸����룬�뱣�ֿհ�</div></td>
     
     </tr>
     
     <tr>
     	<td>�ظ�����</td>
        <td><input type="password" class="  h30" id="ajax_pwd2" name="pwd2" value="" autocomplete="off"> <span id="ajax_pwd2_res"></td>
     </tr>
    <tr><td colspan="2">
	

		<p><input type="submit" class="btn btn-success" value="����"></p>
			
	
    </td>
    </tr>
    </table>
    </form>
	</div>
			
		 
							
		</div>
<?php echo $this->fetch('lib/footer.html'); ?>



