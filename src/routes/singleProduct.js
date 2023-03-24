import Vue from 'vue'
import StickySidebar from 'sticky-sidebar'
import imagesLoaded from 'imagesloaded'
import GLightbox from 'glightbox'
import InteriorForm from '../vue/components/InteriorServiceForm.vue'

const { body } = document
export default {
  init() {
    new Vue({
      el: '.interior-service-form',
      components: { InteriorForm },
    })

    if (
      !body.classList.contains('management-service') &&
      !body.classList.contains('page-template-template-about') &&
      !body.classList.contains('page-template-template-account')
    ) {
      imagesLoaded(body, () => {
        const sidebar = new StickySidebar('.product-sidebar', {
          topSpacing: 30,
          bottomSpacing: 50,
        })
      })
    }
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
