<template>
  <div>
    <v-tabs v-model="activeTab">
      <v-tab>Informacion basica</v-tab>
      <v-tab>Cronograma</v-tab>
      <v-tab>Documentacion peticion de oferta</v-tab>
    </v-tabs>

    <v-tabs-items v-model="activeTab">
      <v-tab-item key="tab1">
        <template>
          <div class="form-container">
            <h2 class="form-title">Informacion basica</h2>
            <v-form @submit.prevent="submitForm">
              <v-text-field class="form-field" v-model="formData1.objeto" label="Objeto" required></v-text-field>
              <v-text-field class="form-field" v-model="formData1.descripcion" label="Descripción/Alcance" required></v-text-field>
              <v-container fluid>
                <v-row>
                  <v-col cols="12">
                    <v-combobox v-model="formData1.select" :items="formData1.item" label="Moneda" dense required></v-combobox>
                  </v-col>
                </v-row>
              </v-container>
              <v-text-field class="form-field" type="number" v-model.number="formData1.presupuesto" label="Presupuesto" @keydown="preventNonNumeric" required @input="validateInput"></v-text-field>
              <div>
                <v-autocomplete v-model="formData1.selectedItem" :items="formData1.options" item-text="b_nombre_producto" item-value="value" label="Actividad" solo-inverted hide-details return-object :filter="customFilter" required></v-autocomplete>
              </div>
              <div class="mt-5 submit-btn">
                <v-btn @click="goToTab(1)" type="button" color="white">Guardar</v-btn>
              </div>
            </v-form>
          </div>
        </template>
      </v-tab-item>

      <v-tab-item key="tab2">
        <template>
          <div>
            <v-form @submit.prevent="submitPickers">
              <div>
                <v-date-picker v-model="formData2.date1" label="Fecha 1" @input="onDate1Change" required></v-date-picker>
                <v-date-picker v-model="formData2.date2" label="Fecha 2" @input="onDate2Change" required></v-date-picker>
              </div>
              <v-row justify="space-around" align="center">
                <v-col style="width: 350px; flex: 0 1 auto;">
                  <h2>Start:</h2>
                  <v-time-picker v-model="formData2.start" required></v-time-picker>
                </v-col>
                <v-col style="width: 350px; flex: 0 1 auto;">
                  <h2>End:</h2>
                  <v-time-picker v-model="formData2.end" required></v-time-picker>
                </v-col>
              </v-row>
            </v-form>
          </div>
          <div class="submit-btn">
            <v-btn @click="submitForm" type="submit" color="white">Publicar</v-btn>
          </div>
        </template>
      </v-tab-item>

      <v-tab-item key="tab3">
        <template>             
          <v-simple-table dark>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Titulo</th>
                  <th class="text-left">Nombre Archivo</th>
                  <th class="text-left">Acción</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="file in files" :key="file.d_id">
                  <td>{{ file.objeto }}</td>
                  <td>{{ file.d_nombre_archivo }}</td>
                  <td>
                    <a :href="getFileURL(file.d_id)" @click="downloadFile(file.d_id)">Descargar</a>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <form @submit.prevent="uploadFiles">
            <div>
              <v-autocomplete v-model="formData3.selectedItem" :items="formData3.options" item-text="objeto" item-value="id" label="evento" solo-inverted hide-details return-object :filter="objectFilter"></v-autocomplete>
            </div>
            <input type="file" ref="fileInput" accept=".pdf,.xls,.xlsx,.doc,.docx" multiple required />
            <v-btn type="submit">Subir archivos</v-btn>
          </form>
        </template>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>



<script>
import axios from 'axios';
import Swal from 'sweetalert';

