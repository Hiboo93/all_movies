const API_URL = 'https://api.themoviedb.org/3/discover/movie?sort_by=popularity.desc&api_key=13a15dda4f713eaa44cebe861f03a4c2&page=1';
const IMG_PATH = 'https://image.tmdb.org/t/p/w1280'
const SEARCH_API = 'https://api.themoviedb.org/3/search/movie?api_key=13a15dda4f713eaa44cebe861f03a4c2&query=';


const main = document.getElementById('main');
const form = document.getElementById('form');
const search = document.getElementById('search');
const mainTwo = document.getElementById('mainTwo');

getMovies(API_URL)

async function getMovies(url)
{
    const res = await fetch(url);
    const data = await res.json();

    showMovies(data.results)
}

function showMovies(movies)
{
    main.innerHTML = '';

    movies.forEach((movie) => {
        const { title, poster_path, vote_average, overview} = movie;

        const movieEl = document.createElement('div');
        movieEl.classList.add('movie')

        movieEl.innerHTML = `
       
            <img src="${IMG_PATH + poster_path}" alt="${title}">
            <div class="movie-info">
                <h3>${title}</h3>
                <span class="${getClassByRate(vote_average)}">${vote_average}</span>
            </div>
            <div class="overview">
                <h3>overview</h3>
                <a href="<?= URL ?>info_movies">More info :</a>
                ${overview}
            </div>
        `
        main.appendChild(movieEl)
    });
}



function getClassByRate(vote)
{
    if (vote >= 8) {
        return 'green'
    } else if (vote >= 5) {
        return 'orange'
    } else {
        return 'red'
    }
}

form.addEventListener('keyup', (e) => {
    e.preventDefault();
    const searchTerm = search.value;

    if (searchTerm && searchTerm !== '') {
        getMovies(SEARCH_API + searchTerm);

        //search.value = "";
    } else {
        window.location.reload();
    }
})

// Partie movie_info.view
const GETMOVIE_ID = 'https://api.themoviedb.org/3/movie/{movie_id}?api_key=13a15dda4f713eaa44cebe861f03a4c2&language=en-US';
const GETVIDEOS = 'https://api.themoviedb.org/3/movie/677179/videos?api_key=13a15dda4f713eaa44cebe861f03a4c2&language=en-US';

getMovieSolo(GETVIDEOS);

async function getMovieSolo(urlvideo)
{
    const res = await fetch(urlvideo);
    const data = await res.json();

    showMovieSolo(data.results)
}


function showMovieSolo(movie)
{
    mainTwo.innerHTML = '';

    movie.forEach((video) => {
        const { title, poster_path, vote_average, overview} = video;

        const filmEl = document.createElement('div');
        filmEl.classList.add('movie')

        filmEl.innerHTML = `
       
            <img src="${IMG_PATH + poster_path}" alt="${title}">
            <div class="movie-info">
                <h3>${title}</h3>
                <span class="${getClassByRate(vote_average)}">${vote_average}</span>
            </div>
            <div class="overview">
                <h3>overview</h3>
                <a href="<?= URL ?>compte/profil">Retour:</a>
                ${overview}
            </div>
        `
        mainTwo.appendChild(filmEl)
    });
}

