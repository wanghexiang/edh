<?php
check_login();

$a=get_post('a')?get_post('a'):'index';
switch($a)
{
	case 'index':
			
			
			loadModel("caipu");
			 
			$id=get_post('id','i');
			$w="";
			if($id){
				$w.=" AND id=$id ";
			}
			$title=get_post('title',"h");
			if($title){
				$w.=" AND title like '%$title%' ";
				$u.="&title=".urlencode($title);
			}
			$cat_id=get_post('cat_id',"i");
			if($cat_id){
				$w.=" AND cat_id={$cat_id}";
				$u.="&cat_id={$cat_id}";
			}
			$cat_id_two=get_post('cat_id_two',"i");
			if($cat_id_two){
				$w.=" AND cat_id_two={$cat_id_two}";
				$u.="&cat_id_two={$cat_id_two}";
			}
			$isrecommend=get_post('isrecommend',"i");
			if($isrecommend){
				$w.=" AND isrecommend=1";
				$u.="&isrecommend=1";
			}
			
			$smarty->assign("catlist",$caipuModel->catlist(0,1));
			$smarty->assign("all_cat",$caipuModel->all_cat());
			assignlist("caipu",20,$w,"order by id DESC " ,"admin.php?m=caipu{$u}");
			$smarty->display("caipu_index.html");
		break;
	case 'add':
			$id=intval(get_post('id'));
			$catlist=$db->getAll("SELECT catid,cname FROM ".table('caipu_cat')." WHERE pid=0   ORDER BY orderindex ASC ");
			$weilist=$db->getAll("SELECT id,wname FROM ".table('cai_wei')."  ORDER BY orderid ASC ");
			$dolist=$db->getAll("SELECT id,dname FROM ".table('cai_do')." ORDER BY orderid ASC ");
			if($id){
				$caipu=$db->getRow("SELECT * FROM ".table('caipu')." WHERE id='$id'  ");
				if($caipu['cat_id'] ){
				  $caipu['cname']=$db->getOne("SELECT cname FROM ".table('caipu')." WHERE catid=".$caipu['cat_id']." ");
				  $smarty->assign("pcatlist",$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid=".$caipu['cat_id']." "));
				}
				
				$tagsid=$db->getCols(" SELECT tagid FROM ".table('caipu_tags_index')." WHERE caipu_id='$id' ");
				 
				$tags=$db->getCols("SELECT tagname FROM ".table('caipu_tags')." where tagid in("._implode($tagsid).") ");
				if($tags){
					$tags=implode(" ",$tags);
				}
				$smarty->assign("tags",$tags);
				 
			}
			
			$smarty->assign(
				array(
					"catlist"=>$catlist,
					"weilist"=>$weilist,
					"dolist"=>$dolist,
					"rs"=>$caipu,
				)
			);
			$smarty->display("caipu_add.html");	
			break;
	case 'post':
				require_once(ROOT_PATH."includes/cls_image.php");
				$clsimg=new image();
				$id=intval(get_post('id'));
				$data['title']=htmlspecialchars(trim(post('title')));
				$data['keywords']=htmlspecialchars(trim(post('keywords')));
				$data['description']=htmlspecialchars(trim(post('description')));
				$data['maincai']=htmlspecialchars(trim(post('maincai')));
				$data['othercai']=htmlspecialchars(trim(post('othercai')));
				$data['content']=trim(post('content'));
				$data['wei_id']=post('wei_id',"i");
				$data['do_id']=post('do_id',"i");
				if(strpos(post('imgurl'),"http://")!==false){
					$dir="upfile/images/".date("Y/m/d/");
					umkdir($dir);
					$file=$dir.time().md5(post('imgurl')).".jpg";
					file_put_contents($file,file_get_contents(post('imgurl')));
					$_POST['imgurl']=$file;
				}
				
				if($id){
					$oldimg=$db->getOne("SELECT imgurl FROM ".table('caipu')." WHERE id='$id' ");
					if($oldimg!=post('imgurl') && post('imgurl')){
						$clsimg->makethumb(post('imgurl').".100x100.jpg",post('imgurl'),100,100,true);
						$clsimg->makethumb(post('imgurl').".300x300.jpg",post('imgurl'),300,300);
						$clsimg->makethumb(post('imgurl').".800x800.jpg",post('imgurl'),800,800);
						
					}
				}else{
					$clsimg->makethumb(post('imgurl').".100x100.jpg",post('imgurl'),100,100,true);
					$clsimg->makethumb(post('imgurl').".300x300.jpg",post('imgurl'),300,300);
					$clsimg->makethumb(post('imgurl').".800x800.jpg",post('imgurl'),800,800);
				}
				$data['cat_id']=intval(post('cat_id'));
				$data['cat_id_two']=intval(post('cat_id_two'));
				$data['imgurl']=trim(post('imgurl'));
				$tags=trim(post('tags'));
				$arr=explode(" ",$tags);
				$arr=$arr?$arr:array();
				if(post('id')){
					$db->update("caipu",$data," AND id=".intval(post('id'))." ");
					$oldtags=$db->getCols("SELECT tagname FROM ".table('caipu')." WHERE id='$id' ");
					$oldtags=$oldtags?$oldtags:array();
					$deltags=array_diff($oldtags,$arr);
					$newtags=array_diff($arr,$oldtags); 
				}else{
					$data['dateline']=time();
					$id=$db->insert("caipu",$data);
					$newtags=$arr;
				}
				
				
				if($deltags){
					foreach($deltags as $k=>$v){
						$tagid=$db->getOne("SELECT tagid FROM ".table('caipu_tags')." WHERE tagname='$v' ");
						$db->query("DELETE FROM ".table('caipu_tags_index')." WHERE tagid='$tagid' AND id='$id' ");
						//减1
						$db->query("UPDATE ".table('caipu_tags')." SET c_num=c_num-1 WHERE tagname='$v' ");
						 
					}
				}
				
				 ;
				if($newtags){
					foreach($newtags as $k=>$v){
						if(empty($v)) continue;
						if(!$tagid=$db->getOne("SELECT tagid FROM ".table('caipu_tags')." WHERE tagname='$v' "))
						{
							$db->query("INSERT INTO ".table('caipu_tags')." SET tagname='$v',c_num=0 ");
							$tagid=$db->insert_id();
							
						} 
						$db->query("INSERT INTO ".table('caipu_tags_index')." SET tagid='$tagid',caipu_id='$id' ");
						$db->query("UPDATE ".table('caipu_tags')." SET c_num=c_num+1 WHERE tagname='$v' "); 
						
					}
				}
			gourl(); 
		break;
	case 'del':
			$id=intval(get('id'));
			$db->query("DELETE FROM ".table('caipu')." WHERE id='$id' ");
			$db->query("DELETE FROM ".table('caipu_tags_index')." WHERE caipu_id='$id' ");
		break;
	case 'recommend':
			$id=intval(get('id'));
			$isrecommend=intval(get('t'));
			$db->query("UPDATE ".table('caipu')." SET isrecommend='$isrecommend' WHERE id='$id' ");
		break;	
	case 'cat':
			$catlist=array();
			$res=$db->query("SELECT * FROM ".table('caipu_cat')." WHERE pid=0 ORDER BY orderindex ASC ");
			while($rs=$db->fetch_array($res)){
				$rs['child']=$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid='{$rs['catid']}' ORDER BY orderindex ASC ");
				$catlist[]=$rs;
			}
			$smarty->assign("catlist",$catlist);
			$smarty->display("caipu_cat.html");
		break;
	case 'cat_add':
			$catid=intval(get_post('catid'));
			if(get_post('op')=='post'){
				$data['cname']=trim(htmlspecialchars(post('cname')));
				$data['orderindex']=intval(post('orderindex'));
				$data['pid']=intval(post('pid'));
				if($catid){
					$db->update("caipu_cat",$data," AND catid='$catid' ");
					
				}else{
					  $db->insert("caipu_cat",$data);
				}
				gourl();
			}else{
				
				$cat=$db->getRow("SELECT * FROM ".table('caipu_cat')." WHERE catid='$catid' ");
				$catlist=$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE   pid=0 ");
				$smarty->assign("cat",$cat);
				$smarty->assign("catlist",$catlist);
				$smarty->display("caipu_cat_add.html");
			}
		break;
	case 'getcatchild':
			header("Content-type:text/html;charset=utf-8");
			$pid=intval(get_post('pid'));
			$pid && $catlist=$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE   pid='$pid' ");
			echo iconv("gbk","utf-8","<option value='0'>请选择</option>");
			if($catlist){
				foreach($catlist  as $v){
					echo iconv("gbk","utf-8","<option value='{$v['catid']}'>{$v['cname']}</option>");
				}
			}
		break;
	/*批量替换分类*/
	case "change_category":
			$ids=get_post('ids');
			$ids=explode(" ",$ids);
			$cat_id=get_post('cat_id',"i");
			$cat_id_two=get_post('cat_id_two',"id");
			$ids && $db->update("caipu",array("cat_id"=>$cat_id,"cat_id_two"=>$cat_id_two)," AND id in("._implode($ids).")");
			errback("分类修改成功");
		break;
	case 'tags':
			switch(get('op'))
			{
				case 'changestatus':
						$tagid=intval(get('tagid'));
						$status=intval(get('status'));
						$db->query("UPDATE ".table('caipu_tags')." SET status='$status' WHERE tagid='$tagid' ");
					break;
				default:
					assignlist("caipu_tags",20,""," ORDER BY orderindex DESC ","admin.php?m=caipu&a=tags");
					$smarty->display("caipu_tags.html");
					break;
			}
			
		break;
	
}

?>