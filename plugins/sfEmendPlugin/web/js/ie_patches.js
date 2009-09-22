/*! (C) 2008 henrik.lindqvist@llamalab.com */

(function(ap){if(!ap.every){ap.every=function(fn,thisp){for(var i=0,l=this.length;--l>=0;i++)
if(i in this&&!fn.call(thisp,this[i],i,this))return false;return true;};}
if(!ap.filter){ap.filter=function(fn,thisp){var r=[];for(var v,i=0,l=this.length;--l>=0;i++)
if(i in this&&fn.call(thisp,v=this[i],i,this))r.push(v);return r;};}
if(!ap.forEach){ap.forEach=function(fn,thisp){for(var i=0,l=this.length;--l>=0;i++)
if(i in this)fn.call(thisp,this[i],i,this);};}
if(!ap.indexOf){ap.indexOf=function(e,i){var l=this.length;i=(i<0)?Math.ceil(i):Math.floor(i);if(i<0)i+=l;for(;i<l;i++)
if(i in this&&this[i]===e)return i;return-1;};}
if(!ap.lastIndexOf){ap.lastIndexOf=function(e,i){var l=this.length;if(isNaN(i))i=l-1;else{i=(i<0)?Math.ceil(i):Math.floor(i);if(i<0)i+=l;else if(i>=l)i=l-1;}
for(;i>-1;i--)
if(i in this&&this[i]===e)return i;return-1;};}
if(!ap.map){ap.map=function(fn,thisp){var l=this.length;var r=new Array(l);for(var i=0;--l>=0;i++)
if(i in this)r[i]=fn.call(thisp,this[i],i,this);return r;};}
if(!ap.some){ap.some=function(fn,thisp){for(var i=0,l=this.length;--l>=0;i++)
if(i in this&&fn.call(thisp,this[i],i,this))
return true;return false;};}})(Array.prototype);/*!
// Copyright 2006 Google Inc.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
*/


// Known Issues:
//
// * Patterns are not implemented.
// * Radial gradient are not implemented. The VML version of these look very
//   different from the canvas one.
// * Clipping paths are not implemented.
// * Coordsize. The width and height attribute have higher priority than the
//   width and height style values which isn't correct.
// * Painting mode isn't implemented.
// * Canvas width/height should is using content-box by default. IE in
//   Quirks mode will draw the canvas using border-box. Either change your
//   doctype to HTML5
//   (http://www.whatwg.org/specs/web-apps/current-work/#the-doctype)
//   or use Box Sizing Behavior from WebFX
//   (http://webfx.eae.net/dhtml/boxsizing/boxsizing.html)
// * Non uniform scaling does not correctly scale strokes.
// * Optimize. There is always room for speed improvements.

