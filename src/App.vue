<template>
  <div id="app" style="margin-top: 0;">
    <v-app>
      <v-card class="mx-auto overflow-hidden" height="64" width="100%">
        <v-app-bar color="accent-4" dark>
          <v-spacer></v-spacer>
          <v-btn :to="{name: 'Principal_card'}">INICIO</v-btn>
        </v-app-bar>
      </v-card>
      <router-view></router-view>
    </v-app>
  </div>
</template>

<script>
  export default {
    data: () => ({
      drawer: false,
      group: null,
    }),
    watch: {
      group () {
        this.drawer = false
      },
    },
  }
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
