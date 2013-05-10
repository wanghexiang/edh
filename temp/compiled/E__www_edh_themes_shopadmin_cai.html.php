<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="shopadmin.php?m=cai&">美食管理</a> <a href="shopadmin.php?m=cai&a=add">美食添加</a> </div>
<div class="nav_title">美食管理 <a href="shopadmin.php?m=cai&a=tocsv">导出美食</a></div>
<div class="rbox">
<form action="admin.php" method="get">
<input type="hidden" name="m" value="cai" />
<table class="tb1">


  <tr>
    <td width="63%" height="30"  align="center">菜名：
      <input name="title" type="text" id="title" size="40" value="<?php echo $_GET['title']; ?>" /> 
      <select name="isding" id="isding">
        <option value="-1" selected="selected">推荐</option>
        <option value="1"<?php if ($_GET['isding'] == 1): ?> selected="selected"<?php endif; ?>>是</option>
        <option value="0" <?php if ($_GET['isding'] == 0): ?> selected="selected"<?php endif; ?>>否</option>
      </select>
      <select name="ishot" id="ishot">
        <option value="-1" selected="selected">热门</option>
        <option value="1" <?php if ($_GET['ishot'] == 1): ?> selected="selected"<?php endif; ?>>是</option>
        <option value="0" <?php if ($_GET['ishot'] == 0): ?> selected="selected"<?php endif; ?>>否</option>
      </select>
      <select name="isnew" id="isnew">
        <option value="-1" selected="selected">最新</option>
        <option value="1" <?php if ($_GET['isnew'] == 1): ?> selected="selected"<?php endif; ?>>是</option>
        <option value="0" <?php if ($_GET['isnew'] == 0): ?> selected="selected"<?php endif; ?>>否</option>
      </select>
      <select name="visible" id="visible">
        <option value="-1" selected="selected">上架</option>
        <option value="1" <?php if ($_GET['visible'] == 1): ?> selected="selected"<?php endif; ?>>是</option>
        <option value="0" <?php if ($_GET['visible'] == 0): ?> selected="selected"<?php endif; ?>>否</option>
      </select>
      <select name="oos" id="oos">
        <option value="-1" selected="selected">缺货</option>
        <option value="1" <?php if ($_GET['oos'] == 1): ?> selected="selected"<?php endif; ?>>是</option>
        <option value="0" <?php if ($_GET['oos'] == 0): ?> selected="selected"<?php endif; ?>>否</option>
      </select>
      <select name="promote" id="promote">
        <option value="-1" selected="selected">促销</option>
        <option value="1" <?php if ($_GET['promote'] == 1): ?> selected="selected"<?php endif; ?>>是</option>
        <option value="0" <?php if ($_GET['promote'] == 0): ?> selected="selected"<?php endif; ?>>否</option>
      </select></td>
    <td width="37%">&nbsp; <input type="submit" name="button" id="button" value="搜索"  class="btn" /></td>
  </tr>
 
  </table>
   </form>
<table width="100%" border="0" cellpadding="1" cellspacing="0" class="tb1">
  <tr>
    <td align="center" height="30">
    <a href="shopadmin.php?m=cai&">全部</a>
    <a href="shopadmin.php?m=cai&week1=1">周一</a> 
    <a href="shopadmin.php?m=cai&week2=1">周二</a> 
    <a href="shopadmin.php?m=cai&week3=1">周三</a> 
    <a href="shopadmin.php?m=cai&week4=1">周四</a> 
    <a href="shopadmin.php?m=cai&week5=1">周五</a> 
    <a href="shopadmin.php?m=cai&week6=1">周六</a> 
    <a href="shopadmin.php?m=cai&week7=1">周七</a>
    </td>
  </tr>
  </table>

