import Vue from 'vue'
import MoveTo from 'moveTo'
import ManagementForm from '../vue/components/ManagementForm.vue'

export default {
  init() {
    const buttons = document.querySelectorAll('.management-plan .button')

    buttons.forEach((element) => {
      element.addEventListener('click', (e) => {
        e.preventDefault()
        const packageSelect = document.querySelector('#package')
        packageSelect.value = e.target.dataset.id
        packageSelect.dispatchEvent(new Event('change'))

        const moveTo = new MoveTo({
          tolerance: 0,
          duration: 800,
        })
        moveTo.move(document.querySelector('.management-deposit'))
      })
    })

    new Vue({
      el: '.management-form',
      components: { ManagementForm },
    })
  },
  finalize() {},
}
