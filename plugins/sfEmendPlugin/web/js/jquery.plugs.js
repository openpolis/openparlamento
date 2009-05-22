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
}; (function($) { 

$.escapeReturns = function(text){
//console.log(text);
    text = escape(text); //encode text string's carriage returns
    
    for(i=0; i<text.length; i++){
    
        if(text.indexOf("%0D%0A") > -1){
            //Windows encodes returns as \r\n hex
            text=text.replace("%0D%0A","<br/>");
        } else if(text.indexOf("%0A") > -1){
            //Unix encodes returns as \n hex
            text=text.replace("%0A","<br/>");
        } else if(text.indexOf("%0D") > -1){
            //Macintosh encodes returns as \r hex
            text=text.replace("%0D","<br/>");
        }
    }
    
    text = unescape(text); //unescape all other encoded characters
//console.log(text);    
    return text;
}

})(jQuery);(function($) {
    $.fixOperaRangeSelectionBug = function ()
    {
        
        function isNbsp(textNode)
        {
            if (textNode.nodeType != 3)
                return false;
            var pat = /\u00A0/;
            return textNode.nodeValue.match(pat);
        }    
        
        var brCollection = document.body.getElementsByTagName('br');
        for (var num1 = 0;num1 < brCollection.length; num1++)
        {
            var br = brCollection[num1];
            var prevSibling = br.previousSibling;
            if (prevSibling != null)
            {
                var hasNbsp = isNbsp(prevSibling);
                if (!hasNbsp)
                {
                    // insert the invisible non-breaking-whitespace
                    br.parentNode.insertBefore(document.createTextNode('\u00A0'), br);
                }
            }
        }
    }
})(jQuery);
//This plugin is a workaround for an Opera >= 9.50 bug witch returns wrong window width and height sizes
if(jQuery && jQuery.browser.opera && jQuery.browser.version >= 9.50) {
    var height_ = jQuery.fn.height;
    jQuery.fn.height = function() {
        if ( this[0] == window )
            return window.innerHeight;
        else return height_.apply(this,arguments);
    };
    var width_ = jQuery.fn.width;
    jQuery.fn.width = function() {
        if ( this[0] == window )
            return window.innerWidth;
        else return width_.apply(this,arguments);
    };
};/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 *//*
 * jQuery Easing Compatibility v1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 *
 * Adds compatibility for applications that use the pre 1.2 easing names
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery.extend( jQuery.easing,
{
	easeIn: function (x, t, b, c, d) {
		return jQuery.easing.easeInQuad(x, t, b, c, d);
	},
	easeOut: function (x, t, b, c, d) {
		return jQuery.easing.easeOutQuad(x, t, b, c, d);
	},
	easeInOut: function (x, t, b, c, d) {
		return jQuery.easing.easeInOutQuad(x, t, b, c, d);
	},
	expoin: function(x, t, b, c, d) {
		return jQuery.easing.easeInExpo(x, t, b, c, d);
	},
	expoout: function(x, t, b, c, d) {
		return jQuery.easing.easeOutExpo(x, t, b, c, d);
	},
	expoinout: function(x, t, b, c, d) {
		return jQuery.easing.easeInOutExpo(x, t, b, c, d);
	},
	bouncein: function(x, t, b, c, d) {
		return jQuery.easing.easeInBounce(x, t, b, c, d);
	},
	bounceout: function(x, t, b, c, d) {
		return jQuery.easing.easeOutBounce(x, t, b, c, d);
	},
	bounceinout: function(x, t, b, c, d) {
		return jQuery.easing.easeInOutBounce(x, t, b, c, d);
	},
	elasin: function(x, t, b, c, d) {
		return jQuery.easing.easeInElastic(x, t, b, c, d);
	},
	elasout: function(x, t, b, c, d) {
		return jQuery.easing.easeOutElastic(x, t, b, c, d);
	},
	elasinout: function(x, t, b, c, d) {
		return jQuery.easing.easeInOutElastic(x, t, b, c, d);
	},
	backin: function(x, t, b, c, d) {
		return jQuery.easing.easeInBack(x, t, b, c, d);
	},
	backout: function(x, t, b, c, d) {
		return jQuery.easing.easeOutBack(x, t, b, c, d);
	},
	backinout: function(x, t, b, c, d) {
		return jQuery.easing.easeInOutBack(x, t, b, c, d);
	}
});(function($) {
	
  // removes whitespace-only text node childrens
	$.fn.cleanWhitespace = function(deep) {
		// white space chars
		
		var element = this[0];
		if ($(element).hasClass('keep-whitespace')) return element;
		var node = element.firstChild;
		while (node) {
			//console.log(node.nodeType);
			var nextNode = node.nextSibling;
			
			if (node.nodeType == 3) {
				if(!/\S/.test(node.nodeValue)) {
					element.removeChild(node);
				} else {
					var str = node.nodeValue;
					str = str.replace(/[\t\n\r\f]/g,'');
					/*
					var start = -1, end = str.length;
					while( str.charCodeAt(--end) < 33 );
					while( str.charCodeAt(++start) < 33 );
					str = str.slice( start, end + 1 );
				*/
					str = str.replace(/\ {2,}/g,' ');
					str = str.replace(/^\ */,'');
					node.nodeValue = str;
				}
			} else if(deep && node.nodeType == 1) {
				$(node).cleanWhitespace(deep);
			}
			//console.log('^'+node.nodeValue+'^');
			node = nextNode;
		}
		return element;
	}
})(jQuery);/* from http://dev.jquery.com/browser/trunk/plugins/textNodes/jquery.textNodes.js
   Send comments to jakecigar@gmail.com
*/

(function($) {
	$.fn.textNodes = function(deep) {
				var text=[];
				this.each(function(){
						var children = this.childNodes;
						for (var i = 0; i < children.length; i++){
								var child = children[i];
								if (child.nodeType == 3)
										text.push(child);
								else if (deep && child.nodeType == 1)
										Array.prototype.push.apply(text,jQuery(child).textNodes(deep,true));
										// [].push.apply(texts,$(child).textNodes(deep,true));
						}
				});
				return arguments[1] ? text : this.pushStack(text);
	};
	
})(jQuery);/*
 * jQuery getSelection plugin
 *
 * returns an object with the current text selection coordinates
 * (startContainer, startOffset, endContainer, endOffset)
 * Version: 0.1 (08/30/2008)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */

