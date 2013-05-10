 
<ul class="nav nav-tabs">
<li <?php if ($_GET['a'] == "index" || $_GET['a'] == "shop"): ?> class="active"<?php endif; ?>><a href="index.php?m=search&a=shop&keyword=<?php echo $_GET['keyword']; ?>" >µÍ∆Ã</a></li>
<li <?php if ($_GET['a'] == "cai"): ?>class="active"<?php endif; ?> ><a href="index.php?m=search&a=cai&keyword=<?php echo $_GET['keyword']; ?>">√¿ ≥</a></li>
<li <?php if ($_GET['a'] == "people"): ?>class="active"<?php endif; ?>><a href="index.php?m=search&a=people&keyword=<?php echo $_GET['keyword']; ?>">∫√”—</a></li>
<li <?php if ($_GET['a'] == "caipu"): ?>class="active"<?php endif; ?>><a href="index.php?m=search&a=caipu&keyword=<?php echo $_GET['keyword']; ?>">≤À∆◊</a></li>
</ul>                                
<form action="index.php" name="searchform" id="form_search_new" method="get" >
		<input type="hidden" name="m" value="search">
        <input type="hidden" name="a" value="<?php echo $_GET['a']; ?>" />
        <input type="text" value=" <?php echo htmlspecialchars($_GET['keyword']); ?>" name="keyword"  style="padding:0px; width:600px; " autocomplete="off" class="searchinput">
        <input type="submit" class="searchbtn" value=" " style="width:90px; height:33px;" name="submit">
         
</form>
<div style="clear:both"></div> 