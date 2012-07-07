/*
 * Shortcut for document.getElementById
 */
function id(elementName) {
	return document.getElementById(elementName);
}

/*
 * Emulates PHP's $_GET array
 * borrowed from http://www.onlineaspect.com/2009/06/10/reading-get-variables-with-javascript/
 */
function $_GET(q,s) { 
    s = s ? s : window.location.search; 
    var re = new RegExp('&'+q+'(?:=([^&]*))?(?=&|$)','i'); 
    return (s=s.replace(/^?/,'&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined; 
}

