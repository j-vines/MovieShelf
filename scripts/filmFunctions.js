/* Functions for searching and displaying results from the TMDb API */
var numResults = 0;
var apiKey = "444952e78bcc4ff9123cbb5ec23e628f"; 
var posterUrlBase = "http://image.tmdb.org/t/p/"; //base location for poster images
var posterSize = "w185"; //file size for poster displaying



/* Closes the box for more info about a specific film */
function closeFilmBox() {
	var filmBox = document.getElementById("filmBox");
	filmBox.style.display = "none";
	var filmBoxContent = document.getElementById("filmBoxContent");
	filmBoxContent.innerHTML = "<button id='close' onClick='closeFilmBox()'>Close</button>";
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
	
	var release = new Date(film.release_date);

	var button = document.createElement('div'); //button has format "Title (Year)"
	button.innerHTML = "<button type='button'onClick='showMore("+film.id+")'>"+film.title+" ("+release.getFullYear()+")</button><br><br>";
	resultWindow.appendChild(button);
}

/* Show modal box with more info on specific film */
function showMore(filmId) {
	//console.log("Showing info on film with id="+filmId);
	var filmBox = document.getElementById("filmBox");
	filmBox.style.display = "block";
	
	var query = "https://api.themoviedb.org/3/movie/"+filmId+"?api_key="+apiKey+"&language=en-US";
	
	fetch(query)
  		.then(response => response.json())
  		.then(function(data) { 
			//create info to be displayed in more info box
			var filmBoxContent = document.getElementById("filmBoxContent");
			//gen title
			var title = document.createElement('h2');
			title.innerHTML = data.title;
			filmBoxContent.appendChild(title);
			//gen release date
			var releaseYear = document.createElement('h3');
			var release = new Date(data.release_date);
			releaseYear.innerHTML = release.getFullYear();
			filmBoxContent.appendChild(releaseYear);
			//gen poster
			var poster = document.createElement('img');
			poster.className = "poster";
			poster.src = posterUrlBase + posterSize + data.poster_path;
			poster.alt = "Missing poster"
			filmBoxContent.appendChild(poster);
			//show overview button
			var showOverview = document.createElement('button');
			showOverview.className = "showOverview";
			showOverview.id = "showOverview";
			showOverview.innerHTML = "Show Synopsis";
		
			showOverview.onclick = function toggleOverview() {
				var synText = document.getElementById("overview");
				if(getComputedStyle(synText).display == "none") {
					synText.style.display = "block";
					document.getElementById("showOverview").innerHTML = "Hide Synopsis";
				} else {
					synText.style.display = "none";
					document.getElementById("showOverview").innerHTML = "Show Synopsis";
				}
				
			};
			filmBoxContent.appendChild(showOverview);
			//overview
			var overview = document.createElement('p');
			overview.className = "overview";
			overview.id = "overview";
			overview.innerHTML = data.overview;
			filmBoxContent.appendChild(overview);
			
			//add to collection button
			var addForm = document.createElement('form');
			addForm.method = "get";
			addForm.action = "add_film.php";
			addForm.innerHTML = "<input type='hidden' name='filmId' value='"+data.id+"'><input type='submit' value='Add to Your Collection'></form><br>";
			filmBoxContent.appendChild(addForm);
			
	});
	
}
