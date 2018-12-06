'use strict';
var pagedata = {};

document.addEventListener('DOMContentLoaded', function() {
    var el;
    var key;

    for (el of document.querySelectorAll('meta[name="pagedata"]'))
        pagedata[el.dataset.key] = el.dataset.value;
});
