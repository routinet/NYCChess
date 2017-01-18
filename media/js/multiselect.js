;
/* Javascript helper for multiselect custom form field */

(function ($, document, window, undefined) {

  /**
   * multiselect jQuery extension definition
   */
  var _multiselect = function(element) {
    this.$e = $(element);
    this.$value = this.$e.find('.multiselect-value');
    this.init();
    return this;
  };

  // Initialize the object.
  _multiselect.prototype.init = function() {
    // The value box, and all checked checkboxes
    var $value = this.$value;
    // set the click handler for the checkbox
    this.$e.on('change', 'input[type="checkbox"]', function (e) {
      e.stopPropagation();
      $parent = $value.closest('.nycc-multiselect');
      $value.html(
          $.makeArray(
              $parent.find('input[type="checkbox"]:checked')
                  .map(function (k,v) { return $(v).next('label').html(); })
          ).join(', ')
      );
    });
  };

  // Add it to the NYCC namespace.
  window.NYCC.multiselect = _multiselect;
  /**
   * End multiselect jQuery extension definition
   */



  /**
   *  onReady necessities
   */
  $(document).ready(function () {

    // Extend jQuery
    $.fn.NYCC_multiselect = function () {
      return this.each(function () {
        //var e =
        window.NYCC.addData(this).data('multiselect', new window.NYCC.multiselect(this));
      });
    };

    // Engage any existing multiselect elements
    $('.nycc-multiselect').NYCC_multiselect();


  });

})(jQuery, document, window);
