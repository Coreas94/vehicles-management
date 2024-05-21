<template>
   <div class="container mt-5">
      <h1 class="mb-4">Historial de vehiculos</h1>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <div v-if="histories.length === 0" class="alert alert-info">No hay registros historicos de vehiculos.</div>
      <table class="table">
         <thead>
            <tr>
               <th>Vehiculo</th>
               <th>Propietario</th>
               <th>Fecha de creación</th>
               <th>Fecha de eliminación</th>
            </tr>
         </thead>
         <tbody>
            <tr v-for="history in histories" :key="history.id">
               <td>{{ history.vehicle.brand }} {{ history.vehicle.model }}</td>
               <td>{{ history.user.name }} {{ history.user.surname }}</td>
               <td>{{ formatDate(history.created_at) }}</td>
               <td v-if="history.vehicle.deleted_at">{{ formatDate(history.vehicle.deleted_at) }}</td>
               <td v-else>-</td>
            </tr>
         </tbody>
      </table>
   </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
   setup() {
      const histories = ref([]);
      const errorMessage = ref('');

      const fetchHistory = async () => {
         try {
            const uri = 'http://localhost:8000/api/vehicle-history';
            const response = await axios.get(uri);
            histories.value = response.data;
         } catch (error) {
            errorMessage.value = 'Error fetching vehicle ownership history: ' + error.message;
            console.error('Error fetching vehicle ownership history:', error);
         }
      };

      const formatDate = (date) => {
         return new Date(date).toLocaleString();
      };

      onMounted(fetchHistory);

      return {
         histories,
         errorMessage,
         formatDate
      };
   }
}
</script>
