<template lang="pug">
  validation-observer(ref="registerForm")
    form(@submit.prevent="onSubmit")
      validation-provider(
        v-slot="{ errors, valid }"
        rules="required"
        :name="i18n.register.full_name"
      )
        b-field.mb-4(
          expanded
          :type="{ 'is-danger': errors[0], 'is-success': valid }"
          :message="errors"
        )
          b-input(
            v-model="form.name"
            :placeholder="`${i18n.register.full_name} *`"
          )

      validation-provider(
        v-slot="{ errors, valid }"
        rules="required|numeric|min:9"
        :name="i18n.register.phone"
      )

        b-field.mb-4(
          expanded
          :type="{ 'is-danger': errors[0], 'is-success': valid }"
          :message="errors"
        )
          b-input(
            v-model="form.tel"
            type="tel"
            :placeholder="`${i18n.register.phone} *`"
          )

      validation-provider(
        v-slot="{ errors, valid }"
        rules="required|email"
        :name="i18n.register.email"
      )

        b-field.mb-4(
          expanded
          :type="{ 'is-danger': errors[0], 'is-success': valid }"
          :message="errors"
        )
          b-input(
            v-model="form.email"
            type="email"
            :placeholder="`${i18n.register.email} *`"
          )

      b-field.mb-4
        b-select.w-100(
          v-model="form.subject"
          expanded
          :placeholder="i18n.register.i_want"
        )
          option(:value="i18n.register.sell_rent") {{ i18n.register.sell_rent }}
          option(:value="i18n.register.appoint_a_room_tour") {{ i18n.register.appoint_a_room_tour }}
          option(:value="i18n.register.need_more_information") {{ i18n.register.need_more_information }}
          option(:value="i18n.register.need_an_urgent") {{ i18n.register.need_an_urgent }}

      b-field.mb-4(type="is-twitter" expanded)
        b-input(
          v-model="form.message"
          type="textarea"
          :placeholder="i18n.register.message"
        )

      .has-text-centered.pt-5
        b-button(
          type="is-primary"
          native-type="submit"
          :loading="buttonLoading"
        ) {{ i18n.register.submit }}

</template>

<script>
import MoveTo from 'moveTo'

export default {
  data: () => ({
    i18n: SHINYU.i18n,
    buttonLoading: false,
    form: {
      name: '',
      tel: '',
      email: '',
    }
  }),

  methods: {
    onSubmit() {
      this.buttonLoading = true
      const form = this.$refs.registerForm
      form.validate().then(success => {
        if (!success) {
          setTimeout(() => {
            this.buttonLoading = false
          }, 100)
          return;
        } else {
          this.$buefy.dialog.alert({
            title: 'ส่งข้อมูลของท่านเรียบร้อย',
            message: 'ได้รับข้อมูลของท่านแล้ว ...ทีมงานจะรีบติดต่อกลับไป',
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
      });
    },
  }
}
</script>