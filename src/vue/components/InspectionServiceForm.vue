<template lang="pug">
validation-observer(ref='addToCartForm')
  form(@submit.prevent='onSubmit')
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
        b-select(v-model='form.variation_id', expanded, @input='onSizeInput')
          option(value='', disabled) {{ i18n.select_room_size }}
          option(
            v-for='(item, index) in JSON.parse(package)',
            :value='item.id',
            :data-price='item.price'
          ) {{ item.title }}

    .is-flex.is-justify-content-space-between.pt-5
      span 
        span.is-block Service Fee
        strong.has-text-primary(v-if='totalPrice') ฿{{ totalPrice | formatMoney }}
        span.has-text-primary(v-else, v-html='price')

      b-button(
        type='is-primary',
        size='is-medium',
        native-type='submit',
        :disabled='!form.variation_id',
        :loading='buttonLoading'
      ) {{ i18n.checkout }}
</template>

<script>
import axios from 'axios'
import Qs from 'qs'

export default {
  props: {
    price: {
      type: String,
      default: '',
    },
    package: {
      type: String,
      default: '',
    },
    productId: {
      type: String,
      default: '',
    },
  },

  data: () => ({
    i18n: SHINYU.i18n,
    subscribe: false,
    totalPrice: 0,
    accept: false,
    buttonLoading: false,
    form: {
      variation_id: '',
      project_name: '',
      unit_no: '',
      floor: '',
      action: 'shinyu_add_to_cart',
    },
  }),

  methods: {
    onSizeInput(val) {
      const obj = JSON.parse(this.package).find(({ id }) => id === val)
      this.totalPrice = obj.price
    },

    onSubmit() {
      this.form.product_id = this.productId
      this.buttonLoading = true
      const form = this.$refs.addToCartForm

      form.validate().then((success) => {
        if (!success) {
          setTimeout(() => {
            this.buttonLoading = false
          }, 100)
          return
        } else {
          axios
            .post(SHINYU.ajaxurl, Qs.stringify(this.form))
            .then(({ data }) => {
              window.open(data.redirect, '_self')
            })
            .catch((error) => {})
            .then(() => {
              this.buttonLoading = false
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