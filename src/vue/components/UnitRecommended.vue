<template lang="pug">
.columns
  .column.is-4(v-for='(item, index) in units', :key='item.id')
    unit-item(:unit='item', target='_self')
</template>

<script>
import axios from 'axios'
import UnitItem from './UnitItem.vue'
export default {
  components: { UnitItem },
  data: () => ({
    units: [],
  }),
  mounted() {
    axios.get(`${SHINYU.api.url}shinyu/unit/recommended`).then((response) => {
      this.units = response.data.data
    })
  },
}
</script>