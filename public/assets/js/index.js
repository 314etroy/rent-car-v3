/*----------------------------- Site Loader & Popup --------------------*/
$(window).on("load", function () {
    $("#bx-overlay").fadeOut("slow");
});

$(document).ready(function () {

    /*--------------------- Aos animation on scroll --------------------*/
    AOS.init({
        once: true
    });

    $("#dropdown-toggle").click(function () {
        $("#mobile-menu").slideToggle("fast");
    });

    /*-------------------- Potfolio --------------------*/
    $('.portfolio-tabs ul li').click(function () {
        $('ul li').removeClass("active");
        $(this).addClass("active");
    });

    /*-------------------- Potfolio for Mixit up --------------------*/
    let portfolioContent = $('.portfolio-content');
    portfolioContent.mixItUp();

    /*--------------------- News carousel -------------------------------- */
    $('.news-carousel').owlCarousel({
        margin: 24,
        loop: true,
        dots: false,
        nav: false,
        smartSpeed: 1000,
        autoplay: true,
        items: 2,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            400: {
                items: 1,
                nav: false
            },
            576: {
                items: 2,
                nav: false
            },
            768: {
                items: 2,
                nav: false
            },
        }
    });

    /*--------------------- parallaxmouse JS -------------------------------- */
    $(window).parallaxmouse({
        invert: true,
        range: 400,
        elms: [
            { el: $('.shape1'), rate: 0.2 },
            { el: $('.shape2'), rate: 0.2 },
            { el: $('.shape3'), rate: 0.2 },
            { el: $('.shape4'), rate: 0.3 },
            { el: $('.shape5'), rate: 0.2 },
        ]
    });

});