// Only add this code if we do not already have a canvas implementation
if (!document.createElement('canvas').getContext) {

(function() {

  // alias some functions to make (compiled) code shorter
  var m = Math;
  var mr = m.round;
  var ms = m.sin;
  var mc = m.cos;
  var abs = m.abs;
  var sqrt = m.sqrt;

  // this is used for sub pixel precision
  var Z = 10;
  var Z2 = Z / 2;

  /**
   * This funtion is assigned to the <canvas> elements as element.getContext().
   * @this {HTMLElement}
   * @return {CanvasRenderingContext2D_}
   */
  function getContext() {
    return this.context_ ||
        (this.context_ = new CanvasRenderingContext2D_(this));
  }

  var slice = Array.prototype.slice;

  /**
   * Binds a function to an object. The returned function will always use the
   * passed in {@code obj} as {@code this}.
   *
   * Example:
   *
   *   g = bind(f, obj, a, b)
   *   g(c, d) // will do f.call(obj, a, b, c, d)
   *
   * @param {Function} f The function to bind the object to
   * @param {Object} obj The object that should act as this when the function
   *     is called
   * @param {*} var_args Rest arguments that will be used as the initial
   *     arguments when the function is called
   * @return {Function} A new function that has bound this
   */
  function bind(f, obj, var_args) {
    var a = slice.call(arguments, 2);
    return function() {
      return f.apply(obj, a.concat(slice.call(arguments)));
    };
  }

  var G_vmlCanvasManager_ = {
    init: function(opt_doc) {
      if (/MSIE/.test(navigator.userAgent) && !window.opera) {
        var doc = opt_doc || document;
        // Create a dummy element so that IE will allow canvas elements to be
        // recognized.
        doc.createElement('canvas');
        doc.attachEvent('onreadystatechange', bind(this.init_, this, doc));
      }
    },

    init_: function(doc) {
      // create xmlns
      if (!doc.namespaces['g_vml_']) {
        doc.namespaces.add('g_vml_', 'urn:schemas-microsoft-com:vml',
                           '#default#VML');

      }
      if (!doc.namespaces['g_o_']) {
        doc.namespaces.add('g_o_', 'urn:schemas-microsoft-com:office:office',
                           '#default#VML');
      }

      // Setup default CSS.  Only add one style sheet per document
      if (!doc.styleSheets['ex_canvas_']) {
        var ss = doc.createStyleSheet();
        ss.owningElement.id = 'ex_canvas_';
        ss.cssText = 'canvas{display:inline-block;overflow:hidden;' +
            // default size is 300x150 in Gecko and Opera
            'text-align:left;width:300px;height:150px}' +
            'g_vml_\\:*{behavior:url(#default#VML)}' +
            'g_o_\\:*{behavior:url(#default#VML)}';

      }

      // find all canvas elements
      var els = doc.getElementsByTagName('canvas');
      for (var i = 0; i < els.length; i++) {
        this.initElement(els[i]);
      }
    },

    /**
     * Public initializes a canvas element so that it can be used as canvas
     * element from now on. This is called automatically before the page is
     * loaded but if you are creating elements using createElement you need to
     * make sure this is called on the element.
     * @param {HTMLElement} el The canvas element to initialize.
     * @return {HTMLElement} the element that was created.
     */
    initElement: function(el) {
      if (!el.getContext) {

        el.getContext = getContext;

        // Remove fallback content. There is no way to hide text nodes so we
        // just remove all childNodes. We could hide all elements and remove
        // text nodes but who really cares about the fallback content.
        el.innerHTML = '';

        // do not use inline function because that will leak memory
        el.attachEvent('onpropertychange', onPropertyChange);
        el.attachEvent('onresize', onResize);

        var attrs = el.attributes;
        if (attrs.width && attrs.width.specified) {
          // TODO: use runtimeStyle and coordsize
          // el.getContext().setWidth_(attrs.width.nodeValue);
          el.style.width = attrs.width.nodeValue + 'px';
        } else {
          el.width = el.clientWidth;
        }
        if (attrs.height && attrs.height.specified) {
          // TODO: use runtimeStyle and coordsize
          // el.getContext().setHeight_(attrs.height.nodeValue);
          el.style.height = attrs.height.nodeValue + 'px';
        } else {
          el.height = el.clientHeight;
        }
        //el.getContext().setCoordsize_()
      }
      return el;
    }
  };

  function onPropertyChange(e) {
    var el = e.srcElement;

    switch (e.propertyName) {
      case 'width':
        el.style.width = el.attributes.width.nodeValue + 'px';
        el.getContext().clearRect();
        break;
      case 'height':
        el.style.height = el.attributes.height.nodeValue + 'px';
        el.getContext().clearRect();
        break;
    }
  }

  function onResize(e) {
    var el = e.srcElement;
    if (el.firstChild) {
      el.firstChild.style.width =  el.clientWidth + 'px';
      el.firstChild.style.height = el.clientHeight + 'px';
    }
  }

  G_vmlCanvasManager_.init();

  // precompute "00" to "FF"
  var dec2hex = [];
  for (var i = 0; i < 16; i++) {
    for (var j = 0; j < 16; j++) {
      dec2hex[i * 16 + j] = i.toString(16) + j.toString(16);
    }
  }

  function createMatrixIdentity() {
    return [
      [1, 0, 0],
      [0, 1, 0],
      [0, 0, 1]
    ];
  }

  function matrixMultiply(m1, m2) {
    var result = createMatrixIdentity();

    for (var x = 0; x < 3; x++) {
      for (var y = 0; y < 3; y++) {
        var sum = 0;

        for (var z = 0; z < 3; z++) {
          sum += m1[x][z] * m2[z][y];
        }

        result[x][y] = sum;
      }
    }
    return result;
  }

  function copyState(o1, o2) {
    o2.fillStyle     = o1.fillStyle;
    o2.lineCap       = o1.lineCap;
    o2.lineJoin      = o1.lineJoin;
    o2.lineWidth     = o1.lineWidth;
    o2.miterLimit    = o1.miterLimit;
    o2.shadowBlur    = o1.shadowBlur;
    o2.shadowColor   = o1.shadowColor;
    o2.shadowOffsetX = o1.shadowOffsetX;
    o2.shadowOffsetY = o1.shadowOffsetY;
    o2.strokeStyle   = o1.strokeStyle;
    o2.globalAlpha   = o1.globalAlpha;
    o2.arcScaleX_    = o1.arcScaleX_;
    o2.arcScaleY_    = o1.arcScaleY_;
    o2.lineScale_    = o1.lineScale_;
  }

  function processStyle(styleString) {
    var str, alpha = 1;

    styleString = String(styleString);
    if (styleString.substring(0, 3) == 'rgb') {
      var start = styleString.indexOf('(', 3);
      var end = styleString.indexOf(')', start + 1);
      var guts = styleString.substring(start + 1, end).split(',');

      str = '#';
      for (var i = 0; i < 3; i++) {
        str += dec2hex[Number(guts[i])];
      }

      if (guts.length == 4 && styleString.substr(3, 1) == 'a') {
        alpha = guts[3];
      }
    } else {
      str = styleString;
    }

    return {color: str, alpha: alpha};
  }

  function processLineCap(lineCap) {
    switch (lineCap) {
      case 'butt':
        return 'flat';
      case 'round':
        return 'round';
      case 'square':
      default:
        return 'square';
    }
  }

  /**
   * This class implements CanvasRenderingContext2D interface as described by
   * the WHATWG.
   * @param {HTMLElement} surfaceElement The element that the 2D context should
   * be associated with
   */
  function CanvasRenderingContext2D_(surfaceElement) {
    this.m_ = createMatrixIdentity();

    this.mStack_ = [];
    this.aStack_ = [];
    this.currentPath_ = [];

    // Canvas context properties
    this.strokeStyle = '#000';
    this.fillStyle = '#000';

    this.lineWidth = 1;
    this.lineJoin = 'miter';
    this.lineCap = 'butt';
    this.miterLimit = Z * 1;
    this.globalAlpha = 1;
    this.canvas = surfaceElement;

    var el = surfaceElement.ownerDocument.createElement('div');
    el.style.width =  surfaceElement.clientWidth + 'px';
    el.style.height = surfaceElement.clientHeight + 'px';
    el.style.overflow = 'hidden';
    el.style.position = 'absolute';
    surfaceElement.appendChild(el);

    this.element_ = el;
    this.arcScaleX_ = 1;
    this.arcScaleY_ = 1;
    this.lineScale_ = 1;
  }

  var contextPrototype = CanvasRenderingContext2D_.prototype;
  contextPrototype.clearRect = function() {
    this.element_.innerHTML = '';
  };

  contextPrototype.beginPath = function() {
    // TODO: Branch current matrix so that save/restore has no effect
    //       as per safari docs.
    this.currentPath_ = [];
  };

  contextPrototype.moveTo = function(aX, aY) {
    var p = this.getCoords_(aX, aY);
    this.currentPath_.push({type: 'moveTo', x: p.x, y: p.y});
    this.currentX_ = p.x;
    this.currentY_ = p.y;
  };

  contextPrototype.lineTo = function(aX, aY) {
    var p = this.getCoords_(aX, aY);
    this.currentPath_.push({type: 'lineTo', x: p.x, y: p.y});

    this.currentX_ = p.x;
    this.currentY_ = p.y;
  };

  contextPrototype.bezierCurveTo = function(aCP1x, aCP1y,
                                            aCP2x, aCP2y,
                                            aX, aY) {
    var p = this.getCoords_(aX, aY);
    var cp1 = this.getCoords_(aCP1x, aCP1y);
    var cp2 = this.getCoords_(aCP2x, aCP2y);
    bezierCurveTo(this, cp1, cp2, p);
  };

  // Helper function that takes the already fixed cordinates.
  function bezierCurveTo(self, cp1, cp2, p) {
    self.currentPath_.push({
      type: 'bezierCurveTo',
      cp1x: cp1.x,
      cp1y: cp1.y,
      cp2x: cp2.x,
      cp2y: cp2.y,
      x: p.x,
      y: p.y
    });
    self.currentX_ = p.x;
    self.currentY_ = p.y;
  }

  contextPrototype.quadraticCurveTo = function(aCPx, aCPy, aX, aY) {
    // the following is lifted almost directly from
    // http://developer.mozilla.org/en/docs/Canvas_tutorial:Drawing_shapes

    var cp = this.getCoords_(aCPx, aCPy);
    var p = this.getCoords_(aX, aY);

    var cp1 = {
      x: this.currentX_ + 2.0 / 3.0 * (cp.x - this.currentX_),
      y: this.currentY_ + 2.0 / 3.0 * (cp.y - this.currentY_)
    };
    var cp2 = {
      x: cp1.x + (p.x - this.currentX_) / 3.0,
      y: cp1.y + (p.y - this.currentY_) / 3.0
    };

    bezierCurveTo(this, cp1, cp2, p);
  };

  contextPrototype.arc = function(aX, aY, aRadius,
                                  aStartAngle, aEndAngle, aClockwise) {
    aRadius *= Z;
    var arcType = aClockwise ? 'at' : 'wa';

    var xStart = aX + mc(aStartAngle) * aRadius - Z2;
    var yStart = aY + ms(aStartAngle) * aRadius - Z2;

    var xEnd = aX + mc(aEndAngle) * aRadius - Z2;
    var yEnd = aY + ms(aEndAngle) * aRadius - Z2;

    // IE won't render arches drawn counter clockwise if xStart == xEnd.
    if (xStart == xEnd && !aClockwise) {
      xStart += 0.125; // Offset xStart by 1/80 of a pixel. Use something
                       // that can be represented in binary
    }

    var p = this.getCoords_(aX, aY);
    var pStart = this.getCoords_(xStart, yStart);
    var pEnd = this.getCoords_(xEnd, yEnd);

    this.currentPath_.push({type: arcType,
                           x: p.x,
                           y: p.y,
                           radius: aRadius,
                           xStart: pStart.x,
                           yStart: pStart.y,
                           xEnd: pEnd.x,
                           yEnd: pEnd.y});

  };

  contextPrototype.rect = function(aX, aY, aWidth, aHeight) {
    this.moveTo(aX, aY);
    this.lineTo(aX + aWidth, aY);
    this.lineTo(aX + aWidth, aY + aHeight);
    this.lineTo(aX, aY + aHeight);
    this.closePath();
  };

  contextPrototype.strokeRect = function(aX, aY, aWidth, aHeight) {
    var oldPath = this.currentPath_;
    this.beginPath();

    this.moveTo(aX, aY);
    this.lineTo(aX + aWidth, aY);
    this.lineTo(aX + aWidth, aY + aHeight);
    this.lineTo(aX, aY + aHeight);
    this.closePath();
    this.stroke();

    this.currentPath_ = oldPath;
  };

  contextPrototype.fillRect = function(aX, aY, aWidth, aHeight) {
    var oldPath = this.currentPath_;
    this.beginPath();

    this.moveTo(aX, aY);
    this.lineTo(aX + aWidth, aY);
    this.lineTo(aX + aWidth, aY + aHeight);
    this.lineTo(aX, aY + aHeight);
    this.closePath();
    this.fill();

    this.currentPath_ = oldPath;
  };

  contextPrototype.createLinearGradient = function(aX0, aY0, aX1, aY1) {
    var gradient = new CanvasGradient_('gradient');
    gradient.x0_ = aX0;
    gradient.y0_ = aY0;
    gradient.x1_ = aX1;
    gradient.y1_ = aY1;
    return gradient;
  };

  contextPrototype.createRadialGradient = function(aX0, aY0, aR0,
                                                   aX1, aY1, aR1) {
    var gradient = new CanvasGradient_('gradientradial');
    gradient.x0_ = aX0;
    gradient.y0_ = aY0;
    gradient.r0_ = aR0;
    gradient.x1_ = aX1;
    gradient.y1_ = aY1;
    gradient.r1_ = aR1;
    return gradient;
  };

  contextPrototype.drawImage = function(image, var_args) {
    var dx, dy, dw, dh, sx, sy, sw, sh;

    // to find the original width we overide the width and height
    var oldRuntimeWidth = image.runtimeStyle.width;
    var oldRuntimeHeight = image.runtimeStyle.height;
    image.runtimeStyle.width = 'auto';
    image.runtimeStyle.height = 'auto';

    // get the original size
    var w = image.width;
    var h = image.height;

    // and remove overides
    image.runtimeStyle.width = oldRuntimeWidth;
    image.runtimeStyle.height = oldRuntimeHeight;

    if (arguments.length == 3) {
      dx = arguments[1];
      dy = arguments[2];
      sx = sy = 0;
      sw = dw = w;
      sh = dh = h;
    } else if (arguments.length == 5) {
      dx = arguments[1];
      dy = arguments[2];
      dw = arguments[3];
      dh = arguments[4];
      sx = sy = 0;
      sw = w;
      sh = h;
    } else if (arguments.length == 9) {
      sx = arguments[1];
      sy = arguments[2];
      sw = arguments[3];
      sh = arguments[4];
      dx = arguments[5];
      dy = arguments[6];
      dw = arguments[7];
      dh = arguments[8];
    } else {
      throw Error('Invalid number of arguments');
    }

    var d = this.getCoords_(dx, dy);

    var w2 = sw / 2;
    var h2 = sh / 2;

    var vmlStr = [];

    var W = 10;
    var H = 10;

    // For some reason that I've now forgotten, using divs didn't work
    vmlStr.push(' <g_vml_:group',
                ' coordsize="', Z * W, ',', Z * H, '"',
                ' coordorigin="0,0"' ,
                ' style="width:', W, 'px;height:', H, 'px;position:absolute;');

    // If filters are necessary (rotation exists), create them
    // filters are bog-slow, so only create them if abbsolutely necessary
    // The following check doesn't account for skews (which don't exist
    // in the canvas spec (yet) anyway.

    if (this.m_[0][0] != 1 || this.m_[0][1]) {
      var filter = [];

      // Note the 12/21 reversal
      filter.push('M11=', this.m_[0][0], ',',
                  'M12=', this.m_[1][0], ',',
                  'M21=', this.m_[0][1], ',',
                  'M22=', this.m_[1][1], ',',
                  'Dx=', mr(d.x / Z), ',',
                  'Dy=', mr(d.y / Z), '');

      // Bounding box calculation (need to minimize displayed area so that
      // filters don't waste time on unused pixels.
      var max = d;
      var c2 = this.getCoords_(dx + dw, dy);
      var c3 = this.getCoords_(dx, dy + dh);
      var c4 = this.getCoords_(dx + dw, dy + dh);

      max.x = m.max(max.x, c2.x, c3.x, c4.x);
      max.y = m.max(max.y, c2.y, c3.y, c4.y);

      vmlStr.push('padding:0 ', mr(max.x / Z), 'px ', mr(max.y / Z),
                  'px 0;filter:progid:DXImageTransform.Microsoft.Matrix(',
                  filter.join(''), ", sizingmethod='clip');")
    } else {
      vmlStr.push('top:', mr(d.y / Z), 'px;left:', mr(d.x / Z), 'px;');
    }

    vmlStr.push(' ">' ,
                '<g_vml_:image src="', image.src, '"',
                ' style="width:', Z * dw, 'px;',
                ' height:', Z * dh, 'px;"',
                ' cropleft="', sx / w, '"',
                ' croptop="', sy / h, '"',
                ' cropright="', (w - sx - sw) / w, '"',
                ' cropbottom="', (h - sy - sh) / h, '"',
                ' />',
                '</g_vml_:group>');

    this.element_.insertAdjacentHTML('BeforeEnd',
                                    vmlStr.join(''));
  };

  contextPrototype.stroke = function(aFill) {
    var lineStr = [];
    var lineOpen = false;
    var a = processStyle(aFill ? this.fillStyle : this.strokeStyle);
    var color = a.color;
    var opacity = a.alpha * this.globalAlpha;

    var W = 10;
    var H = 10;

    lineStr.push('<g_vml_:shape',
                 ' filled="', !!aFill, '"',
                 ' style="position:absolute;width:', W, 'px;height:', H, 'px;"',
                 ' coordorigin="0 0" coordsize="', Z * W, ' ', Z * H, '"',
                 ' stroked="', !aFill, '"',
                 ' path="');

    var newSeq = false;
    var min = {x: null, y: null};
    var max = {x: null, y: null};

    for (var i = 0; i < this.currentPath_.length; i++) {
      var p = this.currentPath_[i];
      var c;

      switch (p.type) {
        case 'moveTo':
          c = p;
          lineStr.push(' m ', mr(p.x), ',', mr(p.y));
          break;
        case 'lineTo':
          lineStr.push(' l ', mr(p.x), ',', mr(p.y));
          break;
        case 'close':
          lineStr.push(' x ');
          p = null;
          break;
        case 'bezierCurveTo':
          lineStr.push(' c ',
                       mr(p.cp1x), ',', mr(p.cp1y), ',',
                       mr(p.cp2x), ',', mr(p.cp2y), ',',
                       mr(p.x), ',', mr(p.y));
          break;
        case 'at':
        case 'wa':
          lineStr.push(' ', p.type, ' ',
                       mr(p.x - this.arcScaleX_ * p.radius), ',',
                       mr(p.y - this.arcScaleY_ * p.radius), ' ',
                       mr(p.x + this.arcScaleX_ * p.radius), ',',
                       mr(p.y + this.arcScaleY_ * p.radius), ' ',
                       mr(p.xStart), ',', mr(p.yStart), ' ',
                       mr(p.xEnd), ',', mr(p.yEnd));
          break;
      }


      // TODO: Following is broken for curves due to
      //       move to proper paths.

      // Figure out dimensions so we can do gradient fills
      // properly
      if (p) {
        if (min.x == null || p.x < min.x) {
          min.x = p.x;
        }
        if (max.x == null || p.x > max.x) {
          max.x = p.x;
        }
        if (min.y == null || p.y < min.y) {
          min.y = p.y;
        }
        if (max.y == null || p.y > max.y) {
          max.y = p.y;
        }
      }
    }
    lineStr.push(' ">');

    if (!aFill) {
      var lineWidth = this.lineScale_ * this.lineWidth;

      // VML cannot correctly render a line if the width is less than 1px.
      // In that case, we dilute the color to make the line look thinner.
      if (lineWidth < 1) {
        opacity *= lineWidth;
      }

      lineStr.push(
        '<g_vml_:stroke',
        ' opacity="', opacity, '"',
        ' joinstyle="', this.lineJoin, '"',
        ' miterlimit="', this.miterLimit, '"',
        ' endcap="', processLineCap(this.lineCap), '"',
        ' weight="', lineWidth, 'px"',
        ' color="', color, '" />'
      );
    } else if (typeof this.fillStyle == 'object') {
      var fillStyle = this.fillStyle;
      var angle = 0;
      var focus = {x: 0, y: 0};

      // additional offset
      var shift = 0;
      // scale factor for offset
      var expansion = 1;

      if (fillStyle.type_ == 'gradient') {
        var x0 = fillStyle.x0_ / this.arcScaleX_;
        var y0 = fillStyle.y0_ / this.arcScaleY_;
        var x1 = fillStyle.x1_ / this.arcScaleX_;
        var y1 = fillStyle.y1_ / this.arcScaleY_;
        var p0 = this.getCoords_(x0, y0);
        var p1 = this.getCoords_(x1, y1);
        var dx = p1.x - p0.x;
        var dy = p1.y - p0.y;
        angle = Math.atan2(dx, dy) * 180 / Math.PI;

        // The angle should be a non-negative number.
        if (angle < 0) {
          angle += 360;
        }

        // Very small angles produce an unexpected result because they are
        // converted to a scientific notation string.
        if (angle < 1e-6) {
          angle = 0;
        }
      } else {
        var p0 = this.getCoords_(fillStyle.x0_, fillStyle.y0_);
        var width  = max.x - min.x;
        var height = max.y - min.y;
        focus = {
          x: (p0.x - min.x) / width,
          y: (p0.y - min.y) / height
        };

        width  /= this.arcScaleX_ * Z;
        height /= this.arcScaleY_ * Z;
        var dimension = m.max(width, height);
        shift = 2 * fillStyle.r0_ / dimension;
        expansion = 2 * fillStyle.r1_ / dimension - shift;
      }

      // We need to sort the color stops in ascending order by offset,
      // otherwise IE won't interpret it correctly.
      var stops = fillStyle.colors_;
      stops.sort(function(cs1, cs2) {
        return cs1.offset - cs2.offset;
      });

      var length = stops.length;
      var color1 = stops[0].color;
      var color2 = stops[length - 1].color;
      var opacity1 = stops[0].alpha * this.globalAlpha;
      var opacity2 = stops[length - 1].alpha * this.globalAlpha;

      var colors = [];
      for (var i = 0; i < length; i++) {
        var stop = stops[i];
        colors.push(stop.offset * expansion + shift + ' ' + stop.color);
      }

      // When colors attribute is used, the meanings of opacity and o:opacity2
      // are reversed.
      lineStr.push('<g_vml_:fill type="', fillStyle.type_, '"',
                   ' method="none" focus="100%"',
                   ' color="', color1, '"',
                   ' color2="', color2, '"',
                   ' colors="', colors.join(','), '"',
                   ' opacity="', opacity2, '"',
                   ' g_o_:opacity2="', opacity1, '"',
                   ' angle="', angle, '"',
                   ' focusposition="', focus.x, ',', focus.y, '" />');
    } else {
      lineStr.push('<g_vml_:fill color="', color, '" opacity="', opacity,
                   '" />');
    }

    lineStr.push('</g_vml_:shape>');

    this.element_.insertAdjacentHTML('beforeEnd', lineStr.join(''));
  };

  contextPrototype.fill = function() {
    this.stroke(true);
  }

  contextPrototype.closePath = function() {
    this.currentPath_.push({type: 'close'});
  };

  /**
   * @private
   */
  contextPrototype.getCoords_ = function(aX, aY) {
    var m = this.m_;
    return {
      x: Z * (aX * m[0][0] + aY * m[1][0] + m[2][0]) - Z2,
      y: Z * (aX * m[0][1] + aY * m[1][1] + m[2][1]) - Z2
    }
  };

  contextPrototype.save = function() {
    var o = {};
    copyState(this, o);
    this.aStack_.push(o);
    this.mStack_.push(this.m_);
    this.m_ = matrixMultiply(createMatrixIdentity(), this.m_);
  };

  contextPrototype.restore = function() {
    copyState(this.aStack_.pop(), this);
    this.m_ = this.mStack_.pop();
  };

  function matrixIsFinite(m) {
    for (var j = 0; j < 3; j++) {
      for (var k = 0; k < 2; k++) {
        if (!isFinite(m[j][k]) || isNaN(m[j][k])) {
          return false;
        }
      }
    }
    return true;
  }

  function setM(ctx, m, updateLineScale) {
    if (!matrixIsFinite(m)) {
      return;
    }
    ctx.m_ = m;

    if (updateLineScale) {
      // Get the line scale.
      // Determinant of this.m_ means how much the area is enlarged by the
      // transformation. So its square root can be used as a scale factor
      // for width.
      var det = m[0][0] * m[1][1] - m[0][1] * m[1][0];
      ctx.lineScale_ = sqrt(abs(det));
    }
  }

  contextPrototype.translate = function(aX, aY) {
    var m1 = [
      [1,  0,  0],
      [0,  1,  0],
      [aX, aY, 1]
    ];

    setM(this, matrixMultiply(m1, this.m_), false);
  };

  contextPrototype.rotate = function(aRot) {
    var c = mc(aRot);
    var s = ms(aRot);

    var m1 = [
      [c,  s, 0],
      [-s, c, 0],
      [0,  0, 1]
    ];

    setM(this, matrixMultiply(m1, this.m_), false);
  };

  contextPrototype.scale = function(aX, aY) {
    this.arcScaleX_ *= aX;
    this.arcScaleY_ *= aY;
    var m1 = [
      [aX, 0,  0],
      [0,  aY, 0],
      [0,  0,  1]
    ];

    setM(this, matrixMultiply(m1, this.m_), true);
  };

  contextPrototype.transform = function(m11, m12, m21, m22, dx, dy) {
    var m1 = [
      [m11, m12, 0],
      [m21, m22, 0],
      [dx,  dy,  1]
    ];

    setM(this, matrixMultiply(m1, this.m_), true);
  };

  contextPrototype.setTransform = function(m11, m12, m21, m22, dx, dy) {
    var m = [
      [m11, m12, 0],
      [m21, m22, 0],
      [dx,  dy,  1]
    ];

    setM(this, m, true);
  };

  /******** STUBS ********/
  contextPrototype.clip = function() {
    // TODO: Implement
  };

  contextPrototype.arcTo = function() {
    // TODO: Implement
  };

  contextPrototype.createPattern = function() {
    return new CanvasPattern_;
  };

  // Gradient / Pattern Stubs
  function CanvasGradient_(aType) {
    this.type_ = aType;
    this.x0_ = 0;
    this.y0_ = 0;
    this.r0_ = 0;
    this.x1_ = 0;
    this.y1_ = 0;
    this.r1_ = 0;
    this.colors_ = [];
  }

  CanvasGradient_.prototype.addColorStop = function(aOffset, aColor) {
    aColor = processStyle(aColor);
    this.colors_.push({offset: aOffset,
                       color: aColor.color,
                       alpha: aColor.alpha});
  };

  function CanvasPattern_() {}

  // set up externs
  G_vmlCanvasManager = G_vmlCanvasManager_;
  CanvasRenderingContext2D = CanvasRenderingContext2D_;
  CanvasGradient = CanvasGradient_;
  CanvasPattern = CanvasPattern_;

})();

} // if
/*!
  XPath.js, an JavaScript implementation of XML Path Language (XPath) Version 1.0
  Copyright (C) 2008 Henrik Lindqvist <henrik.lindqvist@llamalab.com>
  
  This library is free software: you can redistribute it and/or modify
  it under the terms of the GNU Lesser General Public License as published 
  by the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This library is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Lesser General Public License for more details.
  
  You should have received a copy of the GNU Lesser General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
(function (w, d, f) {


function XPath (e) {
  this.e = e;
  this.i = 0;
  this.js = [ 'with(XPath){return ', '}' ];
  this.expression(1, 1) || this.error();
  //console.log(this.js.join(''));
  return new Function('n', 'nsr', this.js.join(''));
}
XPath.ie = /MSIE/.test(navigator.userAgent);
XPath.prototype = {
  match : function (rx, x) {
   var m, r;
    if (   !(m = rx.exec(this.e.substr(this.i))) 
        || (typeof x == 'number' && !(r = m[x]))
        || (typeof x == 'object' && !(r = x[m[1]]))) return false;
    this.m = m;
    this.i += m[0].length;
    return r || m;
  },
  error : function (m) {
    m = (m || 'Syntax error')+' at index '+this.i+': '+this.e.substr(this.i);
    var e;
    try { e = new XPathException(51, m) }
    catch (x) { e = new Error(m) }
    throw e;
  },
  step : function (l, r, s, n) {
    var i = 3;
    if (this.match(/^(\/\/?|\.\.?|@)\s*/, 1)) {
      switch (this.m[1]) {
        case '/':
          if (s) this.error();
          if (!n) return this.step(l, r, 1);
          this.js.splice(l, 0, ' axis(axes["','document-root','"],');
          i += this.nodeTypes.node.call(this, l + i);
          s = 1;
          break;
        case '//':
          if (s) this.error();
          this.js.splice(l, 0, ' axis(axes["','descendant-or-self','"],');
          i += this.nodeTypes.node.call(this, l + i);
          s = 1;
          break;
        case '.':
          if (!s && !n) this.error();
          this.js.splice(l, 0, ' axis(axes["','self','"],');
          i += this.nodeTypes.node.call(this, l + i);
          s = 0;
          break;
        case '..':
          if (!s && !n) this.error();
          this.js.splice(l, 0, ' axis(axes["','parent','"],');
          i += this.nodeTypes.node.call(this, l + i);
          s = 0;
          break;
        case '@':
          if (!s && !n) this.error();
          this.js.splice(l, 0, ' axis(axes["','attribute','"],');
          i += this.nodeTest(l + i, 'node') || this.error('Missing nodeTest after @');
          s = 0;
      }
    }
    else if (!s && !n) return s ? this.error() : 0;
    else if (this.match(/^([a-z]+(?:-[a-z]+)*)\s*::\s*/, XPath.axes)) {
      this.js.splice(l, 0, ' axis(axes["',this.m[1],'"],');
      i += this.nodeTest(l + i, (this.m[1]=='attribute')?'node':'element') || this.error('Missing nodeTest after ::');
      s = 0;
    }
    else if (i = this.nodeTest(l, 'element')) {
      this.js.splice(l, 0, ' axis(axes["','child','"],');
      i += 3;
      s = 0;
    }
    else return 0;
    for (var j; j = this.predicate(l + i); i += j);
    if (n) this.js.splice(r + i++, 0, n);
    i += this.step(l, r + i, s);
    this.js.splice(r + i++, 0, ')');
    return i;
  },
  expression : function (l, r, p) {
    var o, i = this.operand(l);
    while (o = this.match(/^(or|and|!?=|[<>]=?|[|*+-]|div|mod)\s*/, this.operators)) {
      if (p && p[0] >= o[0]) { 
        this.i -= this.m[0].length; 
        break;
      }
      this.js.splice(l, 0, o[1]);
      i++;
      this.js.splice(l + i++, 0, o[2]);
      i += this.expression(l + i, r, o) || this.error('Missing operand');
      this.js.splice(l + i++, 0, o[3]);
    }
    return i;
  },
  operand : function (l) {
    if (this.match(/^(-?(?:[0-9]+(?:\.[0-9]+)?|\.[0-9]+)|"[^"]*"|'[^']*')\s*/, 1)) {
      this.js.splice(l, 0, this.m[1]);
      return 1;
    }
    var fn;
    if (fn = this.match(/^([a-z]+(?:-[a-z]+)*)\s*\(\s*/, this.functions)) {
      var i = 1, j;
      this.js.splice(l, 0, fn[1]);
      do {
        if (j) this.js.splice(l + i++, 0, ',');
        i += (j = this.expression(l + i, l + i));
      } while (j && this.match(/^,\s*/));
      this.match(/^\)\s*/) || this.error('Missing (');
      if (fn[0]) {
        if (j) this.js.splice(l + i++, 0, ',');
        this.js.splice(l + i++, 0, fn[0]);
      }
      if (fn[2]) this.js.splice(l + i++, 0, fn[2]);
      else if (j > 1) this.error('Function has arguments');
      i += this.step(l, l + i);
      return i;
    }
    if (this.match(/^\(\s*/)) {
      var i = 1;
      this.js.splice(l, 0, '(');
      i += this.expression(l + i, l + i);
      this.match(/^\)\s*/) || this.error('Missing )');
      this.js.splice(l + i++, ')');
      return i;
    }
    return this.step(l, l, 0, '[n]');
  },
  operators : {
    '|'   : [1,'union(',',',')'],
    'or'  : [1,'bool(',')||bool(',')'],
    'and' : [2,'bool(',')&&bool(',')'],
    '='   : [3,'compare(eq,',',',')'],
    '!='  : [3,'compare(ne,',',',')'],
    '<'   : [4,'compare(lt,',',',')'],
    '>'   : [4,'compare(gt,',',',')'],
    '<='  : [4,'compare(le,',',',')'],
    '>='  : [4,'compare(ge,',',',')'],
    '+'   : [5,'number(',')+number(',')'],
    '-'   : [5,'number(',')-number(',')'],
    '*'   : [6,'number(',')*number(',')'],
    'div' : [6,'number(',')/number(',')'],
    'mod' : [6,'number(',')%number(',')']
  },
  functions : {
    // Node Set
    'last'          : [0,'nl.length'],
    'position'      : [0,'(i+1)'],
    'count'         : ['nl','(','.length||0)'],
    'id'            : ['n','id(',')'],
    'local-name'    : ['nl','localName(',')'],
    'namespace-uri' : ['nl','namespaceURI(',')'],
    'name'          : ['nl','qName(',')'],
    // String
    'string'           : ['n','string(',')'],
    'concat'           : [0,'concat(',')'],
    'starts-with'      : [0,'startsWith(',')'],
    'contains'         : [0,'contains(',')'],
    'substring-before' : [0,'substringBefore(',')'],
    'substring-after'  : [0,'substringAfter(',')'],
    'substring'        : [0,'substring(',')'],
    'string-length'    : ['n','string(',').length'],
    'normalize-space'  : ['n','normalizeSpace(',')'],
    'translate'        : [0,'translate(',')'],
    // Boolean
    'boolean' : [0,'bool(',')'],
    'not'     : [0,'!bool(',')'],
    'true'    : [0,'true '],
    'false'   : [0,'false '],
//    'lang'    : [],
    // Number
    'number'  : ['n','number(',')'],
    'floor'   : [0,'Math.floor(number(','))'],
    'ceiling' : [0,'Math.ceil(number(','))'],
    'round'   : [0,'Math.round(number(','))'],
    'sum'     : [0,'sum(',')']
  },
  predicate : function (l) {
    var i = 0;
    if (this.match(/^\[\s*/)) {
      if (i = this.expression(l, l)) {
        this.js.splice(l, 0, 'function(n,i,nl){with(XPath){var r=');
        i++;
        this.js.splice(l + i++, 0, ';return typeof r=="number"?Math.round(r)==i+1:bool(r)}},');
      }
      this.match(/^\]\s*/) || this.error('Missing ]');
    }
    return i;
  },
  nodeTest : function (l, t) {
    var fn;
    if (fn = this.match(/^([a-z]+(?:-[a-z]+)*)\(([^)]*)\)\s*/, this.nodeTypes))
      return fn.call(this, l, this.m[2]);
    if (this.match(/^\*\s*/))
      return this.nodeTypes[t].call(this, l);
    return this.nodeName(l)
  },
  nodeType : function (l, t) {
    this.js.splice(l, 0, 'function(n){return n.nodeType==',t,'},');
    return 3;
  },
  nodeTypes : {
    'node' : function (l) {
      this.js.splice(l, 0, 'null,');
      return 1;
    },
    'element' : function (l) {
      return this.nodeType(l, 1);
    },
    'attribute' : function (l) {
      return this.nodeType(l, 2);
    },
    'text' : function (l) { 
      return this.nodeType(l, 3);
    },
    'processing-instruction' : function (l, t) {
      if (!t) return this.nodeType(l, 7);
      this.js.splice(l, 0, 'function(n){return n.nodeType==7&&n.target==',t,'},');
      return 3;
    },
    'comment' : function (l) {
      return this.nodeType(l, 8);
    }
  },
  nodeName : function (l) {
    if (!this.match(/^([a-zA-Z_]+(?:-?[a-zA-Z0-9]+)*)(?::([a-zA-Z_]+(?:-?[a-zA-Z0-9]+)*))?\s*/, 1)) 
      return 0;
    if (this.m[2]) {
      this.js.splice(l,0,'function(n){if(!nsr)throw new XPathException(14);return "',
        this.m[2],'"==',XPath.ie?'n.baseName':'n.localName','&&nsr.lookupNamespaceURI("',
        this.m[1],'")==n.namespaceURI},');
      return 7;
    }
    else { 
      this.js.splice(l,0,'function(n){return/^',this.m[1],'$/i.test(n.nodeName)},');
      return 3;
    }
  }
};
XPath.order = function (l, r) {
  var x = l.compareDocumentPosition 
        ? l.compareDocumentPosition(r) 
        : XPath.compareDocumentPosition.call(l, r);
  if (x & 32) {
    l = Array.prototype.indexOf.call(l.attributes, l); 
    r = Array.prototype.indexOf.call(r.attributes, r);
    return (l < r) ? -1 : (l > r) ? 1 : 0;
  }
  if (!x) {
    if (l == r)
      return 0;
    if ((l = l.ownerElement) && (r = r.ownerElement))
      return XPath.order(l, r);
    return XPath.ie ? 1 : 0;
  }
  return 3 - ((x & 6) || 3);
};
// Runtime - Operand
XPath.compare = function (fn, l, r) {
  if (l instanceof Array && r instanceof Array) {
    var ls = l.map(this.string), rs = r.map(this.string);
    for (l = ls.length; --l >= 0;)
      for (r = rs.length; --r >= 0;)
        if (!fn(ls[l], rs[r])) return false;
    return true;
  }
  if (l instanceof Array) {
    for (var i = l.length; --i >= 0;) 
      if (!fn(this[typeof r](l[i]), r)) return false;
    return l.length > 0;
  }
  if (r instanceof Array) {
    for (var i = r.length; --i >= 0;) 
      if (!fn(l, this[typeof l](r[i]))) return false;
    return r.length > 0;
  }
  if (typeof l == 'boolean' || typeof r == 'boolean') 
    return fn(this.bool(l), this.bool(r));
  if (typeof l == 'number' || typeof r == 'number') 
    return fn(this.number(l), this.number(r));
  return fn(this.string(l), this.string(r));
};
XPath.eq = function (l, r) { return l == r }; 
XPath.ne = function (l, r) { return l != r }; 
XPath.lt = function (l, r) { return l <  r }; 
XPath.gt = function (l, r) { return l >  r }; 
XPath.le = function (l, r) { return l <= r }; 
XPath.ge = function (l, r) { return l >= r }; 
// Runtime - Node Set
XPath.id = function (s, n) {
  if (arguments.length == 1) n = s;
  var nl = [];
  for (var id = this.string(s).split(/\s+/), i = id.length; --i >= 0;)
    if (s = (n.ownerDocument || n).getElementById(id[i]))
      nl.push(s);
  return nl.sort(this.order);
};
XPath.localName = new Function ('nl',
  'return (nl.length&&nl[0].'+(XPath.ie?'baseName':'localName')+')||""'
);
XPath.namespaceURI = function (nl) {
  return (nl.length && nl[0].namespaceURI) || '';
};
XPath.qName = function (nl) {
  return (nl.length && nl[0].nodeName) || '';
};
XPath.union = function (a, b) {
  if (!a.length) return b;
  if (!b.length) return a;
  var nl = [], i = a.length - 1, j = b.length - 1;
  for (;;) {
    switch (this.order(a[i], b[j])) {
      case -1: nl.unshift(b[j--]); break;
      case  0: j--; // fallthru
      case  1: nl.unshift(a[i--]); break;
      default: throw new Error('Invalid order');
    }
    if (i < 0) {
      if (++j > 0) nl.unshift.apply(nl, nl.slice.call(b, 0, j));
      break;
    }
    if (j < 0) {
      if (++i > 0) nl.unshift.apply(nl, nl.slice.call(a, 0, i));
      break;
    }
  }
  return nl;
};
// Runtime - String
XPath.string = XPath.object = function (v) {
  if (v instanceof Array && typeof (v = v[0]) == 'undefined') return '';
  if (typeof v == 'string') return v;
  switch (v.nodeType) {
    case 1: case 9: case 11:
      return Array.prototype.map.call(v.childNodes, this.string, this).join('');
//      case 3: case 4: case 8: 
//        return v.data || '';
    default: 
      return v.nodeValue || '';
  }
  return String(v);
};
XPath.concat = function () {
  return Array.prototype.map.call(arguments, this.string, this).join('');
};
XPath.startsWith = function (a, b) {
  return this.string(a).substr(0, (b = this.string(b)).length) == b;
};
XPath.contains = function (a, b) {
  return this.string(a).indexOf(this.string(b)) != -1;
};
XPath.substringBefore = function (a, b) {
  a = this.string(a);
  b = a.indexOf(this.string(b));
  return b != -1 ? a.substr(0, b) : '';
};
XPath.substringAfter = function (a, b) {
  a = this.string(a); b = this.string(b);
  var i = a.indexOf(b);
  return i != -1 ? a.substr(i + b.length) : '';
};
XPath.substring = function (s, i, l) {
  s = this.string(s);
  i = Math.round(this.number(i)) - 1;
  return (arguments.length == 2)
       ? s.substr(i < 0 ? 0 : i)
       : s.substr(i < 0 ? 0 : i, Math.round(this.number(l)) - Math.max(0, -i));
};
XPath.normalizeSpace = function(s) {
  return this.string(s).replace(/^\s+/,'').replace(/\s+$/,'').replace(/\s+/g, ' ');
};
XPath.translate = function(a, b, c) {
  a = this.string(a); b = this.string(b); c = this.string(c);
  var o = [], l = a.length, i = 0, j, x;
  while (--l >= 0)
    if (   (j = b.indexOf(x = a.charAt(i++))) == -1
        || (x = c.charAt(j))) o.push(x);
  return o.join('');      
};
// Runtime - Boolean
XPath.bool = XPath['boolean'] = function (v) {
  if (typeof v == 'boolean') return v;
  if (v instanceof Array || typeof v == 'string') return v.length > 0; 
  return Boolean(v);
};
// Runtime - Number
XPath.number = function (v) {
  if (v instanceof Array && typeof (v = v[0]) == 'undefined') return 0;
  if (typeof v == 'number') return v;
  if (typeof v == 'boolean') return v ? 1 : 0;
  return Number(this.string(v));
};
XPath.sum = function (nl) {
  var r = 0, i = nl.length;
  while (--i >= 0) r += this.number(nl[i]);
  return r;
};
// Runtime - Axis
XPath.walk = function (n, nl) {
  var x, c = n.firstChild;
  while (c) {
    nl.push(c);
    if (x = c.firstChild) c = x;
    else for (x = c; !(c = x.nextSibling) && (x = x.parentNode) && (x != n););
  }
  return nl;
};
XPath.axes = {
  'ancestor' : function (n) {
    var nl = [];
    while (n = n.parentNode) nl.unshift(n);
    return nl;
  },
  'ancestor-or-self' : function (n) {
    var nl = [];
    do { nl.unshift(n) } while (n = n.parentNode);
    return nl;
  },
  'attribute' : new Function ('n',
    'var nl = [], a = n.attributes;if(a){attr:for(var x,i=a.length;--i>=0;){if(!(x=a[i]).specified){' +
    (XPath.ie?'switch(x.nodeName){case"selected":case"value":if(x.nodeValue)break;default:continue attr;}' : 'continue;') +
    '}nl.unshift(x);}}return nl;'
  ),
  'child' : function (n) {
    return n.childNodes || [];
  },
  'descendant' : function (n) {
    return this.walk(n, []);
  },
  'descendant-or-self' : function (n) { 
    return this.walk(n, [n]);
  },
  'following' : function (n) {
    var nl = [], x;
    while (n) {
      if (x = n.nextSibling) {
        nl.push(n = x);
        if (x = n.firstChild) nl.push(n = x);
      }
      else n = n.parentNode;
    }
    return nl;
  },
  'following-sibling' : function (n) {
    var nl = [];
    while (n = n.nextSibling) nl.push(n);
    return nl;
  },
  'parent' : function (n) {
    return n.parentNode ? [n.parentNode] : [];
  },
  'preceding' : function (n) {
    var nl = [], x, p = n.parentNode;
    while (n) {
      if (x = n.previousSibling) {
        for (n = x; x = n.lastChild; n = x);
        nl.unshift(n);
      }
      else if (n = n.parentNode) {
        if (n == p) p = p.parentNode; 
        else nl.unshift(n);
      }
    }
    return nl;
  },
  'preceding-sibling' : function (n) {
    var nl = [];
    while (n = n.previousSibling) nl.unshift(n);
    return nl;
  },
  'self' : function (n) {
    return [n];
  },
  'document-root' : function (n) {
    return [n.ownerDocument || n];
  }
};
XPath.axis = function (fn, nt/*, pr..., nl*/) {
  var r, x, al = arguments.length - 1, nl = arguments[al], ap = Array.prototype;
  for (var i = 0, j, l = nl.length; --l >= 0;) {
    x = fn.call(this, nl[i++]);
    if (nt && x.length) x = ap.filter.call(x, nt, this);
    for (j = 2; j < al && x.length; x = ap.filter.call(x, arguments[j++], this));
    r = r ? this.union(r, x) : x;
  }
  return r || [];
};
XPath.cache = {};

