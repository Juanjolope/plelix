document.addEventListener('DOMContentLoaded', () => {
    // obtenemos los elementos del DOM
    const searchInput = document.getElementById('movie-search');
    const suggestionsBox = document.getElementById('suggestions');

    // evento que se lanza cuando escribimos en el cuadro de busqueda
    searchInput.addEventListener('input', async () => {
        // Oobtenemos lo que esta escrito en el cuadro de busqueda
        const query = searchInput.value;

        // verificamos que hay mas de 2 caracteres
        if (query.length > 2) {
            //lanzamos una consulta para ver si hay peliculas que coincidan con la busqueda
            const response = await fetch(`/search?query=${query}`);
            const results = await response.json();

            // limpiamos y mostramos las sugerencias
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.remove('hidden');

            // navegamos sobre los resultados y mostrarlos como sugerencias
            results.forEach(movie => {
                const suggestionItem = document.createElement('div');
                suggestionItem.classList.add('suggestion-item');
                suggestionItem.textContent = movie.title;

                // lanzamos evento cuando hacemos click en alguna sugerencia y nos lleva a la vista de esa pelicula
                suggestionItem.addEventListener('click', () => {
                    window.location.href = `/pelicula/${movie.id}`;
                });

                // agregamos sugerencias a la caja de sugerencias
                suggestionsBox.appendChild(suggestionItem);
            });

            // si no hay resultados ocultamos la caja de sugerencias
            if (results.length === 0) {
                suggestionsBox.classList.add('hidden');
            }
        } else {
            // si la consulta es de menos de 2 caracteres no mostramos nada
            suggestionsBox.classList.add('hidden');
        }
    });

    // evento cuando hacemos click fuera de la caja de sugerencuas y se cierra
    document.addEventListener('click', (event) => {
        if (!searchInput.contains(event.target) && !suggestionsBox.contains(event.target)) {
            suggestionsBox.classList.add('hidden');
        }
    });
});

