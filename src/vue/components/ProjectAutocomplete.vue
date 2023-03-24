<template lang="pug">
  b-field(
    :label="`${i18n.post_property.project} *`"
    :type="{ 'is-danger': errors[0], 'is-success': valid }"
    :message="{ 'กรุณาเลือก หรือกรอกชื่อโครงการ' : errors[0]  }"
  )
    b-autocomplete(
      :placeholder="i18n.post_property.project_name"
      :data="data"
      field="title"
      :loading="isFetching"
      :check-infinite-scroll="true"
      open-on-focus
      :clearable="true"
      :max-height="220"
      @typing="getAsyncData"
      @select="onSelect"
      @input="onInput"
      @infinite-scroll="getMoreAsyncData"
    )
      template(slot-scope="props")
        .media
          .media-left
            img(style="width:40px" :src="props.option.image_url")
          .media-content
            span {{ props.option.title }}
      template(slot="footer")
          span(v-show="page > totalPages" class="has-text-grey") Thats it! No more data found.
</template>

<script>
import debounce from 'lodash/debounce'
import axios from 'axios'

export default {
  data: () => ({
    i18n: SHINYU.i18n,
    data: [],
    selected: null,
    isFetching: false,
    page: 1,
    totalPages: 1,
    name: '',
  }),

  props: {
    errors: {
      type: Array,
      default: () => [],
    },
    valid: {
      type: Boolean,
      default: false,
    }
  },

  methods: {
    onSelect(option) {
      this.selected = option
      this.$emit('selected', option)
    },

    onInput(val) {
      this.$emit('input', val)
    },

    getAsyncData: debounce(function (name) {
      // String update
      if (this.name !== name) {
        this.name = name
        this.data = []
        this.page = 1
        this.totalPages = 1
      }
      // String cleared
      if (!name.length) {
        this.data = []
        this.page = 1
        this.totalPages = 1
        return
      }
      // Reached last page
      if (this.page > this.totalPages) {
        return
      }
      this.isFetching = true

      axios
        .get(`${SHINYU.api.url}shinyu/search/project/?keyword=${name}&page=${this.page}&lang=${SHINYU.lang}`)
        .then(({ data }) => {
          this.isFetching = false
          data.data.forEach(item => {
            this.data.push(item)
          });
          this.page++
          this.totalPages = data.meta.total_pages
        })
        .catch(error => {
          this.isFetching = false
        })
    }, 500),

    getMoreAsyncData: debounce(function () {
      this.getAsyncData(this.name)
    }, 250)
  }
}
</script>