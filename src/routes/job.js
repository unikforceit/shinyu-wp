import Vue from 'vue'
// import axios from 'axios'
import VueRouter from 'vue-router'
import {
  ValidationObserver,
  ValidationProvider,
  extend,
  localize,
} from 'vee-validate'
import { required, email, min, confirmed } from 'vee-validate/dist/rules'

import ThaiAddressInput from 'vue-thai-address-input'
import AppHeader from '../vue/job/components/Header.vue'
import Register from '../vue/job/pages/Register.vue'
import Home from '../vue/job/pages/Home.vue'
// import th from 'vee-validate/dist/locale/th.json'
import store from '../vue/job/vuex/store'

const th = {
  code: 'th',
  messages: {
    alpha: '{_field_} ต้องเป็นตัวอักษรเท่านั้น',
    alpha_dash:
      '{_field_} สามารถมีตัวอักษร ตัวเลข เครื่องหมายขีดกลาง (-) และเครื่องหมายขีดล่าง (_)',
    alpha_num: '{_field_} ต้องเป็นตัวอักษร และตัวเลขเท่านั้น',
    alpha_spaces: '{_field_} ต้องเป็นตัวอักษร และช่องว่างเท่านั้น',
    between: '{_field_} ต้องเป็นค่าระหว่าง {min} และ {max}',
    confirmed: 'การยืนยันข้อมูลของ {_field_} ไม่ตรงกัน',
    digits: '{_field_} ต้องเป็นตัวเลขจำนวน {length} หลักเท่านั้น',
    dimensions: '{_field_} ต้องมีขนาด {width}x{height} px',
    email: '{_field_} ต้องเป็นรูปแบบอีเมล',
    excluded: '{_field_} ต้องเป็นค่าที่กำหนดเท่านั้น',
    ext: '{_field_} สกุลไฟล์ไม่ถูกต้อง',
    image: '{_field_} ต้องเป็นรูปภาพเท่านั้น',
    oneOf: '{_field_} ต้องเป็นค่าที่กำหนดเท่านั้น',
    integer: '{_field_} ต้องเป็นเลขจำนวนเต็ม',
    length: '{_field_} ต้องมีความยาว {length}',
    max: '{_field_} ต้องมีความยาวไม่เกิน {length} ตัวอักษร',
    max_value: '{_field_} ต้องมีค่าไม่เกิน {max}',
    mimes: '{_field_} ประเภทไฟล์ไม่ถูกต้อง',
    min: '{_field_} ต้องมีความยาวอย่างน้อย {length} ตัวอักษร',
    min_value: '{_field_} ต้องมีค่าตั้งแต่ {min} ขึ้นไป',
    numeric: '{_field_} ต้องเป็นตัวเลขเท่านั้น',
    regex: 'รูปแบบ {_field_} ไม่ถูกต้อง',
    required: 'กรุณากรอก {_field_}',
    required_if: 'กรุณากรอก {_field_}',
    size: '{_field_} ต้องมีขนาดไฟล์ไม่เกิน {size}KB',
    double: '{_field_} ต้องเป็นทศนิยมที่ถูกต้อง',
  },
}

export default {
  init() {
    const routes = [
      { path: '/', component: Home },
      { path: '/register', component: Register },
    ]

    const router = new VueRouter({
      routes,
    })

    Vue.use(VueRouter)
    Vue.use(ThaiAddressInput)

    extend('required', {
      ...required,
      message: 'โปรดกรอกฟิลด์นี้',
    })
    extend('email', { ...email, message: 'รูปแบบอีเมล์ไม่ถูกต้อง' })
    extend('min', min)
    extend('confirmed', confirmed)

    localize('th', th)

    Vue.component('ValidationProvider', ValidationProvider)
    Vue.component('ValidationObserver', ValidationObserver)

    new Vue({
      el: '#app',
      components: { AppHeader },
      store,
      data: {
        loading: false,
      },

      router,

      mounted() {},

      methods: {},
    })
  },
  finalize() {},
}
