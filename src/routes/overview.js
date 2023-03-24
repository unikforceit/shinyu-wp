import Swiper from 'swiper/bundle'

export default {
  init() {
    const event = document.querySelector('.important-event-swiper')
    const year = document.querySelector('.important-event-year-swiper')

    if (event) {
      const yearSwiper = new Swiper(year, {
        speed: 400,
        // centeredSlides: true,
        slidesPerView: 8,
        grabCursor: true,
        freeMode: false,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        mousewheel: true,
        navigation: {
          nextEl: year.querySelector('.swiper-button-next'),
          prevEl: year.querySelector('.swiper-button-prev'),
        },
      })

      const eventSwiper = new Swiper(event, {
        lazy: {
          loadPrevNext: true,
        },
        speed: 400,
        grabCursor: true,
        spaceBetween: 0,
        thumbs: {
          swiper: yearSwiper,
        },
      })
    }
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
}
