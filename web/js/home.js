var $user=null;
var $bindphoneChecked=false;
$(document).ready(function()
{
	$(".bannerBtn").html("立即体验");
	jQuery.fn.extend({
		center:function(width,height)
		{
			return $(this).css("left", ($(window).width()-width)/2+$(window).scrollLeft()).
			css("top", ($(window).height()-height)/2+$(window).scrollTop()).
			css("width",width).
			css("height",height);
		}
	});

	/*********************************点击滑动到相应的位置***********************************/
	var $color4ds = $(".dth-color4d ");
	var $toHere = $(".to-here");
	for(var i = 0,length = $toHere.length;i<length;i++){
		(function (x) {
			$($color4ds[x]).on("click",function () {
				var target = $($toHere[x]).offset().top;
				$("body,html").animate({"scrollTop":target});
			});
		})(i)
	}
	/*********************************监听滚动,显示固定header***********************************/
	if($(document).scrollTop()>0){
		$("header").addClass("fixed-header");
	}
	$(window).scroll( function(){
		var scrollTop = $(document).scrollTop();
		if(scrollTop > 0){
			$("header").addClass("fixed-header");
		}else{
			$("header").removeClass();
		}
	});

});



