import Vue from 'vue'
import numeral from 'numeral'
import webp from 'v-webp'

const DEV = process.env.NODE_ENV === 'development'

Vue.filter('formatMoney', (val) => {
  return numeral(val).format('0,0')
})

Vue.filter('webp', (url) => {
  // if (webp.isSupportWebp && !DEV) {
  //   url = url.replace('wp-content/uploads', 'wp-content/uploads-webpc/uploads')
  //   return `${url}.webp`
  // }
  return url
})
