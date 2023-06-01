<template>
  <div>
    <div class="form-container">
      <h2 class="form-title">Informacion basica</h2>
      <v-form @submit.prevent="submitForm">
        <v-text-field class="form-field" v-model="formData.id_cerrada" label="id_cerrada" required></v-text-field>
        <v-text-field class="form-field" v-model="formData.descripcion" label="Objeto/Descripción" required></v-text-field>
        <v-text-field class="form-field" v-model="comprador" label="comprador" :disabled="isInputDisabled"></v-text-field>
        <v-container fluid>
          <v-row>
            <v-col cols="12">
              <v-combobox v-model="formData.select" :items="items" label="Estado" dense></v-combobox>
            </v-col>
          </v-row>
        </v-container>
        <div class="submit-btn">
          <v-btn  type="submit">Buscar</v-btn>
        </div>
      </v-form>
    </div>

    <v-simple-table dark>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">id</th>
            <th class="text-left">objeto</th>
            <th class="text-left">actividad</th>
            <th class="text-left">descripcion</th>
            <th class="text-left">moneda</th>
            <th class="text-left">presupuesto</th>
            <th class="text-left">fecha inicio</th>
            <th class="text-left">hora inicio</th>
            <th class="text-left">feha cierre</th>
            <th class="text-left">estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in resultados" :key="item.id">
            <td>{{  item.id }}</td>
            <td>{{  item.objeto }}</td>
            <td>{{  item.actividad }}</td>
            <td>{{  item.descripcion }}</td>
            <td>{{  item.moneda }}</td>
            <td>{{  item.presupuesto }}</td>
            <td>{{  item.fecha_inicio }}</td>
            <td>{{  item.hora_inicio }}</td>
            <td>{{  item.fecha_cierre }}</td>
            <td>{{  item.estado }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <button  @click="generateExcel" style="background: green; margin: 10px; padding: 10px; border-radius: 5px; color: aliceblue;">Generar excel</button>
  </div>
</template>
  
<script>
import axios from 'axios';

export default {
  name: 'Constult_process',
  data() {
    return {
      formData:{
        id_cerrada: '',
        descripcion: '',
        select: '',
      },
      items: [
        'ACTIVO',
        'EVALUADO',
        'PUBLICADO',
      ],
      comprador: '',
      isInputDisabled: true,
      resultados: {},
    };
  },
  methods: {
    generateExcel() {
      axios.post('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/generateExcel.php', this.resultados, { responseType: 'blob' })
      .then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'archivo.xlsx');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      })
      .catch(error => {
        console.error(error);
      });
    },
    submitForm() {
      axios.post('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/consultProcess.php', this.formData)
      .then(response => {
        this.resultados = response.data;                
        console.log(response);
      }).catch(error => {
          console.error(error);
        });
    },
  },
};
</script>

