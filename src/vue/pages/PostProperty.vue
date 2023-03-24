<template lang="pug">
.container
  .columns
    .column.is-8-fullhd.is-12
      validation-observer(ref='postPropertyForm')
        form(@submit.prevent='onSubmit')
          h3.mb-5.has-text-primary {{ i18n.post_property.contact_information }}
          validation-provider.field-group(
            v-slot='{ errors, valid }',
            rules='required',
            :name='i18n.post_property.full_name'
          )
            b-field(
              :label='`${i18n.post_property.full_name} *`',
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='errors',
              expanded
            )
              b-input(v-model='form.name')

          b-field(grouped, expanded)
            validation-provider.field.is-expanded.field-group(
              v-slot='{ errors, valid }',
              rules='required|numeric|min:9',
              :name='i18n.post_property.phone'
            )
              b-field(
                :label='`${i18n.post_property.phone} *`',
                :type='{ "is-danger": errors[0], "is-success": valid }',
                :message='errors',
                expanded
              )
                b-input(v-model='form.phone', type='tel')

            validation-provider.field.is-expanded.field-group(
              v-slot='{ errors, valid }',
              rules='required|email',
              :name='i18n.post_property.email'
            )
              b-field(
                :label='`${i18n.post_property.email} *`',
                :type='{ "is-danger": errors[0], "is-success": valid }',
                :message='errors',
                expanded
              )
                b-input(v-model='form.email', type='email')

          b-field(label='Line ID', expanded)
            b-input(v-model='form.line')

          hr

          h3.mb-5.has-text-primary {{ i18n.post_property.details }}

          validation-provider.field-group(
            v-slot='{ errors, valid }',
            rules='required',
            name='transaction'
          )
            b-field(
              :label='`${i18n.post_property.types} *`',
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='{ "กรุณาเลือกอสังหาฯ สำหรับ": errors[0] }'
            )
              b-radio.mr-5(
                v-model='form.transaction',
                name='transaction',
                native-value='sell'
              ) {{ i18n.post_property.sell }}

              b-radio.mr-5(
                v-model='form.transaction',
                name='transaction',
                native-value='rent'
              ) {{ i18n.post_property.rent }}

              b-radio(
                v-model='form.transaction',
                name='transaction',
                native-value='sell_rent'
              ) {{ i18n.post_property.sell_rent }}

          validation-provider.field-group(
            v-slot='{ errors, valid }',
            rules='required',
            name='project'
          )
            project-autocomplete(
              v-model='form.project_name',
              :errors='errors',
              :valid='valid',
              @selected='onProjectSelect',
              @input='onProjectInput'
            )

          validation-provider.field-group(
            v-slot='{ errors, valid }',
            rules='required',
            name='property_type'
          )
            b-field(
              :label='`${i18n.post_property.property_type} *`',
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='{ กรุณาเลือกประเภทโครงการ: errors[0] }'
            )
              b-select(
                v-model='form.property_type',
                :placeholder='`${i18n.post_property.property_type}`',
                expanded
              )
                option(value='') {{ i18n.post_property.property_type }} *
                option(
                  v-for='(item, index) in field.property_type',
                  :value='item.value'
                ) {{ item.label }}

          validation-provider.field-group(
            v-slot='{ errors, valid }',
            rules='required',
            name='bedroom'
          )
            b-field(
              :label='`${i18n.post_property.number_of_bedrooms} *`',
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='{ กรุณาเลือกจำนวนห้องนอน: errors[0] }',
              expanded
            )
              b-radio-button(
                v-for='(item, index) in field.bedrooms',
                :key='index',
                :native-value='item.value',
                v-if='item.value',
                v-model='form.bedroom',
                name='bedroom',
                expanded
              ) {{ item.label }}

          validation-provider.field-group(
            v-slot='{ errors, valid }',
            rules='required',
            name='bathroom'
          )
            b-field(
              :label='`${i18n.post_property.number_of_bathrooms} *`',
              :type='{ "is-danger": errors[0], "is-success": valid }',
              :message='{ กรุณาเลือกจำนวนห้องน้ำ: errors[0] }',
              expanded
            )
              b-radio-button(
                v-for='(item, index) in field.bathrooms',
                :key='index',
                :native-value='item.value',
                v-if='item.value',
                v-model='form.bathroom',
                name='bathroom',
                expanded
              ) {{ item.label }}

          b-field.mb-4(v-if='form.transaction', grouped, expanded)
            validation-provider.field.is-expanded.field-group(
              v-if='form.transaction !== "rent"',
              v-slot='{ errors, valid }',
              rules='required|numeric',
              :name='i18n.post_property.price_for_sale'
            )
              b-field(
                :label='`${i18n.post_property.price_for_sale} *`',
                :type='{ "is-danger": errors[0], "is-success": valid }',
                :message='errors',
                expanded
              )
                b-input(v-model='form.price_sell', type='number')
                .control
                  span.button.is-static บาท

            validation-provider.field.is-expanded.field-group(
              v-if='form.transaction !== "sell"',
              v-slot='{ errors, valid }',
              rules='required|numeric',
              :name='i18n.post_property.price_for_rent'
            )
              b-field(
                :label='`${i18n.post_property.price_for_rent} *`',
                :type='{ "is-danger": errors[0], "is-success": valid }',
                :message='errors',
                expanded
              )
                b-input(v-model='form.price_rent', type='number')
                .control
                  span.button.is-static {{ i18n.post_property.baht }}

          b-field.mb-4(grouped, expanded)
            validation-provider.field.is-expanded.field-group(
              v-if='form.transaction !== "sell"',
              v-slot='{ errors, valid }',
              rules='required',
              :name='i18n.post_property.size'
            )
              b-field(
                :label='i18n.post_property.size',
                :type='{ "is-danger": errors[0], "is-success": valid }',
                :message='errors',
                expanded
              )
                b-input(v-model='form.size', type='number', expanded)
                .control
                  span.button.is-static {{ i18n.sqm }}

            validation-provider.field.is-expanded.field-group(
              v-if='form.transaction !== "sell"',
              v-slot='{ errors, valid }',
              rules='required|numeric',
              :name='i18n.post_property.floor'
            )
              b-field(
                :label='i18n.post_property.floor',
                :type='{ "is-danger": errors[0], "is-success": valid }',
                :message='errors',
                expanded
              )
                b-input(v-model='form.floor', type='number', expanded)

          b-field.field-facility(:label='i18n.post_property.facilities')
            .columns.is-multiline.mt-0
              .column.is-3.pt-0.pb-0(
                v-for='(item, index) in field.room_facility',
                :key='index'
              )
                b-checkbox(:native-value='item.value', v-model='form.facility') {{ item.label }}

          b-field(:label='i18n.post_property.more_details')
            b-input(
              v-model='form.note',
              type='textarea',
              :placeholder='i18n.post_property.additional'
            )

          b-field.is-relative.mb-0(:label='i18n.post_property.upload_image')
            b-loading(v-model='isLoading', :is-full-page='false')
            b-upload.mb-0(
              v-model='images',
              multiple,
              drag-drop,
              expanded,
              accept='image/*',
              @input='onUpload'
            )
              section.section
                .content.has-text-centered
                  p
                    icon-image(:class='{ "is-loading": isLoading }')

                    p.has-text-gray(
                      v-html='i18n.post_property.drag_drop_or_click'
                    )

                  //- p Drop your files here or click to upload
          small.has-text-gray.d-block.mb-5 รองรับรูปภาพ .jpg .png .gif และขนาดสูงสุดไม่เกิน {{ maxUploadSize / (1024 * 1024) }} MB.

          ul.columns.is-multiline.is-1.is-variable.image-preview
            li.column.is-2(v-for='(image, index) in form.images', :key='index')
              img(:src='image.url')
              button.delete.is-small(
                type='button',
                @click='deleteDropFile(index)'
              )

          .block.pt-5
            b-button(
              type='is-primary',
              native-type='submit',
              :loading='buttonLoading',
              :disabled='isLoading'
            ) {{ i18n.post_property.submit }}
