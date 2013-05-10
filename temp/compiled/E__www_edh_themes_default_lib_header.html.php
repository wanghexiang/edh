
<link rel="stylesheet" type="text/css" href="plugin/bootstrap/css/middle.css"/>
<link rel="stylesheet" type="text/css" href="image/head.css"/>
<script src="js/jquery.js" type="text/javascript"></script>
<script language="javascript" src="js/jquery.center.js"></script>
<script language="javascript" src="plugin/bootstrap/js/bootstrap-dropdown.js"></script>
 <script src="plugin/bootstrap/js/bootstrap-collapse.js"></script>
 <script src="plugin/bootstrap/js/bootstrap-carousel.js"></script>
<script language="javascript" src="js/common.js"></script>
<link href="<?php echo $this->_var['skins']; ?>mybootstrap.css" rel="stylesheet" type="text/css">
<title><?php if ($this->_var['seo']['title']): ?><?php echo $this->_var['seo']['title']; ?><?php else: ?><?php echo $this->_var['web']['webtitle']; ?><?php endif; ?></title>
<meta name="keywords" content="<?php if ($this->_var['seo']['keywords']): ?><?php echo $this->_var['seo']['keywords']; ?><?php else: ?><?php echo $this->_var['web']['webkey']; ?><?php endif; ?>" />
<meta name="description" content="<?php if ($this->_var['seo']['description']): ?><?php echo $this->_var['seo']['description']; ?><?php else: ?><?php echo $this->_var['web']['description']; ?><?php endif; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="qc:admins" content="326621721764117301356375" />
<style>
.row{
margin:0px auto; padding:0px auto ;
border:0px solid #f9f0e9;width:1000px;padding:10px;
background:#ffffff;
}


.kuan{
margin:0px auto; padding:0px auto ;
}
#form_search_new{
margin:0px auto; 
border:1px solid #f9f0e9;width:1000px;
background:#f9f0e9;
}

a {
  color: #0088cc;
  text-decoration: none;
}
a:hover {
  color: #005580;
  text-decoration: underline;
}
#search{float:left; width:368px; margin-top:10px;}
.searchinput {float:left;display:inline; background:url(themes/default/images/searchbg.gif) no-repeat; width:276px; border:none!important; height:33px!important;line-height:33px!important;}
.searchbtn {float:left;display:inline;width:90px;height:33px; background:url(themes/default/images/searchbtn.gif) no-repeat; border:none; border-radius:0px;}
.search_tips{position:absolute; top:31px; border:1px solid  #F30; width:276px; margin:0px; background-color:#fff; display:none; z-index:9999;}
.search_tips li{padding:6px; list-style-type:none;}
.search_tips li:hover{background-color:#ccc;}
</style>
<div class="head">
<dl class="n_top">
	<dd><h1>亲，欢迎来到饿得慌！</h1>
    <h2><?php if (! $this->_var['ssuser']): ?><a href="index.php?m=user&a=login">[登录]</a> <a href="index.php?m=user&a=reg" target="_blank">[免费注册]</a><?php endif; ?> </h2>

	<?php if ($this->_var['ssuser']): ?>
	<div class="nav-collapse">	
		<ul class="nav">
			<li  class="dropdown" style="liststyle:none;display:inline ">
				<a style="liststyle:none;display:inline;color:red" href="javascript:;"   class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->_var['ssuser']['username']; ?><b class="caret"></b></a>
				<ul class="dropdown-menu" >
					<li> <a href="index.php?m=user&a=logout">退出</a></li>
					<li> <a href="index.php?m=user&a=chpwd">帐号密码</a> </li>
					<li> <a href="index.php?m=user&a=edi">手机号码</a> </li>
					<li> <a href="index.php?m=user&a=myaddress">常用地址</a> </li>
					<li> <a href="index.php?m=shopcar&a=history">订单历史</a> </li>
				</ul>
			</li>
		</ul>	
	</div>
<?php endif; ?>
    </dd>
</dl>
<dl class="n_logo kuan">
	<dt><h1><a href="#">饿了么</a></h1><img src="image/l_guan.jpg" /></dt>
    <dd>
     <div class="right gouw">
</div>

    <h1><input type="text" class="sou_kuang" id="search" value="搜索美食" /><input type="button" class="sou_menu fz f14" value="搜一下" id="soumeishi" /></h1>
    </dd>
</dl>
</div>
<script>
	$(document).ready(function(){
		$("#search").focus(function(){ 
			if($(this).val()=="搜索美食"){
				$(this).val("");
			}
		});
		$("#search").blur(function(){
			if($(this).val()==""){
				$(this).val("搜索美食");
			}
		});
		$("#soumeishi").click(function(){
			var keyword=$("#search").val();
			
			window.location="index.php?m=search&a=cai&keyword="+keyword;
			
			
		})
	})
</script>