/**
 * Extends the native <code>Node</code> class with additional functionality.
 * <p>Not available in Internet Exporer which don&rsquo;t have a <code>Node</code> class.</p>
 * <p>See <a href="http://www.w3.org/TR/2003/WD-DOM-Level-3-Core-20030226/core.html#ID-1950641247" target="_blank">http://www.w3.org/TR/2003/WD-DOM-Level-3-Core-20030226/core.html#ID-1950641247</a></code>.</p>
 * @class Node
 * @author Henrik Lindqvist &lt;<a href="mailto:henrik.lindqvist@llamalab.com">henrik.lindqvist@llamalab.com</a>&gt;
 */
/**
 * Compares a node with this node with regard to their position in the document and according to the document order.
 * <p>When comparing two attribute nodes; <code>32</code> is returned if they have the 
 * same <code>ownerElement</code>, otherwise <code>0</code>. This is probably not standard, 
 * but it&rsquo;s what Firefox return, so we do the same.</p>
 * <pre>
 * DOCUMENT_POSITION_DISCONNECTED            = 1;
 * DOCUMENT_POSITION_PRECEDING               = 2;
 * DOCUMENT_POSITION_FOLLOWING               = 4;
 * DOCUMENT_POSITION_CONTAINS                = 8;
 * DOCUMENT_POSITION_IS_CONTAINED            = 16;
 * DOCUMENT_POSITION_IMPLEMENTATION_SPECIFIC = 32;
 * </pre>
 * <p>See <a href="http://www.w3.org/TR/2003/WD-DOM-Level-3-Core-20030226/core.html#Node3-compareDocumentPosition" target="_blank">http://www.w3.org/TR/2003/WD-DOM-Level-3-Core-20030226/core.html#Node3-compareDocumentPosition</a></code>.</p>
 * @function {number} compareDocumentPosition
 * @param {Node} n - node to compare against. 
 * @returns <code>0</code> for nodes are equals or a number with some of the above bits set.
 */
