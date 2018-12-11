'use strict';
var pagedata = {};

$(function() {
    $('meta[name="pagedata"]').each(function() {
        var self = $(this);
        pagedata[self.data('key')] = self.data('value');
    });
});
