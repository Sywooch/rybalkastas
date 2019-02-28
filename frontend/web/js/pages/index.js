$(function(){
    $('.special-proposal-slider').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        },
        navText: ["Назад","Вперед"],
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true
    });

    $('#main-slider').owlCarousel({
        loop:true,
        items:1,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,

    })
});
