import Swiper from 'swiper/bundle'
import GLightbox from 'glightbox'

export default {
  init() {
    const testimonial = document.querySelector('.testimonial-swiper-container')
    new Swiper(testimonial, {
      slidesPerView: 3,
      autoplay: {
        delay: 4000,
      },
      loop: true,
      speed: 600,
      autoHeight: true,
      spaceBetween: 20,
      centeredSlides: true,
      pagination: {
        el: testimonial.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: testimonial.querySelector('.next'),
        prevEl: testimonial.querySelector('.prev'),
      },
    })
  },

  finalize() {
    GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
    })
  },
}
