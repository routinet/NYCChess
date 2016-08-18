/**
 * Project: nycchess
 * File: nycc-base
 *
 * Base JS library for NYCC component
 */
;

// Global namespace object
var NYCC = NYCC || {};

/**
 * Adds the custom NYCC data object to an arbitrary element.
 *
 * @param elem
 *   An object, such as a DOM element or a jQuery object
 *
 */
NYCC.addData = function(elem) {
    var $ = jQuery, $e = $(elem);
    if (!$e.data('NYCC')) {
        $e.data('NYCC', new this.data_object);
    }
    return $e.data('NYCC');
}

/**
 * The custom NYCC data object.
 */
NYCC.data_object = function() {};
NYCC.data_object.prototype.data = function(key, data, undefined) {
    if (data !== undefined) {
        this[key] = data;
    }
    return this[key];
};

