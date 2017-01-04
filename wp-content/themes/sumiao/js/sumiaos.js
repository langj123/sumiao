jQuery(function($) {
  var logo = $('.site-title a'),
      title = $('.site-title'),
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
  // TweenMax.set(logo, {transformStyle: "preserve-3d"} );
  // TweenMax.set(title, {transformStyle: "preserve-3d"} );

  // tl.fromTo(title, .2, {css: {opacity: 0}}, {css: {opacity: 1}})
  //   .fromTo(logo, .3, {css:{ transform: "rotateX(90deg)" }}, {css: {transform:"rotateX(0)" }});


});
