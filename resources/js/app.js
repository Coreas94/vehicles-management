import './bootstrap';

import App from './App.vue';
import Vehicles from '@/components/Vehicles.vue';
import CreateVehicle from '@/components/CreateVehicle.vue';
import EditVehicle from '@/components/EditVehicle.vue';
import Users from '@/components/Users.vue';
import CreateUser from '@/components/CreateUser.vue';
import EditUser from '@/components/EditUser.vue';
import ImportExcel from '@/components/ImportExcel.vue';
import VehicleHistories from '@/components/VehicleHistories.vue';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';


const routes = [
   { path: '/', name: 'Vehicles', component: Vehicles },
   { path: '/vehicles/create', name: 'CreateVehicle', component: CreateVehicle },
   { path: '/vehicles/edit/:id', name: 'EditVehicle', component: EditVehicle },
   { path: '/users', name: 'Users', component: Users },
   { path: '/users/create', name: 'CreateUser', component: CreateUser },
   { path: '/users/edit/:id', name: 'EditUser', component: EditUser },
   { path: '/import-excel', name: 'ImportExcel', component: ImportExcel },
   { path: '/vehicle-histories', name: 'VehicleHistories', component: VehicleHistories },

];

const router = createRouter({
   history: createWebHistory(),
   routes
});

createApp(App)
   .use(router)
   .mount('#app');