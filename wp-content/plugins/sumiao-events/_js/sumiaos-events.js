(function($) {
    var loadEvents = $('#LoadEvents'),
    delay = 120;
    loadEvents.on("click", function() {
        setTimeout(function(){
        	load_events();
        	var offset = loadEvents.data("offset");
        	loadEvents.data('offset', offset + 6);
        }, delay);
    });
    function load_events(){
        var offset = loadEvents.data("offset");
		var str = 'offset=' + offset + '&action=ann_load_past_events';
        $("#PastEvents").append('<p class="search-loading">Loading</p>');
        $.ajax({
            type: "POST",
            dataType: "html",
            url: ajax_events.ajaxurl,
            data: str,
            context: $('#PastEvents'),
            cache: false,
            success: function(data){
                var $data = $(data);
                $('#PastEvents .search-warning').remove();
                $('#PastEvents .search-loading').remove();
                $("#PastEvents").append($data);
                if ($data.length == 0) {
                    $("#PastEvents").append('<p class="search-warning">' + ajax_events.noposts + '</p>');
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }

        });

        return false;
    }

})(jQuery);