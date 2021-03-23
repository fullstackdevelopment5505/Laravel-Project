//disable outside click when bootstrap model is open

$(document).ready(function() {
  $(".modal").modal({
      show: false,
      backdrop: 'static'
  });
});
// sidebar navigation
$('.navigation > ul > li > a').click(function(){
	$(this).next('.sub_menu').slideToggle(100);
  $(this).parents("li.has_dropdown").toggleClass('active_nav');
});	


// toggle header click
$('.header_area .l_head .toggle').click(function(){
	$('.main_area').toggleClass('hide_dividers')
});


// add class on 1024 on main div
if ( $(window).width() <= 1023) { 
    $('.main_area').addClass('hide_dividers')
    } else {  
    $('.main_area').removeClass('hide_dividers')
} 



// search js
$('.header_area .r_head .search').click(function(){
	$('.search_popup').slideToggle(100);
	$('.search .show_search, .search .remove_search').toggle();
});


// notification
$('.notification').click(function(){
	$(this).find('.notify').fadeToggle(100);
});

// user dropdown
$('.user').click(function(){
	$(this).find('.user_detail').fadeToggle(100);
});


// full screen
function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {  
      document.documentElement.requestFullScreen();  
    } else if (document.documentElement.mozRequestFullScreen) {  
      document.documentElement.mozRequestFullScreen();  
    } else if (document.documentElement.webkitRequestFullScreen) {  
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
    }  
  } else {  
    if (document.cancelFullScreen) {  
      document.cancelFullScreen();  
    } else if (document.mozCancelFullScreen) {  
      document.mozCancelFullScreen();  
    } else if (document.webkitCancelFullScreen) {  
      document.webkitCancelFullScreen();  
    }  
  }  
}