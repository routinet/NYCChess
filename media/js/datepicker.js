;
/* Javascript helper for datepicker custom form field */

(function ($, document, window, undefined) {

  /**
   *  onReady necessities
   */
  $(document).ready(function () {

    $('.nycc-datepicker').datepick({multiSelect: 999})
        .each(function(k,v) {
          var $v = $(v),
              $alt = $v.closest('.nycc-datepicker-container').find('.nycc-datepicker-value');
          $v.datepick('option', {altField:$alt, altFormat:'yyyy-mm-dd'});
        });

  });

})(jQuery, document, window);
