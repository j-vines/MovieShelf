/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Functions used in displaying your or another user's collection */

var filmInfoList = [];
var currShelfId = 0;

/* Initialize collection by setting every poster displayed as a click event associated with a certain entry in the filmInfoList array */
function collectionInit() {
	var posters= document.getElementsByClassName("collectionPosterContainer");

	for(var i = 0; i < posters.length; i++) {
		posters[i].addEventListener("click", function(e) {
			var filmId = e.currentTarget.id;
			//get info about this film from film list using returned filmID, pass to showFilmInfo()
			for(var j = 0; j < filmInfoList.length; j++) {
				if(filmInfoList[j].id == filmId) {
					showFilmInfo(filmInfoList[j]);
				}
			}
			
		}, false);
	}
}

/* Store the value of the current shelf - used to decide whether a film removed from a shelf should be removed from the client display */
function setCurrShelf(shelfId) {
	currShelfId = shelfId;
}

/* Initialize collection compare page by setting every poster displayed as a click event associated with a certain entry in the filmInfoList array */
function collectionCompareInit() {
	
	var posters= document.getElementsByClassName("collectionPosterContainer");
	for(var i = 0; i < posters.length; i++) {
		
		posters[i].addEventListener("click", function(e) {
			var filmId = e.currentTarget.id;
			//get info about this film from film list using returned filmID, pass to showCompareFilmInfo()
			for(var j = 0; j < filmInfoList.length; j++) {
				if(filmInfoList[j].tmdbId == filmId) {
					showCompareFilmInfo(filmInfoList[j]);
				}
			}
			
		}, false);
	}
}

/* Store JSON object containing information about film in array of info objects */
function storeFilmInfo(moreInfo) {
	filmInfoList.push(moreInfo);
}

/* Shelf functions */

// Hide the shelf options modal box
function closeShelfOptions() {
	document.getElementById("shelfOptions").style.display="none";
	document.getElementById("deleteShelf").style.display="none";
	document.getElementById("addShelf").style.display="none";
}

// Display the shelf options modal box
function showShelfOptions() {
	showButtons();
	document.getElementById("shelfOptions").style.display="block";
}

// Change contents of shelf options modal box to form for creating a shelf
function showAddShelf() {
	document.getElementById("addShelf").style.display="block";
	document.getElementById("deleteShelf").style.display="none";
	hideButtons();
}

// Change contents of shelf options modal box to form for deleting a shelf
function showDeleteShelf() {
	document.getElementById("deleteShelf").style.display="block";
	document.getElementById("addShelf").style.display="none";
	hideButtons();
}

// Hide buttons for adding and deleting a shelf
function hideButtons() {
	document.getElementById("addShelfButton").style.display="none";
	document.getElementById("deleteShelfButton").style.display="none";
}

// Show buttons for adding and deleting a shelf
function showButtons() {
	document.getElementById("addShelfButton").style.display="block";
	document.getElementById("deleteShelfButton").style.display="block";
}

// Cancel operation (delete or create shelf) by hiding forms
function cancelOp() {
	showButtons();
	document.getElementById("deleteShelf").style.display="none";
	document.getElementById("addShelf").style.display="none";
	
}

/* More info on film functions */

/* Take JSON object containing film information and display it in modal box
	filmInfo includes fields:
	id - id in database of film
	title - title of film
	format - format user owns film on
	releaseYear - year of release of film
	posterPath - image src for film poster
	shelvesIn - array of shelves film is stored in
	shelvesOut - array of shelves film is NOT stored in */
