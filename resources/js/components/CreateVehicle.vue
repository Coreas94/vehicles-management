<template>
   <div class="container mt-5">
      <h1 class="mb-4">Create New Vehicle</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <form @submit.prevent="createVehicle">
         <div class="mb-3">
            <label for="brand" class="form-label">Marca</label>
            <input type="text" v-model="vehicle.brand" class="form-control" id="brand" required>
         </div>
         <div class="mb-3">
            <label for="model" class="form-label">Modelo</label>
            <input type="text" v-model="vehicle.model" class="form-control" id="model" required>
         </div>
         <div class="mb-3">
            <label for="license_plate" class="form-label">Patente</label>
            <input type="text" v-model="vehicle.license_plate" class="form-control" id="license_plate" required>
         </div>
         <div class="mb-3">
            <label for="year" class="form-label">Año</label>
            <input type="number" v-model="vehicle.year" class="form-control" id="year" required>
         </div>
         <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" v-model="vehicle.price" class="form-control" id="price" required>
         </div>
         <div class="mb-3">
            <label for="user_id" class="form-label">Propietario</label>
            <select v-model="vehicle.user_id" class="form-control" id="user_id" required>
               <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.name }} {{ user.surname }}
               </option>
            </select>
         </div>
         <button type="submit" class="btn btn-primary">Crear</button>
      </form>
   </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
   setup() {
      const vehicle = ref({
         brand: '',
         model: '',
         license_plate: '',
         year: '',
         price: '',
         user_id: ''
      });
      const users = ref([]);
      const successMessage = ref('');
      const errorMessage = ref('');
      const router = useRouter();

      const fetchUsers = async () => {
         try {
            const uri = 'http://localhost:8000/api/users';
            const response = await axios.get(uri);
            users.value = response.data;
         } catch (error) {
            console.error('Error fetching users:', error);
         }
      };

      const createVehicle = async () => {
         try {
            const uri = 'http://localhost:8000/api/vehicles';
            await axios.post(uri, vehicle.value);
            successMessage.value = 'Vehiculo creado exitosamente';
            errorMessage.value = '';
            setTimeout(() => {
               router.push({ name: 'Vehicles' });
            }, 3000);
         } catch (error) {
            if(error.response.data.error){
               errorMessage.value = error.response.data.error;
            }
            console.error('Error creando vehicle:', error);
         }
      };

      onMounted(fetchUsers);

      return {
         vehicle,
         users,
         errorMessage,
         createVehicle,
         successMessage
      };
   }
}
</script>
