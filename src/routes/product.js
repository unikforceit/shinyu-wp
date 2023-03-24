import StickySidebar from 'sticky-sidebar'
import imagesLoaded from 'imagesloaded'

const { body } = document

export default {
  init() {
    if (
      !body.classList.contains('management-service') &&
      !body.classList.contains('land-and-building-tax')
    ) {
      imagesLoaded(body, () => {
        const sidebar = new StickySidebar('.product-sidebar', {
          topSpacing: 30,
          bottomSpacing: 50,
        })
      })
    }
  },

  finalize() {},
}
