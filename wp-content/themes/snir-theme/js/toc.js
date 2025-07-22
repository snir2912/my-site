// toc.js

jQuery(document).ready(function($) {
    const tocWrapper = $('.table-of-contents-wrapper');
    const tocHeader = tocWrapper.find('.toc-header');
    const tocList = tocWrapper.find('.toc-list');
    const tocToggleButton = tocWrapper.find('.toc-toggle');

    // Initial state: TOC is closed, so set aria-hidden to true and aria-expanded to false.
    tocList.attr('aria-hidden', 'true');
    tocToggleButton.attr('aria-expanded', 'false');

    tocHeader.on('click', function() {
        const isExpanded = tocToggleButton.attr('aria-expanded') === 'true';

        if (isExpanded) {
            // Collapse the TOC
            tocList.attr('aria-hidden', 'true');
            tocToggleButton.attr('aria-expanded', 'false');
            // Additional styling for collapse animation if needed, though CSS handles it
        } else {
            // Expand the TOC
            tocList.attr('aria-hidden', 'false');
            tocToggleButton.attr('aria-expanded', 'true');
            // Additional styling for expand animation if needed, though CSS handles it
        }
    });

    // Handle smooth scrolling for anchor links
    tocList.find('a').on('click', function(e) {
        e.preventDefault(); // Prevent default anchor jump

        const targetId = $(this).attr('href');
        const targetElement = $(targetId);

        if (targetElement.length) {
            $('html, body').animate({
                scrollTop: targetElement.offset().top - 80 // Adjust 80px for fixed header/padding if any
            }, 800);
        }

        // Optionally, close the TOC after clicking an item
        // tocList.attr('aria-hidden', 'true');
        // tocToggleButton.attr('aria-expanded', 'false');
    });
});