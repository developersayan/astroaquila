	$('.carousel').carousel({
	  interval: 5000,
   	  pause: "false"
	})

	$(".navbar-toggler").click(function(){
  $(".navbar-toggler").toggleClass("showtoggle");
});	

$(document).ready(function() {
  $('.fancybox').fancybox();
  $('.fancybox-media')
    .attr('rel', 'media-gallery')
    .fancybox({
      openEffect : 'none',
      closeEffect : 'none',
      prevEffect : 'none',
      nextEffect : 'none',

      arrows : false,
      helpers : {
        media : {},
        buttons : {}
      }
    });

});


$(document).ready(function() {
    var owl = $('.take_astro_iner .owl-carousel');
    owl.owlCarousel({
      margin: 0,
      nav: true,
      autoplay:true ,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        480: {
          items: 2
        },
        575: {
          items: 2
        },
        715: {
          items: 3
        },
        768: {
          items: 3
        },
        991: {
          items: 3
        },
        1000: {
          items: 4
        }
      }
    })
  })

$(document).ready(function() {
    var owl = $('.gem-stone-iner .owl-carousel');
    owl.owlCarousel({
      margin: 0,
      nav: true,
      autoplay:true ,
      loop: true,
      responsive: {
         0: {
          items: 1
        },
        480: {
          items: 2
        },
        575: {
          items: 2
        },
        715: {
          items: 3
        },
        768: {
          items: 3
        },
        991: {
          items: 3
        },
        1000: {
          items: 4
        }
      }
    })
  })
$(document).ready(function() {
    var owl = $('.astro-product-iner .owl-carousel');
    owl.owlCarousel({
      margin: 0,
      nav: true,
      autoplay:true ,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        480: {
          items: 2
        },
        575: {
          items: 2
        },
        715: {
          items: 3
        },
        768: {
          items: 3
        },
        991: {
          items: 3
        },
        1000: {
          items: 4
        }
      }
    })
  })

$(document).ready(function() {
    var owl = $('.book_puja .owl-carousel');
    owl.owlCarousel({
      margin: 0,
      nav: true,
      autoplay:true ,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        480: {
          items: 2
        },
        575: {
          items: 2
        },
        715: {
          items: 3
        },
        768: {
          items: 3
        },
        991: {
          items: 3
        },
        1000: {
          items: 4
        }
      }
    })
  })

$(document).ready(function() {
    var owl = $('.testimonials_inr .owl-carousel');
    owl.owlCarousel({
      margin: 0,
      center: true,
      nav: true,
      autoplay:true ,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        575: {
          items: 2
        },
        715: {
          items: 2
        },
        768: {
          items: 2
        },
        991: {
          items: 3
        },
        1000: {
          items: 3
        }
      }
    })
  })




