<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">

<div class="span8">

<div class="breadcrumb">>>��ʳ����</div>
<table class="table table-bordered">
  <tr>
    <td class="span4" rowspan="6"><img src="<?php if ($this->_var['cai']['img']): ?><?php echo $this->_var['cai']['img']; ?><?php else: ?>images/nologo.gif<?php endif; ?>"  style="width:100%"></td>
    <td  class="span5">������<?php echo $this->_var['cai']['title']; ?></td>
    </tr>
  <tr>
    <td>���ࣺ<?php echo $this->_var['cai']['cname']; ?></td>
    </tr>
  <tr>
    <td>������<?php echo $this->_var['cai']['dname']; ?></td>
    </tr>
  <tr>
    <td>��ζ��<?php echo $this->_var['cai']['wname']; ?></td>
  </tr>
  <tr>
    <td>�۸�<?php echo $this->_var['cai']['price']; ?> <?php if ($this->_var['cai']['shopping']): ?><a  href="javascript:;" class="addCart btn btn-mini"  caiid="<?php echo $this->_var['cai']['id']; ?>"><i class="icon-shopping-cart"></i>����</a><?php endif; ?></td>
  </tr>
  <tr>
    <td>��ע�����(<?php echo $this->_var['cai']['click']; ?>) &nbsp;<a href="index.php?m=cai&a=delicious&caiid=<?php echo $this->_var['cai']['id']; ?>">�ó�</a>(<?php echo $this->_var['cai']['delicious']; ?>) &nbsp;
<a href="index.php?m=cai&a=undelicious&caiid=<?php echo $this->_var['cai']['id']; ?>">�ѳ�</a>(<?php echo $this->_var['cai']['undelicious']; ?>) 
<?php if ($this->_var['cai']['isfav']): ?>
<a href="javascript:;" class="delcaifav btn btn-mini" caiid="<?php echo $this->_var['cai']['id']; ?>"  >ȡ���ղ�</a>(<?php echo $this->_var['cai']['favs']; ?>)
<?php else: ?>
<a href="javascript:;" class="addcaifav btn btn-mini" caiid="<?php echo $this->_var['cai']['id']; ?>"  >�ղ�</a>(<?php echo $this->_var['cai']['favs']; ?>)
<?php endif; ?>
</td>
  </tr>
</table>

<div class="well"><?php echo $this->_var['cai']['content']; ?></div>
</div>




<div class="span4">
 <?php echo $this->fetch('lib/shopcar.html'); ?>
 <h3>����������Ϣ</h3>
 <table  class="table table-bordered table-striped table-condensed"  >
<tr>
<td >��������</td>
<td><a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>"><?php echo $this->_var['shop']['shopname']; ?></a></td>
</tr>
<tr  >
  <td class="span4">����ʱ��</td>
  <td class="span8"><?php echo $this->_var['shopconfig']['starthour']; ?>:<?php echo $this->_var['shopconfig']['startminute']; ?>-<?php echo $this->_var['shopconfig']['endhour']; ?>:<?php echo $this->_var['shopconfig']['endminute']; ?></td>
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
 <h2>���ǲ�̫�����߶��ͣ�</h2>
 <p>���ģ���Ķ��������̵õ��������Ȼ���ʵʱ�������㡣�ܶ����Ѿ�������ˣ���Ҳ��һ�ΰɡ�</p>
 </div>
 <?php if ($this->_var['shop']['lat']): ?>
<h2>������ͼ</h2>
 <div id="map_canvas" ><iframe style="width:100%; border:0; height:320px;" src="index.php?m=map&shopid=<?php echo $this->_var['shop']['shopid']; ?>"></iframe></div>
 <?php endif; ?>
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
<!--����-->


</div>
<?php echo $this->fetch('lib/footer.html'); ?>