<template lang="pug">
validation-observer(ref='contactForm')
  form(@submit.prevent='onSubmit')
    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.full_name'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.full_name} *`',
        label-position='inside'
      )
        b-input(v-model='form.name')

    validation-provider.field.is-expanded(
      v-slot='{ errors, valid }',
      rules='required|numeric|min:9',
      :name='i18n.phone'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.phone} *`',
        label-position='inside'
      )
        b-input(v-model='form.phone', type='tel')

    validation-provider.field.is-expanded(
      v-slot='{ errors, valid }',
      rules='required|email',
      :name='i18n.email'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.email} *`',
        label-position='inside'
      )
        b-input(v-model='form.email', type='email')

    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.address'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.address} *`',
        label-position='inside'
      )
        b-input(rows, type='textarea', v-model='form.address')

    h4 {{ i18n.project_information_for_interior_services }}
    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.project_name'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.project_name}  *`',
        label-position='inside'
      )
        b-input(v-model='form.project_name')

    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.room_no'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.room_no} *`',
        label-position='inside'
      )
        b-input(v-model='form.unit_no')

    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.floor'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.floor} *`',
        label-position='inside'
      )
        b-input(v-model='form.floor')

    validation-provider(
      v-slot='{ errors, valid }',
      rules='required',
      :name='i18n.room_size'
    )
      b-field.mb-4(
        expanded,
        :type='{ "is-danger": errors[0], "is-success": valid }',
        :message='errors',
        :label='`${i18n.room_size} *`',
        label-position='inside'
      )
        b-input(v-model='form.size')

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
      ) {{ i18n.submit }}
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