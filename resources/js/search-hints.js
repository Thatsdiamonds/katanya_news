/**
 * Search Hints / Autocomplete Component
 * Provides real-time search suggestions with debouncing
 */

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('[data-search-hints]');

    if (!searchInput) return;

    let debounceTimer;
    let currentFocus = -1;
    let suggestions = [];

    // Create suggestions dropdown
    const dropdown = document.createElement('div');
    dropdown.className = 'absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50 hidden';
    dropdown.id = 'search-hints-dropdown';

    const searchContainer = searchInput.closest('form') || searchInput.parentElement;
    searchContainer.style.position = 'relative';
    searchContainer.appendChild(dropdown);

    // Debounced search function
    function fetchHints(query) {
        if (query.length < 3) {
            hideDropdown();
            return;
        }

        showLoading();

        fetch(`/api/search-hints?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestions = data;
                displaySuggestions(data, query);
            })
            .catch(error => {
                console.error('Search hints error:', error);
                hideDropdown();
            });
    }

    function displaySuggestions(data, query) {
        if (data.length === 0) {
            dropdown.innerHTML = `
                <div class="px-4 py-3 text-sm text-gray-500 text-center">
                    Tidak ada hasil untuk "${query}"
                </div>
            `;
            dropdown.classList.remove('hidden');
            return;
        }

        const queryLower = query.toLowerCase();
        dropdown.innerHTML = data.map((item, index) => {
            // Highlight matching text
            const title = item.title;
            const titleLower = title.toLowerCase();
            const matchIndex = titleLower.indexOf(queryLower);

            let highlightedTitle = title;
            if (matchIndex !== -1) {
                const before = title.substring(0, matchIndex);
                const match = title.substring(matchIndex, matchIndex + query.length);
                const after = title.substring(matchIndex + query.length);
                highlightedTitle = `${before}<strong class="font-semibold text-gray-900">${match}</strong>${after}`;
            }

            return `
                <a href="${item.url}"
                   class="search-hint-item flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0"
                   data-index="${index}">
                    <i class="ri-article-line text-gray-400 text-lg mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm text-gray-900 line-clamp-2">${highlightedTitle}</div>
                        <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                            ${item.category_name ? `<span class="px-2 py-0.5 bg-gray-100 rounded-full">${item.category_name}</span>` : ''}
                            ${item.views ? `<span class="flex items-center gap-1"><i class="ri-eye-line"></i>${item.views}</span>` : ''}
                        </div>
                    </div>
                </a>
            `;
        }).join('');

        dropdown.classList.remove('hidden');
        currentFocus = -1;
    }

    function showLoading() {
        dropdown.innerHTML = `
            <div class="px-4 py-3 text-sm text-gray-500 text-center flex items-center justify-center gap-2">
                <i class="ri-loader-4-line animate-spin"></i>
                Mencari...
            </div>
        `;
        dropdown.classList.remove('hidden');
    }

    function hideDropdown() {
        dropdown.classList.add('hidden');
        currentFocus = -1;
    }

    // Input event with debounce
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();

        clearTimeout(debounceTimer);

        if (query.length < 3) {
            hideDropdown();
            return;
        }

        debounceTimer = setTimeout(() => {
            fetchHints(query);
        }, 500);
    });

    // Keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        const items = dropdown.querySelectorAll('.search-hint-item');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items);
        } else if (e.key === 'Enter') {
            if (currentFocus > -1 && items[currentFocus]) {
                e.preventDefault();
                items[currentFocus].click();
            }
        } else if (e.key === 'Escape') {
            hideDropdown();
        }
    });

    function setActive(items) {
        items.forEach((item, index) => {
            if (index === currentFocus) {
                item.classList.add('bg-gray-50');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('bg-gray-50');
            }
        });
    }

    // Click outside to close
    document.addEventListener('click', function(e) {
        if (!searchContainer.contains(e.target)) {
            hideDropdown();
        }
    });

    // Focus event
    searchInput.addEventListener('focus', function() {
        const query = searchInput.value.trim();
        if (query.length >= 3 && suggestions.length > 0) {
            dropdown.classList.remove('hidden');
        }
    });
});
