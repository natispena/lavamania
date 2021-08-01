jQuery(document).ready(function() {
  const $cont = jQuery('.ltx-fcslider-wrapper');
  const $slider = jQuery('.ltx-slider');
  const $nav = jQuery('.ltx-slider-nav');
  const winW = jQuery(window).width();
  const animSpd = 750; // Change also in CSS
  const distOfLetGo = winW * 0.2;
  let curSlide = 1;
  let animation = false;
  let autoScrollVar = true;
  let diff = 0;
  
  // Generating slides
  let numOfSlides = $slider.children().length;
  
  let generateSlide = function(i) {

    let frag2 = jQuery(document.createDocumentFragment());

    i = i + 1;

    const navSlide = jQuery(`<li data-target="${i}" class="nav__slide nav__slide--${i}"></li>`);
    frag2.append(navSlide);
    $nav.append(frag2); 
  };

  for (let i = 0, length = numOfSlides; i < length; i++) {

    generateSlide(i);
  }

  jQuery('.nav__slide--1').addClass('nav-active');
  jQuery('.slide.slide--1').addClass('slide-active');
  jQuery('.slide.slide--2').addClass('slide-next');

  // Navigation
  function bullets(dir) {
    jQuery('.nav__slide--' + curSlide).removeClass('nav-active');
    jQuery('.slide.slide--' + curSlide).removeClass('slide-active slide-prev slide-next');
    jQuery('.nav__slide--' + dir).addClass('nav-active');
    jQuery('.slide.slide--' + dir).removeClass('slide-prev slide-next').addClass('slide-active');

    jQuery('.slide.slide--' + (dir - 1) ).removeClass('slide-prev slide-next').addClass('slide-prev');
    jQuery('.slide.slide--' + (dir + 1) ).removeClass('slide-prev slide-next').addClass('slide-next');

    jQuery('.slide.slide--' + (dir - 2) ).removeClass('slide-prev slide-next');
    jQuery('.slide.slide--' + (dir + 2) ).removeClass('slide-prev slide-next');

  }
  
  function timeout() {
    animation = false;
  }
  
  function pagination(direction) {
    animation = true;
    diff = 0;
    $slider.addClass('animation');
    $slider.css({
      'transform': 'translate3d(-' + ((curSlide - direction) * 100) + '%, 0, 0)'
    });
    
    $slider.find('.slide__darkbg').css({
        'transform': 'translate3d(' + ((curSlide - direction) * 50) + '%, 0, 0)'
    });
    
    $slider.find('.slide__letter').css({
        'transform': 'translate3d(0, 0, 0)',
    });
    
    $slider.find('.slide__text').css({
      'transform': 'translate3d(0, 0, 0)'
    });
  }
  
  function navigateRight() {
    if (!autoScrollVar) return;
    if (curSlide >= numOfSlides) return;
    pagination(0);
    setTimeout(timeout, animSpd);
    bullets(curSlide + 1);
    curSlide++;
  }
  
  function navigateLeft() {
    if (curSlide <= 1) return;
    pagination(2);
    setTimeout(timeout, animSpd);
    bullets(curSlide - 1);
    curSlide--;
  }

  function toDefault() {
    pagination(1);
    setTimeout(timeout, animSpd);
  }
  
  // Events
  jQuery(document).on('mousedown touchstart', '.slide', function(e) {
    if (animation) return;
    let target = +jQuery(this).attr('data-target');
    let startX = e.pageX || e.originalEvent.touches[0].pageX;
    $slider.removeClass('animation');
    
    jQuery(document).on('mousemove touchmove', function(e) {
      let x = e.pageX || e.originalEvent.touches[0].pageX;
      diff = startX - x;
      if (target === 1 && diff < 0 || target === numOfSlides && diff > 0) return;
      
      $slider.css({
        'transform': 'translate3d(-' + ((curSlide - 1) * 100 + (diff / 30)) + '%, 0, 0)'
      });

      $slider.find('.slide__darkbg').css({
        'transform': 'translate3d(' + ((curSlide - 1) * 50 + (diff / 60)) + '%, 0, 0)'
      });
      
      $slider.find('.slide__letter').css({
        'transform': 'translate3d(' +  (diff / 60) + 'vw, 0, 0)',
      });
      
      $slider.find('.slide__text').css({
        'transform': 'translate3d(' + (diff / 15) + 'px, 0, 0)'
      });

    })  
  })
  
  jQuery(document).on('mouseup touchend', function(e) {
    jQuery(document).off('mousemove touchmove');
    
    if (animation) return;
    
    if (diff >= distOfLetGo) {
      navigateRight();
    } else if (diff <= -distOfLetGo) {
      navigateLeft();
    } else {
      toDefault();
    }
  });
  
  jQuery(document).on('click', '.nav__slide:not(.nav-active)', function() {
    let target = +jQuery(this).attr('data-target');
    bullets(target);
    curSlide = target;
    pagination(1);
  }); 
  
  jQuery(document).on('click', '.ltx-side-nav', function() {
    let target = jQuery(this).attr('data-target');
    
    if (target === 'right') navigateRight();
    if (target === 'left') navigateLeft();
  });
  
  jQuery(document).on('keydown', function(e) {
    if (e.which === 39) navigateRight();
    if (e.which === 37) navigateLeft();
  });
  
  jQuery(document).on('mousewheel DOMMouseScroll', function(e) {
    if (animation) return;
    let delta = e.originalEvent.wheelDelta;
    
    if (delta > 0 || e.originalEvent.detail < 0) navigateLeft();
    if (delta < 0 || e.originalEvent.detail > 0) navigateRight();
  });
});