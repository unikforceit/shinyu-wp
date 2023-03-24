<template lang="pug">
  div
    .form
      button.delete(
        type="button"
        @click="$emit('close')"
      )
      login-form(v-if="modal === 'login'" :popup="true")
      register-form(v-else :popup="true")
</template>

<script>
import { mapState } from 'vuex'
import LoginForm from './LoginForm'
import RegisterForm from './RegisterForm'
export default {
  components: { LoginForm, RegisterForm },
  data: () => ({
    isCardModalActive: true,
  }),
  computed: {
    ...mapState(['modal']),
  },
}
</script>

<style lang="scss" scoped>
.form {
  position: relative;
  width: 500px;
  padding: 2rem;
  border-radius: 4px;
  background: #fff;
}

.delete {
  position: absolute;
  right: 16px;
  top: 16px;
}
</style>