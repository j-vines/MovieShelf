/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Functions used in displaying login form in common header */
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

// Display or hide contents of password input field
function togglePassword() {
	var pass = document.getElementById("password_signup");
  	if (pass.type === "password") {
		pass.type = "text";
  	} else {
		pass.type = "password";
  	}
}

// Display sign-up modal box
function openCreateAccount() {
	var signupForm = document.getElementById("createAccount");
	signupForm.style.display = "block";
}

// Hide sign-up modal box
function closeCreateAccount() {
	var signupForm = document.getElementById("createAccount");
	signupForm.style.display = "none";
}