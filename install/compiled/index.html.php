<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ڸ��Ƽ�����ϵͳ��װ</title>
<style type="text/css">
*{margin:0; padding:0;}
.body{width:800px; margin:0 auto;}
.head{height:50px; width:800px; line-height:50px; background-color:#61E964; text-align:center; font-size:20px; font-weight:900;}
.title{height:30px; line-height:30px; padding:3px 6px; background-color:#693;}
.box{width:100%; padding:10px;}
table{background-color:#CCC;}
td{background-color:#FFF; padding:3px 4px;}

</style>
</head>

<body>
<div class="body">
<div class="head">�ڸ��Ƽ�����ϵͳ</div>
<?php if ($this->_var['step'] == 1): ?>
<div class="title">����ִ�е�һ�������ݿ�����</div>
<div class="box">
<form action="index.php?m=index&step=2" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="21%" height="25" align="right">��������</td>
    <td width="79%"><input name="mysql_host" type="text" id="mysql_host" value="localhost" />
    ��mysql��������</td>
  </tr>
  <tr>
    <td height="25" align="right">�û�����</td>
    <td><input type="text" name="mysql_user" id="mysql_user" /></td>
  </tr>
  <tr>
    <td height="25" align="right">���룺</td>
    <td><input type="text" name="mysql_pwd" id="mysql_pwd" /></td>
  </tr>
  <tr>
    <td height="25" align="right">���ݿ⣺</td>
    <td><input type="text" name="mysql_db" id="mysql_db" /></td>
  </tr>
  <tr>
    <td height="25" align="right">��ǰ׺��</td>
    <td><input name="tblpre" type="text" id="tblpre" value="koufu_" /></td>
  </tr>
  <tr>
    <td height="25" align="right">��������</td>
    <td><input name="domain" type="text" id="domain" value="www" />
      (��ַ:www.koufukeji.com)</td>
  </tr>
  <tr>
    <td height="25" align="right">&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="��һ��" /></td>
  </tr>
  </table>


</form>

</div>
<?php elseif ($this->_var['step'] == 2): ?>
<div class="title">����ִ�еڶ�������װ�����ļ�</div>
<div class="box">
˵������װ���ݿ������ļ������ݿ������ļ���Ҫ�����������ݿ⣬�������ݿ⡣

</div>
<?php elseif ($this->_var['step'] == 3): ?>
<div class="title">����ִ�е���������װ���ݿ�</div>
<div class="box">
������վ����������ݿ�.....
</div>
<?php elseif ($this->_var['step'] == 4): ?>
<div class="title">����ִ�е��Ĳ�����ʼ������</div>
<div class="box">
<form action="index.php?m=index&step=5" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="22%" height="30" align="right">����Ա��</td>
    <td width="78%"><input type="text" name="adminname" id="adminname" /></td>
  </tr>
  <tr>
    <td height="30" align="right">���룺</td>
    <td><input type="password" name="pwd1" id="pwd1" /></td>
  </tr>
  <tr>
    <td height="30" align="right">�ظ����룺</td>
    <td><input type="password" name="pwd2" id="pwd2" /></td>
  </tr>
  <tr>
    <td height="30" align="right">&nbsp;</td>
    <td><input type="submit" name="button2" id="button2" value="ȷ��" /></td>
  </tr>
  </table>

</form>

</div>
<?php elseif ($this->_var['step'] == 5): ?>
<div class="title">վ�㰲װ���</div>
<div class="box"> <a href="../index.php">�鿴��ҳ</a> <a href="../admin.php">�������</a> </div>

<?php endif; ?>
</div>

</body>
</html>
