var eMend = {
  config: {
    comment_target: '#testo_atto',
    baseURI: "/sfEmendPlugin/",                            // load eMend assets from this URI
    backstore_tiddly: true,                                // enable/disable tiddly backstore
    backstore_sfEmendPlugin: true,                         // enable/disable symfony plugin backstore
    scroll_refresh_delay: true,                            // delay comments visual link refresh to save CPU cycles
    jquery_noconflict: true,                               // enable/disable jQuery no conflict mode
    jquery_googleapis: false,                              // enable/disable loading jQuery from googleapis
    jquery_min_version: '1.2.6',                           // minimum version of jQuery
    debug: true                                            // enable/disable uncompressed scripts inclusion for debug
  }
};	

function eMendBoot() {
    
    var cfg = eMend.config
      , jq_required = true
      , eMend_required = !(typeof eMend != 'undefined' && eMend.status)
      , v
    ;
			
	if(typeof jQuery != 'undefined' && jQuery.fn && jQuery.fn.jquery) {
		v = jQuery.fn.jquery.split('.');
		jq_required = !(v.length = 3 && Number(v[0]) >= 1 && Number(v[1]) >= 2 && Number(v[2]) >= 6);
	}

    // include jQuery library if needed
	if(jq_required) {
		var head = document.getElementsByTagName('head')[0]
		  , js = document.createElement('script')
          , jqbaseURI = cfg.jquery_googleapis ? 'http://ajax.googleapis.com/ajax/libs/jquery/' : cfg.baseURI+'js/libs/jquery/'
          , jqfile = cfg.debug ? '/jquery.js' : '/jquery.min.js';          
		
        js.language = 'text/javascript';
        js.src =  jqbaseURI + cfg.jquery_min_version + jqfile;
		document.getElementsByTagName('head')[0].appendChild(js);
		
		if(cfg.jquery_noconflict) {
		  var nc = document.createElement('script');
		  nc.language = 'text/javascript';
		  nc.innerHTML = 'jQuery.noConflict();';
		  document.getElementsByTagName('head')[0].appendChild(nc);
		}
	}
	
	if(eMend_required) {
        var emfile = cfg.debug ? '/e-Mend_dist' : '/e-Mend_dist-yui';
		var css = document.createElement('link');
		css.rel = 'stylesheet';
		css.type = 'text/css';
		css.href = cfg.baseURI+'css'+emfile+'.css';
		var head = document.getElementsByTagName('head')[0];
		head.insertBefore(css,head.lastChild);
				
		var js = document.createElement('script');
		js.language = 'text/javascript';
		js.src = cfg.baseURI+'js'+emfile+'.js';
		head.insertBefore(js,head.lastChild);
	}		
	
	/*
	var scr = document.getElementsByTagName('script');
	for (var i=0, l=scr.length; i<l; i++) {
		if(scr[i].src.indexOf('emend.boot') != -1) scr[i].parentNode.removeChild(scr[i]);
	}
	*/
};

eMendBoot();
