jQuery(function($) {
  var logo = $('.site-title a'),
      title = $('.site-title'),
      address = $('.title-container address'),
      social = $('.title-container .social-links'),
      tl = new TimelineLite(),
      wMark = document.getElementsByClassName('watermark'),
      wMPos = wMark[0].offsetTop,
      wH = window.innerHeight,
      wS = window.pageYOffset;

      window.addEventListener('scroll', checkPos);
      window.addEventListener('resize', checkPos);


  	function checkPos() {
  		wS = window.pageYOffset;
  		wH = window.innerHeight;
  		wMPos = wMark[0].offsetTop;
  		if (wS + wH/1.75 > wMPos) {
  			$(wMark[0]).addClass('animate');
  		}
  	}
  // header animations
  tl.to(logo, .3, {css: {transform: "translateY(0)", opacity: 1}})
    .to(address, .3, {css: {opacity: 1, transform: "translateY(0)" }})
    .to(social, .3, {css: {opacity: 1, transform: "translateY(0)"}});


});
