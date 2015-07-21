//<![CDATA[
;(function(window){
    $( document ).ready(function() {
        $('#search-form').submit(function(event) {
                event.preventDefault();
                var input = $('#search-tag-input').val();
                window.location.replace("http://" + window.location.hostname + "/tag/" + input);
            }
        );
    });
})(window);
//]]>