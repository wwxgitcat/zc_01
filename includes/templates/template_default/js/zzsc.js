jQuery(document).ready(function($){




	// browser window scroll (in pixels) after which the "back to top" link is shown
	// var offset = 300,
	// 	//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
	// 	offset_opacity = 1200,
	// 	//duration of the top scrolling animation (in ms)
	// 	scroll_top_duration = 700,
	// 	//grab the "back to top" link
	// 	$back_to_top = $('.cd-top');

	// //hide or show the "back to top" link
	// $(window).scroll(function(){
	// 	( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
	// 	if( $(this).scrollTop() > offset_opacity ) { 
	// 		$back_to_top.addClass('cd-fade-out');
	// 	}
	// });

	// //smooth scroll to top
	// $back_to_top.on('click', function(event){
	// 	event.preventDefault();
	// 	$('body,html').animate({
	// 		scrollTop: 0 ,
	// 	 	}, scroll_top_duration
	// 	);
	// });

});


$(document).ready(function(){ 
	// $(".categories-item-sub-item").find(".categories-item-sub3").prev("a").css("font-weight","bold");
	
$(".categories-item-sub-item>a").next('.demotest1').hide();	
	$(".cate_more").click(function(){
		$('.sub-categories').slideToggle(300);
	
	});
	// $(".product-item").mouseover(function(){
	// 	$(this).find('h5>a').css('color','white');
	// });
	// $(".product-item").mouseout(function(){
	// 	$(this).find('h5>a').css('color','black');
	// });

	// $(".pro_main").mouseover(function(){
	// 	$(this).find('.pro_two>a').css('color','white');	
	// });
	// $(".pro_main").mouseout(function(){
	// 	$(this).find('.pro_two>a').css('color','black');
	// });
	// $(this).mouseout(function(){
	// 	$(this).css('color','black');
	// 	$(this).find('.pro_two>a').css('color','black');
	// });
	// $(".pro_main>.banner-item").mouseout(function(){
	// 	$(".pro_two>a").css('color','black');
	// })


	
	$(".categories-item-sub-item>a").mouseover(function() {
	     // $(".categories-item-sub-item>a").not($(this).next(".categories-item-sub3")).slideUp(300);
	     // $(".demotest1").hide();
	     $(this).next(".demotest1").slideDown(300);
	     return;
	     // $(".categories-item-sub-item").siblings().find(".demotest1").slideUp(800);
	});

}); 
