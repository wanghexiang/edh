<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>页面</title>
<link rel="stylesheet" type="text/css" href="image/chi.css"/>
<script  src="js/jquery.js" type="text/javascript"></script>
<script></script>
</head>

<body class="bg">
<dl class="biaoge_b">
	<dt><h1><a href="#">饿了么</a></h1>
  	<h2>
    <a title="设为首页" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.baidu.com');" href="javascript:;">设为首页</a> 
    <a onClick="window.external.addFavorite('http://www.baidu.com')" title="饿了么">加入收藏</a> 
    </h2>
  </dt>
  <dd>&nbsp;</dd>
</dl>
<div class="content">
	<div class="fullheight" id="step1">
    <div class="main">
     	<div class="city_fr">
        	<ul class="city">
            	<li id="city_1" data-id="1" class="">
                <a onclick="getcity(1);"><b class="city_pic_fr"></b>
                <em class="city_name">武侯区</em></a>
				<em class="to_city" ></em></li>
                <li id="city_2" data-id="2" class="">
                <a onclick="getcity(2);"><b class="city_pic_fr2"></b>
                <em class="city_name">高新区</em></a>
				</li>
                <li id="city_3" data-id="3" class="">
                <a onclick="getcity(3);"><b class="city_pic_fr3"></b>
                <em class="city_name">青羊区</em></a></li>
                <li id="city_4" data-id="4" class="">
                <a onclick="getcity(4);"><b class="city_pic_fr4"></b>
                <em class="city_name">锦江区</em></a>
                <em class="to_city" id="hangzhou_special"></em></li>
                <li id="city_5" data-id="5" class="">
                <a onclick="getcity(5);"><b class="city_pic_fr5"></b>
                <em class="city_name">成华区</em></a></li>
                <li id="city_6" data-id="6" class="">
                <a onclick="getcity(6);"><b class="city_pic_fr6"></b>
                <em class="city_name">金牛区</em></a></li>
				<!--
                <li id="city_7" data-id="7" class="">
                <a onclick="getcity(1);"><b class="city_pic_fr7"></b>
                <em class="city_name">大学</em></a></li>
				-->
            </ul>
            <div class="clear"></div>
            <div class="select_fr">
                <span>
                    <em class="to_city hide"></em>
                    <a href="javascript:void(0);" class="select select-city" id="select_city">武侯区</a>
                </span>
                <span>
                    <em class="to_city hide"></em>
                    <a href="javascript:void(0);" class="select select-city" id="select_city">高新区</a>
                </span>
                <span>
                    <a href="javascript:void(0);" class="select" id="select_district"><b data-name="请选择区域">请选择区域</b></a>
                </span>
                <span>
                    <a href="javascript:void(0);" class="select" id="select_zone"><b data-name="选择商圈">选择商圈</b></a>
                </span>
            </div>
        </div>
            <div id="region">
           <ul>
           <li class="y_daoh">&nbsp;</li>
           <li>2</li>
           <li>3</li>
           <li>4</li>
           <li>5</li>
           <li>6</li>
           <li>7</li>
           <li>8</li>
           <li>9</li>
		   <li>2</li>
           <li>3</li>
          
			</ul>
		</div>

        <div class="search-area">
        
          <div class="search_input">
            <h1><!--<input style="width:240px; height:38px;" class="input-large ui-autocomplete-input sou_kuang" placeholder="输入学校，地址，写字楼查找" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">--><!--<input type="button" class="sou_menu" style="color:#FFF; font-size:14px;" value="搜一下" />--></h1>
          </div>
        </div>
        <div class="entry_fr" style="display:none;">
            <div class="entry">
                <h2>
                    <em class="to_zone" id="backto_step1"></em>
                    <span id="home_nav"></span>
                </h2>
                <div class="econ_fr">
                    <div class="azgroup_fr">
                        <div class="azgroup">
                            <a class="all active" href="javascript:;">全部</a>
                            <a class="com" href="javascript:;">A</a>
                            <a class="com" href="javascript:;">Z</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php if (! $this->_var['ssuser']): ?>
        <div class="foot-button">
                          <a href="index.php?m=user&amp;a=reg" target="_blank" class="foot_addr">注册</a>
              <a class="foot_login" href="index.php?m=user&a=login" target="_blank">登录</a>
			  
      </div>
		<?php endif; ?>
    </div>
</div>

    </div>
</body>
<script type='text/javascript'>
	function getcity(provinceid){
		$.get("index.php?m=region&a=city&provinceid="+provinceid,function(info){
			$("#region").html(info);
			$("#region").show();
			
		})
	}
	function gettowns(cityid){
		$.get("index.php?m=region&a=town&cityid="+cityid,function(info){
			$("#region").html(info);
			$("#region").show();
			
		})
		
	}
	function hide(){
		$("#region").hide();
	}
</script>
</html>
