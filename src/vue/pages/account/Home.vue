<template lang="pug">
.py-2
  .panel-block 
    strong.pr-2 Username :
    | {{ user.username }}

  .panel-block 
    strong.pr-2 {{ i18n.email }} :
    | {{ user.user_email }}

  .panel-block 
    strong.pr-2 {{ i18n.phone }} :
    | {{ user.phone }}

  .panel-block 
    strong.pr-2 {{ i18n.account.first_name }} :
    | {{ user.first_name }}

  .panel-block 
    strong.pr-2 {{ i18n.account.last_name }} :
    | {{ user.last_name }}
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  data: () => ({
    i18n: SHINYU.i18n,
  }),

  computed: {
    ...mapGetters(['user']),
  },
}
</script>