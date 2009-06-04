// (C) 2008 henrik.lindqvist@llamalab.com

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
return true;return false;};}})(Array.prototype);// Copyright 2006 Google Inc.
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
/*
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
/* jsfromhell.com
copyright notice:
"We authorize the copy and modification of all the codes on the site, since if you keep the original author name."

http://jsfromhell.com/array/diff
**************************************
* diff Function v1.0                 *
* Autor: Carlos R. L. Rodrigues      *
**************************************
patched: 2006-12-18
- renamed function to arrDiff
- now works also with empty vector arrays
Alessandro Curci
*/
arrDiff = function(v, c, m){
	if(!v.length){v.push(''); c.push(''); var p=1;}; 
	var d = [], e = -1, h, i, j, k;
	for(i = c.length, k = v.length; i--;){
		for(j = k; j && (h = c[i] !== v[--j]););
		h && (d[++e] = m ? i : c[i]);
	}
	if(p){v.pop(); c.pop(); };
	return d;
};
/* jsfromhell.com
copyright notice:
"We authorize the copy and modification of all the codes on the site, since if you keep the original author name."

http://jsfromhell.com/geral/date-format
**************************************
* Date.format Function v1.0          *
* Autor: Carlos R. L. Rodrigues      *
**************************************
*/
Date.prototype.format = function(m, r){
    var d = this, a, fix = function(n, c){return (n = n + "").length < c ? new Array(++c - n.length).join("0") + n : n};
    var r = r || {}, f = {j: function(){return d.getDate()}, w: function(){return d.getDay()},
        y: function(){return (d.getFullYear() + "").slice(2)}, Y: function(){return d.getFullYear()},
        n: function(){return d.getMonth() + 1}, m: function(){return fix(f.n(), 2)},
        g: function(){return d.getHours() % 12 || 12}, G: function(){return d.getHours()},
        H: function(){return fix(d.getHours(), 2)}, h: function(){return fix(f.g(), 2)},
        d: function(){return fix(f.j(), 2)}, N: function(){return f.w() + 1},
        i: function(){return fix(d.getMinutes(), 2)}, s: function(){return fix(d.getSeconds(), 2)},
        ms: function(){return fix(d.getMilliseconds(), 3)}, a: function(){return d.getHours() > 11 ? "pm" : "am"},
        A: function(){return f.a().toUpperCase()}, O: function(){return d.getTimezoneOffset() / 60},
        z: function(){return (d - new Date(d.getFullYear() + "/1/1")) / 864e5 >> 0},
        L: function(){var y = f.Y(); return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},
        t: function(){var n; return (n = d.getMonth() + 1) == 2 ? 28 + f.L() : n & 1 && n < 8 || !(n & 1) && n > 7 ? 31 : 30},
        W: function(){
            var a = f.z(), b = 364 + f.L() - a, nd = (new Date(d.getFullYear() + "/1/1").getDay() || 7) - 1;
            return (b <= 2 && ((d.getDay() || 7) - 1) <= 2 - b) ? 1 :
                (a <= 2 && nd >= 4 && a >= (6 - nd)) ? new Date(d.getFullYear() - 1 + "/12/31").format("%W%") :
                (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
        }
    }
    return String(m).replace(/%(.*?)%/g, function(t, s){
        return r[s] ? r[s](d, function(s){return f[s] && f[s]();}) : f[s] ? f[s]() : "%" + (s && s + "%");
    });
};

Date.ISO8601 = '%Y%-%m%-%d%T%H%:%i%:%s%%O%';
Date.ISO8601c = '%Y%%m%%d%T%H%:%i%:%s%%O%';


/* Code based on function originaly posted from Paul Sowden @ http://delete.me.uk/2005/03/iso8601.html, March 26, 2005 
   The function was then absorbed into the Dojo Toolkit's dojo.date module under BSD license *or* Academic Free License version 2.1
*/
//
// Parses a string in the ISO 8601 format YYYY-MM-DDThh:mm:ss(.s)(TZD)
// to a Date object, where:
//
//     YYYY = four-digit year
//     MM   = two-digit month (01 = January, etc.)
//     DD   = two-digit day of month (01 through 31)
//     hh   = two digits of hour (00 through 23) (am/pm NOT allowed)
//     mm   = two digits of minute (00 through 59)
//     ss   = two digits of second (00 through 59)
//     s    = one or more digits representing a decimal fraction of a second
//     TZD  = time zone designator (Z or +hh:mm or -hh:mm)
//
// Examples:
//      
//     1994-11-05T08:15:30-05:00 corresponds to
//       November 5, 1994, 8:15:30 am, US Eastern Standard Time.
//
//     1994-11-05T13:15:30Z corresponds to the same instant.
//
// The returned Date object is in local time. If the input is a Date
// object then it is returned verbatim.
//
// See also: http://www.w3.org/TR/NOTE-datetime
//
// *** IMPORTANT! ***
//
// The current implementation parses the fractional part of the
// second but does not use it. The returned Date object is accurate
// to the second only.
//


Date.prototype.setISO8601 = function (string) {
    var regexp = "(^[0-9]{4})(-?([0-9]{2})(-?([0-9]{2})" +
        "(T([0-9]{2}):([0-9]{2})(:([0-9]{2})(\.([0-9]+))?)?" +
        "(Z|(([-+])([0-9]{2}):([0-9]{2})))?)?)?)?";
	
    var d = string.match(new RegExp(regexp));

    var offset = 0;
    var date = new Date(d[1], 0, 1);

    if (d[3]) { date.setMonth(d[3] - 1); }
    if (d[5]) { date.setDate(d[5]); }
    if (d[7]) { date.setHours(d[7]); }
    if (d[8]) { date.setMinutes(d[8]); }
    if (d[10]) { date.setSeconds(d[10]); }
    if (d[12]) { date.setMilliseconds(Number("0." + d[12]) * 1000); }
    if (d[14]) {
        offset = (Number(d[16]) * 60) + Number(d[17]);
        offset *= ((d[15] == '-') ? 1 : -1);
    }

    offset -= date.getTimezoneOffset();
    time = (Number(date) + (offset * 60 * 1000));
    this.setTime(Number(time));
};
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
		var SPACE_SX = new RegExp('^'+String.fromCharCode(32)+'*','m');
		var SPACE_DX = new RegExp('$'+String.fromCharCode(32)+'*','m');
		var SPACE_DBL = new RegExp(String.fromCharCode(32)+'{2,}','gm');
		var NBSP = new RegExp(String.fromCharCode(160),'gm');
		while (node) {
			//console.log(node.nodeType);
			var nextNode = node.nextSibling;
			
			if (node.nodeType == 3) {
				if(!/\S/.test(node.nodeValue) && !NBSP.test(node.nodeValue)) {
					element.removeChild(node);
				} else {
					var str = node.nodeValue;						
						str = str.replace(/[\t\n\r\f]/gm,'');						
						str = str.replace(SPACE_DBL,String.fromCharCode(160));						
						str = str.replace(SPACE_SX,String.fromCharCode(160));
						str = str.replace(SPACE_DX,String.fromCharCode(160));
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
			if (userSelection.getRangeAt) {
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
			
			// fix for browsers giving endContainer.parent as result when selecting over a <br/> tag
			if(endContainer.nodeType == 1) {
			  var t = endContainer.childNodes;
			  //console.log(t);
			  var o = t[endOffset];
			  if(o.tagName.toLowerCase() == "br") {
				o = o.previousSibling;
				if(o.nodeType == 1) {
				 o = $(o).textNodes(true);
				 endContainer = o[o.length-1];
				 endOffset = endContainer.length-1;
				}
			  }
			}			
			
			if(reset) userSelection.removeAllRanges();
								
		} else if (document.selection) {
		  
		  try {

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
//=================================================					
//console.log(endSiblings[Eidx].nodeValue);
//=================================================
					chrSum += endSiblings[Eidx].length;
					Eidx++;
				}
			
				endOffset -= prevSum;
				endContainer = endSiblings[--Eidx];
			}
			endOffset = Math.min(endOffset, endContainer.length);

			if(reset) userSelection.empty();
		  
		  } catch(err) {
			if(eMend.log) {
			  err.funct = '$.getSelection';
			  //err.selection = $.getSelectedText();
			  eMend.log.add('warning',err);
			}
		  }
		  
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
 * jGrowl 1.2.0
 *
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Written by Stan Lemon <stanlemon@mac.com>
 * Last updated: 2009.05.11
 *
 * jGrowl is a jQuery plugin implementing unobtrusive userland notifications.  These 
 * notifications function similarly to the Growl Framework available for
 * Mac OS X (http://growl.info).
 *
 * To Do:
 * - Move library settings to containers and allow them to be changed per container
 *
 * Changes in 1.2.0
 * - Added message pooling to limit the number of messages appearing at a given time.
 * - Closing a notification is now bound to the notification object and triggered by the close button.
 *
 * Changes in 1.1.2
 * - Added iPhone styled example
 * - Fixed possible IE7 bug when determining if the ie6 class shoudl be applied.
 * - Added template for the close button, so that it's content could be customized.
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
		if ( $('#jGrowl').size() == 0 ) $('<div id="jGrowl"></div>').addClass($.jGrowl.defaults.position).appendTo('body');
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
					$(this).data('jGrowl.instance').create( m , o );
				}
			});
		};
	};

	$.extend( $.fn.jGrowl.prototype , {

		/** Default JGrowl Settings **/
		defaults: {
			pool: 			0,
			header: 		'',
			group: 			'',
			sticky: 		false,
			position: 		'top-right', // Is this still needed?
			glue: 			'after',
			theme: 			'default',
			corners: 		'10px',
			check: 			250,
			life: 			3000,
			speed: 			'normal',
			easing: 		'swing',
			closer: 		true,
			closeTemplate: '&times;',
			closerTemplate: '<div>[ close all ]</div>',
			log: 			function(e,m,o) {},
			beforeOpen: 	function(e,m,o) {},
			open: 			function(e,m,o) {},
			beforeClose: 	function(e,m,o) {},
			close: 			function(e,m,o) {},
			animateOpen: 	{
				opacity: 	'show'
			},
			animateClose: 	{
				opacity: 	'hide'
			}
		},
		
		notifications: [],
		
		/** jGrowl Container Node **/
		element: 	null,
	
		/** Interval Function **/
		interval:   null,
		
		/** Create a Notification **/
		create: 	function( message , o ) {
			var o = $.extend({}, this.defaults, o);

			this.notifications[ this.notifications.length ] = { message: message , options: o };
			
			o.log.apply( this.element , [this.element,message,o] );
		},
		
		render: 		function( notification ) {
			var self = this;
			var message = notification.message;
			var o = notification.options;

			var notification = $('<div class="jGrowl-notification' + ((o.group != undefined && o.group != '') ? ' ' + o.group : '') + '"><div class="close">' + o.closeTemplate + '</div><div class="header">' + o.header + '</div><div class="message">' + message + '</div></div>')
				.data("jGrowl", o).addClass(o.theme).children('div.close').bind("click.jGrowl", function() {
					$(this).parent().trigger('jGrowl.close');
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
				$(this).trigger('jGrowl.beforeClose').animate(o.animateClose, o.speed, o.easing, function() {
					$(this).remove();
					o.close.apply( self.element , [self.element,message,o] );
				});
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
					$(this).trigger('jGrowl.close');
				}
			});

			if ( this.notifications.length > 0 && (this.defaults.pool == 0 || $(this.element).find('div.jGrowl-notification:parent').size() < this.defaults.pool) ) {
				this.render( this.notifications.shift() );
			}

			if ( $(this.element).find('div.jGrowl-notification:parent').size() < 2 ) {
				$(this.element).find('div.jGrowl-closer').animate(this.defaults.animateClose, this.defaults.speed, this.defaults.easing, function() {
					$(this).remove();
				});
			};
		},

		/** Setup the jGrowl Notification Container **/
		startup:	function(e) {
			this.element = $(e).addClass('jGrowl').append('<div class="jGrowl-notification"></div>');
			this.interval = setInterval( function() { 
				jQuery(e).data('jGrowl.instance').update(); 
			}, this.defaults.check);
			
			if ($.browser.msie && parseInt($.browser.version) < 7 && !window["XMLHttpRequest"]) $(this.element).addClass('ie6');
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
eMend.dictionary = {
  comment: {
    "delete_note_H": "Elimina questo commento",
    "edit_note_H": "Modifica questo commento",
    "author": "autore",
    "baseURI": "images"
  },
  comment_more: {
    "read_more": "Espandi il testo",
    "read_less": "Riduci il testo",    
    "baseURI": "images"
  },  
  commentForm: {
    "comment": "commento",
    "note": "nota",
    "subject": "oggetto",
    "cancel": "annulla",
    "confirm": "conferma",
    "tags": "tags"
  },
  commentGroup: {
    "read_more": "Espandi il gruppo",
    "read_less": "Riduci il gruppo",
    "comment": "commento",
    "comments": "commenti",
    "baseURI": "images"    
  },
  commentTrigger: {
    "select_text": "seleziona il testo che vuoi commentare",
    "activate_comment": "premi 'C' per commentare il testo selezionato",
    "write_comment": "scrivi nel commento ci&ograve; che pensi",
    "disable_HOL": "non mostrare pi&ugrave; i messaggi di aiuto",
    "outside_boudaries": "la selezione &egrave; fuori dall'area commentabile",
    "login_needed": "per inviare un commento &egrave; necessario il login"
  },
  sidebar: {
    "hidelink": "Nascondi collegamento visuale",
    "showlink": "Mostra collegamento visuale",
    "baseURI": ""
  }
};
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.users = function (options) {
  
  if ( !(this instanceof arguments.callee) ) 
  return new eMend.users(options);
  
  this.opts = $.extend({}, eMend.users.defaults, options);

// INTERNAL PROPERTIES
  this._currentUser = null;

// INIT

};

eMend.users.defaults = {};

eMend.users.prototype = {
  login: function(event,data){
    this._currentUser = data.name;
    this.opts.dataset.loginAs(this._currentUser);
  },
  
  logout: function(){
    this._currentUser = null;
  },
  
  getCurrentUser: function() {
    return this._currentUser;
  }  
};

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.templates = {

comment: '<div class="actions"><a href="#" title="_(delete_note_H)" class="deletenote" onclick="return false;">&nbsp;</a><a href="#" title="_(edit_note_H)" class="editnote" onclick="return false;">&nbsp;</a></div><h6><img src="_(baseURI)/user${userIdx}.png" /><strong>${author}</strong> [${date}]:</h6><h5>${title}</h5><p><span class="commentbody">${body}</span></p>',

comment_more: '...<img src="_(baseURI)/more.png" alt="_(readmore)" class="readmore" /><img src="_(baseURI)/less.png" alt="_(readless)" class="readless" style="display:none;" />', 

commentForm: '<form id="noteForm" class="Emend" onsubmit="return false; void(0);" style="background-image: url(_(baseURI)/bg-fff-diag.gif);"><fieldset><legend>_(comment)</legend><p><label for="noteSubject">_(subject):</label><span><input type="text" id="noteSubject" name="noteSubject" size="29" /></span><br/></p><p><label for="noteText">_(note):</label><span><textarea id="noteText" name="noteText" cols="28" rows="10" ></textarea></span><br class="clear"/></p><!--<p><label for="noteTags">_(tags):</label><span><input type="text" id="noteTags" name="noteTags" size="29" /></span><br/></p>--><p class="Emend-right"><button type="button" class="submit" id="submitNote" onclick="return false; void(0);" style="background: #FFFFFF url(_(baseURI)/bg_form_element.png) repeat-x;"><span class="ico confirm">_(confirm)<img src="_(baseURI)/ico-confirm.png" /></span></button></p><p class="Emend-left"><button type="button" class="submit" id="cancelNote" onclick="return false; void(0);" style="background: #FFFFFF url(_(baseURI)/bg_form_element.png) repeat-x;"><span class="ico cancel"><img src="_(baseURI)/ico-cancel.png" />_(cancel)</span></button></p></fieldset></form>',

commentGroup: '<span><div class="nodetoggle"><img src="_(baseURI)/less_big.png" alt="_(readless)" class="closegroup"><img src="_(baseURI)/more_big.png" title="_(readmore)" class="opengroup" /></div></span>',

commentTrigger: '<ul class="lavalamp"><li><div class="HOLbg" style="background-image: url(_(baseURI)/orange-gradient.png);"><img src="_(baseURI)/selectText.png"/><h2 class="helpOnLine"><span class="pulse" unselectable="on">_(select_text)</span></h2></div><label><input type="checkbox" class="emendHideHOL"/>_(disable_HOL)</label></li><li><div class="HOLbg" style="background-image: url(_(baseURI)/orange-gradient.png);"><img src="_(baseURI)/pressC.png"/><h2 class="helpOnLine"><span class="pulse" unselectable="on">_(activate_comment)</span></h2></div></li><li><div class="HOLbg" style="background-image: url(_(baseURI)/orange-gradient.png);"><img src="_(baseURI)/chat.png"/><h2 class="helpOnLine"><span class="pulse" unselectable="on">_(write_comment)</span></h2></div></li><li><div class="HOLbg" style="background-image: url(_(baseURI)/orange-gradient.png);"><img src="_(baseURI)/selectText.png"/><h2 class="helpOnLine"><span class="pulse" unselectable="on">_(outside_boudaries)</span></h2></div></li><li><div class="HOLbg" style="background-image: url(_(baseURI)/orange-gradient.png);"><img src="_(baseURI)/password.png"/><h2 class="helpOnLine"><span class="pulse" unselectable="on">_(login_needed)</span></h2></div></li></ul>',

sidebar: '<div class="sidebar-Y-header"><img src="_(baseURI)/ico-arrow-left.png" class="opensidebar" /><p class="version">0.3<br/>&beta;4</p><img src="_(baseURI)/emend-vertical.png" alt="e-mend"/></div><div class="sidebar-wrapper"><div class="sidebar-X-header"><!--<div class="extendsidebar"></div>--><img src="_(baseURI)/ico-arrow-right.png" class="closesidebar" /><img src="_(baseURI)/emend-horizontal.png" class="logo" alt="e-mend"/><sup class="version">0.3&beta;4</sup></div><div id="sidebar-body"></div><div id="memefarmers"><a href="http://memefarmers.net"><img src="_(baseURI)/memefarmers.png" /></a></div></div>'
}

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.dataset = function (options) {
  
  if ( !(this instanceof arguments.callee) ) 
  return new eMend.dataset(options);
  
  this.opts = $.extend({}, eMend.dataset.defaults, options);

// INTERNAL PROPERTIES 
  this._selections = [];
  this._comments = [];
  this._users =  [];
  this._usersByName = {};
  this._currentUser = -1;

  this._notesByDate = {};
  this._notesFirstDate = null;
  this._notesLastDate = null;
  this._timeRange = [];

  this._filteredNodes = {};
  this._nodeCommentsCount = {};
  this._contentBkp = [];

// INIT
  this.bkpContent(this.opts.target);
  this._contentEl = this.opts.target;
  this.initNodeFilters(this.opts.target,false);
  this.loginAsGuest();
};

eMend.dataset.defaults = {};


eMend.dataset.prototype = {
	
  getContentEl: function () {
		return this._contentEl;
  },

  getTimeRange: function () {
		if(!this._timeRange.length) this.initTimeRangeFilters();
		return this._timeRange;
  },

  getNotesFirstDate: function () {
		if(!this._notesFirstDate) this.updateNotesByDate();
		return this._notesFirstDate;
  },

  getNotesLastDate: function () {
		if(!this._notesLastDate) this.updateNotesByDate();
		return this._notesLastDate;
  },

  getSelections: function () {
		return this._selections;
  },

  getComments: function () {
		return this._comments;
  },

  getComment: function (userIdx,commentIdx) {
      return this._comments[userIdx][commentIdx];
  },

  getCommentData: function (userIdx,commentIdx) {
      var c = this._comments[userIdx][commentIdx];
      return {
          title: c[0],
          body: c[1],
          date: c[2],
          userIdx: userIdx
      }
  },
  
  getCommentElement: function (userIdx,commentIdx) {
      var c = this._comments[userIdx][commentIdx];
      return c.getElement();
  },	
	
  getCurrentUser: function () {
		return this._currentUser;
  },
	
  setCurrentUser: function (idx) {
	  if(typeof idx == "number") this._currentUser = idx;
  },	
	

  getFilteredNodes: function () {
		return this._filteredNodes;
  },

  getRawNodeMap: function () {
		return this.mapNodes(this._contentEl);
  },

  getMarkedNodeMap: function () {
	  return this.markNodeMap();
  },

// CONTENT BACKUP
  bkpContent: function(contentEl) {
	
    this._contentBkp = [];
    if(this.opts.datastore) {
      if($('#eMend-content-backup').length == 0) {
        this.bkpContentOnDOM(contentEl);
      } else {
        this.restoreContentFromDOM(contentEl);
      }
    };

    var childs = contentEl.childNodes, o,c;
    for (var node in childs) {
      o = childs[node];
      if(!o.nodeType || $(o).hasClass('write-protect')) continue;
      switch(o.nodeType) {
        case 1:
        case 3:
        // Node.ELEMENT_NODE
          c = o.cloneNode(true);
          this._contentBkp.push(c);
        break;
      }
    }
  },

  restoreContent: function() {
    var parent  = this._contentEl;
    var childs = parent.childNodes, o, b=this._contentBkp, wprt = 0;

    // remove all content element childs except write-protected
    while (childs.length - wprt) {
      if($(parent.firstChild).hasClass('write-protect')) {
        wprt++;
        continue;
      }
      parent.removeChild(parent.firstChild);
    }

    // restore nodes from backup
    for(var i=b.length-1; i>-1; i--) {
      parent.insertBefore(b[i].cloneNode(true),parent.firstChild);
    }

    document.body.normalize();
  },
  
  bkpContentOnDOM: function(contentEl) {
    // creates a container in an hidden DOM zone and clones
    // content element
    var DOMbkp = $.create('div',{id:'eMend-content-backup'});
    $(this.opts.datastore).append(DOMbkp);
    var nc = contentEl.cloneNode(true);
    // renames content backup id's to prevent duplicates
    $(nc).find('*[id]').each(function(){
      $(this)[0].id += '__bkp__';
    });
    
    // I should better suffix classNames also and maybe tagNames too
    // as this could possibly alter DOM query results for unaware scripts...
    
    DOMbkp[0].innerHTML = nc.innerHTML;    
  },
  
  restoreContentFromDOM: function(contentEl) {
    var b = $('#eMend-content-backup')[0];
    var nc = b.cloneNode(true);
    // remove anti-duplicate id suffix
    $(nc).find('*[id]').each(function(){
      var id = $(this)[0].id;
      $(this)[0].id = id.substr(0,id.indexOf('__bkp__'));
    });
    contentEl.innerHTML = nc.innerHTML;
    document.body.normalize();
  },

// COMMENTS
  addComment: function(subject, text, userIdx) {
    
    if(typeof userIdx == 'undefined') userIdx = this._currentUser;
    var d = new Date();
    var date = d.format(Date.ISO8601c);
    var noteIdx = this._comments[userIdx].length;
    var auth = this._users[userIdx];
    subject = $.escapeReturns(subject);
    text = $.escapeReturns(text);

    var status = 0;
    var commentdata = {
      author: auth,
      title: subject,
      body: text,
      date: date,
      userIdx: userIdx,
      noteIdx: noteIdx
    };
    
    var l = this._comments[userIdx].push(new eMend.comment(commentdata,{animate: false}));
    
    this.insertNoteByDate(date,userIdx,l-1);    
    this.lastComment = {user:userIdx, idx: l-1};
    $(document).trigger('emend.addComment');

    return (l-1);
  },
	
  modifyComment: function(subject, text, userIdx, noteIdx) {
    var o = this._comments[userIdx][noteIdx];
    var d = new Date();
    var date = d.format(Date.ISO8601c);
    //var subject = subject.stripScripts().stripTags();
    //var text = text.stripScripts().stripTags();
    var status = o[4];
    this._comments[userIdx][noteIdx] = [subject,text,date,text.length,status];
  },
  
  getLastComment: function() {
	return this._comments[this.lastComment.user][this.lastComment.idx];
  },
  remapSelectionToContent: function(s) {
    
    var scParent = s.startContainer.parentNode,
    ecParent = s.endContainer.parentNode,
    
    snode = $(scParent).attr('node'),
    sfragment = $(scParent).attr('fragment') || 0,
    
    enode = $(ecParent).attr('node'),
    efragment = $(ecParent).attr('fragment') || 0;

    var sO = sfragment == 0 ? s.startOffset : this._markedNodeMap.fM[snode][sfragment-1][1] + s.startOffset;
    var eO = efragment == 0 ? s.endOffset : this._markedNodeMap.fM[enode][efragment-1][1] + s.endOffset;

    this.restoreContent();
    var tN = $(this._contentEl).textNodes(true);
    
    return {
      startContainer: tN[snode],
      endContainer: tN[enode],
      startOffset: sO,
      endOffset: eO
    }
  },

// SELECTIONS
  addSelection: function(userIdx) {
    if(typeof userIdx == 'undefined') userIdx = this._currentUser;

    var s = $.getSelection(true);
    
//=================================================
//console.log("Selection object: ",s);
//console.log("Offsets",s.startOffset,s.endOffset);
//=================================================    

    switch (s.startContainer.parentNode.tagName) {
      case 'NODEBLOCK':
      case 'NODEINNER':
        s = this.remapSelectionToContent(s);
      break;
    }

    var r1ContextNode = $(s.startContainer).parents('*[id]');
    r1ContextNode = r1ContextNode[0] ? r1ContextNode[0] : document.body;
    var r1ContextId = r1ContextNode.id ? r1ContextNode.id : '__noId__';

    var cS = $(s.startContainer).generateXPath({context: r1ContextNode});
    var sel = [s.startOffset,s.endOffset,{'xpath':cS,'base':r1ContextId}];

    if(s.startContainer != s.endContainer) {
      var r2ContextNode = $(s.endContainer).parents('*[id]');
      r2ContextNode = r2ContextNode[0] ? r2ContextNode[0] : document.body;
      var r2ContextId = r2ContextNode.id ? r2ContextNode.id : '__noId__';

      var cE = $(s.endContainer).generateXPath({context: r2ContextNode});
      sel.push({'xpath':cE,'base':r2ContextId});
    };
    /*
    if(sel[3]) {
      console.log(sel[0],sel[1],sel[2].xpath,sel[3].xpath);
    } else {
      console.log(sel[0],sel[1],sel[2].xpath);  
    }
    */
    
    var l = this._selections[userIdx].push(sel);
    this.lastSelection = {user:userIdx, idx: l-1};
  },
  
  getLastSelection: function() {
    return this._selections[this.lastSelection.user][this.lastSelection.idx];
  },
  
  removeLastSelection: function() {
    this._selections[this.lastSelection.user].splice(this.lastSelection.idx,1);
  },

// USERS

  addUser: function(name) {
    this._selections.push([]);
    this._comments.push([]);
    var u = this._users.push(name);
    this._usersByName[name] = u-1
    return (u - 1);
  },

  removeUser: function(idx) {
    if(idx > 0) { // guest user can't be removed...
      this._selections.splice(idx,1);
      this._comments.splice(idx,1);
      this._users.splice(idx,1);
    }
  },

  getUser: function(idx) {
    return this._users[idx];
  },
  
  getOrCreateUser: function(name) {
    var userIdx = this._usersByName[name];
    if(userIdx >= 0) return userIdx;
    return this.addUser(name);
  },

  loginAsGuest: function() {
    this.removeUser(this._currentUser);
    this._author = "guest"; 
    this._authorHash = "Sandbox";
    this._password = "guest";
    this.addUser('guest');
    this._currentUser = 0;
    //this.loadLocal();
    //this.renderAll();
    //this.refreshLinks();
    //this.currentMode = 'read';
  },

  loginAs: function(user) {
    this._author = user;
    //this._password = pass;
    this._currentUser = this.addUser(user);
    //this._authorHash = emendCRYPTOutils.md5(user+pass);
    //this.loadLocal();
    //this.renderAll();
    //this.refreshLinks();
  },
  
// IMPORT
  importEmendment: function(selection,commentdata) {
    
    commentdata.selection = selection;
    
    var userIdx = this.getOrCreateUser(commentdata.author);
    commentdata.userIdx = userIdx;
    
    var s = this._selections[userIdx].push(selection);
    commentdata.noteIdx = s-1;
    this.lastSelection = {user:userIdx, idx: s-1};
    
    var c = this._comments[userIdx].push(new eMend.comment(commentdata));
    this.lastComment = {user:userIdx, idx: c-1};
    
    this.insertNoteByDate(commentdata.date,userIdx,c-1);
  },

// TIMERANGE
  initTimeRangeFilters: function() {
    if(!this.notesFirstDate) {
      var d = new Date();
      var date = d.format(d,'%Y%%m%%d%');
      this._notesFirstDate = date;
      this._notesLastDate = date;
    }

    this._timeRange[0] = this._notesFirstDate;
    this._timeRange[1] = this._notesLastDate;
  },

  setTimeRangeFilter: function(start,end) {
    this._timeRange[0] = Number(start);
    this._timeRange[1] = Number(end);
    //>>> this.renderAll();
    //>>> this.refreshLinks();
  },

  updateNotesByDate: function() {
    var d,date,dates,u,i,k,z,Ucs;
    d = new Date();
    date = d.format('%Y%%m%%d%');
    this._notesFirstDate = date;
    this._notesLastDate = date;
    dates = this._notesByDate = {};

    for(u=0, z=this._comments.length; u < z; u++) {
      Ucs = this._comments[u];
      for(i=0,k=Ucs.length; i < k; i++) {
        date = Number(Ucs[i][2].substr(0,8));
        if(!dates[date]) dates[date] = [];
        dates[date].push(u+'_'+i);
        this._notesFirstDate = Math.min(date,this._notesFirstDate);
        this._notesLastDate = Math.max(date,this._notesLastDate);
      }
    }
  },
  
  insertNoteByDate: function(date,userIdx,commentIdx) {
    date = Number(date.substr(0,8));
    if(!this._notesByDate[date]) this._notesByDate[date] = [];
    this._notesByDate[date].push(userIdx+'_'+commentIdx);
    this._notesFirstDate = Math.min(date,this._notesFirstDate);
    this._notesLastDate = Math.max(date,this._notesLastDate);    
  },

// NODE MAP

  mapNodes: function(el) {

    var nodes = [];
    var fragments = [];
    var fragmentsMap = [];

    function rejectUnwanted(node) {

    //if('EmendOverlay' == node.parentNode.id || 'helpOnLine' == node.parentNode.id) return NodeFilter.FILTER_REJECT;

      switch(node.parentNode.tagName){
        case 'SCRIPT':
        case 'NOSCRIPT':
          return NodeFilter.FILTER_REJECT;
        break;
      }
      return NodeFilter.FILTER_ACCEPT;
    }

    function processNode(node) {
      nodes.push(node);
      fragments.push([node.nodeValue]);
      fragmentsMap.push([[0,node.nodeValue.length,[]]]);
    }
    
    function processNodeIE(node) {
      switch(node.parentNode.tagName){
        case 'SCRIPT':
        case 'NOSCRIPT':
          return;
        break;
      }
      
      nodes.push(node);
      fragments.push([node.nodeValue]);
      fragmentsMap.push([[0,node.nodeValue.length,[]]]);
    }    
			
    if(document.createTreeWalker && jQuery.browser.mozilla) {
      // at the time of writing TreeWalker is implemented in Firefox, Safari and Opera; using it just on Mozilla as on:
      // - Firefox 3.0.1 using this native method for the query is slightly faster than jQuery.textNodes plugin
      // - Safari 3.1.1 (win) TreeWalker implementation seems buggy
      // - Opera 9.5.2 is 10x slower than jQuery.textNodes
      function traverse(tw) {
        var current = tw.currentNode;
        for(var node=tw.firstChild(); node!=null; node=tw.nextSibling()){
          processNode(node);
          traverse(tw);
        }
        tw.currentNode = current;
      }
  
      var wk = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, rejectUnwanted, false);
      traverse(wk);
      wk = null;
    } else {
      // fallback to textNodes jQuery plugin
      $(document.body).textNodes(true).each(function() {
      //$(document.body).textNodesFiltered('jGrowl eMend-DATA-Overlay eMend-VISUAL-Overlay').each(function() {
        processNodeIE(this);
      });
    }

    this._rawNodeMap = {'n':nodes,'f':fragments,'fM':fragmentsMap}; 

    return this._rawNodeMap; 
  },

  markNodeMap: function() {
    //LOG('markNodeMap');
    //LOG(arguments.callee.caller.valueOf);

    var groupSel = this._selections
      , groupCom = this._comments
      , map = this.getRawNodeMap();
      
    var nodes = map.n
      , fragments = map.f
      , fragmentsMap = map.fM;

//=================================================
//console.log('nodes',nodes);
//console.log("fragments",fragments);
//console.log("fragmentsMap",fragmentsMap);	
//=================================================

    var tR = this.getTimeRange(); 

	var selections,comments,r,date,oS,oE,XcS,XcE,cS,cE,cSel,cEel,startNode,endNode,startChunk,endChunk;
	var fragmentL,fragmentR,prevOffsetStart,prevOffsetEnd;
    
    var xpathmethod = document.evaluate ? 0 : 1;

	for(var u=0, len1=groupSel.length; u < len1; u++) {
      selections = groupSel[u];
      comments = groupCom[u];

//=================================================
//console.log("selections: ",selections.length);
//console.log("comments: ",comments.length);
//=================================================

      for(var i=0, len2=selections.length; i < len2; i++) {
        //console.log('selections',len2,i);
        date = Number(comments[i].getISO8601c());
        if(date < tR[0] || date > tR[1]) continue; // skip out of time range 
        r = selections[i];
        oS = r[0]; oE = r[1]; // offsetStart; offSetEnd
        XcS = r[2]; XcE = r[3] ? r[3] : r[2]; // startContainer, endContainer XPath expressions

//=================================================
//console.log("XcS.base: ",XcS.base);	
//console.log("XcE.base: ",XcE.base);
//console.log("xpathmethod: "+xpathmethod);
//=================================================

        switch(xpathmethod) {
          case 0:
            cSel = XcS.base == '__noId__' ? document.body : document.getElementById(XcS.base);	
            cEel = XcE.base == '__noId__' ? document.body : document.getElementById(XcE.base);	            
            cS = document.evaluate(XcS.xpath,cSel,null,XPathResult.FIRST_ORDERED_NODE_TYPE,null).singleNodeValue;
            cE = document.evaluate(XcE.xpath,cEel,null,XPathResult.FIRST_ORDERED_NODE_TYPE,null).singleNodeValue;            
          break;
        
          case 1:
            cSel = XcS.base == '__noId__' ? 'body' : '#'+XcS.base;
            cEel = XcE.base == '__noId__' ? 'body' : '#'+XcE.base;	                        
            cS = $.simpleXpath(XcS.xpath,cSel);
            cE = $.simpleXpath(XcE.xpath,cEel);            
          break;
        }
        
        if(!cS) {
			if(eMend.log) {
              err = {};
			  err.funct = 'markNodeMap';
              err.msg = "couldn't find node XcS.xpath: "+XcS.xpath;
			  eMend.log.add('error',err);
			}
            continue;
        }
        
        if(!cE) {
			if(eMend.log) {
              err = {};
			  err.funct = 'markNodeMap';
              err.msg = "couldn't find node XcE.xpath: "+XcE.xpath;
			  eMend.log.add('error',err);
			}
            continue;
        }        

//=================================================
//console.log("XcS.xpath: "+XcS.xpath+" XcE.xpath: "+XcE.xpath);
//console.log("context start: "+cS.nodeValue);
//console.log("context end: "+cE.nodeValue);
//console.log("nodes: ",nodes.length);
//=================================================
     
        startNode = endNode = -1
        for(var j=0, len3=nodes.length; j < len3; j++) {
            if(cS == nodes[j]) startNode = j;
            if(cE == nodes[j]) endNode = j;
            if(startNode != -1 && endNode != -1) break;
        }
        if(startNode == -1 || endNode == -1) continue; //skip filtered nodes
        
//=================================================        
//console.log('startNode: '+startNode);
//console.log('endNode: '+endNode);
//console.log('fragmentsMap.length: '+fragmentsMap.length);
//=================================================
        
        var startFragment = fragments[startNode];
        var endFragment = fragments[endNode];				
        var startFragmentMap = fragmentsMap[startNode];
        var endFragmentMap = fragmentsMap[endNode];

//=================================================        
//console.log('startFragmentMap', typeof startFragmentMap);
//=================================================        

        // Find which chunks the selection boundaries are within
        startChunk = endChunk = -1;
        for(var j=0, len3=startFragmentMap.length; j < len3; j++) {
          if(startChunk == -1 && oS >= startFragmentMap[j][0] && oS <= startFragmentMap[j][1]) {
            startChunk = j;
            break;
          }
        }
        for(var j=0, len3=endFragmentMap.length; j < len3; j++) {
          if(endChunk == -1 && oE >= endFragmentMap[j][0] && oE <= endFragmentMap[j][1]) {
            endChunk = j;
//=================================================
//console.debug("  offsetEnd found in fragment "+j+" ["+endFragmentMap[j][0]+" <= "+oE+" <= "+endFragmentMap[j][1]+"]");					
//=================================================            
            break;
          }
        }
        
        if(endChunk == -1) endChunk = j-1;
//=================================================
//console.log("startChunk,endChunk",startChunk,endChunk);
//=================================================

        var startChunkText = startFragment[startChunk];
        var startChunkMap = fragmentsMap[startNode][startChunk];

//=================================================
//dump('***' + startChunkText + '\n');
//console.log("fragments: ",fragments);
//console.log("fragmentsMap: ",fragmentsMap);				
//console.log('startChunk,endChunk',startChunk,endChunk);
//=================================================

        // cuts the text chunks before and after the selection start boundary in their respective fragments
        fragmentL = startChunkText.slice(0,oS - startChunkMap[0]);
        if(fragmentL.length) {
          // deletes the text before selection in start fragment
          startFragment[startChunk] = startChunkText.slice(oS - startChunkMap[0]);
          // insert fragmentL before startFragment as a new item in fragments
          startFragment.splice(startChunk,0,fragmentL);
          // copy startFragment previous offset start
          prevOffsetStart = startChunkMap[0];
          // update startFragment offset start
          startChunkMap[0] = oS;
          // insert fragmentL before startFragment as new item fragmentsMap
          fragmentsMap[startNode].splice(startChunk,0,[prevOffsetStart,oS-1,startChunkMap[2].slice(0)]);
          startChunk++;
          // increment endChunk index if in same node of startChunk, to reflect the newly inserted chunk
          if(startNode == endNode) { endChunk++; }				
        }

//=================================================
//console.log('startChunk,endChunk',startChunk,endChunk);
//=================================================

        var endChunkText = endFragment[endChunk];				
        var endChunkMap = fragmentsMap[endNode][endChunk];				

        // cuts the text chunks before and after the selection end boundary in their respective fragments 
        fragmentR = endChunkText.slice(oE - endChunkMap[0]);
        if(fragmentR.length) {
          endFragment[endChunk] = endChunkText.slice(0,oE - endChunkMap[0]);
          endFragment.splice(endChunk+1,0,fragmentR);
          prevOffsetEnd = endChunkMap[1];
          endChunkMap[1] = oE;
          fragmentsMap[endNode].splice(endChunk+1,0,[oE,prevOffsetEnd,endChunkMap[2].slice(0)]);
        }

        // mark all node fragments between start/end boundaries with comment ID
        for(var j=startNode; j<=endNode; j++) {
          var from = j == startNode ? startChunk : 0;
          var to = j == endNode ? endChunk+1 : fragmentsMap[j].length;
          for(var k=from; k < to; k++) {
            fragmentsMap[j][k][2].push(u+'_'+i);
          }
        }
      }
	}

    this._markedNodeMap = {'n':nodes,'f':fragments,'fM':fragmentsMap}; 

    return this._markedNodeMap; 
  },

  // NODE FILTERS
  initNodeFilters: function(el, hideAll) {
    var map = this.mapNodes(el);
    for(var i=0; i < map.n.length; i++) {
      hideAll ? this.addNodeFilter(i) : this.removeNodeFilter(i);
    }
  },
  
  filterAllNodes: function() {
    for(node in this._filteredNodes){
      this.addNodeFilter(node);
    }
  },
  
  unfilterAllNodes: function() {
    for(node in this._filteredNodes){
      this.removeNodeFilter(node);
    }
  },
  
  addNodeFilter: function(nodeIdx) {
    this._filteredNodes[nodeIdx] = true;
  },
  
  removeNodeFilter: function(nodeIdx) {
    this._filteredNodes[nodeIdx] = false;
  },

  toggleNodeFilter: function(e,nodeIdx) {

    var node = e.target;
    var relNodes = emendARRAYutils.createFromWords(node.getAttribute('relNodes'));
    for(var i=0, len=relNodes.length; i < len; i++) {
      var v = relNodes[i];
      var status = this._filteredNodes[v] = !this._filteredNodes[v];
      var el = document.getElementById('block'+v);
      el.setAttribute('hidenotes',status);
    };

    var status = this._filteredNodes[nodeIdx];
    node.className = 'cMark_'+status+' fixedFontSize9';

    this.clearLinks();

    if(status) {
      Emend.events.Notes.fadeNodeNotes.fire(node);
    } else {
      Emend.events.Notes.appearNodeNotes.fire(node);
    }

  }
};

})(jQuery);
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.highlight = function (dataset) {
	
	//console.count('highlight');
	
	var m = dataset.getMarkedNodeMap(),
	nodes = m.n,
	fragments = m.f,
	fragmentsMap = m.fM,
	newFrag, chunk, chunkMap, t, c, l;
	
	var f = dataset.getFilteredNodes();

	for(var j=0, len1=nodes.length; j < len1; j++) {
			var filtered = f[j];
			var node = nodes[j];
			var fragment = fragments[j];
			var fragmentMaps = fragmentsMap[j];
			
			//console.log(node);
			var pNode = node.parentNode;
			
			var newNode = document.createElement('NODEBLOCK');
			newNode.id = 'block'+j;
			newNode.className = 'emend-block';
			newNode.setAttribute('hidenotes',filtered);
			newNode.setAttribute('node',j);			
			
			var uniqueComments = [];
			//console.log(fragment, fragmentMaps);
			for (var k=0, len2=fragment.length; k < len2; k++) {
				chunk = fragment[k];
				chunkMap = fragmentMaps[k];
				//console.log('chunk',chunk);
				//console.log('chunkMap',chunkMap);
				newFrag = document.createElement('NODEINNER');
				newFrag.setAttribute('node',j);
				newFrag.setAttribute('fragment',k);					
				if(chunkMap[2].length) {
					//uniqueComments = uniqueComments.merge($H(chunkMap[2]));
					uniqueComments = uniqueComments.concat(arrDiff(uniqueComments,chunkMap[2]));
					l = Math.min(chunkMap[2].length, 40);
					t = chunkMap[2].length+' comments';
					c = 'highlight n' + chunkMap[2].join(' n') +' a'+l;
					newFrag.setAttribute('title',t);
					newFrag.className = c;
/*
					if(this.options.navbar) {
						var nb = this.options.navbar;
						nb.addNode(newFrag,chunkMap[2].length);
					}
*/
				}
				newFrag.appendChild(document.createTextNode(chunk));
				//$(newFrag).text(chunk);


				newNode.appendChild(newFrag);
				//pNode.replaceChild(newFrag,node);
			}
			pNode.replaceChild(newNode,node);

/*
			// ADD BLOCK COUNTERS
			var blockTotalComments = uniqueComments.length;
			if(blockTotalComments>0) {
				
				var blockContainer = newNode;
				var tagName = blockContainer.tagName.toLowerCase();
				//var d = document.defaultView.getComputedStyle(blockContainer,null).getPropertyValue('display');

				while(!this.blockNodesMap[tagName]) {
					blockContainer = blockContainer.parentNode;
					tagName = blockContainer.tagName.toLowerCase();
					//console.log('blockTagName:',tagName,blockContainer);					
					//var d = document.defaultView.getComputedStyle(blockContainer,null).getPropertyValue('display');
					//console.log(tagName);					
				}

				if(this.blockNodesMap[tagName] != true) {
					blockContainer = $(blockContainer).down(this.blockNodesMap[tagName]);
				}
				//console.log(blockContainer,d);
				//newNode.insertBefore(cMark,newNode.firstChild);
				var fC = blockContainer.firstChild; 

				if('cMark' != String(fC.className).substr(0,5)) {
					//console.log('creating new cMark');
					//var cMark = Builder.node('div',{'class':'cMark_'+filtered,'relNodes':j},blockTotalComments);
					var cMark = document.createElement('div');
					cMark.className = 'cMark_'+filtered+' fixedFontSize9';
					cMark.setAttribute('relNodes',j);
					cMark.innerHTML = blockTotalComments;
					this.nodeCommentsCount[j] = blockTotalComments;
					
					Event.observe(cMark,'click',this.toggleNodeFilter.bindAsEventListener(this,j));
					blockContainer.insertBefore(cMark,fC);
				} else {
					if(blockContainer == lastBlockContainer) {
						uniqueComments = uniqueComments.concat(arrDiff(uniqueComments,lastUniqueComments));
						fC.innerHTML = uniqueComments.length;
						this.nodeCommentsCount[j] = blockTotalComments;
					}
					
					fC.setAttribute('relNodes',fC.getAttribute('relNodes')+' '+j);
				}
				
				var lastBlockContainer = blockContainer;
				var lastUniqueComments = uniqueComments.clone();
			}
			*/
		}
	$(document).trigger('emend.highlight');
}

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.comment = function (data,options) {
    if(data) {
        this.data = data;
        this.data.textlength = data.body.length;
        var l = eMend.comment.defaults.shortlength;
        if( this.data.textlength > l) {
            this.data.shorttext = data.body.substr(0,l) + '...'
        }
    }
    this.opts = $.extend({}, eMend.comment.defaults, options);
    this.template = $.template(eMend.templates.comment,{ regx: 'gettext' }).apply(eMend.dictionary.comment);
    this.templateMore = $.template(eMend.templates.comment_more,{ regx: 'gettext' }).apply(eMend.dictionary.comment_more);
    //this.template_C = $.template(this.template).compile();
}

