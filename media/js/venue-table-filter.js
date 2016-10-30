/**
 * Project: nycchess
 * File:
 */
(function ($, document, window, undefined) {
    /**
     * Add the filtering function to NYCC namespace
     */
    window.NYCC.filterVenues = function() {
        var the_table = $('.table-venue-list'),
            elements = $('.venue-filter.selected'),
            filter = elements.map(function(k,v){return v.innerHTML;}).toArray().join('|');
        if (filter) {
            filter = '"('+filter+')"';
        }
        the_table.DataTable().column(2).search(filter, true, true, false).draw();
    };

    /**
     *  onReady necessities
     */
    $(document).ready(function () {

        $('.venue-filter').on('click', function(e) {
            if (e.target.innerHTML == 'All') {
                $('.venue-filter').removeClass('selected');
            } else {
                $(e.target).toggleClass('selected');
            }
            window.NYCC.filterVenues();
        });

        $('.register_venue_label').on('click', function(e) {
            $(e.target).toggleClass('selected');
        })

    });

})(jQuery, document, window);
