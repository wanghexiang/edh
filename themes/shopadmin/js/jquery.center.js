function showDiv(obj){  
$(obj).show();  
center(obj);  
$(window).scroll(function(){   center(obj);  });  
$(window).resize(function(){   center(obj);  });  
} 
function center(obj)
{  
var windowWidth = document.documentElement.clientWidth;    
 var windowHeight = document.documentElement.clientHeight;     
 var popupHeight = $(obj).height();     
 var popupWidth = $(obj).width();      
 $(obj).css({     
  "position": "absolute",     
  "top": (windowHeight-popupHeight)/2+$(document).scrollTop(),      
  "left": (windowWidth-popupWidth)/2+$(document).scrollLeft(),    
   });   
}    