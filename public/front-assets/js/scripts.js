$().ready( function() {
    $(".main-carousel").slick({
    dots: false,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    arrows: true,
    responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 550,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },

      ]
    });


    // Fixa navbar ao ultrapassa-lo
    var $header = $(".fixed-bar"),
    $clone = $header.before($header.clone().addClass("fixed-footer"));

    $(window).on("scroll", function() {
        var fromTop = $(window).scrollTop();
        $("body").toggleClass("down", (fromTop > 400));
    });

    $('.burger').on('click', function(){
        $('.menu').children('ul').slideToggle();
    });

    $('.more').on('click', function(){
        $(this).prev('.detail').slideToggle();
    });

});