import Swiper from 'swiper/bundle'
import GLightbox from 'glightbox'
// import FsLightbox from 'fslightbox'

import { Loader } from 'google-maps'
import Vue from 'vue'

import store from '../vue/store'
import UnitRecommended from '../vue/components/UnitRecommended.vue'
import UnitRegistrationForm from '../vue/components/UnitRegistrationForm.vue'
// import '../vue/filters'

function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (let i = 0; i < results.length; i++) {
      console.log(results[i])
    }
  }
}

export default {
  init() {
    const gallery = document.querySelector('.gallery-swiper-container')
    if (gallery) {
      const gallerySwiper = new Swiper(gallery, {
        lazy: {
          loadPrevNext: true,
        },
        // autoplay: {
        //   delay: 4000,
        // },
        init: true,
        loop: true,
        speed: 600,
        centeredSlides: true,
        slidesPerView: 'auto',
        grabCursor: false,
        spaceBetween: 0,
        pagination: {
          el: gallery.querySelector('.unit-gallery-pagination'),
          type: 'fraction',
        },
        navigation: {
          nextEl: gallery.querySelector('.next'),
          prevEl: gallery.querySelector('.prev'),
        },
      })
    }

    new Vue({
      el: '.unit-recommended-list',
      components: { UnitRecommended },
      store,
    })

    new Vue({
      el: '.unit-registration-form',
      components: { UnitRegistrationForm },
    })
  },

  finalize() {
    const wrap = document.querySelector('.unit-map')
    // const options = LoaderOptions({
    //   libraries: ['places'],
    // })

    const loader = new Loader('AIzaSyCR8TYrZjwXbLjQETTQd2pvayAcg4vMWwM', {
      libraries: ['places'],
    })
    const lat = parseFloat(wrap.dataset.lat, 10)
    const lng = parseFloat(wrap.dataset.lng, 10)

    loader.load().then((google) => {
      const map = new google.maps.Map(
        document.querySelector('.unit-google-map'),
        {
          center: { lat, lng },
          zoom: 12,
        }
      )

      const panorama = new google.maps.StreetViewPanorama(
        document.querySelector('.unit-google-pano'),
        {
          position: { lat, lng },
          pov: {
            heading: 34,
            pitch: 10,
          },
        }
      )

      map.setStreetView(panorama)

      const marker = new google.maps.Marker({
        map,
        draggable: false,
        // icon: SHINYU.marker,
        position: { lat, lng },
      })

      google.maps.event.addListener(marker, 'click', () => {
        window.open('https://goo.gl/maps/ETYSvZxACupgtRkd7')
      })

      // const service = new google.maps.places.PlacesService(map)
      // service.nearbySearch(
      //   {
      //     location: { lat, lng },
      //     radius: 5500,
      //     type: ['bts'],
      //   },
      //   callback
      // )
    })

    // const lightbox = new FsLightbox()

    const lightbox = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
    })
  },
}
