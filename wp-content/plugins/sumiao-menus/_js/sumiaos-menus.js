(function($) {
    var bttn = $('.tabs-items button'),
        menu = document.getElementsByClassName('menu-tabs')[0],
        menuCont = document.getElementsByClassName('menus-container')[0],
        menuH = menu.offsetHeight,
        menuTop = menuCont.getBoundingClientRect().top,
        menuBttm = menuCont.getBoundingClientRect().bottom,
        wS = window.pageYOffset,
        wH = window.innerHeight,
        trig = false;

    // $(window).on('scroll resize', function(){
    //     wS = window.pageYOffset,
    //     wH = window.innerHeight,
    //     menuH = menu.offsetHeight,
    //     menuTop = menuCont.getBoundingClientRect().top,
    //     menuBttm = menuCont.getBoundingClientRect().bottom;

    //     if (menuTop <= 0 && menuBttm > menuH) {
    //         if(!$(menu).hasClass('fixed') && !$(menu).hasClass('init')) {
    //             menu.style.height = menuH + "px";
    //             $(menu).addClass('init');
    //             $(menu).addClass(function(index){
    //                 var item = $(this);
    //                 setTimeout(function(){
    //                     item.addClass('fixed');
    //                 }, 100);
    //             });
    //             $(nav).addClass('unfix');
    //         }
    //        trig = false;
    //     } else if (menuTop > 0 || menuBttm < 0) {
    //         menu.style.height = "auto";
    //         if($(menu).hasClass('fixed') && $(menu).hasClass('init')) {
    //             $(menu).removeClass('fixed');
    //             $(menu).removeClass('init');
    //             $(nav).removeClass('unfix');
    //         }
    //     }
    // });

    bttn.on('click', function(){
        var attr = $(this).data('id'),
            curMenu = $('#' + attr),
            allMenu = $('#AllMenus'),
            menus = $('.menu-category-cont');
        // toggle visiblity of itemsd
        bttn.removeClass('active');
        $(this).addClass('active');
        if (!$(this).parent().parent().hasClass('toggled')) {
            $(this).parent().parent().addClass('toggled');
        }
        menus.removeClass('visible');
        curMenu.addClass('visible');
        if(!allMenu.hasClass('toggled')) {
            allMenu.addClass('toggled');
        }
    });
})(jQuery);