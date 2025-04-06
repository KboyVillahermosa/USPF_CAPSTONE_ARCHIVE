document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const recommendationsContainer = document.getElementById('search-recommendations');

    if (searchInput && recommendationsContainer) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            
            if (searchTerm.length < 2) {
                recommendationsContainer.classList.add('hidden');
                return;
            }

            // Add your search logic here
        });
    }
});