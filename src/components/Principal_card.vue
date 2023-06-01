<template>
    <v-card class="mx-auto" width="500" style="margin-top: 200px; background-color: rgb(40, 53, 147);">
        <v-card-subtitle class="pt-10" style="font-size: 20px; text-align: left; color: aliceblue;"> Procesos/Eventos </v-card-subtitle>
        <v-card-actions style="display: flex; justify-content: center; background-color: rgb(26, 36, 104); margin-top: 50px;">
            <v-btn :to="{name: 'Card_options'}" style="color: aliceblue;" text> Acceder</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
  export default {
    name: 'Principal_card'
  }
</script>

