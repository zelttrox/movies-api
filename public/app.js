const API_BASE = '';
const IMAGE_BASE = 'https://image.tmdb.org/t/p/w500';

let currentType = 'popular';
let isSearching = false;

async function fetchMovies(type) {
    try {
        const response = await fetch(`${API_BASE}/movies?type=${type}`);
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        return data.results || [];
    } catch (error) {
        showError('Impossible de charger les films: ' + error.message);
        return [];
    }
}

async function searchMovies(query) {
    try {
        const encodedQuery = encodeURIComponent(query);
        const response = await fetch(`${API_BASE}/search?query=${encodedQuery}`);
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        return data.results || [];
    } catch (error) {
        showError('Erreur lors de la recherche: ' + error.message);
        return [];
    }
}

async function getMovieDetails(id) {
    try {
        const response = await fetch(`${API_BASE}/movie/${id}`);
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        return data;
    } catch (error) {
        showError('Impossible de charger les détails du film: ' + error.message);
        return null;
    }
}

function displayMovies(movies) {
    const grid = document.getElementById('movies-grid');
    const loading = document.getElementById('loading');
    
    loading.style.display = 'none';
    
    if (!movies || movies.length === 0) {
        grid.innerHTML = '<p style="color: white; text-align: center; grid-column: 1/-1;">Aucun film trouvé</p>';
        return;
    }

    grid.innerHTML = movies.map(movie => `
        <div class="movie-card" onclick="openMovieModal(${movie.id})">
            <img 
                src="${movie.poster_path ? IMAGE_BASE + movie.poster_path : 'https://via.placeholder.com/250x375?text=No+Image'}" 
                alt="${movie.title}"
                class="movie-poster"
            >
            <div class="movie-info">
                <h3 class="movie-title">${movie.title}</h3>
                <div class="movie-meta">
                    <span class="movie-rating">⭐ ${(movie.vote_average || 0).toFixed(1)}</span>
                    <span class="movie-date">${movie.release_date ? new Date(movie.release_date).getFullYear() : 'N/A'}</span>
                </div>
            </div>
        </div>
    `).join('');
}

function showError(message) {
    const errorDiv = document.getElementById('error');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    document.getElementById('loading').style.display = 'none';
}

async function loadMovies(type) {
    document.getElementById('loading').style.display = 'block';
    document.getElementById('error').style.display = 'none';
    
    const movies = await fetchMovies(type);
    displayMovies(movies);
}

async function handleSearch() {
    const query = document.getElementById('search-input').value.trim();
    
    if (!query) {
        showError('Veuillez entrer un terme de recherche');
        return;
    }
    
    isSearching = true;
    document.getElementById('loading').style.display = 'block';
    document.getElementById('error').style.display = 'none';
    
    const movies = await searchMovies(query);
    
    if (movies.length > 0) {
        displayMovies(movies);
    } else if (!document.getElementById('error').style.display === 'block') {
        showError('Aucun film trouvé pour cette recherche');
    }
}

async function openMovieModal(id) {
    const loading = document.getElementById('loading');
    loading.style.display = 'block';
    
    const movie = await getMovieDetails(id);
    
    loading.style.display = 'none';
    
    if (!movie) return;
    
    document.getElementById('modal-title').textContent = movie.title || 'N/A';
    document.getElementById('modal-rating').textContent = (movie.vote_average || 0).toFixed(1);
    document.getElementById('modal-date').textContent = movie.release_date || 'N/A';
    document.getElementById('modal-overview').textContent = movie.overview || 'Aucun synopsis disponible';
    document.getElementById('modal-status').textContent = movie.status || 'N/A';
    
    const posterImg = document.getElementById('modal-poster');
    if (movie.poster_path) {
        posterImg.src = IMAGE_BASE + movie.poster_path;
    } else {
        posterImg.src = 'https://via.placeholder.com/250x375?text=No+Image';
    }
    
    if (movie.genres && movie.genres.length > 0) {
        const genreNames = movie.genres.map(g => g.name).join(', ');
        document.getElementById('modal-genres').innerHTML = `<strong>Genres:</strong> ${genreNames}`;
    } else {
        document.getElementById('modal-genres').textContent = '';
    }
    
    document.getElementById('movie-modal').style.display = 'block';
}

function closeMovieModal() {
    document.getElementById('movie-modal').style.display = 'none';
}

// Event listeners
document.getElementById('search-btn').addEventListener('click', handleSearch);

document.getElementById('search-input').addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        handleSearch();
    }
});

document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        isSearching = false;
        document.getElementById('search-input').value = '';
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const type = btn.dataset.type;
        currentType = type;
        loadMovies(type);
    });
});

document.querySelector('.close').addEventListener('click', closeMovieModal);

window.addEventListener('click', (event) => {
    const modal = document.getElementById('movie-modal');
    if (event.target === modal) {
        closeMovieModal();
    }
});

// Chargement initial
loadMovies(currentType);