jQuery(function($) {
	var sub = $('.sub-page-wrap'),
	pos = sub.offset().top;
	$(window).scroll(function() {
		var winScroll = $(window).scrollTop();
		if (winScroll >= pos) {
			sub.addClass("fixed");
		} else {
			sub.removeClass("fixed");
		}
	});
});