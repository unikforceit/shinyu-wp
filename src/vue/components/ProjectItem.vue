<template lang="pug">
  .card.project-item(:class="`type-${project.type}`")
    .card-image.project-image
      a(
        :href="project.link"
        target="_blank"
      )
        img(:src="project.image_url")

    .card-content.is-relative
      h4.project-title
        a(
          :href="project.link"
          target="_blank"
        ) {{ project.title }}
        small By {{ project.developer }}

</template>

<script>

import IconLocation from '../icons/Location'

export default {
  components: { IconLocation },
  data: () => ({}),

  props: {
    project: {
      type: Object,
      defualt: () => {}
    }
  },
}
</script>

<style lang="scss" scoped>
.card {
   display: flex;
   flex-direction: column;
   height: 100%;

  &-content {
    a {
      font-size: 20px;
      font-weight: 500;
      line-height: 1;
      color: #252525;
    }
  }

  &-footer {
    margin-top: auto;
  }
}

.project {
  &-item {
    transition: box-shadow 0.2s;

    &:hover {
      box-shadow: 16px 16px 32px rgba(0, 0, 0, 0.1);

      .project-title {
        a {
          color: #0f4b81;
        }
      }
    }
  }

  &-image {
    height: 280px;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &-title {

    a {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      display: block;
    }

    small {
      font-size: 14px;
      font-weight: 500;
    }
  }

  &-location {
    line-height: 1;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  
    &-icon {
      fill: #0f4b81;
      display: inline-block;
      margin-right: 0.5rem;
    }
  }
}
</style>
