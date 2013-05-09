<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
	<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
	<div class="span10">
    <?php echo $this->fetch('usernav.html'); ?>												
	<p><h2>常用地址</h2></p>
    <?php $_from = $this->_var['addresslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');if (count($_from)):
    foreach ($_from AS $this->_var['address']):
?>
					
				 
					<form class="address_edit action" action="index.php?m=user&a=myaddress&op=post" method="post">
						 
							<input type="hidden" name="id" value="<?php echo $this->_var['address']['id']; ?>">
							<textarea class="text address_text"  style="width:400px;"  name="address"><?php echo $this->_var['address']['address']; ?></textarea>
							<input type="submit" value="保存" class="btn btn-primary" id="edit_this_address"  >
                            <input type="button" onClick="location.href='index.php?m=user&a=myaddress&op=del&id=<?php echo $this->_var['address']['id']; ?>'" class="btn btn-danger " value="删除">
						 
					</form>
					
						
			
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			
			<form action="index.php?m=user&a=myaddress&op=post" method="post">
				<label for="new_address_text">添加地址</label>
                <textarea id="new_address_text" style="width:400px;" name="address"></textarea>
				<input type="submit" value="保存" class="btn btn-primary">
			</form>
		</div>
			
		 
							
		</div>
<?php echo $this->fetch('lib/footer.html'); ?>
