import Vue from 'vue'
import ContactForm from '../vue/components/ContactForm.vue'

export default {
  init() {
    new Vue({
      el: '.main-content .contact-form',
      components: { ContactForm },
    })
  },
  finalize() {},
}
