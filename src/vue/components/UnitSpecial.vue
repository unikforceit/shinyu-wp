<template lang="pug">
div
  nav.filter
    ul
      li(v-for='(tag, index) in tags', :key='index')
        a(
          href='#',
          :class='{ "is-active": curtentTag === tag.id }',
          @click.prevent='onFilter(tag.id, tag.type)'
        )
          .rippleJS
          span {{ tag.title }}

  .units.columns.is-multiline.is-relative
    b-loading(:is-full-page='false', v-model='isLoading', :can-cancel='true')

    .unit.unit-column.column.is-4-fullhd.is-6-tablet(
      v-for='(item, index) in units',
      :key='item.id'
    )
      project-item(v-if='item.type === "project"', :project='item')

      unit-item(v-else, :unit='item')
</template>

<script>
import axios from 'axios'
import UnitItem from '../components/UnitItem'
import ProjectItem from '../components/ProjectItem'

export default {
  components: { UnitItem, ProjectItem },
  data: () => ({
    tags: [],
    units: [],
    curtentTag: null,
    isLoading: false,
  }),
  mounted() {
    axios
      .get(`${SHINYU.api.url}shinyu/unit-tags?lang=${SHINYU.lang}`)
      .then((response) => {
        this.tags = response.data.data
        const data = response.data.data[0]
        this.curtentTag = data.id

        axios
          .get(`${SHINYU.api.url}shinyu/unit-special`, {
            params: {
              id: data.id,
              type: 'unit',
            },
          })
          .then((response) => {
            this.units = response.data.data
          })
      })
  },

  methods: {
    onFilter(tag, type) {
      this.isLoading = true
      this.curtentTag = tag
      axios
        .get(`${SHINYU.api.url}shinyu/unit-special`, {
          params: {
            id: tag,
            type: type,
          },
        })
        .then((response) => {
          this.units = response.data.data
          this.isLoading = false
        })
    },
  },
}
</script>