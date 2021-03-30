// JavaScript Document

function showRecommendations() {
	document.getElementById("recommendations").style.display = "block";
	document.getElementById("posts").style.display = "none";
	
	document.getElementById("recButton").style.backgroundColor = "darkslateblue";
	document.getElementById("postButton").style.backgroundColor = "black";
}

function showPosts() {
	document.getElementById("recommendations").style.display = "none";
	document.getElementById("posts").style.display = "block";
	
	document.getElementById("recButton").style.backgroundColor = "black";
	document.getElementById("postButton").style.backgroundColor = "darkslateblue";
}

function openRec(num) {
	document.getElementById("rec" + num).style.display = "block";
}

function closeRec(num) {
	document.getElementById("rec" + num).style.display = "none";
}
