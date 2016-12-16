new WOW().init();


//Inpage-Scroll
$(document).ready(function(){
	$('a[href^="#"].inpage-scroll, .inpage-scroll a[href^="#"]').on('click', function(e) {
		e.preventDefault();

		var target = this.hash,
		$target = $(target);
		$('.main-navigation a[href="' + target + '"]').addClass('active');
		$('.main-navigation a:not([href="' + target + '"])').removeClass('active');
		$('html, body').stop().animate({
			'scrollTop': ($target.offset()) ? $target.offset().top : 0
		}, 900, 'swing', function() {
			window.location.hash = target;
		});
	});
});

function scrollToElement(selector, callback){
    var animation = {scrollTop: $(selector).offset().top};
    $('html,body').animate(animation, 'slow', 'swing', function() {
        if (typeof callback == 'function') {
            callback();
        }
        callback = null;
    });
}
//==//


 jQuery(document).ready(function($) {
      
      $('#latest-products-slider').owlCarousel({
      
      items : 1,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [979,1],
      
      sliderSpeed: 100,
      paginationSpeed: 900,
      rewindSpeed: 800,
      
      autoPlay: true,
      stopOnHover: true,
      
      navigation: false,
      
      responsive: false,
      responsiveRefreshRate: 200,
      responsiveBaseWidth: window,
      
      baseClass: "owl-carousel",
      theme: "owl-theme",
      
      animateOut: 'slideOutUp',
      animateIn: 'slideInUp',
      transitionStyle: 'fade'
      
      });
  });

  jQuery(document).ready(function($) {
      
      $('#home-products-slider').owlCarousel({
      
      items : 3,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,1],
      
      sliderSpeed: 100,
      paginationSpeed: 600,
      rewindSpeed: 800,
      
      autoPlay: true,
      stopOnHover: true,
      
      navigation: false,
      
      responsive: true,
      responsiveRefreshRate: 200,
      responsiveBaseWidth: window,
      
      baseClass: "owl-carousel",
      theme: "owl-theme",
      
      animateOut: 'slideOutUp',
      animateIn: 'slideInUp',
      transitionStyle: 'fade'
      
      });
  });

    jQuery(document).ready(function($) {
      
      $('#product-img-slider').owlCarousel({
      
      items : 1,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [979,1],
      
      sliderSpeed: 100,
      paginationSpeed: 600,
      rewindSpeed: 800,
      
      autoPlay: true,
      stopOnHover: true,
      
      navigation: false,
      
      responsive: false,
      responsiveRefreshRate: 200,
      responsiveBaseWidth: window,
      
      baseClass: "owl-carousel",
      theme: "owl-theme",
      
      animateOut: 'slideOutUp',
      animateIn: 'slideInUp'
      
      });
  });

    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});


  jQuery(document).ready(function($) {
      
      $('#testimon-slider').owlCarousel({
      
      items : 1,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [979,1],
      
      sliderSpeed: 100,
      paginationSpeed: 600,
      rewindSpeed: 800,
      
      autoPlay: true,
      stopOnHover: true,
      
      navigation: false,
      
      responsive: true,
      responsiveRefreshRate: 200,
      responsiveBaseWidth: window,
      
      baseClass: "owl-carousel",
      theme: "owl-theme",
      
      animateOut: 'slideOutUp',
      animateIn: 'slideInUp'
      
      });
  });