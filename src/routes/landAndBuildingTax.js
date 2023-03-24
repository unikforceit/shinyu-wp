import Vue from 'vue'
import LandAndBuildingTaxForm from '../vue/components/LandAndBuildingTaxForm.vue'

export default {
  init() {
    new Vue({
      el: '.land-and-building-tax-form',
      components: { LandAndBuildingTaxForm },
    })
  },
  finalize() {},
}
