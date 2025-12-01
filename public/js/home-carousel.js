// Team Carousel Logic - Group-Based Pagination (2 members per page)
let homeCurrentIndex = 0;
let homeAutoSlideInterval;
const homeTotalSlides = document.querySelectorAll('#teamCarousel .team-slide').length;
const MEMBERS_PER_PAGE = 2; // Show 2 members per page/dot
const homeTotalPages = Math.ceil(homeTotalSlides / MEMBERS_PER_PAGE);
const homeCarousel = document.getElementById('teamCarousel');

// Update dots to reflect pages, not individual members
function initializePaginationDots() {
    const dotsContainer = document.querySelector('.team-carousel__dots');
    if (!dotsContainer || homeTotalSlides === 0) return;
    
    // Clear existing dots (yang dibuat PHP)
    dotsContainer.innerHTML = '';
    
    // Create dots based on pages (groups of 2)
    for (let i = 0; i < homeTotalPages; i++) {
        const dot = document.createElement('span');
        dot.className = 'dot' + (i === 0 ? ' active' : '');
        dot.onclick = () => currentSlideHome(i);
        dot.setAttribute('aria-label', `Page ${i + 1}`);
        dotsContainer.appendChild(dot);
    }
}

function updateCarouselHome() {
    if (!homeCarousel || homeTotalSlides === 0) return;

    // Calculate scroll position for group of 2
    const slideWidth = document.querySelector('.team-slide').offsetWidth + 25; // width + gap
    const scrollPosition = homeCurrentIndex * MEMBERS_PER_PAGE * slideWidth;
    
    homeCarousel.style.transform = `translateX(-${scrollPosition}px)`;

    // Update dots (page indicators)
    const dots = document.querySelectorAll('.team-carousel__dots .dot');
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === homeCurrentIndex);
    });
}

function moveCarouselHome(direction) {
    if (homeTotalSlides === 0) return;

    homeCurrentIndex += direction;

    // Wrap around logic
    if (homeCurrentIndex >= homeTotalPages) {
        homeCurrentIndex = 0;
    } else if (homeCurrentIndex < 0) {
        homeCurrentIndex = homeTotalPages - 1;
    }

    updateCarouselHome();
    resetAutoSlideHome();
}

function currentSlideHome(pageIndex) {
    if (homeTotalSlides === 0) return;

    homeCurrentIndex = pageIndex;
    updateCarouselHome();
    resetAutoSlideHome();
}

function autoSlideHome() {
    if (homeTotalSlides === 0) return;

    homeCurrentIndex++;
    if (homeCurrentIndex >= homeTotalPages) {
        homeCurrentIndex = 0;
    }
    updateCarouselHome();
}

function startAutoSlideHome() {
    if (homeTotalPages > 1) {
        // Stable 5-second interval
        homeAutoSlideInterval = setInterval(autoSlideHome, 5000);
    }
}

function resetAutoSlideHome() {
    if (homeAutoSlideInterval) {
        clearInterval(homeAutoSlideInterval);
    }
    startAutoSlideHome();
}

// Initialize carousel on DOM load
document.addEventListener('DOMContentLoaded', function() {
    if (homeTotalSlides > 0) {
        initializePaginationDots(); // Create dots for pages (NOT per member!)
        updateCarouselHome();
        startAutoSlideHome();

        const wrapper = document.querySelector('.team-carousel-wrapper');
        if (wrapper) {
            wrapper.addEventListener('mouseenter', () => {
                if (homeAutoSlideInterval) {
                    clearInterval(homeAutoSlideInterval);
                }
            });
            wrapper.addEventListener('mouseleave', startAutoSlideHome);
        }
    }
});

window.addEventListener('resize', updateCarouselHome);
