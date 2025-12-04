/**
 * LAB NCS - MAIN JAVASCRIPT
 * Contains general functionality extracted from inline scripts
 */

document.addEventListener('DOMContentLoaded', function() {
    // Smooth Scroll Handler with Clean URLs
    // Handle clicks on navigation links with data-scroll attribute
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[data-scroll]');
        if (link) {
            e.preventDefault();
            const targetId = link.getAttribute('data-scroll');
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                // Smooth scroll to target
                const headerOffset = 100; // Account for sticky header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Clean the URL (remove any hash)
                history.pushState('', document.title, window.location.pathname);
            }
        }
    });

    // Handle URL hash on page load (if someone uses direct link with hash)
    function handleHashOnLoad() {
        const hash = window.location.hash;
        if (hash) {
            const targetId = hash.substring(1); // Remove the # symbol
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                setTimeout(() => {
                    const headerOffset = 100;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    // Clean the URL after scrolling
                    setTimeout(() => {
                        history.pushState('', document.title, window.location.pathname);
                    }, 100);
                }, 100);
            }
        }
    }
    handleHashOnLoad();

    // Accordion Toggle Logic with Icon Animation (NO BOUNCING)
    if ($('.accrodion-title').length) {
        $('.accrodion-title').off('click').on('click', function(e) {
            e.preventDefault();
            
            var $container = $(this).closest('.accrodion');
            var $content = $container.find('.accrodion-content');
            var $icon = $container.find('.accrodion-title__icon i');
            
            // STOP any ongoing animation to prevent bounce
            $content.stop(true, true);
            
            // Toggle active class
            $container.toggleClass('active');
            
            // Toggle icon between + and -
            if ($container.hasClass('active')) {
                $icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                $icon.removeClass('fa-minus').addClass('fa-plus');
            }
            
            // Smooth slide toggle with linear easing (300ms)
            $content.slideToggle(300, 'linear');
        });
    }
});