/**
 * Check if this node contains another node.
 * @function {boolean} contains
 * @param {Node} n - node to compare against. 
 * @returns <code>true</code> if <code>this</code> node cotains node <code>n</code>.
 */
function compareDocumentPosition (n) {
  if (this == n) return 0; // Same
  if (this.nodeType == 2 && n.nodeType == 2)
    return (this.ownerElement && this.ownerElement == n.ownerElement) ? 32 : 0; // IMPLEMENT_SPECIFIC
  var l = this.ownerElement || this, r = n.ownerElement || n;
  if (l.sourceIndex >= 0 && r.sourceIndex >= 0 && l.contains && r.contains) {
    return (
        ((l.contains(r)                 && 16) || (r.contains(l)                 && 8))
      | ((l.sourceIndex < r.sourceIndex &&  4) || (r.sourceIndex < l.sourceIndex && 2))
    ) || 1;
  }
  var la = l, ra = r, ld = 0, rd = 0;
  while (la = la.parentNode) ld++;
  while (ra = ra.parentNode) rd++;
  if (ld > rd) {
    while (ld-- != rd) l = l.parentNode;
    if (l == r) return 2|8;  // Preceding|Contains
  }
  else if (rd > ld) {
    while (rd-- != ld) r = r.parentNode; 
    if (r == l) return 4|16; // Following|Contained By
  }
  while ((la = l.parentNode) != (ra = r.parentNode)) 
    if (!(l = la) || !(r = ra)) return 1; // Disconnected
  while (l = l.nextSibling) 
    if (l == r) return 4; // Following
  return 2;  // Preceding
};
if (w.Node) {
  var np = w.Node.prototype;
  if (f || !np.compareDocumentPosition)
    np.compareDocumentPosition = compareDocumentPosition;
  if (f || !np.contains) {
  	np.contains = function (n) {
		  return Boolean(this.compareDocumentPosition(n) & 16);
	  };
  }
}
else 
  XPath.compareDocumentPosition = compareDocumentPosition;