<table width="100%" border="0"  cellpadisding="0" cellspacing="0" class="tb1">
  <tr>
    <td width="49" height="25" align="center">ID</td>
    <td width="142" height="25" align="center">菜名</td>
    <td width="72" align="center">价格</td>
    <td width="79" height="25" align="center">所属分类</td>
    <td width="77" height="25" align="center">推荐</td>
    <td width="70" align="center">热门</td>
    <td width="70" align="center">最新</td>
    <td width="84" align="center">上架</td>
    <td width="41" align="center">促销</td>
    <td width="41" align="center">缺货</td>
    <td width="384" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['cailist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="20" align="center"><?php echo $this->_var['t']['id']; ?></td>
    <td><?php echo $this->_var['t']['title']; ?></td>
    <td align="center">￥<?php echo $this->_var['t']['price']; ?></td>
    <td align="center"><?php echo $this->_var['t']['cname']; ?></td>
    <td width="77" align="center">
    <?php if ($this->_var['t']['isding']): ?>
    <img src='images/yes.gif' class="ajax_no" url="shopadmin.php?m=cai&a=isding&t=0&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=isding&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" url="shopadmin.php?m=cai&a=isding&t=1&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=isding&t=0&id=<?php echo $this->_var['t']['id']; ?>">
    <?php endif; ?>
    </td>
    <td width="70" align="center">
    <?php if ($this->_var['t']['ishot']): ?>
    <img src='images/yes.gif' class="ajax_no" url="shopadmin.php?m=cai&a=ishot&t=0&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=ishot&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" rurl="shopadmin.php?m=cai&a=ishot&t=0&id=<?php echo $this->_var['t']['id']; ?>" url="shopadmin.php?m=cai&a=ishot&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php endif; ?>
    </td>
    <td width="70" align="center">
    <?php if ($this->_var['t']['isnew']): ?>
    <img src='images/yes.gif' class="ajax_no" url="shopadmin.php?m=cai&a=isnew&t=0&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=isnew&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" rurl="shopadmin.php?m=cai&a=isnew&t=0&id=<?php echo $this->_var['t']['id']; ?>" url="shopadmin.php?m=cai&a=isnew&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php endif; ?>
    </td>
    <td align="center">
    <?php if ($this->_var['t']['visible']): ?>
    <img src='images/yes.gif' class="ajax_no" url="shopadmin.php?m=cai&a=visible&visible=0&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=visible&visible=1&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" rurl="shopadmin.php?m=cai&a=visible&visible=0&id=<?php echo $this->_var['t']['id']; ?>" url="shopadmin.php?m=cai&a=visible&visible=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php endif; ?>
    </td>
    <td align="center">
      <?php if ($this->_var['t']['promote']): ?>
    <img src='images/yes.gif' class="ajax_no" url="shopadmin.php?m=cai&a=promote&t=0&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=promote&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" rurl="shopadmin.php?m=cai&a=promote&t=0&id=<?php echo $this->_var['t']['id']; ?>" url="shopadmin.php?m=cai&a=promote&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php endif; ?>
    </td>
    <td align="center">
      <?php if ($this->_var['t']['oos']): ?>
    <img src='images/yes.gif' class="ajax_no" url="shopadmin.php?m=cai&a=oos&t=0&id=<?php echo $this->_var['t']['id']; ?>" rurl="shopadmin.php?m=cai&a=oos&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" rurl="shopadmin.php?m=cai&a=oos&t=0&id=<?php echo $this->_var['t']['id']; ?>" url="shopadmin.php?m=cai&a=oos&t=1&id=<?php echo $this->_var['t']['id']; ?>">
    <?php endif; ?>
    </td>
    <td align="center"><a href="index.php?m=cai&id=<?php echo $this->_var['t']['id']; ?>" target="_blank">查看</a> 
      <a href="shopadmin.php?m=cai_comment&pid=<?php echo $this->_var['t']['id']; ?>">评论</a>
      <a href="shopadmin.php?m=cai&a=add&amp;id=<?php echo $this->_var['t']['id']; ?>">编辑</a> 
      <a href="shopadmin.php?m=cai&a=del&amp;id=<?php echo $this->_var['t']['id']; ?>">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="25" colspan="11" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
<?php endif; ?>
</table>

</div> <?php echo $this->fetch('lib/foot.lbi'); ?>
