<template>
    <v-card class="mx-auto" width="500" style="margin-top: 200px; background-color: rgb(40, 53, 147);">
        <v-card-subtitle class="pt-10" style="font-size: 20px; text-align: left; color: aliceblue;"> Procesos/Eventos </v-card-subtitle>
        <v-card-actions  style="display: flex; justify-content: center; background-color: rgb(26, 36, 104); margin-top: 50px;">
            <v-btn :to="{name: 'Create_offer'}" style="color: aliceblue;" text> Crear</v-btn>
            <v-btn style="color: aliceblue;" text> Copiar</v-btn>
            <v-btn :to="{name: 'Consult_process'}" style="color: aliceblue;" text> Consultar</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default{
        name: 'Card_options'
    }
</script>