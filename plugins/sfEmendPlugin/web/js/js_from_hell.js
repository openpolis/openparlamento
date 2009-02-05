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
