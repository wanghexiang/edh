<?php echo $this->fetch('lib/header.html'); ?>
 
<?php echo $this->fetch('searchnav.html'); ?>
 
<div class="row">
<div class="span9">
  <table class="table table-bordered  table-condensed  "  >
 
  <?php $_from = $this->_var['cailist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai');if (count($_from)):
    foreach ($_from AS $this->_var['cai']):
?>
   
  <tr>
    <td height="25" bgcolor="#FFFFFF"> 
    <!--�̵���Ϣ-->
                    <div id="shopinfo<?php echo $this->_var['cai']['shopid']; ?>" style="display:none;">
                <div class="meta vcard"><span class="name"><?php echo $this->_var['cai']['shopname']; ?></span><span class="tel">(<?php echo $this->_var['cai']['phone']; ?>)</span></div>
                </div>
                <a href="index.php?m=cai&id=<?php echo $this->_var['cai']['id']; ?>" target="_blank"><?php echo $this->_var['cai']['title']; ?></a></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['cai']['price']; ?>Ԫ</td>
    <td bgcolor="#FFFFFF"><a href="index.php?m=shop&shopid=<?php echo $this->_var['cai']['shopid']; ?>" target="_blank"><?php echo $this->_var['cai']['shopname']; ?></a></td>
    <td align="center" bgcolor="#FFFFFF">
    
     <a href="javascript:;" class="addCart" shopid='<?php echo $this->_var['cai']['shopid']; ?>' caiid='<?php echo $this->_var['cai']['id']; ?>' cart_count="0" name="<?php echo $this->_var['cai']['title']; ?>" price="<?php echo $this->_var['cai']['price']; ?>"><?php if ($this->_var['cai']['in_cart']): ?>�ѹ���<?php else: ?>����<?php endif; ?></a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="30" colspan="2" align="center" bgcolor="#FFFFFF"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>
</table>

</div>
<div class="span3">
<?php echo $this->fetch('lib/shopcar.html'); ?>
<div>
 <h3>���ǲ�̫�����߶��ͣ�</h3>
 <p>���ģ���Ķ��������̵õ��������Ȼ���ʵʱ�������㡣�ܶ����Ѿ�������ˣ���Ҳ��һ�ΰɡ�</p>
 </div>
 <form   action="index.php?m=guest&a=add_db" method="post">
								 
					<textarea id="ask_answer_content"  class="input-xlarge"  style=" width:100%;height:100px;" name="content"></textarea>
				 
					<input   type="submit" value="���ˣ��ύ" class="btn">
				 
			</form>
 
 
 <?php $_from = $this->_var['guestlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'guest');if (count($_from)):
    foreach ($_from AS $this->_var['guest']):
?>
 <table class="table table-bordered  table-condensed   ">
 <tr>
        <td><strong><?php echo $this->_var['guest']['username']; ?></strong> �� <?php echo $this->_var['guest']['content']; ?> </td>  </tr>
 <tr>
            
             
           <td> �ڸ����� <?php echo $this->_var['guest']['reply']; ?> </td>
</tr>
        
 </table>      	
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 

</div>
</div>


<?php echo $this->fetch('lib/footer.html'); ?>