/**
 * Exception throw when parser or expression fails. 
 * <p>See <code><a href="http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathException" target="_blank">http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathException</a></code>.</p>
 * @class XPathException
 * @author Henrik Lindqvist &lt;<a href="mailto:henrik.lindqvist@llamalab.com">henrik.lindqvist@llamalab.com</a>&gt;
 */
/**
 * Namespace error.
 * @property {static read number} NAMESPACE_ERR
 */
/**
 * Expression syntax error.
 * @property {static read number} INVALID_EXPRESSION_ERR
 */
/**
 * Result type error.
 * @property {static read number} TYPE_ERR
 */
/**
 * XPathException constructor.
 * @constructor XPathException
 * @param {number} c - error code.
 * @param {string} m - error message.
 * @see NAMESPACE_ERR
 * @see INVALID_EXPRESSION_ERR
 * @see TYPE_ERR
 */
/**
 * Exception name.
 * @property {read string} name
 */
/**
 * Exception code.
 * @property {read number} code
 * @see NAMESPACE_ERR
 * @see INVALID_EXPRESSION_ERR
 * @see TYPE_ERR
 */
/**
 * Exception message.
 * @property {read string} message
 */
if (f || !w.XPathException) {
  function XPathException (c, m) {
    this.name = 'XPathException';
    this.code = c;
    this.message = m;
  }
  var e = XPathException, p = new Error;
  p.toString = function () { 
    return this.name+':'+this.message;
  };
  e.prototype = p;
  e.NAMESPACE_ERR          = 14;
  e.INVALID_EXPRESSION_ERR = 51;
  e.TYPE_ERR               = 52;
  w.XPathException = e;
}
/**
 * Namespace resolver.
 * <p>See <code><a href="http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathNSResolver" target="_blank">http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathNSResolver</a></code>.</p>
 * @class XPathNSResolver
 * @see XPathEvaluator.createNSResolver
 * @author Henrik Lindqvist &lt;<a href="mailto:henrik.lindqvist@llamalab.com">henrik.lindqvist@llamalab.com</a>&gt;
 */
