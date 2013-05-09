// JavaScript Document
$(document).ready(function()
{

	
	$(".replybox_btn").click(function()
	{
		$t=$(this);
		$("#replybox_title").html($t.attr("title"));
		$("#replybox_id").val($t.attr("replyid"));
		$("#replybox_url").val($t.attr("url"));
		$.get($t.attr("geturl"),function(data)
		{
			
			$("#replybox_content").val(data);
		})
		
		$("#replybox").css("display","block");
		center("#replybox");
	});
	$("#replybox_submit").click(function()
	{
		
		$.post(
		$("#replybox_url").val(),{
			id : $("#replybox_id").val(),
			content : $("#replybox_content").val()
		},function(data)
		{
			alert('回复成功');
			
			$("#replybox").css("display","none");
		}
		)
	});
	
	$("#replybox_close").click(function()
	{
		$("#replybox").css("display","none");
	
	});
	
	$(".ajax_yes").live("click",function()
	{
		
		$.get($(this).attr("url"));
		$(this).attr("src","images/yes.gif");
		url=$(this).attr("url");
		$(this).attr("url",$(this).attr("rurl"));
		$(this).attr("rurl",url);
		$(this).removeClass("ajax_yes").addClass("ajax_no");
	});
	
	$(".ajax_no").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).attr("src","images/no.gif");
		url=$(this).attr("url");
		$(this).attr("url",$(this).attr("rurl"));
		$(this).attr("rurl",url);
		$(this).removeClass("ajax_no").addClass("ajax_yes");
	});
	
	$(".ajax_pass").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("已审核");
	});
	$(".ajax_forbid").live("click",function()
	{
		$.get($(this).attr("url"));
		$(this).text("已禁止");
	});
	$(".ajax_del").bind("click",function(){
	 
		if(confirm('删除后不可恢复，确认删除吗？')){
			$.get($(this).attr("url"));
			$(this).parents("tr").remove();
		}
	})
	$("tr:nth-child(1)").addClass('first'); 
	$('tr').addClass('odd'); 
	$('tr:even').addClass('even'); //奇偶变色，添加样式 
	
});