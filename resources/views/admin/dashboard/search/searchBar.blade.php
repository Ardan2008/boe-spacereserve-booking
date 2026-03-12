@vite(['resources/css/app.css', 'resources/js/app.js'])
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            overflow-x: hidden; 
        }
    </style>

<div class="relative w-full md:w-96 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-[#1265A8] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
        <input type="text" 
            id="globalSearch"
            placeholder="Cari data, menu, atau aksi..." 
            class="block w-full pl-12 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-sm placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-[#1265A8] transition-all shadow-sm"
        >
    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
        <kbd class="hidden md:inline-block px-2 py-1 text-[10px] font-semibold text-slate-400 bg-slate-50 border border-slate-200 rounded-lg shadow-sm group-focus-within:hidden">/</kbd>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('globalSearch') || document.getElementById('dashboardSearch');
            
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    
                    // Filter Cards
                    const cards = document.querySelectorAll('.glass-card, .action-card, .searchable-section');
                    cards.forEach(card => {
                        const text = card.innerText.toLowerCase();
                        toggleElement(card, text.includes(term));
                    });

                    // Filter Sidebar Menu
                    const menuItems = document.querySelectorAll('nav a');
                    menuItems.forEach(item => {
                        const text = item.innerText.toLowerCase();
                        item.style.display = text.includes(term) ? "flex" : "none";
                    });
                });

                // handle enter key untuk navigasi cepat
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault(); // Mencegah form submit jika ada
                        
                        const firstVisibleLink = Array.from(document.querySelectorAll('nav a'))
                            .find(item => item.style.display !== 'none');

                        if (firstVisibleLink) {
                            window.location.href = firstVisibleLink.href;
                        }
                    }
                });

                // Shortcut '/' untuk fokus pencarian
                document.addEventListener('keydown', (e) => {
                    if (e.key === '/' && document.activeElement !== searchInput) {
                        e.preventDefault();
                        searchInput.focus();
                    }
                });
            }

            // Initialize Charts & Counters
            if (typeof initCharts === 'function') initCharts();
            if (typeof animateCounters === 'function') animateCounters();
        });

        // Helper untuk Transisi Pencarian
        function toggleElement(el, isVisible) {
            if (isVisible) {
                el.style.display = "";
                setTimeout(() => {
                    el.style.opacity = "1";
                    el.style.transform = "scale(1)";
                }, 10);
            } else {
                el.style.opacity = "0";
                el.style.transform = "scale(0.95)";
                setTimeout(() => {
                    if(el.style.opacity === "0") el.style.display = "none";
                }, 300);
            }
        }
</script>