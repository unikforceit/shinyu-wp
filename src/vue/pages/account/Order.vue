<template lang="pug">
div
  b-table(v-if='orders.length > 0', :data='orders')
    b-table-column(field='date', label='วันที่', v-slot='props')
      .tag.is-success {{ new Date(props.row.date_created.date).toLocaleDateString() }}

    b-table-column(
      field='id',
      label='รายการสั่งซื้อ',
      width='120px',
      v-slot='props'
    ) {{ `#${props.row.id}` }}

    b-table-column(field='items', label='รายการ', v-slot='props')
      ul.mt-0
        li(v-for='item in props.row.line_items', :key='item.id') {{ item.name }}

    b-table-column(
      field='total',
      label='ยอดรวม',
      width='100px',
      v-slot='props'
    ) THB {{ props.row.total | formatMoney }}

    b-table-column(
      field='status',
      label='สถานะ',
      width='100px',
      v-slot='props'
    ) {{ props.row.status }}

    b-table-column(field='action', label='ดำเนินการ', v-slot='props')
      b-button.px-3(type='is-primary', size='is-small', label='ดูรายละเอียด')
  .content(v-else) 
    p.p-3 ยังไม่มีรายการสั่งซื้อ
</template>

<script>
import { axiosNonce } from '../../config.js'
export default {
  data: () => ({
    i18n: SHINYU.i18n,
    orders: [],
  }),

  created() {
    axiosNonce
      .get(`${SHINYU.api.url}shinyu/user/order`, {
        params: '',
      })
      .then(({ data }) => {
        this.orders = data.data
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