/**
 * Visa Page - Filter and Selection Functionality
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        // Check if we're on the visa page
        if ($('.visa-section-page').length > 0) {
            initVisaPage();
        }
    });

    function initVisaPage() {
        // Initialize filter buttons
        initFilterButtons();

        // Initialize country filter
        initCountryFilter();

        // Initialize Select2 for country selection (last to avoid blocking)
        try {
            initCountrySelect();
        } catch(e) {
            // Silent fail if Select2 not available
        }
    }

    /**
     * Initialize Select2 for country dropdown
     */
    function initCountrySelect() {
        if ($('#visaCountrySelect').length > 0) {
            // Check if Select2 is available
            if (typeof $.fn.select2 !== 'undefined') {
                $('#visaCountrySelect').select2({
                    placeholder: 'انتخاب کشور',
                    allowClear: true,
                    dir: 'rtl',
                    dropdownCssClass: 'visa-country-dropdown',
                    language: {
                        noResults: function() {
                            return "نتیجه‌ای یافت نشد";
                        },
                        searching: function() {
                            return "در حال جستجو...";
                        }
                    }
                });
            }
        }
    }

    /**
     * Initialize filter buttons functionality
     */
    function initFilterButtons() {
        $('.visa-filter-btn').on('click', function(e) {
            e.preventDefault();

            // Remove active class from all buttons
            $('.visa-filter-btn').removeClass('active');

            // Add active class to clicked button
            $(this).addClass('active');

            // Get selected visa type
            var selectedType = $(this).data('visa-type');

            // Filter visa cards
            filterVisaCards(selectedType);
        });
    }

    /**
     * Initialize country filter functionality
     */
    function initCountryFilter() {
        $('#visaCountrySelect').on('change', function() {
            var selectedCountryId = $(this).val();

            // Get current active visa type
            var $activeFilter = $('.visa-filter-btn.active');
            var selectedType = $activeFilter.data('visa-type') || 'all';

            // Re-filter with both filters
            filterVisaCards(selectedType);
        });
    }

    /**
     * Filter visa cards by type and country
     * @param {string} type - Visa type to filter (all, tourist, work, study, etc.)
     */
    function filterVisaCards(type) {
        var $visaCards = $('.visa-card-item');
        var $selectedCountry = $('#visaCountrySelect').val();
        var visibleCount = 0;

        $visaCards.each(function() {
            var $card = $(this);
            var cardType = $card.data('visa-type');
            var countryId = $card.data('country-id');
            var shouldShow = true;

            // Check visa type filter
            if (type !== 'all') {
                shouldShow = (cardType == type);
            }

            // Check country filter
            if (shouldShow && $selectedCountry && $selectedCountry !== 'all') {
                shouldShow = (countryId == $selectedCountry);
            }

            // Show or hide card with animation
            if (shouldShow) {
                $card.fadeIn(300);
                visibleCount++;
            } else {
                $card.fadeOut(300);
            }
        });

        // Check if no results after animation completes
        setTimeout(function() {
            checkNoResults();
        }, 350);
    }

    /**
     * Check if there are no visible cards and show message
     */
    function checkNoResults() {
        var $visibleCards = $('.visa-card-item:visible');
        var $cardsRow = $('#visaCardsRow');

        // Remove existing no-results message
        $('.visa-no-results').remove();

        if ($visibleCards.length === 0) {
            // Show no results message
            $cardsRow.append(
               '<div class="col-12 visa-no-results">' +
               '<div class="text-center">' +

               '<span/>ویزایی با این فیلترها یافت نشد. لطفاً فیلترهای دیگری را امتحان کنید.<span>' +
               '</div>' +
               '</div>'
            );
        }
    }

    /**
     * Reset all filters
     */
    function resetFilters() {
        // Reset filter buttons
        $('.visa-filter-btn').removeClass('active');
        $('.visa-filter-btn[data-visa-type="all"]').addClass('active');

        // Reset country select
        $('#visaCountrySelect').val('all').trigger('change');

        // Show all cards
        $('.visa-card-item').fadeIn(300);

        // Remove no results message
        $('.visa-no-results').remove();
    }

    // Make reset function globally available
    window.resetVisaFilters = resetFilters;

})(jQuery);
