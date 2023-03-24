<template lang="pug">
validation-observer(ref='registerForm', v-slot='{ handleSubmit }')
  form.form-register.form-account(
    novalidate,
    @submit.prevent='handleSubmit(onSubmit)'
  )
    h3.title.has-text-dark.has-text-centered {{ i18n.account.sign_up }}
    p.has-text-centered.mb-6 {{ i18n.account.if_you_have_an_account_please }}
      a.pl-2(
        href='#',
        v-if='popup',
        @click.prevent='$store.commit("SET_MODAL", "login")'
      ) {{ i18n.account.sign_in }}
      router-link.pl-2(v-else, to='/login') {{ i18n.account.sign_in }}

    button.button.facebook-login-button.is-medium.is-facebook.is-fullwidth(
      @click='facebookLogin',
      :class='{ "is-loading": buttonLoadingFacebook }'
    )
      span.icon.is-small
        icon-facebook

      span {{ i18n.account.sign_up_with_facebook }}

    .is-flex.is-justify-content-space-between.is-align-items-center.py-5.has-text-centered.divider
      span.px-3 {{ i18n.account.or_sign_up_with_your_account }}

    .columns.is-variable.is-2
      .column
        validation-provider.field-group(
          v-slot='{ errors, valid }',
          rules='required',
          :name='i18n.account.first_name'
        )
          b-field(
            :label='i18n.account.first_name',
            :type='{ "is-danger": errors[0], "is-success": valid }',
            :message='errors',
            expanded
          )
            b-input(v-model='form.first_name', size='is-medium')
      .column
        validation-provider.field-group(
          v-slot='{ errors, valid }',
          rules='required',
          :name='i18n.account.last_name'
        )
          b-field(
            :label='i18n.account.last_name',
            :type='{ "is-danger": errors[0], "is-success": valid }',
            :message='errors',
            expanded
          )
            b-input(v-model='form.last_name', size='is-medium')

    .columns.is-multiline.is-variable.is-2
      .column.is-12
        validation-provider.field-group(
          v-slot='{ errors, valid }',
          rules='required|email',
          :name='i18n.email'
        )
          b-field(
            :label='i18n.email',
            :type='{ "is-danger": errors[0], "is-success": valid }',
            :message='errors',
            expanded
          )
            b-input(type='email', v-model='form.email', size='is-medium')
      .column.is-12
        validation-provider.field-group(
          v-slot='{ errors, valid }',
          rules='required|numeric|min:9|max:10',
          :name='i18n.phone'
        )
          b-field(
            :label='i18n.phone',
            :type='{ "is-danger": errors[0], "is-success": valid }',
            :message='errors',
            expanded
          )
            b-input(
              v-model='form.phone',
              type='tel',
              size='is-medium',
              name='tel'
            )

    .columns.is-variable.is-2
      .column
        validation-provider(
          v-slot='{ errors, valid }',
          rules='required|min:8',
          vid='password',
          :name='i18n.account.password'
        )
          b-field(
            :label='i18n.account.password',
            :type='{ "is-danger": errors[0], "is-success": valid }',
            :message='errors'
          )
            b-input(
              type='password',
              size='is-medium',
              v-model='form.password',
              password-reveal
            )

      .column
        validation-provider(
          v-slot='{ errors, valid }',
          rules='required|confirmed:password',
          :name='i18n.account.confirm_password'
        )
          b-field(
            :label='i18n.account.confirm_password',
            :type='{ "is-danger": errors[0], "is-success": valid }',
            :message='errors'
          )
            b-input(
              type='password',
              size='is-medium',
              v-model='form.password_confirmation',
              password-reveal
            )

    b-message.mt-5.mb-1(
      v-if='errorMessages',
      type='is-danger',
      aria-close-label='Close message'
    )
      p(v-html='errorMessages')

    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      name='Consent'
    )
      b-field(
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors'
      )
        b-checkbox(v-model='form.accept', size='is-small') {{ i18n.privacy_condition }}
          a.px-2(
            href='https://shinyurealestate.com/privacy-policy',
            target='_blank'
          ) {{ i18n.privacy_policy }}
          | {{ i18n.and }}
          a.px-2 {{ i18n.term_of_condition }}

    .is-block.pt-5.has-text-centered
      b-button(
        expanded,
        size='is-medium',
        type='is-danger',
        native-type='submit',
        :loading='buttonLoading',
        :disabled='isLoading || !form.accept'
      ) {{ i18n.account.sign_up }}
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
    i18n: SHINYU.i18n,
    form: {},
    isLoading: false,
    buttonLoading: false,
    buttonLoadingFacebook: false,
    errorMessages: null,
  }),

  methods: {
    async onSubmit() {
      try {
        const { data } = await axios.post('/shinyu/user/register', this.form)
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
                console.log(data)
                setTimeout(() => {
                  window.location.reload()
                }, 1000)
              })
              .catch((error) => {})
              .then(() => {
                setTimeout(() => {
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
}

.subtitle {
  font-size: 14px;
}

form {
  max-width: 30rem;
  margin: 0 auto;
}
</style>
