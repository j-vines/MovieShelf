/* Contains functions for setting, getting, and checking cookies */

//Return the value of cookie "name"
function getCookie(name) {
	var name = name + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var cookieList = decodedCookie.split(';');
	
	for(var i = 0; i < cookieList.length; i++) {
		var cookie = cookieList[i];
		while(cookie.charAt(0) == ' ') {
			cookie = cookie.substring(1);
		}
		if(cookie.indexOf(name) == 0) {
			return cookie.substring(name.length, cookie.length);
		}
	}
	return "";
}

//Return true if cookie "name" is set. Otherwise return false
function checkCookie(name) {
	if(getCookie(name) != "") {
		return true;
	}
	return false;
}