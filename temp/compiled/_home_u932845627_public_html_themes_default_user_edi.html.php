<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
	
    <div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
    
	<div class="span10">												 
	<?php echo $this->fetch('usernav.html'); ?>

 <form class="form " action="index.php?m=user&a=edi_db" method="post">
 <table class="table table-bordered">
 	<tr>
    	<td colspan="2"><h2>联系信息</h2></td>
    </tr>
    
 	<tr>
    	<td>昵称</td>
        <td><input type="text" name="nickname" class="h30" value="<?php echo $this->_var['user']['nickname']; ?>" /></td>
    </tr>
    
     <tr>
    	<td>手机号码</td>
        <td><input type="text" class="h30" name="phone" id="mobile_number" value="<?php echo $this->_var['user']['phone']; ?>"></td>
    </tr>
    
     <tr>
    	<td>QQ</td>
        <td><input type="text" class="h30" name="qq" id="qq" value="<?php echo $this->_var['user']['qq']; ?>" /></td>
    </tr>
    
    <tr>
    	<td>信息</td>
        <td><textarea name="info" style="height:100px; width:400px;"><?php echo $this->_var['user']['info']; ?></textarea></td>
    </tr>
    
    <tr>
    	<td colspan="2"><input class="btn btn-large btn-success" type="submit" value="保存"></td>
    </tr>
 
 </table>

					 
	</form>
    
	</div>
			
		 			
		</div>
<?php echo $this->fetch('lib/footer.html'); ?>