eMend.comment.defaults = {
    shortlength: 100,
    animate: true
};

eMend.comment.prototype = {
	getElement: function(className) {
        if(!this.element) {
            var id = this.data.userIdx+'_'+this.data.noteIdx;
            //console.log(this.data);
            var tpl = $.template(this.template).apply(this.data);
            //var tpl = this.template_C.apply(this.data);	// <-- in firefox this is faster
            
            var note = $.create('div',{'id':'note'+id, 'note':id, 'className': className})[0];
            note.innerHTML = tpl;
            this.element = note;
        }

        $(this.element).mouseover(this.over).mouseout(this.out)
        this.morelesstext($(this.element).find('.commentbody')[0]);
		return this.element;
	},
	getISO8601c: function() {
		return this.data.date.substr(0,8);
	},
    hide: function() {
        return this.opts.animate ? $(this.element).slideUp(200) : $(this.element).hide();
    },
    show: function() {
        return this.opts.animate ? $(this.element).slideDown(200) : $(this.element).show();
    },
    over: function() {
        var hlClass = '.n' + this.id.substr(4);
        $(hlClass).addClass('eMend-highlight-over');
    },
    out: function() {
        var hlClass = '.n' + this.id.substr(4);
        $(hlClass).removeClass('eMend-highlight-over');
    },
    morelesstext: function(el) {
        var fc = el.firstChild;
        if(fc && fc.nodeType == 3 && fc.length > 150) {
            var $this = $(el);
            $this.attr('fulltext',fc.data);
            $this.html(fc.data.substr(0,150) + this.templateMore);
            $this.click(this.toggleText);
        }
    },
    toggleText: function(evt) {
        var $this = $(this);
        var status = $this.children('.readmore, .readless').toggle();
        if($this.attr('fulltext')) {
            $this.attr('shorttext',$this[0].firstChild.data);
            $this[0].firstChild.data = $this.attr('fulltext');
            $this.removeAttr('fulltext');
        } else {
            $this.attr('fulltext',$this[0].firstChild.data);
            $this[0].firstChild.data = $this.attr('shorttext');
            $this.removeAttr('shorttext');		
        }
    }
}

})(jQuery);
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.commentGroup = function (data) {

	this.data = data;
	this.comments = [];
    this.template = $.template(eMend.templates.commentGroup,{ regx: 'gettext' }).apply(eMend.dictionary.commentGroup);

}

