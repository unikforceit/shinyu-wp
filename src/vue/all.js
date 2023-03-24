import Vue from 'vue'
import Buefy from 'buefy'
import VueRouter from 'vue-router'
import {
  ValidationObserver,
  ValidationProvider,
  extend,
  localize,
} from 'vee-validate'

import {
  required,
  email,
  min,
  max,
  numeric,
  confirmed,
} from 'vee-validate/dist/rules'

import { library } from '@fortawesome/fontawesome-svg-core'
// internal icons
import {
  faCheck,
  faCheckCircle,
  faInfoCircle,
  faExclamationTriangle,
  faExclamationCircle,
  faArrowUp,
  faAngleRight,
  faAngleLeft,
  faAngleDown,
  faEye,
  faEyeSlash,
  faCaretDown,
  faCaretUp,
  faUpload,
  faEdit,
  faUser,
} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
  Swiper as SwiperClass,
  Pagination,
  Navigation,
  Mousewheel,
  Scrollbar,
  Autoplay,
  EffectFade,
  Controller,
  Lazy,
  Thumbs,
} from 'swiper/swiper.esm'
import getAwesomeSwiper from 'vue-awesome-swiper/dist/exporter'

library.add(
  faCheck,
  faCheckCircle,
  faInfoCircle,
  faExclamationTriangle,
  faExclamationCircle,
  faArrowUp,
  faAngleRight,
  faAngleLeft,
  faAngleDown,
  faEye,
  faEyeSlash,
  faCaretDown,
  faCaretUp,
  faUpload,
  faEdit,
  faUser
)
Vue.component('vue-fontawesome', FontAwesomeIcon)

Vue.use(Buefy, {
  defaultIconComponent: 'vue-fontawesome',
  defaultIconPack: 'fas',
})

Vue.use(VueRouter)

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
    max: '{_field_} ต้องมีความยาวไม่เกิน {length}',
    max_value: '{_field_} ต้องมีค่าไม่เกิน {max}',
    mimes: '{_field_} ประเภทไฟล์ไม่ถูกต้อง',
    min: '{_field_} ต้องมีความยาวอย่างน้อย {length}',
    min_value: '{_field_} ต้องมีค่าตั้งแต่ {min} ขึ้นไป',
    numeric: '{_field_} ต้องเป็นตัวเลขเท่านั้น',
    regex: 'รูปแบบ {_field_} ไม่ถูกต้อง',
    required: 'กรุณากรอก {_field_}',
    required_if: 'กรุณากรอก {_field_}',
    size: '{_field_} ต้องมีขนาดไฟล์ไม่เกิน {size}KB',
    double: '{_field_} ต้องเป็นทศนิยมที่ถูกต้อง',
  },
}

extend('required', {
  ...required,
  message: 'โปรดกรอกฟิลด์นี้',
})
extend('max', max)
extend('min', min)
extend('numeric', numeric)
extend('confirmed', confirmed)
extend('email', { ...email, message: 'รูปแบบอีเมล์ไม่ถูกต้อง' })
localize('th', th)

Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)

// Swiper modules
SwiperClass.use([
  Pagination,
  Navigation,
  Mousewheel,
  Scrollbar,
  Autoplay,
  EffectFade,
  Controller,
  Lazy,
  Thumbs,
])

// -------------------------------------------------

// Global use
Vue.use(getAwesomeSwiper(SwiperClass))

// -------------------------------------------------

// Or local component
const { Swiper, SwiperSlide } = getAwesomeSwiper(SwiperClass)
export default {
  components: {
    Swiper,
    SwiperSlide,
  },
}
