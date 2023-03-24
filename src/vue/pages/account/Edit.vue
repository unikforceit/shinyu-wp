<template lang="pug">
form.py-2(@submit.prevent='submit')
  .panel-block 
    strong.pr-2 Username :
    b-field
      b-input(type='tel', v-model='user.username', disabled)

  .panel-block 
    strong.pr-2 {{ i18n.email }} :
    b-field
      b-input(type='tel', v-model='user.user_email', disabled)

  .panel-block 
    strong.pr-2 {{ i18n.phone }} :
    b-field
      b-input(type='tel', v-model='user.phone')

  .panel-block 
    strong.pr-2 {{ i18n.account.first_name }} :
    b-field
      b-input(type='text', v-model='user.first_name')

  .panel-block 
    strong.pr-2 {{ i18n.account.last_name }} :
    b-field
      b-input(type='text', v-model='user.last_name')

  .panel-block.pt-5
    strong
    b-button(type='is-primary', native-type='submit', :loading='isLoading') Update
</template>

<script>
import { mapGetters } from 'vuex'
import { axiosNonce } from '../../config.js'
export default {
  data: () => ({
    isLoading: false,
    i18n: SHINYU.i18n,
  }),

  computed: {
    ...mapGetters(['user']),
  },

  methods: {
    submit() {
      this.isLoading = true
      axiosNonce
        .put(`${SHINYU.api.url}shinyu/user/me`, {
          data: this.user,
        })
        .then(({ data }) => {
          this.$store.commit('SET_USER', data.data)
          this.$buefy.toast.open({
            duration: 1000,
            message: `อัพเดทข้อมูลสำเร็จ`,
            position: 'is-top',
            type: 'is-success',
          })
        })
        .catch((error) => {})
        .then(() => (this.isLoading = false))
    },
  },
}
</script>

<style lang="scss" scoped>
strong {
  width: 130px;
  display: inline-block;
}
</style>