export default {
  name: 'Create_offer',
  created(){
    axios.get('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/getProcess.php')
    .then(response => {
      this.formData3.options = response.data.map(item => ({
        id: item.id,
        objeto: item.objeto
      }));
    })
    .catch(error => {
      console.error(error);
    });
    axios.get('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/getFiles.php')
    .then(response => {
      this.files = response.data;
    }),
    axios.get('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/getProducts.php')
    .then(response => {
      this.formData1.options = response.data;
    })
    .catch(error => {
      console.error(error);
    });
  },
  data() {
    return {
      resultados: {},
      archivos: [],
      files: [],
      formData:{
        files: [],
        objeto: ''
      },
      formData1:{
        objeto: '',
        descripcion: '',
        presupuesto: '',
        select: '',
        item: [
          'COP',
          'USD',
          'EUR',
        ],
        selectedItem: null,
        options: [],
      },
      formData2:{
        date1: null,
        date2: null,
        start: null,
        end: null,
      },    
      formData3:{
        objeto: '',
        id: '',
        selectedItem: null,
        options: [{
          id:'',
          objeto:''
        }],
      },
      activeTab: 0,
    };
  },
  methods: {
    preventNonNumeric(event) {
    // Obtenemos el código de la tecla presionada
      const keyCode = event.keyCode || event.which;
    // Verificamos si la tecla presionada es un número
      if (keyCode < 48 || keyCode > 57) {
        event.preventDefault();
      }
    },
    validateInput() {
    // Utiliza la función isNaN para verificar si el valor no es un número válido
      if (isNaN(this.formData1.presupuesto)) {
      // Si no es un número válido, asigna un valor vacío al input
        this.formData1.presupuesto = '';
        this.inputValue = this.inputValue.replace(/[^0-9]/g, '');
      }
    },
    downloadFile(d_id) {
      window.open(this.getFileURL(d_id), '_blank');
    },
    uploadFiles() {
      const files = this.$refs.fileInput.files;
      const formData = new FormData();
      for (let i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]); 
      }
      formData.append('id', this.formData3.selectedItem.id);
      axios.post('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/uploadFiles.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        console.log(response);
      })
      .catch(error => {
        error;
        console.log('no enviadisimo');
      });  
    },
    getFileURL(d_id) {
      return 'http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/getFiles.php?d_id=' + d_id;
    },
    customFilter(item, queryText) {
      const searchText = queryText.toLowerCase();
      return item.b_nombre_producto.toLowerCase().includes(searchText);
    },
    objectFilter(item, queryText){
      const searchText = queryText.toLowerCase();
      return item.objeto.toLowerCase().includes(searchText);
    },
    goToTab(index) {
      this.activeTab = index;
    },
    submitForm() {
      let proceso =Object.assign(this.formData1, this.formData2);
    // Aquí puedes agregar la lógica para enviar el formulario
    axios.post('http://localhost/vue/prueba_php_vue/prueba_backend_vue/backEnd/postProcess.php', proceso )
    .then(response => {
    // Maneja la respuesta del backend si es necesario
      if(response.data !== 1){
        Swal({
  title: '¡Hay campos vacios!',
  text: 'Por favor revise que todos los campos esten llenos',
  icon: 'error',
});

      }else{
        Swal({
  title: '¡Se ha creado el evento!',
  text: 'Ya puede hacer segumiento desde consultas',
  icon: 'success',
});
      }
    })
    .catch(error => {
    // Maneja el error si la solicitud falla
      console.error("errrrrrrrrorr" + error);
    });
    this.formData1.objeto = '';
    this.formData1.descripcion = '';
    this.formData1.select = '';
    this.formData1.presupuesto = '';
    this.formData1.searchTerm = '';
    this.formData1.selectedItem = null;
    },
    onDate1Change(newDate) {
      this.date1 = newDate;
    },
    onDate2Change(newDate) {
      this.date2 = newDate;
    },
  }
};
</script>

<style>
  .form-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 4px;
  }

  .form-title {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
  }

  .form-field {
    margin-bottom: 20px;
  }

  .filter{
    margin-bottom: 25px;
  }

  .submit-btn {
    text-align: center;
  }
</style>