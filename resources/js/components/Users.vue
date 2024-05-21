<template>
   <div class="container mt-5">
      <h1 class="mb-4">Usuarios</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <div v-if="users.length === 0" class="alert alert-info">No hay datos para mostrar.</div>
      <div class="d-flex justify-content-end mb-4">
         <router-link :to="{ name: 'CreateUser' }" class="btn btn-success"><i class="bi bi-plus-lg"></i> Crear nuevo usuario</router-link>
      </div>

      <div class="table-responsive">
         <table class="table table-hover table-bordered">
            <thead class="table-dark">
               <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Correo</th>
                  <th scope="col" style="width: 20%;">Acciones</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.surname }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                     <router-link :to="{ name: 'EditUser', params: { id: user.id } }"
                        class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square me-1"></i>
                        Edit</router-link>
                     <button class="btn btn-sm btn-outline-danger" @click="openDeleteConfirmation(user.id)"> <i
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
                  ¿Estás seguro de eliminar este usuario?
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
      const users = ref([]);
      const userIdToDelete = ref(null);
      const deleteModal = ref(null);
      const successMessage = ref('');
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

      const openDeleteConfirmation = (id) => {
         userIdToDelete.value = id;
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
         if (userIdToDelete.value !== null) {
            await deleteUser(userIdToDelete.value);
            closeModal();
         }
      };

      const deleteUser = async (id) => {
         try {
            const uri = `http://localhost:8000/api/users/${id}`;
            await axios.delete(uri);
            users.value = users.value.filter((user) => user.id !== id);
            successMessage.value = 'Usuario eliminado correctamente!';
            setTimeout(() => {
               successMessage.value = '';
               router.push({ name: 'Users' });
            }, 2000);
         } catch (error) {
            console.error('Error deleting user:', error);
         }
      };

      const formatDate = (date) => {
         return new Date(date).toLocaleString();
      };

      onMounted(fetchUsers);

      return {
         users,
         openDeleteConfirmation,
         confirmDelete,
         deleteUser,
         deleteModal,
         closeModal,
         successMessage,
         formatDate
      };
   }
}
</script>
