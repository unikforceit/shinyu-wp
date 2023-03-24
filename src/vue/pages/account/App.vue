<template lang="pug">
#app
  .page-account-header(
    v-if='$route.fullPath !== "/login" && $route.fullPath !== "/register" && $route.fullPath !== "/lost-password"'
  )
    .container
      .is-flex.is-justify-content-space-between.is-align-items-center
        .media
          .media-left
            figure.image.is-64x64
              img.is-rounded(:src='user.avatar_url')
          .media-content.pl-4
            span.is-block.has-text-primary.username {{ user.first_name }} {{ user.last_name }}
            span.is-block {{ user.user_email }}

        .buttons
          b-button.pr-4.is-radiusless(
            tag='router-link',
            type='is-primary',
            icon-left='edit',
            outlined,
            to='/edit'
          ) แก้ไขข้อมูล

          b-button.px-4.is-radiusless(
            tag='router-link',
            type='is-primary',
            to='/post-property'
          ) ฝากขาย -เช่าอสังหาฯ

  section.section
    .container
      .columns(
        v-if='$route.fullPath !== "/login" && $route.fullPath !== "/register" && $route.fullPath !== "/lost-password"'
      )
        .column.is-3
          .panel.is-primary.sidebar
            .panel-heading 
              h3 บัญชีผู้ใช้

            .panel-block.is-block
              ul.menu
                li
                  router-link(to='/', exact)
                    //- b-icon(icon="user").mr-3
                    span ข้อมูลสมาชิก
                li
                  router-link(to='/order') รายการสั่งซื้อ
                li
                  router-link(to='/property') รายการ ฝากขาย/เช่า
                li
                  a(:href='logoutURL', @click.prevent='logout') ออกจากระบบ

        .column.is-9
          .panel.is-primary
            .panel-heading 
              h3 {{ getTitle }}

            .panel-block.is-block
              .content
                router-view
      router-view(v-else)
</template>

<style lang="scss" scoped>
.page-account-header {
  padding: 2rem 0;
  background: #fff;
}

.sidebar {
  border-bottom: 5px solid var(--primary);
}

.username {
  line-height: 1.4;
  font-size: 1.625rem;
}

.menu {
  padding: 0.5rem 0;

  li {
    a {
      color: #575757;
      display: block;
      padding: 0.25rem 0.5rem;
      margin-bottom: 0.25rem;

      &.router-link-active {
        font-weight: 500;
        color: var(--primary);
      }
    }
  }
}
</style>

<script>
import axios from '../../config'
import { mapGetters } from 'vuex'
export default {
  data: () => ({
    logoutURL: SHINYU.user.logout_url,
    homeURL: SHINYU.homeurl,
  }),

  computed: {
    ...mapGetters(['user']),

    getTitle: function () {
      let title = ''
      switch (this.$route.name) {
        case 'PostProperty':
          title = 'ลงประกาศอสังหาริมทรัพย์'
          break

        case 'Home':
          title = 'ข้อมูลสมาชิก'
          break

        case 'Order':
          title = 'รายการสั่งซื้อ'
          break

        case 'Property':
          title = 'รายการ ฝากขาย/เช่า'
          break

        case 'Edit':
          title = 'แก้ไขโปรไฟล์'
          break

        default:
          title = this.$route.name
          break
      }
      return title
    },
  },

  methods: {
    logout() {
      axios.post('shinyu/user/logout').then(() => {
        window.location.reload()
      })
    },
  },
}
</script>