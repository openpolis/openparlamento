var eMend = {
  config: {
    comment_target: '#testo_atto',
    baseURI: "/sfEmendPlugin/",                            // load eMend assets from this URI
    backstore_tiddly: true,                                // enable/disable tiddly backstore
    backstore_sfEmendPlugin: true,                         // enable/disable symfony plugin backstore
    scroll_refresh_delay: true,                            // delay comments visual link refresh to save CPU cycles
    jquery_noconflict: true,                               // enable/disable jQuery no conflict mode
    jquery_googleapis: false,                              // enable/disable loading jQuery from googleapis
    jquery_min_version: '1.3.1',                           // minimum version of jQuery
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
          
          if(typeof eMendInit != 'undefined' && eMendInit == true) {
            js.language = 'text/javascript';
            js.src =  jqbaseURI + cfg.jquery_min_version + jqfile;
            document.getElementsByTagName('head')[0].appendChild(js);            
          } else {
            document.write('<script type="text/javascript" src="'+jqbaseURI + cfg.jquery_min_version + jqfile+'"><\/script>');    
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

          if(typeof eMendInit != 'undefined' && eMendInit == true) {  
            var js = document.createElement('script');
            js.language = 'text/javascript';
            js.src = cfg.baseURI+'js'+emfile+'.js';         
            head.insertBefore(js,head.lastChild);            
          } else {
            document.write('<script type="text/javascript" src="'+cfg.baseURI+'js'+emfile+'.js'+'"><\/script>');
          }
	}
    	
};

eMendBoot();

