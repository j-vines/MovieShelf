/* Functions for searching and displaying results from the TMDb API */
var numResults = 0;
var apiKey = "444952e78bcc4ff9123cbb5ec23e628f"; 
var posterUrlBase = "http://image.tmdb.org/t/p/"; //base location for poster images
var posterSize = "w154"; //file size for poster displaying

/* Closes the box for more info about a specific film */
function closeAddFilm() {
	var addFilm = document.getElementById("addFilm");
	addFilm.style.display = "none";
	var addFilmContent = document.getElementById("addFilmContent");
	addFilmContent.innerHTML = "<button id='close' onClick='closeAddFilm()'>Close</button>";
}

/* Build and make an API request based on search form data */
function filmSearch() {
	document.getElementById("searchResults").innerHTML = "";
	numResults = 0;
	var searchTerm = document.getElementById("search").value;
	var query = "https://api.themoviedb.org/3/search/movie?api_key=" + apiKey + "&language=en-US&query=" + searchTerm + "&page=1&include_adult=false";
	fetch(query)
  		.then(response => response.json())
  		.then(function(data) { //parse and display results from search
			//console.log(data.results);
			var filmArray = data.results;
			for(let index in filmArray){ //results is array of film objects
    			var film = filmArray[index];
				numResults += 1;
				display(film, document.getElementById("searchResults"));
			}
		})
		.then(function() {
			//display number of results posted
			console.log(numResults);
			var numDisplay = document.createElement('p');
			numDisplay.innerHTML = numResults + " films found";
			document.getElementById("searchResults").appendChild(numDisplay);
		});
}

/* Create link to a film's description page and add it to results page*/
function display(film, resultWindow) {
	console.log(film);
	var filmBox = document.createElement("div"); //contains all movie info
	filmBox.className = "filmBox";
	
	//gen poster
	var poster = document.createElement('img');
	poster.className = "poster";
	poster.src = posterUrlBase + posterSize + film.poster_path;
	poster.alt = "Missing poster"
	filmBox.appendChild(poster);
	
	//var release = new Date(film.release_date);
	var titleCard = document.createElement('div');
	titleCard.className = "titleCard";
	var title = document.createElement('h1');
	title.innerHTML = film.title;
	titleCard.appendChild(title);
	//gen release date
	var releaseYear = document.createElement('h2');
	var release = new Date(film.release_date);
	releaseYear.innerHTML = release.getFullYear();
	titleCard.appendChild(releaseYear);
	
	//overview
	/*var overview = document.createElement('p');
	overview.className = "overview";
	overview.id = "overview";
	overview.innerHTML = film.overview;
	titleCard.appendChild(overview);*/
	
	filmBox.appendChild(titleCard);
	
	//add film button
	
	var addButton = document.createElement('button');
	addButton.className = "addButton";
	addButton.id = "addButton";
	addButton.innerHTML = "Add to Your Collection";
		
	addButton.onclick = function addFilm() {
		document.getElementById("addFilm").style.display = "block";
		document.getElementById("addFilmContent").innerHTML =
			"<button id='close' onClick='closeAddFilm()'>Close</button><br>"
			+ "<h2>Adding <span class='addTitle'>" + film.title + " (" + release.getFullYear() + ")</span> to your collection...</h2>"
			+ "<form id='collectionAdd' autocomplete='off' action='add_film.php' method='post'>"
			+ "<label for='format'>Format: </label>"
			+ "<select id='format' name='format'>"
   			+ "<option value='dvd'>DVD</option>"
			+ "<option value='bluray'>Blu-ray</option>"
			+ "<option value='4k'>4k UHD</option>"
			+ "<option value='other'>Other</option>"
  			+ "</select>"
			+ "<br><br>"
			+ "<label for='shelf'>Shelf: </label>"
			+ "<select id='shelf' name='shelf'>"
   			+ "<option value='none'>No shelves</option>"
  			+ "</select>"
			+ "<br><br>"
			+ "<input type='submit' class='addFilmSubmit' value='Add'>"
			
			+ "</form><br><br>"
				
	};
		
	if(checkCookie("user")) { //only show add film button if user is signed in
		filmBox.appendChild(addButton);
	} else { //show message asking user to sign in
		var message = document.createElement("div");
		message.className = "signinMessage";
		message.innerHTML = "Sign-in to add this film to your collection";
		filmBox.appendChild(message);
	}
	
	
	
				
	//show genres
	/*var genreListText = "";
	for(let index in film.genres) {
		genreListText = genreListText + film.genres[index].name + ", ";
	}
	genreListText = genreListText.slice(0, -2);
	var genreList = document.createElement('p');
	genreList.innerHTML = genreListText;
	console.log(genreListText);
	filmBox.appendChild(genreList); //add poster div (contains poster and genre list)*/
	

	resultWindow.appendChild(filmBox);
	var breakLine = document.createElement("br");
	resultWindow.appendChild(breakLine);
}

/* Show modal box with more info on specific film */
//FUNCTION THAT OPENS MODAL SHOULD NOW OPEN FORM CONTAINING INFO TO ADD TO FILM TABLE
function showMore(filmId) {
	var filmBox = document.getElementById("addFilm");
	filmBox.style.display = "block";

	
}
