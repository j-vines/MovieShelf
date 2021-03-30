// JavaScript Document
var recNum;

function storeRecNum(num) {
	recNum = num;
}

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

function openRec(num, idrecommendation) {
	document.getElementById("rec" + num).style.display = "block";
	
	$.ajax({
		url: "scripts/open_recommendation.php",
		type: "POST",
		data: {'idrecommendation': idrecommendation},
		success: function() {
					if(document.getElementById("openedLabel" + num)) {
						document.getElementById("openedLabel" + num).style.display = "none";
					}
				}
		});
}

function deleteRec(num, idrecommendation) {
	$.ajax({
		url: "scripts/delete_recommendation.php",
		type: "POST",
		data: {'idrecommendation': idrecommendation},
		success: function() {
					//remove recommendation from client display
					var element = document.getElementById("rec" + num);
					element.parentNode.removeChild(element);
			
					var element = document.getElementById("openRec" + num);
					element.parentNode.removeChild(element);
					
					if(recNum > 0) updateButton();
					
				}
		});
}

function updateButton() {
	recNum--;
	if (recNum == 0) {
		document.getElementById("recButton").innerHTML = "NO RECOMMENDATIONS";
	} 
	else if (recNum == 1){
		document.getElementById("recButton").innerHTML = "<span class='notification'>" + recNum + "</span> RECOMMENDATION";
	}
	else {
		document.getElementById("recButton").innerHTML = "<span class='notification'>" + recNum + "</span> RECOMMENDATIONS";
	}
}

function closeRec(num) {
	document.getElementById("rec" + num).style.display = "none";
}
