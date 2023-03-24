import Swiper from 'swiper/bundle'

export default {
  init() {
    const element = document.querySelector('.blog-gallery ')

    if (element) {
      const swiper = new Swiper(element, {
        lazy: {
          loadPrevNext: true,
        },
        autoplay: {
          delay: 4000,
        },
        init: true,
        loop: false,
        speed: 600,
        autoHeight: true,
        grabCursor: true,
        spaceBetween: 6,
        pagination: {
          el: element.querySelector('.swiper-pagination'),
          clickable: true,
          // type: 'progressbar'
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