function showFilmInfo(filmInfo) {
	//console.log(filmInfo);
	document.getElementById("filmInfo").style.display="block";
	document.getElementById("moreInfoTitle").innerHTML = filmInfo.title;
	document.getElementById("moreInfoYear").innerHTML = filmInfo.releaseYear;
	document.getElementById("moreInfoFormat").innerHTML = filmInfo.format;
	document.getElementById("moreInfoPoster").src = filmInfo.posterPath;
	document.getElementById("moreInfoReviewText").innerHTML = filmInfo.review;
	if(document.getElementById("moreInfoReviewButton")) {
		if(filmInfo.review == null) {
			document.getElementById("moreInfoReviewButton").innerHTML = "Write a Review";
		} else {
			document.getElementById("moreInfoReviewButton").innerHTML = "Edit Your Review";
		}
		document.getElementById("moreInfoReviewButton").onclick = function() { showReviewForm(filmInfo.review); };
		document.getElementById("cancelReviewButton").onclick = function() { closeReviewForm(filmInfo.review); };
		document.getElementById("postReviewButton").onclick = function() { postReview(filmInfo.id); };
	}
	if(document.getElementById("removeFilm")) {
		document.getElementById("removeFilm").onclick = function(){ removeFilm(filmInfo.id); };
	}
	
	if(filmInfo.review == null) {
		document.getElementById("moreInfoReviewText").style.display = "none";
	} else {
		document.getElementById("moreInfoReviewText").style.display = "block";
	}
	
	//set stars to change rating
	document.getElementById("1star").onclick = function(){changeRating(filmInfo.id, 1)};
	document.getElementById("2stars").onclick = function(){changeRating(filmInfo.id, 2)};
	document.getElementById("3stars").onclick = function(){changeRating(filmInfo.id, 3)};
	document.getElementById("4stars").onclick = function(){changeRating(filmInfo.id, 4)};
	document.getElementById("5stars").onclick = function(){changeRating(filmInfo.id, 5)};
	
	//display stars based on rating in db
	switch(filmInfo.rating) {
		case '1':
			document.getElementById("1star").checked = true;
			break;
		case '2':
			document.getElementById("2stars").checked = true;
			break;
		case '3':
			document.getElementById("3stars").checked = true;
			break;
			
		case '4':
			document.getElementById("4stars").checked = true;
			break;
			
		case '5':
			document.getElementById("5stars").checked = true;
			break;
			
		default:
			document.getElementById("1star").checked = false;
			document.getElementById("2stars").checked = false;
			document.getElementById("3stars").checked = false;
			document.getElementById("4stars").checked = false;
			document.getElementById("5stars").checked = false;
	}
	
	
	var shelvesIn = JSON.parse(filmInfo.shelvesIn);
	var shelvesOut = JSON.parse(filmInfo.shelvesOut);
	
	//display the names of the shelves that the film is present in
	var shelfList = "";
	if(shelvesIn.length > 0) {
		if(shelvesIn.length > 1) shelfList = "On shelves: "
		else shelfList = "On shelf: "
	}
	
	for(var i = 0; i < shelvesIn.length; i++) {
		var shelf = shelvesIn[i].split(":");
		shelfList = shelfList + shelf[1];
		if(shelvesIn.length - i != 1) shelfList = shelfList + ", ";
	}
	document.getElementById("moreInfoShelves").innerHTML = shelfList;
	
	//display form for adding film to shelves it is not in already
	if(document.getElementById("moreInfoAddForm")) {
		var form = "<form id='filmShelfAdd' autocomplete='off'>"
				   + "<label for='shelf'>Add to shelf: </label>"
				   + "<input type='hidden' value='"+filmInfo.id+"' name='addFilm' id='addFilm'>"
				   + "<select id='addToShelf' name='shelf'>"
				   + "<option>No shelf selected</option>";
		
		for(var i = 0; i < shelvesOut.length; i++) {
			var shelf = shelvesOut[i].split(":");
			form = form + "<option value='"+shelf[0]+"'>"+shelf[1]+"</option>";
		}
		form = form + "</select></form>";
		document.getElementById("moreInfoAddForm").innerHTML = form;
		
		var addToShelf = document.getElementById("addToShelf");
		addToShelf.onchange = function(){shelfAdd(addToShelf.value, filmInfo.id)};
	}
	
	//display form for removing film from the shelves it is currently in
	if(document.getElementById("moreInfoDeleteForm")) {
		var form = "<form id='filmShelfDelete' autocomplete='off'>"
				   + "<label for='shelf'>Remove from shelf: </label>"
				   + "<input type='hidden' value='"+filmInfo.id+"' name='deleteFilm' id='deleteFilm'>"
				   + "<select id='deleteFromShelf' name='shelf'>"
				   + "<option>No shelf selected</option>";
		
		for(var i = 0; i < shelvesIn.length; i++) {
			var shelf = shelvesIn[i].split(":");
			form = form + "<option value='"+shelf[0]+"'>"+shelf[1]+"</option>";
		}
		form = form + "</select></form>";
		document.getElementById("moreInfoDeleteForm").innerHTML = form;
		
		var deleteFromShelf = document.getElementById("deleteFromShelf");
		deleteFromShelf.onchange = function(){shelfRemove(deleteFromShelf.value, filmInfo.id)};
	}
}

/* Take JSON object containing film information for comparison and display it in modal box
	filmInfo includes fields:
	title - title of film
	releaseYear - year of release of film
	posterPath - image src for film poster*/
function showCompareFilmInfo(filmInfo) {
	document.getElementById("filmInfo").style.display="block";
	document.getElementById("collectionCompareTitle").innerHTML = filmInfo.title;
	document.getElementById("collectionComparePoster").src = filmInfo.posterPath;
	document.getElementById("collectionCompareYear").innerHTML = filmInfo.releaseYear;
	
	if(filmInfo.recommend) {
		document.getElementById("recommendButton").innerHTML = "<button onClick='showRecommendForm()'>Recommend this film</button>";
		
		var recommendForm = "<textarea maxlength='250' rows='5' cols='40' id='message' name='message'></textarea><br><br>"
							+ "<button id='sendRecommendationButton'>Send</button>"
							+ "<br><br>"
							+ "<button type='button' onClick='closeRecommendForm()'>Cancel</button>";
			
		document.getElementById("recommendForm").innerHTML = recommendForm;
		
		document.getElementById("sendRecommendationButton").addEventListener("click", function(e) {
			sendRecommendation(filmInfo);
			
		}, false);
	} else {
		document.getElementById("recommendButton").innerHTML = "";
	}
	
	
}

