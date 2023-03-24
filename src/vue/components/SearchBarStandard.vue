<template lang="pug">
  form(
    @submit.prevent="onSubmit"
    :class="{ 'show-advanced' : advancedSearch }"
  )
    .container
      .d-flex.justify-content-between
        b-field.field-transaction.d-flex.justify-content-between
          b-radio.mb-0.mr-4(
            v-model="form.transaction"
            name="transaction"
            native-value="sell"
            :class="{ 'is-active' : form.transaction === 'sell' }"
          ) 
            | {{ i18n.search.buy }}
            .rippleJS.d-lg-none

          b-radio.mb-0.mr-2(
            v-model="form.transaction"
            name="transaction"
            native-value="rent"
            :class="{ 'is-active' : form.transaction === 'rent' }"
          ) 
            | {{ i18n.search.rent }}
            .rippleJS.d-lg-none

        project-area-autocomplete.field-keyword(
          v-model="form.q"
          @selected="onProjectSelect"
          @input="onProjectInput"
        )

        b-field.field-location.d-none.d-lg-block
          b-select(
            placeholder="BTS / MRT"
            v-model="form.location"
          )
            option(value='') {{ form.location ? i18n.search.any : 'BTS / MRT' }}
            optgroup(label="BTS")
              option(
                v-for="(option, index) in fields.location.bts"
                :value="option.value"
                :key="index"
              ) {{ option.label }}

            optgroup(label="MRT")
              option(
                v-for="(option, index) in fields.location.mrt"
                :value="option.value"
                :key="index"
              ) {{ option.label }}

        b-field.field-price.d-none.d-lg-block
          b-select(v-model="form.price")
            option(value="") {{ form.price ? i18n.search.any : i18n.search.price }}
            option(
              v-for="(option, index) in price"
              :value="option.value"
              :key="index"
            ) {{ option.label }}

        b-field.field-bedroom.d-none.d-lg-block
          b-select(v-model="form.bedrooms")
            option(value="") {{ form.bedrooms ? i18n.search.any : i18n.search.bedroom }}
            option(
              v-for="(option, index) in fields.bedrooms"
              :value="option.value"
              :key="index"
              v-if="option.value"
            ) {{ option.label }}

        button.field-advanced.d-lg-none(
          type="button"
          @click="$store.commit('SET_SEARCH_ADVANCED', !advancedSearch)"
        )
          icon-filter
          span(v-if="advancedSearch") ปิด
          span(v-else) ตัวกรองเพิ่มเติม
          .rippleJS

        b-button.field-submit(
          type="is-danger"
          native-type="submit"
          :loading="isLloading"
        ) 
          .d-none.d-sm-block {{ i18n.search.search }}
          icon-search.d-sm-none

</template>

<script>
import { mapState } from 'vuex'
import ProjectAreaAutocomplete from '../components/ProjectAreaAutocomplete'
import IconSearch from '../icons/Search'
import IconFilter from '../icons/Filter'

export default {
  components: { ProjectAreaAutocomplete, IconSearch, IconFilter },
  data: () => ({
    i18n: SHINYU.i18n,
    isLloading: false,
    keyword: '',
    fields: SHINYU.field,
    form: {
      q: '',
      project_id: '',
      area_id: '',
      tag_id: '',
      location: '',
      price: '',
      bedrooms: '',
      transaction: 'sell',
    },
  }),

  computed: {
    ...mapState(['advancedSearch']),

    price() {
      let price

      if (this.form.transaction === 'sell') {
        price = this.fields.price_sell
      } else {
        price = this.fields.price_rent
      }

      this.form.price = ''

      return price
    }
  },

  methods: {
    onProjectSelect(option) {
      if (option) {
        this.form.bedrooms = ''
        this.form.price = ''
        this.form.location = ''
        this.form.q = option.title

        if (option.type === 'project') {
          this.form.project_id = option.id
          this.form.area_id = ''
          this.form.tag_id = ''

        } else if (option.type === 'tag') {
          this.form.tag_id = option.id
          this.form.area_id = ''
          this.form.project_id = ''
        } else {
          this.form.area_id = option.id
          this.form.project_id = ''
          this.form.tag_id = ''
        }
      }
    },

    onProjectInput(val) {
      this.form.project_name = val
    },

    onSubmit() {
      this.isLloading = true
      const url = new URL(SHINYU.search_url)
      url.searchParams.append('transaction', this.form.transaction)

      if (this.form.price) url.searchParams.append('price', this.form.price)
      if (this.form.location) url.searchParams.append('location', this.form.location)
      if (this.form.bedrooms) url.searchParams.append('bedrooms', this.form.bedrooms)
      if (this.form.project_id) url.searchParams.append('project_id', this.form.project_id)
      if (this.form.area_id) url.searchParams.append('area_id', this.form.area_id)
      if (this.form.tag_id) url.searchParams.append('tag_id', this.form.tag_id)
      if (this.form.q) url.searchParams.append('q', this.form.q)

      window.open(url, '_parent')
    },
  }
}
</script>