eMend.commentGroup.prototype = {
	getElement: function() {
		if(!this.element) {
			var nodeGroup = this.data.nodeGroup;
			var nodeClass = this.data.nodeClass;
			//var tpl = $.template(this.template).apply(this.data);	
			this.element = $.create('div',{'id':'noteGroup'+nodeGroup,'class': nodeClass, 'node':nodeGroup})[0];
			this.element.innerHTML = this.template;
			this.counter = $.create('h6',{'unselectable': 'on'})[0];
			this.element.appendChild(this.counter);
            var _self = this;
		
		// BEAHVIOURS
			// scroll to the first note highlight when a commentGroup title is clicked
			$(this.counter).click( function(){
				var firstNoteInGroup = $(this).parent().find('.emend-note').get(0);
				var noteId = $(firstNoteInGroup).attr('note');
				$(window).scrollTo('.n'+noteId,{duration: 500, easing: 'swing'});
			});
			
			// open/close group when +/- icon is clicked
            $(this.element).find('.closegroup, .opengroup').click(function(){_self.toggleGroup(_self.element)});
		}
		return this.element;
	},
	
	updateCounter: function(num) {
		var str = num > 1 ? num +' <em>'+eMend.dictionary.commentGroup.comments+'</em>' : num +' <em>'+eMend.dictionary.commentGroup.comment+'</em>';
        $(this.counter).html(str);
		num = Math.min(num,40);
		this.counter.className = 'a'+num+' emendGroupTitle';
	},
	
	appendChild: function(element) {
		this.comments.push(element);
		this.updateCounter(this.comments.length);
		this.element.appendChild(element);
	},
	
	prependChild: function(element) {
		this.comments.unshift(element);
        var l = this.comments.length;
		this.updateCounter(l);
		if(l > 1) {
			this.element.insertBefore(element,this.comments[1]);
		} else {
			this.element.appendChild(element);			
		}
	},
    toggleGroup: function(groupContainer){
         $(groupContainer).children('.emend-note').toggle();
         $(groupContainer).toggleClass('readfull').toggleClass('readpart');
         $(document).trigger('emend.toggleGroup');
    },
    closeGroup: function(){
         $(this.element).addClass('readpart').removeClass('readfull').removeClass('minify');
    },
    openGroup: function(){
         $(this.element).addClass('readfull').removeClass('readpart').removeClass('minify');
    },
	minifyGroup: function(){
         $(this.element).removeClass('readfull').removeClass('readpart').addClass('minify');
    }
}

})(jQuery);
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.commentForm = function (options) {

	if ( !(this instanceof arguments.callee) ) 
	return new eMend.commentForm(options);  
	
	this.opts = $.extend({}, eMend.commentForm.defaults, options);
	
	this.dataset = this.opts.dataset;
	this.active = false;
	this.template = $.template(eMend.templates.commentForm,{ regx: 'gettext' }).apply(eMend.dictionary.commentForm);
	this.create();
}

