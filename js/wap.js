$(document).ready(function()
{
	
	if($(".navbar").length>0)
	{
		navbarlen=$(".navbar").length;
		for(i=0;i<navbarlen;i++)
		{
			navbarlis=$(".navbar").eq(i).children("ul").children("li").length;
			navbarliwidth=(100/navbarlis)+"%";
			
			$(".navbar").eq(i).children("ul").children("li").css({width:navbarliwidth});
		}
	}
});