<template lang="pug">
form.form-login.form-account(@submit.prevent='onSubmit')
  h3.title.has-text-dark.has-text-centered {{ i18n.account.sign_in }}
  p.has-text-centered.mb-6(v-if='lang !== "ja"') {{ i18n.account.if_you_dont_have_any_account_please }}
    a.pl-2(
      href='#',
      v-if='popup',
      @click.prevent='$store.commit("SET_MODAL", "register")'
    ) {{ i18n.account.sign_up }}
    router-link.pl-2(v-else, to='/register') {{ i18n.account.sign_up }}

  p.has-text-centered.mb-6(v-else)
    | まだアカウントをお持ちでない場合はこちらより
    a.px-2(
      href='#',
      v-if='popup',
      @click.prevent='$store.commit("SET_MODAL", "register")'
    ) サインアップ
    router-link.px-2(v-else, to='/register') サインアップ
    | してください。

  button.button.facebook-login-button.is-medium.is-facebook.is-fullwidth(
    type='button',
    @click='facebookLogin',
    :class='{ "is-loading": buttonLoadingFacebook }'
  )
    span.icon.is-small
      icon-facebook

    span {{ i18n.account.sign_in_with_facebook }}

  .is-flex.is-justify-content-space-between.is-align-items-center.py-5.has-text-centered.divider
    span.px-3 {{ i18n.account.or_sign_in_with_your_account }}

  b-field.field-group(:label='i18n.account.username_email', expanded)
    b-input(v-model='form.username', size='is-medium')

  b-field.field-group(:label='i18n.account.password', expanded)
    b-input(
      v-model='form.password',
      size='is-medium',
      type='password',
      password-reveal
    )

  .is-flex.is-justify-content-space-between
    b-field
      b-checkbox {{ i18n.account.remember_me }}

    router-link(to='/lost-password') {{ i18n.account.forget_password }}

  b-message.mt-5.mb-1(
    v-if='errorMessages',
    type='is-danger',
    aria-close-label='Close message'
  )
    p(v-html='errorMessages')

  .is-block.pt-5.has-text-centered
    b-button(
      expanded,
      size='is-medium',
      type='is-danger',
      native-type='submit',
      :loading='isLoading',
      :disabled='isLoading'
    ) {{ i18n.account.sign_in }}
</template>

<script>
import axios from '../config'
import IconFacebook from '../icons/Facebook2'

export default {
  components: { IconFacebook },

  props: {
    popup: {
      type: Boolean,
      default: false,
    },
  },

  data: () => ({
    lang: SHINYU.lang,
    i18n: SHINYU.i18n,
    form: {},
    isLoading: false,
    buttonLoading: false,
    buttonLoadingFacebook: false,
    errorMessages: null,
  }),

  methods: {
    async onSubmit() {
      this.isLoading = true
      this.errorMessages = null
      try {
        const { data } = await axios.post('shinyu/user/login', this.form)
        this.$buefy.toast.open({
          duration: 1000,
          message: `สวัสดี ${data.data.display_name}`,
          position: 'is-top',
          type: 'is-success',
        })
        setTimeout(() => {
          window.location.reload()
        }, 1000)
      } catch (error) {
        this.errorMessages = error.response.data.message
      } finally {
        setTimeout(() => {
          this.isLoading = false
        }, 300)
      }
    },

    facebookLogin() {
      this.buttonLoadingFacebook = true
      FB.login(
        (response) => {
          if (response.status === 'connected') {
            axios
              .post('shinyu/user/login/facebook', response.authResponse)
              .then(({ data }) => {
                this.$buefy.toast.open({
                  duration: 1000,
                  message: `สวัสดี ${data.data.display_name}`,
                  position: 'is-top',
                  type: 'is-success',
                })
                setTimeout(() => {
                  window.location.reload()
                }, 1000)
              })
              .catch((error) => {})
              .then(() => {
                setTimeout(() => {
                  this.isLoading = false
                  this.buttonLoadingFacebook = false
                }, 300)
              })
          } else {
            this.buttonLoadingFacebook = false
          }
        },
        { scope: 'public_profile,email' }
      )
    },
  },
}
</script>

<style lang="scss" scoped>
.field-group {
  display: block;
  margin-bottom: 1rem;
}

.subtitle {
  font-size: 14px;
}

form {
  max-width: 30rem;
  margin: 0 auto;
}
</style>
