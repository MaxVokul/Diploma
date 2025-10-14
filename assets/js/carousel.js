document.addEventListener('DOMContentLoaded', function() {
    const carouselTrack = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    
    if (!carouselTrack || !prevBtn || !nextBtn) {
        return; // Exit if elements don't exist
    }
    
    const items = carouselTrack.querySelectorAll('.carousel-item');
    const totalItems = items.length;
    
    if (totalItems === 0) {
        return; // Exit if no items
    }
    
    let currentIndex = 0;
    const itemsPerView = getItemsPerView();
    
    function getItemsPerView() {
        const width = window.innerWidth;
        if (width <= 570) return 1;
        if (width <= 768) return 2;
        if (width <= 1024) return 3;
        return 4;
    }
    
    function updateCarousel() {
        const itemWidth = 300; // 280px + 20px margin
        const translateX = -currentIndex * itemWidth;
        carouselTrack.style.transform = `translateX(${translateX}px)`;
        
        // Update button states
        prevBtn.disabled = false;
        nextBtn.disabled = false;
    }
    
    function nextSlide() {
        currentIndex++;
        if (currentIndex >= totalItems) {
            currentIndex = 0;// Возврат к началу
        }
        updateCarousel();
    }
    
    function prevSlide() {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = totalItems - 1;// Переход к концу
        }
        updateCarousel();
    }
    
    // Event listeners
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const newItemsPerView = getItemsPerView();
        if (currentIndex > totalItems - newItemsPerView) {
            currentIndex = Math.max(0, totalItems - newItemsPerView);
        }
        updateCarousel();
    });
    
    // Touch/swipe support for mobile
    let startX = 0;
    let startY = 0;
    let isDragging = false;
    
    carouselTrack.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        isDragging = true;
    });
    
    carouselTrack.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        
        const currentX = e.touches[0].clientX;
        const currentY = e.touches[0].clientY;
        const diffX = startX - currentX;
        const diffY = startY - currentY;
        
        // Only handle horizontal swipes
        if (Math.abs(diffX) > Math.abs(diffY)) {
            e.preventDefault();
        }
    });
    
    carouselTrack.addEventListener('touchend', function(e) {
        if (!isDragging) return;
        
        const endX = e.changedTouches[0].clientX;
        const diffX = startX - endX;
        
        if (Math.abs(diffX) > 50) { // Minimum swipe distance
            if (diffX > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
        
        isDragging = false;
    });
    
    // Initialize carousel
    updateCarousel();
});
