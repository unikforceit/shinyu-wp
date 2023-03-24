<template lang="pug">
validation-observer(ref='contactForm')
  form(@submit.prevent='onSubmit')
    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.contact.full_name'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors'
      )
        b-input(
          v-model='form.name',
          :placeholder='i18n.contact.full_name + "*"'
        )

    b-field.mb-4(expanded)
      b-input(
        v-model='form.id_card',
        type='text',
        :placeholder='i18n.identity_card_or_passport_no'
      )

    validation-provider.field.is-expanded(
      v-slot='{ errors, valid }',
      rules='required|numeric|min:9',
      :name='i18n.contact.phone'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors'
      )
        b-input(
          v-model='form.phone',
          type='tel',
          :placeholder='i18n.contact.phone + "*"'
        )

    validation-provider.field.is-expanded(
      v-slot='{ errors, valid }',
      rules='required|email',
      :name='i18n.contact.email'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors'
      )
        b-input(
          v-model='form.email',
          type='email',
          :placeholder='i18n.contact.email + "*"'
        )

    b-field.file
      b-upload.file-label(v-model='form.house_register')
        span.file-name
          span(v-if='form.house_register') {{ form.house_register.name }}
          span(v-else) {{ i18n.no_file_selected }}
        span.file-cta
          span.file-label {{ i18n.upload_title_deed_file }}

    b-field
      b-checkbox(v-model='accept', size='is-small') {{ i18n.privacy_condition }}
        a.px-2(
          href='https://shinyurealestate.com/privacy-policy',
          target='_blank'
        ) {{ i18n.privacy_policy }}
        | {{ i18n.and }}
        a.px-2 {{ i18n.term_of_condition }}
    .has-text-right.pt-5
      b-button(
        type='is-primary',
        native-type='submit',
        :disabled='!accept',
        :loading='buttonLoading'
      ) {{ i18n.contact.submit }}
</template>

<script>
export default {
  data: () => ({
    i18n: SHINYU.i18n,
    subscribe: false,
    accept: false,
    buttonLoading: false,
    form: {
      name: '',
    },
  }),

  methods: {
    onSubmit() {
      this.buttonLoading = true
      const form = this.$refs.contactForm
      form.validate().then((success) => {
        if (!success) {
          setTimeout(() => {
            this.buttonLoading = false
          }, 100)
          return
        } else {
          this.$buefy.dialog.alert({
            title: 'ส่งข้อมูลเรียบร้อยแล้ว',
            message: 'ส่งข้อมูลเรียบร้อยแล้ว เราจะติดต่อคุณกลับโดยเร็วที่สุด',
            type: 'is-success',
          })

          this.buttonLoading = false
          this.form = {}

          requestAnimationFrame(() => {
            form.reset()
          })
        }
        // this.$nextTick(() => {
        //   form.reset()
        // });
      })
    },
  },
}
</script>

<style lang="scss" scoped>
.file-label {
  width: 100%;
}

.file-name {
  width: 100%;
  max-width: none;
  color: #83757d;
  background: #fff;
  border: solid 1px #dbdbdb;
  border-right: none;
  border-radius: 4px 0 0 4px;
}
</style>