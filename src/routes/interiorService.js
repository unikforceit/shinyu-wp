import Vue from 'vue'
import GLightbox from 'glightbox'
import InteriorForm from '../vue/components/InteriorServiceForm.vue'

export default {
  init() {
    new Vue({
      el: '.interior-service-form',
      components: { InteriorForm },
    })
  },
  finalize() {
    const items = document.querySelectorAll('.interior-work-item ')

    items.forEach((element) => {
      const gLightbox = GLightbox({
        touchNavigation: true,
        loop: true,
        elements: JSON.parse(element.dataset.images),
      })

      const thumbs = element.querySelectorAll('a')

      thumbs.forEach((thumb) => {
        thumb.addEventListener('click', (e) => {
          e.preventDefault()
          gLightbox.openAt(thumb.dataset.id)
        })
      })
    })
  },
}