eMend.commentForm.defaults = {};

eMend.commentForm.prototype = {
	create: function() {
		var commentForm = $('#NoteFormContainer').remove()[0];
		if(!commentForm) {
			var tpl = $.template(this.template).apply(this.data);	
			commentForm = $.create('div',{'id':'NoteFormContainer', 'className': 'jqmWindow340 write-protect'})[0];
			commentForm.innerHTML = tpl;
		}
		//document.body.insertBefore(commentForm,document.body.firstChild);
		$(this.opts.target).append(commentForm);
		var _self = this;
		$('#cancelNote').click(function(){_self.cancel()});
		$('#submitNote').click(function(){_self.submit()});					
	},
	show: function() {
		this.active = true;
		//console.log(this.dataset);
		this.dataset.addSelection();
		if(!$('#NoteFormContainer')[0]) this.create();
		$('#noteSubject').attr('value','');
		$('#noteText').attr('value','');
		$('#NoteFormContainer').jqm({modal:true}).jqmShow();
		
		window.focus(); $('#noteSubject')[0].focus(); // AARGH, ie needs a double focus change
	},
	submit: function() {
		var s = $('#noteSubject').attr('value');
		var t = $('#noteText').attr('value');
		//var tg = $('#noteTags').attr('value');
		var ok = this.check(s,t);
		if(ok) {
			$('#NoteFormContainer').jqmHide();
			var l = this.dataset.addComment(s,t);
			this.active = false;
		}
	},
	cancel: function() {
		this.dataset.removeLastSelection();
		$('#NoteFormContainer').jqmHide();
		this.active = false;
	},
	check: function(subject,text,tags) {
		var pass = true;
		if(subject == '') {
			$('#noteSubject').addClass('warning');
			pass = false;
		} else {
			$('#noteSubject').removeClass('warning');
		}
			
		if(text == '') {
			$('#noteText').addClass('warning');
			pass = false;
		} else {
			$('#noteText').removeClass('warning');
		}
		
		return pass;
		
	},
	isActive: function() {
		return this.active;
	}
	
}

})(jQuery);
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.commentTrigger = function (options) {
  
  if ( !(this instanceof arguments.callee) ) 
  return new eMend.commentTrigger(options);    
  
  this.opts = options;
  
  if(!this.opts.hideHOL) {
    // load HOL preferences
    var hideHOL = false;
    if(window.hideHOL) {
        hideHOL = window.hideHOL;
    } else if(document.location.href.indexOf('emendDisableHOL') != -1) {
        hideHOL = true;
    } else if(document.location.href.indexOf('emendEnableHOL') != -1) {
        hideHOL = false;
        $.aqCookie.del('hideHOL');
    } else {
        hideHOL = $.aqCookie.get('hideHOL') == true ? true : false;
    }
    
    this.opts.hideHOL = hideHOL;
  }
  
  
  this.notifications = [];
  this.status = null;

  var _self = this;
  $(document).mouseup(
    function(event){
      window.setTimeout(function(){
        var s = $.getSelectedText();
        
        if(!_self.opts.form.isActive() && s && s.length) {
          
          // is selection outside of commentable area?
          if(eMend.config.comment_target) {
            var so = $.getSelection();
            var startsInside = $(so.startContainer).parents(eMend.config.comment_target);
            var endsInside = $(so.endContainer).parents(eMend.config.comment_target);
            
            if(eMend.config.login_needed_to_post && _self.opts.users.getCurrentUser() == null) {
              _self.show(4,1000);
              $(document).unbind('keyup.commentTrigger');
              $(document).unbind('keydown.commentTrigger');              
            } else if(startsInside.length & endsInside.length) {
              _self.show(1,1000);
            } else {              
              _self.show(3,1000);
              $(document).unbind('keyup.commentTrigger');
              $(document).unbind('keydown.commentTrigger');
              //var targ = $(eMend.config.comment_target);
              //console.log(targ.css('color') == '');
              //var orig_color = targ.css('color') ? targ.css('color') : '';
              
              
              //targ.css("color", "#ff0000");
              //targ.animate({ opacity: "1" }, {duration: 1000, callback: function(){targ.css("color",orig_color)} });
            }
            
          } else {
            _self.show(1,1000);				            
          }

        } else {
          _self.show(0,1000);
        }
      },10);
    }
  );
  this.template = $.template(eMend.templates.commentTrigger,{ regx: 'gettext' }).apply(eMend.dictionary.commentTrigger);
  this.create();
  //this.show(0);
}

