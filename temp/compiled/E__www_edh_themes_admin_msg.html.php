<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav_title">��Ϣ��ʾ</div> 

<script language="javascript">
function movenew()
{
	document.location='<?php echo $this->_var['url']; ?>';
}
setTimeout(movenew,2000);

</script>
<div class="rbox">
<div style="padding:20px; line-height:30px;"> 
<?php echo $this->_var['message']; ?>,��������û���Զ���ת������<a href="<?php echo $this->_var['url']; ?>">��ת</a>��
</div>
</div>
 
<?php echo $this->fetch('lib/foot.lbi'); ?>
