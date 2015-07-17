"use strict";
	
jQuery(document).ready(function(){
	jQuery('.menu li a').click(function() {
		var href = jQuery(this).attr('href');
		jQuery("html, body").animate({ scrollTop: jQuery(href).offset().top - 90 }, 1000);
		return false;
	});
	
/* RESPONSIVE VIDEOS */	
	jQuery(".main").fitVids();	
	
/*blog hover image*/
	jQuery( ".blogpostcategory" ).each(function() {		
		var img = jQuery(this).find('img');
		var height = img.height();
		var width = img.width();
		var over = jQuery(this).find('a.overdefultlink');
		over.css({'width':width+'px', 'height':height+'px'});
		var margin_left = parseInt(width)/2 - 18
		var margin_top = parseInt(height)/2 - 18
		over.css('backgroundPosition', margin_left+'px '+margin_top+'px');
	});	
	
/*resp menu*/	
	jQuery('.resp_menu_button').click(function() {
	if(jQuery('.event-type-selector-dropdown').attr('style') == 'display: block;')
	jQuery('.event-type-selector-dropdown').slideUp({ duration: 500, easing: "easeInOutCubic" });
	else
	jQuery('.event-type-selector-dropdown').slideDown({ duration: 500, easing: "easeInOutCubic" });
	});	
	jQuery('.event-type-selector-dropdown').click(function() {
	jQuery('.event-type-selector-dropdown').slideUp({ duration: 500, easing: "easeInOutCubic" });
	});	
	
/*add submenu class*/
	jQuery('.menu > li').each(function() {
	if(jQuery(this).find('ul').size() > 0 ){
	jQuery(this).addClass('has-sub-menu');
	}
	});	
	
/*animate menu*/

	jQuery('ul.menu > li').hover(function(){
	jQuery(this).find('ul').stop(true,true).fadeIn(300);
	},
	function () {
	jQuery(this).find('ul').stop(true,true).fadeOut(300);
	});
/*add lightbox*/	
	jQuery(".gallery a").attr("rel", "lightbox[gallery]").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false,deeplinking:false});
	
/*form hide replay*/
	jQuery(".reply").click(function(){
	jQuery('#commentform h3').hide();
	});
	jQuery("#cancel-comment-reply-link").click(function(){
	jQuery('#commentform h3').show();
	});	
	
	var menu = jQuery('.mainmenu');
	jQuery( window ).scroll(function() {
	if(!menu.isOnScreen() && jQuery(this).scrollTop() > 350){ 
	jQuery(".totop").fadeIn(200);
	jQuery(".fixedmenu").slideDown(200);
	jQuery(".pmc-sidebar-post:hidden").fadeIn(200);}
	else{
	jQuery(".fixedmenu").slideUp(200);
	jQuery(".totop").fadeOut(200);
	jQuery(".pmc-sidebar-post:visible").fadeOut(200);;
	}
	});	
	
/*go tot op*/
	jQuery('.gototop').click(function() {
	jQuery('html, body').animate({scrollTop:0}, 'medium');
	});	
	
	jQuery( ".pagenav.home .menu > li:first-child a" ).addClass('important_color');
	
	jQuery('.bxslider').bxSlider({
	  auto: true,
	  speed: 1000,
	  controls: false,
	  pager :false,
	  easing : 'easeInOutQuint',
	});

	jQuery('.post-widget-slider').bxSlider({
		controls: true,
		displaySlideQty: 1,
		speed: 800,
		touchEnabled: false,
		easing : 'easeInOutQuint',
		prevText : '<i class="fa fa-chevron-left"></i>',
		nextText : '<i class="fa fa-chevron-right"></i>',
		pager :false

	});	

});


jQuery.fn.isOnScreen = function(){
     
    var win = jQuery(window);
     
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
    
	if(this.offset()){
    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
     
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
     }
};



