// JavaScript Document
$(document).ready(function()
{
	
	$("#cat1").change(function()
	{
		$.post(
		"admin.php?m=art_cat&",
		{
			pid :	$("#cat1").val(),
			act : "getcat"
		},function(data,textStatu){
			
			$("#cat2").empty();
			$("#cat2").append(data);
			
		
		})
	});
	
	
});
