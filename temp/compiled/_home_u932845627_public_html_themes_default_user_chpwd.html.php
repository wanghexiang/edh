<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
	<div class="span2">
    	<?php echo $this->fetch('usernavleft.html'); ?>
    </div>
	<div class="span10">
    <?php echo $this->fetch('usernav.html'); ?>
    <form class="account_form " action="index.php?m=user&a=chpwd_db" method="post">												 
 	<table class="table table-bordered">
    <tr><td colspan="2"><h2>账号密码修改</h2></td></tr>
    <tr>
    	<td>Email</td>
        <td>
      		  <?php if ($this->_var['user']['email']): ?>
					<input disabled="disabled" type="text" class="h30" id="email" name="email" value="<?php echo $this->_var['user']['email']; ?>"><?php else: ?>
                    <input   type="text" class="text disabled" id="email" name="email" value=""> 填写后不可修改
                 <?php endif; ?>
        </td>
     </tr>
     
     <tr>
     	<td>用户名</td>
        <td><input type="text" disabled="disabled" class="h30" id="username" name="username" value="<?php echo $this->_var['user']['username']; ?>"></td>
     </tr>
     <tr>
     	<td>新密码</td>
        <td><input type="password" class="h30" id="ajax_pwd1" name="pwd1" value="" autocomplete="off"> <span id="ajax_pwd1_res"></span>
					<div class="hint">如果不想修改密码，请保持空白</div></td>
     
     </tr>
     
     <tr>
     	<td>重复密码</td>
        <td><input type="password" class="  h30" id="ajax_pwd2" name="pwd2" value="" autocomplete="off"> <span id="ajax_pwd2_res"></td>
     </tr>
    <tr><td colspan="2">
	

		<p><input type="submit" class="btn btn-success" value="保存"></p>
			
	
    </td>
    </tr>
    </table>
    </form>
	</div>
			
		 
							
		</div>
<?php echo $this->fetch('lib/footer.html'); ?>