/**
 * Look up a namespace URI by it&rsquo;s prefix use in document.
 * @function {string} lookupNamespaceURI
 * @param {string} p - <code>xmlns:</code> prefix, empty string for <code>targetNamespace</code>. 
 * @returns associated namespace URI, or <code>undefined</code> if none is found.
 */
if (f || !w.XPathNSResolver) {  
  function XPathNSResolver (n) {
    this.ns = {};
    for (var m, a, i = n.attributes.length; --i >= 0;)
      if (m = /xmlns:(.+)/.exec((a = n.attributes[i]).nodeName))
        this.ns[m[1]] = a.nodeValue;
    this.ns[''] = n.getAttribute('targetNamespace');
  }
  XPathNSResolver.prototype = {
    lookupNamespaceURI : function (p) { 
      return this.ns[p || ''];
    }
  };
  w.XPathNSResolver = XPathNSResolver;
}
/**
 * A pre-parsed XPath expression.
 * <p>See <code><a href="http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathExpression" target="_blank">http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathExpression</a></code>.</p>
 * @class XPathExpression
 * @see XPathEvaluator.createExpression
 * @author Henrik Lindqvist &lt;<a href="mailto:henrik.lindqvist@llamalab.com">henrik.lindqvist@llamalab.com</a>&gt;
 */
