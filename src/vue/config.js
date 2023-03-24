import WooCommerceRestApi from '@woocommerce/woocommerce-rest-api'
import axiosInstance from 'axios'

const WooCommerce = new WooCommerceRestApi({
  url: SHINYU.siteurl,
  wpAPIPrefix: 'api',
  consumerKey: 'ck_2b7314d240e7b84b7f4a79347f2f86a576dd19de',
  consumerSecret: 'cs_765a44aea6d991a1f9448228276c5f1fb2e9d4bd',
  version: 'wc/v3',
  axiosConfig: {
    headers: {
      'X-WP-Nonce': SHINYU.api.nonce,
    },
  },
})

const axios = axiosInstance.create({
  baseURL: SHINYU.api.url,
  headers: {
    'X-WP-Nonce': SHINYU.api.nonce,
  },
  // withCredentials: true
})

export { WooCommerce, axios }
export default axios
