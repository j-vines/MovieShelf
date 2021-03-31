
var filmInfoList = [];
var currShelfId = 0;

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

function setCurrShelf(shelfId) {
	currShelfId = shelfId;
}

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


function storeFilmInfo(moreInfo) {
	//store JSON object containing information about film in array of info objects
	filmInfoList.push(moreInfo);
}

/* Shelf functions */
function closeShelfOptions() {
	document.getElementById("shelfOptions").style.display="none";
	document.getElementById("deleteShelf").style.display="none";
	document.getElementById("addShelf").style.display="none";
}

function showShelfOptions() {
	showButtons();
	document.getElementById("shelfOptions").style.display="block";
}

function showAddShelf() {
	document.getElementById("addShelf").style.display="block";
	document.getElementById("deleteShelf").style.display="none";
	hideButtons();
}

function showDeleteShelf() {
	document.getElementById("deleteShelf").style.display="block";
	document.getElementById("addShelf").style.display="none";
	hideButtons();
}

function hideButtons() {
	document.getElementById("addShelfButton").style.display="none";
	document.getElementById("deleteShelfButton").style.display="none";
}

function showButtons() {
	document.getElementById("addShelfButton").style.display="block";
	document.getElementById("deleteShelfButton").style.display="block";
}

function cancelOp() {
	showButtons();
	document.getElementById("deleteShelf").style.display="none";
	document.getElementById("addShelf").style.display="none";
	
}

/* More info on film functions */

/* showFilmInfo takes JSON object containing film information and displays it in modal box
	filmInfo includes fields:
	id - id in database of film
	title - title of film
	format - format user owns film on
	releaseYear - year of release of film
	posterPath - image src for film poster
	shelvesIn - array of shelves film is stored in
	shelvesOut - array of shelves film is NOT stored in */
function showFilmInfo(filmInfo) {
	
	document.getElementById("filmInfo").style.display="block";
	document.getElementById("moreInfoTitle").innerHTML = filmInfo.title;
	document.getElementById("moreInfoYear").innerHTML = filmInfo.releaseYear;
	document.getElementById("moreInfoFormat").innerHTML = filmInfo.format;
	document.getElementById("moreInfoPoster").src = filmInfo.posterPath;
	if(document.getElementById("removeFilm")) {
		document.getElementById("removeFilm").addEventListener("click", function(e) {
			removeFilm(filmInfo.id);
			
		}, false);
	}
	/*if(document.getElementById("ratingId")) {
		document.getElementById("ratingId").value = filmInfo.id;
	}*/
	
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

function showCompareFilmInfo(filmInfo) {
	console.log(filmInfo);
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

function closeFilmInfo() {
	document.getElementById("filmInfo").style.display="none";
}

function showRecommendForm() {
	document.getElementById("recommendForm").style.display = "block";
	document.getElementById("recommendButton").style.display = "none";
}

function closeRecommendForm() {
	document.getElementById("recommendForm").style.display = "none";
	document.getElementById("recommendButton").style.display = "block";
}

