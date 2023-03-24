<template lang="pug">
validation-observer(ref='registerForm', v-slot='{ handleSubmit }')
  form.form-login.form-account(@submit.prevent='handleSubmit(onSubmit)')
    h3.title.has-text-dark.has-text-centered {{ i18n.account.forget_password }}
    p.has-text-centered.mb-6 {{ i18n.account.forget_password_massage }}

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
        b-input(type='text', v-model='form.email', size='is-medium')

    b-message.mt-5.mb-1(
      v-if='errorMessages',
      type='is-danger',
      aria-close-label='Close message'
    )
      p(v-html='errorMessages')

    b-message.mt-5.mb-1(
      v-if='successMessages',
      type='is-primary',
      aria-close-label='Close message'
    )
      p(v-html='successMessages')

    .is-block.pt-5.has-text-centered
      b-button(
        expanded,
        size='is-medium',
        type='is-danger',
        native-type='submit',
        :loading='isLoading',
        :disabled='isLoading'
      ) {{ i18n.account.reset_password }}
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
    successMessages: null,
  }),

  methods: {
    async onSubmit() {
      this.isLoading = true
      this.errorMessages = null
      this.successMessages = null

      try {
        const { data } = await axios.post(
          'shinyu/user/reset-password',
          this.form
        )
        this.successMessages = data.message
      } catch (error) {
        this.errorMessages = error.response.data.message
      } finally {
        setTimeout(() => {
          this.isLoading = false
        }, 300)
      }
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
