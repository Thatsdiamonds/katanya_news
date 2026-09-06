/**
 * Search Hints / Autocomplete Component
 * Provides real-time search suggestions with debouncing
 * Features: backdrop blur, random placeholder articles, image preview
 */

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('[data-search-hints]');

    if (!searchInput) return;

    let debounceTimer;
    let currentFocus = -1;
    let suggestions = [];
    let placeholderArticles = [];

    // Create backdrop overlay
    const backdrop = document.createElement('div');
    backdrop.className = 'fixed inset-0 bg-black/20 backdrop-blur-sm z-40 hidden transition-opacity duration-200';
    backdrop.id = 'search-backdrop';
    document.body.appendChild(backdrop);

    // Create suggestions dropdown
    const dropdown = document.createElement('div');
    dropdown.className = 'absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden z-50 hidden max-h-[70vh] overflow-y-auto';
    dropdown.id = 'search-hints-dropdown';

    const searchContainer = searchInput.closest('form') || searchInput.parentElement;
    searchContainer.style.position = 'relative';
    searchContainer.appendChild(dropdown);

    // Fetch random placeholder articles
    async function fetchPlaceholders() {
        try {
            const response = await fetch('/api/search-hints?query=random');
            if (response.ok) {
                const data = await response.json();
                placeholderArticles = data.slice(0, 5);
            }
        } catch (error) {
            console.error('Failed to fetch placeholders:', error);
        }
    }

    // Show placeholder articles
    function showPlaceholders() {
        if (placeholderArticles.length === 0) {
            dropdown.innerHTML = `
                <div class="px-4 py-8 text-center">
                    <i class="ri-search-line text-4xl text-gray-300 mb-2"></i>
                    <p class="text-sm text-gray-500">Mulai ketik untuk mencari artikel...</p>
                </div>
            `;
        } else {
            dropdown.innerHTML = `
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Berita Terbaru</p>
                </div>
                ${placeholderArticles.map((item, index) => `
                    <a href="${item.url}"
                       class="search-hint-item flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0"
                       data-index="${index}">
                        ${item.image ? `
                            <img src="${item.image}"
                                 alt="${item.title}"
                                 class="w-16 h-16 rounded-lg object-cover flex-shrink-0 bg-gray-100"
                                 loading="lazy">
                        ` : `
                            <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <i class="ri-article-line text-gray-300 text-2xl"></i>
                            </div>
                        `}
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">${item.title}</div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                ${item.category_name ? `<span class="px-2 py-0.5 bg-gray-100 rounded-full">${item.category_name}</span>` : ''}
                                ${item.views ? `<span class="flex items-center gap-1"><i class="ri-eye-line"></i>${item.views}</span>` : ''}
                            </div>
                        </div>
                    </a>
                `).join('')}
            `;
        }
        dropdown.classList.remove('hidden');
        backdrop.classList.remove('hidden');
    }

    // Debounced search function
    function fetchHints(query) {
        if (query.length < 3) {
            showPlaceholders();
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
                <div class="px-4 py-8 text-center">
                    <i class="ri-search-off-line text-4xl text-gray-300 mb-2"></i>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Tidak ada hasil</p>
                    <p class="text-xs text-gray-500">Coba kata kunci lain atau kurangi jumlah kata</p>
                </div>
            `;
            dropdown.classList.remove('hidden');
            backdrop.classList.remove('hidden');
            return;
        }

        const queryLower = query.toLowerCase();
        dropdown.innerHTML = `
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    ${data.length} Hasil Ditemukan
                </p>
            </div>
            ${data.map((item, index) => {
                // Highlight matching text
                const title = item.title;
                const titleLower = title.toLowerCase();
                const matchIndex = titleLower.indexOf(queryLower);

                let highlightedTitle = title;
                if (matchIndex !== -1) {
                    const before = title.substring(0, matchIndex);
                    const match = title.substring(matchIndex, matchIndex + query.length);
                    const after = title.substring(matchIndex + query.length);
                    highlightedTitle = `${before}<strong class="font-semibold text-gray-900 bg-yellow-100">${match}</strong>${after}`;
                }

                return `
                    <a href="${item.url}"
                       class="search-hint-item flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0"
                       data-index="${index}">
                        ${item.image ? `
                            <img src="${item.image}"
                                 alt="${item.title}"
                                 class="w-20 h-20 rounded-lg object-cover flex-shrink-0 bg-gray-100"
                                 loading="lazy">
                        ` : `
                            <div class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <i class="ri-article-line text-gray-300 text-3xl"></i>
                            </div>
                        `}
                        <div class="flex-1 min-w-0">
                            <div class="text-sm text-gray-900 line-clamp-2 mb-1">${highlightedTitle}</div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                ${item.category_name ? `<span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full font-medium">${item.category_name}</span>` : ''}
                                ${item.views ? `<span class="flex items-center gap-1"><i class="ri-eye-line"></i>${item.views}</span>` : ''}
                            </div>
                        </div>
                    </a>
                `;
            }).join('')}
        `;

        dropdown.classList.remove('hidden');
        backdrop.classList.remove('hidden');
        currentFocus = -1;
    }

    function showLoading() {
        dropdown.innerHTML = `
            <div class="px-4 py-8 text-center flex flex-col items-center justify-center gap-2">
                <i class="ri-loader-4-line animate-spin text-3xl text-blue-500"></i>
                <p class="text-sm text-gray-500">Mencari artikel...</p>
            </div>
        `;
        dropdown.classList.remove('hidden');
        backdrop.classList.remove('hidden');
    }

    function hideDropdown() {
        dropdown.classList.add('hidden');
        backdrop.classList.add('hidden');
        currentFocus = -1;
    }

    // Input event with debounce
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();

        clearTimeout(debounceTimer);

        if (query.length === 0) {
            showPlaceholders();
            return;
        }

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
            searchInput.blur();
        }
    });

    function setActive(items) {
        items.forEach((item, index) => {
            if (index === currentFocus) {
                item.classList.add('bg-gray-50');
                item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            } else {
                item.classList.remove('bg-gray-50');
            }
        });
    }

    // Click outside to close
    backdrop.addEventListener('click', function() {
        hideDropdown();
    });

    // Focus event - show placeholders
    searchInput.addEventListener('focus', function() {
        const query = searchInput.value.trim();
        if (query.length === 0) {
            if (placeholderArticles.length === 0) {
                fetchPlaceholders().then(() => showPlaceholders());
            } else {
                showPlaceholders();
            }
        } else if (query.length >= 3 && suggestions.length > 0) {
            dropdown.classList.remove('hidden');
            backdrop.classList.remove('hidden');
        }
    });

    // Blur event
    searchInput.addEventListener('blur', function() {
        // Delay to allow click on suggestions
        setTimeout(() => {
            if (!dropdown.matches(':hover')) {
                hideDropdown();
            }
        }, 200);
    });

    // Initial placeholder fetch
    fetchPlaceholders();
});
