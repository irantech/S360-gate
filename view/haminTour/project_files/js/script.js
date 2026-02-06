document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const menuToggle = document.querySelector('.menu-toggle');
    const closeMenu = document.querySelector('.close-menu');
    const mobileMenu = document.querySelector('.mobile-menu');
    const overlay = document.querySelector('.overlay');
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-nav a');

    // Open mobile menu with animation
    menuToggle.addEventListener('click', function() {
        mobileMenu.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    });

    // Close mobile menu function
    function closeMenuFunction() {
        mobileMenu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = ''; // Enable scrolling
    }

    // Event listeners for closing menu
    closeMenu.addEventListener('click', closeMenuFunction);
    overlay.addEventListener('click', closeMenuFunction);

    // Close menu when clicking on a link
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', closeMenuFunction);
    });

    // Check if device is desktop size
    function checkIfDesktop() {
        if (window.innerWidth >= 1024) {
            closeMenuFunction();
        }
    }

    // Check on resize
    window.addEventListener('resize', checkIfDesktop);

    // Handle escape key to close menu
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMenuFunction();
        }
    });
});

$('.owl-footer').owlCarousel({
    rtl:true,
    loop:true,
    margin:0,
    autoplay: true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    nav:false,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
        1000:{
            items:4
        }
    }
})