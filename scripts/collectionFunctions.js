

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
	document.getElementById("addButton").style.display="none";
	document.getElementById("deleteButton").style.display="none";
}

function showButtons() {
	document.getElementById("addButton").style.display="block";
	document.getElementById("deleteButton").style.display="block";
}

function cancelOp() {
	showButtons();
	document.getElementById("deleteShelf").style.display="none";
	document.getElementById("addShelf").style.display="none";
	
}