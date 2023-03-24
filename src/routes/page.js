import Swiper from 'swiper/bundle'

export default {
  init() {
    const element = document.querySelector('.page-header__slider')

    if (element) {
      const swiper = new Swiper(element, {
        lazy: {
          loadPrevNext: true,
        },
        autoplay: {
          delay: 4000,
        },
        init: true,
        loop: true,
        effect: 'fade',
        speed: 400,
        autoHeight: true,
        grabCursor: true,
        spaceBetween: 0,
        pagination: {
          el: element.querySelector('.swiper-pagination'),
          clickable: true,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      })
    }
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
}