eMend.commentTrigger.prototype = {
  create: function() {
    var commentTrigger = $('#HOLteaser').remove();
    if(!commentTrigger.length) {
      commentTrigger = $.create('div',{'id':'HOLteaser', 'style':'cursor: pointer;'});
      commentTrigger[0].innerHTML = this.template;      
    }

    //var _self = this;
    //$(commentTrigger).bind('click',function(){ _self.activate(); });
    this.opts.target.appendChild(commentTrigger[0]);
    $(commentTrigger).find('li').hide();
    
    return commentTrigger;
  },
  show: function(n, delay) {
    if(this.status == n) return;
    
    var _self = this;
    window.clearTimeout(this.timeOut);
    $('.eMend-jGrowl div.close').trigger('click.jGrowl');
    var v = $('#HOLteaser').find('li')[n];
    var pos = this.opts.sidebar.isOpen() == false ? 'bottom-right' : 'bottom-left';
    
    $.jGrowl.defaults.closer = false;
    $.jGrowl.defaults.position = pos;
    
    if (!this.opts.hideHOL) this.timeOut = window.setTimeout(function(){
      $.jGrowl(v.innerHTML, {theme: 'eMend-jGrowl', life: 6000, position: pos });
      
      $('.emendHideHOL').click( function(){
	  _self.opts.hideHOL = true;
	  $.aqCookie.set('hideHOL','true');
	}
      );
    }, 500);
    
    this.status = n;
    
    _self.isCtrl = false;
    $(document).bind('keyup.commentTrigger',function (e) {
      if(e.which == 17) _self.isCtrl=false;
      if(e.which == 67 && _self.isCtrl == false) {
	e.stopPropagation();
	_self.activate();
      }        
    }).bind('keydown.commentTrigger',function (e) {
	if(e.which == 17) _self.isCtrl=true;
    });       
  },
  hide: function(n, delay){
    $(document).unbind('keyup.commentTrigger');
    $(document).unbind('keydown.commentTrigger');
  },
  activate: function() {
    if(this.status != 2 ) {
      this.hide();
      this.show(2);
      this.opts.form.show();
    }
  }
}
})(jQuery);
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.linker = function(options) {
  
  if ( !(this instanceof arguments.callee) ) 
  return new eMend.linker(options);   
  
  this.opts = $.extend({}, eMend.linker.defaults, options);
  
  this.noteReferences = [];
  this.hiddenNodeLinks = {};
  this.lastScrollInfo = {x:0,y:0};
  this.destroyCanvas();
}

eMend.linker.defaults = {};

// to be used as status icon template
// <div class="linktoggle"><a href="#" title="_(hidelink)" class="unlinkgroup" onclick="return false;">&nbsp;</a><a href="#" title="_(showlink)" class="linkgroup" onclick="return false;">&nbsp;</a></div>

eMend.linker.prototype = {
  createCanvas: function(refresh) {
    var W = this.containerWidth = $(window).width() - 20
      , H = this.containerHeight = $(window).height()
      , Y = $(window).scrollTop()
      , canvas = $('#EmendLinks')
    ;
    
    if(refresh && canvas.length) {
      canvas.attr('width',W);
      canvas.attr('height',H);
      canvas[0].style.top = Y+'px';
    } else {
      canvas = $.create('canvas',{'id':'EmendLinks','class':'EmendOverlay','height':H,'width':W})[0];
      canvas.style.top = Y+'px';

      $(this.opts.target).append(canvas);

      if ($.browser.msie) {        
        G_vmlCanvasManager.initElement(canvas);
        canvas = document.getElementById("EmendLinks");
      }

      this.canvas = canvas;
      this.ctx = canvas.getContext('2d');
      this.ctx.lineWidth = 1;
    
      $(canvas).click(this.hideLinks);      
    }
    this.ctx.strokeStyle = "#09f";    
  },
  
  destroyCanvas: function() {
    $('#EmendLinks').remove();
  },
  hideLinks: function() {
    $('#EmendLinks').hide();
    $(this).trigger('emend.hidelinks');
    this._linksVisible = false;
  },
  showLinks: function() {
    $('#EmendLinks').show();
    this._linksVisible = true;
  },
  refreshLinks: function(shadow){
    this.createCanvas(true);
    this.clearLinks();
    this.renderLinks();
    if(!shadow) this.canvas.style.display = 'block';
  },
  clearLinks: function(){
    if(this.canvas) this.canvas.getContext('2d').clearRect(0,0,this.containerWidth,this.containerHeight);
    this._linksVisible = false;
    //this.canvas.style.display = 'none';
  },
  renderLinks: function() {
    //console.time('renderLinks');
    var ctx = this.ctx
      , doneGroups = {}
      , refPos = this.opts.positions.getReferences()
      , scrl = { x:$(window).scrollLeft(), y: $(window).scrollTop() }
      , lowerbound = $.browser.opera && $.browser.version >= 9.50 ? 12 : 5
      , node, ntlID, ntEL, ntPOS, ntlPOS, xstart, ystart, ybaseline, xend, yend;
    
    for(ntlID in refPos) {
      ntEL = $('#note'+ntlID);
      ntlPOS = refPos[ntlID]; // note linker position
      node = ntlPOS.node;
      if(this.hiddenNodeLinks[node]) continue;

      if(!ntEL.length || ntEL[0] && ntEL[0].style.display == 'none') {
          if(doneGroups[node]) continue;
          doneGroups[node] = true;
          ntEL = $('#noteGroup'+node);
      }

      ntPOS = $(ntEL).offset({lite:true}); // note position
      //console.log(ntPOS);
      xstart = ntlPOS.left-scrl.x;
      ystart = ntlPOS.top-scrl.y;
      ybaseline = ystart+lowerbound;
      xend = ntPOS.left-scrl.x;
      yend = ntPOS.top-scrl.y+8;
      
      ctx.beginPath();
      ctx.moveTo(xstart,ystart);
      ctx.lineTo(xstart,ybaseline);
      ctx.lineTo(xend-25,ybaseline);						
      ctx.lineTo(xend-4,yend);
      ctx.lineTo(xend,yend);			
      ctx.stroke();
    }
    //console.timeEnd('renderLinks');
  }
}
    
    
})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.sidebar = function (options) {
    
    if ( !(this instanceof arguments.callee) ) 
    return new eMend.sidebar(options);    

    this.opts = $.extend({}, eMend.sidebar.defaults, options);
    this.status = 'closed';
    this.template = $.template(eMend.templates.sidebar,{ regx: 'gettext' }).apply(eMend.dictionary.sidebar);
    this.create();
}

