<?php
switch($a){
	case "getlist":
			$catid=1;
			$pn=max(1,intval($_GET['pn']));
			$f=file_get_contents("http://jingyan.baidu.com/list/$catid?pn=$pn");
			
			preg_match_all("/\/(article\/[^\.]*\.html).*title=\"(.*)\"/iUs",$f,$a);
			$base="http://jingyan.baidu.com/";
			 
			if(empty($a[1])) exit("采集成功");
			foreach($a[1] as $k=>$v)
			{
				$data=array();
				$data['url']=$base.$v;
				$data['title']=iconv("utf-8","gbk",$a[2][$k]);
				if(!$db->getOne("SELECT id FROM ".table('stole')." WHERE url='".$base.$v."' ")){
					$db->insert("stole",$data); 
				}
			}
			 
			if($pn)
			{
				$pn=$pn+25;
				echo "<script>location.href='index.php?m=stole&a=getlist&pn=$pn'</script>";
				exit;
			}else
			{
				echo '采集完毕';
			}
		break;
	case "getcontent":
			set_time_limit(0);
			$rs=$db->getRow("SELECT  id,title,url FROM ".table("stole")." WHERE status=0 LIMIT 1 ");
			 
			if(!$rs) echo "生成成功";
			$db->update("stole",array("status"=>1), " AND id=".$rs['id']);
			$f=file_get_contents($rs['url']);
			$f=str_replace("?","",mb_convert_encoding($f,"gbk","utf-8"));
			 
			
			//获取原料
			preg_match("/(工具\/原料.*<\/ul>)/iUs",$f,$cai);
			$cai=strip_tags($cai[0]);
			preg_match("/<section id=\"exp-detail\" class=\"border-padding \">(.*)<\/section>/iUs",$f,$a);
			//preg_match("/<div class=\"exp-content\">(.*)<script>/iUs",$a[1],$a);
			$s=$a[1]; 
			//获取内容
			preg_match("/<ol class=\"exp-conent-orderlist\">.*<\/ol>/iUs",$s,$cc);
			$content=removelink($cc[0]);
			
			preg_match_all("/<img.*src=[\'\"]+(.*)[\'\"]/iUs",$content,$arr);
			
			$pics=$arr[1];
			$dir="upfile/caipu/".date("Y/m/");
			umkdir($dir);
			if(empty($pics)) exit("无法获取图片");
			foreach($pics as $k=>$pic)
			{
				$file=$dir.md5(time().$pic).".jpg";
				file_put_contents($file,file_get_contents($pic));
				if($k==0){
					$imgurl=$file;
					require_once(ROOT_PATH."includes/cls_image.php");
					$clsimg=new image();
					$clsimg->makethumb($imgurl.".100x100.jpg",$imgurl,100,100,true);
					$clsimg->makethumb($imgurl.".300x300.jpg",$imgurl,300,300);
					$clsimg->makethumb($imgurl.".800x800.jpg",$imgurl,800,800);
				}
				
				
				$content=str_replace($pic,$file,$content);
			}
			 
			
			$s=preg_replace("/<div class=\"exp-content-block \"><h2 class=\"exp-content-head\">参考资料<\/h2>(.*)<\/script> <div class=\"clear\"><\/div>/iUs","",$content);
			$s=preg_replace("/<script.*>(.*)<\/script>/iUs",'',$s);
			$s=preg_replace("/<li style=\".*\"/iUs","<li ",$s);
			$s=preg_replace("/<ul class=\"exp-relate\">.*<\/ul>/iUs","",$s);
			$s=preg_replace("/<h2>参考资料<\/h2>.*<\/a>/i","",$s);
			$s=preg_replace("/<div class=\"prompt\">.*<\/div>/iUs",'',$s);
			
			
			
  
			$cai=trim(str_replace(array("工具/原料","、","\r\n")," ",$cai));
			$caiarr=explode(" ",$cai);
			if($caiarr){
				$ikey=1;
				foreach($caiarr as $k=>$v){
					
					if($v){
						
						if($ikey<5){
							$maincais[]=$v;
						}else{
							$othercais[]=$v;
						}
						$ikey++;
					}
					
				}
			}
			$maincai=$othercai=" ";
			if(isset($maincais)){
				$maincai=implode(" ",$maincais);
			}
			if(isset($othercais)){
				$othercai=implode(" ",$othercais);
			}
			//$data['cat_id']=1;
			$seo=array(
				"厦门外卖教学:",
				"厦门外卖网教学:",
				"厦门订餐教学：",
				"厦门软件园二期订餐：",
				"厦门美食教学：",
			); 
			shuffle($seo);
			$data['title']=$seo[0].$rs['title'];
			$data['keywords']=$seo[0].$rs['title'];
			$data['description']=$seo[0].$rs['title'];
			$data['dateline']=time();
			$data['imgurl']=$imgurl;
			$data['maincai']=$maincai;
			$data['othercai']=$othercai;
			$data['content']=addslashes($seo[0].$content);
			$db->insert("caipu",$data);
			$id=$db->insert_id();
			/*发送微博*/
			require_once("config/sina_config.php");
			require_once("api/sina/saetv2.ex.class.php");
			$accesstoken=$db->getOne("SELECT accesstoken FROM ".table('userapi')." where xusername='我是挑食客'  ");
			if($accesstoken){
				$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$accesstoken );
				$c->upload(iconv("gbk","utf-8",$rs['title'] ." 挑食客 http://www.tiaoshike.com/m-caipu-a-show-id-{$id}.html"),"http://www.tiaoshike.com/".$imgurl);
			}
			echo "采集成功".$db->insert_id();;
		break;
	case "getwaimaijia"://采集外卖家的店铺
				set_time_limit(0);
				$i=max(245,$_GET['i']);
				$c=file_get_contents("http://www.waimaijia.com/sj_detail.asp?id=$i");
				preg_match("/[^>>]>> (.*)>><a href=\"sjdianping\.asp\?area=\">返回商家列表<\/a>/iUs",$c,$s);
				if($s){
					$shopname=$s[1];
					$shop=array(
						"shopname"=>$shopname,
						"siteid"=>1,
						"visible"=>1,
					);
					//添加商店
					$db->insert("shop",$shop);
					$shopid=$db->insert_id();
					//添加商店配置
					$shopconfig=array(
						"shopid"=>$shopid,
						 "ordertype"=>1,
					);
					$db->insert("shopconfig",$shopconfig);
					//添加商店内容
					$db->insert("shop_data",array("shopid"=>$shopid,"content"=>"暂无内容"));
					//添加美食分类
					$db->insert("cai_cat",array("cname"=>"{$shopname}的套餐","siteid"=>1,"shopid"=>$shopid));
					$catid=$db->insert_id();
					preg_match_all("/<a href=\".*\.jpg\".*rel=\"lightbox\">(.*)<\/a>/iUs",$c,$t);
					preg_match_all("/￥(\d+)[^\d]/iUs",$c,$p);
					foreach($t[1] as $k=>$v){
						//添加美食
						$cai=array(
							"siteid"=>1,
							"catid"=>$catid,
							"title"=>$v,
							"shopid"=>$shopid,
							"price"=>$p[1][$k],
						);
						$db->insert("cai",$cai);
						$caiid=$db->insert_id();
						$db->insert("cai_data",array("id"=>$caiid,"content"=>"暂无内容"));
					}
					
					

					$i++;
					
					echo "<script>location.href='index.php?m=stole&a=getwaimaijia&i={$i}';</script>";
					exit;
				}else{
					$i++;
					
					echo "<script>location.href='index.php?m=stole&a=getwaimaijia&i={$i}';</script>";
					exit;
				}
				
				
		break;

	
}

?>