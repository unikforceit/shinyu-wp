<template lang="pug">
  .container
    form(@submit.prevent="onSubmit")
      .columns.d-flex.align-items-center.m-0
        .column.column-input.is-6.pl-0.pr-0
          b-field
            b-input(
              :placeholder="i18n.enter_email"
              size="is-large"
              type="email"
              required
            )

        .column.is-6.pl-0.pr-0
          .d-flex.justify-content-between
            b-button(
              type="is-danger is-inverted"
              native-type="submit"
              :loading="isLoading"
            ) {{ i18n.subscribe }}
            a.d-none.d-xl-block(href="tel:020013033")
              icon-phone-call
              span 02 001 3033
</template>

<script>
import IconPhoneCall from '../icons/PhoneCall'
export default {
  components: { IconPhoneCall },
  data: () => ({
    i18n: SHINYU.i18n.subscribe,
    isLoading: false,
  }),

  methods: {
    onSubmit() {
      this.isLoading = true
      setTimeout(() => {
        this.$buefy.dialog.alert({
          title: 'Thank You For Subscribing',
          message: 'Please check your email for a confirmation link along with the WPBeginner Toolkit and other resources.',
          type: 'is-success',
        })
        this.isLoading = false
      }, 400);
    }
  }
}
</script>