 <h3>����������Ϣ</h3>
 <table  class="table table-bordered table-striped table-condensed"  >
				<tr>
                    <td>��������</td>
                    <td><?php echo $this->_var['shop']['shopname']; ?></td>
                </tr>
				<tr  >
					<td  width="100">����ʱ��</td>
					<td class="span8"><?php echo $this->_var['shopconfig']['starthour']; ?>:<?php if (! $this->_var['shopconfig']['startminute']): ?>00<?php else: ?><?php echo $this->_var['shopconfig']['startminute']; ?><?php endif; ?>-<?php echo $this->_var['shopconfig']['endhour']; ?>:<?php if (! $this->_var['shopconfig']['endminute']): ?>00<?php else: ?><?php echo $this->_var['shopconfig']['endminute']; ?><?php endif; ?></td>
				</tr>
				<tr  >
					<td>�Ͳͷ���</td>
					<td><?php echo $this->_var['shopconfig']['sendprice']; ?>Ԫ</td>
				</tr>
				<tr >
					<td>���ͽ��</td>
					<td><?php echo $this->_var['shopconfig']['minprice']; ?>Ԫ</td>
				</tr>
                
                <tr  >
					<td>������ַ</td>
					<td><?php echo $this->_var['shop']['address']; ?></td>
				</tr>
                
                <tr  >
					<td>�����绰</td>
					<td><?php echo $this->_var['shop']['phone']; ?></td>
				</tr>
                
				<tr class="restaurant_info_item">
					<td>�Ͳͷ�Χ</td>
					<td><?php echo $this->_var['shop']['sendarea']; ?></td>
				</tr>
					<tr  >
					<td>���С���</td>
					<td>
						<?php echo $this->_var['shop']['info']; ?>
					</td>
				</tr>
								
								
			</table>   
 <div>
 <h2>��������</h2>
 </div>
 <form   action="index.php?m=guest&a=add_db" method="post">
					<input type="hidden" name="shopid" value="<?php echo $_GET['shopid']; ?>" />			 
					<textarea id="ask_answer_content"  class="input-xlarge"  style="height:100px;" name="content"></textarea>
				 
					<p><input   type="submit" value="���ˣ��ύ" class="btn btn-success"></p>
				 
			</form>

 
 <?php if ($this->_var['shop']['lat']): ?>
 
<h2>������ͼ</h2>
 <div id="map_canvas" ><iframe style="width:100%; border:0; height:320px;" src="index.php?m=map&shopid=<?php echo $this->_var['shop']['shopid']; ?>"></iframe></div>
 <?php endif; ?>
  <?php if ($this->_var['guestlist']): ?>
  <h2><?php echo $this->_var['shop']['shopname']; ?>����</h2>
 <?php $_from = $this->_var['guestlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'guest');if (count($_from)):
    foreach ($_from AS $this->_var['guest']):
?>
 <table class="table table-bordered  table-condensed   ">
 <tr>
        <td><strong><?php if ($this->_var['guest']['username']): ?><?php echo $this->_var['guest']['username']; ?><?php else: ?>�ο�<?php endif; ?>��</strong><?php echo $this->_var['guest']['content']; ?> </td>  </tr>
 <tr>
            
             
           <td><strong><?php echo $this->_var['shop']['shopname']; ?>��</strong><?php echo $this->_var['guest']['reply']; ?> </td>
</tr>
        
 </table>      	
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          
          <?php endif; ?>