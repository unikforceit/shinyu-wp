import Vue from 'vue'
import InspectionServiceForm from '../vue/components/InspectionServiceForm.vue'

export default {
  init() {
    new Vue({
      el: '.inspection-service-form',
      components: { InspectionServiceForm },
    })
  },
  finalize() {},
}