(function($) {
      
  $.getSelectedText = function() {
		if (window.getSelection) {
            var userSelection = window.getSelection();
            return userSelection.toString();
        } else if (document.selection) {
			var userSelection = document.selection,
			r = userSelection.createRange();
			return r.text;
        }
  }

  $.getSelection = function(reset) {
		if (window.getSelection) {
			var userSelection = window.getSelection();
			if (false && userSelection.getRangeAt) {
				var	r = userSelection.getRangeAt(0);
			} else { // Safari!
				var r = document.createRange();
				r.setStart(userSelection.anchorNode,userSelection.anchorOffset);
				r.setEnd(userSelection.focusNode,userSelection.focusOffset);
			}

			r1 = r.cloneRange(),
			r2 = r.cloneRange();
			r1.collapse(true); r2.collapse(false);
			
			var startContainer = r1.startContainer,
			endContainer = r2.endContainer,
			startOffset = r1.startOffset,
			endOffset = r2.endOffset,
			selectedText = userSelection.toString();
			
//=================================================
//console.log("startContainer: ",startContainer);
//console.log("endContainer",endContainer);
//=================================================  			
			
			if(startContainer.nodeType == 1) {
			  startContainer = $(startContainer).textNodes(true)[startOffset];
			  startOffset = 0;
			}
			
			if(endContainer.nodeType == 1) {
			  var t = $(endContainer).textNodes(true);
			  var stL = selectedText.length;
			  var pMatch = '', tmpMatch = '', idxMatch = -1;
			  maxcount = 0;

			  
			  var nodeText = '';
			  for(var i=0, len=Number(t.length); i<len; i++) {
				tn = t[i].data.replace(/\s/g,' ');
				tnL = tn.length;
				pMatch = selectedText.substr(stL-tnL).replace(/\s/g,' ');

				for(var j=i-1; tn == pMatch; j--) {
				  tn = t[j].data.replace(/\s/g,' ') + tn;
				  tnL = tn.length;
				  //console.log(stL,tn.length);
				  pMatch = selectedText.substr(stL-tnL).replace(/\s/g,' ');

				  if(tn.indexOf(pMatch) != -1 || pMatch.indexOf(tn) != -1 ) {
				  console.log(tn)
				  console.log(pMatch);				  					
					console.log('>>>>>>>>>>>>>>>>>>>');
				  }
				}
			  }

			  
			  endContainer = t[idxMatch];
			  endOffset = endContainer.length;
			}			
			
			if(reset) userSelection.removeAllRanges();
								
		} else if (document.selection) {

			var userSelection = document.selection,
			r = userSelection.createRange();
            
			var selectedText = r.text;
            if(selectedText.length == 0) return null;
            
            var r1 = r.duplicate(), r2 = r.duplicate();
			r1.collapse(true); r2.collapse(false);
			
			var startParent = r1.parentElement();
			var endParent = r2.parentElement();
			
			var v = document.body.createTextRange(),
            len = v.text.length;
			v.moveToElementText(startParent);
			v.collapse(true);
			var startOffset = 0;

			// while(r.inRange(v) == false && startOffset < len) {
			while(r.compareEndPoints('StartToStart',v) != 0 && startOffset < len) {
				startOffset++;
				v.move('character');
			}
			
			v.moveToElementText(endParent);
            len = v.text.length;
			v.collapse(true);
			var endOffset = 0;

			// while(r2.inRange(v) == false && endOffset < len) {
			while(r.compareEndPoints('EndToEnd',v) != 0 && endOffset < len) {
				endOffset++;
				v.move('character');
			}
			
			var startSiblings = $(startParent).textNodes(true),
			startContainer;
//=================================================
//console.log(startParent.innerHTML,startSiblings.length);
//=================================================
			if(startSiblings.length == 1) {
				startContainer = startSiblings[0];
			} else {	
				var Sidx = 0, chrSum = 0, prevSum = 0;
				while(chrSum <= startOffset) {
					prevSum = chrSum;						
					chrSum += startSiblings[Sidx].length;
					Sidx++;
				}
				startOffset -= prevSum;
				startContainer = startSiblings[--Sidx];
			}
			
			var endSiblings = $(endParent).textNodes(true),
			endContainer;
//=================================================
//console.log(endParent.innerHTML,endSiblings.length);
//=================================================
			if(endSiblings.length == 1) {
				endContainer = endSiblings[0];
			} else {
				var Eidx = 0, chrSum = 0, prevSum = 0;
				while(chrSum <= endOffset && Eidx < endSiblings.length) {
					prevSum = chrSum;						
					chrSum += endSiblings[Eidx].length;
					Eidx++;
				}
				endOffset -= prevSum;
				endContainer = endSiblings[--Eidx];
			}
			endOffset = Math.min(endOffset, endContainer.length);

			if(reset) userSelection.empty();
		}
		
		if(startContainer != endContainer || startOffset != endOffset) {
			var sObj = {startContainer: startContainer,
							endContainer: endContainer,
							startOffset: startOffset,
							endOffset: endOffset,
							text: selectedText
			}
			//console.log(sObj);
			return sObj;
		} else {
			return null;
		}
	}
})(jQuery);
(function($) { 

  $.create = function() {
    var ret = [], a = arguments, i, e;
    a = a[0].constructor == Array ? a[0] : a;
    for(i=0; i<a.length; i++) {
      if(a[i+1] && a[i+1].constructor == Object) { // item is element if attributes follow
        e = document.createElement(a[i]);
        $(e).attr(a[++i]); // apply attributes
        if(a[i+1] && a[i+1].constructor == Array) $(e).append($.create(a[++i])); // optional children
        ret.push(e);
      } else { // item is just a text node
        ret.push(document.createTextNode(a[i]));
      }
    }
    return ret;
  };
  
  $.tpl = function(json, tpl) {
    var ret = [];
    jQuery.each(json.constructor == Array ? json : [json], function() {
      var o = $.create(tpl.apply(this));
      for(var i=0;i<o.length;i++) ret.push(o[i]);
    });
    return ret;
  };

})(jQuery);

/**
 * jQuery Templates
 *
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Written by: Stan Lemon <stanlemon@mac.com>
 *
 * Based off of the Ext.Template library, available at:
 * http://www.extjs.com
 *
 * This library provides basic templating functionality, allowing for macro-based
 * templates within jQuery.
 *
 * Basic Usage:
 *
 * var t = $.template('<div id="foo">Hello ${name}, how are you ${question}?  I am ${me:substr(0,10)}</div>');
 *
 * $(selector).append( t , {
 *     name: 'Stan',
 *     question: 'feeling',
 *     me: 'doing quite well myself, thank you very much!'
 * });
 *
 * Requires: jQuery 1.2+
 *
 *
 * @todo    Add callbacks to the DOM manipulation methods, so that events can be bound
 *          to template nodes after creation.
 */
