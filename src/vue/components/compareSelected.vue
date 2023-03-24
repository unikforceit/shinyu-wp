<template lang="pug">
  a(v-if="compareItems.length > 0" :href="`${url}`")
    b-tooltip(label="เปรียบเทียบ" :square="true" type="is-danger" position="is-left")
      icon-compare
      span.compare-count {{ compareItems.length }}
</template>

<script>
import { mapState } from 'vuex'
import IconCompare from '../icons/Compare'
export default {
  data: () => ({
    url: SHINYU.compare_url
  }),
  components: { IconCompare },
  computed: {
    ...mapState(['compareItems']),
  },
}
</script>