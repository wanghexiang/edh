<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>��ҳ</title>
<link rel="stylesheet" type="text/css" href="image/gong.css"/>
<link rel="stylesheet" type="text/css" href="image/nei.css"/>
</head>
<body>
<?php echo $this->fetch('lib/header.html'); ?>
<script language="javascript">
function movenew()
{
	document.location='<?php echo $this->_var['url']; ?>';
}
setTimeout(movenew,2000);

</script>
<br/>
<br/>
<br/><br/>
<br/>
<br/><br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<center>
<div class="well" style="color:green">
<?php echo $this->_var['message']; ?>�����û���Զ���ת���� <a href="<?php echo $this->_var['url']; ?>">��ת</a>

</div>
</center>
<br/>
<br/>
<br/><br/>
<br/>
<br/><br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<?php echo $this->fetch('lib/footer.html'); ?>
</body>
</html>