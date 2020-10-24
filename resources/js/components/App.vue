<template>
  <v-app>
    <v-main>
      <vue-snotify></vue-snotify>
      <v-container 
        class="beige" 
        fluid>
        <Form />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Form from './form'
export default {
  name: 'App',
  components: {
    Form
  }
}
</script>

<style>
  .beige {
    background: beige;
  }
</style>