jQuery(function($) {
  var logo = $('.site-title a'),
      title = $('.site-title'),
      tl = new TimelineLite();

  TweenMax.set(logo, {transformStyle: "preserve-3d"} );
  TweenMax.set(title, {transformStyle: "preserve-3d"} );

  tl.fromTo(title, .4, {css: {opacity: 0}}, {css: {opacity: 1}})
    .fromTo(logo, .7, {css:{ transform: "rotateX(90deg)" }}, {css: {transform:"rotateX(0)" }});

});