/* Asynchronously add recommendation to database 
	filmInfo - object containing information about a film to be displayed in recommendation body
*/
function sendRecommendation(filmInfo) {
	
	var message = document.getElementById("message").value;
	
	$.ajax({
		url: "scripts/send_recommendation.php",
		type: "POST",
		data: {'userTo': filmInfo.otherUserId,
				'filmPosterPath': filmInfo.posterPath,
				'filmYear': filmInfo.releaseYear,
				'filmTitle': filmInfo.title,
				'userFrom': filmInfo.userId,
			  	'message': message},
		success: function() {
					closeRecommendForm();
					alert("Recommendation sent!");
					
				}
		});
}

/* Add a review to the database asynchronously
	id - id of the film the review is associated with 
*/
function postReview(id) {
	var reviewText = document.getElementById("reviewTextArea").value;
	
	$.ajax({
		url: "scripts/post_review.php",
		type: "POST",
		data: {'id': id,
			  	'review': reviewText},
		success: function() {
			alert("Review Posted!");

			//change review in filminfolist
			for(var i = 0; i < filmInfoList.length; i++) {
				if(filmInfoList[i].id == id) {
					filmInfoList[i].review = reviewText;
				}
			}
			closeReviewForm(reviewText);
			document.getElementById("moreInfoReviewText").innerHTML = reviewText;
		}
		});
}

/* Display form for sending a review in the compare collection film info modal box */
function showReviewForm(review) {
	document.getElementById("moreInfoReviewForm").style.display = "block";
	document.getElementById("moreInfoReviewButton").style.display = "none";
	document.getElementById("moreInfoReviewText").style.display = "none";
	document.getElementById("reviewTextArea").value = review;
}

/* Hide form for sending a review in the compare collection film info modal box */
function closeReviewForm(review) {
	if(review != null) {
		document.getElementById("moreInfoReviewText").style.display = "block";
	}
	document.getElementById("moreInfoReviewForm").style.display = "none";
	document.getElementById("reviewTextArea").value = "";
	document.getElementById("moreInfoReviewButton").style.display = "block";
	
}

/* Asynchronously remove film from the film table 
	id - id of the film to be removed
*/
function removeFilm(id) {
	$.ajax({
		url: "scripts/remove_film.php",
		type: "POST",
		data: {'filmId': id},
		success: function() {
					closeFilmInfo();
					var element = document.getElementById(id);
					element.parentElement.removeChild(element);
				}
		});
}

/* Modify rating of film in the film table
	id - id of the film whose rating is to be modified
	rating - number representing new rating
*/
function changeRating(id, rating) {
	$.ajax({
		url: "scripts/change_rating.php",
		type: "POST",
		data: {'ratingId': id,
			  	'rating': rating},
		success: function() {
			//change rating in filminfolist
			for(var i = 0; i < filmInfoList.length; i++) {
				if(filmInfoList[i].id == id) {
					filmInfoList[i].rating = rating.toString();
				}
			}
		}
		});
}

/* Add a film to a shelf
	shelfId - id of shelf to be added to
	filmId - id of film to be added to shelf
*/
function shelfAdd(shelfId, filmId) {
	$.ajax({
		url: "scripts/add_to_shelf.php",
		type: "POST",
		data: {'shelfId': shelfId,
			  	'filmId': filmId},
		success: function() {
			alert("Film added to shelf!");
		}
		});
}

/* Remove a film from a shelf
	shelfId - id of shelf to be removed from
	filmId - id of film to be removed from shelf
*/
function shelfRemove(shelfId, filmId) {
	$.ajax({
		url: "scripts/delete_from_shelf.php",
		type: "POST",
		data: {'shelfId': shelfId,
			  	'filmId': filmId},
		success: function() {
			alert("Film removed from shelf!");

			if(currShelfId.toString() == shelfId) {
				var element = document.getElementById(filmId);
				element.parentElement.removeChild(element);
			}
		}
		});
}

/* Hide film info modal box */
function closeFilmInfo() {
	document.getElementById("filmInfo").style.display="none";
}

/* Display form for sending recommendations in film info modal box */
function showRecommendForm() {
	document.getElementById("recommendForm").style.display = "block";
	document.getElementById("recommendButton").style.display = "none";
}

/* Hide form for sending recommendations in film info modal box */
function closeRecommendForm() {
	document.getElementById("recommendForm").style.display = "none";
	document.getElementById("recommendButton").style.display = "block";
}