/**
 * Evaluate this pre-parsed expression.
 * @function {XPathResult} evaluate
 * @param {Node} n - context node.
 * @param {number} rt - return type, see <code>{@link XPathResult}</code>.
 * @param {XPathResult} r - <code>{@link XPathResult}</code> that maybe reuse, or <code>null</code>.
 * @returns a <code>{@link XPathResult}</code>.
 */
if (f || !w.XPathExpression) {
  function XPathExpression (e, nsr) {
    this.fn = XPath.cache[e] || (XPath.cache[e] = new XPath(e));
    this.nsr = nsr;
  }
  XPathExpression.prototype = {
    evaluate : function (n, rt) {
      return new XPathResult(this.fn(n, this.nsr), rt);
    }
  };
  w.XPathExpression = XPathExpression;
}
/**
 * Container for XPath results.
 * <p>See <code><a href="http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathResult" target="_blank">http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathResult</a></code>.</p>
 * @class XPathResult
 * @see XPathEvaluator.evaluate
 * @see XPathExpression.evaluate
 * @author Henrik Lindqvist &lt;<a href="mailto:henrik.lindqvist@llamalab.com">henrik.lindqvist@llamalab.com</a>&gt;
 */
/**
 * Result will be accessed unconverted as the expression returned it.
 * @property {static read number} ANY_TYPE
 */
/**
 * Result will be accessed as a number.  
 * @property {static read number} NUMBER_TYPE
 * @see numberValue
 */
/**
 * Result will be accessed as a string.  
 * @property {static read number} STRING_TYPE
 * @see stringValue
 */
/**
 * Result will be accessed as boolean.  
 * @property {static read number} BOOLEAN_TYPE
 * @see booleanValue
 */
/**
 * Result will be accessed iteratively, node order insignificant.
 * <p>This is equal to <code>{@link ORDERED_NODE_ITERATOR_TYPE}</code> 
 * since the result is always document-ordered.</p>
 * @property {static read number} UNORDERED_NODE_ITERATOR_TYPE
 * @see iterateNext
 */
/**
 * Result will be accessed iteratively which must be document-ordered.  
 * @property {static read number} ORDERED_NODE_ITERATOR_TYPE
 * @see iterateNext
 */
/**
 * Result will be accessed as a snapshot list of nodes, node order insignificant.  
 * <p>This is equal to <code>{@link ORDERED_NODE_SNAPSHOT_TYPE}</code> 
 * since the result is always document-ordered.</p>
 * @property {static read number} UNORDERED_NODE_SNAPSHOT_TYPE
 * @see snapshotLength
 * @see snapshotItem
 */
/**
 * Result will be accessed as a snapshot list of nodes which must be document-ordered.  
 * @property {static read number} ORDERED_NODE_SNAPSHOT_TYPE
 * @see snapshotLength
 * @see snapshotItem
 */
