/* eslint-disable prefer-destructuring */
/* eslint-disable no-multi-assign */
/* eslint-disable prefer-spread */
/* eslint-disable prefer-rest-params */
/* eslint-disable no-underscore-dangle */
/* eslint-disable no-unused-expressions */
import WebFont from 'webfontloader'
import enterView from 'enter-view'
import imagesLoaded from 'imagesloaded'
import Swiper from 'swiper/bundle'
import MoveTo from 'moveTo'
import Vue from 'vue'

import Analytics from 'analytics'
// import googleTagManager from '@analytics/google-tag-manager'
import googleAnalytics from '@analytics/google-analytics'

import Subscribe from '../vue/components/Subscribe.vue'
import CompareSelected from '../vue/components/CompareSelected.vue'
import TrainStation from '../vue/components/TrainStation.vue'
import SearchBar from '../vue/components/SearchBarStandard.vue'

import store from '../vue/store'

const { body, documentElement } = document
const hamburger = body.querySelector('.hamburger-menu')
const currencies = body.querySelectorAll('.currency-switcher a')
const DEV = process.env.NODE_ENV === 'development'

function WebpIsSupported(callback) {
  // If the browser doesn't has the method createImageBitmap, you can't display webp format
  if (!window.createImageBitmap) {
    callback(false)
    return
  }

  // Base64 representation of a white point image
  const webpdata =
    'data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoCAAEAAQAcJaQAA3AA/v3AgAA='

  // Retrieve the Image in Blob Format
  fetch(webpdata)
    .then(function (response) {
      return response.blob()
    })
    .then(function (blob) {
      // If the createImageBitmap method succeeds, return true, otherwise false
      createImageBitmap(blob).then(
        function () {
          callback(true)
        },
        function () {
          callback(false)
        }
      )
    })
}

