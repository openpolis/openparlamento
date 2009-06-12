(function($) {

jQuery.getScroll = function (e){ 
    if (e) { 
        t = e.scrollTop; 
        l = e.scrollLeft; 
        w = e.scrollWidth; 
        h = e.scrollHeight; 
    } else { 
        if (document.documentElement && document.documentElement.scrollTop) { 
            t = document.documentElement.scrollTop; 
            l = document.documentElement.scrollLeft; 
            w = document.documentElement.scrollWidth; 
            h = document.documentElement.scrollHeight; 
        } else if (document.body) { 
            t = document.body.scrollTop; 
            l = document.body.scrollLeft; 
            w = document.body.scrollWidth; 
            h = document.body.scrollHeight; 
        } 
    } 
    return { t: t, l: l, w: w, h: h }; 
};

lazyloadpositions = [];

lazyRefresh = function() {
        var Y = $.getScroll().t;
        // filter spurious scroll events for Webkit based browsers
        if(lazyload_lastScrollPosition != Y ) {
		window.clearTimeout(lazyload_lastScrollTimer);
		lazyload_lastScrollTimer = window.setTimeout(function(){
        		var Y = $.getScroll().t;
                	var H = $(window).height();
			var from = Math.floor(Y/100);
			var to = Math.ceil((Y+H)/100);
			var el;
			for(from; from < to; from++) {
				if(lazyloadpositions[from]){
				 while(lazyloadpositions[from].length){
				   el = lazyloadpositions[from].pop();
				  
 				   $(el).attr("src", $(el).attr("highsrc"));				      
				 }
				};
			}
			
		},450);
	}; 

	lazyload_lastScrollPosition = Y;
};

lazyloadels = [];
lazyCache = function(el) {
	var pos = jQuery(el).offset();
	var rY = Math.floor(pos.top/100);
	lazyloadpositions[rY] ? lazyloadpositions[rY].push(el) : lazyloadpositions[rY] = [el];  
};

lazyLoadParse = function () {
	var loop = 0;
	while(lazyloadels.length && loop < 50) {
		var el = lazyloadels.shift();
		lazyCache(el);	
		loop++;
	}
	if(lazyloadels.length) {
		setTimeout(arguments.callee,10);
	} 
}

lazyLoad = function () {
	jQuery('.lazyload img').each(function(){
          lazyloadels.push(this);
	});
	lazyLoadParse(); 
	$(window).scroll(lazyRefresh);
	lazyRefresh();
}

$(document).ready(function(){
  lazyload_lastScrollTimer = -1;
  lazyload_lastScrollPosition = -1;
  lazyLoad();
});


})(jQuery);

    

