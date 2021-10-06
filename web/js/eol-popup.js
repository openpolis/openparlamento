function EOLsetCookie(e,t,n){var o=new Date;o.setTime(o.getTime()+24*n*60*60*1e3);var i="expires="+o.toGMTString();document.cookie=e+"="+t+";"+i+";path=/"}
function EOLgetCookie(e){for(var t=e+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}

if (!EOLgetCookie("EOLPopupShown201903")) {
    var EOLnotice = GLightbox();
    EOLnotice.setElements([{'href': '/img/op_questionario.png', 'type': 'image'}]);
    EOLnotice.open();

    EOLsetCookie("EOLPopupShown201903", true, 2);
    jQuery('.gslide-media').css({cursor:'pointer'}).click(function(){
    	window.location = 'http://swg.it/openpolisC'
    })
}


