<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">

<div class="span8">

<div class="breadcrumb">>>美食详情</div>
<table class="table table-bordered">
  <tr>
    <td class="span4" rowspan="6"><img src="<?php if ($this->_var['cai']['img']): ?><?php echo $this->_var['cai']['img']; ?><?php else: ?>images/nologo.gif<?php endif; ?>"  style="width:100%"></td>
    <td  class="span5">菜名：<?php echo $this->_var['cai']['title']; ?></td>
    </tr>
  <tr>
    <td>分类：<?php echo $this->_var['cai']['cname']; ?></td>
    </tr>
  <tr>
    <td>做法：<?php echo $this->_var['cai']['dname']; ?></td>
    </tr>
  <tr>
    <td>口味：<?php echo $this->_var['cai']['wname']; ?></td>
  </tr>
  <tr>
    <td>价格：<?php echo $this->_var['cai']['price']; ?> <?php if ($this->_var['cai']['shopping']): ?><a  href="javascript:;" class="addCart btn btn-mini"  caiid="<?php echo $this->_var['cai']['id']; ?>"><i class="icon-shopping-cart"></i>购买</a><?php endif; ?></td>
  </tr>
  <tr>
    <td>关注：浏览(<?php echo $this->_var['cai']['click']; ?>) &nbsp;<a href="index.php?m=cai&a=delicious&caiid=<?php echo $this->_var['cai']['id']; ?>">好吃</a>(<?php echo $this->_var['cai']['delicious']; ?>) &nbsp;
<a href="index.php?m=cai&a=undelicious&caiid=<?php echo $this->_var['cai']['id']; ?>">难吃</a>(<?php echo $this->_var['cai']['undelicious']; ?>) 
<?php if ($this->_var['cai']['isfav']): ?>
<a href="javascript:;" class="delcaifav btn btn-mini" caiid="<?php echo $this->_var['cai']['id']; ?>"  >取消收藏</a>(<?php echo $this->_var['cai']['favs']; ?>)
<?php else: ?>
<a href="javascript:;" class="addcaifav btn btn-mini" caiid="<?php echo $this->_var['cai']['id']; ?>"  >收藏</a>(<?php echo $this->_var['cai']['favs']; ?>)
<?php endif; ?>
</td>
  </tr>
</table>

<div class="well"><?php echo $this->_var['cai']['content']; ?></div>
</div>




<div class="span4">
 <?php echo $this->fetch('lib/shopcar.html'); ?>
 <h3>餐厅基本信息</h3>
 <table  class="table table-bordered table-striped table-condensed"  >
<tr>
<td >餐厅名称</td>
<td><a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>"><?php echo $this->_var['shop']['shopname']; ?></a></td>
</tr>
<tr  >
  <td class="span4">外卖时间</td>
  <td class="span8"><?php echo $this->_var['shopconfig']['starthour']; ?>:<?php echo $this->_var['shopconfig']['startminute']; ?>-<?php echo $this->_var['shopconfig']['endhour']; ?>:<?php echo $this->_var['shopconfig']['endminute']; ?></td>
</tr>
<tr  >
  <td>送餐费用</td>
  <td><?php echo $this->_var['shopconfig']['sendprice']; ?>元</td>
</tr>
<tr >
  <td>起送金额</td>
  <td><?php echo $this->_var['shopconfig']['minprice']; ?>元</td>
</tr>

<tr  >
  <td>餐厅地址</td>
  <td><?php echo $this->_var['shop']['address']; ?></td>
</tr>

<tr  >
  <td>餐厅电话</td>
  <td><?php echo $this->_var['shop']['phone']; ?></td>
</tr>

<tr class="restaurant_info_item">
  <td>送餐范围</td>
  <td><?php echo $this->_var['shop']['sendarea']; ?></td>
</tr>
  <tr  >
  <td>还有……</td>
  <td>
      <?php echo $this->_var['shop']['info']; ?>
  </td>
</tr>
								
								
</table>   
 <div>
 <h2>还是不太敢在线订餐？</h2>
 <p>别担心，你的订单会立刻得到处理，进度还会实时反馈给你。很多人已经用上瘾了，你也试一次吧。</p>
 </div>
 <?php if ($this->_var['shop']['lat']): ?>
<h2>餐厅地图</h2>
 <div id="map_canvas" ><iframe style="width:100%; border:0; height:320px;" src="index.php?m=map&shopid=<?php echo $this->_var['shop']['shopid']; ?>"></iframe></div>
 <?php endif; ?>
 <?php $_from = $this->_var['guestlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'guest');if (count($_from)):
    foreach ($_from AS $this->_var['guest']):
?>
 <table class="table table-bordered  table-condensed   ">
 <tr>
        <td><strong><?php echo $this->_var['guest']['username']; ?></strong> ： <?php echo $this->_var['guest']['content']; ?> </td>  </tr>
 <tr>
            
             
           <td> 口福答疑 <?php echo $this->_var['guest']['reply']; ?> </td>
</tr>
        
 </table>      	
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<!--结束-->


</div>
<?php echo $this->fetch('lib/footer.html'); ?>