eMend.sidebar.defaults = {
    body_open: '280px',
    body_closed: '27px'
};

eMend.sidebar.prototype = {
	create: function() {
        var sidebar = $('#eMend-sidebar')[0]
          , h = $(window).height();
          
        if(!sidebar) {
            //this.destroy();
            sidebar = $.create(
                'div', {
                    id:'eMend-sidebar',
                    style: 'right: 0px; top: 0; height: '+h+'px;',
                    unselectable: 'on',
                    className: this.status
                }
            )[0];
            sidebar.innerHTML = this.template;
            $(this.opts.target).append(sidebar);
        } else {
            sidebar.style.height = h+'px';
            this.status = $(sidebar).attr('className');
        }
		var _self = this;

		$(window).wresize(function(){ _self.refreshHeight(); });
		$(document.body).css({marginRight: eMend.sidebar.defaults['body_'+this.status]});
		$(sidebar).find(".sidebar-Y-header").click(function(){ _self.open(); });
		$(sidebar).find(".closesidebar").click(function(){ _self.close(); });
        //$(sidebar).find(".extendsidebar").click(function(){ _self.extend(); });
		
		this.container = sidebar;
	},
    
    getContainer: function() {
        return $(this.container).find('#sidebar-body')[0];        
    },
	
	destroy: function() {
		var sidebar = $('eMend-sidebar');
		if(sidebar) {
			sidebar.remove();
			delete this.container;
		}
	},
	
	open: function() {
		$('.sidebar-wrapper').animate({right: "0"}, 500, 'swing', function(){
			$(document.body).css({marginRight: "280px"});
			$('.sidebar-Y-header').css({right: "-60px"});
            $(document).trigger('emend.opensidebar');
		});
        $('#eMend-sidebar').attr('className','open');
        this.status = 'open';
		window.setTimeout(function(){
			$('#memefarmers').animate({bottom: "-20px"},1000, 'swing');
		}, 10000)
	},
    
	close: function() {
		$(document.body).css({marginRight: "27px"});
        $(document).trigger('emend.closesidebar');
		$('.sidebar-wrapper').animate({right: "-260px"}, 500, 'swing', function(){
			$('.sidebar-Y-header').css({right: "-280px"});
			$('.sidebar-Y-header').animate({right: "0"},500,'swing', function(){
				$('.sidebar-Y-header').css({bottom: "0"});
			});
		});
        $('#eMend-sidebar').attr('className','closed');
        this.status = 'closed';
	},
    
    extend: function() {
        $('#eMend-sidebar').css({width: "520px"});
		$('.sidebar-wrapper').animate({width: "520px"}, 500, 'swing', function(){
			$(document.body).css({marginRight: "540px"});
            $(document).trigger('emend.opensidebar');
		});        
    },
	
	refreshHeight: function(){
		var h = $(window).height()
		$(this.container).height(h+'px');
	},
    
    isOpen: function(){
        return (this.status == 'open');
    }
}


})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.navbar = function (options) {
	
    if ( !(this instanceof arguments.callee) ) 
    return new eMend.navbar(options);  	

	this.opts = $.extend({}, eMend.navbar.defaults, options);
	this.htmlEl = $('html');
	this.create();
	this.clear();
};

eMend.navbar.defaults = {
	align: "right",
	width: "6px",
	height: "100%"
}

eMend.navbar.prototype = {
	create: function () {
		this.htmlEl.css({height:'100%'});
		this.bar = $('#emend-navbar').remove()[0] || $.create('div',{'id': 'emend-navbar', 'style': s},' ')[0];
		var o = this.opts;
		var s = o.align+':0; top:0; width:'+o.width+'; height:'+o.height+'; position: absolute;';
		$(this.bar).attr('style',s);
		$(this.opts.target).append(this.bar);
	},
	refresh: function () {
		this.clear();
		this.render();
	},
	
	render: function() {
		var	o = this.opts
		  ,	bodyH = $(document.body).height()
		  ,	barH = $(this.bar).height()
		  , HLels = this.opts.positions.getHighlightsCollection();

		var node, status, nodeH, nodeY, markH, markY, s, mark;
		for(var i=0; i < HLels.length; i++) {
			node = HLels[i];
			status = node.className.split(' ').pop();

			//nodeH = Element.getHeight(node);
			nodeH = $(node).height();
			nodeY = $(node).offset({lite:true}).top;
			markH = Math.round(nodeH/bodyH*barH);
			markY = Math.round(nodeY/bodyH*barH);
			s = 'height:'+markH+'px; width:'+o.width+'; position: absolute; top:'+markY+'px; z-index:'+status.substr(1)+';';
			mark = $.create('div',{'class': status, 'style': s})[0];
			this.bar.appendChild(mark);
		}
	},
	clear: function() {
		$(this.bar).empty();
	}
};

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.positions = function (options) {
	
    if ( !(this instanceof arguments.callee) ) 
    return new eMend.positions(options);  	
	
	this.highlightEls = null;
	this.highlights = null;
	this.references = null;
	
	this.opts = $.extend({}, eMend.positions.defaults, options);
};

eMend.positions.prototype = {
	invalidate: function() {
		var prop, i, l;
		for(i=0, l=arguments.length; i < l; i++) {
			prop = arguments[i];
			//console.log('invalidate',prop);
			switch(prop) {
				case 'highlights':
					this.highlightEls = null;
					this.highlights = null;
				break;
				case 'references':
					this.references = null;
				break;			
			}
		}
	},
	updateAll: function() {
		this.updateHighlightCollection();
		this.updateHighlights();
		this.updateReferences();
	},
	updateHighlightCollection: function() {
		//console.log('updateHighlightCollection');
		this.highlightEls = $('nodeinner').filter('.highlight');
	},
	updateHighlights: function() {
		//console.log('updateHighlight');
		//console.time('refPositions');
	  
		this.highlights = {};
		var hl = this.highlightEls;
		
		var hlEL, ntIDs, ntID, o;
		
		for(var i=hl.length-1; i>=0; i--) {
		  hlEL = hl[i]; // highlight element reference			
		  ntIDs = hlEL.className.split(' '); // multiple notes IDs
		  ntIDs.pop(); ntIDs.shift(); // trashes 'highlight' and 'aX' class
		
		  for(var j=0, l=ntIDs.length; j < l; j++) {
			ntID = ntIDs[j].substring(1); // note ID
			if(!this.highlights[ntID]) {
			  o = $(hlEL).offset({lite:true});
			  this.highlights[ntID] = o;
			  this.highlights[ntID].bottom = o.top + $(hlEL).height();
			}
		  }
		}
		//console.timeEnd('refPositions');
	},
	updateReferences: function() {
		//console.log('updateReferences');
		//console.time('refPositions');
		this.references = {};
		var hl = this.getHighlightsCollection();
		
		var hlEL, ntIDs, ntID, ntlEL, ntsEL, o;
		
		for(var i=hl.length-1; i>=0; i--) {
		  hlEL = hl[i]; // highlight element reference
		  //if(hlEL.parentNode.getAttribute('hidenotes') == 'true') continue;			
		  ntIDs = hlEL.className.split(' '); // multiple notes IDs
		  ntIDs.pop(); ntIDs.shift(); // trashes 'highlight' and 'aX' class
		
		  for(var j=0, l=ntIDs.length; j < l; j++) {
			ntID = ntIDs[j].substring(1); // note ID
			if(!this.references[ntID]) {
			  ntlEL = document.createElement('span');
			  ntlEL.style.fontSize = "1px";
			  ntlEL.innerHTML = '|';
			  hlEL.appendChild(ntlEL);
			  o = $(ntlEL).offset({lite:true});
			  this.references[ntID] = o;
			  this.references[ntID].node = ntlEL.parentNode.getAttribute('node');
			  hlEL.removeChild(ntlEL);          
			}
		  }
		}
		//console.timeEnd('refPositions');
	},
	getVisibleHighlights: function() {
	  var o 
		, scrl = $(window).scrollTop()
		, wh = $(window).height()
		, v = []
		, i = []
		, hl = this.getHighlights()
	  ;

	  for(ntID in hl) {
		o = hl[ntID];
		if(o.bottom >= scrl && o.top <= wh+scrl) {
            v.push(ntID);
        } else {
            i.push(ntID);
        }
		//console.log(o.bottom,'>=',scrl,'...',o.top,'<=',wh+scrl);
	  }
	  return {visible: v, invisible: i};
	},
	getInvisibleHighlights: function() {
	  var o 
		, scrl = $(window).scrollTop()
		, wh = $(window).height()
		, c = []
		, hl = this.getHighlights()
	  ;

	  for(ntID in hl) {
		o = hl[ntID];
		if(o.bottom <= scrl || o.top >= wh+scrl) c.push(ntID);
		//console.log(o.bottom,'<=',scrl,'...',o.top,'>=',wh+scrl);
	  }
	  return c;		
	},
	getReferences: function() {
		if(this.references == null) this.updateReferences();
		return this.references;
		
	},
	getReference: function(ntID){
		if(this.references  == null) this.updateReferences();
		return this.references[ntID];
		
	},
	getHighlights: function(){
		if(this.highlights == null) this.updateHighlights();
		return this.highlights;
	},
	getHighlight: function(ntID){
		if(this.highlights == null) this.updateHighlights();
		return this.highlights[ntID];
	},
	getHighlightsCollection: function(){
		if(!this.highlightEls) this.updateHighlightCollection();
		return this.highlightEls;
	}
};

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.renderNotes = function (options) {
	
    if ( !(this instanceof arguments.callee) ) 
    return new eMend.renderNotes(options); 	
	
	this.opts = $.extend({}, eMend.renderNotes.defaults, options);
	this.container = this.opts.target;
	this.dataset = this.opts.dataset;
	this.positions = this.opts.positions;
	
	this.nodeStatus = {};
	this.nodeLinkHidden = {};
	this.renderedNotes = {};
	var _self = this;
	
	$(this.container).hover(function(){$(_self).trigger('emend.notesHover')},
							function(){$(_self).trigger('emend.notesUnHover')}
	);
	
	this.clearNotes();
}

eMend.renderNotes.defaults = {};

