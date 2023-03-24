<template lang="pug">
  .compare
    .columns
      b-loading(:is-full-page="false" v-model="isLoading" :can-cancel="true")
      .column(v-if="compareItems.length > 0")

        compare-item()
          .column(
            v-for="(id, index) in unit.id"
            :key="index"
          )
            button.button.is-small.pl-2.pr-2(@click="onDelete(id)") ลบ

        compare-item(label="ชื่อโครงการ")
          .column(
            v-for="(project, index) in unit.project"
            :key="index"
          )
            strong {{ project }}

        hr

        compare-item
          .column(
            v-for="(image, index) in unit.image"
            :key="index"
          )
            img(:src="image")

        hr


        compare-item(label="ราคา")
          .column(
                v-for="(price, index) in unit.price"
                :key="index"
          )
            bdi.d-block(v-if="price.rent").rent
              span {{ i18n.rent }}
              span.currency-symbol  {{ currencyUnit }}
              span {{ price.rent | formatMoney }} / {{ i18n.month }}  

            bdi.d-block(v-if="price.sell").sell
              span {{ i18n.buy }}
              span.currency-symbol  {{ currencyUnit }}
              span {{ price.sell | formatMoney }}

        hr

        compare-item(:label="`${i18n.usable_area} (${i18n.sqm})`")
          .column(
            v-for="(sqm, index) in unit.sqm"
            :key="index"
          )
            span {{ sqm }}

        hr

        compare-item(:label="i18n.bedroom")
          .column(
            v-for="(bedroom, index) in unit.bedroom"
            :key="index"
          )
            span {{ bedroom }}

        hr

        compare-item(:label="i18n.bathroom")
          .column(
            v-for="(bathroom, index) in unit.bathroom"
            :key="index"
          )
            span {{ bathroom }}

        hr

        compare-item(label="สิ่งอำนวยความสะดวก")
          .column(
            v-for="(facility, index) in unit.facility"
            :key="index"
          )
            ul.compare-facility
              li(v-for="(item, index) in facility")
                icon-tick
                span {{ item }}

        hr        

        compare-item()
          .column(
            v-for="(link, index) in unit.link"
            :key="index"
          )
            a.button.is-primary.pl-3.pr-3(
              :href="link"
              target="_blank"
            ) ดูรายละเอียด
 

      .column(
        v-if="compareItems.length < 4"
        :class="{'is-3' : compareItems.length === 3, 'is-5' : compareItems.length === 2, 'is-7' : compareItems.length === 1}"
      )
        a.add-unit(:href="searchURL")
          icon-plus
          span เพิ่มยูนิตเพื่อเปรียบเทียบ

</template>
<script>
import { mapState } from 'vuex'
import axios from 'axios'
import IconPlus from '../icons/Plus2'
import IconTick from '../icons/Tick'
import CompareItem from '../components/CompareItem.vue'

export default {
  components: { IconPlus, CompareItem, IconTick },
  data: () => ({
    isLoading: false,
    unit: {},
    searchURL: SHINYU.search_url,
    i18n: SHINYU.i18n,
    currencyUnit: SHINYU.currency.unit,
  }),

  computed: {
    ...mapState(['compareItems']),
  },

  mounted() {
    this.fetchData()
  },

  methods: {
    fetchData() {
      this.isLoading = true

      axios
        .get(`${SHINYU.api.url}shinyu/compare`, {
          params: {
            'unit': this.compareItems,
            'lang': SHINYU.lang
          }
        })
        .then(({ data }) => {
          this.unit = data.data
        })
        .catch(error => {
        })
        .then(() => {
          this.isLoading = false
        })
    },
    
    onDelete(item) {
      this.$store.commit('SET_COMPARE', this.compareItems.filter(e => e !== item))
      this.fetchData()
    }
  }
}
</script>