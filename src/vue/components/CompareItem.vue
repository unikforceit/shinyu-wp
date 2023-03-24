<template lang="pug">
  .columns
    .column(:class="`is-${6 - compareItems.length}`")
      strong(v-if="label") {{ label }}

    .column
      .columns
        slot

</template>
<script>
import { mapState } from 'vuex'

export default {
  props: {
    label: {
      type: String,
      default: '',
    }
  },
  computed: {
    ...mapState(['compareItems']),
  },
}
</script>