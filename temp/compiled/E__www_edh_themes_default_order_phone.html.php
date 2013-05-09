<?php echo $this->fetch('lib/header.html'); ?>

<style>

/*图片弹出框*/
#showBox{padding:6px; display:none; width:600px; min-height:100px;  position:absolute; background-color:#FFF; z-index:1111; border:1px solid #CCC;}
#showBox_nav{line-height:25px; height:25px; background-color:#F0F0F0; padding:0px 4px;} 
#showBox_title{float:left;}
#showBox_close{float:right; cursor:pointer; height:25px; line-height:25px; padding:0 5px;}
#showBox_close:hover{background-color:#808000;}
#showBox_content{display:block;}
#showBox_footer{height:25px; line-height:25px;}

.border{border-radius: 5px; border:1px solid #ccc;}
.linearcolor{
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(top, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e6e6e6', GradientType=0);
}
td img{max-width:100%;}
.odd {background-color:#ffffff;} 
.even,.even td {background-color:#F7F8FC;}

.pointer{cursor:pointer;}
.h30{height:30px;}
.uneditable-input {
  margin-left: 0;
}
input.span12, textarea.span12, .uneditable-input.span12 {
  width: 930px;
}
input.span11, textarea.span11, .uneditable-input.span11 {
  width: 850px;
}
input.span10, textarea.span10, .uneditable-input.span10 {
  width: 770px;
}
input.span9, textarea.span9, .uneditable-input.span9 {
  width: 690px;
}
input.span8, textarea.span8, .uneditable-input.span8 {
  width: 610px;
}
input.span7, textarea.span7, .uneditable-input.span7 {
  width: 530px;
}
input.span6, textarea.span6, .uneditable-input.span6 {
  width: 450px;
}
input.span5, textarea.span5, .uneditable-input.span5 {
  width: 370px;
}
input.span4, textarea.span4, .uneditable-input.span4 {
  width: 290px;
}
input.span3, textarea.span3, .uneditable-input.span3 {
  width: 210px;
}
input.span2, textarea.span2, .uneditable-input.span2 {
  width: 130px;
}
input.span1, textarea.span1, .uneditable-input.span1 {
  width: 50px;
}
input[disabled],
select[disabled],
textarea[disabled],
input[readonly],
select[readonly],
textarea[readonly] {
  background-color: #eeeeee;
  border-color: #ddd;
  cursor: not-allowed;
}
#addresscontent{
 display: inline-block;
  width: 210px;
  height: 18px;
  padding: 4px;
  margin-bottom: 9px;
  font-size: 13px;
  line-height: 18px;
  color: #555555;
  border: 1px solid #cccccc;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.well {
  min-height: 20px;
  padding: 19px;
  margin-bottom: 20px;
  background-color: #f5f5f5;
  border: 1px solid #eee;
  border: 1px solid rgba(0, 0, 0, 0.05);
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
}
.well blockquote {
  border-color: #ddd;
  border-color: rgba(0, 0, 0, 0.15);
}
.well-large {
  padding: 24px;
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
}
.well-small {
  padding: 9px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
body{margin:auto 0px; padding:auto 0px ;text-algin:center;}
</style>
<body>
<div class="row">
<div class="span8" style="margin: 0px auto; padding:0px auto;" >
		<ul class="breadcrumb" >
  <li >
    <a href="javascript:;">创建订单</a> <span class="divider">></span>
  </li>
  <li>
    <a href="#">确定联系方式</a> <span class="divider">></span>
  </li>
  <li >完成</li>
</ul>
        										 
		
	<!--订单信息开始-->
 <?php $_from = $this->_var['orderlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
			<form class="well" action="index.php?m=shopcar&a=orderphone_db" method="post">
				<h2><a href="index.php?m=shop&shopid=<?php echo $this->_var['order']['shopid']; ?>" target="_blank"><?php echo $this->_var['order']['shopname']; ?></a> <small><?php echo $this->_var['order']['phone']; ?></small></h2>
				<div class="row-fluid">
                <div class="span6">
                <h3>您的餐饮：<?php echo $this->_var['order']['money']; ?>元 (送餐费用<?php echo $this->_var['order']['config']['sendprice']; ?>元)</h3>
				 <div class="row-fluid">
                <div class="span4"><strong>菜品名称</strong> </div>
                
				<div class="span4"><strong>数量</strong></div>
                <div class="span4"><strong>单价(元)</strong></div>
				</div>
                 <?php $_from = $this->_var['order']['cailist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai');if (count($_from)):
    foreach ($_from AS $this->_var['cai']):
?>
                <div class="row-fluid">
                <div class="span4"><?php echo $this->_var['cai']['title']; ?> </div>
                
				<div class="span4"><?php echo $this->_var['cai']['cainum']; ?></div>
                <div class="span4"><?php echo $this->_var['cai']['price']; ?></div>
				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				
                </div>
                <!--左边结束-->
                <div class="span6">
                <label>您的手机：</label>
				<?php if ($this->_var['order']['sendtype'] == 0): ?>                                               
                <input type="hidden" value="<?php echo $this->_var['order']['id']; ?>" name="orderid">
				<input type="text" name="orderphone" class="text mobile_number" id="mobile_number" value="<?php echo $this->_var['order']['orderphone']; ?>">
                <?php else: ?><?php echo $this->_var['order']['orderphone']; ?><?php endif; ?>
				<p>稍后我们会发一条短信给您</p>
                <?php if ($this->_var['order']['money'] < $this->_var['balance']): ?>
                <p>支付方式：<?php if ($this->_var['order']['ispay']): ?>已经付款<?php else: ?><input type="checkbox" name="ispay" value="1" /> 余额支付 <br />(默认货到付款，可不选)<?php endif; ?></p>
                <?php endif; ?>
				<label>详细地址：</label>
					<?php if ($this->_var['order']['sendtype'] == 0): ?>
					<?php $_from = $this->_var['addresslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');if (count($_from)):
    foreach ($_from AS $this->_var['address']):
?>
					<p>
                    
                    <input type="radio" name="orderaddress" <?php if ($this->_var['address']['address'] == $this->_var['order']['orderaddress']): ?> checked="checked"<?php endif; ?>  id="address_old_<?php echo $this->_var['address']['id']; ?>" value="<?php echo $this->_var['address']['address']; ?>" > <?php echo $this->_var['address']['address']; ?>  
					</p>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                   <p>(<a href="javascript:;"   class="ajax_addaddress"><span style="color:#03F;">添加新地址</span></a>)
                   </p>
																						
                            <?php else: ?>
                                         <p><?php echo $this->_var['order']['orderaddress']; ?></p>
							 <?php endif; ?>														
									
											<label>餐饮要求：</label>
										
												<?php if ($this->_var['order']['sendtype'] == 0): ?><textarea name="orderinfo" style="width:300px; height:60px;"><?php echo $this->_var['order']['orderinfo']; ?></textarea>
                                                <?php else: ?>
                                                <?php echo $this->_var['order']['orderinfo']; ?>
                                                <?php endif; ?>
											<p> 如果菜品有大份/小份选择，请在这里注明。<br>添加上您的姓氏和称谓会更便于餐厅联系。</p>
                                            
																								
																																						<p><?php if ($this->_var['order']['sendtype'] == 0): ?><input class="btn btn-success" type="submit" value="确认信息，提交">
<input onclick="window.location='index.php?m=shopcar&a=delorder&id=<?php echo $this->_var['order']['id']; ?>&url=orderphone'; return confirm('删除后不可恢复,确认删除?');"  class="btn btn-danger" type="reset" value="删除"><?php else: ?>订单已确定，如要修改请联系客服
<?php endif; ?></p>
											</div>
											
											
											</div></form>
<?php if ($this->_var['order']['sendtype'] == 3): ?>
<script language="javascript" src="plugin/raty/js/jquery.raty.min.js" ></script>


       
      
<div class="well">
<form method="post" class="form-horizontal" action="index.php?m=shopcar&a=ordercomment">
<h2>对店铺评论</h2>
<table class="table">
<tr><td width="60">服务:</td><td><span id="star_fuwu" style="width:200px;"></span><input type="hidden" id="jf_fuwu" name="jf_fuwu" value="<?php echo $this->_var['order']['comment']['jf_fuwu']; ?>" /></td></tr>
<tr><td>口味:</td><td><span id="star_kouwei" style="width:200px;"></span><input type="hidden" id="jf_kouwei" name="jf_kouwei" value="<?php echo $this->_var['order']['comment']['jf_kouwei']; ?>" /></td></tr>
<tr><td>价格:</td><td><span id="star_jiage" style="width:200px;"></span><input type="hidden" id="jf_jiage" name="jf_jiage" value="<?php echo $this->_var['order']['comment']['jf_jiage']; ?>" /></td></tr>
<tr><td>配送时间:</td><td><span id="star_shijian" style="width:200px;"></span><input type="hidden" id="jf_shijian" name="jf_shijian" value="<?php echo $this->_var['order']['comment']['jf_shijian']; ?>" /></td></tr>
<tr><td>总评：</td><td><span id="star_all" style="width:200px;"></span><input type="hidden" id="jf_all" name="jf_all" value="<?php echo $this->_var['order']['comment']['jf_all']; ?>" /></td></tr>

</table>
<input type="hidden" name="orderid" value="<?php echo $this->_var['order']['id']; ?>" />
<p><textarea name="content" style="width:400px;"><?php echo $this->_var['order']['comment']['content']; ?></textarea></p>
<p><input type="submit" value="订单评价" class="btn-primary" /></p>
</form>
</div>

<script>

pingfen("#star_fuwu","#jf_fuwu"<?php if ($this->_var['order']['comment']['jf_fuwu']): ?>,<?php echo $this->_var['order']['comment']['jf_fuwu']; ?><?php endif; ?>);
pingfen("#star_kouwei","#jf_kouwei"<?php if ($this->_var['order']['comment']['jf_kouwei']): ?>,<?php echo $this->_var['order']['comment']['jf_kouwei']; ?><?php endif; ?>);
pingfen("#star_jiage","#jf_jiage"<?php if ($this->_var['order']['comment']['jf_jiage']): ?>,<?php echo $this->_var['order']['comment']['jf_jiage']; ?><?php endif; ?>);
pingfen("#star_shijian","#jf_shijian"<?php if ($this->_var['order']['comment']['jf_shijian']): ?>,<?php echo $this->_var['order']['comment']['jf_shijian']; ?><?php endif; ?>);
pingfen("#star_all","#jf_all"<?php if ($this->_var['order']['comment']['jf_all']): ?>,<?php echo $this->_var['order']['comment']['jf_all']; ?><?php endif; ?>);

function pingfen(objstar,objval,jf)
{
	jf=jf?jf:0;
	$(objstar).raty(
	{
		 width :'200px',
		 hints : [1,2,3,4,5],
		 score : jf,
		 number : 5 ,
		 path	:'plugin/raty/img/',
		 click : function(score, evt)
		 {
			 $(objval).val(score);
		 }
	}
	);
}


</script> 
 

<?php endif; ?>          
                <!--右边结束-->
                
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<!--订单信息结束-->
</div>			
					
			
									 
						
		
</div>

	
	<div id="showBox" style="display: none; position: fixed; left: 50%; top: 50%; z-index: 99; margin-left: -307px; margin-top: -68.5px;">

<div id="showBox_nav">

<div id="showBox_title">  </div>

<div id="showBox_close">关闭</div>

</div>

<div id="showBox_content"><div class="breadcrumb">地址：<input type="text" class="h30" id="addresscontent"> <input type="button" id="addresscontent_submit" class="btn btn-success" value="添加"> <input type="button" id="addresscontent_clear" class="btn btn-delete" value="取消"></div></div>

<div id="showBox_footer"></div>

</div>
	
<?php echo $this->fetch('lib/footer.html'); ?>
</body>
</html>
<script type='text/javascript'>
function send(){
	document.getElementById("form1").submit();
	}
</script>