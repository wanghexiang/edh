<?php
$a=get_post('a');
if(empty($a)) $a='index';
switch($a){
	case 'index':
			$w=$purl="";
			$cat_id=intval(get('cat_id'));
			if($cat_id){
				$w.=" AND cat_id='$cat_id' ";
				$catchild=$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid='$cat_id'  ");
				$smarty->assign("catchild",$catchild);
				$purl.="&cat_id=$cat_id";
			}
			$cat_id_two=intval(get('cat_id_two'));
			if($cat_id_two){
				$w.=" AND cat_id_two='$cat_id_two' ";
				$purl.="&cat_id_two=$cat_id_two";
			}
			assignlist("caipu",20,$w,"order by id desc","index.php?m=caipu{$purl}");
			$smarty->assign("catlist",$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid=0 "));
			$smarty->display("caipu.html");
		break;
	case 'show':
			$id=intval(get('id'));
			$caipu=$db->getRow("SELECT * FROM ".table('caipu')." WHERE id='$id' ");
			$_GET['cat_id']=$caipu['cat_id'];
			$_GET['cat_id_two']=$caipu['cat_id_two'];
			$smarty->assign("catlist",$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid=0 "));
			$caipu['cat_id_two'] && $catchild=$db->getAll("SELECT * FROM ".table('caipu_cat')." WHERE pid='{$caipu['cat_id']}'  ");
			$caipulist=$db->getAll("SELECT * FROM  ".table('caipu')." WHERE isrecommend=1 limit 10 "); 
			$tagsid=$db->getCols("SELECT tagid FROM ".table('caipu_tags_index')." WHERE caipu_id='$id' ");
			$tagsid && $tagslist=$db->getAll("SELECT tagid,tagname FROM ".table('caipu_tags')." WHERE tagid in("._implode($tagsid).") ");
			$smarty->assign(
				array(
					"caipu"=>$caipu,
					"catchild"=>$catchild,
					"caipulist"=>$caipulist,
					"tagslist"=>$tagslist,
					"seo"		=>array(
									"title"=>$caipu['title'],
									"keywords"=>$caipu['keywords'],
									"description"=>$caipu['description'],
								),
				)
			);
			
			$smarty->display("caipu_show.html");
		break;
	case "tags":
			$tagslist=$db->getAll(" SELECT * FROM ".table('caipu_tags')." WHERE status=1 ORDER BY orderindex DESC ");
			$smarty->assign("tagslist",$tagslist);
			$tagid=intval(get('tagid'));
			$pagesize=20;
			$start=(max(1,intval(get('page')))-1)*$pagesize;
			$ids=$db->getCols("SELECT caipu_id FROM ".table('caipu_tags_index')." WHERE tagid='$tagid' ORDER BY caipu_id DESC LIMIT $start,$pagesize ");
			 
			if($ids){
				$smarty->assign("list",$db->getAll("SELECT * FROM ".table('caipu')." WHERE id in("._implode($ids).") "));
			}
			$smarty->display("caipu_tags.html");
		break;
	
	
}

?>