document.addEventListener('DOMContentLoaded', function() {
    // Carousel functionality
    const carouselTrack = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    
    if (carouselTrack && prevBtn && nextBtn) {
        let currentPosition = 0;
        const itemWidth = 280 + 24; // 280px item width + 24px gap
        const visibleItems = Math.floor(carouselTrack.parentElement.offsetWidth / itemWidth);
        const totalItems = carouselTrack.children.length;
        const maxPosition = Math.max(0, totalItems - visibleItems);
        
        function updateCarousel() {
            carouselTrack.style.transform = `translateX(-${currentPosition * itemWidth}px)`;
            // Remove disabled states to allow looping
            prevBtn.style.opacity = '1';
            nextBtn.style.opacity = '1';
        }
        
        prevBtn.addEventListener('click', () => {
            if (currentPosition > 0) {
                currentPosition--;
            } else {
                // Loop to the end
                currentPosition = maxPosition;
            }
            updateCarousel();
        });
        
        nextBtn.addEventListener('click', () => {
            if (currentPosition < maxPosition) {
                currentPosition++;
            } else {
                // Loop to the beginning
                currentPosition = 0;
            }
            updateCarousel();
        });
        
        // Initialize carousel
        updateCarousel();
        
        // Handle window resize
        window.addEventListener('resize', () => {
            const newVisibleItems = Math.floor(carouselTrack.parentElement.offsetWidth / itemWidth);
            const newMaxPosition = Math.max(0, totalItems - newVisibleItems);
            if (currentPosition > newMaxPosition) {
                currentPosition = newMaxPosition;
            }
            updateCarousel();
        });
    }
    
    // Back to Top functionality
    const backToTopBtn = document.getElementById('backToTop');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });
        
        // Smooth scroll to top
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
