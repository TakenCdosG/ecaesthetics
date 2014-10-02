function simple_tooltip(target_items, image){
 var id = target_items.replace('a#','div-');
 jQuery(target_items).each(function(i){
		jQuery(this).parent().append("<div class=\"tooltip\" id='"+id+"'>"+"<img src="+image+" /><span>"+jQuery(this).attr('title')+"</span><b></b>"+"</div>");
		var my_tooltip = jQuery("#"+id);
		my_tooltip.css({opacity:0});
		jQuery(this).removeAttr("title").hover(
		function(){ my_tooltip.stop().animate({opacity:1, 'left':(jQuery(this).width()+22)+'px'});},
		function(){ my_tooltip.stop().animate({opacity:0, 'left':'100px'});}
		
		)
	});
}

	
