<template lang="pug">
.container
  h3.title.has-text-primary.mb-6 {{ i18n.management.apply_for_services }}
  validation-observer(ref='contactForm')
    form(@submit.prevent='onSubmit')
      h3.contact-form-title.has-text-primary

      .columns.is-variable.is-2
        .column.is-6
          validation-provider(
            v-slot='{ errors, valid }',
            rules='required',
            :name='i18n.project_name'
          )
            b-field.mb-4(
              expanded,
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='errors',
              :label='`${i18n.project_name} *`'
            )
              b-input(v-model='form.project_name')
        .column.is-3
          validation-provider(
            v-slot='{ errors, valid }',
            rules='required',
            :name='i18n.room_no'
          )
            b-field.mb-4(
              expanded,
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='errors',
              :label='`${i18n.room_no} *`'
            )
              b-input(v-model='form.unit_no')

        .column.is-3
          b-field.mb-4(expanded, :label='i18n.floor')
            b-input(type='number', v-model='form.floor')

      .columns.is-variable.is-2
        .column.is-6
          validation-provider(
            v-slot='{ errors, valid }',
            rules='required',
            :name='i18n.plan'
          )
            b-field.mb-4(
              expanded,
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='errors',
              :label='`${i18n.plan} *`'
            )
              b-select#package(
                expanded,
                v-model='form.variation_id',
                @input='onPackageInput'
              )
                option(value='' selected disabled) Select Plan
                option(
                  v-for='(item, index) in JSON.parse(package)',
                  :value='item.id',
                  :data-price='item.price'
                ) {{ item.title }}
                //- display_price
                //- variation_id
                //- attributes.attribute_pa_subscription
                //- attributes.attribute_pa_months

        .column.is-6
          validation-provider(
            v-slot='{ errors, valid }',
            rules='required',
            :name='i18n.room_type'
          )
            b-field.mb-4(
              expanded,
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='errors',
              :label='`${i18n.room_type} *`'
            )
              b-radio-button(
                expanded,
                native-value='1',
                v-model='form.unit_type',
                @input='onUnitInput'
              ) 1 Bed

              b-radio-button(
                expanded,
                native-value='2',
                v-model='form.unit_type',
                @input='onUnitInput'
              ) 2 Bed or More

      .columns.is-variable.is-2
        .column.is-6
          .label {{ i18n.title_deed }}
          b-field.file.is-primary
            b-upload.file-label(v-model='form.title_deed')
              span.file-name
                span(v-if='form.title_deed') {{ form.title_deed.name }}
                span(v-else) {{ i18n.no_file_selected }}
              span.file-cta
                b-icon.file-icon(icon='upload')
                span.file-label {{ i18n.upload_title_deed_file }}

        .column.is-6
          .label {{ i18n.house_register }}
          b-field.file.is-primary
            b-upload.file-label(v-model='form.house_register')
              span.file-name
                span(v-if='form.house_register') {{ form.house_register.name }}
                span(v-else) {{ i18n.no_file_selected }}
              span.file-cta
                b-icon.file-icon(icon='upload')
                span.file-label Upload photo

      .is-flex.is-justify-content-space-between.pt-5
        .totals 
          .is-flex(v-if='packagePrice')
            span Package
            span ฿{{ packagePrice | formatMoney }}

          .is-flex(v-if='depositPrice') 
            span Deposit
            span ฿{{ depositPrice | formatMoney }}

          .total.has-text-primary.is-flex(v-if='totalPrice') 
            span Total
            span ฿{{ totalPrice | formatMoney }}

        .has-text-right
          validation-provider(
            v-slot='{ errors, valid }',
            rules='required',
            name='Consent'
          )
            b-field(
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='errors'
            )
              b-checkbox(v-model='form.accept', size='is-small')
                span(v-if='lang === "th"') 
                  | ข้าพเจ้าได้อ่านและตกลงยินยอมตกลงตาม
                  a.px-2(
                    target='_blank',
                    href='https://shinyurealestate.com/condominium-maintenance-agreement'
                  )
                    strong สัญญาจ้าง
                  | เพื่อดูแลห้องชุดของทางบริษัท ชินยู เรียล เอสเตท จำกัด

                span(v-else-if='lang === "ja"') 
                  | Shinyu Real Estate Co.,Ltd. の
                  a.px-2(
                    target='_blank',
                    href='https://shinyurealestate.com/condominium-maintenance-agreement'
                  ) 
                    strong サービス、管理規約
                  | を確認の上同意します。

                span(v-else) 
                  | I have read and agree to the
                  a.px-2(
                    target='_blank',
                    href='https://shinyurealestate.com/condominium-maintenance-agreement'
                  ) 
                    strong Condominium Maintenance Agreement
                  | of Shinyu Real Estate Co.,Ltd.

          b-button(
            type='is-danger',
            size='is-medium',
            native-type='submit',
            :disabled='buttonLoading || !form.accept',
            :loading='buttonLoading'
          ) {{ i18n.management.confirm }}
</template>

<script>
import axios from 'axios'
import Qs from 'qs'

export default {
  props: {
    package: {
      type: String,
      default: '',
    },
    productId: {
      type: Number,
      default: 0,
    },
  },
  data: () => ({
    lang: SHINYU.lang,
    i18n: SHINYU.i18n,
    subscribe: false,
    accept: false,
    buttonLoading: false,
    form: {
      variation_id: '',
      name: '',
      title_deed: null,
      house_register: null,
      unit_type: null,
      action: 'shinyu_add_to_cart',
    },

    totalPrice: 0,
    packagePrice: 0,
    depositPrice: 0,
    month: null,
    deposit: {
      '3-months': {
        1: 4500,
        2: 10000,
      },
      '6-months': {
        1: 7500,
        2: 14000,
      },
      '1-year': {
        1: 15000,
        2: 28000,
      },
    },
  }),

  watch: {
    packagePrice: function (val) {
      this.totalPrice = parseInt(val) + this.depositPrice
    },
    depositPrice: function (val) {
      this.totalPrice = parseInt(val) + this.packagePrice
    },
  },

  methods: {
    onPackageInput(val) {
      const obj = JSON.parse(this.package).find(({ id }) => id === val)
      this.packagePrice = obj.price
      this.month = obj.month
      if (this.form.unit_type)
        this.depositPrice = this.deposit[this.month][this.form.unit_type]
    },

    onUnitInput(val) {
      if (this.month) this.depositPrice = this.deposit[this.month][val]
    },
    // onPackageChange(event) {
    //   const index = event.target.options.selectedIndex
    //   this.packagePrice = event.target[index].dataset.price
    // },
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
          this.form.deposit = this.depositPrice
          this.form.product_id = this.productId

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
.container {
  max-width: 900px !important;
}
.columns {
  padding-top: 0;
  padding-bottom: 0;

  .column {
    padding-top: 0;
  }
}
.file-label {
  width: 100%;
}

.file-name {
  width: 100%;
  max-width: none;
  background: #fff;
  border: solid 1px #dbdbdb;
  border-right: none;
  border-radius: 4px 0 0 4px;
}

.total {
  font-weight: bold;
  font-size: 26px;
}

.totals {
  span:first-child {
    width: 5.625rem;
  }
}
</style>