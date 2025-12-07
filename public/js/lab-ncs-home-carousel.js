/**
 * LAB NCS - HOME PAGE CAROUSEL SCRIPT
 * Extracted from: app/views/public/home.php (lines 439-545)
 * Purpose: Team carousel navigation and auto-slide functionality
 * Last Updated: 2025-12-04
 * Fixed: Pagination bug - calculate actual pages needed based on visible cards
 */

(function() {
    'use strict';

    // Initialize carousel variables
    let homeCurrentIndex = 0;
    let homeAutoSlideInterval;
    let resizeTimeout;
    const homeTotalMembers = window.homeTotalSlides || 0; // Total number of team members
    const homeCarousel = document.getElementById('teamCarousel');
    const homeDots = document.querySelectorAll('.team-carousel__dots .dot');
    
    /**
     * Get number of cards visible per slide based on viewport width
     * Matches the CSS breakpoints in lab-ncs-home.css
     */
    function getCardsPerSlide() {
        const width = window.innerWidth;
        if (width >= 1200) return 3.5;  // Desktop: 3.5 cards (fixed to match CSS)
        if (width >= 992) return 3;   // Tablet large: 3 cards (33.333%)
        if (width >= 768) return 2;   // Tablet: 2 cards (50%)
        return 1;                      // Mobile: 1 card (100%)
    }
    
    /**
     * Calculate total pages/slides needed
     * This is the KEY FIX - calculate pages based on cards per slide
     */
    function getTotalPages() {
        if (homeTotalMembers === 0) return 0;
        const cardsPerSlide = getCardsPerSlide();
        return Math.ceil(homeTotalMembers / cardsPerSlide);
    }

    /**
     * Update carousel position and dot indicators
     */
    function updateCarouselHome() {
        if (!homeCarousel || homeTotalMembers === 0) return;

        const slideWidth = document.querySelector('.team-slide').offsetWidth + 25;
        const cardsPerSlide = getCardsPerSlide();
        const totalPages = getTotalPages();
        
        // Ensure current index doesn't exceed total pages
        if (homeCurrentIndex >= totalPages) {
            homeCurrentIndex = totalPages - 1;
        }
        
        // CRITICAL FIX: Check if we're on last page
        const isLastPage = homeCurrentIndex === (totalPages - 1);
        let translateDistance;
        
        if (isLastPage) {
            // On last page: only scroll enough to show remaining cards
            // This eliminates white space on the right
            const cardsShown = homeCurrentIndex * cardsPerSlide;
            const remainingCards = homeTotalMembers - cardsShown;
            
            // If remaining cards < cardsPerSlide, adjust to show only remaining
            if (remainingCards < cardsPerSlide) {
                // Scroll to show last card at the right edge (no white space)
                translateDistance = (homeTotalMembers - cardsPerSlide) * slideWidth;
                // Prevent negative scroll
                translateDistance = Math.max(0, translateDistance);
            } else {
                // Normal scroll for last page if it has full cards
                translateDistance = homeCurrentIndex * cardsPerSlide * slideWidth;
            }
        } else {
            // Normal pages: scroll by full card increments
            translateDistance = homeCurrentIndex * cardsPerSlide * slideWidth;
        }
        
        homeCarousel.style.transform = `translateX(-${translateDistance}px)`;

        // Update dots
        homeDots.forEach((dot, index) => {
            // Only show dots for actual pages
            if (index < totalPages) {
                dot.style.display = 'inline-block';
                dot.classList.toggle('active', index === homeCurrentIndex);
            } else {
                dot.style.display = 'none';
            }
        });
    }

    /**
     * Move carousel in specified direction
     * @param {number} direction - 1 for next, -1 for previous
     */
    function moveCarouselHome(direction) {
        if (homeTotalMembers === 0) return;
        
        const totalPages = getTotalPages();
        homeCurrentIndex += direction;

        // Wrap around logic - smooth circular navigation
        if (homeCurrentIndex >= totalPages) {
            homeCurrentIndex = 0;
        } else if (homeCurrentIndex < 0) {
            homeCurrentIndex = totalPages - 1;
        }

        updateCarouselHome();
        resetAutoSlideHome();
    }

    /**
     * Jump to specific slide
     * @param {number} index - Slide index to navigate to
     */
    function currentSlideHome(index) {
        if (homeTotalMembers === 0) return;
        
        const totalPages = getTotalPages();
        if (index >= 0 && index < totalPages) {
            homeCurrentIndex = index;
            updateCarouselHome();
            resetAutoSlideHome();
        }
    }

    /**
     * Auto-slide to next slide
     */
    function autoSlideHome() {
        if (homeTotalMembers === 0) return;
        
        const totalPages = getTotalPages();
        homeCurrentIndex++;
        if (homeCurrentIndex >= totalPages) {
            homeCurrentIndex = 0;
        }
        updateCarouselHome();
    }

    /**
     * Start auto-slide interval
     * Fixed: Increased from 5000ms to 6000ms for smoother scrolling
     */
    function startAutoSlideHome() {
        const totalPages = getTotalPages();
        if (totalPages > 1) {
            homeAutoSlideInterval = setInterval(autoSlideHome, 6000);
        }
    }

    /**
     * Reset auto-slide interval
     */
    function resetAutoSlideHome() {
        clearInterval(homeAutoSlideInterval);
        startAutoSlideHome();
    }

    /**
     * Initialize carousel on DOM ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        if (homeTotalMembers > 0) {
            updateCarouselHome();
            startAutoSlideHome();

            const wrapper = document.querySelector('.team-carousel-wrapper');
            if (wrapper) {
                wrapper.addEventListener('mouseenter', () => clearInterval(homeAutoSlideInterval));
                wrapper.addEventListener('mouseleave', startAutoSlideHome);
            }

            // Event Listeners for Navigation Buttons
            const prevBtn = document.querySelector('.team-carousel__nav--prev');
            const nextBtn = document.querySelector('.team-carousel__nav--next');

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    moveCarouselHome(-1);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    moveCarouselHome(1);
                });
            }

            // Event Listeners for Dots
            homeDots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    currentSlideHome(index);
                });
                
                // Accessibility: Allow Enter key on dots
                dot.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        currentSlideHome(index);
                    }
                });
            });
        }
    });

    /**
     * Handle window resize for responsive carousel with debounce
     * IMPORTANT: Recalculate pages when window resizes (cards per slide changes)
     */
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            homeCurrentIndex = 0; // Reset to first slide on resize
            requestAnimationFrame(updateCarouselHome);
        }, 150);
    });
})();
