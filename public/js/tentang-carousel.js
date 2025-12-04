/**
 * LAB NCS - TENTANG PAGE CAROUSEL SCRIPT
 * Purpose: Team carousel navigation and auto-slide functionality for tentang.php
 * Last Updated: 2025-12-02
 * Fixed: Autoscroll timing bug and smooth transition
 */

(function() {
    'use strict';

    // Initialize carousel variables
    let homeCurrentIndex = 0;
    let homeAutoSlideInterval;
    let resizeTimeout;
    const homeTotalSlides = window.homeTotalSlides || 0;
    const homeCarousel = document.getElementById('teamCarousel');
    const homeDots = document.querySelectorAll('.team-carousel__dots .dot');

    /**
     * Update carousel position and dot indicators
     */
    function updateCarouselHome() {
        if (!homeCarousel || homeTotalSlides === 0) return;

        const slideWidth = document.querySelector('.team-slide').offsetWidth + 25;
        homeCarousel.style.transform = `translateX(-${homeCurrentIndex * slideWidth}px)`;

        // Update dots
        homeDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === homeCurrentIndex);
        });
    }

    /**
     * Move carousel in specified direction (globally accessible)
     * @param {number} direction - 1 for next, -1 for previous
     */
    window.moveCarouselHome = function(direction) {
        if (homeTotalSlides === 0) return;

        homeCurrentIndex += direction;

        // Wrap around logic - smooth circular navigation
        if (homeCurrentIndex >= homeTotalSlides) {
            homeCurrentIndex = 0;
        } else if (homeCurrentIndex < 0) {
            homeCurrentIndex = homeTotalSlides - 1;
        }

        updateCarouselHome();
        resetAutoSlideHome();
    };

    /**
     * Jump to specific slide (globally accessible)
     * @param {number} index - Slide index to navigate to
     */
    window.currentSlideHome = function(index) {
        if (homeTotalSlides === 0) return;

        homeCurrentIndex = index;
        updateCarouselHome();
        resetAutoSlideHome();
    };

    /**
     * Auto-slide to next slide
     */
    function autoSlideHome() {
        if (homeTotalSlides === 0) return;

        homeCurrentIndex++;
        if (homeCurrentIndex >= homeTotalSlides) {
            homeCurrentIndex = 0;
        }
        updateCarouselHome();
    }

    /**
     * Start auto-slide interval
     * Fixed: Increased from 5000ms to 6000ms for smoother scrolling
     */
    function startAutoSlideHome() {
        if (homeTotalSlides > 1) {
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
        if (homeTotalSlides > 0) {
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
     */
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            requestAnimationFrame(updateCarouselHome);
        }, 150);
    });
})();
