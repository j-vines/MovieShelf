
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

function showFilmInfo(id, title, format, releaseYear, posterPath, shelvesArray) {
	document.getElementById("filmInfo").style.display="block";
	document.getElementById("moreInfoTitle").innerHTML = title;
	document.getElementById("moreInfoYear").innerHTML = releaseYear;
	document.getElementById("moreInfoFormat").innerHTML = format;
	document.getElementById("moreInfoPoster").src = posterPath;
	document.getElementById("addFilm").value = id;
	
	
	var shelfList = "";
	for(var i = 0; i < shelvesArray.length; i++) {
		var shelf = shelvesArray[i].split(":");
		shelfList = shelfList + shelf[1];
		if(shelvesArray.length - i != 1) shelfList = shelfList + ", ";
	}
	document.getElementById("moreInfoShelves").innerHTML = shelfList;
}

function closeFilmInfo() {
	document.getElementById("filmInfo").style.display="none";
}