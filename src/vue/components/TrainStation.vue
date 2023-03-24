<template lang="pug">
  div
    b-collapse.card(:open="false" animation="slide" aria-id="mrt")
      button.button.is-primary.is-inverted(
        slot="trigger"
        slot-scope="props"
        aria-controls="mrt"
        :class="props.open ? 'is-active' : ''"
      ) MRT
      ul
        li(v-for="(item, index) in location.mrt" :key="index")
          a(:href="`${searchURL}?transaction=rent&location=${item.slug}`") {{ item.name }}

    b-collapse.card(animation="slide" aria-id="bts")
      button.button.is-primary.is-inverted(
        slot="trigger"
        slot-scope="props"
        herf="#"
        aria-controls="bts"
        :class="props.open ? 'is-active' : ''"
      ) BTS
      ul
        li(v-for="(item, index) in location.bts" :key="index")
          a(:href="`${searchURL}?transaction=rent&location=${item.slug}`") {{ item.name }}

</template>

<script>
export default {
  data: () => ({
    location: SHINYU.location,
    searchURL: SHINYU.search_url
  })
}
</script>