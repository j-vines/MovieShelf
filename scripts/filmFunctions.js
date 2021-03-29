/* Functions for searching and displaying results from the TMDb API */
var numResults = 0;
var apiKey = "444952e78bcc4ff9123cbb5ec23e628f"; 
var posterUrlBase = "http://image.tmdb.org/t/p/"; //base location for poster images
var posterSize = "w154"; //file size for poster displaying

/* Closes the box for more info about a specific film */
function closeAddFilm() {
	var addFilm = document.getElementById("addFilm");
	addFilm.style.display = "none";
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
			var filmArray = data.results;
			for(let index in filmArray){ //results is array of film objects
    			var film = filmArray[index];
				numResults += 1;
				display(film, document.getElementById("searchResults"));
			}
		})
		.then(function() {
			//display number of results posted
			var numDisplay = document.createElement('p');
			if (numResults == 20) {
				numDisplay.innerHTML = "Showing first 20 results";
			} else {
				if (numResults != 1) {
					numDisplay.innerHTML = numResults + " films found";
				} else {
					numDisplay.innerHTML = "1 film found";
				}
				
			}
			document.getElementById("searchResults").appendChild(numDisplay);
		});
}

/* Create link to a film's description page and add it to results page*/
function display(film, resultWindow) {
	var breakLine = document.createElement("br");
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
	
	filmBox.appendChild(titleCard);
	
	//overview
	var overview = document.createElement('p');
	overview.className = "overview";
	overview.id = "overview" + film.id; //each overview has unique id for purposes of hiding/displaying
	overview.innerHTML = film.overview;
	
	var overviewButton = document.createElement('button');
	overviewButton.className = "overviewButton";
	overviewButton.id = "overviewButton" + film.id;
	overviewButton.innerHTML = "Read Synopsis";
		
	overviewButton.onclick = function showOverview() {
		var synopsis = document.getElementById("overview" + film.id);
		var synButton = document.getElementById("overviewButton" + film.id);
		if(window.getComputedStyle(synopsis).display == "none") {
			synopsis.style.display = "block";
			synButton.innerHTML = "Hide Synopsis";
		} else {
			synopsis.style.display = "none";
			synButton.innerHTML = "Read Synopsis";
		}
		
	}
	filmBox.appendChild(breakLine);
	filmBox.appendChild(overviewButton);
	filmBox.appendChild(overview);
	
	//add film button
	var addButton = document.createElement('button');
	addButton.className = "addButton";
	addButton.id = "addButton";
	addButton.innerHTML = "<h3>ADD TO YOUR COLLECTION</h3>";
		
	addButton.onclick = function addFilm() {
		document.getElementById("addFilm").style.display = "block";
		//Set values of form
		document.getElementById("addFilmContentTitle").innerHTML = "Adding <span class='addTitle'>" + film.title + " (" + release.getFullYear() + ")</span> to your collection...";

		document.getElementById("filmId").value = film.id //pass api film id to database
		document.getElementById("posterPath").value = posterUrlBase + posterSize + film.poster_path; //pass poster path to database
		document.getElementById("title").value = film.title; //pass film title to database
		document.getElementById("releaseDate").value = release.getFullYear();
		document.getElementById("userId").value = getCookie("user"); //pass userid to add script
				
	};
		
	if(checkCookie("user")) { //only show add film button if user is signed in
		filmBox.appendChild(addButton);
	} else { //show message asking user to sign in
		var message = document.createElement("div");
		message.className = "signinMessage";
		message.innerHTML = "<h3>Sign-in to add this film to your collection</h3>";
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
	resultWindow.appendChild(breakLine);
}

/* Show modal box with more info on specific film */
function showMore(filmId) {
	var filmBox = document.getElementById("addFilm");
	filmBox.style.display = "block";

	
}