eMend.renderNotes.prototype = {
	clearNotes: function(){
		$(this.container).find('.noteGroup').remove();
	},
	
	renderNotes: function() {
		
		var container = this.container;
		
		var isRefreshing = false,
		row = false,
		lastNodeGroup = null,
		container = this.container,
		ds = this.dataset;
		if(!isRefreshing) {
			this.clearNotes();
			/*
			var spaceHolder = $.create('div',{className:'noteGroup'});
			$(spaceHolder).css({height:'10px', visibility:'hidden'});
			container.appendChild(spaceHolder[0]);
			*/
		}
		
		var hl = $('.highlight'),
		doneNodes = {}, doneNotes = {}, notesFound = {}, emptyGroups = {}, lastInsert, newCommentGroupEl, commentGroup, nodeGroup, nodeClass;
		
		for(var i=hl.length-1; i>=0; i--) {
			hlEL = hl[i]; // highlight element	reference
			nodeGroup = $(hlEL.parentNode).attr('node');
			ntIDs = $(hlEL).attr('className').split(' '); // multiple notes IDs
			ntIDs.pop(); ntIDs.shift(); // trashes 'highlight' and 'aX' class
			
			if(!doneNodes[nodeGroup]) { // NOTEGROUP NOT YET CREATED
				nodeClass = 'noteGroup';
				nodeClass += this.nodeStatus[nodeGroup] ? ' readpart' : ' readfull';
				nodeClass += this.nodeLinkHidden[nodeGroup] ? ' unlinked' : ' linked';					
				//nodeClass += EmendCore.isNodeLinkHidden(nodeGroup) ? ' unlinked' : ' linked';		<<<<<< RESTORE THIS
				commentGroup = new eMend.commentGroup({'nodeGroup': nodeGroup, 'nodeClass': nodeClass});
				newCommentGroupEl = commentGroup.getElement();

				if(isRefreshing) {
					container.replaceChild(newCommentGroupEl,$('noteGroup'+refreshNode));
				} else if (lastNodeGroup) {
                    
					container.insertBefore(newCommentGroupEl,lastNodeGroup);
				} else {
					container.appendChild(newCommentGroupEl);
				}
				//Event.observe(nodeToggle,'click',this.events.actionOnGroup); <<<<<< RESTORE THIS
				lastNodeGroup = newCommentGroupEl;
				lastInsert = null;
				doneNodes[nodeGroup] = true;
				count = 0;
			} 

			for(var j=0, len=ntIDs.length; j < len; j++) {
				ntID = ntIDs[j].substring(1); // note ID
				if(!doneNotes[ntID]) {
//console.log(doneNotes);
					if(!this.nodeStatus[nodeGroup]) {
						uc = ntID.split('_'); // userIdx, noteIdx
						
						//var cData = ds.getComment(uc[0],uc[1]);
						//newInsert = eMend.comment(ntID,cData,nodeGroup,'note even_'+row);
						var cData = ds.getComment(uc[0],uc[1]);
						var newInsert = cData.getElement('emend-note even_'+row);
						
						row = !row;
						commentGroup.prependChild(newInsert);
						/*
						if(lastInsert) {
							newNodeGroup.insertBefore(newInsert,lastInsert);
						} else {
							newNodeGroup.appendChild(newInsert);
						}
						*/
						lastInsert = newInsert;
						this.renderedNotes[ntID] = {group: commentGroup, comment:cData};
					}
					doneNotes[ntID] = true;
					count++;
				}
			}
			
			//console.dir(doneNodes);
			//console.log(nodeGroup,count);
			
			switch (count) {
				case 0:
					emptyGroups[nodeGroup] = true;
				break;
				
				case 1:
					delete emptyGroups[nodeGroup];
					//nodeHead.innerHTML = count +' '+this.I18n.comment;
					//nodeHead.className = 'a'+count;					
				break;
				
				default:
					delete emptyGroups[nodeGroup];
					//nodeHead.innerHTML = count +' '+this.I18n.comments;
					//nodeHead.className = 'a'+count;					
			}			
			
		}
		
		for(nodeGroup in emptyGroups) {
			$('#noteGroup'+nodeGroup).remove();
		}
		
		var spaceHolder = $.create('div',{className:'noteGroup'});
		$(spaceHolder).css({height:'50px', visibility:'hidden'});
		container.appendChild(spaceHolder[0]);
		
		$(this).trigger('emend.rendernotes');
	},
	refreshView: function() {
		
		var o = this.positions.getVisibleHighlights()
		  , Ihl = o.invisible
		  , Vhl = o.visible
		  , In, Vn
		  , IhlL = Ihl.length
		  , VhlL = Vhl.length
		  ;

		for(i=0; i < IhlL; i++) {
			var In = this.renderedNotes[Ihl[i]];
			if(In) {
				In.comment.hide();
				In.group.closeGroup();
				if(VhlL > 3 || IhlL > 3) In.group.minifyGroup();
				//$('#note'+Ihl[i]).parent().addClass('readpart').removeClass('readfull');
			}
		}
		for(i=0; i < VhlL; i++) {
			var Vn = this.renderedNotes[Vhl[i]];
			if(Vn) {
				Vn.comment.show();
				Vn.group.openGroup();
				//$('#note'+Vhl[i]).parent().addClass('readfull').removeClass('readpart');
			}
		}

		var ntID = Vhl[Vhl.length-1];
		var el = $('#note'+ntID);
		
		if(el.length) {
			var t = ( el.offset().top - $(window).scrollTop() + 36 )  + 'px';
			this.scrollTo(t);
		} else {
			window.setTimeout( function(){ $(document).trigger('emend.afterviewscroll'); }, 350 );
		}		
	},
	scrollTo: function(Y){
		$('#sidebar-body').scrollTo(
			{top:Y},
			350,{
			onAfter: function(){ $(document).trigger('emend.afterviewscroll'); },
			stop: true
			}
		);		
	}
}


})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.prefetch = function (options) {
    
    var cfg = eMend.config;
    var baseURI = typeof cfg.baseURI != 'undefined' ? cfg.baseURI : '../dist';

    var c = $('#eMend-comment-assets');
    if(!c.length) {
        c = $($.create('div',{id:'eMend-comment-assets'}))
        for(var i=0; i<21; i++) {
            c.append( $.create('img',{src: baseURI+'images/user'+i+'.png'}) );
        }
        c.append( $.create('img',{src: baseURI + 'images/more_big.png'}) );
        c.append( $.create('img',{src: baseURI + 'images/less_big.png'}) );
        c.append( $.create('img',{src: baseURI +'images/more.png'}) );
        c.append( $.create('img',{src: baseURI + 'images/less.png'}) );
        
        $(options.datastore).append(c);
        
        var d = eMend.dictionary;
        d.comment.baseURI = d.comment_more.baseURI = d.commentGroup.baseURI = d.commentTrigger.baseURI = d.commentForm.baseURI = d.sidebar.baseURI = baseURI+'images';
        
    } else {
        var URI = $(c[0].firstChild).attr('src')
          , OFF = URI.substr(0,URI.lastIndexOf('/'))
          , d = eMend.dictionary;
             
        d.comment.baseURI = d.comment_more.baseURI = d.commentGroup.baseURI = d.commentTrigger.baseURI = d.commentForm.baseURI = d.sidebar.baseURI = OFF;

    }
    
    delete eMendBaseURI;
}

})(jQuery);/*
 * jQuery JSON Plugin
 * version: 1.0 (2008-04-17)
 *
 * This document is licensed as free software under the terms of the
 * MIT License: http://www.opensource.org/licenses/mit-license.php
 *
 * Brantley Harris technically wrote this plugin, but it is based somewhat
 * on the JSON.org website's http://www.json.org/json2.js, which proclaims:
 * "NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.", a sentiment that
 * I uphold.  I really just cleaned it up.
 *
 * It is also based heavily on MochiKit's serializeJSON, which is 
 * copywrited 2005 by Bob Ippolito.
 */
 
