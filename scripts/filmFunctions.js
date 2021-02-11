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
	addButton.innerHTML = "<h3>Add to Your Collection</h3>";
		
	addButton.onclick = function addFilm() {
		document.getElementById("addFilm").style.display = "block";
		document.getElementById("addFilmContent").innerHTML =
			"<button id='close' onClick='closeAddFilm()'>Close</button><br>"
			+ "<h2>Adding <span class='addTitle'>" + film.title + " (" + release.getFullYear() + ")</span> to your collection...</h2>"
			+ "<form id='collectionAdd' autocomplete='off' action='add_film.php' method='post'>"
			+ "<input type='hidden' id='filmId' name='filmId' value='"+film.id+"'>" //pass api film id to database
			+ "<input type='hidden' id='posterPath' name='posterPath' value='"+posterUrlBase + posterSize + film.poster_path+"'>" //pass poster path to database
			+ "<input type='hidden' id='title' name='title' value='"+film.title+"'>" //pass film title to database
			+ "<input type='hidden' id='releaseDate' name='releaseDate' value='"+release.getFullYear()+"'>"
			+ "<input type='hidden' id='userId' name='userId' value='"+getCookie("user")+"'>" //pass userid to add script
			+ "<label for='format'>Format: </label>"
			+ "<select id='format' name='format'>"
   			+ "<option value='4'>DVD</option>" // 4 - id for dvd in db
			+ "<option value='5'>Blu-ray</option>" // 5 - id for bluray in db
			+ "<option value='6'>4k UHD</option>" // 6 - id for 4k in db
			+ "<option value='7'>Other</option>"
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
