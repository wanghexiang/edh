<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<script language="javascript" src="plugin/raty/js/jquery.raty.min.js" ></script>
<div class="row">

<div class="span8">

<?php if ($this->_var['list']): ?>

<script>



function pingfen(objstar,jf)
{
	$(objstar).raty(
	{
		 width :'100px',
		 hints : [1,2,3,4,5],
		 readOnly:true,
		 score : jf,
		 number : 5 ,
		 path	:'plugin/raty/img/'
	}
	);
}


</script> 
<pre>���������ǻ��ڹ����û����ڸõ�����ۣ�ÿ������ֻ������һ�Σ�������Ȩɾ����</pre>
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>

<table class="table table-bordered">
<tr>
<td  >�����ߣ�<?php if ($this->_var['g']['nickname']): ?><?php echo $this->_var['g']['nickname']; ?><?php else: ?>�ο�<?php endif; ?></td>
<td> ����ʱ��:<?php echo date("Y-m-d",$this->_var['g']['dateline']); ?></td>
</tr>
<tr>
<td>����<span id="star_fuwu_<?php echo $this->_var['g']['id']; ?>"></span></td>
<td>��ζ��<span id="star_kouwei_<?php echo $this->_var['g']['id']; ?>"></span></td>
</tr>
<tr>
<td>�۸�<span id="star_jiage_<?php echo $this->_var['g']['id']; ?>"></span></td>
<td>����ʱ�䣺<span id="star_shijian_<?php echo $this->_var['g']['id']; ?>"></span></td>
</tr>
<tr><td colspan="2">�������ۣ�<span id="start_all_<?php echo $this->_var['g']['id']; ?>"></span></td></tr>

<tr>
<td colspan="2">���ݣ�<?php echo $this->_var['g']['content']; ?></td>
</tr>

<?php if ($this->_var['g']['reply']): ?>
<tr>
<td colspan="2">
�ظ���<?php echo $this->_var['g']['reply']; ?>
</td>
</tr>
<?php endif; ?>
</table>
<script>
pingfen("#star_fuwu_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_fuwu']; ?>);
pingfen("#star_kouwei_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_kouwei']; ?>);
pingfen("#star_jiage_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_jiage']; ?>);
pingfen("#star_shijian_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_shijian']; ?>);
pingfen("#star_all_<?php echo $this->_var['g']['id']; ?>",<?php echo $this->_var['g']['jf_all']; ?>);
</script>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php if ($this->_var['pagelist']): ?><?php echo $this->_var['pagelist']; ?><?php endif; ?>
<?php else: ?>
<h2>��������</h2>
<?php endif; ?>


</div>
<!--��߽���-->
<div class="span4">
<?php echo $this->fetch('shop_right.html'); ?>

 </div>
 <!--�Ҳ����-->
</div>
<?php echo $this->fetch('lib/footer.html'); ?>