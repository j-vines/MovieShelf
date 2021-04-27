/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Methods used in updating and displaying to the activity page */

var recNum;

/* Stores number of recommendations for display to the user */
function storeRecNum(num) {
	recNum = num;
}

/* Hides post feed and displays recommendation inbox */
function showRecommendations() {
	document.getElementById("recommendations").style.display = "block";
	document.getElementById("posts").style.display = "none";
	
	document.getElementById("recButton").style.backgroundColor = "darkslateblue";
	document.getElementById("postButton").style.backgroundColor = "black";
}

/* Hides recommendation inbox and displays post feed */
function showPosts() {
	document.getElementById("recommendations").style.display = "none";
	document.getElementById("posts").style.display = "block";
	
	document.getElementById("recButton").style.backgroundColor = "black";
	document.getElementById("postButton").style.backgroundColor = "darkslateblue";
}

/* Set getPosts function to be called every 60 seconds */
function initGetPosts() {
	var interval = 1000 * 60; //call getPosts every 1 minute

	setInterval(getPosts, interval);
	
	getPosts();
}

/* Retrieve new posts from the database (acquisitions/reviews), sort them by timestamp, and display them */
function getPosts() {
	
	$.ajax({
		url: "scripts/get_posts.php",
		type: "GET",
		success: function(data) {
					var postArray = [];

					//sort data by timeShared
					data = JSON.parse(data);
					data.forEach(modifyDate);
					
					//change timeShared from string to js Date
					function modifyDate(post) {
						post = JSON.parse(post);
						var timestamp = post.timeShared.split(/[- :]/);
						
						var time = new Date(Date.UTC(timestamp[0], timestamp[1]-1, timestamp[2], timestamp[3], timestamp[4], timestamp[5]));
						
						post.timeShared = time;
						postArray.push(post);
						
					}
					
					//sort post array by timeShared
					postArray.sort(function(a, b) {
						var c = new Date(a.timeShared);
						var d = new Date(b.timeShared);
						return d-c;
					});
					
					var postHTML = "";
					postArray.forEach(displayPost);
					
					/*Post contains: 
						filmName
						filmReleaseYear
						name
						posterPath
						reviewText (reviews only)
						timeShared
						type
						userid
						dateAcquired (acquisitions only) */
					function displayPost(post) {
						var postText = "<div class='post'>";
						
						
						//get time since post
						var currDate = new Date().getTime();
						var secondsSincePost = (currDate - post.timeShared.getTime()) * .001; //seconds
						//console.log(secondsSincePost);
						var timeDisplay = "";
						if (secondsSincePost > 60) { //display in minutes
							timeDisplay = Math.round((secondsSincePost) / 60) + " minutes ago";
							
							if ((secondsSincePost / 60) > 60) { //display in hours
								timeDisplay = Math.round(((secondsSincePost) / 60) / 60) + " hours ago";
								
								if (((secondsSincePost / 60) / 60) > 24) { //display in days
									timeDisplay = Math.round((((secondsSincePost) / 60) / 60) / 24) + " days ago";
									
								}
							}
						} else {
							timeDisplay = Math.round(secondsSincePost) + " seconds ago";
						}
						
						if(post.type == "review") {
							postText += "<a class='profileLink' href='user_profile.php?userid="+post.userid+"'>"+post.name+"</a>" + 
										" reviewed <b>" + post.filmName + " (" + post.filmReleaseYear + ") </b>" +
										"<br> on <b>" + post.format + "</b><br>" +
										"<br><div class='reviewText'>" + post.reviewText + "</div><br>";
						} else {
							postText += "<a class='profileLink' href='user_profile.php?userid="+post.userid+"'>"+post.name+"</a> acquired <b>" + post.filmName + " (" + post.filmReleaseYear + ") </b>" +
							"<br> on <b>" + post.format + "</b><br><br>";
						}
						
						postHTML += postText + timeDisplay + "</div>";
						
					}
					document.getElementById("posts").innerHTML = postHTML;
			
					
				}
		});
	
	
}



/* When user opens recommendation, remove "NEW" from its header and set it to inactive in database */
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

/* Remove a recommendation from a user's inbox */
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

/* Change the recommendation tab button based on number of active recommendations in inbox */
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

/* Hide body of recommendation that a user closes */
function closeRec(num) {
	document.getElementById("rec" + num).style.display = "none";
}
