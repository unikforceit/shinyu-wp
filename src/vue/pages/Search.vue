<template lang="pug">
.search-wrapper
  search-bar(@submit='onSubmit')
  .search-header
    .container.d-flex.justify-content-between
      .search-result-info.has-text-primary
        div
          span {{ i18n.search.found }}

          small.has-text-danger.px-3 {{ meta.total | formatMoney }}
          span {{ i18n.search.results }}
        //- template(v-if="meta.total > 12")
        //-   span แสดงผล
        //-   strong.has-text-danger  {{ pageNum * 12 - 11 | formatMoney }} - {{ Math.min(pageNum * 12, meta.total) | formatMoney  }}
        //-   span  จาก
        //-   strong.has-text-danger  {{ meta.total | formatMoney }}
        //-   span  รายการ

        //- template(v-else) 
        //-   span ผลการค้นหาพบ
        //-   strong.has-text-danger  {{ meta.total }}
        //-   span  รายการ

      .search-sort.d-none.d-sm-block
        .field
          .control.has-icons-left
            .select
              select(
                v-model='sort',
                @change='onSort',
                :disabled='meta.total < 2'
              )
                //- option(value="" disabled selected) เรียงตาม
                option(value='') {{ i18n.search.latest_update }}
                option(value='price_asc') {{ i18n.search.price_low_to_high }}
                option(value='price_desc') {{ i18n.search.price_high_to_low }}
            .icon.is-small.is-left
              icon-sort

  .search-body
    .container
      b-loading(:is-full-page='false', v-model='isLoading', :can-cancel='true')
      .columns.is-multiline.mb-0
        .column.unit-column.is-4-fullhd.is-6-tablet(
          v-for='(item, index) in units',
          :key='item.id'
        )
          unit-item(:unit='item', :type='query.transaction')

  .search-foter
    .container
      b-pagination.d-flex.justify-content-center(
        v-if='meta.total > 12',
        @change='onPagination',
        :total='meta.total',
        v-model='pageNum',
        :range-before='3',
        :range-after='3',
        :per-page='12',
        order='is-centered',
        aria-next-label='Next page',
        aria-previous-label='Previous page',
        aria-page-label='Page',
        aria-current-label='Current page'
      )
</template>

<script>
import axios from 'axios'
import MoveTo from 'moveTo'
import SearchBar from '../components/SearchBar.vue'
import UnitItem from '../components/UnitItem.vue'
import IconSort from '../icons/Sort.vue'
import lodash from 'lodash/object'

export default {
  components: { SearchBar, UnitItem, IconSort },
  data: () => ({
    i18n: SHINYU.i18n,
    units: [],
    meta: {},
    sort: '',
    pageNum: 1,
    isLoading: false,
    query: {},
  }),

  created() {
    this.query = Object.assign({}, this.$route.query)
    this.pageNum = this.$route.query.pagenum
      ? parseInt(this.$route.query.pagenum)
      : 1
    this.sort = this.$route.query.sort ?? ''
    this.query.transaction = this.query.transaction ?? 'sell'
  },

  // watch: {
  //   '$route': 'fetchData'
  // },

  mounted() {
    this.fetchData()
  },

  methods: {
    replaceQuery() {
      const query = lodash.pickBy(this.query, lodash.identity)
      this.$router.replace({ query }).catch(() => {})
    },

    onPagination() {
      this.query.pagenum = this.pageNum
      this.replaceQuery()
      this.fetchData(true)
    },

    onSort() {
      this.query.sort = this.sort
      this.replaceQuery()
      this.fetchData(false, true)
    },

    onSubmit(query) {
      this.query = query
      this.query.sort = this.sort
      this.replaceQuery()
      this.pageNum = 1
      this.fetchData(true)
    },

    fetchData(goTop = false, sort = false) {
      this.isLoading = true
      this.query.lang = SHINYU.lang

      // console.log(Object.assign({}, this.query))
      axios
        .get(`${SHINYU.api.url}shinyu/search`, {
          params: this.query,
        })
        .then(({ data }) => {
          this.units = data.data
          this.meta = data.meta
          this.isLoading = false
          this.$store.commit('SET_LOADING', false)
          // this.$store.commit('SET_SEARCH_ADVANCED', false)

          const menus = document.querySelectorAll('.navigation-item')

          menus.forEach((element) => {
            element.classList.remove('is-active')
            if (
              element.getAttribute('data-transaction') ===
              this.query.transaction
            ) {
              element.classList.add('is-active')
            }
          })

          if (goTop && window.innerWidth > 991) {
            setTimeout(() => {
              const moveTo = new MoveTo()
              moveTo.move(document.querySelector('.search-wrapper'))
            }, 100)
          }
        })
        .catch((error) => {
          this.isLoading = false
        })
    },
  },
}
</script>