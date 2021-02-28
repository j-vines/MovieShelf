
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

function showFilmInfo(id, title, format, releaseYear, posterPath, shelvesInArray, shelvesNotInArray) {
	document.getElementById("filmInfo").style.display="block";
	document.getElementById("moreInfoTitle").innerHTML = title;
	document.getElementById("moreInfoYear").innerHTML = releaseYear;
	document.getElementById("moreInfoFormat").innerHTML = format;
	document.getElementById("moreInfoPoster").src = posterPath;
	
	//display the names of the shelves that the film is present in
	var shelfList = "";
	if(shelvesInArray.length > 0) {
		if(shelvesInArray.length > 1) shelfList = "On shelves: "
		else shelfList = "On shelf: "
	}
	
	for(var i = 0; i < shelvesInArray.length; i++) {
		var shelf = shelvesInArray[i].split(":");
		shelfList = shelfList + shelf[1];
		if(shelvesInArray.length - i != 1) shelfList = shelfList + ", ";
	}
	document.getElementById("moreInfoShelves").innerHTML = shelfList;
	
	//display form for adding film to shelves it is not in already
	if(!!document.getElementById("moreInfoAddForm")) {
		var form = "<form id='filmShelfAdd' autocomplete='off' action='scripts/shelf_edit.php' method='post'>"
				   + "<label for='shelf'>Add to shelf: </label>"
				   + "<input type='hidden' value='"+id+"' name='addFilm' id='addFilm'>"
				   + "<select id='shelf' name='shelf' onchange='this.form.submit()'>"
				   + "<option>No shelf selected</option>";
		
		for(var i = 0; i < shelvesNotInArray.length; i++) {
			var shelf = shelvesNotInArray[i].split(":");
			form = form + "<option value='"+shelf[0]+"'>"+shelf[1]+"</option>";
		}
		form = form + "</select></form>";
		document.getElementById("moreInfoAddForm").innerHTML = form;
	}
	
	
	//display form for removing film from the shelves it is currently in
	if(!!document.getElementById("moreInfoDeleteForm")) {
		var form = "<form id='filmShelfDelete' autocomplete='off' action='scripts/shelf_edit.php' method='post'>"
				   + "<label for='shelf'>Remove from shelf: </label>"
				   + "<input type='hidden' value='"+id+"' name='deleteFilm' id='deleteFilm'>"
				   + "<select id='shelf' name='shelf' onchange='this.form.submit()'>"
				   + "<option>No shelf selected</option>";
		
		for(var i = 0; i < shelvesInArray.length; i++) {
			var shelf = shelvesInArray[i].split(":");
			form = form + "<option value='"+shelf[0]+"'>"+shelf[1]+"</option>";
		}
		form = form + "</select></form>";
		document.getElementById("moreInfoDeleteForm").innerHTML = form;
	}
	
}

function closeFilmInfo() {
	document.getElementById("filmInfo").style.display="none";
}