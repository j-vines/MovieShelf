/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Functions used in displaying welcome login message */
var message;
var form;

/**
	Init called when common_header.php loads
	Gets references to dom objects to be manipulated
*/
function init() {
	message = document.getElementById("loginMessage");
	form = document.getElementById("loginForm");
}

/**
	Hides login button, shows login form
*/
function displayForm() {
	message.style.display = "none";
	form.style.display = "block";
}

/**
	Hides login form, shows login button
*/
function hideForm() {
	message.style.display = "block";
	form.style.display = "none";
}