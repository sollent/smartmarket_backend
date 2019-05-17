// Initial all materialize-js javascript components
$(document).ready(function(){
    // For mobile menu button
    $('.sidenav').sidenav();
    $('.catalog_menu .collapsible').collapsible({

        inDuration: 200,
        outDuration: 200
    });
    $('.categories-menu .collapsible').collapsible({

    });
    $('.modal').modal({
        inDuration: 500,
        outDuration: 500
    });
    $('.slider').slider();
    $('select').formSelect();
    $('.tabs').tabs();
    $('.materialboxed').materialbox();
    // $('.datepicker').datepicker({
    //     i18n: {
    //         cancel: 'Отмена'
    //     },
    //     onClose: function() {
    //         if ($('#clientOtherDateInput').checked) {
    //             $('#clientOtherDateInput').checked = false;
    //         }
    //     }
    // });
    $('.timepicker').timepicker();
    $(document).ready(function(){
        $('.sidenav.product-description-sidenav').sidenav({
            edge: 'right',
            inDuration: 550,
            outDuration: 300
        });
    });
    // $('.carousel').carousel({
    //     dist: -200
    // });
    $("#scroll-to-top-validation").click(function() {
        $('html,body').animate({
                scrollTop: $("#cartModalHeader").offset().top
            },
            'slow');
    });
    $('#scroll-to-top-success').click(function() {
        $('html,body').animate({
                scrollTop: $(".header").offset().top
            },
            'slow');
    });
    let lastScrollTop = 0;
    $(window).scroll(function(event){
        let st = $(this).scrollTop();
        if (st > lastScrollTop){
            // код для прокрутки вниз
            $('.header-nav').removeClass('active');
        } else {
            // код для прокрутки вверх
            $('.header-nav').addClass('active');
        }
        lastScrollTop = st;
    });
});
