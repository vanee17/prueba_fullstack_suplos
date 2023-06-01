import Vue from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';

//importamos vue router
import VueRouter from 'vue-router';

//import de componentes
import Principal_card from './components/Principal_card';
import Card_options from './components/Card_options';
import Create_offer from './components/Create_offer';
import Consult_process from './components/Consult_process';
//se crea el componente princiupal

Vue.component('Principal_card', Principal_card);
Vue.component('Card_options', Card_options);
Vue.component('Create_offer', Create_offer);
Vue.component('Consult_process', Consult_process);

//uso de route
Vue.use(VueRouter);

//definimos rutas

const routes = [
  {path: '/', component: Principal_card },
  {path: '/Principal_card', component: Principal_card },
  {path: '/Card_options', component: Card_options, name: 'Card_options'},
  {path: '/Principal_card', component: Principal_card, name: 'Principal_card'},
  {path: '/Create_offer', component: Create_offer, name: 'Create_offer'},
  {path: '/Consult_process', component: Consult_process, name: 'Consult_process'},
];

const router = new VueRouter({
  routes,
  mode: 'history'
});

Vue.config.productionTip = false

new Vue({
  vuetify,
  router,
  render: h => h(App)
}).$mount('#app');
