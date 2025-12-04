/**
 * LAB NCS - TENTANG PAGE CAROUSEL SCRIPT
 * Purpose: Team carousel navigation and auto-slide functionality for tentang.php
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
        if (width >= 1200) return 4;  // Desktop: 4 cards (25%)
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
        
        // Calculate transform based on cards per slide
        homeCarousel.style.transform = `translateX(-${homeCurrentIndex * cardsPerSlide * slideWidth}px)`;

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
     * Move carousel in specified direction (globally accessible)
     * @param {number} direction - 1 for next, -1 for previous
     */
    window.moveCarouselHome = function(direction) {
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
    };

    /**
     * Jump to specific slide (globally accessible)
     * @param {number} index - Slide index to navigate to
     */
    window.currentSlideHome = function(index) {
        if (homeTotalMembers === 0) return;
        
        const totalPages = getTotalPages();
        if (index >= 0 && index < totalPages) {
            homeCurrentIndex = index;
            updateCarouselHome();
            resetAutoSlideHome();
        }
    };

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
