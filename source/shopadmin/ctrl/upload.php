<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ļ��ϴ�</title>
<style type="text/css">
*{padding:0px; margin:0px; font-size:14px;}
.box{margin:0 auto; width:400px; height:200px; line-height:200px; background-color:#DCF7FC; display:block; padding-left:10px;}
#button{ padding:2px 4px;}
</style>
</head>

<body>
<div class="title" style="margin:0 auto; width:400px; height:30px; line-height:30px; background-color:#CCC;padding-left:10px; ">�ļ��ϴ�</div>
<div class="box">
<form action="shopadmin.php?m=upfile" method="post" enctype="multipart/form-data">
 <input type="hidden" name="formname" id="formname" value="<?php echo $_REQUEST['formname'];?>"/>
<input type="hidden" name="editname" id="editname" value="<?php echo $_REQUEST['editname'];?> " />
    <input type="hidden" name="f_type" id="f_type"  value="<?php echo $_REQUEST['f_type']; ?>"/>
<input type="file" name="upfile" id="upfile"  />

 <input type="submit" name="button" id="button" value="�ϴ�" />
  
</form>
</div>
</body>
</html>