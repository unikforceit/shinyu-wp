<template lang="pug">
div
  b-table(v-if='unit.length > 0', :data='unit')
    b-table-column(field='image', width='100', v-slot='props')
      img(:src='props.row.image_url')
    b-table-column(field='project', label='โครงการ', v-slot='props') {{ props.row.title }}

    b-table-column(field='for', label='สำหรับ', v-slot='props')
      span.pr-2(v-for='(item, index) in props.row.for') {{ item }}

    b-table-column(field='price', label='ราคา', v-slot='props')
      bdi.d-block.rent(v-if='props.row.price.rent')
        span.currency-symbol {{ currencyUnit }}
        span {{ props.row.price.rent | formatMoney }} / {{ i18n.month }}

      bdi.d-block.sell(v-if='props.row.price.sell')
        span.currency-symbol {{ currencyUnit }}
        span {{ props.row.price.sell | formatMoney }}

    //- b-table-column(field='action', label='ดำเนินการ', v-slot='props')
    //-   b-button.px-3(type='is-primary', size='is-small', label='ดูรายละเอียด')
  .content(v-else) 
    p.p-3 ยังไม่มีรายการ
</template>

<script>
import { axiosNonce } from '../../config'
export default {
  data: () => ({
    i18n: SHINYU.i18n,
    currencyUnit: SHINYU.currency.unit,
    unit: [],
    isLoading: false,
  }),

  mounted() {
    axiosNonce
      .get(`${SHINYU.api.url}shinyu/user/property`, {
        params: '',
      })
      .then(({ data }) => {
        this.unit = data.data
      })
      .catch((error) => {
        this.isLoading = false
      })
  },
}
</script>

<style lang="scss" scoped>
.content {
  font-size: 14px;
}
</style>