(function($){
	
	/**
	 * Create a New Template
	 */
	$.template = function(html, options) {
		return new $.template.instance(html, options);
	};

	/**
	 * Template constructor - Creates a new template instance.
	 *
	 * @param 	html 	The string of HTML to be used for the template.
	 * @param 	options An object of configurable options.  Currently
	 * 			you can toggle compile as a boolean value and set a custom
	 *          template regular expression on the property regx by
	 *          specifying the key of the regx to use from the regx object.
	 */
	$.template.instance = function(html, options) {
        // If a custom regular expression has been set, grab it from the regx object
        if ( options && options['regx'] ) options.regx = this.regx[ options.regx ];

		this.options = $.extend({
			compile: 		false,
			regx:           this.regx.standard
		}, options || {});

		this.html = html;

		if (this.options.compile) {
			this.compile();   
		}
		this.isTemplate = true;
	};

	/**
	 * Regular Expression for Finding Variables
	 *
	 * The default pattern looks for variables in JSP style, the form of: ${variable}
	 * There are also regular expressions available for ext-style variables and
	 * jTemplate style variables.
	 *
	 * You can add your own regular expressions for variable ussage by doing.
	 * $.extend({ $.template.re , {
	 *     myvartype: /...../g
	 * }
	 *
	 * Then when creating a template do:
	 * var t = $.template("<div>...</div>", { regx: 'myvartype' });
	 */
	$.template.regx = $.template.instance.prototype.regx = {
	    jsp:        /\$\{([\w-]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?\}/g,
        ext:        /\{([\w-]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?\}/g,
        jtemplates: /\{\{([\w-]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?\}\}/g
	};
	
	$.extend( $.template.regx , {	gettext: /\_\(([\w-]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?\)/g });	
	
	/**
	 * Set the standard regular expression to be used.
	 */
	$.template.regx.standard = $.template.regx.jsp;
	
	/**
	 * Variable Helper Methods
	 *
	 * This is a collection of methods which can be used within the variable syntax, ie:
	 * ${variable:substr(0,30)} Which would only print a substring, 30 characters in length
	 * begining at the first character for the variable named "variable".
	 *
	 * A basic substring helper is provided as an example of how you can define helpers.
	 * To add more helpers simply do:
	 * $.extend( $.template.helpers , {
	 *	 sampleHelper: function() { ... }	
	 * });
	 */
	$.template.helpers = $.template.instance.prototype.helpers = {
		substr : function(value, start, length){
			return String(value).substr(start, length);
		}
	};


	/**
	 * Template Instance Methods
	 */
	$.extend( $.template.instance.prototype, {
		
		/**
		 * Apply Values to a Template
		 *
		 * This is the macro-work horse of the library, it receives an object
		 * and the properties of that objects are assigned to the template, where
		 * the variables in the template represent keys within the object itself.
		 *
		 * @param 	values 	An object of properties mapped to template variables
		 */
		apply: function(values) {
			if (this.options.compile) {
				return this.compiled(values);
			} else {
				var tpl = this;
				var fm = this.helpers;

				var fn = function(m, name, format, args) {
					if (format) {
						if (format.substr(0, 5) == "this."){
							return tpl.call(format.substr(5), values[name], values);
						} else {
							if (args) {
								// quoted values are required for strings in compiled templates, 
								// but for non compiled we need to strip them
								// quoted reversed for jsmin
								var re = /^\s*['"](.*)["']\s*$/;
								args = args.split(',');

								for(var i = 0, len = args.length; i < len; i++) {
									args[i] = args[i].replace(re, "$1");
								}
								args = [values[name]].concat(args);
							} else {
								args = [values[name]];
							}

							return fm[format].apply(fm, args);
						}
					} else {
						return values[name] !== undefined ? values[name] : "";
					}
				};

				return this.html.replace(this.options.regx, fn);
			}
		},

		/**
		 * Compile a template for speedier usage
		 */
		compile: function() {
			var sep = $.browser.mozilla ? "+" : ",";
			var fm = this.helpers;

			var fn = function(m, name, format, args){
				if (format) {
					args = args ? ',' + args : "";

					if (format.substr(0, 5) != "this.") {
						format = "fm." + format + '(';
					} else {
						format = 'this.call("'+ format.substr(5) + '", ';
						args = ", values";
					}
				} else {
					args= ''; format = "(values['" + name + "'] == undefined ? '' : ";
				}
				return "'"+ sep + format + "values['" + name + "']" + args + ")"+sep+"'";
			};

			var body;

			if ($.browser.mozilla) {
				body = "this.compiled = function(values){ return '" +
					   this.html.replace(/\\/g, '\\\\').replace(/(\r\n|\n)/g, '\\n').replace(/'/g, "\\'").replace(this.options.regx, fn) +
						"';};";
			} else {
				body = ["this.compiled = function(values){ return ['"];
				body.push(this.html.replace(/\\/g, '\\\\').replace(/(\r\n|\n)/g, '\\n').replace(/'/g, "\\'").replace(this.options.regx, fn));
				body.push("'].join('');};");
				body = body.join('');
			}
			eval(body);
			return this;
		}
	});


	/**
	 * Save a reference in this local scope to the original methods which we're 
	 * going to overload.
	 **/
	var $_old = {
	    domManip: $.fn.domManip,
	    text: $.fn.text,
	    html: $.fn.html
	};

	/**
	 * Overwrite the domManip method so that we can use things like append() by passing a 
	 * template object and macro parameters.
	 */
	$.fn.domManip = function( args, table, reverse, callback ) {
		if (args[0].isTemplate) {
			// Apply the template and it's arguments...
			args[0] = args[0].apply( args[1] );
			// Get rid of the arguements, we don't want to pass them on
			delete args[1];
		}

		// Call the original method
		var r = $_old.domManip.apply(this, arguments);

		return r;
	};

    /**
     * Overwrite the html() method
     */
	$.fn.html = function( value , o ) {
	    if (value && value.isTemplate) var value = value.apply( o );

		var r = $_old.html.apply(this, [value]);

		return r;
	};
	
	/**
	 * Overwrite the text() method
	 */
	$.fn.text = function( value , o ) {
	    if (value && value.isTemplate) var value = value.apply( o );

		var r = $_old.text.apply(this, [value]);

		return r;
	};

})(jQuery);


/* ***** BEGIN LICENSE BLOCK *****
 * Version: MPL 1.1/GPL 2.0/LGPL 2.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * The Original Code is XPather - a firefox extension.
 *
 * The Initial Developer of the Original Code is
 * Viktor Zigo <xpather@alephzarro.com>.
 * Portions created by the Initial Developer are Copyright (C) 2005
 * the Initial Developer. All Rights Reserved.
 *
 * Contributor(s):
 * Alessandro Curci <htrex@memefarmers.net> - jQuery wrapper
 *
 * Alternatively, the contents of this file may be used under the terms of
 * either the GNU General Public License Version 2 or later (the "GPL"), or
 * the GNU Lesser General Public License Version 2.1 or later (the "LGPL"),
 * in which case the provisions of the GPL or the LGPL are applicable instead
 * of those above. If you wish to allow use of your version of this file only
 * under the terms of either the GPL or the LGPL, and not to allow others to
 * use your version of this file under the terms of the MPL, indicate your
 * decision by deleting the provisions above and replace them with the notice
 * and other provisions required by the GPL or the LGPL. If you do not delete
 * the provisions above, a recipient may use your version of this file under
 * the terms of any one of the MPL, the GPL or the LGPL.
 *
 * ***** END LICENSE BLOCK ***** */
 
 /* XPather,  Author: Viktor Zigo, http://xpath.alephzarro.com */
 
(function($) {
					
$.fn.generateXPath = function(options){
	
	$.fn.generateXPath.defaults = {
		depth:0,
		maxDepth: 99,
		context: document.body,
		namespace: null,
		kwds: { showId: 1 }
	};	

	var o = $.extend({}, $.fn.generateXPath.defaults, options );
	return walkUp(this[0], o.depth, o.maxDepth, o.context, o.namespace, o.kwds);

	function walkUp(node, depth, maxDepth, aSentinel, aDefaultNS, kwds)
	{
		var str = "";
		if(!node) return "";
		if(node==aSentinel) return ".";
		if((node.parentNode) && (depth < maxDepth)) {
			str += walkUp(node.parentNode, depth + 1, maxDepth, aSentinel, aDefaultNS, kwds);
		}

		switch (node.nodeType) {
			case 1:{
			// Node.ELEMENT_NODE
				var nname = node.nodeName;
				var conditions = [];
				var hasid = false;
				if (kwds['showClass'] && $(node).attr('class')) conditions.push("@class='"+node.getAttribute('class')+"'");
				if (kwds['showId'] && $(node).attr('id')) {
						conditions.push("@id='"+node.getAttribute('id')+"'");
						hasid = true;
				}
						
				//not identified by id?
				if(!hasid){
						var index = siblingIndex(node);
						//more than one sibling?
						if (index) {
								//are there also other conditions?
								if (conditions.length>0) conditions.push('position()='+index);
								else conditions.push(index);
						}
	
				}
				if (kwds['showNS']){
						if(node.prefix) nname=node.prefix+":"+nname;
						else if (aDefaultNS) nname="default:"+nname;
				}
				if (kwds['toLowercase']) nname=nname.toLowerCase();
				str += "/"+nname;
				
				if(conditions.length>0){
						str+="[";
						for(var i=0;i<conditions.length; i++){
								if (i>0) str+=' and ';
								str+=conditions[i];
						}
						str+="]";
				}
				break;
			}
			case 9:{
			// Node.DOCUMENT_NODE
				break;
			}
			case 3:{
			// Node.TEXT_NODE
				str+='/text()';
				var index = siblingIndex(node);
				if (index) str+="["+index+"]";
				break;
			}				
		}
		return str;            
	}
	
	// gets index of aNode (relative to other same-tag siblings)
	// first position = 1; returns null if the component is the only one 
	function siblingIndex(aNode){
		var siblings = aNode.parentNode.childNodes;
		var allCount = 0;
		var position;

		if (aNode.nodeType==1){ //Node.ELEMENT_NODE
			var name = aNode.nodeName;
			for (var i=0; i<siblings.length; i++){
				var node = siblings.item(i);
				if (node.nodeType==1){ //Node.ELEMENT_NODE
					if (node.nodeName == name) allCount++;  //nodeName includes namespace
					if (node == aNode) position = allCount;
				}
			}
		}
		else if (aNode.nodeType==3){ //Node.TEXT_NODE
			for (var i=0; i<siblings.length; i++){
				var node = siblings.item(i);
				if (node.nodeType==3){ //Node.TEXT_NODE
					allCount++;
					if (node == aNode) position = allCount;
				}
			}
		}
		if (allCount>1) return position;
	}
}
})(jQuery);

/*  
===============================================================================
WResize is the jQuery plugin for fixing the IE window resize bug
...............................................................................
                                               Copyright 2007 / Andrea Ercolino
-------------------------------------------------------------------------------
LICENSE: http://www.opensource.org/licenses/mit-license.php
WEBSITE: http://noteslog.com/
===============================================================================
*/

( function( $ ) 
{
	$.fn.wresize = function( f ) 
	{
		version = '1.1';
		wresize = {fired: false, width: 0};

		function resizeOnce() 
		{
			if ( $.browser.msie )
			{
				if ( ! wresize.fired )
				{
					wresize.fired = true;
				}
				else 
				{
					var version = parseInt( $.browser.version, 10 );
					wresize.fired = false;
					if ( version < 7 )
					{
						return false;
					}
					else if ( version == 7 )
					{
						//a vertical resize is fired once, an horizontal resize twice
						var width = $( window ).width();
						if ( width != wresize.width )
						{
							wresize.width = width;
							return false;
						}
					}
				}
			}

			return true;
		}

		function handleWResize( e ) 
		{
			if ( resizeOnce() )
			{
				return f.apply(this, [e]);
			}
		}

		this.each( function() 
		{
			if ( this == window )
			{
				$( this ).resize( handleWResize );
			}
			else
			{
				$( this ).resize( f );
			}
		} );

		return this;
	};

} ) ( jQuery );
(function($) {

$.textResizeDetector = function (options) {
  this.opts = $.extend({}, $.textResizeDetector.defaults, options);
  this.initialize();
};

$.textResizeDetector.defaults = {};

$.textResizeDetector.prototype = {
	id: 'ResizeDetector', 
	delay: 800,
    create: function() {
	  $('#'+this.id+'_text').remove();
      var sT = 'position: absolute; padding: 0; left: -9999px; font-size:'+30+'px; line-height:'+30+'px;';
      var sW = 'position: absolute; left: -9999px; width:10%; height:10%;';
      var elT = $.create('span',{'id':this.id+'_text','style':sT,'className':'write-protect'})[0];
      elT.innerHTML = '&nbsp;';
      var c = this.opts.target;
      c.appendChild(elT);
      this.sizeT = 30;
      return elT;
    },
	initialize: function() {
      this.create();
      this.check = window.setInterval(this.detect,this.delay);
	},
	
	detect: function() {
      //var newSizeT = this.getSize(this.id+'_text');
      var el = $('#ResizeDetector_text');
      if(!el.length) el = this.create();
      
      var newSizeT = el.height();
      //var newSizeW = this.getSize(this.id+'_win');

      if(newSizeT != this.sizeT) {
        var revertFactor = 30/newSizeT;
        $(document).trigger('textResize',revertFactor);
        this.sizeT = newSizeT;
        $('.fixedFontSize9').each(function(el){
            var f = Math.max(9*revertFactor,1);
            $(this).css({'fontSize':f+'px','lineHeight':f+'px'})
        });
        $('.fixedFontSize11').each(function(el){
            var f = Math.max(11*revertFactor,1);
            $(this).css({'fontSize':f+'px','lineHeight':f+'px'})
        });
        $('.fixedFontSize12').each(function(el){
            var f = Math.max(12*revertFactor,1);
            $(this).css({'fontSize':f+'px','lineHeight':f+'px'})
        });
      }
	}
}
})(jQuery);

/**
 * jQuery.ScrollTo
 * Copyright (c) 2007-2008 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 9/11/2008
 *
 * @projectDescription Easy element scrolling using jQuery.
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * Tested with jQuery 1.2.6. On FF 2/3, IE 6/7, Opera 9.2/5 and Safari 3. on Windows.
 *
 * @author Ariel Flesler
 * @version 1.4
 *
 * @id jQuery.scrollTo
 * @id jQuery.fn.scrollTo
 * @param {String, Number, DOMElement, jQuery, Object} target Where to scroll the matched elements.
 *	  The different options for target are:
 *		- A number position (will be applied to all axes).
 *		- A string position ('44', '100px', '+=90', etc ) will be applied to all axes
 *		- A jQuery/DOM element ( logically, child of the element to scroll )
 *		- A string selector, that will be relative to the element to scroll ( 'li:eq(2)', etc )
 *		- A hash { top:x, left:y }, x and y can be any kind of number/string like above.
 * @param {Number} duration The OVERALL length of the animation, this argument can be the settings object instead.
 * @param {Object,Function} settings Optional set of settings or the onAfter callback.
 *	 @option {String} axis Which axis must be scrolled, use 'x', 'y', 'xy' or 'yx'.
 *	 @option {Number} duration The OVERALL length of the animation.
 *	 @option {String} easing The easing method for the animation.
 *	 @option {Boolean} margin If true, the margin of the target element will be deducted from the final position.
 *	 @option {Object, Number} offset Add/deduct from the end position. One number for both axes or { top:x, left:y }.
 *	 @option {Object, Number} over Add/deduct the height/width multiplied by 'over', can be { top:x, left:y } when using both axes.
 *	 @option {Boolean} queue If true, and both axis are given, the 2nd axis will only be animated after the first one ends.
 *	 @option {Function} onAfter Function to be called after the scrolling ends. 
 *	 @option {Function} onAfterFirst If queuing is activated, this function will be called after the first scrolling ends.
 * @return {jQuery} Returns the same jQuery object, for chaining.
 *
 * @desc Scroll to a fixed position
 * @example $('div').scrollTo( 340 );
 *
 * @desc Scroll relatively to the actual position
 * @example $('div').scrollTo( '+=340px', { axis:'y' } );
 *
 * @dec Scroll using a selector (relative to the scrolled element)
 * @example $('div').scrollTo( 'p.paragraph:eq(2)', 500, { easing:'swing', queue:true, axis:'xy' } );
 *
 * @ Scroll to a DOM element (same for jQuery object)
 * @example var second_child = document.getElementById('container').firstChild.nextSibling;
 *			$('#container').scrollTo( second_child, { duration:500, axis:'x', onAfter:function(){
 *				alert('scrolled!!');																   
 *			}});
 *
 * @desc Scroll on both axes, to different values
 * @example $('div').scrollTo( { top: 300, left:'+=200' }, { axis:'xy', offset:-20 } );
 */
;(function( $ ){
	
	var $scrollTo = $.scrollTo = function( target, duration, settings ){
		$(window).scrollTo( target, duration, settings );
	};

	$scrollTo.defaults = {
		axis:'y',
		duration:1
	};

	// Returns the element that needs to be animated to scroll the window.
	// Kept for backwards compatibility (specially for localScroll & serialScroll)
	$scrollTo.window = function( scope ){
		return $(window).scrollable();
	};

	// Hack, hack, hack... stay away!
	// Returns the real elements to scroll (supports window/iframes, documents and regular nodes)
	$.fn.scrollable = function(){
		return this.map(function(){
			// Just store it, we might need it
			var win = this.parentWindow || this.defaultView,
				// If it's a document, get its iframe or the window if it's THE document
				elem = this.nodeName == '#document' ? win.frameElement || win : this,
				// Get the corresponding document
				doc = elem.contentDocument || (elem.contentWindow || elem).document,
				isWin = elem.setInterval;

			return elem.nodeName == 'IFRAME' || isWin && $.browser.safari ? doc.body
				: isWin ? doc.documentElement
				: this;
		});
	};

	$.fn.scrollTo = function( target, duration, settings ){
		if( typeof duration == 'object' ){
			settings = duration;
			duration = 0;
		}
		if( typeof settings == 'function' )
			settings = { onAfter:settings };
			
		settings = $.extend( {}, $scrollTo.defaults, settings );
		// Speed is still recognized for backwards compatibility
		duration = duration || settings.speed || settings.duration;
		// Make sure the settings are given right
		settings.queue = settings.queue && settings.axis.length > 1;
		
		if( settings.queue )
			// Let's keep the overall duration
			duration /= 2;
		settings.offset = both( settings.offset );
		settings.over = both( settings.over );

		return this.scrollable().each(function(){
			var elem = this,
				$elem = $(elem),
				targ = target, toff, attr = {},
				win = $elem.is('html,body');

			switch( typeof targ ){
				// A number will pass the regex
				case 'number':
				case 'string':
					if( /^([+-]=)?\d+(px)?$/.test(targ) ){
						targ = both( targ );
						// We are done
						break;
					}
					// Relative selector, no break!
					targ = $(targ,this);
				case 'object':
					// DOMElement / jQuery
					if( targ.is || targ.style )
						// Get the real position of the target 
						toff = (targ = $(targ)).offset();
			}
			$.each( settings.axis.split(''), function( i, axis ){
				var Pos	= axis == 'x' ? 'Left' : 'Top',
					pos = Pos.toLowerCase(),
					key = 'scroll' + Pos,
					old = elem[key],
					Dim = axis == 'x' ? 'Width' : 'Height',
					dim = Dim.toLowerCase();

				if( toff ){// jQuery / DOMElement
					attr[key] = toff[pos] + ( win ? 0 : old - $elem.offset()[pos] );

					// If it's a dom element, reduce the margin
					if( settings.margin ){
						attr[key] -= parseInt(targ.css('margin'+Pos)) || 0;
						attr[key] -= parseInt(targ.css('border'+Pos+'Width')) || 0;
					}
					
					attr[key] += settings.offset[pos] || 0;
					
					if( settings.over[pos] )
						// Scroll to a fraction of its width/height
						attr[key] += targ[dim]() * settings.over[pos];
				}else
					attr[key] = targ[pos];

				// Number or 'number'
				if( /^\d+$/.test(attr[key]) )
					// Check the limits
					attr[key] = attr[key] <= 0 ? 0 : Math.min( attr[key], max(Dim) );

				// Queueing axes
				if( !i && settings.queue ){
					// Don't waste time animating, if there's no need.
					if( old != attr[key] )
						// Intermediate animation
						animate( settings.onAfterFirst );
					// Don't animate this axis again in the next iteration.
					delete attr[key];
				}
			});			
			animate( settings.onAfter );			

			function animate( callback ){
				$elem.animate( attr, duration, settings.easing, callback && function(){
					callback.call(this, target, settings);
				});
			};
			function max( Dim ){
				var attr ='scroll'+Dim,
					doc = elem.ownerDocument;
				
				return win
						? Math.max( doc.documentElement[attr], doc.body[attr]  )
						: elem[attr];
			};
		}).end();
	};

	function both( val ){
		return typeof val == 'object' ? val : { top:val, left:val };
	};

})( jQuery );/*
 * jqModal - Minimalist Modaling with jQuery
 *   (http://dev.iceburg.net/jquery/jqmodal/)
 *
 * Copyright (c) 2007,2008 Brice Burgess <bhb@iceburg.net>
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 * 
 * $Version: 07/06/2008 +r13
 */
(function($) {
$.fn.jqm=function(o){
var p={
overlay: 50,
overlayClass: 'jqmOverlay',
closeClass: 'jqmClose',
trigger: '.jqModal',
ajax: F,
ajaxText: '',
target: F,
modal: F,
toTop: F,
onShow: F,
onHide: F,
onLoad: F
};
return this.each(function(){if(this._jqm)return H[this._jqm].c=$.extend({},H[this._jqm].c,o);s++;this._jqm=s;
H[s]={c:$.extend(p,$.jqm.params,o),a:F,w:$(this).addClass('jqmID'+s),s:s};
if(p.trigger)$(this).jqmAddTrigger(p.trigger);
});};

$.fn.jqmAddClose=function(e){return hs(this,e,'jqmHide');};
$.fn.jqmAddTrigger=function(e){return hs(this,e,'jqmShow');};
$.fn.jqmShow=function(t){return this.each(function(){$.jqm.open(this._jqm,t);});};
$.fn.jqmHide=function(t){return this.each(function(){$.jqm.close(this._jqm,t)});};

$.jqm = {
hash:{},
open:function(s,t){var h=H[s],c=h.c,cc='.'+c.closeClass,z=(parseInt(h.w.css('z-index'))),z=(z>0)?z:3000,o=$('<div></div>').css({height:'100%',width:'100%',position:'fixed',left:0,top:0,'z-index':z-1,opacity:c.overlay/100});if(h.a)return F;h.t=t;h.a=true;h.w.css('z-index',z);
 if(c.modal) {if(!A[0])L('bind');A.push(s);}
 else if(c.overlay > 0)h.w.jqmAddClose(o);
 else o=F;

 h.o=(o)?o.addClass(c.overlayClass).prependTo('body'):F;
 if(ie6){$('html,body').css({height:'100%',width:'100%'});if(o){o=o.css({position:'absolute'})[0];for(var y in {Top:1,Left:1})o.style.setExpression(y.toLowerCase(),"(_=(document.documentElement.scroll"+y+" || document.body.scroll"+y+"))+'px'");}}

 if(c.ajax) {var r=c.target||h.w,u=c.ajax,r=(typeof r == 'string')?$(r,h.w):$(r),u=(u.substr(0,1) == '@')?$(t).attr(u.substring(1)):u;
  r.html(c.ajaxText).load(u,function(){if(c.onLoad)c.onLoad.call(this,h);if(cc)h.w.jqmAddClose($(cc,h.w));e(h);});}
 else if(cc)h.w.jqmAddClose($(cc,h.w));

 if(c.toTop&&h.o)h.w.before('<span id="jqmP'+h.w[0]._jqm+'"></span>').insertAfter(h.o);	
 (c.onShow)?c.onShow(h):h.w.show();e(h);return F;
},
close:function(s){var h=H[s];if(!h.a)return F;h.a=F;
 if(A[0]){A.pop();if(!A[0])L('unbind');}
 if(h.c.toTop&&h.o)$('#jqmP'+h.w[0]._jqm).after(h.w).remove();
 if(h.c.onHide)h.c.onHide(h);else{h.w.hide();if(h.o)h.o.remove();} return F;
},
params:{}};
var s=0,H=$.jqm.hash,A=[],ie6=$.browser.msie&&($.browser.version == "6.0"),F=false,
i=$('<iframe src="javascript:false;document.write(\'\');" class="jqm"></iframe>').css({opacity:0}),
e=function(h){if(ie6)if(h.o)h.o.html('<p style="width:100%;height:100%"/>').prepend(i);else if(!$('iframe.jqm',h.w)[0])h.w.prepend(i); f(h);},
f=function(h){try{$(':input:visible',h.w)[0].focus();}catch(_){}},
L=function(t){$()[t]("keypress",m)[t]("keydown",m)[t]("mousedown",m);},
m=function(e){var h=H[A[A.length-1]],r=(!$(e.target).parents('.jqmID'+h.s)[0]);if(r)f(h);return !r;},
hs=function(w,t,c){return w.each(function(){var s=this._jqm;$(t).each(function() {
 if(!this[c]){this[c]=[];$(this).click(function(){for(var i in {jqmShow:1,jqmHide:1})for(var s in this[i])if(H[this[i][s]])H[this[i][s]].w[i](this);return F;});}this[c].push(s);});});};
})(jQuery);/**
 * jGrowl 1.1.1
 *
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Written by Stan Lemon <stanlemon@mac.com>
 * Last updated: 2008.08.17
 *
 * jGrowl is a jQuery plugin implementing unobtrusive userland notifications.  These 
 * notifications function similarly to the Growl Framework available for
 * Mac OS X (http://growl.info).
 *
 * To Do:
 * - Move library settings to containers and allow them to be changed per container
 *
 * Changes in 1.1.1
 * - Fixed CSS styling bug for ie6 caused by a mispelling
 * - Changes height restriction on default notifications to min-height
 * - Added skinned examples using a variety of images
 * - Added the ability to customize the content of the [close all] box
 * - Added jTweet, an example of using jGrowl + Twitter
 *
 * Changes in 1.1.0
 * - Multiple container and instances.
 * - Standard $.jGrowl() now wraps $.fn.jGrowl() by first establishing a generic jGrowl container.
 * - Instance methods of a jGrowl container can be called by $.fn.jGrowl(methodName)
 * - Added glue preferenced, which allows notifications to be inserted before or after nodes in the container
 * - Added new log callback which is called before anything is done for the notification
 * - Corner's attribute are now applied on an individual notification basis.
 *
 * Changes in 1.0.4
 * - Various CSS fixes so that jGrowl renders correctly in IE6.
 *
 * Changes in 1.0.3
 * - Fixed bug with options persisting across notifications
 * - Fixed theme application bug
 * - Simplified some selectors and manipulations.
 * - Added beforeOpen and beforeClose callbacks
 * - Reorganized some lines of code to be more readable
 * - Removed unnecessary this.defaults context
 * - If corners plugin is present, it's now customizable.
 * - Customizable open animation.
 * - Customizable close animation.
 * - Customizable animation easing.
 * - Added customizable positioning (top-left, top-right, bottom-left, bottom-right, center)
 *
 * Changes in 1.0.2
 * - All CSS styling is now external.
 * - Added a theme parameter which specifies a secondary class for styling, such
 *   that notifications can be customized in appearance on a per message basis.
 * - Notification life span is now customizable on a per message basis.
 * - Added the ability to disable the global closer, enabled by default.
 * - Added callbacks for when a notification is opened or closed.
 * - Added callback for the global closer.
 * - Customizable animation speed.
 * - jGrowl now set itself up and tears itself down.
 *
 * Changes in 1.0.1:
 * - Removed dependency on metadata plugin in favor of .data()
 * - Namespaced all events
 */
(function($) {

	/** jGrowl Wrapper - Establish a base jGrowl Container for compatibility with older releases. **/
	$.jGrowl = function( m , o ) {
		// To maintain compatibility with older version that only supported one instance we'll create the base container.
		if ( $('#jGrowl').size() == 0 ) $('<div id="jGrowl"></div>').addClass($.jGrowl.defaults.position).appendTo($.jGrowl.defaults.appendTo);
		// Create a notification on the container.
		$('#jGrowl').jGrowl(m,o);
	};


	/** Raise jGrowl Notification on a jGrowl Container **/
	$.fn.jGrowl = function( m , o ) {
		if ( $.isFunction(this.each) ) {
			var args = arguments;

			return this.each(function() {
				var self = this;

				/** Create a jGrowl Instance on the Container if it does not exist **/
				if ( $(this).data('jGrowl.instance') == undefined ) {
					$(this).data('jGrowl.instance', new $.fn.jGrowl());
					$(this).data('jGrowl.instance').startup( this );
				}

				/** Optionally call jGrowl instance methods, or just raise a normal notification **/
				if ( $.isFunction($(this).data('jGrowl.instance')[m]) ) {
					$(this).data('jGrowl.instance')[m].apply( $(this).data('jGrowl.instance') , $.makeArray(args).slice(1) );
				} else {
					$(this).data('jGrowl.instance').notification( m , o );
				}
			});
		};
	};

	$.extend( $.fn.jGrowl.prototype , {

		/** Default JGrowl Settings **/
		defaults: {
			header: 		'',
			sticky: 		false,
			position: 		'top-right', // Is this still needed?
			glue: 			'after',
			theme: 			'default',
			corners: 		'10px',
			check: 			500,
			life: 			3000,
			speed: 			'normal',
			easing: 		'swing',
			closer: 		true,
			closerTemplate: '<div>[ close all ]</div>',
			log: 			function(e,m,o) {},
			beforeOpen: 	function(e,m,o) {},
			open: 			function(e,m,o) {},
			beforeClose: 	function(e,m,o) {},
			close: 			function(e,m,o) {},
			appendTo:		'body',
			animateOpen: 	{
				opacity: 	'show'
			},
			animateClose: 	{
				opacity: 	'hide'
			}
		},
		
		/** jGrowl Container Node **/
		element: 	null,
	
		/** Interval Function **/
		interval:   null,
		
		/** Create a Notification **/
		notification: 	function( message , o ) {
			var self = this;
			var o = $.extend({}, this.defaults, o);

			o.log.apply( this.element , [this.element,message,o] );

			var notification = $('<div class="jGrowl-notification"><div class="close">&times;</div><div class="header">' + o.header + '</div><div class="message">' + message + '</div></div>')
				.data("jGrowl", o).addClass(o.theme).children('div.close').bind("click.jGrowl", function() {
					$(this).unbind('click.jGrowl').parent().trigger('jGrowl.beforeClose').animate(o.animateClose, o.speed, o.easing, function() {
						$(this).trigger('jGrowl.close').remove();
					});
				}).parent();
				
			( o.glue == 'after' ) ? $('div.jGrowl-notification:last', this.element).after(notification) : $('div.jGrowl-notification:first', this.element).before(notification);

			/** Notification Actions **/
			$(notification).bind("mouseover.jGrowl", function() {
				$(this).data("jGrowl").pause = true;
			}).bind("mouseout.jGrowl", function() {
				$(this).data("jGrowl").pause = false;
			}).bind('jGrowl.beforeOpen', function() {
				o.beforeOpen.apply( self.element , [self.element,message,o] );
			}).bind('jGrowl.open', function() {
				o.open.apply( self.element , [self.element,message,o] );
			}).bind('jGrowl.beforeClose', function() {
				o.beforeClose.apply( self.element , [self.element,message,o] );
			}).bind('jGrowl.close', function() {
				o.close.apply( self.element , [self.element,message,o] );
			}).trigger('jGrowl.beforeOpen').animate(o.animateOpen, o.speed, o.easing, function() {
				$(this).data("jGrowl").created = new Date();
			}).trigger('jGrowl.open');
		
			/** Optional Corners Plugin **/
			if ( $.fn.corner != undefined ) $(notification).corner( o.corners );

			/** Add a Global Closer if more than one notification exists **/
			if ( $('div.jGrowl-notification:parent', this.element).size() > 1 && $('div.jGrowl-closer', this.element).size() == 0 && this.defaults.closer != false ) {
				$(this.defaults.closerTemplate).addClass('jGrowl-closer').addClass(this.defaults.theme).appendTo(this.element).animate(this.defaults.animateOpen, this.defaults.speed, this.defaults.easing).bind("click.jGrowl", function() {
					$(this).siblings().children('div.close').trigger("click.jGrowl");

					if ( $.isFunction( self.defaults.closer ) ) self.defaults.closer.apply( $(this).parent()[0] , [$(this).parent()[0]] );
				});
			};
		},

		/** Update the jGrowl Container, removing old jGrowl notifications **/
		update:	 function() {
			$(this.element).find('div.jGrowl-notification:parent').each( function() {
				if ( $(this).data("jGrowl") != undefined && $(this).data("jGrowl").created != undefined && ($(this).data("jGrowl").created.getTime() + $(this).data("jGrowl").life)  < (new Date()).getTime() && $(this).data("jGrowl").sticky != true && 
					 ($(this).data("jGrowl").pause == undefined || $(this).data("jGrowl").pause != true) ) {
					$(this).children('div.close').trigger('click.jGrowl');
				}
			});

			if ( $(this.element).find('div.jGrowl-notification:parent').size() < 2 ) {
				$(this.element).find('div.jGrowl-closer').animate(this.defaults.animateClose, this.defaults.speed, this.defaults.easing, function() {
					$(this).remove();
				});
			};
		},

		/** Setup the jGrowl Notification Container **/
		startup:	function(e) {
			this.element = $(e).addClass('jGrowl').append('<div class="jGrowl-notification"></div>');
			this.interval = setInterval( function() { jQuery(e).data('jGrowl.instance').update(); }, this.defaults.check);
			
			if ($.browser.msie && parseInt($.browser.version) < 7) $(this.element).addClass('ie6');
		},

		/** Shutdown jGrowl, removing it and clearing the interval **/
		shutdown:   function() {
			$(this.element).removeClass('jGrowl').find('div.jGrowl-notification').remove();
			clearInterval( this.interval );
		}
	});
	
	/** Reference the Defaults Object for compatibility with older versions of jGrowl **/
	$.jGrowl.defaults = $.fn.jGrowl.prototype.defaults;

})(jQuery);/* aqCookie v1.0 - Simpler way to get and sets cookies.
   Copyright (C) 2008 Paul Pham <http://aquaron.com/~jquery/aqCookie>

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
(function($){
$.aqCookie = {
   domain: '',
   secToExpire: 3153600000,

   get: function(carr) {
      if (typeof carr == 'string')
         carr = [carr];

      var hash = [];
      var ca = document.cookie.split(';');
      for(var i=0;i < ca.length;i++) {
         var c = ca[i];
         while (c.charAt(0)==' ') c = c.substring(1,c.length);

         for(var j=0;j<carr.length;j++) {
            var n = carr[j]+'=';
            if (c.indexOf(n) == 0) 
               hash[carr[j]] = c.substring(n.length,c.length);
         }
      }
      return hash;
   },

   set: function(k,v) {
      if (v) {
         var exp = new Date();
         exp.setTime(exp.getTime() + $.aqCookie.secToExpire);
         document.cookie = k + "=" + v + "; path=/; domain="+$.aqCookie.domain+"; expires="+ exp.toGMTString() + '";';
      } else
         document.cookie = k + "=; path=/; domain="+$.aqCookie.domain+"; expires=Thu, 01-Jan-1970 00:00:01 GMT;";
   },

   all: function(filter) {
      var hash = [];
      var ca = document.cookie.split(';');
      var re = new RegExp(filter);
      for(var i=0;i < ca.length;i++) {
         var c = ca[i];
         while (c.charAt(0)==' ') c = c.substring(1,c.length);
         if (!c.match(re))
            continue;
         hash.push(c.substring(0,c.indexOf('=')));
      }
      return hash;
   },

   del: function(k) { $.aqCookie.set(k) }
};
})(jQuery);/*
 * jQuery simpleXpath plugin
 *
 * returns an object with the current text selection coordinates
 * (startContainer, startOffset, endContainer, endOffset)
 * Version: 0.1 (08/30/2008)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */

(function($) {
  $.simpleXpath = function(selector,context) {


    var o = selector.split('/text()');
    selector = o[0];
    var textNodeN = o[1].replace(/[\[\]]/g,"");
    
    // Convert ./ to >
    selector = selector.replace(/\.\//g, ">");    
    
    // Convert // to " "
    //selector = selector.replace(/\/\//g, " ");

    // Convert / to >
    selector = selector.replace(/\//g, ">");
    
    // Convert [n] to :eq(n-1)
    var nth = selector.split(/[\[\]]/);
    
    for(var i=0, l=nth.length; i<l; i++) {
      if(Number(nth[i]) > 0) {
        nth[i] = ":eq("+(nth[i]-1)+")";
      }
    }
    selector = nth.join('');
    //console.log(context+selector,$(context+selector).get(0).innerHTML);
    //console.log(selection.lenght);
    
    return $(context+selector).textNodes(true)[textNodeN];
  }
})(jQuery);
