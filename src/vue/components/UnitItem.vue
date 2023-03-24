<template lang="pug">
.card.unit-item(:class='type', :id='`unit-${unit.id}`')
  .card-image.unit-image
    swiper(:options='swiperOptions')
      swiper-slide(v-for='(image, index) in unit.images', :key='index')
        img.swiper-lazy(:data-src='image | webp')

    .swiper-navigation
      button.prev Prev
      button.next Next

    .unit-badge.d-flex(v-if='unit.badge.length > 0')
      span.unit-badge-item(v-for='(item, index) in unit.badge', :key='index') {{ item }}

    .unit-action
      b-button(
        @click='addToCompare(unit.id)',
        :class='{ "is-selected": selected }'
      )
        b-tooltip(
          :label='selected ? "Delete form compare" : "Add to compare"',
          :square='true',
          type='is-danger'
        )
          icon-compare

    ul.unit-for.d-flex
      li(v-for='(item, index) in unit.for', :key='')
        span(v-if='item === "rent"', :class='item') {{ i18n.lease }}
        span(v-else, :class='item') {{ i18n.sales }}

  .card-content.is-relative
    h4.unit-title
      a(:href='unit.link', :target='target') {{ unit.title }}
      small {{ unit.project }}

    .unit-location(v-if='unit.area')
      icon-location.unit-location-icon
      span {{ unit.area }}

    ul.unit-info
      li(v-if='unit.info.bedrooms')
        b-tooltip(:label='i18n.bedroom', :square='true', type='is-danger')
          icon-bed
          span {{ unit.info.bedrooms }}

      li(v-if='unit.info.bathrooms')
        b-tooltip(:label='i18n.bathroom', :square='true', type='is-danger')
          icon-bathroom
          span {{ unit.info.bathrooms }}

      li.area(v-if='unit.info.area_sqm')
        b-tooltip(:label='i18n.usable_area', :square='true', type='is-danger')
          icon-fullscreen
          span {{ unit.info.area_sqm }} {{ i18n.sqm }}

  .card-footer.unit-footer
    .unit-price
      template(v-if='type')
        bdi.d-block.rent(v-if='unit.price.rent && type === "rent"')
          span {{ i18n.rent }}
          span.currency-symbol {{ currencyUnit }}
          span {{ unit.price.rent | formatMoney }} / {{ i18n.month }}

        bdi.d-block.sell(v-if='unit.price.sell && type === "sell"')
          span {{ i18n.buy }}
          span.currency-symbol {{ currencyUnit }}
          span {{ unit.price.sell | formatMoney }}

      template(v-else)
        bdi.d-block.rent(v-if='unit.price.rent')
          span {{ i18n.rent }}
          span.currency-symbol {{ currencyUnit }}
          span {{ unit.price.rent | formatMoney }} / {{ i18n.month }}

        bdi.d-block.sell(v-if='unit.price.sell')
          span {{ i18n.buy }}
          span.currency-symbol {{ currencyUnit }}
          span {{ unit.price.sell | formatMoney }}
</template>

<script>
import _ from 'lodash/array'
import { mapState } from 'vuex'
import IconLocation from '../icons/Location'
import IconBed from '../icons/Bed'
import IconBathroom from '../icons/Bathroom'
import IconFullscreen from '../icons/Fullscreen'
import IconCompare from '../icons/Compare'
import ModalLoginAndRegister from './ModalLoginAndRegister'
// this.$store.commit('SET_COMPARE', this.form)
export default {
  components: {
    IconLocation,
    IconBed,
    IconBathroom,
    IconFullscreen,
    IconCompare,
  },
  props: {
    unit: {
      type: Object,
      default: () => {},
    },
    type: {
      type: String,
      default: '',
    },
    target: {
      type: String,
      default: '_blank',
    },
  },

  data() {
    return {
      i18n: SHINYU.i18n,
      currencyUnit: SHINYU.currency.unit,
      swiperOptions: {
        loop: false,
        preloadImages: false,
        lazy: {
          loadPrevNext: true,
        },
        // preloadImages: false,
        // lazy: true,
        // effect: 'fade',
        speed: 800,
        slidesPerView: 1,
        // autoHeight: true,
        spaceBetween: 0,
        navigation: {
          nextEl: `#unit-${this.unit.id} .next`,
          prevEl: `#unit-${this.unit.id} .prev`,
        },
        pagination: {
          el: '.banner-pagination',
          type: 'bullets',
          clickable: true,
        },
      },
    }
  },

  computed: {
    ...mapState(['compareItems']),
    selected() {
      return this.compareItems.includes(this.unit.id)
    },
  },

  methods: {
    onLogin() {
      this.$buefy.modal.open({
        parent: this,
        component: ModalLoginAndRegister,
        hasModalCard: true,
        trapFocus: true,
      })
    },

    addToCompare(id) {
      let items = this.compareItems
      let message = 'Add item to compare successfully'

      if (this.compareItems.includes(id)) {
        items = _.remove(items, (n) => {
          return n !== id
        })
        message = 'Delete item form compare successfully'
      } else {
        if (items.length > 3) {
          this.$buefy.dialog.confirm({
            title: 'Confirmation',
            message: 'คุณต้องการเพิ่มยูนิตนี้แทนยูนิตเปรียบเทียบล่าสุดหรือไม่?',
            onConfirm: () => {
              items = _.dropRight(items)
              items.push(id)
              this.$store.commit('SET_COMPARE', items)
              return
            },
          })
        } else {
          items.push(id)
        }
      }
      this.$store.commit('SET_COMPARE', items)
    },
  },
}
</script>