</template>

<script>
import axios from 'axios'
import IconImage from '../icons/Image.vue'
import ProjectAutocomplete from '../components/ProjectAutocomplete'
import MoveTo from 'moveTo'

export default {
  components: { IconImage, ProjectAutocomplete },
  data: () => ({
    i18n: SHINYU.i18n,
    field: SHINYU.field,
    maxUploadSize: SHINYU.max_upload_size,
    isLoading: false,
    buttonLoading: false,
    form: {
      name: SHINYU.user.data.display_name,
      phone: '',
      email: SHINYU.user.data.user_email,
      line: '',
      transaction: '',
      images: [],
      bedroom: '',
      bathroom: '',
      property_type: '',
      project_name: '',
      project_id: '',
      project: '',
      price_sell: '',
      price_rent: '',
      size: '',
      floor: '',
      facility: [],
      note: '',
      lang: SHINYU.lang,
    },
    images: [],
  }),

  created() {},

  // watch: {
  //   '$route': 'fetchData'
  // },

  mounted() {},

  methods: {
    onSubmit() {
      this.buttonLoading = true
      const form = this.$refs.postPropertyForm
      form.validate().then((success) => {
        if (!success) {
          setTimeout(() => {
            const errors = Object.entries(form.errors)
              .map(([key, value]) => ({ key, value }))
              .filter((error) => error['value'].length)

            const to = form.refs[errors[0]['key']].$el
            const moveTo = new MoveTo({
              tolerance: 110,
              duration: 800,
            })

            moveTo.move(to)
            this.buttonLoading = false
          }, 100)
          return
        } else {
          axios
            .post(`${SHINYU.api.url}shinyu/unit`, this.form)
            .then(({ data }) => {
              this.$buefy.dialog.alert({
                title: 'ส่งข้อมูลของท่านเรียบร้อย',
                message: 'ได้รับข้อมูลของท่านแล้ว ...ทีมงานจะรีบติดต่อกลับไป',
                type: 'is-success',
              })
            })
            .catch((error) => {})
            .then(() => {
              this.buttonLoading = false
              this.form = {}
              this.images = []
              requestAnimationFrame(() => {
                form.reset()
              })
            })
        }
        // this.$nextTick(() => {
        //   form.reset()
        // });
      })
      // try {
      // } catch (error) {
      //   const errors = error.response.data.errors
      //   form.setErrors(errors)
      // } finally {
      // }
    },

    onProjectSelect(option) {
      if (option) {
        this.form.project_name = option.title
        this.form.project_id = option.id
        this.form.property_type = option.type
      }
    },

    onProjectInput(val) {
      this.form.project_name = val
    },

    onUpload() {
      if (this.images.length > 0) {
        for (let index = 0; index < this.images.length; index++) {
          const element = this.images[index]
          if (!element.upload) {
            const formData = new FormData()
            formData.append('image', element)

            this.isLoading = true

            axios
              .post(`${SHINYU.api.url}shinyu/uploadimage`, formData)
              .then(({ data }) => {
                this.form.images.push(data.data)
                this.images[index].upload = true
                this.$buefy.toast.open({
                  duration: 3000,
                  queue: false,
                  message: `อัพโหลดไฟล์ ${element.name} สำเร็จ`,
                  type: 'is-success',
                  position: 'is-top-right',
                })
              })
              .catch((error) => {
                this.images.splice(index, 1)
                this.$buefy.toast.open({
                  duration: 3000,
                  queue: false,
                  message: `อัพโหลดไฟล์ ${element.name} ไม่สำเร็จ ${error}`,
                  type: 'is-danger',
                  position: 'is-top-right',
                })
              })
              .then(() => {
                this.isLoading = false
              })
          }
        }
        // this.form.images.forEach(element => {

        // })
      }

      // const form = new FormData()
      // form.append('file_payment', this.form.images)

      // try {
      // } catch (error) {
      // } finally {
      // }
    },

    deleteDropFile(index) {
      this.images.splice(index, 1)
      this.form.images.splice(index, 1)
    },
  },
}
</script>