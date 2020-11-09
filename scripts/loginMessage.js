// JavaScript Document
var message;
var form;

function init() {
	message = document.getElementById("loginMessage");
	form = document.getElementById("loginForm");
}

function displayForm() {
	message.style.display = "none";
	form.style.display = "block";
}

function hideForm() {
	message.style.display = "block";
	form.style.display = "none";
}