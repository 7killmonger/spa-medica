/**
 * Spa Medica Theme JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Header scroll effect
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 30) {
                header.classList.add('bg-[#7DAB4E]/70', 'shadow-md');
                header.classList.remove('bg-transparent');
            } else {
                if (window.innerWidth < 1024) { // Mobile and tablet views
                    header.classList.add('bg-transparent');
                    header.classList.remove('bg-[#7DAB4E]/70', 'shadow-md');
                }
            }
        });
    }
    
    // Initialize the icons swiper
    const iconsSwiper = new Swiper('.icons-swiper', {
        // Optional parameters
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        
        // Responsive breakpoints
        breakpoints: {
            // When window width is >= 640px
            640: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            // When window width is >= 768px
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            // When window width is >= 1024px
            1024: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
        
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
}); 