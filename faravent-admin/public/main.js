
function showToast(toastType, message, timeout=2000){
    $('#toast-container').append('\
    <div class="toast '+toastType+'" aria-live="polite">\
        <div class="toast-message">\
            '+message+'\
        </div>\
    </div>');

    setTimeout(function(){$('#toast-container').find('div').first().remove();}, timeout);
}

var vis = (function(){
    var stateKey,
        eventKey,
        keys = {
                hidden: "visibilitychange",
                webkitHidden: "webkitvisibilitychange",
                mozHidden: "mozvisibilitychange",
                msHidden: "msvisibilitychange"
    };
    for (stateKey in keys) {
        if (stateKey in document) {
            eventKey = keys[stateKey];
            break;
        }
    }
    return function(c) {
        if (c) document.addEventListener(eventKey, c);
        return !document[stateKey];
    }
})();
