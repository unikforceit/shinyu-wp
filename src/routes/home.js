import Swiper from 'swiper/bundle'
import imagesLoaded from 'imagesloaded'
import GLightbox from 'glightbox'
import Vue from 'vue'
import UnitSpecial from '../vue/components/UnitSpecial.vue'
import SearchBox from '../vue/components/SearchBox.vue'
import store from '../vue/store'

export default {
  init() {
    const slideshow = document.querySelector('.slideshow-swiper-container')
    const slideshowSwiper = new Swiper(slideshow, {
      lazy: {
        loadPrevNext: true,
      },
      autoplay: {
        delay: 4000,
      },
      effect: 'fade',
      init: false,
      loop: false,
      speed: 600,
      autoHeight: true,
      grabCursor: true,
      spaceBetween: 0,
      pagination: {
        el: slideshow.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: slideshow.querySelector('.next'),
        prevEl: slideshow.querySelector('.prev'),
      },
    })

    imagesLoaded(slideshow, () => {
      slideshowSwiper.init()
    })

    slideshowSwiper.on('init', (swiper) => {
      setTimeout(() => {
        document.querySelector('.slideshow').classList.remove('is-loading')
      }, 400)
    })

    const project = document.querySelectorAll('.project-swiper-container')

    project.forEach((element) => {
      new Swiper(element, {
        lazy: {
          loadPrevNext: true,
        },
        autoplay: {
          delay: 4000,
        },
        effect: 'fade',
        init: true,
        loop: false,
        speed: 600,
        // autoHeight: true,
        grabCursor: true,
        spaceBetween: 6,
        pagination: {
          el: element.querySelector('.swiper-pagination'),
          clickable: true,
        },
      })
    })

    const news = document.querySelector('.news-swiper-container')
    const newsSwiper = new Swiper(news, {
      // lazy: {
      //   loadPrevNext: true,
      // },
      lazy: true,
      slidesPerView: 2,
      slidesPerGroup: 2,
      spaceBetween: 16,
      // autoplay: {
      //   delay: 4000,
      // },
      init: true,
      loop: false,
      speed: 600,
      autoHeight: true,
      pagination: {
        el: news.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: news.querySelector('.next'),
        prevEl: news.querySelector('.prev'),
      },
      breakpoints: {
        768: {
          slidesPerView: 3,
          slidesPerGroup: 3,
          spaceBetween: 30,
        },
      },
    })

    new Vue({
      el: '.search-box',
      components: { SearchBox },
      mounted() {},
      methods: {},
    })

    new Vue({
      el: '.unit-special-app',
      components: { UnitSpecial },
      store,
    })
  },

  finalize() {
    const lightbox = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
    })
  },
}
