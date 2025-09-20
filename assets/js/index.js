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
        // Calculate max position considering the 1500px limit
        const maxTransform = Math.max(0, totalItems * itemWidth - carouselTrack.parentElement.offsetWidth);
        const limitedMaxTransform = Math.min(maxTransform, 1500);
        const maxPosition = Math.floor(limitedMaxTransform / itemWidth);
        
        function updateCarousel() {
            // Calculate the exact transform needed to show all items without empty spaces
            const trackWidth = totalItems * itemWidth;
            const containerWidth = carouselTrack.parentElement.offsetWidth;
            const maxTransform = Math.max(0, trackWidth - containerWidth);
            // Limit the maximum transform to 1500px as requested
            const limitedMaxTransform = Math.min(maxTransform, 1500);
            const transform = Math.min(currentPosition * itemWidth, limitedMaxTransform);
            
            carouselTrack.style.transform = `translateX(-${transform}px)`;
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
            const newMaxTransform = Math.max(0, totalItems * itemWidth - carouselTrack.parentElement.offsetWidth);
            const newLimitedMaxTransform = Math.min(newMaxTransform, 1500);
            const newMaxPosition = Math.floor(newLimitedMaxTransform / itemWidth);
            if (currentPosition > newMaxPosition) {
                currentPosition = newMaxPosition;
            }
            updateCarousel();
        });
    }
    
    // Load More functionality for For You section
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const forYouSection = document.getElementById('foryouSection');
    
    console.log('Load More Button:', loadMoreBtn);
    console.log('For You Section:', forYouSection);
    
    if (loadMoreBtn && forYouSection) {
        const allNews = window.forYouNewsData || [];
        console.log('Total articles available:', allNews.length);
        
        let currentRows = 4; // Start with 4 rows
        const loadMoreRows = 6; // Load 6 more rows each time
        const articlesPerRow = 3;
        
        // Update the counter text
        function updateCounter() {
            const counterText = loadMoreBtn.parentElement.querySelector('p');
            if (counterText) {
                const shownArticles = Math.min(currentRows * articlesPerRow, allNews.length);
                counterText.textContent = `Showing ${shownArticles} of ${allNews.length} articles`;
            }
        }
        
        loadMoreBtn.addEventListener('click', function() {
            console.log('Load More clicked! Current rows:', currentRows);
            
            const nextRows = Math.min(currentRows + loadMoreRows, Math.ceil(allNews.length / articlesPerRow));
            console.log('Loading rows from', currentRows, 'to', nextRows);
            
            // Create new rows for additional articles
            for (let i = currentRows; i < nextRows; i++) {
                const row = document.createElement('div');
                row.className = 'row';
                
                for (let j = 0; j < articlesPerRow && (i * articlesPerRow + j) < allNews.length; j++) {
                    const newsItem = allNews[i * articlesPerRow + j];
                    const rect = document.createElement('div');
                    rect.className = 'rect';
                    
                    // Format date
                    const publishTime = new Date(newsItem.published_at).getTime();
                    const now = Date.now();
                    const diff = now - publishTime;
                    let dateStr;
                    
                    if (diff < 86400000) { // Less than 24 hours
                        const hours = Math.floor(diff / 3600000);
                        if (hours < 1) {
                            const minutes = Math.floor(diff / 60000);
                            dateStr = minutes + ' minutes ago';
                        } else {
                            dateStr = hours + ' hours ago';
                        }
                    } else {
                        dateStr = new Date(publishTime).toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        });
                    }
                    
                    rect.innerHTML = `
                        <a href="/news.php?id=${newsItem.id}" class="rectlink">
                            <img src="${newsItem.image_url || 'resources/Rectangle 20.png'}" class="rectimg" alt="${newsItem.title}">
                            <div class="recttxt">
                                <h2>${newsItem.title}</h2>
                                <p>${newsItem.excerpt.substring(0, 150)}${newsItem.excerpt.length > 150 ? '...' : ''}</p>
                            </div>
                            <p class="rectp">
                                ${dateStr} / by ${newsItem.author_name} / ${newsItem.category_name || 'Uncategorized'}
                            </p>
                        </a>
                    `;
                    
                    row.appendChild(rect);
                }
                
                forYouSection.appendChild(row);
            }
            
            currentRows = nextRows;
            updateCounter();
            
            // Hide button if all articles are loaded
            if (currentRows * articlesPerRow >= allNews.length) {
                loadMoreBtn.style.display = 'none';
                console.log('All articles loaded, hiding button');
            }
        });
        
        // Initialize counter
        updateCounter();
    } else {
        console.log('Load More button or For You section not found!');
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