/**
 * Result will be accessed as a single node value, any of the resulting nodes.
 * <p>This is equal to <code>{@link FIRST_ORDERED_NODE_TYPE}</code> 
 * since the result is always document-ordered.</p>
 * @property {static read number} ANY_UNORDERED_NODE_TYPE
 * @see singleNodeValue
 */
/**
 * Result will be accessed as a single node value, the first resulting node in document-ordered.
 * @property {static read number} FIRST_ORDERED_NODE_TYPE
 * @see singleNodeValue
 */
/**
 * Convert result to number.  
 * @property {static read number} NUMBER_TYPE
 */
/**
 * Convert result to number.  
 * @property {static read number} NUMBER_TYPE
 */
/**
 * Convert result to number.  
 * @property {static read number} NUMBER_TYPE
 */
/**
 * Convert result to number.  
 * @property {static read number} NUMBER_TYPE
 */
/**
 * Convert result to number.  
 * @property {static read number} NUMBER_TYPE
 */
/**
 * Resulting number.  
 * @property {read number} numberValue
 * @see NUMBER_TYPE
 */
/**
 * Resulting string.  
 * @property {read string} stringValue
 * @see STRING_TYPE
 */
/**
 * Resulting boolean.  
 * @property {read boolean} booleanValue
 * @see BOOLEAN_TYPE
 */
/**
 * Signifies that the iterator has become invalid.  
 * @property {read boolean} invalidIteratorState
 * @see UNORDERED_NODE_ITERATOR_TYPE
 * @see ORDERED_NODE_ITERATOR_TYPE
 */
/**
 * The number of nodes in the result snapshot. 
 * @property {read number} snapshotLength
 * @see UNORDERED_NODE_SNAPSHOT_TYPE
 * @see ORDERED_NODE_SNAPSHOT_TYPE
 */
/**
 * The value of this single node result, maybe <code>undefined</code>. 
 * @property {read object} singleNodeValue
 * @see ANY_UNORDERED_NODE_TYPE
 * @see FIRST_ORDERED_NODE_TYPE
 */
/**
 * Unconverted result as returned by our internal evaluator.
 * <p>This is a non-standard property which is set to the raw unconverted result from our 
 * expression evaluator. It&rsquo;s of the type <code>number</code>, <code>string</code>,
 * <code>boolean</code> or an <code>{@link Array}</code> with nodes depending on expression.
 * If you prefer to work with arrays instead of <code>{@link XPathResult.snapshotItem}</code>
 * You can check for this property and use it directly.</p>
 * <h3>Example</h3>
 * <pre>
 * function selectNodes (expr) {
 *   // Cross-browser safe way of selecting nodes and return an Array 
 *   var r = document.evaluate('//LI', document, null, 7, null);
 *   if (typeof r.value != 'undefined') return r.value;
 *   var a = [];
 *   for (var i = r.snapshotLength; --i >= 0; a[i] = r.snapshotItem(i));
 *   return a;
 * }
 * </pre>
 * @property {read object} value
 * @see ANY_TYPE
 */
/**
 * Iterates and returns the next node from the resuling nodes.
 * @function {object} iterateNext
 * @returns a <code>Node</code>, or <code>undefined</code> if there are no more nodes.
 */
/**
 * Returns the <code>index</code>th item in the snapshot collection.
 * @function {object} snapshotItem
 * @param {number} i - index of resuling node to return.
 * @returns the <code>Node</code>, at provided index or <code>undefined</code> if invalid.
 */
if (f || !w.XPathResult) {
  function XPathResult (r, rt) {
    if (rt == 0) {
      switch (typeof r) {
        default:        rt++;
        case 'boolean': rt++;
        case 'string':  rt++;
        case 'number':  rt++;
      }
    }
    this.resultType = rt;
    switch (rt) {
      case 1:
        this.numberValue = XPath.number(r);
        return;
      case 2: 
        this.stringValue = XPath.string(r);
        return;
      case 3: 
        this.booleanValue = XPath.bool(r); 
        return;
      case 4: 
      case 5:
        if (r instanceof Array) {
          this.value = r;
          this.index = 0;
          this.invalidIteratorState = false;
          return;
        }        
        break;
      case 6: 
      case 7:
        if (r instanceof Array) {
          this.value = r;
          this.snapshotLength = r.length;
          return;
        }
        break;
      case 8: 
      case 9: 
        if (r instanceof Array) {
          this.singleNodeValue = r[0];
          return;
        }
    }
    throw new XPathException(52);
  }
  var r = XPathResult;
  r.ANY_TYPE                      = 0;
  r.NUMBER_TYPE                   = 1;
  r.STRING_TYPE                   = 2;
  r.BOOLEAN_TYPE                  = 3;
  r.UNORDERED_NODE_ITERATOR_TYPE  = 4;
  r.ORDERED_NODE_ITERATOR_TYPE    = 5;
  r.UNORDERED_NODE_SNAPSHOT_TYPE  = 6;
  r.ORDERED_NODE_SNAPSHOT_TYPE    = 7;
  r.ANY_UNORDERED_NODE_TYPE       = 8;
  r.FIRST_ORDERED_NODE_TYPE       = 9;
  r.prototype = {
    iterateNext : function () {
      switch (this.resultType) {
        case 4: 
        case 5:
          return this.value[this.index++];
      }
      throw new XPathException(52);
    },
    snapshotItem : function (i) {
      switch (this.resultType) {
        case 6: 
        case 7:
          return this.value[i];
      }
      throw new XPathException(52);
    }
  };
  w.XPathResult = r;
}
/**
 * An interface with the XPath functionality.
 * <p><code>Document.prototype</code> and/or <code>document</code> will be 
 * extended using <code>{@link install}</code> to implements it&rsquo;s functions.</p> 
 * <p>See <code><a href="http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathEvaluator" target="_blank">http://www.w3.org/TR/DOM-Level-3-XPath/xpath.html#XPathEvaluator</a></code>.</p>
 * @interface XPathEvaluator
 * @author Henrik Lindqvist &lt;<a href="mailto:henrik.lindqvist@llamalab.com">henrik.lindqvist@llamalab.com</a>&gt;
 */
/**
 * Non-standard function that extends the provided object with <code>{@link XPathEvaluator}</code> functions.
 * @function {static} install
 * @param {object} o - object (i.e document node) to extend.
 * @param {optional boolean} f - force replace the build-in function even if they exists.
 */
/**
 * Creates a pre-parsed expression.
 * @function {XPathExpression} createExpression
 * @param {string} e - expression.
 * @param {XPathNSResolver} nsr - namespace resolver to use when evaluating, or <code>null</code>.
 * @returns a new <code>{@link XPathExpression}</code>.
 */
/**
 * Create a namespace resolver by scanning a node for <code>xmlns:</code> attributes.
 * @function {XPathNSResolver} createNSResolver
 * @param {Node} n - an <code>Node</code> with defined namespace attributes (i.e the documentElement).
 * @returns a new <code>{@link XPathNSResolver}</code>.
 */
/**
 * Evaluate an expression.
 * <p>Same as <code>new XPathExpression(e, nsr).evaluate(n, rt)</code>.</p>
 * @function {XPathResult} evaluate
 * @param {string} e - XPath expression string.
 * @param {Node} n - context node.
 * @param {XPathNSResolver} nsr - namespace resolver to use when evaluating, or <code>null</code>.
 * @param {number} rt - return type, see <code>{@link XPathResult}</code>.
 * @param {XPathResult} r - <code>{@link XPathResult}</code> that maybe reuse, or <code>null</code>. Ignored.
 * @returns a <code>{@link XPathResult}</code>.
 */
if (f || !w.XPathEvaluator) {
  function XPathEvaluator () {}
  var e = XPathEvaluator;
  e.prototype = {
    createExpression : function (e, nsr) {
      return new XPathExpression(e, nsr);
    },
    createNSResolver : function (n) {
      return new XPathNSResolver(n);
    },
    evaluate : function (e, n, nsr, rt) {
      return new XPathExpression(e, nsr).evaluate(n, rt);
    }
  };
  e.install = function (o, f) {
    for (var k in XPathEvaluator.prototype) 
      if (f || !o[k]) o[k] = XPathEvaluator.prototype[k];
  };
  w.XPathEvaluator = e;
  if (w.Document)
    e.install(w.Document.prototype, f);
  else 
    e.install(document, f);
  w.XPath = XPath;
}

})(window, document, /WebKit/.test(navigator.userAgent)); // force replace?