(function($) {   
    function toIntegersAtLease(n) 
    // Format integers to have at least two digits.
    {    
        return n < 10 ? '0' + n : n;
    }

    Date.prototype.toJSON = function(date)
    // Yes, it polutes the Date namespace, but we'll allow it here, as
    // it's damned usefull.
    {
        return this.getUTCFullYear()   + '-' +
             toIntegersAtLease(this.getUTCMonth()) + '-' +
             toIntegersAtLease(this.getUTCDate());
    };

    var escapeable = /["\\\x00-\x1f\x7f-\x9f]/g;
    var meta = {    // table of character substitutions
            '\b': '\\b',
            '\t': '\\t',
            '\n': '\\n',
            '\f': '\\f',
            '\r': '\\r',
            '"' : '\\"',
            '\\': '\\\\'
        }
        
    $.quoteString = function(string)
    // Places quotes around a string, inteligently.
    // If the string contains no control characters, no quote characters, and no
    // backslash characters, then we can safely slap some quotes around it.
    // Otherwise we must also replace the offending characters with safe escape
    // sequences.
    {
        if (escapeable.test(string))
        {
            return '"' + string.replace(escapeable, function (a) 
            {
                var c = meta[a];
                if (typeof c === 'string') {
                    return c;
                }
                c = a.charCodeAt();
                return '\\u00' + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
            }) + '"'
        }
        return '"' + string + '"';
    }
    
    $.toJSON = function(o, compact)
    {
        var type = typeof(o);
        
        if (type == "undefined")
            return "undefined";
        else if (type == "number" || type == "boolean")
            return o + "";
        else if (o === null)
            return "null";
        
        // Is it a string?
        if (type == "string") 
        {
            return $.quoteString(o);
        }
        
        // Does it have a .toJSON function?
        if (type == "object" && typeof o.toJSON == "function") 
            return o.toJSON(compact);
        
        // Is it an array?
        if (type != "function" && typeof(o.length) == "number") 
        {
            var ret = [];
            for (var i = 0; i < o.length; i++) {
                ret.push( $.toJSON(o[i], compact) );
            }
            if (compact)
                return "[" + ret.join(",") + "]";
            else
                return "[" + ret.join(", ") + "]";
        }
        
        // If it's a function, we have to warn somebody!
        if (type == "function") {
            throw new TypeError("Unable to convert object of type 'function' to json.");
        }
        
        // It's probably an object, then.
        ret = [];
        for (var k in o) {
            var name;
            var type = typeof(k);
            
            if (type == "number")
                name = '"' + k + '"';
            else if (type == "string")
                name = $.quoteString(k);
            else
                continue;  //skip non-string or number keys
            
            val = $.toJSON(o[k], compact);
            if (typeof(val) != "string") {
                // skip non-serializable values
                continue;
            }
            
            if (compact)
                ret.push(name + ":" + val);
            else
                ret.push(name + ": " + val);
        }
        return "{" + ret.join(", ") + "}";
    }
    
    $.compactJSON = function(o)
    {
        return $.toJSON(o, true);
    }
    
    $.evalJSON = function(src)
    // Evals JSON that we know to be safe.
    {
        return eval("(" + src + ")");
    }
    
    $.secureEvalJSON = function(src)
    // Evals JSON in a way that is *more* secure.
    {
        var filtered = src;
        filtered = filtered.replace(/\\["\\\/bfnrtu]/g, '@');
        filtered = filtered.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']');
        filtered = filtered.replace(/(?:^|:|,)(?:\s*\[)+/g, '');
        
        if (/^[\],:{}\s]*$/.test(filtered))
            return eval("(" + src + ")");
        else
            throw new SyntaxError("Error parsing JSON, source is not valid.");
    }
})(jQuery);
/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.backstore = eMend.backstore || {};
eMend.backstore.tiddly = function (options) {
	
	if ( !(this instanceof arguments.callee) ) 
	return new eMend.backstore.tiddly(options); 	

	this.opts = $.extend({}, eMend.backstore.tiddly.defaults, options);

	// data container creation or import
	var dc = $('#eMend-backstore-tiddly');
	if(dc.length) {
		this.importData(dc);
	} else {
		dc = this.createDataContainer();
	}
	this.container = dc;
};

eMend.backstore.tiddly.defaults = {};

eMend.backstore.tiddly.prototype = {
	createDataContainer: function(location) {
		var dc = $.create('div',{id:'eMend-backstore-tiddly'});
		$(this.opts.datastore).append(dc);
		return $(dc);
	},
	addComment: function() {
		var s = this.opts.dataset.getLastSelection()
		  , c = this.opts.dataset.getLastComment().data
		  , t = $.create('div',{});
		  
		$(t).attr('data', $.toJSON({"s":s,"c":c}));
		t[0].innerHTML = c.body;
		this.container.append(t);
		//console.log('addcomment',s,c);
	},
	importData: function(container) {
		var ds = this.opts.dataset;
		container.children().each(function(){
			var o = $.evalJSON($(this).attr('data')); //$.secureEvalJSON ? secure :) ?
			ds.importEmendment(o.s,o.c);
		});
		$(document).trigger('emend.importData');
		
	}
};

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.backstore = eMend.backstore || {};
eMend.backstore.sfEmendPlugin = function (options) {
	
	if ( !(this instanceof arguments.callee) ) 
	return new eMend.backstore.sfEmendPlugin(options); 	

	this.opts = $.extend({}, eMend.backstore.sfEmendPlugin.defaults, options);
    
    var loc = window.location.pathname.split('/');
    loc.shift();
    this.resourceID = loc.join('_');
    this.getCurrentUser();
    this.getComments();
};

eMend.backstore.sfEmendPlugin.defaults = {};

eMend.backstore.sfEmendPlugin.prototype = {
	addComment: function() {
		var s = this.opts.dataset.getLastSelection()
		  , c = this.opts.dataset.getLastComment().data;
            //console.log('sfEmendPlugin.addcomment',s,c);

        //console.log(c);        

		c.selection = $.toJSON(s);
		//console.log(c);
		$.ajax({
		    url: '/fe_dev.php/emend.addComment/'+this.resourceID,
		    data: c,
		    success: function(msg){
		      //console.log("Data Saved: ",msg);
		    }
		});
	},
	getComments: function(container) {
		var ds = this.opts.dataset;
		$.ajax({
		    url: '/fe_dev.php/emend.getComments/'+this.resourceID,
		    success: function(data, textStatus){
		      //console.log("Data loaded: ",textStatus, data);
		      var obj = $.evalJSON(data);
		      //console.log("JSON: ",obj);
		      
		      var i,l,o;
		    
		      for(i=0, l=obj.comments.length; i<l; i++) {
			o = obj.comments[i];
			ds.importEmendment(o.s,o.c);
		      }
		      $(document).trigger('emend.importData');              
		    },
		    error: function (XMLHttpRequest, textStatus, errorThrown) {
		      //console.log(textStatus, errorThrown)
		      // typically only one of textStatus or errorThrown 
		      // will have info
		      this; // the options for this ajax request
		    }           
		});
	},
	getCurrentUser: function(callback) {
		$.ajax({
		  url: '/get_logged_user',
		  success: function(data, textStatus){
		    var obj = $.evalJSON(data);
		    
		    if(typeof obj.name != 'undefined') {
		      $(document).trigger('emend.loggedIn',obj);
		    } else {
              $(document).trigger('emend.loggedOut');
            }
		  },
		  error: function (XMLHttpRequest, textStatus, errorThrown) {
		    //console.log(textStatus, errorThrown)
		    // typically only one of textStatus or errorThrown 
		    // will have info
		    this; // the options for this ajax request
		  }           
		});
	}
};

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

(function($) {
eMend.backstore = eMend.backstore || {};
eMend.backstore.sfEmendPluginLog = function (options) {
	if ( !(this instanceof arguments.callee) ) 
	return new eMend.backstore.sfEmendPluginLog(options);
    
    this.username = 'anonymous';
	this.opts = $.extend({}, eMend.backstore.sfEmendPluginLog.defaults, options);
    
    var loc = window.location.pathname.split('/');
    loc.shift();
    this.resourceID = loc.join('_');
    this.getCurrentUser();
};

eMend.backstore.sfEmendPluginLog.defaults = {};

eMend.backstore.sfEmendPluginLog.prototype = {
	add: function(type, msg) {
        var o = '';
        if(typeof msg == 'object') {
            for(k in msg) {
                o += '<p>'+k+': <strong>'+msg[k]+'</strong></p>';
            }
        } else {
            o += msg;
        }
        o += '<p> resource id: <strong>'+this.resourceID+'</strong></p>';
        o += '<p> username:'+this.username+'</p>';
        o += '<p> user agent: '+navigator.userAgent+'</p>';
        //console.log(o);
		var log = { msg_type: type,
                    msg: o
        }

		$.ajax({
		    url: '/fe_dev.php/emend.addLog/'+this.resourceID,
		    data: log,
		    success: function(msg){
		      //console.log("Data Saved: ",msg);
		    }
		});
	},
	getCurrentUser: function(callback) {
		$.ajax({
		  url: '/get_logged_user',
		  success: function(data, textStatus){
		    var obj = $.evalJSON(data);
		    
		    if(typeof obj.name != 'undefined') {
		      this.username = obj.name;
		    } else {
              this.username = 'anonymous';
            }
		  },
		  error: function (XMLHttpRequest, textStatus, errorThrown) {
		    //console.log(textStatus, errorThrown)
		    // typically only one of textStatus or errorThrown 
		    // will have info
		    this; // the options for this ajax request
		  }           
		});
	}
};

})(jQuery);/* 
    e-Mend - a web comment system.
    Copyright (C) 2006-2008 MemeFarmers, Collective.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!window.console || !window.console.firebug) {

    if (window.opera && !window.console) {
      window.console = {};
      function fn() { opera.postError(arguments); };
      ['log', 'debug', 'info', 'warn', 'error', 'assert', 'dir', 'dirxml', 'group', 'groupEnd',
       'time', 'timeEnd', 'count', 'trace', 'profile', 'profileEnd'].forEach(function(name) {
        window.console[name] = fn;
      });
    } else {
         var names = ["dir", "dirxml", "group", "groupEnd", "trace", "profile", "profileEnd",
                      "log", "debug", "info", "warn", "error", "time", "timeEnd", "assert", "count"
                     ];  
         window.console = {};  
         // no more javascript errors in non-firefox browsers  
         for (i in names) {  
             window.console[names[i]] = function() {};  
         }
     }
}

(function($) {
eMend.init = function($) {
//eMend.init = function() {
	if(eMend.status == 'running') return;
    
    // backend
    if(eMend.config.backend_debug) {
        switch(eMend.config.backend_debug) {
            case "sfEmendPluginLog":
                eMend.log = eMend.backstore.sfEmendPluginLog();
            break;
        }
    };
    
    
    // cleanup document to possibly eliminate crossbrowser DOM inconsistencies
    $('pre').addClass('keep-whitespace');
	document.body.normalize();
    $.fixOperaRangeSelectionBug();
    var t = $(eMend.config.comment_target).get(0) || document.body;
   
    var html = t.innerHTML;
    html = html.replace(/[\t\n\r\f]/gm, " ");  
    html = html.replace(/>\s+</gm, "><");  
    html = html.replace(/\s{2,}/gm, " ");      
    t.innerHTML = html;

    $(eMend.config.comment_target).cleanWhitespace(true);
    $('a').each(function(){
        this.nodeValue = $.trim(this.nodeValue);
    });     
    
    document.body.normalize();
    
    // creates and attaches DATA and VISUAL containers
	var DO = $('#eMend-DATA-Overlay').remove()[0] || $.create('div',{id:'eMend-DATA-Overlay', className:'hidden write-protect'})[0];
	var VO = $('#eMend-VISUAL-Overlay').remove()[0] || $.create('div',{id:'eMend-VISUAL-Overlay', className:'write-protect'})[0];
	
	if($.browser.msie || $.browser.safari ) {
		$(document.body).append(DO).append(VO);
	} else {
		$(document.body.parentNode).append(DO).append(VO);
	}
	
    // instances and binds modules
	var pf = eMend.prefetch({datastore: DO});
	var SB = eMend.sidebar({target: VO});
	var SBc = SB.getContainer();
	
	var ds = eMend.dataset({target: document.body, datastore: DO})
	  , ps = eMend.positions()
      , usr = eMend.users({dataset: ds})
	  , rn = eMend.renderNotes({dataset: ds, target: SBc, positions: ps})
	  , nb = eMend.navbar({target: SBc.parentNode, positions: ps})
	  , cf = eMend.commentForm({dataset: ds, target: VO})
	  , ct = eMend.commentTrigger({target:VO, form: cf, sidebar: SB, users: usr})
	  , ln = eMend.linker({target: VO, positions: ps});
      
    // backend
    if(eMend.config.backend) {
        switch(eMend.config.backend) {
            case "sfEmendPlugin":
                var sfbk = eMend.backstore.sfEmendPlugin({dataset: ds});
                $(document).bind('emend.addComment',function(){ sfbk.addComment(); });
            break;
        }
    };
    	  
	var emend_lastScrollTimer = -1;
	var emend_lastScrollPosition = $.getScroll().t;
	
// EVENTS HANDLERS
    
    // if sidebar is open refresh links
	var F_refLinks = function(event, data){ if(SB.isOpen()) ln.refreshLinks(); }
    // if sidebar is open refresh view
	  , F_viewChange = function(event, data){ if(SB.isOpen()) rn.refreshView(); }
    // hide links
	  , F_hideLinks = function(event, data){ ln.hideLinks(); }
    //clear links
	  , F_clearLinks = function(event, data){ ln.clearLinks(); }
    // refresh navbar
	  , F_refnavbar = function(event, data){ nb.refresh(); }
    // invalidate position cache when highlights are updated
	  , F_updHL = function(event, data){ ps.invalidate('highlights','references'); }
    // refresh highlights and sidebar notes 
	  , F_refRender = function(event, data){ eMend.highlight(ds); rn.renderNotes(); }
    // open sidebar
	  , F_openSB = function(event, data){ SB.open(); }
    // sends an event 450ms after scroll is over
	  , F_afterscroll = function(event, data){
            window.clearTimeout(emend_lastScrollTimer);
            emend_lastScrollTimer = window.setTimeout(function(){
                $(document).trigger('emend.afterscroll');
            },450);
	    }
	;
    
    delayedRefresh = function() {
        var scroll_Y = $.getScroll().t;
        // filter spurious scroll events for Webkit based browsers
        if(emend_lastScrollPosition != scroll_Y ) {
            F_hideLinks();
            F_afterscroll();
            emend_lastScrollPosition = scroll_Y;
        }
    };

//=================================================	
// EVENTS BINDING
//=================================================

// when sidebar is opened

    // refresh links
	$(document).bind('emend.opensidebar',function(){F_refLinks()});
    // refresh navbar
	$(document).bind('emend.opensidebar',F_refnavbar);
    
// when sidebar is closed

    // hide links then clear theme
	$(document).bind('emend.closesidebar',function(){ F_hideLinks(); window.setTimeout(F_clearLinks,500); });
    
// when a comment is posted

    // refresh render
	$(document).bind('emend.addComment',F_refRender);
    
    // shows a GUI message 
	$(document).bind('emend.addComment',function(){ ct.show(0); });
    
// when new data is imported in dataset

    // refresh render
    $(document).bind('emend.importData',function(){ F_refRender(); });

// when highlights are repainted

    // invalidates positions cache
	$(document).bind('emend.highlight',F_updHL);
    
	
	$(rn).bind('emend.notesHover',F_refLinks);
	
// when notes are rendered

    // open sidebar
    $(rn).bind('emend.rendernotes',F_openSB);
    
    
	$(document).bind('emend.afterscroll',F_viewChange);
	$(document).bind('emend.afterviewscroll',F_refLinks);
	//$(document).bind('emend.toggleGroup',F_refLinks);
    
// when a comment group is opened/closed

    // refresh links
	$(document).bind('emend.toggleGroup',function(){ F_refLinks(); });
    
// when the window is resized

    // invalidates positions cache
	$(window).wresize(F_updHL);
    
    // refresh links
	$(window).wresize(F_refLinks);
    
    // refresh navbar
	$(window).wresize(F_refnavbar);

//=================================================    
// OPTIONAL BINDINGS
//=================================================
	
//
// scroll_refresh_delay: [true/false]
//

if(eMend.config.scroll_refresh_delay) {
    // hide links and repaint view after a certain delay after the last scroll event
    $(window).scroll(delayedRefresh);
} else {
    // immediately repaint after each scroll event
    $(window).scroll(F_refLinks);
    $(window).scroll(F_afterscroll);        
}

//
// backend: [sfEmendPlugin(/Wordpress/MediaWiki)]
//

if(eMend.config.backend) {
    $(document).bind('emend.loggedIn', function(event, data) { usr.login(event,data); ct.show(0); });
    $(document).bind('emend.loggedOut', function(event, data) { usr.logout(); ct.show(4); });
}

//  
// backstore_tiddly: [true/false]
//

if(eMend.config.backstore_tiddly) {
    // instances tiddly module
    var bk = eMend.backstore.tiddly({dataset: ds, datastore: DO});
    // ping it when a comment is added
    $(document).bind('emend.addComment',function(){ bk.addComment(); });
};

    eMend.status = 'running';    
};



if(typeof eMendInit != 'undefined' && eMendInit == true) eMend.init(jQuery);
$(document).ready(function(){ eMend.init(jQuery) });
//jQuery(document).ready(function(){ eMend.init(jQuery) });

})(jQuery);
if(eMend.config.jquery_noconflict) {
  //jQuery.noConflict();
};
