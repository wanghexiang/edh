<?php echo $this->fetch('lib/header.html'); ?>
<div class="row" >
	<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
	<div class="span10">												 
   <p> <h2>������ʷ</h2></p>
            
            <p>
                ������������鿴������������ʷ������¼�� ȷ���ջ���������յ����ͺ��ȷ�ϣ�
            </p>
 
<table   class="table table-striped table-bordered table-condensed">
			<tbody>
            <tr class="even">
            	<th width="128" height="29" class="span2">������</th>
				<th width="195"  class="span2">ʱ��</th>
				<th width="136" class="span3">��������</th>
				<th width="112"  class="span1">�ܼ�</th>
				<th width="236"  class="span2">״̬</th>
                <th width="180" class="span2">�ջ�</th>
                <th width="60" class="span2">����</th>
			</tr>
            <?php $_from = $this->_var['orderlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
            <tr class="even">
            <th><a href="index.php?m=shopcar&a=orderphone&ids=<?php echo $this->_var['order']['id']; ?>" target="_blank"><?php echo $this->_var['order']['orderno']; ?></a></th>
            <th><?php echo date("m-d H:i",$this->_var['order']['dateline']); ?></th>
            <th><a href="index.php?m=shop&shopid=<?php echo $this->_var['order']['shopid']; ?>" target="_blank"><?php echo $this->_var['order']['shopname']; ?></a></th>
            <th><?php echo $this->_var['order']['money']; ?></th>
            <th><?php if ($this->_var['order']['sendtype'] == 0): ?>δ���<?php elseif ($this->_var['order']['sendtype'] == 1): ?>��ȷ��<?php elseif ($this->_var['order']['sendtype'] == 2): ?>��������<?php elseif ($this->_var['order']['sendtype'] == 3): ?>���<?php endif; ?> <?php if (! $this->_var['order']['isvalid']): ?>δ��Ч<?php endif; ?></th>
            <th>
            <?php if ($this->_var['order']['received']): ?>���ջ�<?php elseif ($this->_var['order']['sendtype'] > 0): ?><a href="javascript:;" onclick="$.get('index.php?m=shopcar&a=received&id=<?php echo $this->_var['order']['id']; ?>');$(this).text('���ջ�')">ȷ���ջ�</a><?php endif; ?>
            <?php if ($this->_var['order']['sendtype'] == 3): ?>
            <?php if (! $this->_var['order']['iscomment']): ?><a href="index.php?m=shopcar&a=orderphone&ids=<?php echo $this->_var['order']['id']; ?>" target="_blank">����</a><?php else: ?>������<?php endif; ?>
            <?php endif; ?>
            </th>
            <th><?php if ($this->_var['order']['ispay']): ?>������֧��<?php else: ?>����<?php endif; ?></th>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            
					</tbody></table>
    <div ><?php echo $this->_var['pagelist']; ?></div>
	</div>
	</div>				
		<?php echo $this->fetch('lib/footer.html'); ?>
		
</body>
</html>

