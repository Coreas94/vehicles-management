<template>
   <div class="container mt-5">
      <h1 class="mb-4">Vehiculos</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <div v-if="vehicles.length === 0" class="alert alert-info">No hay datos para mostrar.</div>
      <div class="d-flex justify-content-end mb-4">
         <router-link :to="{ name: 'CreateVehicle' }" class="btn btn-success"><i class="bi bi-plus-lg"></i> Crear nuevo vehiculo</router-link>
      </div>

      <div class="table-responsive">
         <table class="table table-hover table-bordered">
            <thead class="table-dark">
               <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Modelo</th>
                  <th scope="col">Patente</th>
                  <th scope="col">Año</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Propietario</th>
                  <th scope="col" style="width: 20%;">Acciones</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="vehicle in vehicles" :key="vehicle.id">
                  <td>{{ vehicle.id }}</td>
                  <td>{{ vehicle.brand }}</td>
                  <td>{{ vehicle.model }}</td>
                  <td>{{ vehicle.license_plate }}</td>
                  <td>{{ vehicle.year }}</td>
                  <td>${{ vehicle.price }}</td>
                  <td>{{ vehicle.user.name }} {{ vehicle.user.surname }}</td>
                  <td>
                     <router-link :to="{ name: 'EditVehicle', params: { id: vehicle.id } }"
                        class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square me-1"></i>
                        Edit</router-link>
                     <button class="btn btn-sm btn-outline-danger" @click="openDeleteConfirmation(vehicle.id)"> <i
                           class="bi bi-trash me-1"></i> Delete</button>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>

      <!--Modal para borrar un registro-->
      <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
         aria-hidden="true" ref="deleteModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                  <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  ¿Estás seguro de eliminar este vehiculo?
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                  <button type="button" class="btn btn-danger" @click="confirmDelete">Delete</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
   setup() {
      const vehicles = ref([]);
      const vehicleIdToDelete = ref(null);
      const deleteModal = ref(null);
      const successMessage = ref('');
      const router = useRouter();

      const fetchVehicles = async () => {
         try {
            const uri = 'http://localhost:8000/api/vehicles';
            const response = await axios.get(uri);
            vehicles.value = response.data;
         } catch (error) {
            console.error('Error fetching vehicles:', error);
         }
      };

      const openDeleteConfirmation = (id) => {
         vehicleIdToDelete.value = id;
         const modalInstance = new bootstrap.Modal(deleteModal.value);
         modalInstance.show();
      };

      const closeModal = () => {
         const modalInstance = bootstrap.Modal.getInstance(deleteModal.value);
         if (modalInstance) {
            modalInstance.hide();
         }
      };

      const confirmDelete = async () => {
         if (vehicleIdToDelete.value !== null) {
            await deleteVehicle(vehicleIdToDelete.value);
            closeModal();
         }
      };

      const deleteVehicle = async (id) => {
         try {
            const uri = `http://localhost:8000/api/vehicles/${id}`;
            await axios.delete(uri);
            vehicles.value = vehicles.value.filter((vehicle) => vehicle.id !== id);
            successMessage.value = 'Vehiculo eliminado correctamente!';
            setTimeout(() => {
               successMessage.value = '';
               router.push({ name: 'Vehicles' });
            }, 2000);
         } catch (error) {
            console.error('Error deleting vehicle:', error);
         }
      };

      const formatDate = (date) => {
         return new Date(date).toLocaleString();
      };

      onMounted(fetchVehicles);

      return {
         vehicles,
         openDeleteConfirmation,
         confirmDelete,
         deleteVehicle,
         deleteModal,
         closeModal,
         successMessage,
         formatDate
      };
   }
}
</script>
