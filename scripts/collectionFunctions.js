
var filmInfoList = [];

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
		document.getElementById("removeFilm").value = filmInfo.id;
	}
	if(document.getElementById("ratingId")) {
		document.getElementById("ratingId").value = filmInfo.id;
	}
	
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
		var form = "<form id='filmShelfAdd' autocomplete='off' action='scripts/shelf_edit.php' method='post'>"
				   + "<label for='shelf'>Add to shelf: </label>"
				   + "<input type='hidden' value='"+filmInfo.id+"' name='addFilm' id='addFilm'>"
				   + "<select id='shelf' name='shelf' onchange='this.form.submit()'>"
				   + "<option>No shelf selected</option>";
		
		for(var i = 0; i < shelvesOut.length; i++) {
			var shelf = shelvesOut[i].split(":");
			form = form + "<option value='"+shelf[0]+"'>"+shelf[1]+"</option>";
		}
		form = form + "</select></form>";
		document.getElementById("moreInfoAddForm").innerHTML = form;
	}
	
	//display form for removing film from the shelves it is currently in
	if(document.getElementById("moreInfoDeleteForm")) {
		var form = "<form id='filmShelfDelete' autocomplete='off' action='scripts/shelf_edit.php' method='post'>"
				   + "<label for='shelf'>Remove from shelf: </label>"
				   + "<input type='hidden' value='"+filmInfo.id+"' name='deleteFilm' id='deleteFilm'>"
				   + "<select id='shelf' name='shelf' onchange='this.form.submit()'>"
				   + "<option>No shelf selected</option>";
		
		for(var i = 0; i < shelvesIn.length; i++) {
			var shelf = shelvesIn[i].split(":");
			form = form + "<option value='"+shelf[0]+"'>"+shelf[1]+"</option>";
		}
		form = form + "</select></form>";
		document.getElementById("moreInfoDeleteForm").innerHTML = form;
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
		
		var recommendForm = "<form action='collection_compare.php' method='post'>"
							+ "<input type='hidden' id='sendRecommendation' name='sendRecommendation'>"
							+ "<input type='hidden' id='userFrom' name='userFrom' value='" + filmInfo.userId + "'>"
							+ "<input type='hidden' id='userTo' name='userTo' value='" + filmInfo.otherUserId + "'>"
							+ "<input type='hidden' id='userToName' name='userToName' value='" + filmInfo.otherUsername + "'>"
							+ "<input type='hidden' id='filmTitle' name='filmTitle' value='" + filmInfo.title + "'>"
							+ "<input type='hidden' id='filmYear' name='filmYear' value='" + filmInfo.releaseYear + "'>"
							+ "<input type='hidden' id='filmPosterPath' name='filmPosterPath' value='" + filmInfo.posterPath + "'>"
							+ "<label for='message'>Message: </lable>"
							+ "<textarea maxlength='250' rows='5' cols='40' id='message' name='message'></textarea><br><br>"
							+ "<input type='submit' value='Send'>"
							+ "</form><br><br>"
							+ "<button type='button' onClick='closeRecommendForm()'>Cancel</button>";
			
		document.getElementById("recommendForm").innerHTML = recommendForm;
	} else {
		document.getElementById("recommendButton").innerHTML = "";
	}
	
	
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