export default {
  init() {
    const setCookie = function setCookie(cname, cvalue, exdays) {
      const d = new Date()
      d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000)
      const expires = `expires=${d.toUTCString()}`
      document.cookie = `${cname}=${cvalue};${expires};path=/`
    }

    const analytics = Analytics({
      app: 'awesome-app',
      plugins: [
        googleAnalytics({
          trackingId: 'UA-181011445-1',
        }),
        // googleTagManager({
        //   containerId: '',
        // }),
      ],
    })

    analytics.page()

    WebFont.load({
      google: {
        families: [
          'Prompt:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i&display=swap&subset=thai',
        ],
      },
    })

    WebpIsSupported((isSupported) => {
      if (isSupported) {
        documentElement.classList.add('webp')
      } else {
        documentElement.classList.add('no-webp')
      }
    })

    hamburger.addEventListener('click', (e) => {
      e.preventDefault()
      documentElement.classList.toggle('open-menu')
    })

    new Vue({
      el: '.subscribe',
      components: { Subscribe },
    })

    new Vue({
      el: '.compare-selected',
      components: { CompareSelected },
      store,
    })

    new Vue({
      el: '.train-station',
      components: { TrainStation },
    })

    if (
      !document.body.classList.contains('search') &&
      !document.body.classList.contains('woocommerce-cart') &&
      !document.body.classList.contains('woocommerce-checkout')
    ) {
      new Vue({
        el: '.search-bar',
        components: { SearchBar },
        store,
      })
    }

    const partner = document.querySelector('.partner-swiper-container')
    if (partner) {
      const partnerSwiper = new Swiper(partner, {
        // lazy: {
        //   loadPrevNext: true,
        // },
        lazy: true,
        slidesPerView: 5,
        slidesPerGroup: 5,
        autoplay: {
          delay: 4000,
        },
        init: true,
        loop: false,
        speed: 600,
        autoHeight: true,
        spaceBetween: 32,
        pagination: {
          el: partner.querySelector('.swiper-pagination'),
          clickable: true,
        },
        navigation: {
          nextEl: partner.querySelector('.next'),
          prevEl: partner.querySelector('.prev'),
        },
      })
    }

    const navigation = document.querySelector('.navigation.scrollspy')
    if (navigation) {
      imagesLoaded(document.body, (instance) => {
        const moveTo = new MoveTo({
          tolerance: 58,
          duration: 800,
        })

        const triggers = document.querySelectorAll('.navigation a')
        for (let i = 0; i < triggers.length; i++) {
          moveTo.registerTrigger(triggers[i])
        }

        const sections = document.querySelectorAll('.main-content section')
        const menuLinks = document.querySelectorAll('.navigation a')

        const makeActive = (link) => menuLinks[link].classList.add('active')
        const removeActive = (link) =>
          menuLinks[link].classList.remove('active')

        const removeAllActive = () =>
          [...Array(sections.length).keys()].forEach((link) =>
            removeActive(link)
          )
        const sectionMargin = 0

        let currentActive = 0

        window.addEventListener('scroll', () => {
          const current =
            sections.length -
            [...sections]
              .reverse()
              .findIndex(
                (section) => window.scrollY >= section.offsetTop - sectionMargin
              ) -
            1

          if (current !== currentActive) {
            removeAllActive()
            currentActive = current
            makeActive(current)
          }
        })

        enterView({
          selector: '.navigation',
          enter: (el) => {
            navigation.classList.add('is-sticky')
          },
          offset: 1,
          exit: (el) => {
            navigation.classList.remove('is-sticky')
          },
        })
      })
    }

    currencies.forEach((element) => {
      element.addEventListener('click', (e) => {
        e.preventDefault()
        setCookie('currency', element.dataset.code, 100)
        window.location.reload()
      })
    })
  },
  finalize() {
    window.onload = () => {
      window.fbAsyncInit = function () {
        FB.init({
          appId: DEV ? '613169022972250' : '2936478359953744',
          autoLogAppEvents: true,
          xfbml: true,
          version: 'v9.0',
        })
      }
      ;(function (d, s, id) {
        const fjs = d.getElementsByTagName(s)[0]
        if (d.getElementById(id)) {
          return
        }
        const js = d.createElement(s)
        js.id = id
        js.src = `https://connect.facebook.net/${SHINYU.lang_code}/sdk/xfbml.customerchat.js`
        fjs.parentNode.insertBefore(js, fjs)
      })(document, 'script', 'facebook-jssdk')

      !(function (f, b, e, v, n, t, s) {
        if (f.fbq) return
        n = f.fbq = function () {
          n.callMethod
            ? n.callMethod.apply(n, arguments)
            : n.queue.push(arguments)
        }
        if (!f._fbq) f._fbq = n
        n.push = n
        n.loaded = !0
        n.version = '2.0'
        n.queue = []
        t = b.createElement(e)
        t.async = !0
        t.src = v
        s = b.getElementsByTagName(e)[0]
        s.parentNode.insertBefore(t, s)
      })(
        window,
        document,
        'script',
        'https://connect.facebook.net/en_US/fbevents.js'
      )
      fbq('init', '739530643381377')
      fbq('track', 'PageView')
    }

    if (
      !body.classList.contains('search') &&
      !body.classList.contains('page-template-template-about') &&
      !body.classList.contains('single-room') &&
      !body.classList.contains('single-product') &&
      !body.classList.contains('woocommerce-checkout') &&
      !body.classList.contains('woocommerce-cart') &&
      !body.classList.contains('page-template-template-account')
    ) {
      // element
      imagesLoaded(document.body, (instance) => {
        // enterView({
        //   selector: '.main-content',
        //   enter: (el) => {
        //     body.classList.add('header-sticky')
        //   },
        //   offset: 1,
        //   exit: (el) => {
        //     body.classList.remove('header-sticky')
        //   },
        // })

        let scrollPos = 0
        let timeout

        window.addEventListener('scroll', () => {
          // if (body.scrollHeight < 2000) return
          // console.log(body.getBoundingClientRect().top)

          if (body.getBoundingClientRect().top < 0) {
            body.classList.add('header-hide')
            body.classList.add('header-sticky')
          } else {
            body.classList.remove('header-hide')
            body.classList.remove('header-sticky')
          }

          if (body.getBoundingClientRect().top > scrollPos) {
            body.classList.add('scrollup')
          } else if (body.getBoundingClientRect().top < scrollPos) {
            body.classList.remove('scrollup')
          }

          clearTimeout(timeout)

          timeout = setTimeout(function () {
            scrollPos = body.getBoundingClientRect().top
          }, 100)

          // console.log(scrollPos)
        })
      })
    } else {
      const searchBar = body.querySelector('.search-bar')
      window.addEventListener('scroll', () => {
        if (body.getBoundingClientRect().top < -83) {
          searchBar.classList.add('is-sticky')
        } else {
          searchBar.classList.remove('is-sticky')
        }
      })
    }
  },
}
