@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    /* Mencegah scroll saat menu terbuka */
    .no-scroll {
        overflow: hidden;
        height: 100vh;
    }

    /* Animasi Hover Link Mobile */
    .mobile-link {
        position: relative;
        transition: all 0.3s ease;
    }

    .mobile-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        width: 0;
        height: 3px;
        background-color: #276AD7;
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .mobile-link:hover {
        color: #276AD7;
        transform: scale(1.1);
    }

    .mobile-link:hover::after {
        width: 100%;
    }
</style>

<nav id="navbar" class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 md:px-12 bg-transparent text-white border-b border-white/30 transition-all duration-500 py-4">
    
    <div class="flex items-center gap-4 transition-all duration-500 z-50" id="logo-container">
        <img src="/image/logo/tutwuri-logo.svg" alt="Logo" id="nav-logo" class="h-16 md:h-20 w-auto transition-all duration-500">
        <div class="flex flex-col tracking-tight">
            <h1 id="nav-title" class="text-[18px] md:text-[25px] font-semibold leading-none transition-all duration-500">
                BBPPMPV BOE Malang
            </h1>
            <p id="nav-subtitle" class="block text-[10px] md:text-[14px] text-white/80 font-normal tracking-wider leading-tight mt-1 transition-all duration-500">
                Balai Besar Pengembangan Penjaminan Mutu Pendidikan Vokasi<br>
                Bidang Otomotif dan Elektronika
            </p>
        </div>
    </div>

    <ul id="nav-links" class="hidden md:flex text-[18px] items-center gap-8 font-semibold transition-all duration-500 mr-10">
        <li><a href="/" class="hover:text-[#276AD7] transition">Home</a></li>
        <li><a href="#about" class="hover:text-[#276AD7] transition">About</a></li>
        <li><a href="#booking" class="hover:text-[#276AD7] transition">Booking</a></li>
        <li><a href="#contact" class="hover:text-[#276AD7] transition">Contact</a></li>
    </ul>

    <button id="menu-btn" class="md:hidden flex flex-col gap-1.5 z-[60] p-2 transition-colors duration-300">
        <span class="w-7 h-1 bg-current transition-all duration-300"></span>
        <span class="w-7 h-1 bg-current transition-all duration-300"></span>
        <span class="w-7 h-1 bg-current transition-all duration-300"></span>
    </button>

    <div id="mobile-menu" class="fixed inset-0 bg-white text-black translate-x-full transition-transform duration-500 flex flex-col items-center justify-center gap-10 text-3xl font-black z-[55]">
        <a href="/" class="mobile-link">Home</a>
        <a href="#about" class="mobile-link">About</a>
        <a href="#booking" class="mobile-link">Booking</a>
        <a href="#contact" class="mobile-link">Contact</a>
    </div>
</nav>

<script>
    const navbar = document.getElementById('navbar');
    const navLogo = document.getElementById('nav-logo');
    const navTitle = document.getElementById('nav-title');
    const subtitle = document.getElementById('nav-subtitle');
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const spans = menuBtn.querySelectorAll('span');
    const mobileLinks = document.querySelectorAll('.mobile-link');
    const body = document.body;

    window.addEventListener('scroll', function() {
        const isScrolled = window.scrollY > 50;
        const isMenuOpen = !mobileMenu.classList.contains('translate-x-full');

        if (isScrolled) {
            // Scrolled Down
            navbar.classList.replace('py-4', 'py-2');
            navbar.classList.add('bg-white', 'shadow-md', 'text-black', 'border-gray-200');
            navbar.classList.remove('bg-transparent', 'text-white', 'border-white/30');
            
            // Resize Logo
            navLogo.classList.add('h-12', 'md:h-16'); 
            navLogo.classList.remove('h-16', 'md:h-20');
            
            // Resize Title
            navTitle.classList.add('md:text-[20px]');
            navTitle.classList.remove('md:text-[25px]');

            // Text Colors
            if(subtitle) subtitle.classList.replace('text-white/80', 'text-black/60');
            
        } else {
            navbar.classList.replace('py-2', 'py-4');
            navbar.classList.remove('bg-white', 'shadow-md', 'text-black', 'border-gray-200');
            navbar.classList.add('bg-transparent', 'text-white', 'border-white/30');
            
            // Restore Logo
            navLogo.classList.remove('h-12', 'md:h-16');
            navLogo.classList.add('h-16', 'md:h-20');

            // Restore Title
            navTitle.classList.remove('md:text-[20px]');
            navTitle.classList.add('md:text-[25px]');

            // Restore Subtitle
            if(subtitle) subtitle.classList.replace('text-black/60', 'text-white/80');
        }

        // Hamburger color logic 
        if (isMenuOpen || isScrolled) {
            menuBtn.classList.add('text-black');
            menuBtn.classList.remove('text-white');
        } else {
            menuBtn.classList.add('text-white');
            menuBtn.classList.remove('text-black');
        }
    });

    // Toggle Menu
    menuBtn.addEventListener('click', () => {
        const isMenuOpen = mobileMenu.classList.contains('translate-x-0');
        if (!isMenuOpen) {
            openMenu();
        } else {
            closeMenu();
        }
    });

    function openMenu() {
        mobileMenu.classList.replace('translate-x-full', 'translate-x-0');
        
        // Animasi Hamburger ke X
        spans[0].classList.add('rotate-45', 'translate-y-[10px]');
        spans[1].classList.add('opacity-0');
        spans[2].classList.add('-rotate-45', '-translate-y-[10px]');
        
        // Kunci Scroll
        body.classList.add('no-scroll');
        
        // Warna text saat menu putih terbuka
        menuBtn.classList.add('text-black');
        menuBtn.classList.remove('text-white');
        navTitle.classList.add('text-black');
        if(subtitle) subtitle.classList.add('text-black/60');
    }

    function closeMenu() {
        mobileMenu.classList.replace('translate-x-0', 'translate-x-full');
        
        // Animasi X kembali ke Hamburger
        spans[0].classList.remove('rotate-45', 'translate-y-[10px]');
        spans[1].classList.remove('opacity-0');
        spans[2].classList.remove('-rotate-45', '-translate-y-[10px]');
        
        // Lepas Kunci Scroll
        body.classList.remove('no-scroll');
        
        if (window.scrollY <= 50) {
            menuBtn.classList.replace('text-black', 'text-white');
            navTitle.classList.remove('text-black');
            if(subtitle) subtitle.classList.remove('text-black/60');
        }
    }

    mobileLinks.forEach(link => { 
        link.addEventListener('click', closeMenu); 
    });
</script>