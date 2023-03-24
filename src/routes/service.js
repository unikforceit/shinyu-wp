import MoveTo from 'moveTo'
import imagesLoaded from 'imagesloaded'

export default {
  init() {},
  finalize() {
    const main = document.querySelector('.main-content')

    imagesLoaded(main, () => {
      const goto = document.querySelector(`#${main.dataset.id}`)
      if (goto) {
        const moveTo = new MoveTo({
          tolerance: 58,
          duration: 1200,
        })
        moveTo.move(goto)
      }
    })
  },
}
