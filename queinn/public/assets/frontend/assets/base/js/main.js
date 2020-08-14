
$(document).ready(function(){
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollTop').fadeIn();
		} else {
			$('.scrollTop').fadeOut();
		}
	});
	$('.scrollTop').click(function(){
		$('html, body').animate({scrollTop : 0},1000);
		return false;
	});
	
});

function bannerslider()
{	$('.bannerPanel').ready(function(){
	$('.bannerSlider').bxSlider({ auto:true,infiniteLoop:true,pause:7500,speed:1500, nextSelector: '#slidernext',   prevSelector: '#sliderprev'});
	});
}
function featuredSlider()
{	
	var featuredSlider = $("#featuredSlider");
    featuredSlider.owlCarousel({	
		itemsCustom:[
		[0, 2],
		[450, 2],
		[600, 3],
		[960, 4],
		[1024, 4],
		[1200, 4]
		],
		autoPlay:true,
		navigation : true
		});
		$(".featurednext").click(function(){
			featuredSlider.trigger('owl.next');
		})
		$(".featuredprev").click(function(){
			featuredSlider.trigger('owl.prev');
		})
}



$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-right").removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-right");
});

