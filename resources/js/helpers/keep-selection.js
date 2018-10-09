window.$ = window.jQuery = require('jquery');

$(function() {
    var selectionRange = null;

    $(document).on('click', '.js-keep-selection-button', function(){
        selectionRange = saveSelection();
        addFauxHighlight(selectionRange);
    });

    $(document).on('focus, keydown', '.ProseMirror', function(){
        removeFauxHighlight();
    });

    function saveSelection() {
        if (window.getSelection) {
            var sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                return sel.getRangeAt(0);
            }
        } else if (document.selection && document.selection.createRange) {
            return document.selection.createRange();
        }
        return null;
    }

    function restoreSelection(range) {
        if (range) {
            if (window.getSelection) {
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            } else if (document.selection && range.select) {
                range.select();
            }
        }
    }

    function removeFauxHighlight() {
        var wrap = $('.ProseMirror').find('ins');
        var text = wrap.html();
        wrap.replaceWith(text);
    }

    function addFauxHighlight(selection) {
        var ins = document.createElement('ins');
        var range = selection.cloneRange();
        range.surroundContents(ins);

    }

});


