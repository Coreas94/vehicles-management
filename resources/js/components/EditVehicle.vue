<template>
   <div class="container mt-5">
      <h1 class="mb-4">Edit Vehicle</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <form @submit.prevent="updateVehicle">
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
            <label for="owner_id" class="form-label">Propietario</label>
            <select v-model="vehicle.owner_id" class="form-control" id="owner_id" required>
               <option v-for="owner in owners" :key="owner.id" :value="owner.id">
                  {{ owner.name }} {{ owner.surname }}
               </option>
            </select>
         </div>
         <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" v-model="vehicle.price" class="form-control" id="price" required>
         </div>
         <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
   </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

export default {
   setup() {
      const vehicle = ref({
         brand: '',
         model: '',
         license_plate: '',
         year: '',
         owner_id: '',
         price: ''
      });
      const owners = ref([]);
      const errorMessage = ref('');
      const successMessage = ref('');
      const router = useRouter();
      const route = useRoute();

      const fetchVehicle = async () => {
         try {
            const uri = `http://localhost:8000/api/vehicles/${route.params.id}`;
            const response = await axios.get(uri);
            const vehicleData = response.data;

            vehicle.value = response.data;
            if (vehicleData.user) {
            vehicle.value.owner_id = vehicleData.user.id;
        }
         } catch (error) {
            console.error('Error fetching vehicle:', error);
         }
      };

      const fetchOwners = async () => {
         try {
            const uri = 'http://localhost:8000/api/users';
            const response = await axios.get(uri);
            owners.value = response.data;
         } catch (error) {
            console.error('Error fetching owners:', error);
         }
      };

      const updateVehicle = async () => {
         try {
            const uri = `http://localhost:8000/api/vehicles/${route.params.id}`;
            await axios.put(uri, vehicle.value);
            successMessage.value = 'Vehiculo actualizado correctamente';
            errorMessage.value = '';
            setTimeout(() => {
               router.push({ name: 'Vehicles' });
            }, 3000);
         } catch (error) {
            if(error.response.data.error){
               errorMessage.value = error.response.data.error;
            }
            console.error('Error actualizando vehicle:', error);
         }
      };

      onMounted(() => {
         fetchVehicle();
         fetchOwners();
      });

      return {
         vehicle,
         owners,
         errorMessage,
         successMessage,
         updateVehicle
      };
   }
}
</script>
