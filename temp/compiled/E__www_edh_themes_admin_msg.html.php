<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav_title">消息提示</div> 

<script language="javascript">
function movenew()
{
	document.location='<?php echo $this->_var['url']; ?>';
}
setTimeout(movenew,2000);

</script>
<div class="rbox">
<div style="padding:20px; line-height:30px;"> 
<?php echo $this->_var['message']; ?>,如果浏览器没有自动跳转，请点击<a href="<?php echo $this->_var['url']; ?>">跳转</a>！
</div>
</div>
 
<?php echo $this->fetch('lib/foot.lbi'); ?>
